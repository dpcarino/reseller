<?php

class Heads_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_heads_by_member_dtable($headname = false, $member_id, $order_by = false)
    {

        if ($headname) $this->db->like('headname', $headname);

        if ($order_by) $this->db->order_by($order_by);

        $this->db->where('status', 0);
        
        $this->db->where('member_id', $member_id);


        $result = $this->db->get('heads')->result();
        
        return $result;
    }

    public function insert_head($data)
    {
        $this->db->insert('heads', $data);
        return $this->db->insert_id();
    }

    public function get_heads()
    {
        $this->db->where('status', 0);
        $result = $this->db->get('heads')->result();
        return $result;
    }

    public function get_all_heads()
    {
        $result = $this->db->get('heads')->result();
        return $result;
    }

    public function get_head($head_id){

        $this->db->where('head_id', $head_id);

        $result = $this->db->get('heads')->row();
        return $result;
    }

    public function get_top_head($member_id){

        $this->db->where('member_id', $member_id);

        $result = $this->db->get('heads')->row();
        return $result;
    }

    public function get_member_heads($member_id)
    {
        $this->db->where('status', 0);
        $this->db->where('member_id', $member_id);

        $result = $this->db->get('heads')->result();
        return $result;
    }

    public function update_head($data)
    {
        $this->db->where('head_id', $data['head_id']);
        $this->db->update('heads', $data);        
    }

    public function insert_gold_count($data)
    {
        $this->db->insert('gold_count', $data);
        return $this->db->insert_id();
    }

    public function get_head_by_headname($headname){

        $this->db->where('headname', $headname);

        $result = $this->db->get('heads')->row();
        return $result;
    }

    public function get_gold_count_by_head($head_id){

        $this->db->where('head_id', $head_id);

        $result = $this->db->get('gold_count')->row();
        return $result;
    }    

    public function update_gold_count($data)
    {
        $this->db->where('head_id', $data['head_id']);
        $this->db->update('gold_count', $data);
    }

    public function func4lvl_genealogy($TopHead){

        $result = $this->db->query('SELECT func4lvl_genealogy(?)', array('TopHead' => $TopHead));

        return $result->row_array();
    }

    public function get_search_result($headname = false, $member_name = false, $account_status="", $knight_status="", $is_paylite="", $paid_ar = false, $knight_ar = false, $order_by = false)
    {

        $this->db->select('*');
        $this->db->from('heads'); 
        $this->db->join('members_detail', 'members_detail.member_id = heads.member_id');

        if($headname){
            $this->db->like('heads.headname', $headname);
        }

        if($member_name){
            $this->db->like('members_detail.first_name', $member_name);
            $this->db->or_like('members_detail.middle_name', $member_name);            
            $this->db->or_like('members_detail.last_name', $member_name);            
        }        

        if($account_status != ''){
            $this->db->where('account_status', $account_status);
        }

        if($knight_status != ''){
            $this->db->where('knight_status', $knight_status);
        }

        if($is_paylite != ''){
            $this->db->where('is_paylite', $is_paylite);
        }

        if($paid_ar){
            $this->db->like('heads.paid_ar', $paid_ar);
        }

        if($knight_ar){
            $this->db->like('heads.knight_ar', $knight_ar);
        }        

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get()->result();

        return $result;
    }

    public function funcPaidCD($PaidHead_id){

        $result = $this->db->query('SELECT funcPaidCD(?)', array('PaidHead_id' => $PaidHead_id));

        return $result;
    }

    public function funcCDPromo($PaidHead_id){

        $result = $this->db->query('SELECT funcCDPromo(?)', array('PaidHead_id' => $PaidHead_id));

        return $result;
    }

    public function funcPaylitePayment($PaidHead_id, $PaidAmount, $ARNumber){

        $result = $this->db->query('SELECT funcPaylitePayment(?, ?, ?)', array('PaidHead_id' => $PaidHead_id, 'PaidAmount' => $PaidAmount, 'ARNumber' => $ARNumber));

        return $result;
    }

    public function get_gold_heads()
    {
        $this->db->where('account_status', 1);
        $result = $this->db->get('heads')->result();
        return $result;
    }

    public function get_cd_heads()
    {
        $this->db->where('account_status', 0);
        $result = $this->db->get('heads')->result();
        return $result;
    }

    public function get_paylite_history($head_id)
    {
        $this->db->where('head_id', $head_id);

        $result = $this->db->get('paylite_payments')->result();
        return $result;
    }
}