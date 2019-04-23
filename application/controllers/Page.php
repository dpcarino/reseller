<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->library(array('ion_auth_member','form_validation'));

        $this->load->model('Members_model');
        $this->load->model('Announcement_model');
    }

	public function index()
	{
		$data = array();	

    	$this->load->view('member-login-tpl', $data);
	}

	public function mailtest(){
	
		$this->load->library('email');

		$this->load->model('Email_model');
		$this->load->model('Members_model');

        $member_info = $this->Members_model->get_member(983);
        $member_details_info = $this->Members_model->get_member_details(983);

		$row = $this->Email_model->get_message(1);

		$row['subject'] = str_replace('{fullname}', $member_details_info->first_name.' '.$member_details_info->last_name, $row['subject']);

		$row['content'] = html_entity_decode($row['content']);

		$row['content'] = str_replace('{url}', $this->config->item('base_url'), $row['content']);

		$row['content'] = str_replace('{fullname}', $member_details_info->first_name.' '.$member_details_info->last_name, $row['content']);
		
		$row['content'] = str_replace('{username}', 'dpcarino', $row['content']);
		$row['content'] = str_replace('{temp_password}', 'essdpcarino', $row['content']);
		
		$row['content'] = str_replace('{activate_url}', $this->config->item('base_url').'activate/'.$member_info->activation_code, $row['content']);		

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

        $this->email->to('essensait@essensanaturale.org');

        $this->email->subject('TEST EMAIL');
        $this->email->message($row['content']);

        $this->email->send();

        echo 'TEST SENDING';

	}

	public function bulk_sender(){
		
		$this->load->library('email');

		$this->load->model('Email_model');
		$this->load->model('Members_model');

		$email_members = $this->Email_model->bulk_email_members();

		foreach($email_members as $email_member){

			$activation_code = generate_code();

            $username = $email_member->username;
            $password = generate_random_password();

            $hashed_password = $this->ion_auth_member->hash_password($password);

            $member_data['member_id'] = $email_member->member_id;
            $member_data['password'] = $hashed_password;
            $member_data['activation_code'] = $activation_code;
            $member_data['activation_email_sent'] = 1;

            $this->Members_model->update_member($member_data);


	        $member_info = $this->Members_model->get_member($email_member->member_id);
	        $member_details_info = $this->Members_model->get_member_details($email_member->member_id);

			$row = $this->Email_model->get_message(1);

			$row['subject'] = str_replace('{fullname}', $member_details_info->first_name.' '.$member_details_info->last_name, $row['subject']);

			$row['content'] = html_entity_decode($row['content']);

			$row['content'] = str_replace('{url}', $this->config->item('base_url'), $row['content']);

			$row['content'] = str_replace('{fullname}', $member_details_info->first_name.' '.$member_details_info->last_name, $row['content']);
			
			$row['content'] = str_replace('{username}', $username, $row['content']);
			$row['content'] = str_replace('{temp_password}', $password, $row['content']);
			
			$row['content'] = str_replace('{activate_url}', $this->config->item('base_url').'activate/'.$activation_code, $row['content']);		

	        $config = array(
	            'useragent' => 'PHPMailer',
	            'protocol' => 'smtp',
	            'smtp_host' => 'smtp.gmail.com',
	            'smtp_port' => '587',
	            'smtp_user' => 'customerservice@essensanaturale.org',
	            'smtp_pass' => 'essensa4321',
	            'mailtype'  => 'html', 
	            'charset'   => 'UTF-8'
	        );

	        $this->email->initialize($config);

	        $this->email->from('customerservice@essensanaturale.org', 'Essensa Customer Service');

	        #$this->email->to('carino.dino@gmail.com');
	        $this->email->to($email_member->email);

			// $email_arr = array('essensanaturaleit@gmail.com', 'essensait@essensanaturale.org');

			// $this->email->bcc($email_arr);

	        $this->email->subject($row['subject']);
	        $this->email->message($row['content']);

	        $this->email->send();

	        echo $email_member->email.'<br>';
		}
	}

	public function generate_qrcode(){
		$this->load->library('ciqrcode');

		header("Content-Type: image/png");
		$params['data'] = 'http://essensaelite.com/vcard/essensatop';
		$this->ciqrcode->generate($params);
	}

	public function vcard($username){

		$data = array();	

		$member_info = $this->Members_model->get_member_by_username($username);

		$member_details_info = $this->Members_model->get_member_details($member_info->member_id);

		$data['member_info'] = $member_info;
		$data['member_details_info'] = $member_details_info;

    	$this->load->view('member-vcard-tpl', $data);
    	
	}

	public function ajax($section)
	{
		switch ($section) {
			case 'get-announcement-with-notif':

				$announcement_info = $this->Announcement_model->get_announcement_notif();

				if($announcement_info->notify == 1){

                	$data['status'] = 'success';
                	$data['teaser'] = $announcement_info->teaser;
                	$data['announceid'] = $announcement_info->announcement_id;
				}else{
					$data['status'] = 'error';
				}


				$this->output->set_content_type('application/json')->set_output(json_encode($data));

			break;
		}
	}
}