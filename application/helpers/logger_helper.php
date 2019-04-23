<?php defined('BASEPATH') OR exit('No direct script access allowed.');

function logger($action, $user_id, $section, $message){

	$CI = &get_instance();
	$CI->load->model('System_model');
	$CI->load->model('User_model');

	if($section == 'members'){
		$user_info = $CI->User_model->get_member($user_id);
	}elseif($section == 'admin'){
		$user_info = $CI->User_model->get_admin_by_id($user_id);
	}

    if(is_mobile()==1)
    {
        $device = 'MOBILE';
    }else
    {
        $device = 'PC';
    }

	$message = str_replace("%username%", $user_info->username, $message);

    $log_data['action'] = $action;
    $log_data['section'] = $section;
    $log_data['user_id'] = $user_id;
    $log_data['username'] = $user_info->username;
    $log_data['message'] = $message;
    $log_data['ip_address'] = $CI->input->ip_address();
    $log_data['device'] = $device;
    $log_data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    $log_data['dtstamp'] = date('Y-m-d H:i:s');

    $CI->System_model->save_system_log($log_data);    

}

?>