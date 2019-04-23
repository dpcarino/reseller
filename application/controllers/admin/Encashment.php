<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Encashment extends CI_Controller {

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
    }

    public function index(){
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $encashment_settings = $this->System_model->get_settings('encashment');
            $encashment_amount = $this->Encashment_model->encashment_amount_sum(0);
            $encashment_tax = $this->Encashment_model->encashment_tax_sum(0);
            $encashment_payout = $this->Encashment_model->encashment_payout_sum(0);
            $encashments = $this->Encashment_model->get_all_encashment_request();

            $data['encashment_request_counts'] = count($encashments);

            $data['encashment_settings'] = $encashment_settings;
            $data['encashment_amount'] = $encashment_amount;
            $data['encashment_tax'] = $encashment_tax;
            $data['encashment_payout'] = $encashment_payout;

            $this->load->view('admin/encashment-requests-tpl', $data);
        }
    }

    public function payouts(){
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $this->load->view('admin/encashment-payouts-tpl', $data);
        }
    }

    public function details($trackingcode){
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $data['trackingcode'] = $trackingcode;

            $payout_info = $this->Encashment_model->get_payout_by_trackingcode($trackingcode);

            $requests = $this->Encashment_model->get_all_encashment_request_by_trackingcode($trackingcode);

            $admin_info = $this->User_model->get_admin_by_id($payout_info->processedby);

            $data['processedby'] = $admin_info->username;
            $data['payout_info'] = $payout_info;
            $data['encashment_request_counts'] = count($requests);

            $this->session->set_userdata('trackingcode_details', $trackingcode);

            $this->load->view('admin/encashment-details-tpl', $data);
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
            $encashments = $this->Encashment_model->get_all_encashment_request();

            $data['encashment_request_counts'] = count($encashments);

            $data['encashment_settings'] = $encashment_settings;

            $this->load->view('admin/encashment-process-requests-tpl', $data);
        }
    }

	public function ajax($section){
		switch ($section) {
            case 'get_encashment_request':

                $records = $_REQUEST;

                $order_by = 'encashment_id ASC';

                $requests = $this->Encashment_model->get_all_encashment_request($order_by);

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

                    $records["data"][] = array(
                        $member_id,
                        $member_details_info->first_name.' '.$member_details_info->middle_name.' '.$member_details_info->last_name,
                        $request[$i]->daterequested,
                        $request[$i]->request_type,
                        $request[$i]->amount,
                        $request[$i]->tax,
                        $request[$i]->payout,
                        '<a href="javascript:;" id="cancel-request-button" onclick="cancelRequest();" data-ecash-id="'.$request[$i]->encashment_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-remove"></i> Cancel Request</a>',
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

            case 'cancel-encashment-request':
                $encashment_id = $this->input->post('encashment_id');

                $admin_id = $this->ion_auth_admin->get_user_id();

                #get encashment request info
                $request_info = $this->Encashment_model->get_encashment_request($encashment_id);

                if(!empty($request_info)){
                    
                    #update wallet 
                    $member_wallet_info = $this->Members_model->get_member_wallet($request_info->member_id);

                    $wallet_amount = $member_wallet_info->amount + $request_info->amount;

                    $wallet_data['member_id'] = $request_info->member_id;
                    $wallet_data['amount'] = $wallet_amount;

                    $this->Members_model->update_member_wallet($wallet_data);                    
                    
                    #delete in encashments
                    $this->Encashment_model->remove_encashment_request($encashment_id);

                }

                $data['status'] = 'success';
                $data['msg'] = 'Encashment request cancelled successfully';

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Encashment request cancelled successfully';

                $this->session->set_flashdata('message', $printed_message); 

                #log action
                $member_info = $this->Members_model->get_member($request_info->member_id);

                logger('cancel_encashment_request', $admin_id, 'admin', 'User %username% cancelled encashment request of '.$member_info->username);                 

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'create-payout':
                $admin_id = $this->ion_auth_admin->get_user_id();

                $encashments = $this->Encashment_model->get_all_encashment_request();

                if(count($encashments) <= 0){

                    $data['status'] = 'error';

                    $printed_message['type'] = 'error';
                    $printed_message['message'] = 'There is no encashment request to be processed';

                    $this->session->set_flashdata('message', $printed_message); 

                }else{

                    $sess_trackingcode = $this->session->userdata('trackingcode');

                    if(empty($sess_trackingcode)){

                        $trackingcode = 'GE'.date('YmdHis');
                        $encashment_amount = $this->Encashment_model->encashment_amount_sum(0);
                        $encashment_tax = $this->Encashment_model->encashment_tax_sum(0);
                        $encashment_payout = $this->Encashment_model->encashment_payout_sum(0);

                        $payout_data['trackingcode'] = $trackingcode;
                        $payout_data['total_payout'] = $encashment_payout->payout;
                        $payout_data['total_tax'] = $encashment_tax->tax;
                        $payout_data['total_amount'] = $encashment_amount->amount;
                        $payout_data['processedby'] = $admin_id;
                        $payout_data['dateprocessed'] = date('Y-m-d H:i:s');

                        $this->Encashment_model->insert_encashment_payout($payout_data);

                        $this->session->set_flashdata('trackingcode', $trackingcode);

                        logger('encashment_payout_created', $admin_id, 'admin', 'User %username% created payout tracking code '.$trackingcode);                 
                        $data['status'] = 'success';
                        $data['trackingcode'] = $trackingcode;

                    }else{
                        $data['status'] = 'success';
                        $data['trackingcode'] = $sess_trackingcode;                    
                    }
                }
                $this->output->set_content_type('application/json')->set_output(json_encode($data));                
            break;

            case 'process-payout':
                $sess_trackingcode = $this->session->userdata('trackingcode');

                $encashments = $this->Encashment_model->get_all_encashment_request();

                foreach ($encashments as $encashment) {
                    $encashment_data['encashment_id'] = $encashment->encashment_id;
                    $encashment_data['trackingcode'] = $sess_trackingcode;
                    $encashment_data['dateprocessed'] = date('Y-m-d H:i:s');
                    $encashment_data['encashment_status'] = 1;
                    
                    $this->Encashment_model->update_encashment($encashment_data);
                }

                $data['status'] = 'success';
                $data['encashment_count'] = count($encashments);

                $admin_id = $this->ion_auth_admin->get_user_id();
                                   
                logger('process_encashment', $admin_id, 'admin', '%username% process encashment payout tracking code'.$sess_trackingcode);                

                $this->session->unset_userdata('trackingcode');

                $this->output->set_content_type('application/json')->set_output(json_encode($data)); 
            break;

            case 'get_encashment_payouts':
                $records = $_REQUEST;

                if (isset($records['filter'])) {
                    $trackingcode = $records['filter']['both']['trackingcode'];
                } else {
                    $trackingcode = '';
                }

                $order_by = 'payout_id ASC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'trackingcode' . ' ' . $records['order'][0]['dir'];
                    }
                }                

                $payouts = $this->Encashment_model->get_encashment_payouts($trackingcode, $order_by);

                $iTotalRecords = count($payouts);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $payout = $payouts;

                    $admin_id = $payout[$i]->processedby;

                    $admin_info = $this->User_model->get_admin_by_id($admin_id);

                    $records["data"][] = array(
                        $payout[$i]->trackingcode,
                        $payout[$i]->total_payout,
                        $payout[$i]->total_tax,
                        $payout[$i]->total_amount,
                        $admin_info->username,
                        $payout[$i]->dateprocessed,
                        '<a href="'.site_url('admin/encashment/details').'/'.$payout[$i]->trackingcode.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-database"></i> View Details</a>
                        <a href="'.site_url('admin/encashment/export-payout').'/'.$payout[$i]->trackingcode.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-file-excel-o"></i> Export to Excel</a>',
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

            case 'get_encashment_processed_request':

                $records = $_REQUEST;

                $trackingcode = $this->session->userdata('trackingcode_details');

                if (isset($records['filter'])) {
                    $membername = $records['filter']['both']['membername'];
                } else {
                    $membername = '';
                }

                $order_by = 'encashments.encashment_id ASC';

                if(isset($records['order'])){
                    if($records['order'][0]['column'] == 1){
                        $order_by = 'encashment_id'. ' ' . $records['order'][0]['dir'];
                    }
                } 

                $requests = $this->Encashment_model->get_all_encashment_request_by_trackingcode($trackingcode, $membername, $order_by);

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

                    $records["data"][] = array(
                        $request[$i]->encashment_id,
                        $member_details_info->first_name.' '.$member_details_info->middle_name.' '.$member_details_info->last_name,
                        $request[$i]->daterequested,
                        $request[$i]->request_type,
                        $request[$i]->amount,
                        $request[$i]->tax,
                        $request[$i]->payout,
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

    public function export_payout($trackingcode){

        $filename = 'GE-PAYOUT-'.$trackingcode.'-'.date('Ymd');

        $this->load->library('excel');

        $objPHPExcel = $this->excel;

        $inputFileType = 'Excel5';
        $inputFileName = 'templates/payout.xls';
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $objPHPExcel->getProperties()->setCreator("Essensa Naturale - Encashment");

        $payout_info = $this->Encashment_model->get_payout_by_trackingcode($trackingcode);

        $requests = $this->Encashment_model->get_all_encashment_request_by_trackingcode($trackingcode);

        $admin_info = $this->User_model->get_admin_by_id($payout_info->processedby);

        $objPHPExcel->getActiveSheet()->setCellValue("B2", date('l, F j Y g:i A', strtotime($payout_info->dateprocessed)));
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
            $objPHPExcel->getActiveSheet()->setCellValue("E{$i}", $request->request_type);

            if($request->request_type == 'BANK'){
                $objPHPExcel->getActiveSheet()->setCellValue("F{$i}", 'AUB');
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue("F{$i}", 'NA');
            }
            
            if($request->request_type == 'BANK'){
                $objPHPExcel->getActiveSheet()->setCellValue("G{$i}", $member_details_info->bank_acct_number);
                $objPHPExcel->getActiveSheet()->setCellValue("H{$i}", $member_details_info->bank_acct_name);
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue("G{$i}", 'NA');
                $objPHPExcel->getActiveSheet()->setCellValue("H{$i}", 'NA');                
            }

            $objPHPExcel->getActiveSheet()->setCellValue("I{$i}", $request->amount);
            $objPHPExcel->getActiveSheet()->setCellValue("J{$i}", $request->tax);
            $objPHPExcel->getActiveSheet()->setCellValue("K{$i}", $request->payout);

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