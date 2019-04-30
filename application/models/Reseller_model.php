<?php

class Reseller_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_reseller($data)
    {
        $this->db->insert('reseller', $data);
        return $this->db->insert_id();
    }

    public function insert_reseller_voucher_payout($data)
    {
        $this->db->insert('reseller_payouts', $data);
        return $this->db->insert_id();
    }

    public function update_reseller($data)
    {
        $this->db->where('head_id', $data['head_id']);
        $this->db->update('reseller', $data);
    }

    public function update_reseller_claims($data)
    {
        $this->db->where('reseller_claims_id', $data['reseller_claims_id']);
        $this->db->update('reseller_claims', $data);
    }      

    public function insert_reseller_request($data)
    {
        $this->db->insert('reseller_claims', $data);
        return $this->db->insert_id();
    }

    public function execResellerAddSponsor($SponsorHeadID){

        $result = $this->db->query('CALL ResellerAddSponsor(?)', array('SponsorHeadID' => $SponsorHeadID));

        return $result;
    }

    public function execResellerAwardGSC($NewHeadID){

        $result = $this->db->query('CALL ResellerAwardGSC(?)', array('NewHeadID' => $NewHeadID));

        return $result;
    }

    public function get_member_reseller_voucher_request_dtable($member_id){

        $this->db->where('claim_status', 0);
        $this->db->where('member_id', $member_id);
        
        $result = $this->db->get('reseller_claims')->result();
        return $result;
    }

    public function get_reseller_voucher_request($reseller_claims_id){

        $this->db->where('reseller_claims_id', $reseller_claims_id);
        
        $result = $this->db->get('reseller_claims')->row();
        return $result;
    }

    public function remove_reseller_voucher_request($reseller_claims_id){
        $this->db->where('reseller_claims_id', $reseller_claims_id);
        $this->db->delete('reseller_claims');
    }

    public function get_all_reseller_voucher_request($order_by = false)
    {

        if ($order_by) $this->db->order_by($order_by);
        
        $this->db->where('claim_status', 0);

        $result = $this->db->get('reseller_claims')->result();
        
        return $result;
    }

    public function get_reseller_voucher_payouts($trackingcode = false, $order_by = false)
    {

        if ($trackingcode) $this->db->like('trackingcode', $trackingcode);
        if ($order_by) $this->db->order_by($order_by);
        
        $result = $this->db->get('reseller_payouts')->result();
        
        return $result;
    }

    public function get_payout_by_trackingcode($trackingcode){

        $this->db->where('trackingcode', $trackingcode);
        
        $result = $this->db->get('reseller_payouts')->row();
        return $result;
    }

    public function get_all_reseller_voucher_request_by_trackingcode($trackingcode, $membername = false, $order_by = false)
    {

        $this->db->select('*');
        $this->db->from('reseller_claims');  

        if($membername){
            $this->db->join('members_detail', 'members_detail.member_id = reseller_claims.member_id');
            $this->db->like('members_detail.first_name', $membername);
            $this->db->or_like('members_detail.middle_name', $membername);            
            $this->db->or_like('members_detail.last_name', $membername);            
        }

        if ($order_by) $this->db->order_by($order_by);

        $this->db->where('reseller_claims.trackingcode', $trackingcode);
        $this->db->where('reseller_claims.claim_status', 1);

        $result = $this->db->get()->result();
        
        #error_log(print_r($this->db->last_query(), true), 0);

        return $result;
    }

    public function get_reseller($head_id){

        $this->db->where('head_id', $head_id);
        
        $result = $this->db->get('reseller')->row();
        return $result;
    }

    public function execfuncPaidReseller($PaidHead_id, $PaidAR){

        $result = $this->db->query('SELECT funcPaidReseller(?,?)', array('PaidHead_id' => $PaidHead_id, 'PaidAR' => $PaidAR));

        return $result;
    }    
}