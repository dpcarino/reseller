<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	public function __construct()
    {
        parent::__construct();

        $this->load->model('Cron_model');
    }

	public function index()
	{
		echo 'cron';
	}

	public function weeklyIncome(){

		$trackingno = 'INC'.date('YmdHis');

		$this->Cron_model->execProcessWeeklyIncome($trackingno);

		#log action
		logger('cron_weeklyincome', 1, 'admin', '%username% successfully processed weeklyIncome CRON');		
	}
}