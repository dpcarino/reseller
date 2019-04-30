<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reseller extends CI_Controller {

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
      $this->load->model('Reseller_model');
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

            $voucher_requests = $this->Reseller_model->get_all_reseller_voucher_request();

            $data['encashment_settings'] = $encashment_settings;
            $data['voucher_requests_cnt'] = count($voucher_requests);

            $this->load->view('admin/reseller-requests-tpl', $data);
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
            $voucher_requests = $this->Reseller_model->get_all_reseller_voucher_request();

            $data['voucher_requests_cnt'] = count($voucher_requests);

            $data['encashment_settings'] = $encashment_settings;

            $this->load->view('admin/reseller-voucher-process-requests-tpl', $data);
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

            $this->load->view('admin/reseller-voucher-payouts-tpl', $data);
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

            $payout_info = $this->Reseller_model->get_payout_by_trackingcode($trackingcode);

            $requests = $this->Reseller_model->get_all_reseller_voucher_request_by_trackingcode($trackingcode);

            $admin_info = $this->User_model->get_admin_by_id($payout_info->processedby);

            $data['processedby'] = $admin_info->username;
            $data['payout_info'] = $payout_info;
            $data['encashment_request_counts'] = count($requests);

            $this->session->set_userdata('trackingcode_details', $trackingcode);

            $this->load->view('admin/reseller-voucher-requests-details-tpl', $data);
        }
    }    

    public function ajax($section){
      switch ($section) {
        case 'get_reseller_voucher_request':

            $records = $_REQUEST;

            $order_by = 'reseller_claims_id ASC';

            $requests = $this->Reseller_model->get_all_reseller_voucher_request($order_by);

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

                $head_info = $this->Heads_model->get_head($request[$i]->head_id);

                $records["data"][] = array(
                    $member_id,
                    $member_details_info->first_name.' '.$member_details_info->middle_name.' '.$member_details_info->last_name,
                    $head_info->headname,
                    $request[$i]->daterequested,
                    '<a href="javascript:;" id="cancel-request-button" onclick="cancelRequest();" data-ecash-id="'.$request[$i]->reseller_claims_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-remove"></i> Cancel Request</a>',
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

        case 'cancel-reseller-voucher-request':
            $reseller_claims_id = $this->input->post('reseller_claims_id');

            $admin_id = $this->ion_auth_admin->get_user_id();

            #get encashment request info
            $request_info = $this->Reseller_model->get_reseller_voucher_request($reseller_claims_id);

            if(!empty($request_info)){
                
                #update reseller
                $reseller_data['head_id'] = $request_info->head_id;
                $reseller_data['gc_available'] = 1;
                
                $this->Reseller_model->update_reseller($reseller_data);                   
                
                #delete in reseller request
                $this->Reseller_model->remove_reseller_voucher_request($reseller_claims_id);

            }

            $data['status'] = 'success';
            $data['msg'] = 'Reseller voucher request cancelled successfully';

            $printed_message['type'] = 'success';
            $printed_message['message'] = 'Reseller voucher request cancelled successfully';

            $this->session->set_flashdata('message', $printed_message); 

            #log action
            $member_info = $this->Members_model->get_member($request_info->member_id);

            logger('cancel_reseller_voucher_request', $admin_id, 'admin', 'User %username% cancelled reseller voucher request of '.$member_info->username);                 

            $this->output->set_content_type('application/json')->set_output(json_encode($data));
        break;

        case 'create-payout':
            $admin_id = $this->ion_auth_admin->get_user_id();

            $voucher_requests = $this->Reseller_model->get_all_reseller_voucher_request();

            if(count($voucher_requests) <= 0){

                $data['status'] = 'error';

                $printed_message['type'] = 'error';
                $printed_message['message'] = 'There is no reseller voucher request to be processed';

                $this->session->set_flashdata('message', $printed_message); 

            }else{

                $sess_trackingcode = $this->session->userdata('trackingcode');

                if(empty($sess_trackingcode)){

                    $trackingcode = 'GERS'.date('YmdHis');

                    $payout_data['trackingcode'] = $trackingcode;
                    $payout_data['total_voucher_amount'] = count($voucher_requests) * 3000;
                    $payout_data['total_requests'] = count($voucher_requests);
                    $payout_data['processedby'] = $admin_id;
                    $payout_data['dateprocessed'] = date('Y-m-d H:i:s');

                    $this->Reseller_model->insert_reseller_voucher_payout($payout_data);

                    $this->session->set_flashdata('trackingcode', $trackingcode);

                    logger('reseller_voucher_payout_created', $admin_id, 'admin', 'User %username% created reseller voucher payout tracking code '.$trackingcode);                 
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

            $voucher_requests = $this->Reseller_model->get_all_reseller_voucher_request();

            foreach ($voucher_requests as $voucher_request) {
                $request_data['reseller_claims_id'] = $voucher_request->reseller_claims_id;
                $request_data['trackingcode'] = $sess_trackingcode;
                $request_data['dateprocessed'] = date('Y-m-d H:i:s');
                $request_data['claim_status'] = 1;
                
                $this->Reseller_model->update_reseller_claims($request_data);
            }

            $data['status'] = 'success';
            $data['voucher_count'] = count($voucher_requests);

            $admin_id = $this->ion_auth_admin->get_user_id();
                               
            logger('process_reseller_voucher_payout', $admin_id, 'admin', '%username% process reseller voucher payout tracking code'.$sess_trackingcode);                

            $this->session->unset_userdata('trackingcode');

            $this->output->set_content_type('application/json')->set_output(json_encode($data)); 
        break;

        case 'get_reseller_voucher_payouts':
            $records = $_REQUEST;

            if (isset($records['filter'])) {
                $trackingcode = $records['filter']['both']['trackingcode'];
            } else {
                $trackingcode = '';
            }

            $order_by = 'payout_id DESC';

            if (isset($records['order'])) {
                if ($records['order'][0]['column'] == 1) {
                    $order_by = 'trackingcode' . ' ' . $records['order'][0]['dir'];
                }
            }                

            $payouts = $this->Reseller_model->get_reseller_voucher_payouts($trackingcode, $order_by);

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
                    $payout[$i]->total_voucher_amount,
                    $payout[$i]->total_requests,
                    $admin_info->username,
                    $payout[$i]->dateprocessed,
                    '<a href="'.site_url('admin/reseller/details').'/'.$payout[$i]->trackingcode.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-database"></i> View Details</a>
                    <a href="'.site_url('admin/reseller/export-payout').'/'.$payout[$i]->trackingcode.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-file-excel-o"></i> Export to Excel</a>',
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

        case 'get_reseller_voucher_processed_request':

            $records = $_REQUEST;

            $trackingcode = $this->session->userdata('trackingcode_details');

            if (isset($records['filter'])) {
                $membername = $records['filter']['both']['membername'];
            } else {
                $membername = '';
            }

            $order_by = 'reseller_claims.reseller_claims_id ASC';

            if(isset($records['order'])){
                if($records['order'][0]['column'] == 1){
                    $order_by = 'reseller_claims_id'. ' ' . $records['order'][0]['dir'];
                }
            } 

            $requests = $this->Reseller_model->get_all_reseller_voucher_request_by_trackingcode($trackingcode, $membername, $order_by);

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

                $head_info = $this->Heads_model->get_head($request[$i]->head_id);

                $records["data"][] = array(
                    $request[$i]->reseller_claims_id,
                    $member_details_info->first_name.' '.$member_details_info->middle_name.' '.$member_details_info->last_name,
                    $head_info->headname,
                    $request[$i]->daterequested,
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

        $filename = 'GE-RESELLER-'.$trackingcode.'-'.date('Ymd');

        $this->load->library('excel');

        $objPHPExcel = $this->excel;

        $inputFileType = 'Excel5';
        $inputFileName = 'templates/reseller.xls';
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $objPHPExcel->getProperties()->setCreator("Essensa Naturale - Reseller Voucher");

        $payout_info = $this->Reseller_model->get_payout_by_trackingcode($trackingcode);

        $requests = $this->Reseller_model->get_all_reseller_voucher_request_by_trackingcode($trackingcode);

        $admin_info = $this->User_model->get_admin_by_id($payout_info->processedby);

        $objPHPExcel->getActiveSheet()->setCellValue("B2", date('l, F j Y g:i A', strtotime($payout_info->dateprocessed)));
        $objPHPExcel->getActiveSheet()->setCellValue("B3", $trackingcode);
        $objPHPExcel->getActiveSheet()->setCellValue("B4", $admin_info->username);
        $objPHPExcel->getActiveSheet()->setCellValue("B5", count($requests));

        $i = 8;

        foreach($requests as $request){
            
            $member_info = $this->Members_model->get_member($request->member_id);
            $member_details_info = $this->Members_model->get_member_details($request->member_id);
            $head_info = $this->Heads_model->get_head($request->head_id);

            $objPHPExcel->getActiveSheet()->setCellValue("A{$i}", $request->member_id);
            $objPHPExcel->getActiveSheet()->setCellValue("B{$i}", $head_info->headname);
            $objPHPExcel->getActiveSheet()->setCellValue("C{$i}", $member_info->username);
            $objPHPExcel->getActiveSheet()->setCellValue("D{$i}", $request->daterequested);
            
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