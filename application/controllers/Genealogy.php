<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Genealogy extends CI_Controller {

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

	public function index()
	{
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

                    if($this->session->userdata('genealogy_head_id') != ''){
                        $current_head_id = $this->session->userdata('genealogy_head_id');
                    }else{
                        $current_head_id = $memberhead_info->head_id;
                    }

                    $genealogy = $this->Heads_model->func4lvl_genealogy($current_head_id);

                    $arr_text = "func4lvl_genealogy('".$current_head_id."')";

                    $genealogy_str = $genealogy[$arr_text];

                    $data['heads'] = $heads;
                    $data['current_head'] = $head;
        			$data['genealogy_str'] = str_replace('"', '', $genealogy_str);
                    $data['memberhead_info'] = $memberhead_info;

        			$this->load->view('genealogy-tpl', $data);
                }
            }
        }
	}

	public function member_genealogy(){
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

                    $current_head_id = $this->session->userdata('genealogy_head_id');

                    $genealogy = $this->Heads_model->func4lvl_genealogy($current_head_id);

                    $arr_text = "func4lvl_genealogy('".$current_head_id."')";

                    $genealogy_str = $genealogy[$arr_text];

                    $data['heads'] = $heads;
                    $data['current_head'] = $head;
        			$data['genealogy_str'] = str_replace('"', '', $genealogy_str);
                    $data['memberhead_info'] = $memberhead_info;

        			$this->load->view('genealogy-tpl', $data);
                }
            }
        }		
	}

	public function ajax($section){

		switch ($section) {
            case 'set-genealogy':

                $this->session->unset_userdata('genealogy_head_id');

                $head_id = $this->input->post('head_id');

                $this->session->set_userdata('genealogy_head_id', $head_id);

                $data['status'] = 'success';
                $data['msg'] = 'Successfully set genealogy head';

                $this->output->set_content_type('application/json')->set_output(json_encode($data));
            break;
        }	
    }
}