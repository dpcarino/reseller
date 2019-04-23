<?php

class Cron_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function execProcessWeeklyIncome($transactionId){

        $result = $this->db->query('CALL ProcessWeeklyIncome(?)', array('vcTransactionID' => $transactionId));

        return $result;
    }    
}