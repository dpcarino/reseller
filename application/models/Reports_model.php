<?php

class Reports_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_auto_paids($member_name = false, $order_by = false)
    {

        $this->db->select('*');
        $this->db->from('auto_paid_cd'); 
        $this->db->join('heads', 'heads.head_id = auto_paid_cd.head_id');
        $this->db->join('leadership_processed', 'leadership_processed.transaction_id = auto_paid_cd.transaction_id');
        $this->db->join('members_detail', 'members_detail.member_id = heads.member_id');

        if($member_name){
            $this->db->like('members_detail.first_name', $member_name);
            $this->db->or_like('members_detail.middle_name', $member_name);            
            $this->db->or_like('members_detail.last_name', $member_name);            
        }

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get()->result();

        return $result;
    }
}