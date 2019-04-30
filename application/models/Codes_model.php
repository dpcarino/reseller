<?php

class Codes_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_codes_dtable($purchase_no = false, $code = false, $type_id,  $generated_by = false, $purchased_by = false, $used_by = false, $status = false, $order_by = false)
    {

        if ($purchase_no) $this->db->like('purchase_no', $purchase_no);
        if ($code) $this->db->like('code', $code);
        if ($type_id != '') $this->db->like('type_id', $type_id);
        if ($status) $this->db->like('status', $status);

        if($generated_by){
            $this->db->join('admins', 'codes.generated_by = admins.id');
            $this->db->like('admins.first_name', $generated_by);
            $this->db->or_like('admins.last_name', $generated_by);            
        }

        if($purchased_by){
            $this->db->join('members_detail', 'members_detail.member_id = codes.purchased_by');
            $this->db->like('members_detail.first_name', $purchased_by);
            $this->db->or_like('members_detail.middle_name', $purchased_by);            
            $this->db->or_like('members_detail.last_name', $purchased_by);            
        }

        if($used_by){
            $this->db->join('members_detail', 'members_detail.member_id = codes.used_by');
            $this->db->like('members_detail.first_name', $used_by);
            $this->db->or_like('members_detail.middle_name', $used_by);            
            $this->db->or_like('members_detail.last_name', $used_by);            
        }

        if ($order_by) $this->db->order_by($order_by);
        #$this->db->where('status !=', 0);


        $result = $this->db->get('codes')->result();
        
        return $result;
    }

    public function get_all_codes_dtable_member($code = false, $type_id,  $member_id, $order_by = false)
    {

        if ($code) $this->db->like('code', $code);
        if ($type_id != '') $this->db->like('type_id', $type_id);

        if ($order_by) $this->db->order_by($order_by);
        
        $this->db->where('purchased_by', $member_id);
        $this->db->where('status !=', 1);


        $result = $this->db->get('codes')->result();

        #error_log(print_r($this->db->last_query(), true), 0);
        
        return $result;
    }

    public function get_all_codes_dtable_history($code_id = false, $type,  $member_id, $order_by = false)
    {

        if ($code_id) $this->db->like('code_id', $code_id);
        if ($type != '') $this->db->like('type', $type);

        if ($order_by) $this->db->order_by($order_by);
        
        $this->db->where('member_id', $member_id);


        $result = $this->db->get('codes_history')->result();

        #error_log(print_r($this->db->last_query(), true), 0);
        
        return $result;
    }

    public function get_all_used_codes_dtable_history($code_id = false, $type,  $member_id, $order_by = false)
    {

        if ($code_id) $this->db->like('code_id', $code_id);
        if ($type != '') $this->db->like('type', $type);

        if ($order_by) $this->db->order_by($order_by);
        
        $this->db->where('purchased_by', $member_id);
        $this->db->where('status', 1);

        $result = $this->db->get('codes')->result();

        #error_log(print_r($this->db->last_query(), true), 0);
        
        return $result;
    }

    public function insert_code($data)
    {
        $this->db->insert('codes', $data);
        return $this->db->insert_id();
    }

    public function insert_cancel_code($data)
    {
        $this->db->insert('codes_canceled', $data);
        return $this->db->insert_id();
    }

    public function update_code($data)
    {
        $this->db->where('code_id', $data['code_id']);
        $this->db->update('codes', $data);
    }

    public function get_code_by_code($code){

        $this->db->like('code', $code);

        $result = $this->db->get('codes')->row();
        return $result;
    }

    public function get_code($code_id){

        $this->db->where('code_id', $code_id);

        $result = $this->db->get('codes')->row();
        return $result;
    }

    public function check_member_code($code_id, $member_id){

        $this->db->where('code_id', $code_id);
        $this->db->where('purchased_by', $member_id);

        $result = $this->db->get('codes')->row();
        return $result;
    }

    public function get_total_all_codes()
    {
        $result = $this->db->get('codes')->result();
        return $result;
    }

    public function get_all_codes()
    {
        $this->db->where('type_id', 1);
        $result = $this->db->get('codes')->result();
        return $result;
    } 

    public function get_all_paid_codes_by_member($member_id)
    {
        $this->db->where('purchased_by', $member_id);
        $this->db->where('type_id', 1);
        $this->db->where('status', 0);

        $result = $this->db->get('codes')->result();
        return $result;
    }     

    public function get_all_cd_codes_by_member($member_id)
    {
        $this->db->where('purchased_by', $member_id);
        $this->db->where('type_id', 0);
        $this->db->where('status', 0);

        $result = $this->db->get('codes')->result();
        return $result;
    }

    public function get_all_unused_cd_codes()
    {
        $this->db->where('type_id', 0);
        $this->db->where('status', 0);

        $result = $this->db->get('codes')->result();
        return $result;
    }   

    public function get_all_unused_paid_codes()
    {
        $this->db->where('type_id', 1);
        $this->db->where('status', 0);

        $result = $this->db->get('codes')->result();
        return $result;
    }     

    public function get_all_used_cd_codes()
    {
        $this->db->where('type_id', 0);
        $this->db->where('status', 1);

        $result = $this->db->get('codes')->result();
        return $result;
    }   

    public function get_all_used_paid_codes()
    {
        $this->db->where('type_id', 1);
        $this->db->where('status', 1);

        $result = $this->db->get('codes')->result();
        return $result;
    }

    public function get_all_paylite_codes()
    {
        $this->db->where('package_id', 5);
        $result = $this->db->get('codes')->result();
        return $result;
    }    

    public function get_all_used_paylite_codes()
    {
        $this->db->where('package_id', 5);
        $this->db->where('status', 1);

        $result = $this->db->get('codes')->result();
        return $result;
    }

    public function get_all_unused_paylite_codes()
    {
        $this->db->where('package_id', 5);
        $this->db->where('status', 0);

        $result = $this->db->get('codes')->result();
        return $result;
    }

    public function get_code_for_encoding($package_id, $member_id){

        $this->db->where('package_id', $package_id);
        $this->db->where('purchased_by', $member_id);
        $this->db->where('status', 0);
        $this->db->limit(1);

        $result = $this->db->get('codes')->row();

        #error_log(print_r($this->db->last_query(), true), 0);

        return $result;

    }

    public function insert_code_history($data)
    {
        $this->db->insert('codes_history', $data);
        return $this->db->insert_id();
    }


    public function get_used_to($member_id){

        $this->db->where('used_to', $member_id);

        $result = $this->db->get('codes')->row();

        return $result;
    }

    public function remove_code($code_id){
        $this->db->where('code_id', $code_id);
        $this->db->delete('codes');
    }

    public function get_unused_reseller_codes_by_member($member_id)
    {
        $this->db->where('package_id', 9);
        $this->db->where('purchased_by', $member_id);
        $this->db->where('status', 0);

        $result = $this->db->get('codes')->result();
        return $result;
    }

    public function get_all_reseller_codes()
    {
        $this->db->where('package_id', 9);
        $result = $this->db->get('codes')->result();
        return $result;
    }    

    public function get_all_used_reseller_codes()
    {
        $this->db->where('package_id', 9);
        $this->db->where('status', 1);

        $result = $this->db->get('codes')->result();
        return $result;
    }

    public function get_all_unused_reseller_codes()
    {
        $this->db->where('package_id', 9);
        $this->db->where('status', 0);

        $result = $this->db->get('codes')->result();
        return $result;
    }    
}