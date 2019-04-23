<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

	   $this->load->database();

	   $this->load->library(array('ion_auth_admin','form_validation'));

       $this->load->helper(array('url','language'));

	   $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth_admin'), $this->config->item('error_end_delimiter', 'ion_auth_admin'));

	   $this->lang->load('auth');

	   $this->load->model('Codes_model');
	   $this->load->model('Members_model');
	   $this->load->model('Heads_model');
	   $this->load->model('User_model');
	   $this->load->model('Encashment_model');
    }

	public function index()
	{
		
		if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        }else{

        	$data=array();

        	$heads = $this->Heads_model->get_heads();
        	$members = $this->Members_model->get_members();
        	$codes = $this->Codes_model->get_all_codes();
        	$total_codes = $this->Codes_model->get_total_all_codes();
        	$unused_cd_codes = $this->Codes_model->get_all_unused_cd_codes();
        	$unused_paid_codes = $this->Codes_model->get_all_unused_paid_codes();
        	$used_cd_codes = $this->Codes_model->get_all_used_cd_codes();
        	$used_paid_codes = $this->Codes_model->get_all_used_paid_codes();
        	$used_paylite_codes = $this->Codes_model->get_all_used_paylite_codes();
        	$unused_paylite_codes = $this->Codes_model->get_all_unused_paylite_codes();
        	$paylite_codes = $this->Codes_model->get_all_paylite_codes();
        	$encashment_request = $this->Encashment_model->get_all_encashment_request();
        	$gold_heads = $this->Heads_model->get_gold_heads();
        	$cd_heads = $this->Heads_model->get_cd_heads();

        	$data['heads_count'] = count($heads);
        	$data['members_count'] = count($members);
        	$data['total_codes'] = count($total_codes);
        	$data['codes_count'] = count($codes);
        	$data['unused_paid_count'] = count($unused_paid_codes);
        	$data['unused_cd_count'] = count($unused_cd_codes);
        	$data['used_paid_count'] = count($used_paid_codes);
        	$data['used_cd_count'] = count($used_cd_codes);
        	$data['encashment_request'] = count($encashment_request);
        	$data['gold_heads'] = count($gold_heads);
        	$data['cd_heads'] = count($cd_heads);
        	$data['used_paylite_codes'] = count($used_paylite_codes);
        	$data['unused_paylite_codes'] = count($unused_paylite_codes);
        	$data['paylite_codes'] = count($paylite_codes);

        	$blog_config = $this->config->item('ion_auth_admin');

        	$this->load->view('admin/home-tpl', $data);
        }	

	}

	public function login(){
		$data = array();

		if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
			//validate form input
			$this->form_validation->set_rules('email', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
			$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

			if ($this->form_validation->run() == true)
			{
				// check to see if the user is logging in
				// check for "remember me"
				$remember = (bool) $this->input->post('remember');         

				if ($this->ion_auth_admin->login($this->input->post('email'), $this->input->post('password'), $remember))
				{
					//if the login is successful
					//redirect them back to the home page
					if($this->session->userdata('page_url')){
						redirect($this->session->userdata('page_url'));
					}else{
						$this->session->set_flashdata('message', $this->ion_auth_admin->messages());

						$admin_id = $this->ion_auth_admin->get_user_id();
						logger('login', $admin_id, 'admin', 'User %username% successfully logged in');

						redirect('admin/', 'refresh');
					}
				}
				else
				{
					// if the login was un-successful
					// redirect them back to the login page
					$this->session->set_flashdata('message', $this->ion_auth_admin->errors());
					redirect('admin/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
				}

			}else{
				// the user is not logging in so display the login page
				// set the flash data error message if there is one
				$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->load->view('admin/login-tpl', $data);
			}
		}else{
			$this->session->set_flashdata('message', $this->ion_auth_admin->messages());
			redirect('admin/', 'refresh');			
		}
	}

	public function logout()
	{
		$this->data['title'] = "Logout";

		// log the user out
		$logout = $this->ion_auth_admin->logout();

		// redirect them to the login page
		$this->session->set_flashdata('message', $this->ion_auth_admin->messages());		
		
		redirect('admin/', 'refresh');
	}

	public function search(){
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $this->load->view('admin/admin-search-tpl', $data);
        }		
	}

    public function detail($admin_id){

        $data = array();
        
        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            $this->ion_auth_admin->logout();
            redirect('admin/login', 'refresh');

        }else{

        	if($admin_id != 0){

        		$admin_info = $this->User_model->get_admin_by_id($admin_id);

        		$username = $admin_info->username;
        		$email = $admin_info->email;
        		$first_name = $admin_info->first_name;
        		$last_name = $admin_info->last_name;

        	}else{
        		$username = "";
        		$email = "";
        		$first_name = "";
        		$last_name = "";
        	}

	        $data['admin_id'] = $admin_id;
	        $data['username'] = $username;
	        $data['first_name'] = $first_name;
	        $data['last_name'] = $last_name;
	        $data['email'] = $email;        	

            if ($this->input->server('REQUEST_METHOD') == 'POST') {
	            
	            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
	            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');

	            if ($admin_id == 0) {
	                $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_dash|callback_check_username');
	                $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_email');
	                $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
	                $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|matches[password]');

	            } else {

	                if ($this->input->post('password') != '') {
	                    $this->form_validation->set_rules('password', 'Password', 'trim|required');
	                    $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|matches[password]');
	                }

	            }	            

	            if ($this->form_validation->run() == FALSE){

	                $data['first_name'] = $this->input->post('first_name');
	                $data['last_name'] = $this->input->post('last_name');
	                $data['email'] = $this->input->post('email');
	                $data['username'] = $this->input->post('username');

	            }else{

	                $first_name = $this->input->post('first_name');
	                $last_name = $this->input->post('last_name');
	                $username = strtolower($this->input->post('username'));
	                $password = $this->input->post('password');
	                $email = strtolower($this->input->post('email'));
	                $group_id = 2;

	                if ($admin_id != 0) {

	                    $save_data = array(
	                        'first_name' => $first_name,
	                        'last_name' => $last_name,
	                        'email' => $email,
	                        'username' => $username,
	                        'password' => $password,
	                        'group_id' => $group_id,
	                    );
	                    
	                    $this->ion_auth_admin->update($admin_id, $save_data);

	                } else {

	                	$group = array($group_id);

	                    $additional_data = array(
	                        'first_name' => $first_name,
	                        'last_name' => $last_name,
	                        'group_id' => $group_id,
	                    );

	                    $user_id = $this->ion_auth_admin->register($username, $password, $email, $additional_data, $group);
	                }

	                $current_admin = $this->ion_auth_admin->get_user_id();
	                   
	                if ($current_admin != 0) {
	                	logger('admin_update', $current_admin, 'admin', '%username% successfully updated '.$username);
	            	}else{
	                	logger('admin_add', $current_admin, 'admin', '%username% successfully status of '.$username);
	            	}

	                redirect('admin/search');	                
	            }

	        }          
                        
            $this->load->view('admin/admin-details-tpl', $data);            
        }
    }	

	public function ajax($section)
	{
		switch ($section) {
            case 'get_search_result':
                $records = $_REQUEST;

                if (isset($records['filter'])) {
                    
                    $username = $records['filter']['both']['username'];

                } else {

                    $username = '';
                }


                $order_by = 'id DESC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'username' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $admins = $this->User_model->get_search_result($username, $order_by);

                $iTotalRecords = count($admins);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $admin = $admins;

                    $records["data"][] = array(
                        $admin[$i]->username,
                        $admin[$i]->email,
                        $admin[$i]->first_name,
                        $admin[$i]->last_name,
                        $admin[$i]->created_on,
                        '<a href="'.site_url('admin/detail').'/'.$admin[$i]->id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-database"></i> View Details</a>'
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

    public function check_email($email){

        if ($this->ion_auth_admin->email_check($email)){

            $this->form_validation->set_message('check_email', '{field} is already registered');
            return FALSE;

        }else{

            return TRUE;
        }
    }

    public function check_username($username){

        if ($this->ion_auth_admin->username_check($username)){

            $this->form_validation->set_message('check_username', '{field} is already taken');
            return FALSE;

        }else{

            return TRUE;
        }
    }    
}