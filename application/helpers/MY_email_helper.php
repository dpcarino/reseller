<?php defined('BASEPATH') OR exit('No direct script access allowed.');

	function sendActivationEmail($member_id, $username, $temp_password){

		$CI = &get_instance();
		$CI->load->model('Email_model');
		$CI->load->model('Members_model');

        $member_info = $CI->Members_model->get_member($member_id);
        $member_details_info = $CI->Members_model->get_member_details($member_id);

		$row = $CI->Email_model->get_message(1);

		$row['subject'] = str_replace('{fullname}', $member_details_info->first_name.' '.$member_details_info->last_name, $row['subject']);

		$row['content'] = html_entity_decode($row['content']);

		$row['content'] = str_replace('{url}', $CI->config->item('base_url'), $row['content']);

		$row['content'] = str_replace('{fullname}', $member_details_info->first_name.' '.$member_details_info->last_name, $row['content']);
		
		$row['content'] = str_replace('{username}', $username, $row['content']);
		$row['content'] = str_replace('{temp_password}', $temp_password, $row['content']);
		
		$row['content'] = str_replace('{activate_url}', $CI->config->item('base_url').'activate/'.$member_info->activation_code.'/'.$temp_password, $row['content']);		

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

        $CI->email->initialize($config);

        $CI->email->from('customerservice@essensanaturale.org', 'Essensa Customer Service');

        $CI->email->to($member_info->email);

        $CI->email->subject($row['subject']);
        $CI->email->message($row['content']);

        $CI->email->send();

	}

    function sendPayliteActivationEmail($member_id, $username, $temp_password){

        $CI = &get_instance();
        $CI->load->model('Email_model');
        $CI->load->model('Members_model');

        $member_info = $CI->Members_model->get_member($member_id);
        $member_details_info = $CI->Members_model->get_member_details($member_id);

        $row = $CI->Email_model->get_message(3);

        $row['subject'] = str_replace('{fullname}', $member_details_info->first_name.' '.$member_details_info->last_name, $row['subject']);

        $row['content'] = html_entity_decode($row['content']);

        $row['content'] = str_replace('{url}', $CI->config->item('base_url'), $row['content']);

        $row['content'] = str_replace('{fullname}', $member_details_info->first_name.' '.$member_details_info->last_name, $row['content']);
        
        $row['content'] = str_replace('{username}', $username, $row['content']);
        $row['content'] = str_replace('{temp_password}', $temp_password, $row['content']);
        
        $row['content'] = str_replace('{activate_url}', $CI->config->item('base_url').'activate/'.$member_info->activation_code.'/'.$temp_password, $row['content']);       

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

        $CI->email->initialize($config);

        $CI->email->from('customerservice@essensanaturale.org', 'Essensa Customer Service');

        $CI->email->to($member_info->email);

        $CI->email->subject($row['subject']);
        $CI->email->message($row['content']);

        $CI->email->send();

    }

    function sendForgotEmail($member_id, $forgotten_password_code){

        $CI = &get_instance();
        $CI->load->model('Email_model');
        $CI->load->model('Members_model');

        $member_info = $CI->Members_model->get_member($member_id);
        $member_details_info = $CI->Members_model->get_member_details($member_id);

        $row = $CI->Email_model->get_message(2);

        $row['content'] = html_entity_decode($row['content']);

        $row['content'] = str_replace('{url}', $CI->config->item('base_url'), $row['content']);

        $row['content'] = str_replace('{fullname}', $member_details_info->first_name.' '.$member_details_info->last_name, $row['content']);
                
        $row['content'] = str_replace('{forgot_url}', $CI->config->item('base_url').'forgot-password/'.$forgotten_password_code, $row['content']);      

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

        $CI->email->initialize($config);

        $CI->email->from('customerservice@essensanaturale.org', 'Essensa Customer Service');

        $CI->email->to($member_info->email);

        $CI->email->subject($row['subject']);
        $CI->email->message($row['content']);

        $CI->email->send();

    }    
?>