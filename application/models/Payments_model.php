<?php

class Payments_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    

    public function get_payments($head_id)
    {
        $this->db->where('head_id', $head_id);
        $result = $this->db->get('payments')->result();

        return $result;
    }

    public function save_payment($data)
    {
        $this->db->insert('payments', $data);
        return $this->db->insert_id();
    }
}