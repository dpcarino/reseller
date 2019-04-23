<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requests extends CI_Controller {

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
    }

    public function request_encashment(){
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
                    $memberhead_details_info = $this->Members_model->get_member_details($member_id);

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $encashment_settings = $this->System_model->get_settings('encashment');
                    
                    if($encashment_settings['active'] == 0){
                        $member_request_info = $this->Encashment_model->get_member_encashment_request($member_id);
                    }else{
                        $member_request_info = array();
                    }

                    $member_pin_info = $this->Members_model->get_member($member_id);
                    $member_details_info = $this->Members_model->get_member_details($member_id);

                    $data['heads'] = $heads;
                    $data['memberhead_info'] = $memberhead_info;
                    $data['memberhead_details_info'] = $memberhead_details_info;
                    $data['member_wallet_info'] = $member_wallet_info;
                    $data['member_request_info'] = $member_request_info;
                    $data['member_pin_info'] = $member_pin_info;
                    $data['member_details_info'] = $member_details_info;

                    $data['encashment_settings'] = $encashment_settings;

                    $this->form_validation->set_rules('amount', 'Amount', 'trim|required|callback_verify_minimum');
                    $this->form_validation->set_rules('request_type', 'Request Type', 'trim|required');
                    $this->form_validation->set_rules('security_pin', 'Security Pin', 'trim|required|callback_verify_security_pin');

                    if ($this->form_validation->run() == FALSE){
                    
                    }else{
                        $amount         = xss_clean($this->input->post('amount'));
                        $request_type   = xss_clean($this->input->post('request_type'));

                        switch ($request_type) {
                            case 'BANK':
                                $tax = $amount * $encashment_settings['tax'];
                                $payout = $amount - $tax;                        
                            break;

                            case 'CHEQUE':
                                $tax = $amount * $encashment_settings['tax'];
                                $payout = $amount - $tax;                        
                            break;                     

                            case 'PRODUCT':
                                $tax = 0;
                                $payout = $amount - $tax;                        
                            break;
                        }

                        #add to encashments
                        $encash_data['member_id'] = $member_id;
                        $encash_data['request_type'] = $request_type;
                        $encash_data['amount'] = $amount;
                        $encash_data['ip_address'] = $this->input->ip_address();
                        $encash_data['tax'] = $tax;
                        $encash_data['payout'] = $payout;
                        $encash_data['daterequested'] = date('Y-m-d H:i:s');

                        $this->Encashment_model->insert_encashment_request($encash_data);

                        #update wallet
                        $update_wallet_amount = $member_wallet_info->amount - $amount; 

                        $wallet_data['member_id'] = $member_id;
                        $wallet_data['amount'] = $update_wallet_amount;

                        $this->Members_model->update_member_wallet($wallet_data);

                        $printed_message['type'] = 'success';
                        $printed_message['message'] = 'Successfully requested for encashment';

                        $this->session->set_flashdata('message', $printed_message);

                        #log action
                        logger('request_encashment', $member_id, 'members', 'User %username% requested encashment of '.$amount.'for '.$request_type.' request. Current Wallet is '.$update_wallet_amount);

                        redirect('request/encashment');
                    }

                    $this->load->view('member-encashment-request-tpl', $data);
                }
            }
        }
    }

    public function request_rewards(){
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
                    $memberhead_details_info = $this->Members_model->get_member_details($member_id);

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $encashment_settings = $this->System_model->get_settings('encashment');
                    
                    if($encashment_settings['active'] == 0){
                        $member_request_info = $this->Encashment_model->get_member_encashment_request($member_id);
                    }else{
                        $member_request_info = array();
                    }

                    $rewards = $this->Rewards_model->get_all_rewards();

                    $member_pin_info = $this->Members_model->get_member($member_id);
                    $member_details_info = $this->Members_model->get_member_details($member_id);

                    $data['rewards'] = $rewards;
                    $data['heads'] = $heads;
                    $data['memberhead_info'] = $memberhead_info;
                    $data['memberhead_details_info'] = $memberhead_details_info;
                    $data['member_star_wallet_info'] = $member_star_wallet_info;
                    $data['member_request_info'] = $member_request_info;
                    $data['member_pin_info'] = $member_pin_info;
                    $data['member_details_info'] = $member_details_info;

                    $data['encashment_settings'] = $encashment_settings;

                    $this->form_validation->set_rules('reward', 'Reward', 'trim|required');
                    $this->form_validation->set_rules('security_pin', 'Security Pin', 'trim|required|callback_verify_security_pin');

                    if ($this->form_validation->run() == FALSE){

                    }else{

                        $reward_id   = xss_clean($this->input->post('reward'));
                        $reward_info = $this->Rewards_model->get_reward($reward_id);

                        $claim_data['member_id'] = $member_id;
                        $claim_data['reward_id'] = $reward_id;
                        $claim_data['stars_used'] = $reward_info->stars_required;
                        $claim_data['ip_address'] = $this->input->ip_address();
                        $claim_data['daterequested'] = date('Y-m-d H:i:s');

                        $this->Rewards_model->insert_claim_request($claim_data);

                        #update star wallet
                        $update_wallet_stars = $member_star_wallet_info->stars - $reward_info->stars_required; 

                        $wallet_data['member_id'] = $member_id;
                        $wallet_data['stars'] = $update_wallet_stars;

                        $this->Members_model->update_member_star_wallet($wallet_data);

                        $printed_message['type'] = 'success';
                        $printed_message['message'] = 'Successfully requested for rewards claim';

                        $this->session->set_flashdata('message', $printed_message);

                        #log action
                        logger('request_rewards', $member_id, 'members', 'User %username% requested reward of '.$reward_info->reward. 'for '.$reward_info->stars_required.'. Current Star Wallet is '.$update_wallet_stars);                

                        redirect('request/rewards');
                    }

                    $this->load->view('member-reward-request-tpl', $data);
                }
            }
        }
    }

    public function encashment_history(){
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

                    $this->load->view('member-encashment-history-tpl', $data);
                }
            }
        }
    }

    public function claim_history(){
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

                    $this->load->view('member-claim-history-tpl', $data);
                }
            }
        }
    }

    public function ajax($section){

        switch ($section) {
            case 'get_current_encashment_request':
                $records = $_REQUEST;

                $member_id = $this->ion_auth_member->get_user_id();

                $requests = $this->Encashment_model->get_member_encashment_request_dtable($member_id);

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

                    if($request[$i]->encashment_status == 0){                        
                        $encashment_status = 'PENDING';
                    }else{
                        $encashment_status = 'PROCESSED';
                    }

                    $encashment_settings = $this->System_model->get_settings('encashment');

                    if($encashment_settings['active'] == 0){
                        $action = '<a href="javascript:;" id="cancel-request-button" onclick="cancelRequest();" data-ecash-id="'.$request[$i]->encashment_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-remove"></i> Cancel Request</a>';
                    }else{
                        $action = '';
                    }


                    $records["data"][] = array(
                        $request[$i]->daterequested,
                        $request[$i]->request_type,
                        $request[$i]->amount,
                        $request[$i]->tax,
                        $request[$i]->payout,
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

            case 'get_current_claim_request':
                $records = $_REQUEST;

                $member_id = $this->ion_auth_member->get_user_id();

                $requests = $this->Rewards_model->get_member_claim_request_dtable($member_id);

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

            case 'cancel-encashment-request':
                $encashment_id = $this->input->post('encashment_id');
                $member_id = $this->ion_auth_member->get_user_id();

                #get encashment request info
                $request_info = $this->Encashment_model->get_encashment_request($encashment_id);

                if(!empty($request_info)){
                    
                    #update wallet 
                    $member_wallet_info = $this->Members_model->get_member_wallet($member_id);

                    $wallet_amount = $member_wallet_info->amount + $request_info->amount;

                    $wallet_data['member_id'] = $member_id;
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
                logger('cancel_encashment_request', $member_id, 'members', 'User %username% cancelled encashment request');                 

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'cancel-claim-request':
                $reward_claims_id = $this->input->post('reward_claims_id');
                $member_id = $this->ion_auth_member->get_user_id();

                #get encashment request info
                $request_info = $this->Rewards_model->get_claim_request($reward_claims_id);

                if(!empty($request_info)){
                    
                    #update wallet 
                    $member_star_wallet_info = $this->Members_model->get_member_star_wallet($member_id);

                    $star_wallet_amount = $member_star_wallet_info->stars + $request_info->stars_used;

                    $wallet_data['member_id'] = $member_id;
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
                logger('cancel_claim_request', $member_id, 'members', 'User %username% cancelled claim request');                 

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'get_encashment_history':
                $records = $_REQUEST;

                $member_id = $this->ion_auth_member->get_user_id();

                $histories = $this->Encashment_model->get_encashment_history($member_id);

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

                    if($history[$i]->encashment_status == 0){                        
                        $encashment_status = 'PENDING';
                    }else{
                        $encashment_status = 'PROCESSED';
                    }

                    $records["data"][] = array(
                        $history[$i]->trackingcode,
                        $history[$i]->daterequested,
                        $history[$i]->dateprocessed,
                        $history[$i]->request_type,
                        $history[$i]->amount,
                        $history[$i]->tax,
                        $history[$i]->payout,
                        $encashment_status,
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

            case 'get_claim_history':
                $records = $_REQUEST;

                $member_id = $this->ion_auth_member->get_user_id();

                $histories = $this->Rewards_model->get_member_claim_history_dtable($member_id);

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

                    if($history[$i]->claim_status == 0){                        
                        $encashment_status = 'PENDING';
                    }else{
                        $encashment_status = 'PROCESSED';
                    }

                    $reward_info = $this->Rewards_model->get_reward($history[$i]->reward_id);

                    $records["data"][] = array(
                        $history[$i]->trackingcode,
                        $history[$i]->daterequested,
                        $history[$i]->dateprocessed,
                        $reward_info->reward,
                        $history[$i]->stars_used,
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

    #callbacks
    public function verify_minimum($amount){

        $encashment_settings = $this->System_model->get_settings('encashment');
        $member_id = $this->ion_auth_member->get_user_id();

        $member_wallet_info = $this->Members_model->get_member_wallet($member_id);

        if($amount > $member_wallet_info->amount){
            $this->form_validation->set_message('verify_minimum', 'Your current wallet is not enough');
            return false;            
        }else{
            if(is_numeric($amount)){
                if($amount < $encashment_settings['minimum_request']){
                    $this->form_validation->set_message('verify_minimum', 'Invalid amount, minimum encashment request is '.$encashment_settings['minimum_request']);
                    return false;                
                }else{
                    return true;
                }
            }else{
                $this->form_validation->set_message('verify_minimum', 'Please enter a valid amount');
                return false;            
            }
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