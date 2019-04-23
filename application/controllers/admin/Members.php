<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {

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
	   $this->load->model('Email_model');
    }

    public function index()
    {
        $data = array();
    }

    public function search(){
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $heads = $this->Heads_model->get_heads();

            $data['heads'] = $heads;

            $this->load->view('admin/member-search-tpl', $data);
        }
    }

    public function detail($member_id){
        $data = array();
        
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('admin/login', 'refresh');

        }else{
            $member_star_wallet_info = $this->Members_model->get_member_star_wallet($member_id);
            
            $heads = $this->Heads_model->get_member_heads($member_id);

            $member_wallet_info = $this->Members_model->get_member_wallet($member_id);

            $member_details_info = $this->Members_model->get_member_details($member_id);
            $member_info = $this->Members_model->get_member($member_id);
            
            $paid_codes = $this->Codes_model->get_all_paid_codes_by_member($member_id);
            $cd_codes = $this->Codes_model->get_all_cd_codes_by_member($member_id);
            
            $used_to_info = $this->Codes_model->get_used_to($member_id);
            if(!empty($used_to_info)){
                $member_used_to_info = $this->Members_model->get_member_details($used_to_info->used_by);
            }else{
                $member_used_to_info = array();
            }

            $cities = $this->Settings_model->get_all_cities();
            $provinces = $this->Settings_model->get_all_provinces();
            $citizenships = $this->Settings_model->get_all_citizenships();
            $setting_members = $this->Settings_model->get_setting_members();

            $member_setting_info = $this->Settings_model->get_setting_member($member_details_info->member_status);

            $data['cities'] = $cities;
            $data['provinces'] = $provinces;
            $data['citizenships'] = $citizenships;            

            $data['member_wallet_info'] = $member_wallet_info;
            $data['member_star_wallet_info'] = $member_star_wallet_info;
            $data['heads'] = $heads;
            $data['member_details_info'] = $member_details_info;
            $data['member_info'] = $member_info;
            $data['setting_members'] = $setting_members;
            $data['member_setting_info'] = $member_setting_info;
            $data['member_used_to_info'] = $member_used_to_info;
            $data['used_to_info'] = $used_to_info;
            $data['paid_codes_cnt'] = count($paid_codes);
            $data['cd_codes_cnt'] = count($cd_codes);

            $this->load->library('ciqrcode');

            #generate qr code

            $params['data'] = 'http://essensaelite.com/vcard/'.$member_info->username;
            $params['level'] = 'H';
            $params['size'] = 10;
            $params['savename'] = QRPATH.$member_info->username.'.png';

            $this->ciqrcode->generate($params);            
                        
            $this->load->view('admin/member-details-tpl', $data);            
        }
    }

    public function update_personal_info($member_id){
        $data = array();
    
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('login', 'refresh');
        }else{

            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            // $this->form_validation->set_rules('citizenship', 'Citizenship', 'trim|required');
            // $this->form_validation->set_rules('dob', 'Date of Birth', 'trim|required');
            // $this->form_validation->set_rules('pob', 'Place of Birth', 'required');
            // $this->form_validation->set_rules('tin_number', 'TIN Number', 'required');
            // $this->form_validation->set_rules('telephone', 'Telephone', 'trim|required|numeric');
            // $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|numeric');
            // $this->form_validation->set_rules('address', 'Address', 'trim|required');
            // $this->form_validation->set_rules('city', 'City', 'required');
            // $this->form_validation->set_rules('province', 'Province', 'required');

            if ($this->form_validation->run() == FALSE){

                $printed_message['type'] = 'error';
                $printed_message['message'] = validation_errors();

                $this->session->set_flashdata('message', $printed_message);                   
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
                
                $address        = xss_clean($this->input->post('address'));
                $city           = xss_clean($this->input->post('city'));
                $province       = xss_clean($this->input->post('province'));

                $member_details_data['member_id'] = $member_id;
                $member_details_data['first_name'] = ucfirst($first_name);
                $member_details_data['middle_name'] = ucfirst($middle_name);
                $member_details_data['last_name'] = ucfirst($last_name);
                $member_details_data['citizenship'] = $citizenship;
                $member_details_data['dob'] = $dob;
                $member_details_data['pob'] = $pob;
                $member_details_data['civil_status'] = $civil_status;
                $member_details_data['tin_number'] = format_tin_number($tin_number);
                $member_details_data['telephone'] = $telephone;
                $member_details_data['mobile'] = $mobile;
                $member_details_data['address'] = $address;
                $member_details_data['city'] = $city;
                $member_details_data['province'] = $province;

                $this->Members_model->update_member_details($member_details_data);                

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Successfully updated personal information';

                $this->session->set_flashdata('message', $printed_message);         

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();
                   
                logger('update_personal_info', $admin_id, 'admin', '%username% successfully updated personal information of member id'.$member_id);            

            }
            
            redirect('admin/members/detail/'.$member_id);
        }
    }

    public function update_bank_info($member_id){
        
        $data = array();
      
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('login', 'refresh');
        }else{

            $this->form_validation->set_rules('bank_acct_name', 'Account Name', 'trim|required');
            $this->form_validation->set_rules('bank_acct_number', 'Account Number', 'trim|required');

            if ($this->form_validation->run() == FALSE){

                $printed_message['type'] = 'error';
                $printed_message['message'] = validation_errors();

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

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();
                   
                logger('update_bank_info', $admin_id, 'admin', '%username% successfully updated bank information of member id'.$member_id);            

            }
            
            redirect('admin/members/detail/'.$member_id);
        }
    }

    public function upload_valid_photos($member_id){
        
        $data = array();
       
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('login', 'refresh');
        }else{

            //$this->form_validation->set_rules('authorized_id_img_1', 'Member Photo', 'callback_file_check_authorized_id_img_1');
            $this->form_validation->set_rules('authorized_id_img_2', 'Valid ID', 'callback_file_check_authorized_id_img_2');

            if ($this->form_validation->run() == FALSE){

                $printed_message['type'] = 'error';
                $printed_message['message'] = validation_errors();       

                $this->session->set_flashdata('message', $printed_message);                   
            }else{

                $member_id  = xss_clean($this->input->post('member_id'));

                $member_details_info = $this->Members_model->get_member_details($member_id);                
            
                $profile_chk_1 = 0;
                $profile_chk_2 = 0;
                #member photo
                if ($_FILES['authorized_id_img_1']['name'] != '') {
                    $authorized_id_img_1 = $this->upload_image('uploads/members/image', 'authorized_id_img_1');

                    $profile_chk_1 = 1;
                }else{
                    $authorized_id_img_1 = $member_details_info->authorized_id_img_1;

                    $profile_chk_1 = 1;
                }

                #valid id
                if ($_FILES['authorized_id_img_2']['name'] != '') {
                    $authorized_id_img_2 = $this->upload_image('uploads/members/valid_id', 'authorized_id_img_2');

                    $profile_chk_2 = 1;
                }else{
                    $authorized_id_img_2 = $member_details_info->authorized_id_img_2;

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

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();
                   
                logger('update_password', $admin_id, 'admin', '%username% successfully updated valid photo and id of member id'.$member_id);            

            }
            
            redirect('admin/members/detail/'.$member_id);
        }
    }    

    public function update_password($member_id){
        
        $data = array();
        
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('login', 'refresh');
        }else{

            $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]');
            $this->form_validation->set_rules('confirm_password', 'Confirm New Password', 'required|matches[new_password]');

            if ($this->form_validation->run() == FALSE){

                $printed_message['type'] = 'error';
                $printed_message['message'] = validation_errors();              

                $this->session->set_flashdata('message', $printed_message);                   
            }else{
            
                $new_password     = xss_clean($this->input->post('new_password'));            

                $hashed_password = $this->ion_auth_admin->hash_password($new_password);

                $member_data['member_id'] = $member_id;
                $member_data['password'] = $hashed_password;

                $this->Members_model->update_member($member_data);

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Successfully updated password';

                $this->session->set_flashdata('message', $printed_message);

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();
                   
                logger('update_password', $admin_id, 'admin', '%username% successfully updated password of member id'.$member_id);            

            }
            
            redirect('admin/members/detail/'.$member_id);
        }
    }    

    public function security_pin($member_id){
        
        $data = array();
     
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('admin/login', 'refresh');

        }else{

            $reset_pin     = xss_clean($this->input->post('reset_pin'));                
            
            if($reset_pin == 1){        
                $member_data['member_id'] = $member_id;
                $member_data['security_pin'] = NULL;

                $this->Members_model->update_member($member_data);

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Successfully reset security pin';
            }else{
                $printed_message['type'] = 'error';
                $printed_message['message'] = 'Select YES to perform security pin reset'; 
            }

            $this->session->set_flashdata('message', $printed_message);

            #log action

            $admin_id = $this->ion_auth_admin->get_user_id();
               
            logger('security_pin', $admin_id, 'admin', '%username% successfully reset security pin of member id'.$member_id);            

            redirect('admin/members/detail/'.$member_id);
        }
    }  

    public function block_account($member_id){
        
        $data = array();
     
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('admin/login', 'refresh');

        }else{

            $blocked     = xss_clean($this->input->post('blocked'));                
            
            $member_data['member_id'] = $member_id;
            $member_data['blocked'] = $blocked;

            $this->Members_model->update_member($member_data);

            $printed_message['type'] = 'success';
            if($blocked == 0){
                $printed_message['message'] = 'Successfully unblocked';
            }else{
                $printed_message['message'] = 'Successfully blocked';
            }

            $this->session->set_flashdata('message', $printed_message);

            #log action

            $admin_id = $this->ion_auth_admin->get_user_id();

            if($blocked == 0){
                logger('block_account', $admin_id, 'admin', '%username% successfully unblocked member id'.$member_id);
            }else{                    
                logger('block_account', $admin_id, 'admin', '%username% successfully blocked member id'.$member_id);
            }

            redirect('admin/members/detail/'.$member_id);
        }
    }    

    public function update_email($member_id){
        
        $data = array();
      
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('login', 'refresh');
        }else{

            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_member_email');

            if ($this->form_validation->run() == FALSE){

                $printed_message['type'] = 'error';
                $printed_message['message'] = validation_errors();

                $this->session->set_flashdata('message', $printed_message);                   
            }else{

                $email   = xss_clean($this->input->post('email'));

                $member_data['member_id'] = $member_id;
                $member_data['email'] = $email;

                $this->Members_model->update_member($member_data);                

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Successfully updated email';

                $this->session->set_flashdata('message', $printed_message); 

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();
                   
                logger('update_email', $admin_id, 'admin', '%username% successfully updated email of member id'.$member_id);            

            }
            
            redirect('admin/members/detail/'.$member_id);
        }
    }

    public function member_status($member_id){
        
        $data = array();
     
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('admin/login', 'refresh');

        }else{

            $member_status     = xss_clean($this->input->post('member_status'));                
            
            $member_data['member_id'] = $member_id;
            $member_data['member_status'] = $member_status;

            $this->Members_model->update_member_details($member_data);

            $printed_message['type'] = 'success';
            $printed_message['message'] = 'Successfully updated member status';

            $this->session->set_flashdata('message', $printed_message);

            #log action

            $admin_id = $this->ion_auth_admin->get_user_id();
                   
            logger('member_status', $admin_id, 'admin', '%username% successfully updated member status of member id'.$member_id);

            redirect('admin/members/detail/'.$member_id);
        }
    } 

    public function activate_member($member_id){
        
        $data = array();
     
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('admin/login', 'refresh');

        }else{

            $active     = xss_clean($this->input->post('active'));                
            
            $member_data['member_id'] = $member_id;
            $member_data['active'] = $active;
            $member_data['activation_code'] = '';
    
            if($active == 0){
                $member_data['dateactivated'] = '0000-00-00 00:00:00';
                $member_data['datedeactivated'] = date('Y-m-d H:i:s');
            }else{
                $member_data['dateactivated'] = date('Y-m-d H:i:s');                
                $member_data['datedeactivated'] = '0000-00-00 00:00:00';
            }


            $this->Members_model->update_member($member_data);

            $printed_message['type'] = 'success';
            if($active == 0){
                $printed_message['message'] = 'Successfully deactivated';
            }else{
                $printed_message['message'] = 'Successfully activated';
            }

            $this->session->set_flashdata('message', $printed_message);

            #log action

            $admin_id = $this->ion_auth_admin->get_user_id();

            if($active == 0){
                logger('deactivate_member', $admin_id, 'admin', '%username% successfully deactivated member id'.$member_id);
            }else{                    
                logger('activate_member', $admin_id, 'admin', '%username% successfully activated member id'.$member_id);
            }

            redirect('admin/members/detail/'.$member_id);
        }
    } 

    public function activate_encashment($member_id){
        
        $data = array();
     
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('admin/login', 'refresh');

        }else{

            $encashment     = xss_clean($this->input->post('encashment'));                
            
            $member_data['member_id'] = $member_id;
            $member_data['encashment'] = $encashment;
    
            $this->Members_model->update_member_details($member_data);

            $printed_message['type'] = 'success';
            if($encashment == 0){
                $printed_message['message'] = 'Successfully deactivated encashment';
            }else{
                $printed_message['message'] = 'Successfully activated encashment';
            }

            $this->session->set_flashdata('message', $printed_message);

            #log action

            $admin_id = $this->ion_auth_admin->get_user_id();

            if($encashment == 0){
                logger('deactivate_encashment', $admin_id, 'admin', '%username% successfully deactivated encashment of member id'.$member_id);
            }else{                    
                logger('activate_encashment', $admin_id, 'admin', '%username% successfully activated encashment of member id'.$member_id);
            }

            redirect('admin/members/detail/'.$member_id);
        }
    }

    public function resend_activation($member_id){
        
        $data = array();
        
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('login', 'refresh');
        }else{

            $resend     = xss_clean($this->input->post('resend'));

            if($resend == 1){

                $member_info = $this->Members_model->get_member($member_id);
                $member_details_info = $this->Members_model->get_member_details($member_id);

                $activation_code = generate_code();

                $username = $member_info->username;
                $password = generate_random_password();

                $hashed_password = $this->ion_auth_admin->hash_password($password);

                $member_data['member_id'] = $member_id;
                $member_data['password'] = $hashed_password;
                $member_data['activation_code'] = $activation_code;
                $member_data['activation_email_sent'] = 1;
                $member_data['active'] = 0;

                $this->Members_model->update_member($member_data);

                $row = $this->Email_model->get_message(1);

                $row['subject'] = str_replace('{fullname}', $member_details_info->first_name.' '.$member_details_info->last_name, $row['subject']);

                $row['content'] = html_entity_decode($row['content']);

                $row['content'] = str_replace('{url}', $this->config->item('base_url'), $row['content']);

                $row['content'] = str_replace('{fullname}', $member_details_info->first_name.' '.$member_details_info->last_name, $row['content']);
                
                $row['content'] = str_replace('{username}', $username, $row['content']);
                $row['content'] = str_replace('{temp_password}', $password, $row['content']);
                
                $row['content'] = str_replace('{activate_url}', $this->config->item('base_url').'activate/'.$activation_code.'/'.$password, $row['content']);     

                $config = array(
                    'useragent' => 'PHPMailer',
                    'protocol' => 'smtp',
                    'smtp_host' => 'smtp.gmail.com',
                    'smtp_port' => '587',
                    'smtp_user' => 'customerservice@essensanaturale.org',
                    'smtp_pass' => '3ssens453rv!c3',
                    'mailtype'  => 'html', 
                    'charset'   => 'UTF-8'
                );

                $this->email->initialize($config);

                $this->email->from('customerservice@essensanaturale.org', 'Essensa Customer Service');

                $this->email->to($member_info->email);

                $this->email->subject($row['subject']);
                $this->email->message($row['content']);

                $this->email->send();


                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Successfully resent activation email';

                $this->session->set_flashdata('message', $printed_message);

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();
                   
                logger('update_password', $admin_id, 'admin', '%username% successfully resent activation email of member id'.$member_id); 
            }
            
            redirect('admin/members/detail/'.$member_id);
        }
    } 

	public function ajax($section)
	{
		switch ($section) {
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

                    if($member[$i]->active == 0){
                        $active = 'No';
                    }else{
                        $active = 'Yes';
                    }

                    $records["data"][] = array(
                        $member[$i]->username,
                        $member[$i]->first_name,
                        $member[$i]->middle_name,
                        $member[$i]->last_name,
                        $member[$i]->mobile,
                        $member[$i]->email,
                        $active,
                        $member[$i]->created_on,
                        '<a href="'.site_url('admin/members/detail').'/'.$member[$i]->member_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-database"></i> View Details</a>'
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

            case 'get_member_heads':
                $member_id     = xss_clean($this->input->post('member_id'));

                $head_ids = array();
                $head_ids_available = array();

                $member_heads = $this->Members_model->get_member_heads($member_id);

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

                $available_uplines = $this->Members_model->get_head_list($head_ids_available);

                $options = '<option value="" >Select Upline</option>';

                foreach($available_uplines as $available_upline){
                    $options .= "<option value='". $available_upline->head_id ."'>".$available_upline->headname."</option>";
                }

                $data['status'] = 'success';
                $data['opts'] = $options;

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;

            case 'get_heads':
                
                $member_id     = xss_clean($this->input->post('member_id'));
                
                $heads = $this->Heads_model->get_member_heads($member_id);

                $options = '<option value="" >Select Sponsor</option>';

                foreach($heads as $head){
                    $options .= "<option value='". $head->head_id ."'>".$head->headname."</option>";
                }

                $data['status'] = 'success';
                $data['opts_head'] = $options;

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
		}
	}

    public function export(){

        $filename = 'MEMBER-LIST-'.date('Ymd');

        $this->load->library('excel');

        $objPHPExcel = $this->excel;

        $inputFileType = 'Excel5';
        $inputFileName = 'templates/members.xls';
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($inputFileName);

        $objPHPExcel->getProperties()->setCreator("Essensa Naturale - Members");

        $members = $this->Members_model->get_members();

        $admin_id = $this->ion_auth_admin->get_user_id();

        $admin_info = $this->User_model->get_admin_by_id($admin_id);

        $objPHPExcel->getActiveSheet()->setCellValue("B2", $admin_info->username);
        $objPHPExcel->getActiveSheet()->setCellValue("B3", count($members));        

        $i = 6;

        foreach($members as $member){
            
            $member_info = $this->Members_model->get_member($member->member_id);
            $member_details_info = $this->Members_model->get_member_details($member->member_id);

            $objPHPExcel->getActiveSheet()->setCellValue("A{$i}", $member->member_id);
            $objPHPExcel->getActiveSheet()->setCellValue("B{$i}", $member->username);
            $objPHPExcel->getActiveSheet()->setCellValue("C{$i}", $member->email);
            $objPHPExcel->getActiveSheet()->setCellValue("D{$i}", $member_details_info->first_name);
            $objPHPExcel->getActiveSheet()->setCellValue("E{$i}", $member_details_info->middle_name);
            $objPHPExcel->getActiveSheet()->setCellValue("F{$i}", $member_details_info->last_name);
            $objPHPExcel->getActiveSheet()->setCellValue("G{$i}", $member_details_info->dob);
            $objPHPExcel->getActiveSheet()->setCellValue("H{$i}", $member_details_info->pob);
            $objPHPExcel->getActiveSheet()->setCellValue("I{$i}", $member_details_info->address);
            $objPHPExcel->getActiveSheet()->setCellValue("J{$i}", $member_details_info->city);
            $objPHPExcel->getActiveSheet()->setCellValue("K{$i}", $member_details_info->province);
            $objPHPExcel->getActiveSheet()->setCellValue("L{$i}", $member_details_info->tin_number);

            $member_status_info = $this->Settings_model->get_setting_member($member_details_info->member_status);

            $objPHPExcel->getActiveSheet()->setCellValue("M{$i}", $member_details_info->mobile);
            $objPHPExcel->getActiveSheet()->setCellValue("N{$i}", $member_details_info->telephone);
            $objPHPExcel->getActiveSheet()->setCellValue("O{$i}", $member_status_info->status_name);

            if($member_info->active == 1){
                $activated = 'Yes';
            }else{
                $activated = 'No';
            }

            $objPHPExcel->getActiveSheet()->setCellValue("P{$i}", $activated);

            $i++;
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function add_member(){
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $heads = $this->Heads_model->get_heads();
            $data['heads'] = $heads;

            $members = $this->Members_model->get_members();
            $data['members'] = $members;

            $cities = $this->Settings_model->get_all_cities();
            $provinces = $this->Settings_model->get_all_provinces();
            $citizenships = $this->Settings_model->get_all_citizenships();

            $data['cities'] = $cities;
            $data['provinces'] = $provinces;
            $data['citizenships'] = $citizenships;

            $data['first_name'] = '';
            $data['middle_name'] = '';
            $data['last_name'] = '';
            $data['citizenship'] = '';
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
            $data['application_form_id'] = '';

            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha_dash');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha_dash');
            $this->form_validation->set_rules('pob', 'Place of Birth', 'trim|required');
            $this->form_validation->set_rules('mobile', 'Mobile Number', 'trim|required|numeric');
            $this->form_validation->set_rules('address', 'Address', 'trim|required');
            $this->form_validation->set_rules('province', 'Province', 'trim|required');
            $this->form_validation->set_rules('sponsor_head', 'Sponsor Head', 'trim|required');
            $this->form_validation->set_rules('upline_placement_position', 'Upline Placement Position', 'trim|required');
            $this->form_validation->set_rules('upline_pos', 'Upline Position', 'trim|required');
            $this->form_validation->set_rules('desired_username', 'Desired Username', 'trim|required|alpha_dash|callback_check_member_username');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_member_email');
            $this->form_validation->set_rules('application_form_id', 'Application Form ID', 'trim|required');

            if ($this->form_validation->run() == FALSE){

                $data['first_name'] = $this->input->post('first_name');
                $data['middle_name'] = $this->input->post('middle_name');
                $data['last_name'] = $this->input->post('last_name');
                $data['citizenship'] = $this->input->post('citizenship');
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
                $data['application_form_id'] = $this->input->post('application_form_id');

            }else{

                $first_name     = xss_clean($this->input->post('first_name'));
                $middle_name    = xss_clean($this->input->post('middle_name'));
                $last_name      = xss_clean($this->input->post('last_name'));
                $citizenship    = xss_clean($this->input->post('citizenship'));
                $pob            = xss_clean($this->input->post('pob'));
                $civil_status   = xss_clean($this->input->post('civil_status'));
                $tin_number     = xss_clean($this->input->post('tin_number'));
                                

                $telephone      = xss_clean($this->input->post('telephone'));
                $mobile         = xss_clean($this->input->post('mobile'));
                $email          = xss_clean($this->input->post('email'));
                
                $address        = xss_clean($this->input->post('address'));
                $city           = xss_clean($this->input->post('city'));
                $province       = xss_clean($this->input->post('province'));

                $sponsor_head               = xss_clean($this->input->post('sponsor_head'));
                $upline_placement_position  = xss_clean($this->input->post('upline_placement_position'));
                $upline_pos                 = xss_clean($this->input->post('upline_pos'));
                $code_type                  = xss_clean($this->input->post('code_type'));
                $code_available             = xss_clean($this->input->post('code_available'));

                $desired_username           = xss_clean($this->input->post('desired_username'));
                $application_form_id        = xss_clean($this->input->post('application_form_id'));

                #generate username
                $username = $desired_username;
                $password = generate_random_password();

                $hashed_password = $this->ion_auth_admin->hash_password($password);
                #generate activation code 
                $activation_code = generate_code();
                  
                $member_data['username'] = $username;
                $member_data['password'] = $hashed_password;
                $member_data['email'] = $email;
                $member_data['activation_code'] = $activation_code;
                $member_data['group_id'] = 3;
                $member_data['created_on'] = date('Y-m-d H:i:s');
                $member_data['application_form_id'] = $application_form_id;

                $new_member_id = $this->Members_model->insert_member($member_data);

                #insert details in member details

                $member_details_data['member_id'] = $new_member_id;
                $member_details_data['first_name'] = ucfirst($first_name);
                $member_details_data['middle_name'] = ucfirst($middle_name);
                $member_details_data['last_name'] = ucfirst($last_name);
                $member_details_data['pob'] = $pob;
                $member_details_data['citizenship'] = $citizenship;
                $member_details_data['mobile'] = $mobile;
                $member_details_data['telephone'] = $telephone;
                $member_details_data['address'] = $address;
                $member_details_data['city'] = $city;
                $member_details_data['province'] = $province;
                $member_details_data['tin_number'] = format_tin_number($tin_number);
                $member_details_data['civil_status'] = $civil_status;

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
                $head_data['sponsor_id'] = $sponsor_head;
                $head_data['upline_id'] = $upline_placement_position;
                $head_data['upline_pos'] = $upline_pos;
                $head_data['account_status'] = $code_type;

                if($code_type == 0){
                    $head_data['cd_balance'] = '12888.00';
                }

                $new_head_id = $this->Heads_model->insert_head($head_data);

                #insert to gold count
                $gold_data['head_id'] = $new_head_id;

                $this->Heads_model->insert_gold_count($gold_data);                

                if($code_type == 0){

                    $result_addSponsor = $this->Members_model->execCDAddSponsor($sponsor_head);

                }elseif($code_type == 1){

                    $result_addSponsor = $this->Members_model->execGoldAddSponsor($sponsor_head);
                }


                if($code_type == 0){

                    $result_awardGSC = $this->Members_model->execCDAwardGSC($new_head_id);

                }elseif($code_type == 1){

                    $result_awardGSC = $this->Members_model->execGoldAwardGSC($new_head_id);
                }

                #send activation email
                sendActivationEmail($new_member_id, $username, $password);
                #end sending email

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Successfully added new member, email will be sent to registered email';

                $this->session->set_flashdata('message', $printed_message); 

                #log action
                $admin_id = $this->ion_auth_admin->get_user_id();

                logger('admin_add_member', $admin_id, 'admin', '%username% successfully added member '.$username);

                redirect('admin/members/search');
            }
            $this->load->view('admin/member-add-tpl', $data);
        }
    }

    #callback
    public function file_check_authorized_id_img_1($str){

        $member_id  = xss_clean($this->input->post('member_id'));

        $member_details_info = $this->Members_model->get_member_details($member_id);

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
            if($member_details_info->authorized_id_img_1 != ''){
                return true;
            }else{
                $this->form_validation->set_message('file_check_authorized_id_img_1', 'Please choose a file to upload for Member Photo.');
                return false;
            }
        }
    }

    public function file_check_authorized_id_img_2($str){

        $member_id  = xss_clean($this->input->post('member_id'));

        $member_details_info = $this->Members_model->get_member_details($member_id);

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
            if($member_details_info->authorized_id_img_2 != ''){
                return true;
            }else{
                $this->form_validation->set_message('file_check_authorized_id_img_2', 'Please choose a file to upload for Valid ID.');
                return false;
            }
        }
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

    public function check_member_email($email){

        if ($this->Members_model->check_member_email($email)){

            $this->form_validation->set_message('check_member_email', '{field} is already registered');
            return FALSE;

        }else{

            return TRUE;
        }
    }

    public function check_member_username($username){

        if ($this->Members_model->check_member_username($username)){

            $this->form_validation->set_message('check_member_username', '{field} is already taken');
            return FALSE;

        }else{

            return TRUE;
        }
    }
}