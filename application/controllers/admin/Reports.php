<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

	   $this->load->database();

	   $this->load->library(array('ion_auth_admin','form_validation', 'uuid'));

       $this->load->helper(array('url','language'));

	   $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth_admin'), $this->config->item('error_end_delimiter', 'ion_auth_admin'));

	   $this->lang->load('auth');        

       $this->load->model('User_model');
       $this->load->model('Reports_model');
       $this->load->model('Members_model');
	   $this->load->model('Heads_model');
    }

    public function index()
    {

    }

    public function auto_paid()
    {
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $this->load->view('admin/auto-paid-tpl', $data);
        }
    }


	public function ajax($section)
	{
		switch ($section) {
            case 'get_all_auto_paids':

                $records = $_REQUEST;

                if (isset($records['filter'])) {
                    
                    $member_name = $records['filter']['both']['member_name'];

                } else {

                    $member_name = '';
                }

                $order_by = 'auto_paid_cd_id DESC';

                $autos = $this->Reports_model->get_all_auto_paids($member_name, $order_by);

                $iTotalRecords = count($autos);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $auto = $autos;

                    error_log(print_r($auto, true), 0);

                    $head_info = $this->Heads_model->get_head($auto[$i]->head_id);
                    $member_details_info = $this->Members_model->get_member_details($head_info->member_id);

                    $records["data"][] = array(
                        $member_details_info->first_name.' '.$member_details_info->middle_name.' '.$member_details_info->last_name,
                        $head_info->headname,                        
                        $auto[$i]->transaction_id,                        
                        $auto[$i]->process_type,                        
                        $auto[$i]->dateprocessed,                        
                        ''
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
}