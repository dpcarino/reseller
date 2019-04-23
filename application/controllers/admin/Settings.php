<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

		$this->load->database();
		$this->load->library(array('ion_auth_admin','form_validation'));
		$this->load->helper(array('url','language', 'file'));

        $this->load->model('Leadership_model');
        $this->load->model('System_model');
        $this->load->model('Rewards_model');
        $this->load->model('Announcement_model');
        $this->load->model('User_model');
        $this->load->model('Members_model');

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth_admin'), $this->config->item('error_end_delimiter', 'ion_auth_admin'));

		$this->lang->load('auth');
	
    }

	public function index()
	{
	}

    public function settings_encashment(){

        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $encashment_settings = $this->System_model->get_settings('encashment');

            $data['settings'] = $encashment_settings;

            $this->form_validation->set_rules('processing_fee', 'Processing Fee', 'trim|required|is_natural');
            $this->form_validation->set_rules('commission_deduction', 'Commission Deduction', 'trim|required|is_natural');
            $this->form_validation->set_rules('tax', 'Tax', 'trim|required|decimal');
            $this->form_validation->set_rules('minimum_request', 'Minimum Request', 'trim|required|callback_verify_minimum');
            
            if ($this->form_validation->run() == FALSE){

            }else{

                $admin_id = $this->ion_auth_admin->get_user_id();

                $save = $this->input->post();

                $this->System_model->save_settings('encashment', $save);

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Encashment settings successfully updated';

                $this->session->set_flashdata('message', $printed_message);

                #update encashment settings of members                
                $member_data['encashment'] = 1;
                $this->Members_model->update_encashments($member_data);

                #log action
                logger('settings_encashment', $admin_id, 'admin', 'Account %username% updated encashment settings');

                redirect('admin/settings/encashment-settings');

            }

            $this->load->view('admin/encashment-settings-tpl', $data);
        }
    }

    public function settings_elite(){

        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $elite_settings = $this->System_model->get_elite_settings();

            $data['settings'] = $elite_settings;

            $this->form_validation->set_rules('GoldDirectRefferal', 'Gold Direct Refferal', 'trim|required|is_natural');
            $this->form_validation->set_rules('GoldPairingBonus', 'Gold Pairing Bonus', 'trim|required|is_natural');
            $this->form_validation->set_rules('GoldGSCPoints', 'Gold GSC Points', 'trim|required|is_natural');
            $this->form_validation->set_rules('FlushOut', 'Flush Out', 'trim|required|is_natural');
            $this->form_validation->set_rules('KnightDateDiff', 'Knight Days', 'trim|required|is_natural');
            $this->form_validation->set_rules('CD_deduction_percentage', 'CD Deduction Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('knight_lvl_1_percentage', 'Knight 1 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('knight_lvl_2_percentage', 'Knight 2 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_1_percentage', 'Leader 1 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_2_percentage', 'Leader 2 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_3_percentage', 'Leader 3 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_4_percentage', 'Leader 4 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_5_percentage', 'Leader 5 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_6_percentage', 'Leader 6 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_7_percentage', 'Leader 7 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_8_percentage', 'Leader 8 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_9_percentage', 'Leader 9 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_10_percentage', 'Leader 10 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_11_percentage', 'Leader 11 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_12_percentage', 'Leader 12 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_13_percentage', 'Leader 13 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_14_percentage', 'Leader 14 Percent', 'trim|required|is_natural');
            $this->form_validation->set_rules('leader_lvl_15_percentage', 'Leader 15 Percent', 'trim|required|is_natural');
            
            if ($this->form_validation->run() == FALSE){

            }else{

                $admin_id = $this->ion_auth_admin->get_user_id();

                $save = $this->input->post();

                $this->System_model->save_elite_settings($save);

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Elite settings successfully updated';

                $this->session->set_flashdata('message', $printed_message);

                #log action
                logger('settings_elite', $admin_id, 'admin', 'Account %username% updated elite settings');

                redirect('admin/settings/elite-settings');
            }

            $this->load->view('admin/elite-settings-tpl', $data);
        }
    }    

    public function settings_maintenance(){
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $maintenance_settings = $this->System_model->get_settings('maintenance');

            $data['settings'] = $maintenance_settings;

            $this->form_validation->set_rules('message', 'Maintenance Message', 'trim|required');
            
            if ($this->form_validation->run() == FALSE){

            }else{

                $admin_id = $this->ion_auth_admin->get_user_id();

                $save = $this->input->post();

                $this->System_model->save_settings('maintenance', $save);

                $printed_message['type'] = 'success';
                $printed_message['message'] = 'Maintenance settings successfully updated';

                $this->session->set_flashdata('message', $printed_message);

                #log action
                logger('settings_maintenance', $admin_id, 'admin', 'Account %username% updated maintenance settings');

                if($save['active'] == 1){
                    $this->db->truncate('ci_sessions');
                }

                redirect('admin/settings/maintenance-settings');

            }

            $this->load->view('admin/maintenance-settings-tpl', $data);
        }
    }

    public function rewards(){

        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {

            $this->load->view('admin/rewards-settings-tpl', $data);
        }
    }

    public function announcements(){

        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {

            $this->load->view('admin/announcements-settings-tpl', $data);
        }
    }

    public function reward_form($reward_id = false){
        $data = array();

        if ($reward_id != 0)
        {
            $reward_info = $this->Rewards_model->get_reward($reward_id);

            $reward = $reward_info->reward;
            $reward_description = $reward_info->reward_description;
            $reward_img = $reward_info->reward_img;
            $stars_required = $reward_info->stars_required;
            $status = $reward_info->status;
        }else{

            $reward = "";
            $reward_description = "";
            $reward_img = "";
            $stars_required = "";
            $status = 0;
        }

        $data['reward_id'] = $reward_id;
        $data['reward'] = $reward;
        $data['reward_description'] = $reward_description;
        $data['reward_img'] = $reward_img;
        $data['stars_required'] = $stars_required;
        $data['status'] = $status;

        $this->form_validation->set_rules('reward', 'Reward', 'trim|required');
        $this->form_validation->set_rules('reward_description', 'Reward Description', 'trim|required');
        $this->form_validation->set_rules('stars_required', 'Stars Required', 'trim|required');

        if($reward_img == ''){
            $this->form_validation->set_rules('reward_img', 'Reward Image', 'callback_file_check_reward_img');
        }
        

        if ($this->form_validation->run() == FALSE){           

        }else{

            $reward             = xss_clean($this->input->post('reward'));
            $reward_description = xss_clean($this->input->post('reward_description'));
            $stars_required     = xss_clean($this->input->post('stars_required'));
            $status             = xss_clean($this->input->post('status'));

            if ($_FILES['reward_img']['name'] != '') {
                $reward_img = $this->upload_image('uploads/rewards', 'reward_img');
            }

            $reward_data['reward'] = $reward;            
            $reward_data['reward_description'] = $reward_description;
            $reward_data['stars_required'] = $stars_required;
            $reward_data['status'] = $status;
            $reward_data['reward_img'] = $reward_img;
            $reward_data['datecreated'] = date('Y-m-d H:i:s');

            if($reward_id == 0){
                $this->Rewards_model->insert_reward($reward_data);
            }else{
                $reward_data['reward_id'] = $reward_id;

                $this->Rewards_model->update_reward($reward_data);
            }

            $admin_id = $this->ion_auth_admin->get_user_id();
                           
            if($reward_id == 0){
                logger('reward_add', $admin_id, 'admin', '%username% successfully created reward '.$reward);
            }else{
                logger('reward_edit', $admin_id, 'admin', '%username% successfully updated reward '.$reward);
            }

            redirect('admin/settings/rewards');
        }

        $this->load->view('admin/reward-form-tpl',$data);
    }

    public function annoucement_form($announcement_id = false){
        $data = array();

        if ($announcement_id != 0)
        {
            $annoucement_info = $this->Announcement_model->get_announcement($announcement_id);

            $message = $annoucement_info->message;
            $announcement_img = $annoucement_info->announcement_img;
            $teaser = $annoucement_info->teaser;
            $notify = $annoucement_info->notify;
        }else{

            $message = "";
            $announcement_img = "";
            $teaser = "";
            $notify = 0;
        }

        $data['announcement_id'] = $announcement_id;
        $data['message'] = $message;
        $data['announcement_img'] = $announcement_img;
        $data['teaser'] = $teaser;
        $data['notify'] = $notify;

        $this->form_validation->set_rules('teaser', 'Teaser', 'trim|required');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
                
        if ($this->form_validation->run() == FALSE){           

        }else{
            $admin_id = $this->ion_auth_admin->get_user_id();

            $teaser             = xss_clean($this->input->post('teaser'));
            $message            = xss_clean($this->input->post('message'));
            $notify             = xss_clean($this->input->post('notify'));

            if ($_FILES['announcement_img']['name'] != '') {
                $announcement_img = $this->upload_image('uploads/announcement', 'announcement_img');
                $annoucement_data['announcement_img'] = $announcement_img;
            }           

            $annoucement_data['admin_id'] = $admin_id;            
            $annoucement_data['teaser'] = $teaser;
            $annoucement_data['message'] = $message;
            $annoucement_data['notify'] = $notify;
            
            if($announcement_id == 0){
                
                $annoucement_data['datecreated'] = date('Y-m-d H:i:s');
                $this->Announcement_model->insert_annoucement($annoucement_data);

            }else{
                $annoucement_data['announcement_id'] = $announcement_id;
                $this->Announcement_model->update_annoucement($annoucement_data);
            }

            if($announcement_id == 0){
                logger('announcement_add', $admin_id, 'admin', '%username% successfully created announcement '.$teaser);
            }else{
                logger('announcement_edit', $admin_id, 'admin', '%username% successfully updated announcement '.$teaser);
            }

            redirect('admin/settings/announcements');
        }

        $this->load->view('admin/announcement-form-tpl',$data);
    }

    public function ajax($section)
    {
        switch ($section) {
            case 'get_all_rewards':

                $records = $_REQUEST;

                if (isset($records['filter'])) {
                    $reward = $records['filter']['both']['reward'];

                } else {

                    $reward = '';
                }


                $order_by = 'reward_id DESC';

                if (isset($records['order'])) {
                    if ($records['order'][0]['column'] == 1) {
                        $order_by = 'reward' . ' ' . $records['order'][0]['dir'];
                    }
                }

                $rewards = $this->Rewards_model->get_all_rewards_dtable($reward, $order_by);

                $iTotalRecords = count($rewards);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $reward = $rewards;

                    $records["data"][] = array(
                        $reward[$i]->reward, $reward[$i]->reward_description, $reward[$i]->stars_required, 
                        '<a href="'.site_url("admin/settings/reward-form/".$reward[$i]->reward_id).'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-pencil"></i> Edit</a>',
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

            case 'get_all_announcements':

                $records = $_REQUEST;

                $announcements = $this->Announcement_model->get_all_announcements();

                $iTotalRecords = count($announcements);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $announcement = $announcements;

                    $admin_info = $this->User_model->get_admin_by_id($announcement[$i]->admin_id);

                    $admin_name = $admin_info->first_name.' '.$admin_info->last_name;

                    $records["data"][] = array(
                        $admin_name, $announcement[$i]->teaser, $announcement[$i]->message, 
                        '<a href="'.site_url("admin/settings/announcement-form/".$announcement[$i]->announcement_id).'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-pencil"></i> Edit</a>',
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

    public function verify_minimum($amount){
        if(is_numeric($amount)){
            if($amount < 500){
                $this->form_validation->set_message('verify_minimum', 'Invalid amount, minimum encashment request is 500');
                return false;                
            }else{
                return true;
            }
        }else{
            $this->form_validation->set_message('verify_minimum', 'Please enter a valid amount');
            return false;            
        }
    } 

    public function file_check_reward_img($str){

        $reward_id  = xss_clean($this->input->post('reward_id'));

        $reward_info = $this->Rewards_model->get_reward($reward_id);

        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['reward_img']['name']);

        if(isset($_FILES['reward_img']['name']) && $_FILES['reward_img']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check_reward_img', 'Please select only jpg/png file.');
                return false;
            }
        }else{
            if($reward_info->reward_img != ''){
                return true;
            }else{
                $this->form_validation->set_message('file_check_reward_img', 'Please choose a file to upload for Reward Image.');
                return false;
            }
        }
    }


    public function file_check_announcement_img($str){

        $announcement_id  = xss_clean($this->input->post('announcement_id'));

        $annoucement_info = $this->Announcement_model->get_announcement($announcement_id);

        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['announcement_img']['name']);

        if(isset($_FILES['announcement_img']['name']) && $_FILES['announcement_img']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check_announcement_img', 'Please select only jpg/png file.');
                return false;
            }
        }else{
            if($annoucement_info->announcement_img != ''){
                return true;
            }else{
                $this->form_validation->set_message('file_check_announcement_img', 'Please choose a file to upload for Reward Image.');
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
}