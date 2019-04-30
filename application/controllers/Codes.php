<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Codes extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->database();

        $this->load->library(array('ion_auth_member','form_validation'));

        $this->load->helper(array('url','language', 'file'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth_member'), $this->config->item('error_end_delimiter', 'ion_auth_member'));

        $this->lang->load('auth');

        $this->load->model('Codes_model');
        $this->load->model('Members_model');
        $this->load->model('Heads_model');        
        $this->load->model('Announcement_model');
        $this->load->model('User_model');
        $this->load->model('Rewards_model');
        $this->load->model('Settings_model');
        $this->load->model('System_model');
        $this->load->model('Encashment_model');
        $this->load->model('Packages_model');
    }


    public function codes(){
        $data = array();

        $user = $this->ion_auth_member->user()->row();

        if(isset($user) && $user->blocked == 1){
            redirect('blocked', 'refresh');
            exit;
        }else{ 

            $maintenance_settings = $this->System_model->get_settings('maintenance');

            if($maintenance_settings['active'] == 1){
                redirect('maintenance', 'refresh');
            }else{        
                if (!$this->ion_auth_member->logged_in() || $this->session->userdata('user_type') != 'member')
                {
                    // redirect them to the login page
                    $this->ion_auth_member->logout();
                    redirect('login', 'refresh');
                }else{
                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $data['memberhead_info'] = $memberhead_info;

                    $this->load->view('member-codes-listing-tpl', $data);
                }
            }
        }
    }   

    public function transfer(){
        $data = array();

        $user = $this->ion_auth_member->user()->row();

        if(isset($user) && $user->blocked == 1){
            redirect('blocked', 'refresh');
            exit;
        }else{ 

            $maintenance_settings = $this->System_model->get_settings('maintenance');

            if($maintenance_settings['active'] == 1){
                redirect('maintenance', 'refresh');
            }else{
                if (!$this->ion_auth_member->logged_in() || $this->session->userdata('user_type') != 'member')
                {
                    // redirect them to the login page
                    $this->ion_auth_member->logout();
                    redirect('login', 'refresh');
                }else{
                    $code_id = $this->session->userdata('member_code_id');

                    $member_id = $this->ion_auth_member->get_user_id();

                    #validate user that the code is available and own it
                    $code_info = $this->Codes_model->check_member_code($code_id, $member_id);

                    if(empty($code_info)){

                        redirect('codes');

                    }else{

                        $data = array();

                        $members = $this->Members_model->get_members_yournotincluded($member_id);

                        $data['members'] = $members;
                        $data['code_info'] = $code_info;

                        $head = $this->session->userdata('current_head');

                        $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                        $data['memberhead_info'] = $memberhead_info;

                        $member_pin_info = $this->Members_model->get_member($member_id);

                        $data['member_pin_info'] = $member_pin_info;

                        $this->form_validation->set_rules('security_pin', 'Security Pin', 'trim|required|callback_verify_security_pin');
                        $this->form_validation->set_rules('member_account', 'Member Account', 'trim|required|callback_check_member_id');
                        #$this->form_validation->set_rules('member_id', 'Member Account', 'trim|required|callback_check_member_id');

                        if ($this->form_validation->run() == FALSE){
                        
                        }else{
                            $transfer_member_id = $this->input->post('member_account');
                            $current_member_id = $this->ion_auth_member->get_user_id();

                            #validate user that the code is available and own it
                            $code_info = $this->Codes_model->check_member_code($code_id, $current_member_id);

                            if(empty($code_info)){

                                $printed_message['type'] = 'error';
                                $printed_message['message'] = 'Invalid Code';

                                $this->session->set_flashdata('message', $printed_message);

                                redirect('codes/listing');

                            }else{
                                $update_data['code_id'] = $code_id;
                                $update_data['purchased_by'] = $transfer_member_id;

                                $this->Codes_model->update_code($update_data);

                                #add to history

                                $history_data['type'] = 'transfer';
                                $history_data['code_id'] = $code_id;
                                $history_data['member_id'] = $current_member_id;
                                $history_data['transfer_to'] = $transfer_member_id;
                                $history_data['datecreated'] = date('Y-m-d H:i:s');

                                $this->Codes_model->insert_code_history($history_data);

                                $data['status'] = 'success';
                                $data['msg'] = 'Code transferred successfully';

                                #log action
                                $member_transfer_info = $this->Members_model->get_member($transfer_member_id);
                                $code_info = $this->Codes_model->get_code($code_id);

                                logger('transfer_code', $current_member_id, 'members', 'User %username% successfully transferred code('.$code_info->code.') to '.$member_transfer_info->username);

                                redirect('codes/transfer-history');
                            }

                        }

                        $this->load->view('member-transfer-code-tpl', $data);
                    }
                }
            }
        }
    }

    public function transfer_history(){

        $data = array();

        $user = $this->ion_auth_member->user()->row();

        if(isset($user) && $user->blocked == 1){
            redirect('blocked', 'refresh');
            exit;
        }else{ 
        
            $maintenance_settings = $this->System_model->get_settings('maintenance');

            if($maintenance_settings['active'] == 1){
                redirect('maintenance', 'refresh');
            }else{

                if (!$this->ion_auth_member->logged_in() || $this->session->userdata('user_type') != 'member')
                {
                    // redirect them to the login page
                    $this->ion_auth_member->logout();
                    redirect('login', 'refresh');
                }else{

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $data['memberhead_info'] = $memberhead_info;
                                
                    $this->load->view('member-codes-history-listing-tpl', $data);
                }
            }
        }
    } 
    
    public function used_history(){

        $data = array();

        $user = $this->ion_auth_member->user()->row();

        if(isset($user) && $user->blocked == 1){
            redirect('blocked', 'refresh');
            exit;
        }else{ 
        
            $maintenance_settings = $this->System_model->get_settings('maintenance');

            if($maintenance_settings['active'] == 1){
                redirect('maintenance', 'refresh');
            }else{

                if (!$this->ion_auth_member->logged_in() || $this->session->userdata('user_type') != 'member')
                {
                    // redirect them to the login page
                    $this->ion_auth_member->logout();
                    redirect('login', 'refresh');
                }else{

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $data['memberhead_info'] = $memberhead_info;
                                
                    $this->load->view('member-used-codes-history-listing-tpl', $data);
                }
            }
        }
    }

    public function ajax($section){

        switch ($section) {
            case 'get_all_codes':

                $records = $_REQUEST;

                $member_id = $this->ion_auth_member->get_user_id();

                if (isset($records['filter'])) {
                    $code = $records['filter']['both']['code'];
                    $type_id = $records['filter']['both']['type_id'];
                } else {

                    $code = '';
                    $type_id = '';
                }


                $order_by = 'code_id DESC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'code' . ' ' . $records['order'][0]['dir'];
                    } elseif ($records['order'][0]['column'] == 2) {
                        $order_by = 'type_id' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $codes = $this->Codes_model->get_all_codes_dtable_member($code, $type_id, $member_id, $order_by);

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

                    if($code[$i]->type_id == 0){
                        $code_type = 'CD';
                    }elseif($code[$i]->type_id == 1){
                        $code_type = 'PAID';
                    }

                    $package_info = $this->Packages_model->get_package($code[$i]->package_id);

                    $action = '<a href="javascript:;" id="transfer-button-'.$i.'" onclick="transferCode('.$i.');" data-code_id="'.$code[$i]->code_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-exchange"></i> Transfer</a>';

                    $records["data"][] = array(
                        $code[$i]->code, $code_type, $package_info->package_name, $code[$i]->datecreated, $action,
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

            case 'transfer-code':
                $transfer_member_id = $this->input->post('member_id');
                $code_id = $this->input->post('code_id');

                $current_member_id = $this->ion_auth_member->get_user_id();
                #validate user that the code is available and own it
                $code_info = $this->Codes_model->check_member_code($code_id, $current_member_id);

                if(empty($code_info)){

                    $data['status'] = 'error';
                    $data['msg'] = 'Error on transferring code';

                }else{

                    $update_data['code_id'] = $code_id;
                    $update_data['purchased_by'] = $transfer_member_id;

                    $this->Codes_model->update_code($update_data);

                    #add to history

                    $history_data['type'] = 'transfer';
                    $history_data['code_id'] = $code_id;
                    $history_data['member_id'] = $current_member_id;
                    $history_data['transfer_to'] = $transfer_member_id;
                    $history_data['datecreated'] = date('Y-m-d H:i:s');

                    $this->Codes_model->insert_code_history($history_data);

                    $data['status'] = 'success';
                    $data['msg'] = 'Code transferred successfully';

                    #log action
                    $member_transfer_info = $this->Members_model->get_member($transfer_member_id);
                    $code_info = $this->Codes_model->get_code($code_id);

                    logger('transfer_code', $current_member_id, 'members', 'User %username% successfully transferred code('.$code_info->code.') to '.$member_transfer_info->username);                    
                }


                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'code_history_listings':
                $records = $_REQUEST;

                $member_id = $this->ion_auth_member->get_user_id();

                if (isset($records['filter'])) {
                    $code = $records['filter']['both']['code_id'];
                    $type = $records['filter']['both']['type'];

                    $code_info = $this->Codes_model->get_code_by_code($code);

                    $code_id = $code_info->code_id;
                } else {

                    $code_id = '';
                    $type = '';
                }


                $order_by = 'code_id DESC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'code_id' . ' ' . $records['order'][0]['dir'];
                    } elseif ($records['order'][0]['column'] == 2) {
                        $order_by = 'type' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $codes = $this->Codes_model->get_all_codes_dtable_history($code_id, $type, $member_id, $order_by);

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

                    $code_info = $this->Codes_model->get_code($code[$i]->code_id);

                    if($code[$i]->transfer_to == 0){
                        $transfer_to = 'NA';
                    }else{
                        $user_info = $this->Members_model->get_member($code[$i]->transfer_to);
                        $user_details_info = $this->Members_model->get_member_details($code[$i]->transfer_to);

                        $transfer_to = $user_details_info->first_name.' '.$user_details_info->middle_name.' '.$user_details_info->last_name;
                    }

                    $records["data"][] = array(
                        $code_info->code, $transfer_to, $code[$i]->datecreated,  
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

            case 'used_code_history_listings':
                $records = $_REQUEST;

                $member_id = $this->ion_auth_member->get_user_id();

                if (isset($records['filter'])) {
                    $code = $records['filter']['both']['code_id'];
                    $type = $records['filter']['both']['type'];

                    $code_info = $this->Codes_model->get_code_by_code($code);

                    $code_id = $code_info->code_id;
                } else {

                    $code_id = '';
                    $type = '';
                }


                $order_by = 'code_id DESC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'code_id' . ' ' . $records['order'][0]['dir'];
                    } elseif ($records['order'][0]['column'] == 2) {
                        $order_by = 'type' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $codes = $this->Codes_model->get_all_used_codes_dtable_history($code_id, $type, $member_id, $order_by);

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

                    $member_info = $this->Members_model->get_member($code[$i]->used_by);
                    
                    if($code[$i]->used_to == 0){
                        $used_to = 'Not Yet Used';
                    }else{
                        $member_used_to_info = $this->Members_model->get_member_details($code[$i]->used_to);
                        $used_to = $member_used_to_info->first_name.' '.$member_used_to_info->middle_name.' '.$member_used_to_info->last_name;
                    }

                    $records["data"][] = array(
                         $code[$i]->code, $member_info->username, $used_to, $code[$i]->dateused,  
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

            case 'set-code':

                $code_id = $this->input->post('code_id');

                $this->session->set_userdata('member_code_id', $code_id);

                $data['status'] = 'success';
                $data['msg'] = 'Successfully set star wallet head';

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;             
        }
    }

    public function verify_security_pin(){

        $security_pin = xss_clean($this->input->post('security_pin'));
        $member_id = $this->ion_auth_member->get_user_id();

        if ($this->ion_auth_member->hash_security_pin_db($member_id, $security_pin) !== TRUE)
        {
            $this->form_validation->set_message('verify_security_pin', 'Incorrect Security Pin');
            return false;
        }else{
            return true;
        }        

    }

    public function check_member_id(){

        $member_id = xss_clean($this->input->post('member_account'));

        if ($member_id == 0)
        {
            $this->form_validation->set_message('check_member_id', 'Invalid Member Account');
            return false;
        }else{
            return true;
        }        

    }
}