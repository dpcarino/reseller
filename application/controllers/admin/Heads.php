<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Heads extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

	   $this->load->database();

	   $this->load->library(array('ion_auth_admin','form_validation', 'uuid'));

       $this->load->helper(array('url','language', 'file'));

	   $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth_admin'), $this->config->item('error_end_delimiter', 'ion_auth_admin'));

	   $this->lang->load('auth');        

	   $this->load->model('Codes_model');
       $this->load->model('Heads_model');
       $this->load->model('User_model');
       $this->load->model('Members_model');
       $this->load->model('Settings_model');
	   $this->load->model('Reseller_model');
    }

    public function index()
    {
        $data = array();
    }

    public function search()
    {
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $heads = $this->Heads_model->get_heads();

            $data['heads'] = $heads;

            $this->load->view('admin/heads-search-tpl', $data);
        }
    }

    public function detail($head_id){
        $data = array();
        
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('admin/login', 'refresh');

        }else{

            $head_info = $this->Heads_model->get_head($head_id);
            $reseller_info = $this->Reseller_model->get_reseller($head_id);

            $data['head_info'] = $head_info;
            $data['reseller_info'] = $reseller_info;

            $this->form_validation->set_rules('status', 'Status', 'required');

            if ($this->form_validation->run() == FALSE){

            }else{

                $status     = xss_clean($this->input->post('status'));

                $head_data['head_id'] = $head_id;
                $head_data['status'] = $status;

                $this->Heads_model->update_head($head_data);

                if($status == 0){
                    $status_str = 'ACTIVE';
                }else{
                    $status_str = 'BLOCKED';
                }

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Successfully updated status of '.$head_info->headname.' to '.$status_str;

                $this->session->set_flashdata('message', $printed_message);         

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();
                   
                logger('head_block', $admin_id, 'admin', '%username% successfully status of '.$head_info->headname.' to '.$status_str);

                redirect('admin/heads/detail/'.$head_id);               
            }            
                        
            $this->load->view('admin/head-details-tpl', $data);            
        }
    }

    public function update_balance($head_id){
        $data = array();
        
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('admin/login', 'refresh');

        }else{

            $head_info = $this->Heads_model->get_head($head_id);

            $data['head_info'] = $head_info;

            $this->form_validation->set_rules('paid_ar', 'Paid AR', 'trim|required');

            if ($this->form_validation->run() == FALSE){

            }else{

                $paid_ar     = xss_clean($this->input->post('paid_ar'));

                $head_data['head_id'] = $head_id;
                $head_data['paid_ar'] = $paid_ar;
                $head_data['paid_updated'] = date('Y-m-d H:i:s');

                $this->Heads_model->update_head($head_data);

                #update CD to Paid
                $this->Heads_model->funcPaidCD($head_id);

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Successfully updated status of '.$head_info->headname.' with '.$paid_ar;

                $this->session->set_flashdata('message', $printed_message);         

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();
                   
                logger('update_balance', $admin_id, 'admin', '%username% successfully updated status of '.$head_info->headname.' with '.$paid_ar);

                redirect('admin/heads/update-balance/'.$head_id);               
            }            
                        
            $this->load->view('admin/head-update-balance-tpl', $data);            
        }
    }

    public function update_promo($head_id){
        $data = array();
        
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('admin/login', 'refresh');

        }else{

            $head_info = $this->Heads_model->get_head($head_id);

            $data['head_info'] = $head_info;

            $this->form_validation->set_rules('paid_ar', 'Paid AR', 'trim|required');

            if ($this->form_validation->run() == FALSE){

            }else{

                $paid_ar     = xss_clean($this->input->post('paid_ar'));

                $head_data['head_id'] = $head_id;
                $head_data['paid_ar'] = $paid_ar;
                $head_data['paid_updated'] = date('Y-m-d H:i:s');

                $this->Heads_model->update_head($head_data);

                #update CD to Paid
                $this->Heads_model->funcCDPromo($head_id);

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Successfully updated cd promo status of '.$head_info->headname.' with '.$paid_ar;

                $this->session->set_flashdata('message', $printed_message);         

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();
                   
                logger('update_promo', $admin_id, 'admin', '%username% successfully updated cd promo status of '.$head_info->headname.' with '.$paid_ar);

                redirect('admin/heads/update-promo/'.$head_id);               
            }            
                        
            $this->load->view('admin/head-update-promo-tpl', $data);            
        }
    }

    public function update_paylite($head_id){
        $data = array();
        
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('admin/login', 'refresh');

        }else{

            $head_info = $this->Heads_model->get_head($head_id);

            $payments = $this->Heads_model->get_paylite_history($head_id);

            $data['head_info'] = $head_info;
            $data['payments'] = $payments;

            $this->form_validation->set_rules('paid_ar', 'Paid AR', 'trim|required');
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required|numeric');

            if ($this->form_validation->run() == FALSE){

            }else{

                $paid_ar     = xss_clean($this->input->post('paid_ar'));
                $amount      = xss_clean($this->input->post('amount'));

                #update PayLite
                $this->Heads_model->funcPaylitePayment($head_id, $amount, $paid_ar);

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Successfully updated paylite status of '.$head_info->headname.' with '.$paid_ar;

                $this->session->set_flashdata('message', $printed_message);         

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();
                   
                logger('update_paylite', $admin_id, 'admin', '%username% successfully updated paylite status of '.$head_info->headname.' with '.$paid_ar);

                redirect('admin/heads/update-paylite/'.$head_id);               
            }            
                        
            $this->load->view('admin/head-update-paylite-tpl', $data);            
        }
    }

    public function update_knight($head_id){
        $data = array();
        
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('admin/login', 'refresh');

        }else{

            $head_info = $this->Heads_model->get_head($head_id);

            $data['head_info'] = $head_info;

            $this->form_validation->set_rules('knight_ar', 'Knight AR', 'trim|required');

            if ($this->form_validation->run() == FALSE){

            }else{

                $knight_ar     = xss_clean($this->input->post('knight_ar'));

                $head_data['head_id'] = $head_id;
                $head_data['knight_ar'] = $knight_ar;
                $head_data['account_status'] = 1;
                $head_data['knight_date'] = date('Y-m-d H:i:s');
                $head_data['knight_status'] = 1;

                $this->Heads_model->update_head($head_data);

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Successfully updated knight status of '.$head_info->headname.' with '.$knight_ar;

                $this->session->set_flashdata('message', $printed_message);         

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();
                   
                logger('update_knight', $admin_id, 'admin', '%username% successfully updated knight status of '.$head_info->headname.' with '.$knight_ar);

                redirect('admin/heads/search');               
            }            
                        
            $this->load->view('admin/head-update-knight-tpl', $data);            
        }
    }    

    public function update_reseller($head_id){
        $data = array();
        
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('admin/login', 'refresh');

        }else{

            $head_info = $this->Heads_model->get_head($head_id);

            $data['head_info'] = $head_info;

            $this->form_validation->set_rules('reseller_ar', 'Reseller AR', 'trim|required');

            if ($this->form_validation->run() == FALSE){

            }else{

                $reseller_ar     = xss_clean($this->input->post('reseller_ar'));

                $this->Reseller_model->execfuncPaidReseller($head_id, $reseller_ar);

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Successfully updated reseller status of '.$head_info->headname.' with '.$knight_ar;

                $this->session->set_flashdata('message', $printed_message);         

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();
                   
                logger('update_reseller', $admin_id, 'admin', '%username% successfully reseller status of '.$head_info->headname.' with '.$knight_ar);

                redirect('admin/heads/search');               
            }            
                        
            $this->load->view('admin/head-update-reseller-tpl', $data);            
        }
    } 

	public function ajax($section)
	{
		switch ($section) {
            case 'get_search_result_old':
                $records = $_REQUEST;

                if (isset($records['filter'])) {
                    
                    $headname = $records['filter']['both']['headname'];
                    $member_name = $records['filter']['both']['member_name'];
                    $account_status = $records['filter']['both']['account_status'];
                    $knight_status = $records['filter']['both']['knight_status'];
                    $is_paylite = $records['filter']['both']['is_paylite'];
                    $paid_ar = $records['filter']['both']['paid_ar'];
                    $knight_ar = $records['filter']['both']['knight_ar'];

                } else {

                    $headname = '';
                    $member_name = '';
                    $account_status = '';
                    $knight_status = '';
                    $is_paylite = '';
                    $paid_ar = '';
                    $knight_ar = '';
                }


                $order_by = 'heads.head_id DESC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'headname' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $heads = $this->Heads_model->get_search_result($headname, $member_name, $account_status, $knight_status, $is_paylite, $paid_ar, $knight_ar, $order_by);

                $iTotalRecords = count($heads);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $head = $heads;

                    $member_details_info = $this->Members_model->get_member_details($head[$i]->member_id);

                    if($head[$i]->status == 0){
                        $head_status = 'NO';
                    }else{
                        $head_status = 'YES';
                    }

                    $action = '';

                    if($head[$i]->account_status == 0){
                        $account_status = 'CD';
                    }else{
                        $account_status = 'PAID';                        
                    }

                    if($head[$i]->cd_balance != '0.00'){
                        
                        if($head[$i]->is_paylite == 1){
                            $action .= '<a href="'.site_url('admin/heads/update-paylite').'/'.$head[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-balance-scale"></i> Update PayLite</a>';

                            $is_paylite = 'YES';
                        }else{
                            $action .= '<br><br><a href="'.site_url('admin/heads/update-balance').'/'.$head[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-balance-scale"></i> Update CD Balance</a>';
                            $action .= '<a href="'.site_url('admin/heads/update-promo').'/'.$head[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-balance-scale"></i> Update CD Promo</a>';

                            $is_paylite = 'NO';
                        }

                    }else{                       

                        $is_paylite = 'NO';

                        $action = '';
                    }

                    if($head[$i]->knight_status == 0){
                        $knight_status = 'NOT ACTIVATED';

                        if($head[$i]->account_status == 0){
                            $action .= '';
                        }else{
                            $action .= '<a href="'.site_url('admin/heads/update-knight').'/'.$head[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-balance-scale"></i> Update Knight</a>';
                        }

                    }else{
                        $knight_status = 'ACTIVATED';
                    }

                    if($head[$i]->paid_ar == 0 || $head[$i]->paid_ar == NULL){
                        $paid_ar = 'NA';
                    }else{
                        $paid_ar = $head[$i]->paid_ar;
                    }

                    if($head[$i]->knight_ar == 0 || $head[$i]->knight_ar == NULL){
                        $knight_ar = 'NA';
                    }else{
                        $knight_ar = $head[$i]->knight_ar;
                    }

                    $records["data"][] = array(
                        $head[$i]->headname,
                        $member_details_info->first_name.' '.$member_details_info->last_name,
                        $head[$i]->total_income,
                        $head[$i]->cd_balance,
                        $account_status,
                        $head_status,
                        $is_paylite,
                        $knight_status,
                        $paid_ar,
                        $knight_ar,
                        $head[$i]->created_on,
                        '<a href="'.site_url('admin/heads/detail').'/'.$head[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-database"></i> View Details</a>'.$action
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

            case 'get_search_result':
                $records = $_REQUEST;

                if (isset($records['filter'])) {
                    
                    $headname = $records['filter']['both']['headname'];
                    $member_name = $records['filter']['both']['member_name'];
                    $account_status = '';
                    $knight_status = '';
                    $is_paylite = '';
                    $paid_ar = '';
                    $knight_ar = '';
                    
                } else {

                    $headname = '';
                    $member_name = '';
                    $account_status = '';
                    $knight_status = '';
                    $is_paylite = '';
                    $paid_ar = '';
                    $knight_ar = '';
                }


                $order_by = 'heads.head_id DESC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'headname' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $heads = $this->Heads_model->get_search_result($headname, $member_name, $account_status, $knight_status, $is_paylite, $paid_ar, $knight_ar, $order_by);

                $iTotalRecords = count($heads);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $head = $heads;

                    $member_details_info = $this->Members_model->get_member_details($head[$i]->member_id);

                    $reseller_info = $this->Reseller_model->get_reseller($head[$i]->head_id);

                    $action = '';

                    if($reseller_info->is_reseller == 1){

                        $action .= '<a href="'.site_url('admin/heads/update-reseller').'/'.$head[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-balance-scale"></i> Update Reseller</a>';

                    }else{

                        if($head[$i]->cd_balance != '0.00'){
                            
                            if($head[$i]->is_paylite == 1){
                                $action .= '<a href="'.site_url('admin/heads/update-paylite').'/'.$head[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-balance-scale"></i> Update PayLite</a>';

                            }else{
                                $action .= '<br><br><a href="'.site_url('admin/heads/update-balance').'/'.$head[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-balance-scale"></i> Update CD Balance</a>';
                                $action .= '<a href="'.site_url('admin/heads/update-promo').'/'.$head[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-balance-scale"></i> Update CD Promo</a>';
                            }

                        }else{

                            $action = '';
                        }

                        if($head[$i]->knight_status == 0){

                            if($head[$i]->account_status == 0){
                                $action .= '';
                            }else{
                                $action .= '<a href="'.site_url('admin/heads/update-knight').'/'.$head[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-balance-scale"></i> Update Knight</a>';
                            }

                        }

                    }

                    $records["data"][] = array(
                        $head[$i]->headname,
                        $member_details_info->first_name.' '.$member_details_info->last_name,
                        $head[$i]->created_on,
                        '<a href="'.site_url('admin/heads/detail').'/'.$head[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-database"></i> View Details</a>'.$action
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

    public function export(){

        $filename = 'HEADS-LIST-'.date('Ymd');

        $this->load->library('excel');

        $objPHPExcel = $this->excel;

        $inputFileType = 'Excel5';
        $inputFileName = 'templates/heads.xls';
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $objPHPExcel->getProperties()->setCreator("Essensa Naturale - Heads");

        $heads = $this->Heads_model->get_all_heads();

        $admin_id = $this->ion_auth_admin->get_user_id();

        $admin_info = $this->User_model->get_admin_by_id($admin_id);

        $objPHPExcel->getActiveSheet()->setCellValue("B2", $admin_info->username);
        $objPHPExcel->getActiveSheet()->setCellValue("B3", count($heads));        

        $i = 6;

        foreach($heads as $head){
            
            $member_info = $this->Members_model->get_member($head->member_id);
            $member_details_info = $this->Members_model->get_member_details($head->member_id);
            $gold_count_info = $this->Heads_model->get_gold_count_by_head($head->head_id);

            $objPHPExcel->getActiveSheet()->setCellValue("A{$i}", $head->headname);
            $objPHPExcel->getActiveSheet()->setCellValue("B{$i}", $member_info->username);
            $objPHPExcel->getActiveSheet()->setCellValue("C{$i}", $head->cd_balance);
            $objPHPExcel->getActiveSheet()->setCellValue("D{$i}", $gold_count_info->stars);
            $objPHPExcel->getActiveSheet()->setCellValue("E{$i}", $head->total_income);
            $objPHPExcel->getActiveSheet()->setCellValue("F{$i}", $head->total_direct_bonus);
            $objPHPExcel->getActiveSheet()->setCellValue("G{$i}", $head->total_gsc_bonus);
            $objPHPExcel->getActiveSheet()->setCellValue("H{$i}", $head->total_leadership_bonus);
            
            if($head->knight_status == 0){
                $knight_status = 'No';
            }else{
                $knight_status = 'Yes';
            }
            $objPHPExcel->getActiveSheet()->setCellValue("I{$i}", $knight_status);
            
            $objPHPExcel->getActiveSheet()->setCellValue("J{$i}", $head->knight_date);

            if($head->status == 0){
                $status = 'No';
            }else{
                $status = 'Yes';
            }            
            $objPHPExcel->getActiveSheet()->setCellValue("K{$i}", $status);
            $objPHPExcel->getActiveSheet()->setCellValue("L{$i}", $head->created_on);

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