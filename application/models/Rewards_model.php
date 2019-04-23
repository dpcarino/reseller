<?php

class Rewards_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_rewards()
    {
        $this->db->where('status', 0);
        $this->db->order_by('reward_id', 'desc');
        $this->db->limit(3);

        $result = $this->db->get('rewards')->result();
        return $result;
    }

    public function get_all_rewards()
    {
        $this->db->where('status', 0);
        $this->db->order_by('reward_id', 'desc');

        $result = $this->db->get('rewards')->result();
        return $result;
    } 

    public function get_reward($reward_id){

        $this->db->where('reward_id', $reward_id);

        $result = $this->db->get('rewards')->row();
        return $result;
    }

    public function insert_reward($data)
    {
        $this->db->insert('rewards', $data);
        return $this->db->insert_id();
    }

    public function update_reward($data)
    {
        $this->db->where('reward_id', $data['reward_id']);
        $this->db->update('rewards', $data);
    }    

    public function insert_claim_request($data)
    {
        $this->db->insert('reward_claims', $data);
        return $this->db->insert_id();
    }

    public function get_member_claim_request_dtable($member_id){

        $this->db->where('claim_status', 0);
        $this->db->where('member_id', $member_id);
        
        $result = $this->db->get('reward_claims')->result();
        return $result;
    }

    public function get_member_claim_history_dtable($member_id){

        $this->db->where('claim_status', 1);
        $this->db->where('member_id', $member_id);
        
        $result = $this->db->get('reward_claims')->result();
        return $result;
    }

    public function get_claim_request($reward_claims_id){

        $this->db->where('reward_claims_id', $reward_claims_id);
        
        $result = $this->db->get('reward_claims')->row();
        return $result;
    }    

    public function remove_claim_request($reward_claims_id){
        $this->db->where('reward_claims_id', $reward_claims_id);
        $this->db->delete('reward_claims');
    } 

    public function get_all_claims_request($order_by = false)
    {

        if ($order_by) $this->db->order_by($order_by);
        
        $this->db->where('claim_status', 0);

        $result = $this->db->get('reward_claims')->result();
        
        return $result;
    }

    public function claim_stars_sum($status, $trackingcode = false){
        
        if ($trackingcode) $this->db->where('trackingcode', $trackingcode);

        $this->db->where('claim_status', $status);
        $this->db->select_sum('stars_used');
        
        $result = $this->db->get('reward_claims')->row();

        return $result;

    }

    public function insert_claims($data)
    {
        $this->db->insert('claims', $data);
        return $this->db->insert_id();
    }

    public function update_reward_claims($data)
    {
        $this->db->where('reward_claims_id', $data['reward_claims_id']);
        $this->db->update('reward_claims', $data);
    }

    public function get_all_rewards_dtable($reward = false, $order_by){

        if ($reward) $this->db->like('reward', $reward);

        if ($order_by) $this->db->order_by($order_by);
        
        $result = $this->db->get('rewards')->result();
        
        return $result;
    } 

    public function get_claims_history($trackingcode = false, $order_by = false)
    {

        if ($trackingcode) $this->db->like('trackingcode', $trackingcode);
        if ($order_by) $this->db->order_by($order_by);
        
        $result = $this->db->get('claims')->result();
        
        return $result;
    }

    public function get_claims_by_trackingcode($trackingcode){

        $this->db->where('trackingcode', $trackingcode);
        
        $result = $this->db->get('claims')->row();
        return $result;
    }  

    public function get_all_claim_request_by_trackingcode($trackingcode, $membername = false, $order_by = false)
    {

        $this->db->select('*');
        $this->db->from('reward_claims');  

        if($membername){
            $this->db->join('members_detail', 'members_detail.member_id = reward_claims.member_id');
            $this->db->like('members_detail.first_name', $membername);
            $this->db->or_like('members_detail.middle_name', $membername);            
            $this->db->or_like('members_detail.last_name', $membername);            
        }

        if ($order_by) $this->db->order_by($order_by);

        $this->db->where('reward_claims.trackingcode', $trackingcode);
        $this->db->where('reward_claims.claim_status', 1);

        $result = $this->db->get()->result();
        
        #error_log(print_r($this->db->last_query(), true), 0);

        return $result;
    }      
}