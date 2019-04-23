<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Codes extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

	   $this->load->database();

	   $this->load->library(array('ion_auth_admin','form_validation', 'uuid'));

       $this->load->helper(array('url','language'));

	   $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth_admin'), $this->config->item('error_end_delimiter', 'ion_auth_admin'));

	   $this->lang->load('auth');        

	   $this->load->model('Codes_model');
       $this->load->model('Heads_model');
       $this->load->model('Members_model');
       $this->load->model('User_model');
	   $this->load->model('Packages_model');
    }

    public function listings()
    {
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $this->load->view('admin/codes-all-tpl', $data);
        }
    }

	public function generate()
	{
		$data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $members = $this->Members_model->get_members();
            $packages = $this->Packages_model->get_packages();

            $data['members'] = $members;
            $data['packages'] = $packages;

            $this->form_validation->set_rules('member_account', 'Member Account', 'trim|required|callback_verify_member_account');
            $this->form_validation->set_rules('package', 'Package', 'trim|required');
            $this->form_validation->set_rules('code_quantity', 'Code Quantity', 'trim|required|numeric');
            $this->form_validation->set_rules('purchase_no', 'Purchase Number', 'trim|required|numeric');

            if ($this->form_validation->run() == FALSE){

                $printed_message['type'] = 'error';
                $printed_message['message'] = validation_errors();

                $this->session->set_flashdata('message', $printed_message);                   
            }else{

                $member_id = $this->input->post('member_id');
                $code_quantity = $this->input->post('code_quantity');
                $package = $this->input->post('package');
                $purchase_no = $this->input->post('purchase_no');

                $admin = $this->ion_auth_admin->user()->row();

                $trackingno = 'GENCODE-'.strtoupper($admin->username).'-'.date('YmdHis');

                $package_info = $this->Packages_model->get_package($package);

                if($package_info->is_cd == 1){

                    $code_type = 0;
                
                }else{

                    $code_type = 1;    

                }

                for ($i=0; $i < $code_quantity; $i++) { 

                    #define prefix
                    $code = strtoupper($package_info->package_prefix.'-'.$this->uuid->V4());

                    $save_data['type_id'] = $code_type;
                    $save_data['trackingno'] = $trackingno;
                    $save_data['code'] = $code;
                    $save_data['package_id'] = $package;
                    $save_data['purchase_no'] = $purchase_no;
                    $save_data['generated_by'] = $admin->id;
                    $save_data['purchased_by'] = $member_id;
                    $save_data['datecreated'] = date('Y-m-d H:i:s');

                    $this->Codes_model->insert_code($save_data);                        
                }                

                $code_msg = strtoupper($package_info->package_name);

                $member_info = $this->User_model->get_member_details($member_id);

                $transfered_to = $member_info->first_name.' '.$member_info->last_name;

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Successfully generated '.$code_quantity.' '.$code_msg.' codes to '.$transfered_to;

                $this->session->set_flashdata('message', $printed_message);

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();

                logger('admin_generate_codes', $admin_id, 'admin', 'User %username% successfully generated '.$code_quantity.' codes with TRACKING NUMBER: '.$trackingno);

                redirect('admin/codes/listings'); 
            }

			$this->load->view('admin/generate-codes-tpl', $data);
		}
	}

	public function ajax($section)
	{
		switch ($section) {
            case 'get_all_codes':

                $records = $_REQUEST;

                if (isset($records['filter'])) {
                    $purchase_no = $records['filter']['both']['purchase_no'];
                    $code = $records['filter']['both']['code'];
                    $type_id = $records['filter']['both']['type_id'];
                    $generated_by = $records['filter']['both']['generated_by'];
                    $purchased_by = $records['filter']['both']['purchased_by'];
                    $used_by = $records['filter']['both']['used_by'];
                    $status = $records['filter']['both']['status'];
                } else {

                    $purchase_no = '';
                    $code = '';
                    $type_id = '';
                    $generated_by = '';
                    $purchased_by = '';
                    $used_by = '';
                    $status = '';
                }


                $order_by = 'code_id DESC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 0) {
                        $order_by = 'purchase_no' . ' ' . $records['order'][0]['dir'];
                    } elseif ($records['order'][0]['column'] == 1) {
                        $order_by = 'code' . ' ' . $records['order'][0]['dir'];
                    } elseif ($records['order'][0]['column'] == 6) {
                        $order_by = 'datecreated' . ' ' . $records['order'][0]['dir'];
                    } elseif ($records['order'][0]['column'] == 7) {
                        $order_by = 'dateused' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $codes = $this->Codes_model->get_all_codes_dtable($purchase_no, $code, $type_id, $generated_by, $purchased_by, $used_by, $status, $order_by);

                $iTotalRecords = count($codes);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $code = $codes;

                    $admin_info = $this->User_model->get_admin_by_id($code[$i]->generated_by);
                    $head_info = $this->User_model->get_member_details($code[$i]->purchased_by);

                    if($code[$i]->used_to == 0){
                        $used_to = 'Not Yet Used';
                    }else{
                        $member_used_to_info = $this->Members_model->get_member_details($code[$i]->used_to);
                        $used_to = $member_used_to_info->first_name.' '.$member_used_to_info->middle_name.' '.$member_used_to_info->last_name;
                    }

                    $generated_by = $admin_info->first_name.' '.$admin_info->last_name;

                    $purchased_by = $head_info->first_name.' '.$head_info->last_name;

                    if($code[$i]->used_by == 0){
                        $used_by = 'NA';
                    }else{
                        $member_info = $this->User_model->get_member_details($code[$i]->used_by);

                        $used_by = $member_info->first_name.' '.$member_info->last_name;
                    }

                    if($code[$i]->status == 0){
                        $code_status = 'Available';
                    }elseif($code[$i]->status == 1){
                        $code_status = 'Used';
                    }

                    if($code[$i]->type_id == 0){
                        $code_type = 'CD';
                    }elseif($code[$i]->type_id == 1){
                        $code_type = 'PAID';
                    }

                    $action = '';

                    if($code[$i]->status == 1){
                        $action .= '';
                    }else{
                        $action .= '<a href="javascript:;" id="cancel-code-button-'.$i.'" onclick="cancelCode('.$i.');" data-code-id="'.$code[$i]->code_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-remove"></i> Cancel Code</a>';
                    }

                    $records["data"][] = array(
                        $code[$i]->purchase_no, $code[$i]->code, $code_type, $generated_by, $purchased_by, $used_by, $used_to, $code[$i]->datecreated, $code[$i]->dateused, $code_status,$action,
                    );
                }

                if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
                    $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                    $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
                }

                $records["draw"] = $sEcho;
                $records["recordsTotal"] = $iTotalRecords;
                $records["recordsFiltered"] = $iTotalRecords;

                echo json_encode($records);

                break;

			case 'generate-code':

                $member_id = $this->input->post('member_id');
                $code_quantity = $this->input->post('code_quantity');
                $code_type = $this->input->post('code_type');
                $purchase_no = $this->input->post('purchase_no');

                $admin = $this->ion_auth_admin->user()->row();

                $trackingno = 'GENCODE-'.strtoupper($admin->username).'-'.date('YmdHis');

                for ($i=0; $i < $code_quantity; $i++) { 

                	#define prefix
                	if($code_type == 0){

                		$code_prefix = 'cd-';

                	}else{

                		$code_prefix = 'pa-';
                	}

                	$code = strtoupper($code_prefix.$this->uuid->V4());

                    $save_data['type_id'] = $code_type;
                    $save_data['trackingno'] = $trackingno;
                    $save_data['code'] = $code;
                    $save_data['purchase_no'] = $purchase_no;
                    $save_data['generated_by'] = $admin->id;
                    $save_data['purchased_by'] = $member_id;
                    $save_data['datecreated'] = date('Y-m-d H:i:s');

                    $this->Codes_model->insert_code($save_data);                    	
                }                

                if($code_type == 0){

                    $code_msg = 'CD';

                }else{

                    $code_msg = 'PAID';
                }

                $member_info = $this->User_model->get_member_details($member_id);

                $transfered_to = $member_info->first_name.' '.$member_info->last_name;

				$data['status'] = 'success';
				$data['msg'] = 'Successfully generated '.$code_quantity.' '.$code_msg.' codes to '.$transfered_to;				

                $admin_id = $this->ion_auth_admin->get_user_id();
                logger('admin_generate_codes', $admin_id, 'admin', 'User %username% successfully generated '.$code_quantity.' codes with TRACKING NUMBER: '.$trackingno);                

				$this->output->set_content_type('application/json')->set_output(json_encode($data));
			break;

            case 'remove-code':
                $code_id = $this->input->post('code_id');

                $code_info = $this->Codes_model->get_code($code_id);

                $cancel_code_data['code_id'] = $code_info->code_id;
                $cancel_code_data['type_id'] = $code_info->type_id;
                $cancel_code_data['trackingno'] = $code_info->trackingno;
                $cancel_code_data['package_id'] = $code_info->package_id;
                $cancel_code_data['code'] = $code_info->code;
                $cancel_code_data['generated_by'] = $code_info->generated_by;
                $cancel_code_data['purchased_by'] = $code_info->purchased_by;
                $cancel_code_data['used_by'] = $code_info->used_by;
                $cancel_code_data['used_to'] = $code_info->used_to;
                $cancel_code_data['datecreated'] = $code_info->datecreated;
                $cancel_code_data['dateused'] = $code_info->dateused;
                $cancel_code_data['purchase_no'] = $code_info->purchase_no;
                $cancel_code_data['status'] = $code_info->status;

                $this->Codes_model->insert_cancel_code($cancel_code_data);
                 
                $this->Codes_model->remove_code($code_id);

                $data['status'] = 'success';
                $data['msg'] = 'Successfully removed '.$code_info->code;              

                $admin_id = $this->ion_auth_admin->get_user_id();
                logger('remove_code', $admin_id, 'admin', 'Successfully removed '.$code_info->code);                

                $this->output->set_content_type('application/json')->set_output(json_encode($data));

            break;
		}
	}

    #callback

    public function verify_member_account(){

        $member_account = xss_clean($this->input->post('member_account'));
        $member_id = xss_clean($this->input->post('member_id'));

        if($member_id == 0){
            
            $this->form_validation->set_message('verify_member_account', 'Invalid member account please select correctly in the suggestion box');
            return false;

        }else{
            return true;
        }

    }
}