<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Leadership extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

		$this->load->database();
		$this->load->library(array('ion_auth_admin','form_validation'));
		$this->load->helper(array('url','language'));

        $this->load->model('System_model');
        $this->load->model('Members_model');
        $this->load->model('Leadership_model');
        $this->load->model('User_model');
        $this->load->model('Heads_model');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth_admin'), $this->config->item('error_end_delimiter', 'ion_auth_admin'));

		$this->lang->load('auth');
	
    }

	public function index()
	{
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {

            $data = array();

            $maintenance_settings = $this->System_model->get_settings('maintenance');

            $members = $this->Members_model->get_members();
            $heads = $this->Members_model->get_heads();
            
            #current figures
            $total_income = $this->Members_model->head_sums('total_income');
            $cd_balance = $this->Members_model->head_sums('cd_balance');

            $data['maintenance_settings'] = $maintenance_settings;
            $data['member_count'] = count($members);
            $data['head_count'] = count($heads);
            $data['total_income'] = number_format($total_income);
            $data['cd_balance'] = number_format($cd_balance);

            $this->load->view('admin/leadership-pre-process-tpl', $data);
        }
	}

    public function process()
    {
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {

            $data = array();

            $maintenance_settings = $this->System_model->get_settings('maintenance');

            $members = $this->Members_model->get_members();
            $heads = $this->Members_model->get_heads();
            
            #current figures
            $total_income = $this->Members_model->head_sums('total_income');
            $cd_balance = $this->Members_model->head_sums('cd_balance');

            $data['maintenance_settings'] = $maintenance_settings;
            $data['member_count'] = count($members);
            $data['head_count'] = count($heads);
            $data['total_income'] = number_format($total_income);
            $data['cd_balance'] = number_format($cd_balance);

            $this->load->view('admin/leadership-process-tpl', $data);
        }
    }

    public function history()
    {
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {

            $data = array();

            $this->session->unset_userdata('transaction_id_history');
            $this->session->unset_userdata('details_id_history');

            $this->load->view('admin/leadership-history-tpl', $data);
        }
    }

    public function history_details()
    {
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {

            $data = array();

            $transaction_id = $this->session->userdata('transaction_id_history');

            $data['transaction_id'] = $transaction_id;

            $this->load->view('admin/leadership-history-details-tpl', $data);
        }
    }

    public function history_level()
    {
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {

            $data = array();

            $transaction_id = $this->session->userdata('transaction_id_history');
            $details_id = $this->session->userdata('details_id_history');

            $data['details_id'] = $details_id;
            $data['transaction_id'] = $transaction_id;

            $this->load->view('admin/leadership-history-level-tpl', $data);
        }
    }

    public function history_gsc()
    {
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {

            $data = array();

            $transaction_id = $this->session->userdata('transaction_id_history');
            $leader_id = $this->session->userdata('leader_id_history');

            $data['leader_id'] = $leader_id;
            $data['transaction_id'] = $transaction_id;

            $this->load->view('admin/leadership-history-gsc-tpl', $data);
        }
    }

    public function export_breakdown($details_id, $transaction_id){

        $order_by = 'level ASC';

        $levels = $this->Leadership_model->get_leadership_history_level($transaction_id, $details_id, $order_by);

        $leader_head_info = $this->Heads_model->get_head($levels[0]->leader_id);

        $leader_details_info = $this->Members_model->get_member_details($leader_head_info->member_id);

        $filename = 'LEADERSHIP-LEVELS-'.$leader_details_info->first_name.'-'.$leader_details_info->last_name.'-'.date('Ymd');

        $this->load->library('excel');

        $objPHPExcel = $this->excel;

        $inputFileType = 'Excel5';
        $inputFileName = 'templates/levels.xls';
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $objPHPExcel->getProperties()->setCreator("Essensa Naturale - Levels Details");

        $admin_id = $this->ion_auth_admin->get_user_id();

        $admin_info = $this->User_model->get_admin_by_id($admin_id);

        $objPHPExcel->getActiveSheet()->setCellValue("B2", $transaction_id);
        $objPHPExcel->getActiveSheet()->setCellValue("B3",  $leader_details_info->first_name.' '.$leader_details_info->middle_name.' '.$leader_details_info->last_name);
        $objPHPExcel->getActiveSheet()->setCellValue("B4", count($levels));        

        $i = 7;

        foreach($levels as $level){
            
            $head_info = $this->Heads_model->get_head($level->head_id);

            $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

            $objPHPExcel->getActiveSheet()->setCellValue("A{$i}", $head_info->headname);
            $objPHPExcel->getActiveSheet()->setCellValue("B{$i}", $level->sponsor_count);
            $objPHPExcel->getActiveSheet()->setCellValue("C{$i}", $level->percentage);
            $objPHPExcel->getActiveSheet()->setCellValue("D{$i}", number_format($level->gsc_income));
            $objPHPExcel->getActiveSheet()->setCellValue("E{$i}", number_format($level->leadership_income));
            $objPHPExcel->getActiveSheet()->setCellValue("F{$i}", $level->level);
            $objPHPExcel->getActiveSheet()->setCellValue("G{$i}", $level->date_processed);

            $i++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }    

    public function ajax($section)
    {
        switch ($section) {
            case 'preprocess-information':

                $transaction_id = 'GE-LEADERSHIP'.date('YmdHis');

                $admin_id = $this->ion_auth_admin->get_user_id();

                $members = $this->Members_model->get_members();
                $heads = $this->Members_model->get_heads();

                #current figures
                $current_total_income = $this->Members_model->head_sums('total_income');
                $current_cd_balance = $this->Members_model->head_sums('cd_balance');

                $total_members = count($members);
                $total_heads = count($heads);
                $total_income = $current_total_income;
                $total_cd_balance = $current_cd_balance;

                $pre_process_data['processedby'] = $admin_id;
                $pre_process_data['transaction_id'] = $transaction_id;
                $pre_process_data['total_members'] = $total_members;
                $pre_process_data['total_heads'] = $total_heads;
                $pre_process_data['total_income'] = $total_income;
                $pre_process_data['total_cd_balance'] = $total_cd_balance;
                $pre_process_data['datepreprocess'] = date('Y-m-d H:i:s');

                $this->Leadership_model->insert_preprocess($pre_process_data);

                $this->session->set_userdata('transaction_id', $transaction_id);

                $data['status'] = 'success';

                #log action
                logger('leadership_preprocess_information', $admin_id, 'admin', 'Leadership pre-process information of '.$transaction_id.' successfully saved');

                $this->output->set_content_type('application/json')->set_output(json_encode($data));                
            break;

            case 'process-weekly-income':

                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->ProcessWeeklyIncome($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership weekly income of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership weekly income of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_weekly_income', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));  

            break;

            case 'leadership-level1':

                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership1($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 1 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 1 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_1', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));  

            break;

            case 'leadership-level2':

                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership2($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 2 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 2 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_2', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));  

            break;

            case 'leadership-level3':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership3($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 3 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 3 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_3', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'leadership-level4':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership4($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 4 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 4 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_4', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'leadership-level5':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership5($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 5 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 5 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_5', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'leadership-level6':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership6($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 6 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 6 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_6', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'leadership-level7':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership7($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 7 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 7 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_7', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'leadership-level8':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership8($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 8 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 8 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_8', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'leadership-level9':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership9($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 9 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 9 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_9', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'leadership-level10':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership10($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 10 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 10 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_10', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'leadership-level11':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership11($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 11 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 11 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_11', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'leadership-level12':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership12($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 12 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 12 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_12', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'leadership-level13':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership13($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 13 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 13 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_13', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'leadership-level14':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership14($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 14 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 14 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_14', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'leadership-level15':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->Leadership15($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership level 15 of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership level 15 of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_level_15', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'leadership-income':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                #call sp here
                $result = $this->Leadership_model->LeadershipIncome($transaction_id);

                if($result){

                    $data['status'] = 'success';
                    $message = 'Leadership income of '.$transaction_id.' processed';

                }else{

                    $data['status'] = 'error';
                    $message = 'Leadership income of '.$transaction_id.' error';
                }

                $data['msg'] = $message;

                #log action
                logger('process_leadership_income', $admin_id, 'admin', $message);

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;            

            case 'process-information':
                $transaction_id = $this->session->userdata('transaction_id');
                $admin_id = $this->ion_auth_admin->get_user_id();

                $members = $this->Members_model->get_members();
                $heads = $this->Members_model->get_heads();

                #current figures
                $current_total_income = $this->Members_model->head_sums('total_income');
                $current_cd_balance = $this->Members_model->head_sums('cd_balance');

                $total_members = count($members);
                $total_heads = count($heads);
                $total_income = $current_total_income;
                $total_cd_balance = $current_cd_balance;

                $processed_data['processedby'] = $admin_id;
                $processed_data['transaction_id'] = $transaction_id;
                $processed_data['total_members'] = $total_members;
                $processed_data['total_heads'] = $total_heads;
                $processed_data['total_income'] = $total_income;
                $processed_data['total_cd_balance'] = $total_cd_balance;
                $processed_data['dateprocessed'] = date('Y-m-d H:i:s');

                $this->Leadership_model->insert_processed($processed_data);

                $this->session->unset_userdata('transaction_id');

                $data['status'] = 'success';

                #log action
                logger('leadership_processed_information', $admin_id, 'admin', 'Leadership process information of '.$transaction_id.' successfully saved');

                $this->output->set_content_type('application/json')->set_output(json_encode($data)); 
            break;

            case 'get_leadership_histories':
                $records = $_REQUEST;

                if (isset($records['filter'])) {
                    
                    $transaction_id = $records['filter']['both']['transaction_id'];

                } else {

                    $transaction_id = '';
                }


                $order_by = 'processed_id DESC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'processed_id' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $histories = $this->Leadership_model->get_leadership_histories($transaction_id, $order_by);

                $iTotalRecords = count($histories);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $history = $histories;

                    $admin_info = $this->User_model->get_admin_by_id($history[$i]->processedby);

                    $records["data"][] = array(
                        $history[$i]->transaction_id,
                        $history[$i]->total_members,
                        $history[$i]->total_heads,
                        number_format($history[$i]->pre_total_income),
                        number_format($history[$i]->pre_total_cd_balance),
                        number_format($history[$i]->proc_total_income),
                        number_format($history[$i]->proc_total_cd_balance),
                        $admin_info->username,
                        $history[$i]->dateprocessed,
                        '<a href="javascript:;" id="set-transaction-'.$i.'" onclick="setTransaction('.$i.');" data-trans-id="'.$history[$i]->transaction_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-database"></i> View Details</a>'
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

            case 'get_leadership_history_details':
                $records = $_REQUEST;

                $transaction_id = $this->session->userdata('transaction_id_history');
                // $transaction_id = 'GE-LEADERSHIP20180911235030';

                if (isset($records['filter'])) {
                    
                    $membername = $records['filter']['both']['membername'];
                    $headname = $records['filter']['both']['headname'];

                } else {

                    $membername = '';
                    $headname = '';
                }


                $order_by = 'details_id ASC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'details_id' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $details = $this->Leadership_model->get_leadership_history_details($transaction_id, $membername, $headname, $order_by);

                $iTotalRecords = count($details);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $detail = $details;

                    $head_info = $this->Heads_model->get_head($detail[$i]->leader_id);

                    $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                    if($detail[$i]->knight_status == 1){
                        $knight_status = 'Yes';
                    }else{
                        $knight_status = 'No';
                    }

                    $records["data"][] = array(
                        $member_details_info->first_name.' '.$member_details_info->middle_name.' '.$member_details_info->last_name,
                        $head_info->headname,
                        $knight_status,
                        $detail[$i]->sponsor_count,
                        number_format($detail[$i]->leadership_income),
                        number_format($detail[$i]->cd_deduction),
                        number_format($detail[$i]->cd_balance),
                        $detail[$i]->date_processed,
                        '<a href="javascript:;" class="btn btn-sm btn-circle btn-default btn-editable" onclick="setDetailsId('.$detail[$i]->details_id.');"><i class="fa fa-database"></i> Per Level</a>
                        <a href="javsacript:;" class="btn btn-sm btn-circle btn-default btn-editable" onclick="setLeaderId('.$detail[$i]->leader_id.');"><i class="fa fa-database"></i> GSC</a>'
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

            case 'get_leadership_history_level':
                $records = $_REQUEST;

                #$details_id = $this->input->post('details_id');
                $details_id = $this->session->userdata('details_id_history');
                $transaction_id = $this->session->userdata('transaction_id_history');

                if (isset($records['filter'])) {
                    
                    $head = $records['filter']['both']['head'];

                } else {

                    $head = '';
                }


                $order_by = 'level ASC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'level' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $levels = $this->Leadership_model->get_leadership_history_level($transaction_id, $details_id, $order_by);

                $iTotalRecords = count($levels);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $level = $levels;

                    $leader_head_info = $this->Heads_model->get_head($level[$i]->leader_id);

                    $head_info = $this->Heads_model->get_head($level[$i]->head_id);

                    $leader_details_info = $this->Members_model->get_member_details($leader_head_info->member_id);

                    $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                    $records["data"][] = array(
                        $leader_details_info->first_name.' '.$leader_details_info->middle_name.' '.$leader_details_info->last_name,
                        $head_info->headname,
                        $level[$i]->sponsor_count,
                        $level[$i]->percentage,
                        number_format($level[$i]->gsc_income),
                        number_format($level[$i]->leadership_income),
                        $level[$i]->level,
                        $level[$i]->date_processed,
                        ''
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

            case 'get_leadership_history_gsc':
                $records = $_REQUEST;

                $leader_id = $this->session->userdata('leader_id_history');
                $transaction_id = $this->session->userdata('transaction_id_history');

                if (isset($records['filter'])) {
                    
                    $head = $records['filter']['both']['head'];

                } else {

                    $head = '';
                }


                $order_by = 'gsc_history_id ASC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'gsc_history_id' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $histories = $this->Leadership_model->get_leadership_history_gsc($transaction_id, $leader_id, $order_by);

                $iTotalRecords = count($histories);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $history = $histories;

                    $head_info = $this->Heads_model->get_head($history[$i]->head_id);

                    $records["data"][] = array(
                        $head_info->headname,
                        $history[$i]->lgsc,
                        $history[$i]->rgsc,
                        $history[$i]->cd_l_count,
                        $history[$i]->cd_r_count,
                        $history[$i]->paid_l_count,
                        $history[$i]->paid_r_count,
                        number_format($history[$i]->direct_referral_bonus),
                        number_format($history[$i]->gsc_income),
                        number_format($history[$i]->cd_deduction),
                        number_format($history[$i]->cd_balance),
                        $history[$i]->weekly_star,
                        $history[$i]->date_processed,
                        ''
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

            case 'set-details-id':

                $this->session->unset_userdata('details_id_history');

                $details_id = $this->input->post('details_id');
                $transaction_id = $this->input->post('transaction_id');

                $this->session->set_userdata('details_id_history', $details_id);
                $this->session->set_userdata('transaction_id_history', $transaction_id);

                $data['status'] = 'success';
                $data['msg'] = 'Successfully set details id';

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'set-leader-id':

                $this->session->unset_userdata('leader_id_history');

                $leader_id = $this->input->post('leader_id');
                $transaction_id = $this->input->post('transaction_id');

                $this->session->set_userdata('leader_id_history', $leader_id);
                $this->session->set_userdata('transaction_id_history', $transaction_id);

                $data['status'] = 'success';
                $data['msg'] = 'Successfully set leader id';

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'set-transaction-id':

                $transaction_id = $this->session->userdata('transaction_id_history');
                $details_id = $this->session->userdata('details_id_history');

                $transaction_id = $this->input->post('transaction_id');

                $this->session->set_userdata('transaction_id_history', $transaction_id);

                $data['status'] = 'success';
                $data['msg'] = 'Successfully set transaction id';

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;
        }
    }
}