<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

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
        $this->load->model('Reseller_model');
    }

	public function index(){
		
        $data = array();

        $maintenance_settings = $this->System_model->get_settings('maintenance');

        if($maintenance_settings['active'] == 0){
    		if (!$this->ion_auth_member->logged_in() || $this->session->userdata('user_type') != 'member')
            {
                // redirect them to the login page
                $this->ion_auth_member->logout();
                redirect('login', 'refresh');
            }else{
            	
        		redirect('dashboard', 'refresh');
        	}
        }else{
            redirect('maintenance', 'refresh');
        }
	}

    public function maintenance(){

        $data = array();

        $maintenance_settings = $this->System_model->get_settings('maintenance');

        if($maintenance_settings['active'] == 0){
            redirect('login', 'refresh');
        }else{

            $data['maintenance_settings'] = $maintenance_settings;

            $this->load->view('maintenance-tpl', $data);
        }
    }

    public function blocked(){

        $data = array();

        $member_id = $this->ion_auth_member->get_user_id();

        $user = $this->ion_auth_member->user()->row();

        if(isset($user) && $user->blocked == 1){
            // redirect('blocked', 'refresh');
            // exit;

            $data['member_info'] =  $this->Members_model->get_member($member_id);
            $data['member_details'] = $this->Members_model->get_member_details($member_id);

            $this->load->view('blocked-tpl', $data);

        }else{
            redirect('/');
        }
    }    

    public function activate($activation_code, $temp_password_url = false){

        $data = array();

        $maintenance_settings = $this->System_model->get_settings('maintenance');

        if($maintenance_settings['active'] == 0){

            $data['activation_code'] = $activation_code;
            $data['temp_password_url'] = $temp_password_url;

            $member_info = $this->Members_model->get_member_by_activation_code($activation_code);

            if(empty($member_info)){

                $printed_message['type'] = 'error';
                $printed_message['message'] = 'Invalid Activation Code';

                $this->session->set_flashdata('message', $printed_message);

                redirect('login');
            }else{
                
                $this->form_validation->set_rules('temp_password', 'Temporary Password', 'trim|required|callback_verify_temp_password');
                $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]');
                $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[new_password]');
                
                if ($this->form_validation->run() == FALSE){

                }else{
                    $new_password     = xss_clean($this->input->post('new_password'));            

                    $member_data = array(
                            'activation_code' => '',
                            'active' => 1,
                            'dateactivated' => date('Y-m-d H:i:s'),
                            'password' => $new_password,
                             );

                    $this->ion_auth_member->update($member_info->member_id, $member_data);

                    $printed_message['type'] = 'success';
                    $printed_message['message'] = 'Account Successfully Activated';

                    $this->session->set_flashdata('message', $printed_message);

                    #log action
                    logger('activate', $member_info->member_id, 'members', 'Account %username% Successfully Activated');

                    redirect('login');
                }
            }

            $this->load->view('member-activate-tpl', $data);

        }else{
            redirect('maintenance', 'refresh');
        }
    }

    public function forgot_password($forgot_code = ''){

        $data = array();

        $maintenance_settings = $this->System_model->get_settings('maintenance');

        if($maintenance_settings['active'] == 0){
            if($forgot_code == ''){

                $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_verify_username');

                if ($this->form_validation->run() == FALSE){
                
                }else{

                    $username = xss_clean($this->input->post('username'));

                    $member_info = $this->Members_model->get_member_by_username($username);

                    if(!empty($member_info)){

                        #generate forgot code 
                        $forgotten_password_code = generate_code();

                        $member_data = array(
                                'forgotten_password_code' => $forgotten_password_code,
                                 );

                        $this->ion_auth_member->update($member_info->member_id, $member_data);

                        #send forgot email
                        sendForgotEmail($member_info->member_id, $forgotten_password_code);
                        #end sending email

                        $email_part = explode("@",$member_info->email);

                        $printed_message['type'] = 'success';
                        $printed_message['message'] = 'Email sent to '.mask_characters($email_part[0])."@".$email_part[1];

                        $this->session->set_flashdata('message', $printed_message);

                        #log action
                        logger('forgot_password', $member_info->member_id, 'members', 'Email sent to '.mask_characters($email_part[0])."@".$email_part[1].' for %username%');

                        redirect('login');

                    }

                }            

                $this->load->view('member-forgot-tpl', $data);
            }else{

                $data = array();

                $data['forgot_code'] = $forgot_code;

                $member_info = $this->Members_model->get_member_by_forgot_code($forgot_code);

                $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]');
                $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[new_password]');
                
                if ($this->form_validation->run() == FALSE){

                }else{
                    $new_password     = xss_clean($this->input->post('new_password'));            

                    $member_data = array(
                            'forgotten_password_code' => '',
                            'password' => $new_password,
                             );

                    $this->ion_auth_member->update($member_info->member_id, $member_data);

                    $printed_message['type'] = 'success';
                    $printed_message['message'] = 'Successfully Updated Password';

                    $this->session->set_flashdata('message', $printed_message);

                    redirect('login');
                }            

                $this->load->view('member-forgot-process-tpl', $data);
            }
        }else{
            redirect('maintenance', 'refresh');
        }            
    }

	public function dashboard(){

		$data = array();    

        $user = $this->ion_auth_member->user()->row();

        if(isset($user) && $user->blocked == 1){
            redirect('blocked', 'refresh');
            exit;
        }else{

            $this->session->unset_userdata('bank_info_css');
            $this->session->unset_userdata('valid_photo_css');
            $this->session->unset_userdata('change_password_css');
            $this->session->unset_userdata('security_pin_css');
            $this->session->unset_userdata('personal_info_css');
            
            $maintenance_settings = $this->System_model->get_settings('maintenance');

            if($maintenance_settings['active'] == 0){        

        		if (!$this->ion_auth_member->logged_in() || $this->session->userdata('user_type') != 'member')
                {
                    // redirect them to the login page
                    $this->ion_auth_member->logout();
                    redirect('login', 'refresh');
                }else{
                	$member_id = $this->ion_auth_member->get_user_id();

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $member_star_wallet_info = $this->Members_model->get_member_star_wallet($member_id);
                    
                    $announcements = $this->Announcement_model->get_announcements();
                    $rewards = $this->Rewards_model->get_rewards();

                    $paid_codes = $this->Codes_model->get_all_paid_codes_by_member($member_id);
                    $cd_codes = $this->Codes_model->get_all_cd_codes_by_member($member_id);

                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $data['heads'] = $heads;
                    $data['announcements'] = $announcements;
                    $data['rewards'] = $rewards;
                    $data['current_head'] = $head;
                    $data['paid_codes_count'] = count($paid_codes);
                    $data['cd_codes_count'] = count($cd_codes);
                    $data['memberhead_info'] = $memberhead_info;
                    $data['member_star_wallet_info'] = $member_star_wallet_info;
					
					#buboy 2019-04-26
					#Add member codes summary to dashboard
					$available_codes = $this->Members_model->get_available_codes_count($member_id);
					$data['available_codes'] = $available_codes;
					
					#buboy 2019-04-26
					#for leaderboards
					$leaderboards = $this->Members_model->get_leaderboards();
					$data['leaderboards'] = $leaderboards;

            		$this->load->view('member-home-tpl', $data);
            	}

            }else{
                redirect('maintenance', 'refresh');
            }
        }            
	}

	public function login(){
		$data = array();

        $maintenance_settings = $this->System_model->get_settings('maintenance');
      
        if($maintenance_settings['active'] == 0){

    		if (!$this->ion_auth_member->logged_in() || $this->session->userdata('user_type') != 'member')
            {
    			//validate form input
    			$this->form_validation->set_rules('email', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
    			$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

    			if ($this->form_validation->run() == true)
    			{
    				// check to see if the user is logging in
    				// check for "remember me"
    				$remember = (bool) $this->input->post('remember');         

    				if ($this->ion_auth_member->login($this->input->post('email'), $this->input->post('password'), $remember))
    				{
    					//if the login is successful
    					//redirect them back to the home page
    					if($this->session->userdata('page_url')){
    						redirect($this->session->userdata('page_url'));
    					}else{
                            $member_id = $this->ion_auth_member->get_user_id();

                            $member_detail_info = $this->Members_model->get_member_details($member_id);

                            $head_info = $this->Heads_model->get_top_head($member_id);

                            $printed_message['type'] = 'success';
                            $printed_message['message'] = 'Welcome Back '.$member_detail_info->first_name;

                            $this->session->set_flashdata('message', $printed_message);                         

                            $this->session->set_userdata('current_head', $head_info->headname);

                            #error_log(print_r(session_id(), true), 0);

                            #log action
                            logger('login', $member_id, 'members', 'User %username% successfully logged in');
                            
                            #check if user is blocked

                            $member_info = $this->Members_model->get_member($member_id);

                            if($member_info->blocked == 1){
                                redirect('blocked', 'refresh');
                            }else{
                                redirect('dashboard', 'refresh');
                            }
    					}
    				}
    				else
    				{
    					// if the login was un-successful
    					// redirect them back to the login page
    					$this->session->set_flashdata('message', $this->ion_auth_member->errors());
    					redirect('login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
    				}

    			}else{
    				// the user is not logging in so display the login page
    				// set the flash data error message if there is one
    				$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
    				$this->load->view('member-login-tpl', $data);
    			}
    		}else{
    			$this->session->set_flashdata('message', $this->ion_auth_member->messages());

                $member_id = $this->ion_auth_member->get_user_id();

                $head_info = $this->Heads_model->get_top_head($member_id);

                $this->session->set_userdata('current_head', $head_info->headname);

                redirect('dashboard', 'refresh');
    		}
        }else{
            redirect('maintenance', 'refresh');
        }
	}

    public function add_heads(){
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
                    $head = $this->session->userdata('current_head');

                    #buboy 2019-03-21
                    #change Mysql view
                    #$memberhead_info = $this->Members_model->get_member_view_info_by_head($head);					
					$memberdetails_info = $this->Members_model->get_member_details_info_by_memberid($user->member_id);
					 
                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $head_ids = array();
                    $head_ids_available = array();

                    $member_heads = $this->Members_model->get_member_heads($member_id);
					
					#buboy 2019-04-01
                    #generate avilable codes count
                    $available_codes = $this->Members_model->get_available_codes_count($member_id);
					$data['available_codes'] = $available_codes;

                    foreach($member_heads as $member_head){
                        array_push($head_ids, $member_head->head_id);
                    }

                    while (!empty($head_ids)) {
                        $current = array_shift($head_ids);

                        #error_log(print_r($current, true), 0);

                        $downlines = $this->Members_model->get_downlines($current);

                        if(empty($downlines)){
                            if(!in_array($current, $head_ids_available)){
                                array_push($head_ids_available, $current);
                            }                    
                        }else{
                            foreach($downlines as $downline){

                                #error_log(print_r(count($downlines), true), 0);
                                if(count($downlines) == 2){
                                    #error_log(print_r($downline->head_id, true), 0);
                                    array_push($head_ids, $downline->head_id);
                                }else{

                                    if(count($downlines) == 1){
                                        array_push($head_ids, $downline->head_id);
                                    }
                                                                        
                                    if(!in_array($downline->upline_id, $head_ids_available)){
                                        array_push($head_ids_available, $downline->upline_id);
                                    }
                                }
                            }                     
                        }
                       
                    }

                    #generate list of heads
                    $available_uplines = $this->Members_model->get_head_list($head_ids_available);
                   
                    $member_setting = $this->Settings_model->get_setting_member($memberdetails_info->member_status);

                    $packages = $this->Packages_model->get_packages();
                    
                    $data['packages'] = $packages;
                    $data['available_uplines'] = $available_uplines;
                    $data['current_head'] = $head;
                    #buboy 2019-03-31
                    #fix member_all
                    #$data['memberhead_info'] = $memberhead_info;
                    $data['memberdetails_info'] = $memberdetails_info;
                    $data['heads'] = $heads;
                    $data['member_setting'] = $member_setting;
                    $data['head_count'] = count($heads);

                    $this->form_validation->set_rules('code_available', 'Code', 'trim|required|callback_check_code');
                    $this->form_validation->set_rules('sponsor_id', 'Sponsor', 'trim|required');
                    $this->form_validation->set_rules('upline_placement_position', 'Upline Placement Position', 'trim|required');
                    $this->form_validation->set_rules('upline_pos', 'Placement Position', 'trim|required');
                    $this->form_validation->set_rules('package_id', 'Entry Code Package', 'trim|required');


                    if ($this->form_validation->run() == FALSE){

                    }else{
                        $sponsor_id                 = xss_clean($this->input->post('sponsor_id'));
                        $upline_placement_position  = xss_clean($this->input->post('upline_placement_position'));
                        $upline_pos                 = xss_clean($this->input->post('upline_pos'));
                        $package_id                 = xss_clean($this->input->post('package_id'));
                        $code_available             = xss_clean($this->input->post('code_available'));

                        #update code to used
                        $code_info = $this->Codes_model->get_code_by_code($code_available);

                        if(!empty($code_info)){
                            
                            if($code_info->used_by != 0 && $code_info->status == 1){

                            }else{

                                $code_data['code_id'] = $code_info->code_id;
                                $code_data['used_by'] = $member_id;
                                $code_data['used_to'] = $member_id;
                                $code_data['dateused'] = date('Y-m-d H:i:s');
                                $code_data['status'] = 1;

                                $this->Codes_model->update_code($code_data);                        

                            }
                        }

                        $member_heads_count = count($member_heads) + 1;

                        $member_info = $this->Members_model->get_member($member_id);

                        $username = $member_info->username;

                        $member_head_padded = sprintf('%02d', $member_heads_count);

                        #insert to heads
                        $head_data['member_id'] = $member_id;
                        $head_data['headname'] = 'GE'.$username.$member_head_padded;
                        $head_data['created_on'] = date('Y-m-d H:i:s');
                        $head_data['knight_start_date'] = date('Y-m-d H:i:s');
                        $head_data['sponsor_id'] = $sponsor_id;
                        $head_data['upline_id'] = $upline_placement_position;
                        $head_data['upline_pos'] = $upline_pos;

                        $package_info = $this->Packages_model->get_package($package_id);

                        if($package_id == 6){ //knight40k
                            $head_data['account_status'] = 1;
                            $head_data['knight_date'] = date('Y-m-d H:i:s');
                            $head_data['knight_status'] = 1;
                        }else{
                            $head_data['account_status'] = 0;
                            $head_data['knight_date'] = '0000-00-00 00:00:00';
                            $head_data['knight_status'] = 0;
                        }

                        if($package_id == 5){//paylite
                            $head_data['is_paylite'] = 1;
                        }else{
                            $head_data['is_paylite'] = 0;
                        }

                        if($package_info->is_cd == 1){
                            $code_type = 0;
                        }else{
                            $code_type = 1;
                        }

                        $head_data['account_status'] = $code_type;

                        if($code_type == 0){
                            if($package_info->cd_value != '0.00'){
                                $head_data['cd_balance'] = $package_info->cd_value;
                            }else{
                                $head_data['cd_balance'] = '12888.00';
                            }
                        }
                        
                        $new_head_id = $this->Heads_model->insert_head($head_data);

                        if($package_id == 9){ //reseller
                            $reseller_data['head_id'] = $new_head_id;
                            $reseller_data['gc_available'] = 1;
                            $reseller_data['is_reseller'] = 1;

                            $this->Reseller_model->insert_reseller($reseller_data);
                        }else{
                            
                            $reseller_data['head_id'] = $new_head_id;

                            $this->Reseller_model->insert_reseller($reseller_data);
                        }

                        #insert to gold count
                        $gold_data['head_id'] = $new_head_id;

                        $this->Heads_model->insert_gold_count($gold_data);


                        if($code_type == 0){

                            if($package_id == 5){
                                $result_addSponsor = $this->Members_model->execPayLiteAddSponsor($sponsor_id, $new_head_id);
                            }else{                            
                                $result_addSponsor = $this->Members_model->execCDAddSponsor($sponsor_id);
                            }

                        }elseif($code_type == 1){

                            if($package_id == 9){
                                $result_addSponsor = $this->Reseller_model->execResellerAddSponsor($sponsor_id);
                            }else{
                                $result_addSponsor = $this->Members_model->execGoldAddSponsor($sponsor_id);
                            }

                        }


                        if($code_type == 0){

                            $result_awardGSC = $this->Members_model->execCDAwardGSC($new_head_id);

                        }elseif($code_type == 1){

                            if($package_id == 9){
                                // error_log(print_r('execResellerAwardGSC', true), 0);
                                $result_awardGSC = $this->Reseller_model->execResellerAwardGSC($new_head_id);
                            }else{
                                // error_log(print_r('execGoldAwardGSC', true), 0);
                                // error_log(print_r($new_head_id, true), 0);
                                $result_awardGSC = $this->Members_model->execGoldAwardGSC($new_head_id);
                            }
                        }   

                        $printed_message['type'] = 'success';
                        $printed_message['message'] = 'Successfully added new Head';

                        $this->session->set_flashdata('message', $printed_message);

                        #log action
                        logger('add_heads', $member_id, 'members', '%username% successfully added head '.$head_data['headname'].' using code '.$code_available);                

                        redirect('dashboard');
                    }

                    $this->load->view('member-add-head-tpl', $data);
                }
            }
        }
    }

	public function add(){
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

                    #error_log(print_r($memberhead_info, true), 0);

                    $data['memberhead_info'] = $memberhead_info;

                    $head_ids = array();
                    $head_ids_available = array();

                    $member_id = $this->ion_auth_member->get_user_id();

                    $member_heads = $this->Members_model->get_member_heads($member_id);
					
					#buboy 2019-04-01
                    #generate avilable codes count
                    $available_codes = $this->Members_model->get_available_codes_count($member_id);
                    $data['available_codes'] = $available_codes;

                    #$downlines = $this->Members_model->get_downlines($member_head->head_id);
                    #error_log(print_r($member_heads, true), 0);

                    foreach($member_heads as $member_head){
                        array_push($head_ids, $member_head->head_id);
                    }

                    while (!empty($head_ids)) {
                        $current = array_shift($head_ids);

                        #error_log(print_r($current, true), 0);

                        $downlines = $this->Members_model->get_downlines($current);

                        #error_log(print_r($downlines, true), 0);

                        if(empty($downlines)){
                            if(!in_array($current, $head_ids_available)){
                                array_push($head_ids_available, $current);
                            }                    
                        }else{
                            #error_log(print_r($head_ids_available, true), 0);
                            foreach($downlines as $downline){

                                #error_log(print_r($downline, true), 0);
                                #error_log(print_r(count($downlines), true), 0);
                                if(count($downlines) == 2){
                                    #error_log(print_r($downline->head_id, true), 0);
                                    array_push($head_ids, $downline->head_id);
                                }else{
                                    if(count($downlines) == 1){
                                        array_push($head_ids, $downline->head_id);
                                    }

                                    if(!in_array($downline->upline_id, $head_ids_available)){
                                        array_push($head_ids_available, $downline->upline_id);
                                    }
                                }
                            }                     
                        }
                       
                    }

                    #error_log(print_r($head_ids_available, true), 0);
                    #generate list of heads
                    $available_uplines = $this->Members_model->get_head_list($head_ids_available);

                    $data['available_uplines'] = $available_uplines;

                    $cities = $this->Settings_model->get_all_cities();
                    $provinces = $this->Settings_model->get_all_provinces();
                    $citizenships = $this->Settings_model->get_all_citizenships();
                    
                    $packages = $this->Packages_model->get_packages();

                    $data['cities'] = $cities;
                    $data['provinces'] = $provinces;
                    $data['citizenships'] = $citizenships;
                    $data['packages'] = $packages;

                    $data['first_name'] = '';
                    $data['middle_name'] = '';
                    $data['last_name'] = '';
                    $data['citizenship'] = '';
                    $data['dob'] = '';
                    $data['pob'] = '';
                    $data['civil_status'] = '';
                    $data['tin_number'] = '';
                    $data['telephone'] = '';
                    $data['mobile'] = '';
                    $data['email'] = '';
                    $data['address'] = '';
                    $data['city'] = '';
                    $data['province'] = '';
                    $data['desired_username'] = '';
                    
                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $data['current_head'] = $head;
                    $data['heads'] = $heads;

                    $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
                    $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
                    $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
                    $this->form_validation->set_rules('pob', 'Place of Birth', 'trim|required');
                    $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|numeric');
                    $this->form_validation->set_rules('address', 'Address', 'trim|required');
                    $this->form_validation->set_rules('province', 'Province', 'trim|required');
                    $this->form_validation->set_rules('code_available', 'Code', 'trim|required|callback_check_code');
                    $this->form_validation->set_rules('desired_username', 'Desired Username', 'trim|required|alpha_dash|callback_check_member_username');
                    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_member_email');
                    #$this->form_validation->set_rules('authorized_id_img_1', 'Member Photo', 'callback_file_check_authorized_id_img_1');

                    $this->form_validation->set_rules('upline_placement_position', 'Upline Placement Position', 'trim|required');
                    $this->form_validation->set_rules('upline_pos', 'Placement Position', 'trim|required');
                    $this->form_validation->set_rules('package_id', 'Entry Code Package', 'trim|required');

                    if ($this->form_validation->run() == FALSE){

                        $data['first_name'] = $this->input->post('first_name');
                        $data['middle_name'] = $this->input->post('middle_name');
                        $data['last_name'] = $this->input->post('last_name');
                        $data['citizenship'] = $this->input->post('citizenship');
                        $data['dob'] = $this->input->post('dob');
                        $data['pob'] = $this->input->post('pob');
                        $data['civil_status'] = $this->input->post('civil_status');
                        $data['tin_number'] = $this->input->post('tin_number');
                        $data['telephone'] = $this->input->post('telephone');
                        $data['mobile'] = $this->input->post('mobile');
                        $data['email'] = $this->input->post('email');
                        $data['address'] = $this->input->post('address');
                        $data['city'] = $this->input->post('city');
                        $data['province'] = $this->input->post('province');
                        $data['desired_username'] = $this->input->post('desired_username');

                    }else{

                        $first_name     = xss_clean($this->input->post('first_name'));
                        $middle_name    = xss_clean($this->input->post('middle_name'));
                        $last_name      = xss_clean($this->input->post('last_name'));
                        $citizenship    = xss_clean($this->input->post('citizenship'));
                        $dob            = xss_clean($this->input->post('dob'));
                        $pob            = xss_clean($this->input->post('pob'));
                        $civil_status   = xss_clean($this->input->post('civil_status'));
                        $tin_number     = xss_clean($this->input->post('tin_number'));
                                        

                        $telephone      = xss_clean($this->input->post('telephone'));
                        $mobile         = xss_clean($this->input->post('mobile'));
                        $email          = xss_clean($this->input->post('email'));
                        
                        $address        = xss_clean($this->input->post('address'));
                        $city           = xss_clean($this->input->post('city'));
                        $province       = xss_clean($this->input->post('province'));

                        $upline_placement_position  = xss_clean($this->input->post('upline_placement_position'));
                        $upline_pos                 = xss_clean($this->input->post('upline_pos'));
                        $package_id                 = xss_clean($this->input->post('package_id'));
                        $code_available             = xss_clean($this->input->post('code_available'));

                        $desired_username           = xss_clean($this->input->post('desired_username'));

                        $profile_chk_1 = 0;
                        $profile_chk_2 = 0;
                        #member photo
                        if ($_FILES['authorized_id_img_1']['name'] != '') {
                            $authorized_id_img_1 = $this->upload_image('uploads/members/image', 'authorized_id_img_1');

                            $profile_chk_1 = 1;
                        }else{
                            $profile_chk_1 = 1;
                            $authorized_id_img_1 = '';
                        }

                        #valid id
                        if ($_FILES['authorized_id_img_2']['name'] != '') {
                            $authorized_id_img_2 = $this->upload_image('uploads/members/valid_id', 'authorized_id_img_2');

                            $profile_chk_2 = 1;
                        }else{
                            $authorized_id_img_2 = '';
                        }

                        #generate username
                        $username = $desired_username;
                        $password = generate_random_password();
                        $group = array();

                        #generate activation code 
                        $activation_code = generate_code();

                        $additional_data = array(
                            'activation_code' => $activation_code,
                            'group_id' => 3,
                        );                
                        
                        $new_member_id = $this->ion_auth_member->register($username, $password, $email, $additional_data, $group);

                        #update code to used
                        $code_info = $this->Codes_model->get_code_by_code($code_available);

                        if(!empty($code_info)){
                            
                            if($code_info->used_by != 0 && $code_info->status == 1){

                            }else{

                                $code_data['code_id'] = $code_info->code_id;
                                $code_data['used_by'] = $member_id;
                                $code_data['used_to'] = $new_member_id;
                                $code_data['dateused'] = date('Y-m-d H:i:s');
                                $code_data['status'] = 1;

                                $this->Codes_model->update_code($code_data);                        

                            }
                        }

                        #insert details in member details

                        $member_details_data['member_id'] = $new_member_id;
                        $member_details_data['first_name'] = ucfirst($first_name);
                        $member_details_data['middle_name'] = ucfirst($middle_name);
                        $member_details_data['last_name'] = ucfirst($last_name);
                        $member_details_data['dob'] = $dob;
                        $member_details_data['pob'] = $pob;
                        $member_details_data['citizenship'] = $citizenship;
                        $member_details_data['mobile'] = $mobile;
                        $member_details_data['telephone'] = $telephone;
                        $member_details_data['address'] = $address;
                        $member_details_data['city'] = $city;
                        $member_details_data['province'] = $province;
                        $member_details_data['tin_number'] = format_tin_number($tin_number);
                        $member_details_data['civil_status'] = $civil_status;
                        $member_details_data['authorized_id_img_1'] = $authorized_id_img_1;
                        $member_details_data['authorized_id_img_2'] = $authorized_id_img_2;

                        if($profile_chk_1 == 0 OR $profile_chk_2 == 0){
                            $member_details_data['is_profile_complete'] = 0; #not complete
                        }else{
                            $member_details_data['is_profile_complete'] = 1; #complete
                        }

                        $this->Members_model->insert_member_details($member_details_data);

                        #insert to member wallets
                        $member_wallet_data['member_id'] = $new_member_id;

                        $this->Members_model->insert_member_wallet($member_wallet_data);

                        $member_star_wallet_data['member_id'] = $new_member_id;

                        $this->Members_model->insert_member_star_wallet($member_star_wallet_data);                

                        #insert to heads
                        $head_data['member_id'] = $new_member_id;
                        $head_data['headname'] = 'GE'.$username.'01';
                        $head_data['created_on'] = date('Y-m-d H:i:s');
                        $head_data['knight_start_date'] = date('Y-m-d H:i:s');
                        $head_data['sponsor_id'] = $memberhead_info->head_id;
                        $head_data['upline_id'] = $upline_placement_position;
                        $head_data['upline_pos'] = $upline_pos;

                        $package_info = $this->Packages_model->get_package($package_id);

                        if($package_id == 6){ //knight40k
                            $head_data['account_status'] = 1;
                            $head_data['knight_date'] = date('Y-m-d H:i:s');
                            $head_data['knight_status'] = 1;
                        }else{
                            $head_data['account_status'] = 0;
                            $head_data['knight_date'] = '0000-00-00 00:00:00';
                            $head_data['knight_status'] = 0;
                        }

                        if($package_id == 5){ //paylite
                            $head_data['is_paylite'] = 1;
                        }else{
                            $head_data['is_paylite'] = 0;
                        }

                        if($package_info->is_cd == 1){
                            $code_type = 0;
                        }else{
                            $code_type = 1;
                        }

                        $head_data['account_status'] = $code_type;

                        if($code_type == 0){
                            if($package_info->cd_value != '0.00'){
                                $head_data['cd_balance'] = $package_info->cd_value;
                            }else{
                                $head_data['cd_balance'] = '12888.00';
                            }
                        }


                        $new_head_id = $this->Heads_model->insert_head($head_data);                        
                        
                        if($package_id == 9){ //reseller
                            $reseller_data['head_id'] = $new_head_id;
                            $reseller_data['gc_available'] = 1;
                            $reseller_data['is_reseller'] = 1;

                            $this->Reseller_model->insert_reseller($reseller_data);

                        }else{

                            $reseller_data['head_id'] = $new_head_id;

                            $this->Reseller_model->insert_reseller($reseller_data);
                        }

                        #insert to gold count
                        $gold_data['head_id'] = $new_head_id;

                        $this->Heads_model->insert_gold_count($gold_data);

                        if($code_type == 0){

                            if($package_id == 5){
                                $result_addSponsor = $this->Members_model->execPayLiteAddSponsor($memberhead_info->head_id, $new_head_id);
                            }else{                            
                                $result_addSponsor = $this->Members_model->execCDAddSponsor($memberhead_info->head_id);
                            }

                        }elseif($code_type == 1){

                            if($package_id == 9){
                                $result_addSponsor = $this->Reseller_model->execResellerAddSponsor($memberhead_info->head_id);
                            }else{
                                $result_addSponsor = $this->Members_model->execGoldAddSponsor($memberhead_info->head_id);
                            }
                        }


                        if($code_type == 0){

                            $result_awardGSC = $this->Members_model->execCDAwardGSC($new_head_id);

                        }elseif($code_type == 1){

                            if($package_id == 9){
                                $result_awardGSC = $this->Reseller_model->execResellerAwardGSC($new_head_id);
                            }else{
                                $result_awardGSC = $this->Members_model->execGoldAwardGSC($new_head_id);
                            }    
                        }                    

                        #send activation email
                        #if paylite send other email
                        if($package_id == 5){
                            sendPayliteActivationEmail($new_member_id, $username, $password);
                        }else{
                            sendActivationEmail($new_member_id, $username, $password);
                        }
                        #end sending email

                        $printed_message['type'] = 'success';
                        $printed_message['message'] = 'Successfully added new member, email will be sent to registered email';

                        $this->session->set_flashdata('message', $printed_message); 

                        #log action
                        logger('add_member', $member_id, 'members', '%username% successfully added member '.$username.' using code '.$code_available);                

                        redirect('dashboard');
                    }

                    $this->load->view('member-add-recruit-tpl', $data);
            	}
            }
        }
	}

    public function view_announcements(){
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

                    $announcements = $this->Announcement_model->get_all_announcements();

                    $data['memberhead_info'] = $memberhead_info;
                    $data['announcements'] = $announcements;
                                
                    $this->load->view('member-announcements-tpl', $data);
                }        
            }
        }
    }

    public function announcement_details($announcement_id){
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
                    
                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    $data['memberhead_info'] = $memberhead_info;


                    $announcement_info = $this->Announcement_model->get_announcement($announcement_id);
                    $data['member_star_wallet_info'] = $member_star_wallet_info;

                    $data['announcement_info'] = $announcement_info;
                                
                    $this->load->view('member-announcement-details-tpl', $data);            
                }
            }
        }
    }

    public function profile(){
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
                    
                    $head = $this->session->userdata('current_head');

                    $memberhead_info = $this->Members_model->get_member_view_info_by_head($head);

                    #buboy 2019-03-31
                    #change MySQL View
                    #$memberdetails_info = $this->Members_model->get_member_details_info_by_head($member_id);
					$memberdetails_info = $this->Members_model->get_member_details_info_by_memberid($member_id);

                    $heads = $this->Heads_model->get_member_heads($member_id);

                    $member_wallet_info = $this->Members_model->get_member_wallet($member_id);

                    $member_details_info = $this->Members_model->get_member_details($member_id);
                    $member_pin_info = $this->Members_model->get_member($member_id);

                    $cities = $this->Settings_model->get_all_cities();
                    $provinces = $this->Settings_model->get_all_provinces();
                    $citizenships = $this->Settings_model->get_all_citizenships();

                    $data['cities'] = $cities;
                    $data['provinces'] = $provinces;
                    $data['citizenships'] = $citizenships;            

                    $data['memberhead_info'] = $memberhead_info;
                    #buboy 2019-03-31
                    #fix member_all
                    $data['memberdetails_info'] = $memberdetails_info;
                    $data['member_wallet_info'] = $member_wallet_info;
                    $data['member_star_wallet_info'] = $member_star_wallet_info;
                    $data['heads'] = $heads;
                    $data['member_details_info'] = $member_details_info;
                    $data['member_pin_info'] = $member_pin_info;
                                
                    $this->load->view('member-profile-details-tpl', $data);            
                }
            }

        }
    }

    public function update_personal_info(){
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

                    // $this->form_validation->set_rules('citizenship', 'Citizenship', 'trim|required');
                    // $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
                    // $this->form_validation->set_rules('pob', 'Place of Birth', 'required');
                    $this->form_validation->set_rules('tin_number', 'TIN Number', 'required');
                    // $this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|numeric');
                    // $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|numeric');
                    // $this->form_validation->set_rules('address', 'Address', 'trim|required');
                    // $this->form_validation->set_rules('city', 'City', 'required');
                    // $this->form_validation->set_rules('province', 'Province', 'required');

                    if ($this->form_validation->run() == FALSE){

                        $printed_message['type'] = 'error';
                        $printed_message['message'] = validation_errors();

                        $this->session->set_userdata('personal_info_css', 'active');
                        $this->session->unset_userdata('valid_photo_css');
                        $this->session->unset_userdata('change_password_css');
                        $this->session->unset_userdata('bank_info_css');
                        $this->session->unset_userdata('security_pin_css');

                        $this->session->set_flashdata('message', $printed_message);                   
                    }else{
                        
                        // $citizenship    = xss_clean($this->input->post('citizenship'));
                        // $dob            = xss_clean($this->input->post('dob'));
                        // $pob            = xss_clean($this->input->post('pob'));
                        // $civil_status   = xss_clean($this->input->post('civil_status'));
                        $tin_number     = xss_clean($this->input->post('tin_number'));
                                        

                        // $telephone      = xss_clean($this->input->post('telephone'));
                        // $mobile         = xss_clean($this->input->post('mobile'));
                        
                        // $address        = xss_clean($this->input->post('address'));
                        // $city           = xss_clean($this->input->post('city'));
                        // $province       = xss_clean($this->input->post('province'));

                        $member_details_data['member_id'] = $member_id;
                        // $member_details_data['citizenship'] = $citizenship;
                        // $member_details_data['dob'] = $dob;
                        // $member_details_data['pob'] = $pob;
                        // $member_details_data['civil_status'] = $civil_status;
                        $member_details_data['tin_number'] = format_tin_number($tin_number);
                        // $member_details_data['telephone'] = $telephone;
                        // $member_details_data['mobile'] = $mobile;
                        // $member_details_data['address'] = $address;
                        // $member_details_data['city'] = $city;
                        // $member_details_data['province'] = $province;

                        $this->Members_model->update_member_details($member_details_data);                

                        $printed_message['type'] = 'success';
                        $printed_message['message'] = 'Successfully updated personal information';

                        $this->session->set_flashdata('message', $printed_message); 

                        $this->session->unset_userdata('bank_info_css');
                        $this->session->unset_userdata('valid_photo_css');
                        $this->session->unset_userdata('change_password_css');
                        $this->session->unset_userdata('security_pin_css');
                        $this->session->set_userdata('personal_info_css', 'active');                  

                        #log action
                        logger('update_personal_info', $member_id, 'members', '%username% successfully updated personal information');
                    }
                
                    redirect('profile');
                }        
            }
        }        
    }

    public function upload_valid_photos(){
        
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

                    // $this->form_validation->set_rules('authorized_id_img_1', 'Member Photo', 'callback_file_check_authorized_id_img_1');
                    $this->form_validation->set_rules('authorized_id_img_2', 'Valid ID', 'callback_file_check_authorized_id_img_2');

                    if ($this->form_validation->run() == FALSE){

                        $printed_message['type'] = 'error';
                        $printed_message['message'] = validation_errors();

                        $this->session->set_userdata('valid_photo_css', 'active');
                        $this->session->unset_userdata('personal_info_css');
                        $this->session->unset_userdata('change_password_css');
                        $this->session->unset_userdata('bank_info_css');
                        $this->session->unset_userdata('security_pin_css');                    

                        $this->session->set_flashdata('message', $printed_message);                   
                    }else{
                    
                        $profile_chk_1 = 0;
                        $profile_chk_2 = 0;
                        #member photo
                        if ($_FILES['authorized_id_img_1']['name'] != '') {
                            $authorized_id_img_1 = $this->upload_image('uploads/members/image', 'authorized_id_img_1');

                            $profile_chk_1 = 1;
                        }else{
                            $authorized_id_img_1 = '';
                            $profile_chk_1 = 1;
                        }

                        #valid id
                        if ($_FILES['authorized_id_img_2']['name'] != '') {
                            $authorized_id_img_2 = $this->upload_image('uploads/members/valid_id', 'authorized_id_img_2');

                            $profile_chk_2 = 1;
                        }

                        $member_details_data['member_id'] = $member_id;
                        $member_details_data['authorized_id_img_1'] = $authorized_id_img_1;
                        $member_details_data['authorized_id_img_2'] = $authorized_id_img_2;

                        if($profile_chk_1 == 0 OR $profile_chk_2 == 0){
                            $member_details_data['is_profile_complete'] = 0; #not complete
                        }else{
                            $member_details_data['is_profile_complete'] = 1; #complete
                        }

                        $this->Members_model->update_member_details($member_details_data); 

                        $printed_message['type'] = 'success';
                        $printed_message['message'] = 'Successfully uploaded valid photo';

                        $this->session->set_flashdata('message', $printed_message); 

                        $this->session->unset_userdata('bank_info_css');
                        $this->session->unset_userdata('change_password_css');
                        $this->session->unset_userdata('security_pin_css');
                        $this->session->unset_userdata('personal_info_css');
                        $this->session->set_userdata('valid_photo_css', 'active');

                        #log action
                        logger('upload_photo', $member_id, 'members', '%username% successfully uploaded valid photo');
                    }

                    redirect('profile');
                }
            }
        }
    }

    public function update_password(){
        
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

                    $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required|callback_verify_current_password');
                    $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]|max_length[8]');
                    $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[new_password]');

                    if ($this->form_validation->run() == FALSE){

                        $printed_message['type'] = 'error';
                        $printed_message['message'] = validation_errors();

                        $this->session->set_userdata('change_password_css', 'active');
                        $this->session->unset_userdata('personal_info_css');
                        $this->session->unset_userdata('valid_photo_css');
                        $this->session->unset_userdata('bank_info_css');
                        $this->session->unset_userdata('security_pin_css');                      

                        $this->session->set_flashdata('message', $printed_message);                   
                    }else{
                    
                        $new_password     = xss_clean($this->input->post('new_password'));            

                        $member_data = array(
                                'password' => $new_password,
                                 );

                        $this->ion_auth_member->update($member_id, $member_data);                

                        $printed_message['type'] = 'success';
                        $printed_message['message'] = 'Successfully updated password';

                        $this->session->set_flashdata('message', $printed_message); 

                        $this->session->unset_userdata('bank_info_css');
                        $this->session->unset_userdata('valid_photo_css');
                        // $this->session->unset_userdata('change_password_css');
                        $this->session->unset_userdata('security_pin_css');
                        $this->session->unset_userdata('personal_info_css');
                        $this->session->set_userdata('change_password_css', 'active');

                        #log action
                        logger('update_password', $member_id, 'members', '%username% successfully updated password');
                    }

                    redirect('profile');
                }
            }
        }
    }

    public function security_pin(){
        
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

                    $this->form_validation->set_rules('security_pin', 'Security Pin', 'required|min_length[6]|max_length[6]');
                    $this->form_validation->set_rules('confirm_security_pin', 'Confirm Security Pin', 'required|matches[security_pin]');

                    if ($this->form_validation->run() == FALSE){

                        $printed_message['type'] = 'error';
                        $printed_message['message'] = validation_errors();

                        $this->session->set_userdata('security_pin_css', 'active'); 
                        $this->session->unset_userdata('personal_info_css');
                        $this->session->unset_userdata('valid_photo_css');
                        $this->session->unset_userdata('change_password_css');
                        $this->session->unset_userdata('bank_info_css'); 


                        $this->session->set_flashdata('message', $printed_message);                   
                    }else{
                    
                        $security_pin     = xss_clean($this->input->post('security_pin'));

                        $hash_security_pin = $this->ion_auth_member->hash_password($security_pin);

                        #error_log(print_r($hash_security_pin, true), 0);

                        $member_data = array(
                                'security_pin' => $hash_security_pin,
                                 );

                        $this->ion_auth_member->update($member_id, $member_data);

                        #$security_pin_chk = $this->ion_auth_member->hash_security_pin_db($member_id, $security_pin);

                        $printed_message['type'] = 'success';
                        $printed_message['message'] = 'Successfully updated security pin';

                        $this->session->set_flashdata('message', $printed_message);

                        $this->session->unset_userdata('bank_info_css');
                        $this->session->unset_userdata('valid_photo_css');
                        $this->session->unset_userdata('change_password_css');
                        // $this->session->unset_userdata('security_pin_css');
                        $this->session->unset_userdata('personal_info_css');
                        $this->session->set_userdata('security_pin_css', 'active'); 

                        #log action
                        logger('security_pin', $member_id, 'members', '%username% successfully updated security pin');
                    }

                    redirect('profile');
                }
            }
        }
    }

    public function update_bank_info(){
        
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

                    $this->form_validation->set_rules('bank_acct_name', 'Account Name', 'trim|required');
                    $this->form_validation->set_rules('bank_acct_number', 'Account Number', 'trim|required');

                    if ($this->form_validation->run() == FALSE){

                        $printed_message['type'] = 'error';
                        $printed_message['message'] = validation_errors();

                        $this->session->set_userdata('bank_info_css', 'active'); 
                        $this->session->unset_userdata('personal_info_css');
                        $this->session->unset_userdata('valid_photo_css');
                        $this->session->unset_userdata('change_password_css');
                        $this->session->unset_userdata('security_pin_css');  

                        $this->session->set_flashdata('message', $printed_message);                   
                    }else{

                        $bank_acct_name     = xss_clean($this->input->post('bank_acct_name'));
                        $bank_acct_number   = xss_clean($this->input->post('bank_acct_number'));

                        $member_details_data['member_id'] = $member_id;
                        $member_details_data['bank_acct_name'] = $bank_acct_name;
                        $member_details_data['bank_acct_number'] = $bank_acct_number;

                        $this->Members_model->update_member_details($member_details_data);                

                        $printed_message['type'] = 'success';
                        $printed_message['message'] = 'Successfully updated bank information';

                        $this->session->set_flashdata('message', $printed_message); 

                        // $this->session->unset_userdata('bank_info_css');
                        $this->session->unset_userdata('valid_photo_css');
                        $this->session->unset_userdata('change_password_css');
                        $this->session->unset_userdata('security_pin_css');
                        $this->session->unset_userdata('personal_info_css');
                        $this->session->set_userdata('bank_info_css', 'active');

                        #log action
                        logger('update_personal_info', $member_id, 'members', '%username% successfully updated bank information');
                    }
                
                    redirect('profile');
                }
            }
        }
    }

    public function search(){
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

                    $first_name   = "";
                    $middle_name  = "";
                    $last_name    = "";
                    $email        = "";

                    if ($this->input->server('REQUEST_METHOD') == 'POST') {
                        
                        $first_name   = xss_clean($this->input->post('first_name'));
                        $middle_name  = xss_clean($this->input->post('middle_name'));
                        $last_name    = xss_clean($this->input->post('last_name'));
                        $email        = xss_clean($this->input->post('email'));

                        if($first_name == '' && $middle_name == '' && $last_name == '' && $email == ''){
                            $members = array();
                        }else{

                            $members = $this->Members_model->get_member_search_result(false, $first_name, $middle_name, $last_name, $email);
                        }

                        $data['members'] = $members;
                        $data['first_name'] = $first_name;
                        $data['middle_name'] = $middle_name;
                        $data['last_name'] = $last_name;
                        $data['email'] = $email;

                    }else{
                        $data['members'] = array();
                        $data['first_name'] = $first_name;
                        $data['middle_name'] = $middle_name;
                        $data['last_name'] = $last_name;
                        $data['email'] = $email;                        
                    }


                    $this->load->view('member-search-tpl', $data); 
                }
            }
        }
    }


    public function logout(){
        $maintenance_settings = $this->System_model->get_settings('maintenance');
        
        if($maintenance_settings['active'] == 1){
            redirect('maintenance', 'refresh');
        }else{    
            $this->data['title'] = "Logout";
            // log the user out
            $logout = $this->ion_auth_member->logout();

            // redirect them to the login page
            $this->session->set_flashdata('message', $this->ion_auth_member->messages());
            
            redirect('/', 'refresh');
        }
    }

	public function ajax($section){

		switch ($section) {
            case 'set-session-head':

                $headname = $this->input->post('headname');

                $this->session->set_userdata('current_head', $headname);

                $this->session->unset_userdata('genealogy_head_id');

                $data['status'] = 'success';
                $data['msg'] = 'Successfully set head';

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'check-upline-position-available':
                $upline_id = $this->input->post('upline_id');

                $upline_info = $this->Members_model->get_downlines($upline_id);

                #error_log(print_r($upline_info, true), 0);
                if(empty($upline_info)){
                    $upline_pos = 'B';
                    $data['upline_pos'] = $upline_pos;
                    $data['status'] = 'success';
                }else{
                    if($upline_info[0]->upline_pos == 'L'){
                        $upline_pos = 'R';
                        $data['upline_pos'] = $upline_pos;
                        $data['status'] = 'success';
                    }elseif($upline_info[0]->upline_pos == 'R'){
                        $upline_pos = 'L';
                        $data['upline_pos'] = $upline_pos;
                        $data['status'] = 'success';
                    }else{
                        $data['status'] = 'error';
                        $data['msg'] = 'No upline positions available, page will refresh';
                    }
                }


                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'get-available-code':
                $package_id = $this->input->post('package_id');

                $member_id = $this->ion_auth_member->get_user_id();

                $code = $this->Codes_model->get_code_for_encoding($package_id, $member_id);

                if(empty($code)){
                    $data['status'] = 'error';
                }else{
                    $data['code_available'] = $code->code;
                    $data['status'] = 'success';
                }                

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'get_search_result':
                $records = $_REQUEST;

                if (isset($records['filter'])) {
                    
                    $username = $records['filter']['both']['username'];
                    $first_name = $records['filter']['both']['first_name'];
                    $middle_name = $records['filter']['both']['middle_name'];
                    $last_name = $records['filter']['both']['last_name'];
                    $email = $records['filter']['both']['email'];

                } else {

                    $username = '';
                    $first_name = '';
                    $middle_name = '';
                    $last_name = '';
                    $email = '';

                }


                $order_by = 'members.member_id DESC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'username' . ' ' . $records['order'][0]['dir'];
                    } elseif ($records['order'][0]['column'] == 2) {
                        $order_by = 'first_name' . ' ' . $records['order'][0]['dir'];
                    } elseif ($records['order'][0]['column'] == 3) {
                        $generated_by = 'middle_name' . ' ' . $records['order'][0]['dir'];
                    } elseif ($records['order'][0]['column'] == 4) {
                        $generated_by = 'last_name' . ' ' . $records['order'][0]['dir'];
                    } elseif ($records['order'][0]['column'] == 5) {
                        $generated_by = 'email' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $members = $this->Members_model->get_search_result($username, $first_name, $middle_name, $last_name, $email, $order_by);

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

                    $records["data"][] = array(
                        $member[$i]->username,
                        $member[$i]->first_name,
                        $member[$i]->middle_name,
                        $member[$i]->last_name,
                        $member[$i]->mobile,
                        $member[$i]->email,
                        $member[$i]->created_on,''
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

            case 'destroy-session':
                
                $member_id = $this->ion_auth_member->get_user_id();

                #log action
                logger('multiple_tab', $member_id, 'members', 'User %username% detected open in another tab');           

                $data['status'] = 'success';

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;
		}
	}

    #callbacks

    public function check_code($code){
        
        $code_info = $this->Codes_model->get_code_by_code($code);
        $member_id = $this->ion_auth_member->get_user_id();

        if($code_info->purchased_by != $member_id){

            $this->form_validation->set_message('check_code', '{field} is not purchased by you');
            return FALSE;

        }else{
            if($code_info->used_by != 0 && $code_info->status == 1){
                $this->form_validation->set_message('check_code', '{field} is already used');
                return FALSE;
            }else{
                return TRUE;
            }
        }
    }

    public function check_member_username($username){

        if ($this->ion_auth_member->username_check($username)){

            $this->form_validation->set_message('check_member_username', '{field} is already taken');
            return FALSE;

        }else{

            return TRUE;
        }
    }

    public function verify_username($username){

        if ($this->ion_auth_member->username_check($username)){
            return TRUE;
        }else{
            $this->form_validation->set_message('verify_username', 'Invalid Username');
            return FALSE;
        }
    }

    public function check_member_email($email){

        if ($this->ion_auth_member->email_check($email)){

            $this->form_validation->set_message('check_member_email', '{field} is already registered');
            return FALSE;

        }else{

            return TRUE;
        }
    }

    public function file_check_authorized_id_img_1($str){
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['authorized_id_img_1']['name']);

        if(isset($_FILES['authorized_id_img_1']['name']) && $_FILES['authorized_id_img_1']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check_authorized_id_img_1', 'Please select only jpg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check_authorized_id_img_1', 'Please choose a file to upload for Member Photo.');
            return false;
        }
    }

    public function file_check_authorized_id_img_2($str){
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['authorized_id_img_2']['name']);
        if(isset($_FILES['authorized_id_img_2']['name']) && $_FILES['authorized_id_img_2']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check_authorized_id_img_2', 'Please select only jpg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check_authorized_id_img_2', 'Please choose a file to upload for Valid ID.');
            return false;
        }
    }

    public function random_username($string) {
        $pattern = " ";
        $firstPart = strstr(strtolower($string), $pattern, true);
        $secondPart = substr(strstr(strtolower($string), $pattern, false), 0,3);
        $nrRand = rand(0, 100);

        $username = trim($firstPart).trim($secondPart).trim($nrRand);
        return $username;
    }

    public function upload_image($upload_p, $do_upload){

        $config['upload_path'] = $upload_p;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = 1024 * 125;
        $config['file_name'] = substr(md5(time()), 0, 8);

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        $this->upload->do_upload($do_upload);

        $this->load->library('image_lib');
        $data = $this->upload->data();

        return $data['file_name'];
    }

    public function verify_temp_password(){

        $activation_code = $this->input->post('activation_code');
        $temp_password = $this->input->post('temp_password');

        $member_info = $this->Members_model->get_member_by_activation_code($activation_code);

        if ($this->ion_auth_member->hash_password_db($member_info->member_id, trim($temp_password)) !== TRUE)
        {
            $this->form_validation->set_message('verify_temp_password', 'Incorrect Temporary Password');
            return false;
        }else{
            return true;
        }
    }

    public function verify_current_password(){

        $member_id = $this->ion_auth_member->get_user_id();
        $current_password = $this->input->post('current_password');

        if ($this->ion_auth_member->hash_password_db($member_id, $current_password) !== TRUE)
        {
            $this->form_validation->set_message('verify_current_password', 'Current password is invalid');
            return false;
        }else{
            return true;
        }
    }    
}