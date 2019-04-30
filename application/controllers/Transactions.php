<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends CI_Controller {

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
        $this->load->model('Leadership_model');
        $this->load->model('Reseller_model');
    }

    public function wallet(){
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
                    $member_id = $this->ion_auth_member->get_user_id();

                    $member_wallet_info = $this->Members_model->get_member_wallet($member_id);

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $data['heads'] = $heads;
                    $data['memberhead_info'] = $memberhead_info;
                    $data['member_wallet_info'] = $member_wallet_info;

                    $this->load->view('member-wallet-tpl', $data);
                }
            }            
        }
    }

    public function star_wallet(){

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
                    $member_id = $this->ion_auth_member->get_user_id();

                    $member_star_wallet_info = $this->Members_model->get_member_star_wallet($member_id);

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $data['heads'] = $heads;
                    $data['memberhead_info'] = $memberhead_info;
                    $data['member_star_wallet_info'] = $member_star_wallet_info;

                    $this->load->view('member-star-wallet-tpl', $data);
                }
            }
        }
    }

    public function wallet_history(){

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
                    $member_id = $this->ion_auth_member->get_user_id();

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $data['heads'] = $heads;
                    $data['memberhead_info'] = $memberhead_info;

                    $this->load->view('member-wallet-history-tpl', $data);
                }
            }
        }
    }

    public function star_wallet_history(){

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
                    $member_id = $this->ion_auth_member->get_user_id();

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $data['heads'] = $heads;
                    $data['memberhead_info'] = $memberhead_info;

                    $this->load->view('member-star-wallet-history-tpl', $data);
                }
            }
        }
    }

    public function move_wallet(){

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
                    $head_id = $this->session->userdata('wallet_head_id');
                    
                    $member_id = $this->ion_auth_member->get_user_id();

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $head_info = $this->Heads_model->get_head($head_id);

                    $data['heads'] = $heads;
                    $data['memberhead_info'] = $memberhead_info;
                    $data['head_info'] = $head_info;
                    $data['head_id'] = $head_id;


                    $member_pin_info = $this->Members_model->get_member($member_id);
                    $data['member_pin_info'] = $member_pin_info;

                    $this->form_validation->set_rules('security_pin', 'Security Pin', 'trim|required|callback_verify_security_pin');
                    $this->form_validation->set_rules('amount', 'Amount', 'trim|required|callback_verify_amount');

                    if ($this->form_validation->run() == FALSE){
                    
                    }else{

                        $amount         = xss_clean($this->input->post('amount'));

                        $current_head_income = $head_info->total_income;

                        $new_head_income = $current_head_income - $amount;

                        #update head total_income

                        $head_data['head_id'] = $head_id;
                        $head_data['total_income'] = $new_head_income;

                        $this->Heads_model->update_head($head_data);

                        #update member wallet
                        $member_wallet_info = $this->Members_model->get_member_wallet($member_id);

                        $current_wallet = $member_wallet_info->amount;

                        $new_wallet = $current_wallet + $amount;

                        $wallet_data['member_id'] = $member_id;
                        $wallet_data['amount'] = $new_wallet;

                        $this->Members_model->update_member_wallet($wallet_data);

                        #log transaction in member wallet history
                        $wallet_history_data['member_id'] = $member_id;
                        $wallet_history_data['head_id'] = $head_id;
                        $wallet_history_data['amount'] = $amount;
                        $wallet_history_data['transaction_type'] = 'credit';
                        $wallet_history_data['datetransaction'] = date('Y-m-d H:i:s');

                        $this->Members_model->insert_member_wallet_history($wallet_history_data);

                        $printed_message['type'] = 'success';
                        $printed_message['message'] = 'Successfully moved to wallet';

                        $this->session->set_flashdata('message', $printed_message); 

                        #log action
                        logger('move_wallet', $member_id, 'members', 'User %username% successfully moved to wallet amount: '.$amount);

                        redirect('transactions/wallet');
                    }            

                    $this->load->view('member-move-to-wallet-tpl', $data);
                }
            }
        }
    }
	
	public function claim_reseller_voucher(){
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

                    $member_id = $this->ion_auth_member->get_user_id();

                    $member_details_info = $this->Members_model->get_member_details($member_id);
                    $memberhead_details_info = $this->Members_model->get_member_details($member_id);
                    $member_pin_info = $this->Members_model->get_member($member_id);

                    $encashment_settings = $this->System_model->get_settings('encashment');

                    $data['encashment_settings'] = $encashment_settings;
                    $data['memberhead_details_info'] = $memberhead_details_info;
                    $data['member_details_info'] = $member_details_info;
                    $data['member_pin_info'] = $member_pin_info;

                    $this->form_validation->set_rules('security_pin', 'Security Pin', 'trim|required|callback_verify_security_pin');

                    if ($this->form_validation->run() == FALSE){
                    
                    }else{

                        $head_id = $this->session->userdata('wallet_head_id');

                        $reseller_request_data['member_id'] = $member_id;
                        $reseller_request_data['head_id'] = $head_id;
                        $reseller_request_data['daterequested'] = date('Y-m-d H:i:s');
                        $reseller_request_data['ip_address'] = $this->input->ip_address();

                        $this->Reseller_model->insert_reseller_request($reseller_request_data);

                        #update reseller

                        $reseller_data['head_id'] = $head_id;
                        $reseller_data['gc_available'] = 0;

                        $this->Reseller_model->update_reseller($reseller_data);

                        $printed_message['type'] = 'success';
                        $printed_message['message'] = 'Successfully requested for reseller voucher';

                        $this->session->set_flashdata('message', $printed_message);

                        #log action
                        logger('request_reseller_voucher', $member_id, 'members', 'User %username% requested reseller voucher for head '.$head_id);

                        redirect('transactions/reseller-voucher-request-history');                        
                    }

                    $this->load->view('member-reseller-voucher-request-tpl', $data);
                }
            }
        }        
    }

    public function move_star_wallet(){

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
                    $head_id = $this->session->userdata('star_wallet_head_id');

                    $member_id = $this->ion_auth_member->get_user_id();

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $head_info = $this->Heads_model->get_head($head_id);

                    $data['heads'] = $heads;
                    $data['memberhead_info'] = $memberhead_info;
                    $data['head_info'] = $head_info;
                    $data['head_id'] = $head_id;

                    $member_pin_info = $this->Members_model->get_member($member_id);
                    $data['member_pin_info'] = $member_pin_info;

                    $this->form_validation->set_rules('security_pin', 'Security Pin', 'trim|required|callback_verify_security_pin');
                    $this->form_validation->set_rules('stars', 'Stars Quantity', 'trim|required|is_natural_no_zero|callback_verify_star');

                    if ($this->form_validation->run() == FALSE){
                    
                    }else{

                        $stars         = xss_clean($this->input->post('stars'));

                        $gold_info = $this->Heads_model->get_gold_count_by_head($head_id);

                        $current_head_stars = $gold_info->stars;

                        $new_head_stars = $current_head_stars - $stars;

                        #update head stars in gold_count

                        $gold_data['head_id'] = $head_id;
                        $gold_data['stars'] = $new_head_stars;

                        $this->Heads_model->update_gold_count($gold_data);

                        #update member wallet
                        $member_star_wallet_info = $this->Members_model->get_member_star_wallet($member_id);

                        $current_stars = $member_star_wallet_info->stars;

                        $new_stars = $current_stars + $stars;

                        $star_wallet_data['member_id'] = $member_id;
                        $star_wallet_data['stars'] = $new_stars;

                        $this->Members_model->update_member_star_wallet($star_wallet_data);

                        #log transaction in member wallet history
                        $star_wallet_history_data['member_id'] = $member_id;
                        $star_wallet_history_data['head_id'] = $head_id;
                        $star_wallet_history_data['stars'] = $stars;
                        $star_wallet_history_data['transaction_type'] = 'credit';
                        $star_wallet_history_data['datetransaction'] = date('Y-m-d H:i:s');

                        $this->Members_model->insert_member_star_wallet_history($star_wallet_history_data);

                        $printed_message['type'] = 'success';
                        $printed_message['message'] = 'Successfully moved to star wallet';

                        $this->session->set_flashdata('message', $printed_message); 

                        #log action
                        logger('move_star_wallet', $member_id, 'members', 'User %username% successfully moved to star wallet stars: '.$stars);                

                        redirect('transactions/star-wallet');
                    }            

                    $this->load->view('member-move-to-star-wallet-tpl', $data);
                }
            }
        }
    }

    public function gsc_history(){

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
                    $member_id = $this->ion_auth_member->get_user_id();

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $data['heads'] = $heads;
                    $data['current_head'] = $head;
                    $data['memberhead_info'] = $memberhead_info;
                    $data['head_id'] = $memberhead_info->head_id;

                    $this->load->view('member-gsc-history-tpl', $data);
                }
            }
        }
    }

    public function leadership_history(){

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
                    $member_id = $this->ion_auth_member->get_user_id();

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $data['heads'] = $heads;
                    $data['current_head'] = $head;
                    $data['memberhead_info'] = $memberhead_info;
                    $data['head_id'] = $memberhead_info->head_id;

                    $this->load->view('member-leadership-history-tpl', $data);
                }
            }
        }
    }

    public function leadership_details_history($transaction_id){

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
                    $member_id = $this->ion_auth_member->get_user_id();

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $data['heads'] = $heads;
                    $data['current_head'] = $head;
                    $data['memberhead_info'] = $memberhead_info;
                    $data['head_id'] = $memberhead_info->head_id;
                    $data['transaction_id'] = $transaction_id;

                    $this->load->view('member-leadership-details-history-tpl', $data);
                }
            }
        }
    }

    public function leadership_level_history($transaction_id){

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
                    $member_id = $this->ion_auth_member->get_user_id();

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $data['heads'] = $heads;
                    $data['current_head'] = $head;
                    $data['memberhead_info'] = $memberhead_info;
                    $data['head_id'] = $memberhead_info->head_id;
                    $data['transaction_id'] = $transaction_id;

                    $this->load->view('member-leadership-level-history-tpl', $data);
                }
            }
        }
    }

    public function reseller_voucher_request_history(){

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
                $this->load->view('member-reseller-voucher-request-history-tpl', $data);
            }
        }

    }

    public function ajax($section){

        switch ($section) {
            case 'get_wallet_history':
                $records = $_REQUEST;

                $member_id = $this->ion_auth_member->get_user_id();

                if (isset($records['filter'])) {
                    $headname = $records['filter']['both']['headname'];

                    $head_info = $this->Heads_model->get_head_by_headname($headname);

                    $head_id = $head_info->head_id;
                } else {
                    $head_id = '';
                }


                $order_by = 'head_id ASC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'headname' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $histories = $this->Members_model->get_wallet_history_dtable($head_id, $member_id, $order_by);

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

                    if($history[$i]->head_id == 0){
                        $head = 'NA';
                    }else{
                        $head_info = $this->Heads_model->get_head($history[$i]->head_id);
                        
                        $head = $head_info->headname;
                    }

                    $records["data"][] = array(
                        $head, $history[$i]->amount, strtoupper($history[$i]->transaction_type), $history[$i]->datetransaction, ''
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

            case 'get_star_heads':
                $records = $_REQUEST;

                $member_id = $this->ion_auth_member->get_user_id();

                if (isset($records['filter'])) {
                    $headname = $records['filter']['both']['headname'];

                    $head_info = $this->Heads_model->get_head_by_headname($headname);

                    $head_id = $head_info->head_id;
                } else {
                    $head_id = '';
                }


                $order_by = 'head_id ASC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'headname' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $members = $this->Members_model->get_star_wallet_dtable($head_id, $member_id, $order_by);

                $iTotalRecords = count($members);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $member = $members;

                    if($member[$i]->head_id == 0){
                        $head = 'NA';
                    }else{
                        $head_info = $this->Heads_model->get_head($member[$i]->head_id);
                        
                        $head = $head_info->headname;
                    }

                    if($member[$i]->stars != 0){
                        $action = '<a href="javascript:;" id="wallet-move-button-'.$i.'" onclick="moveToWallet('.$i.');" data-head_id="'.$member[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-exchange"></i> Move To Star Wallet</a>';
                    }else{
                        $action = '';
                    }

                    $records["data"][] = array(
                        $head, $member[$i]->stars, $action
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

            case 'get_star_wallet_history':
                $records = $_REQUEST;

                $member_id = $this->ion_auth_member->get_user_id();

                if (isset($records['filter'])) {
                    $headname = $records['filter']['both']['headname'];

                    $head_info = $this->Heads_model->get_head_by_headname($headname);

                    $head_id = $head_info->head_id;
                } else {
                    $head_id = '';
                }


                $order_by = 'head_id ASC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'headname' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $histories = $this->Members_model->get_star_wallet_history_dtable($head_id, $member_id, $order_by);

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

                    if($history[$i]->head_id == 0){
                        $head = 'NA';
                    }else{
                        $head_info = $this->Heads_model->get_head($history[$i]->head_id);
                        
                        $head = $head_info->headname;
                    }

                    $records["data"][] = array(
                        $head, $history[$i]->stars, strtoupper($history[$i]->transaction_type), $history[$i]->datetransaction, ''
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

            case 'get_income_heads':
                $records = $_REQUEST;

                $member_id = $this->ion_auth_member->get_user_id();

                if (isset($records['filter'])) {
                    $headname = $records['filter']['both']['headname'];
                } else {
                    $headname = '';
                }


                $order_by = 'head_id ASC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'headname' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $heads = $this->Heads_model->get_all_heads_by_member_dtable($headname, $member_id, $order_by);

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
					
					#Buboy April 27, 2019
					#reseller conditions
					$action = '';
                    if($head[$i]->total_income != '0.00'){
                        # buboy April 23, 2019
                        # added active wallet
                        if($head[$i]->ActiveWallet == '1'){
                            $action = '<a href="javascript:;" id="wallet-move-button-'.$i.'" onclick="moveToWallet('.$i.');" data-head_id="'.$head[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-exchange"></i> Move To Wallet</a>';
                        }
                    }
                    
                    if($head[$i]->ActiveResellerGC == '1'){
                        $action = $action. '<a href="javascript:;" id="reseller-gc-release-'.$i.'" onclick="resellerGCRelease('.$i.');" data-head_id="'.$head[$i]->head_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-exchange"></i> Claim Reseller Voucher</a>';
                    }
					
					$action = $action.$head[$i]->ResellerMessage;

                    $records["data"][] = array(
                        $head[$i]->headname, $head[$i]->total_income, $action
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

            case 'set-star-head':

                $head_id = $this->input->post('head_id');

                $this->session->set_userdata('star_wallet_head_id', $head_id);

                $data['status'] = 'success';
                $data['msg'] = 'Successfully set star wallet head';

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'set-wallet-head':

                $head_id = $this->input->post('head_id');

                $this->session->set_userdata('wallet_head_id', $head_id);

                $data['status'] = 'success';
                $data['msg'] = 'Successfully set star wallet head';

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'get_gsc_history':
                $records = $_REQUEST;

                $head_id = $this->input->post('head_id');

                $order_by = 'gsc_history_id ASC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'gsc_history_id' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $histories = $this->Leadership_model->get_history_gsc($head_id, $order_by);

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
                        $history[$i]->transaction_id,
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
                        $history[$i]->dateprocessed,
                        '<a href="'.site_url('transactions/leadership-history-details').'/'.$history[$i]->transaction_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-database"></i> View Details</a>'
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

            case 'get_history_details':
                $records = $_REQUEST;

                $head_id = $this->input->post('head_id');
                $transaction_id = $this->input->post('transaction_id');

                if (isset($records['filter'])) {
                    
                    $head = $records['filter']['both']['head'];

                } else {

                    $head = '';
                }


                $order_by = 'details_id ASC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'details_id' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $details = $this->Leadership_model->get_history_details($transaction_id, $head_id, $order_by);

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
                        $head_info->headname,
                        $knight_status,
                        $detail[$i]->sponsor_count,
                        number_format($detail[$i]->leadership_income),
                        number_format($detail[$i]->cd_deduction),
                        number_format($detail[$i]->cd_balance),
                        $detail[$i]->date_processed,
                        '<a href="'.site_url('transactions/leadership-level-details').'/'.$transaction_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-database"></i> Per Level</a>'
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

            case 'get_history_level':
                $records = $_REQUEST;

                $head_id        = $this->input->post('head_id');
                $transaction_id = $this->input->post('transaction_id');

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

                $levels = $this->Leadership_model->get_history_level($transaction_id, $head_id, $order_by);

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

            case 'get_reseller_voucher_requests':
                $records = $_REQUEST;

                $member_id = $this->ion_auth_member->get_user_id();

                $requests = $this->Reseller_model->get_member_reseller_voucher_request_dtable($member_id);

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
                        $claim_status = 'PENDING';
                    }else{
                        $claim_status = 'PROCESSED';
                    }

                    $encashment_settings = $this->System_model->get_settings('encashment');

                    if($encashment_settings['active'] == 0){
                        $action = '<a href="javascript:;" id="cancel-request-button" onclick="cancelRequest();" data-ecash-id="'.$request[$i]->reseller_claims_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-remove"></i> Cancel Request</a>';
                    }else{
                        $action = '';
                    }

                    $head_info = $this->Heads_model->get_head($request[$i]->head_id);

                    if($request[$i]->trackingcode != null){
                        $trackingcode = $request[$i]->trackingcode;
                    }else{
                        $trackingcode = 'Tracking Code Not Available';
                    }

                    $records["data"][] = array(
                        $trackingcode,
                        $request[$i]->daterequested,
                        $request[$i]->dateprocessed,
                        $head_info->headname,
                        $claim_status,
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

            case 'cancel-reseller-voucher-request':
                $reseller_claims_id = $this->input->post('reseller_claims_id');
                $member_id = $this->ion_auth_member->get_user_id();

                #get encashment request info
                $request_info = $this->Reseller_model->get_reseller_voucher_request($reseller_claims_id);

                if(!empty($request_info)){
                    
                    #update reseller
                    $reseller_data['head_id'] = $request_info->head_id;
                    $reseller_data['gc_available'] = 1;
                    
                    $this->Reseller_model->update_reseller($reseller_data);
                    
                    #delete in reseller_claims
                    $this->Reseller_model->remove_reseller_voucher_request($reseller_claims_id);

                }

                $data['status'] = 'success';
                $data['msg'] = 'Reseller voucher request cancelled successfully';

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Reseller voucher request cancelled successfully';

                $this->session->set_flashdata('message', $printed_message); 

                #log action
                logger('cancel_reseller_voucher_request', $member_id, 'members', 'User %username% cancelled reseller voucher request');                 

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;            
        }
    }

    #callbacks
    public function verify_amount(){
        $head_id = $this->session->userdata('wallet_head_id');

        $amount = $this->input->post('amount');

        $member_id = $this->ion_auth_member->get_user_id();

        $head_info = $this->Heads_model->get_head($head_id);

        if(is_numeric($amount)){
            if($head_info->member_id == $member_id){
                if($head_info->total_income >= $amount){
                    return true;
                }else{
                    $this->form_validation->set_message('verify_amount', 'Your current total income is not enough');
                    return false;            
                }
            }else{
                $this->form_validation->set_message('verify_amount', 'This is not your account!');
                return false;
            }
        }else{
            $this->form_validation->set_message('verify_amount', 'Please enter a valid amount');
            return false;            
        }
    }

    public function verify_star(){
        $head_id = $this->session->userdata('star_wallet_head_id');

        $stars = $this->input->post('stars');

        $member_id = $this->ion_auth_member->get_user_id();

        $head_info = $this->Heads_model->get_head($head_id);
        $gold_info = $this->Heads_model->get_gold_count_by_head($head_id);

        if(is_numeric($stars)){
            if($head_info->member_id == $member_id){

                if($gold_info->stars >= $stars){
                    return true;
                }else{
                    $this->form_validation->set_message('verify_star', 'Your current total stars is not enough');
                    return false;            
                }

            }else{
                $this->form_validation->set_message('verify_star', 'This is not your account!');
                return false;
            }
        }else{
            $this->form_validation->set_message('verify_star', 'Please enter a valid stars to be transferred');
            return false;            
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
}