<?php

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_admin_by_id($admin_id){

        $this->db->where('id', $admin_id);

        $result = $this->db->get('admins')->row();
        return $result;
    }

    public function get_member($member_id){

        $this->db->where('member_id', $member_id);

        $result = $this->db->get('members')->row();
        return $result;
    }

    public function get_member_details($member_id){

        $this->db->where('member_id', $member_id);

        $result = $this->db->get('members_detail')->row();
        return $result;
    }

    public function get_search_result($username = false, $order_by = false)
    {

        $this->db->select('*');
        $this->db->from('admins'); 

        if($username){
            $this->db->like('username', $username);
        }   

        $this->db->where('group_id !=', 1);

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get()->result();

        return $result;
    }    
}