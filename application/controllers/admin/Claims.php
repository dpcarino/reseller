<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Claims extends CI_Controller {

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
       $this->load->model('Encashment_model');
       $this->load->model('System_model');
	   $this->load->model('Rewards_model');
    }

    public function index()
    {
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $encashment_settings = $this->System_model->get_settings('encashment');

            $claims = $this->Rewards_model->get_all_claims_request();
            $claim_star_sum = $this->Rewards_model->claim_stars_sum(0);

            $data['claims_request_counts'] = count($claims);

            $data['claim_star_sum'] = $claim_star_sum;
            $data['encashment_settings'] = $encashment_settings;

            $this->load->view('admin/claims-requests-tpl', $data);
        }
    }

    public function claims()
    {
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $this->load->view('admin/claims-history-tpl', $data);
        }
    }

    public function details($trackingcode)
    {
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $data['trackingcode'] = $trackingcode;

            $claim_info = $this->Rewards_model->get_claims_by_trackingcode($trackingcode);

            $requests = $this->Rewards_model->get_all_claim_request_by_trackingcode($trackingcode);

            $admin_info = $this->User_model->get_admin_by_id($claim_info->processedby);

            $data['processedby'] = $admin_info->username;
            $data['claim_info'] = $claim_info;
            $data['claim_request_counts'] = count($requests);

            $this->session->set_userdata('trackingcode_details', $trackingcode);

            $this->load->view('admin/claim-details-tpl', $data);
        }
    }

    public function process(){
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $encashment_settings = $this->System_model->get_settings('encashment');
            $claims = $this->Rewards_model->get_all_claims_request();

            $data['claims_request_counts'] = count($claims);

            $data['encashment_settings'] = $encashment_settings;

            $this->load->view('admin/claims-process-requests-tpl', $data);
        }
    }

	public function ajax($section)
	{
		switch ($section) {
            case 'get_claims_request':

                $records = $_REQUEST;

                $order_by = 'reward_claims_id ASC';

                $requests = $this->Rewards_model->get_all_claims_request($order_by);

                $iTotalRecords = count($requests);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $request = $requests;

                    if($request[$i]->claim_status == 0){                        
                        $encashment_status = 'PENDING';
                    }else{
                        $encashment_status = 'PROCESSED';
                    }

                    $encashment_settings = $this->System_model->get_settings('encashment');

                    if($encashment_settings['active'] == 0){
                        $action = '<a href="javascript:;" id="cancel-request-button" onclick="cancelRequest();" data-claim-id="'.$request[$i]->reward_claims_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-remove"></i> Cancel Request</a>';
                    }else{
                        $action = '';
                    }

                    $reward_info = $this->Rewards_model->get_reward($request[$i]->reward_id);


                    $records["data"][] = array(
                        $request[$i]->daterequested,
                        $reward_info->reward,
                        $request[$i]->stars_used,
                        $encashment_status,
                        $action
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

            case 'cancel-claim-request':
                $reward_claims_id = $this->input->post('reward_claims_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #get encashment request info
                $request_info = $this->Rewards_model->get_claim_request($reward_claims_id);

                if(!empty($request_info)){
                    
                    #update wallet 
                    $member_star_wallet_info = $this->Members_model->get_member_star_wallet($request_info->member_id);

                    $star_wallet_amount = $member_star_wallet_info->stars + $request_info->stars_used;

                    $wallet_data['member_id'] = $request_info->member_id;
                    $wallet_data['stars'] = $star_wallet_amount;

                    $this->Members_model->update_member_star_wallet($wallet_data);                    
                    
                    #delete in encashments
                    $this->Rewards_model->remove_claim_request($reward_claims_id);

                }

                $data['status'] = 'success';
                $data['msg'] = 'Rewards claim request cancelled successfully';

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Rewards claim request cancelled successfully';

                $this->session->set_flashdata('message', $printed_message); 

                #log action
                $member_info = $this->Members_model->get_member($request_info->member_id);

                logger('cancel_claim_request', $admin_id, 'admin', 'User %username% cancelled claim request of '.$member_info->username);                 

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'create-claims':
                $admin_id = $this->ion_auth_admin->get_user_id();

                $claims = $this->Rewards_model->get_all_claims_request();

                if(count($claims) <= 0){

                    $data['status'] = 'error';

                    $printed_message['type'] = 'error';
                    $printed_message['message'] = 'There is no reward claims request to be processed';

                    $this->session->set_flashdata('message', $printed_message); 

                }else{

                    $sess_trackingcode = $this->session->userdata('trackingcode');

                    if(empty($sess_trackingcode)){

                        $trackingcode = 'GE-REWARDS'.date('YmdHis');
                        $claim_star_sum = $this->Rewards_model->claim_stars_sum(0);

                        $claims_data['trackingcode'] = $trackingcode;
                        $claims_data['total_stars'] = $claim_star_sum->stars_used;
                        $claims_data['total_rewards'] = count($claims);
                        $claims_data['processedby'] = $admin_id;
                        $claims_data['dateprocessed'] = date('Y-m-d H:i:s');

                        $this->Rewards_model->insert_claims($claims_data);

                        $this->session->set_flashdata('trackingcode', $trackingcode);

                        logger('claims_created', $admin_id, 'admin', 'User %username% created claims tracking code '.$trackingcode);                 
                        $data['status'] = 'success';
                        $data['trackingcode'] = $trackingcode;

                    }else{
                        $data['status'] = 'success';
                        $data['trackingcode'] = $sess_trackingcode;                    
                    }
                }
                $this->output->set_content_type('application/json')->set_output(json_encode($data));                
            break;

            case 'process-claims':
                $sess_trackingcode = $this->session->userdata('trackingcode');

                $claims = $this->Rewards_model->get_all_claims_request();

                foreach ($claims as $claim) {
                    $encashment_data['reward_claims_id'] = $claim->reward_claims_id;
                    $encashment_data['trackingcode'] = $sess_trackingcode;
                    $encashment_data['dateprocessed'] = date('Y-m-d H:i:s');
                    $encashment_data['claim_status'] = 1;
                    
                    $this->Rewards_model->update_reward_claims($encashment_data);
                }

                $data['status'] = 'success';
                $data['claim_count'] = count($claims);

                $admin_id = $this->ion_auth_admin->get_user_id();
                                   
                logger('process_claims', $admin_id, 'admin', '%username% process reward claims tracking code'.$sess_trackingcode);

                $this->session->unset_userdata('trackingcode');

                $this->output->set_content_type('application/json')->set_output(json_encode($data)); 
            break;

            case 'get_claims_history':
                $records = $_REQUEST;

                if (isset($records['filter'])) {
                    $trackingcode = $records['filter']['both']['trackingcode'];
                } else {
                    $trackingcode = '';
                }

                $order_by = 'claim_id ASC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'trackingcode' . ' ' . $records['order'][0]['dir'];
                    }
                }                

                $claims = $this->Rewards_model->get_claims_history($trackingcode, $order_by);

                $iTotalRecords = count($claims);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $claim = $claims;

                    $admin_id = $claim[$i]->processedby;

                    $admin_info = $this->User_model->get_admin_by_id($admin_id);

                    $records["data"][] = array(
                        $claim[$i]->trackingcode,
                        $claim[$i]->total_stars,
                        $claim[$i]->total_rewards,
                        $admin_info->username,
                        $claim[$i]->dateprocessed,
                        '<a href="'.site_url('admin/claims/details').'/'.$claim[$i]->trackingcode.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-database"></i> View Details</a>
                        <a href="'.site_url('admin/claims/export-claims').'/'.$claim[$i]->trackingcode.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-file-excel-o"></i> Export to Excel</a>',
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

            case 'get_claims_processed_request':

                $records = $_REQUEST;

                $trackingcode = $this->session->userdata('trackingcode_details');

                if (isset($records['filter'])) {
                    $membername = $records['filter']['both']['membername'];
                } else {
                    $membername = '';
                }

                $order_by = 'reward_claims.reward_claims_id ASC';

                if(isset($records['order'])){
                    if($records['order'][0]['column'] == 1){
                        $order_by = 'reward_claims_id'. ' ' . $records['order'][0]['dir'];
                    }
                } 

                $requests = $this->Rewards_model->get_all_claim_request_by_trackingcode($trackingcode, $membername, $order_by);

                $iTotalRecords = count($requests);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $request = $requests;

                    $member_id = $request[$i]->member_id;

                    $member_details_info = $this->Members_model->get_member_details($member_id);

                    $reward_info = $this->Rewards_model->get_reward($request[$i]->reward_id);

                    $records["data"][] = array(
                        $request[$i]->reward_claims_id,
                        $member_details_info->first_name.' '.$member_details_info->middle_name.' '.$member_details_info->last_name,
                        $request[$i]->daterequested,
                        $reward_info->reward,
                        $request[$i]->stars_used,
                        '',
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
		}
	}

    public function export_claims($trackingcode){

        $filename = 'GE-REWARDS-'.$trackingcode.'-'.date('Ymd');

        $this->load->library('excel');

        $objPHPExcel = $this->excel;

        $inputFileType = 'Excel5';
        $inputFileName = 'templates/rewards.xls';
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $objPHPExcel->getProperties()->setCreator("Essensa Naturale - Rewards");

        $claim_info = $this->Rewards_model->get_claims_by_trackingcode($trackingcode);

        $requests = $this->Rewards_model->get_all_claim_request_by_trackingcode($trackingcode);

        $admin_info = $this->User_model->get_admin_by_id($claim_info->processedby);

        $objPHPExcel->getActiveSheet()->setCellValue("B2", date('l, F j Y g:i A', strtotime($claim_info->dateprocessed)));
        $objPHPExcel->getActiveSheet()->setCellValue("B3", $trackingcode);
        $objPHPExcel->getActiveSheet()->setCellValue("B4", $admin_info->username);
        $objPHPExcel->getActiveSheet()->setCellValue("B5", count($requests));

        $i = 8;

        foreach($requests as $request){
            
            $member_info = $this->Members_model->get_member($request->member_id);
            $member_details_info = $this->Members_model->get_member_details($request->member_id);

            $objPHPExcel->getActiveSheet()->setCellValue("A{$i}", $request->member_id);
            $objPHPExcel->getActiveSheet()->setCellValue("B{$i}", $member_info->username);
            $objPHPExcel->getActiveSheet()->setCellValue("C{$i}", $member_details_info->first_name.' '.$member_details_info->middle_name.' '.$member_details_info->last_name);
            $objPHPExcel->getActiveSheet()->setCellValue("D{$i}", $request->daterequested);

            $reward_info = $this->Rewards_model->get_reward($request->reward_id);

            $objPHPExcel->getActiveSheet()->setCellValue("E{$i}", $reward_info->reward);
            $objPHPExcel->getActiveSheet()->setCellValue("F{$i}", $request->stars_used);

            $i++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }    
}