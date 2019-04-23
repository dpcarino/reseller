<?php

class Encashment_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_encashment_request($order_by = false)
    {

        if ($order_by) $this->db->order_by($order_by);
        
        $this->db->where('encashment_status', 0);

        $result = $this->db->get('encashments')->result();
        
        return $result;
    }

    public function get_encashment_history($member_id)
    {

        $this->db->where('member_id', $member_id);
        $this->db->where('encashment_status', 1);

        $result = $this->db->get('encashments')->result();
        
        return $result;
    }

    public function get_encashment_payouts($trackingcode = false, $order_by = false)
    {

        if ($trackingcode) $this->db->like('trackingcode', $trackingcode);
        if ($order_by) $this->db->order_by($order_by);
        
        $result = $this->db->get('encashment_payouts')->result();
        
        return $result;
    }

    public function insert_encashment_request($data)
    {
        $this->db->insert('encashments', $data);
        return $this->db->insert_id();
    } 

    public function get_member_encashment_request($member_id){

        $this->db->where('encashment_status', 0);
        $this->db->where('member_id', $member_id);
        
        $result = $this->db->get('encashments')->row();
        return $result;
    }

    public function get_encashment_request($encashment_id){

        $this->db->where('encashment_id', $encashment_id);
        
        $result = $this->db->get('encashments')->row();
        return $result;
    }

    public function get_member_encashment_request_dtable($member_id){

        $this->db->where('encashment_status', 0);
        $this->db->where('member_id', $member_id);
        
        $result = $this->db->get('encashments')->result();
        return $result;
    }

    public function remove_encashment_request($encashment_id){
        $this->db->where('encashment_id', $encashment_id);
        $this->db->delete('encashments');
    }

    public function encashment_amount_sum($status, $trackingcode = false){
        
        if ($trackingcode) $this->db->where('trackingcode', $trackingcode);

        $this->db->where('encashment_status', $status);
        $this->db->select_sum('amount');
        
        $result = $this->db->get('encashments')->row();

        return $result;

    }

    public function encashment_payout_sum($status, $trackingcode = false){
        
        if ($trackingcode) $this->db->where('trackingcode', $trackingcode);

        $this->db->where('encashment_status', $status);
        $this->db->select_sum('payout');
        
        $result = $this->db->get('encashments')->row();

        return $result;

    }

    public function encashment_tax_sum($status, $trackingcode = false){
        
        if ($trackingcode) $this->db->where('trackingcode', $trackingcode);

        $this->db->where('encashment_status', $status);
        $this->db->select_sum('tax');
        
        $result = $this->db->get('encashments')->row();

        return $result;

    }

    public function insert_encashment_payout($data)
    {
        $this->db->insert('encashment_payouts', $data);
        return $this->db->insert_id();
    }

    public function update_encashment($data)
    {
        $this->db->where('encashment_id', $data['encashment_id']);
        $this->db->update('encashments', $data);
    } 

    public function get_payout_by_trackingcode($trackingcode){

        $this->db->where('trackingcode', $trackingcode);
        
        $result = $this->db->get('encashment_payouts')->row();
        return $result;
    }

    public function get_all_encashment_request_by_trackingcode($trackingcode, $membername = false, $order_by = false)
    {

        $this->db->select('*');
        $this->db->from('encashments');  

        if($membername){
            $this->db->join('members_detail', 'members_detail.member_id = encashments.member_id');
            $this->db->like('members_detail.first_name', $membername);
            $this->db->or_like('members_detail.middle_name', $membername);            
            $this->db->or_like('members_detail.last_name', $membername);            
        }

        if ($order_by) $this->db->order_by($order_by);

        $this->db->where('encashments.trackingcode', $trackingcode);
        $this->db->where('encashments.encashment_status', 1);

        $result = $this->db->get()->result();
        
        #error_log(print_r($this->db->last_query(), true), 0);

        return $result;
    }    
}