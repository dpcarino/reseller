<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rewards extends CI_Controller {

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

        $maintenance_settings = $this->System_model->get_settings('maintenance');
    }

    public function view_rewards(){
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

                    $rewards = $this->Rewards_model->get_all_rewards();

                    $data['rewards'] = $rewards;
                    $data['member_star_wallet_info'] = $member_star_wallet_info;
                                
                    $this->load->view('member-rewards-tpl', $data);
                }
            }
        }        
    }

    public function details($reward_id){
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


                    $reward_info = $this->Rewards_model->get_reward($reward_id);

                    $data['reward_info'] = $reward_info;
                    $data['member_star_wallet_info'] = $member_star_wallet_info;
                                
                    $this->load->view('member-reward-details-tpl', $data);            
                }
            }
        }
    }
}