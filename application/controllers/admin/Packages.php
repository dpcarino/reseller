<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Packages extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

	   $this->load->database();

	   $this->load->library(array('ion_auth_admin','form_validation', 'uuid'));

       $this->load->helper(array('url','language'));

	   $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth_admin'), $this->config->item('error_end_delimiter', 'ion_auth_admin'));

	   $this->lang->load('auth');        

       $this->load->model('User_model');
	   $this->load->model('Packages_model');
    }

    public function index()
    {
        $data = array();

        if (!$this->ion_auth_admin->logged_in() || $this->session->userdata('user_type') != 'admin')
        {
            // redirect them to the login page
            redirect('admin/login', 'refresh');
        } else {
            $data = array();

            $this->load->view('admin/packages-tpl', $data);
        }
    }

    public function package_form($package_id = false){
        $data = array();

        if ($package_id != 0)
        {
            $package_info = $this->Packages_model->get_package($package_id);

            $package_name = $package_info->package_name;
            $package_prefix = $package_info->package_prefix;
            $status = $package_info->status;
            $is_cd = $package_info->is_cd;
            $cd_value = $package_info->cd_value;

        }else{

            $package_name = "";
            $package_prefix = "";
            $status = 0;
            $is_cd = 0;
            $cd_value = 0;
        }

        $data['package_id'] = $package_id;
        $data['package_name'] = $package_name;
        $data['package_prefix'] = $package_prefix;
        $data['status'] = $status;
        $data['is_cd'] = $is_cd;
        $data['cd_value'] = $cd_value;

        $this->form_validation->set_rules('package_name', 'Package Name', 'trim|required');
        $this->form_validation->set_rules('package_prefix', 'Package Prefix', 'trim|required');
        $this->form_validation->set_rules('cd_value', 'CD Value', 'callback_verify_cd_value');

        if ($this->form_validation->run() == FALSE){           

        }else{

            $package_name       = xss_clean($this->input->post('package_name'));
            $package_prefix     = xss_clean($this->input->post('package_prefix'));
            $status             = xss_clean($this->input->post('status'));
            $is_cd              = xss_clean($this->input->post('is_cd'));
            $cd_value           = xss_clean($this->input->post('cd_value'));

            $package_data['package_name'] = $package_name;            
            $package_data['package_prefix'] = $package_prefix;
            $package_data['status'] = $status;
            $package_data['is_cd'] = $is_cd;

            if($is_cd == 1){
                $package_data['cd_value'] = $cd_value;
            }

            if($package_id == 0){
                $package_data['datecreated'] = date('Y-m-d H:i:s');

                $this->Packages_model->insert_package($package_data);
            }else{
                $package_data['package_id'] = $package_id;

                $this->Packages_model->update_package($package_data);
            }

            $admin_id = $this->ion_auth_admin->get_user_id();
                           
            if($package_id == 0){
                logger('reward_add', $admin_id, 'admin', '%username% successfully created package '.$package_name);
            }else{
                logger('reward_edit', $admin_id, 'admin', '%username% successfully updated package '.$package_name);
            }

            redirect('admin/packages');
        }

        $this->load->view('admin/package-form-tpl',$data);
    }

	public function ajax($section)
	{
		switch ($section) {
            case 'get_all_packages':

                $records = $_REQUEST;

                $order_by = 'package_id ASC';

                $packages = $this->Packages_model->get_all_packages($order_by);

                $iTotalRecords = count($packages);
                $iDisplayLength = intval($_REQUEST['length']);
                $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
                $iDisplayStart = intval($_REQUEST['start']);

                $sEcho = intval($_REQUEST['draw']);

                $records["data"] = array();

                $end = $iDisplayStart + $iDisplayLength;
                $end = $end > $iTotalRecords ? $iTotalRecords : $end;


                for ($i = $iDisplayStart; $i < $end; $i++) {
                    $package = $packages;

                    if($package[$i]->status == 0){                        
                        $package_status = 'ACTIVE';
                    }else{
                        $package_status = 'DISABLED';
                    }

                    if($package[$i]->is_cd == 0){                        
                        $is_cd = 'NO';
                    }else{
                        $is_cd = 'YES';
                    }

                    $records["data"][] = array(
                        $package[$i]->package_name,
                        $package[$i]->package_prefix,
                        $package_status,
                        $is_cd,
                        $package[$i]->datecreated,
                        '<a href="'.site_url('admin/packages/package-form').'/'.$package[$i]->package_id.'" class="btn btn-sm btn-circle btn-default btn-editable"><i class="fa fa-pencil"></i> Edit</a>'
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

    public function verify_cd_value(){

        $is_cd = $this->input->post('is_cd');
        $cd_value = $this->input->post('cd_value');

        if($is_cd == 1)
        {            

            if($cd_value > 0){
                return true;
            }else{

                $this->form_validation->set_message('verify_cd_value', 'Please enter a valid CD Value');
                return false;
            }
        }else{
            return true;
        }
    } 
}