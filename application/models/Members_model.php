<?php

class Members_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    public function get_members()
    {
        $result = $this->db->get('members')->result();
        return $result;
    }

    public function get_heads()
    {
        $result = $this->db->get('heads')->result();
        return $result;
    }    

    public function head_sums($field){
        
        $this->db->select_sum($field);
        
        $result = $this->db->get('heads')->row();

        return $result->$field;

    }    

    public function get_members_yournotincluded($member_id)
    {
        $this->db->where('is_corpo !=', 1);
        $this->db->where('member_id !=', $member_id);
        $result = $this->db->get('members')->result();
        return $result;
    }

    public function get_member($member_id){

        $this->db->where('member_id', $member_id);

        $result = $this->db->get('members')->row();
        return $result;
    }

    public function get_member_by_activation_code($activation_code){

        $this->db->where('activation_code', $activation_code);

        $result = $this->db->get('members')->row();
        return $result;
    }

    public function get_member_by_forgot_code($forgot_code){

        $this->db->where('forgotten_password_code', $forgot_code);

        $result = $this->db->get('members')->row();
        return $result;
    }
    
    public function get_member_by_username($username){

        $this->db->where('username', $username);

        $result = $this->db->get('members')->row();
        return $result;
    }

    public function get_member_details($member_id){

        $this->db->where('member_id', $member_id);

        $result = $this->db->get('members_detail')->row();
        return $result;
    }

    public function get_member_view_info_by_head($head){

        $this->db->where('headname', $head);

        #buboy 2019-03-31
        #change new MySql View
        #$result = $this->db->get('member_all')->row();
        $result = $this->db->get('memberhead_info')->row();
        return $result;
    }

    #buboy 2019-03-31
    #added for profile view and add member controller
    #$result = $this->db->get('member_all')->row();
    public function get_member_details_info_by_memberid($member_id){

        $this->db->where('member_id', $member_id);

        $result = $this->db->get('memberdetails_info')->row();
        return $result;
    }
	
	#buboy 2019-04-01
    #for table codes count
    public function get_available_codes_count($member_id){

        $sql = "SELECT p.package_name, ".
            "(SELECT COUNT(c.code_id) FROM codes c ".
            "WHERE c.package_id = p.package_id ".
            "AND c.purchased_by = ".$member_id. " ".
            "AND c.status = 0) AS quantity ".
            "FROM packages p ".
            "WHERE p.status = 0 ".
            "GROUP BY p.package_id;";
       
        $result = $this->db->query($sql)->result();
        return $result;
    }

    public function get_member_heads($member_id){

        $this->db->where('member_id', $member_id);

        $result = $this->db->get('heads')->result();
        
        return $result;
    }

    public function get_downlines($upline_id){

        $this->db->where('upline_id', $upline_id);

        $result = $this->db->get('heads')->result();

        return $result;
    }

    public function get_head_list($head_ids_array){

        $this->db->where_in('head_id', $head_ids_array);
        $result = $this->db->get('heads')->result();

        #error_log(print_r($this->db->last_query(), true), 0);

        return $result;
    }

    public function insert_member_details($data)
    {
        $this->db->insert('members_detail', $data);
        return $this->db->insert_id();
    }

    public function update_member_details($data)
    {
        $this->db->where('member_id', $data['member_id']);
        $this->db->update('members_detail', $data);

        #error_log(print_r($this->db->last_query(), true), 0);
    }    

    public function update_encashments($data)
    {
        $this->db->update('members_detail', $data);

        #error_log(print_r($this->db->last_query(), true), 0);
    } 

    public function execCDAddSponsor($SponsorHeadId){

        $result = $this->db->query('CALL CDAddSponsor(?)', array('SponsorHeadID' => $SponsorHeadId));

        return $result;
    }

    public function execPayLiteAddSponsor($SponsorHeadID, $HeadID){

        $result = $this->db->query('CALL PayLiteAddSponsor(?,?)', array('SponsorHeadID' => $SponsorHeadID, 'HeadID' => $HeadID));

        return $result;
    }

    public function execGoldAddSponsor($SponsorHeadId){

        $result = $this->db->query('CALL GoldAddSponsor(?)', array('SponsorHeadID' => $SponsorHeadId));

        return $result;
    }

    public function execCDAwardGSC($NewHeadID){

        $result = $this->db->query('CALL CDAwardGSC(?)', array('NewHeadID' => $NewHeadID));

        return $result;
    }

    public function execGoldAwardGSC($NewHeadID){

        $result = $this->db->query('CALL GoldAwardGSC(?)', array('NewHeadID' => $NewHeadID));

        return $result;
    }

    public function get_member_wallet($member_id){

        $this->db->where('member_id', $member_id);

        $result = $this->db->get('member_wallet')->row();
        return $result;
    }

    public function get_member_star_wallet($member_id){

        $this->db->where('member_id', $member_id);

        $result = $this->db->get('member_star_wallet')->row();
        return $result;
    }

    public function get_member_wallet_history($member_id){

        $this->db->where('member_id', $member_id);

        $result = $this->db->get('member_wallet_history')->row();
        return $result;
    }    

    public function update_member_wallet($data)
    {
        $this->db->where('member_id', $data['member_id']);
        $this->db->update('member_wallet', $data);
    }  

    public function update_member_star_wallet($data)
    {
        $this->db->where('member_id', $data['member_id']);
        $this->db->update('member_star_wallet', $data);
    }     

    public function insert_member_wallet_history($data)
    {
        $this->db->insert('member_wallet_history', $data);
        return $this->db->insert_id();
    } 

    public function insert_member_star_wallet_history($data)
    {
        $this->db->insert('member_star_wallet_history', $data);
        return $this->db->insert_id();
    } 

    public function insert_member_wallet($data)
    {
        $this->db->insert('member_wallet', $data);
        return $this->db->insert_id();
    }    

    public function insert_member_star_wallet($data)
    {
        $this->db->insert('member_star_wallet', $data);
        return $this->db->insert_id();
    } 

    public function get_wallet_history_dtable($head_id = false, $member_id, $order_by = false)
    {

        if ($head_id) $this->db->where('head_id', $head_id);

        if ($order_by) $this->db->order_by($order_by);
        
        $this->db->where('member_id', $member_id);


        $result = $this->db->get('member_wallet_history')->result();
        
        return $result;
    }

    public function get_star_wallet_dtable($head_id = false, $member_id, $order_by = false)
    {

        if ($head_id) $this->db->where('head_id', $head_id);

        if ($order_by) $this->db->order_by($order_by);

        $this->db->where('head_status', 0);
        
        $this->db->where('member_id', $member_id);


        $result = $this->db->get('member_all')->result();
        
        return $result;
    }

    public function get_star_wallet_history_dtable($head_id = false, $member_id, $order_by = false)
    {

        if ($head_id) $this->db->where('head_id', $head_id);

        if ($order_by) $this->db->order_by($order_by);
        
        $this->db->where('member_id', $member_id);


        $result = $this->db->get('member_star_wallet_history')->result();
        
        return $result;
    }

    public function get_search_result($username = false, $first_name = false,  $middle_name = false, $last_name = false, $email = false, $order_by = false)
    {

        $this->db->select('*');
        $this->db->from('members_detail'); 
        $this->db->join('members', 'members.member_id = members_detail.member_id');

        if($username){
            $this->db->like('members.username', $username);
        }

        if($first_name){
            $this->db->like('members_detail.first_name', $first_name);
            $this->db->or_like('members_detail.middle_name', $first_name);            
            $this->db->or_like('members_detail.last_name', $first_name);            
        }

        if($middle_name){
            $this->db->like('members_detail.first_name', $middle_name);
            $this->db->or_like('members_detail.middle_name', $middle_name);            
            $this->db->or_like('members_detail.last_name', $middle_name);            
        }

        if($last_name){
            $this->db->like('members_detail.first_name', $last_name);
            $this->db->or_like('members_detail.middle_name', $last_name);            
            $this->db->or_like('members_detail.last_name', $last_name);            
        }

        if($email){
            $this->db->like('members.email', $email);
        }

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get()->result();

        return $result;
    }  

    public function get_member_search_result($username = false, $first_name = false,  $middle_name = false, $last_name = false, $email = false, $order_by = false)
    {

        $this->db->select('*');
        $this->db->from('members_detail'); 
        $this->db->join('members', 'members.member_id = members_detail.member_id');

        if($username){
            $this->db->like('members.username', $username);
        }

        if($first_name){
            $this->db->like('members_detail.first_name', $first_name);       
        }

        if($middle_name){
            $this->db->like('members_detail.middle_name', $middle_name);        
        }

        if($last_name){
            $this->db->like('members_detail.last_name', $last_name);           
        }

        if($email){
            $this->db->where('members.email', $email);
        }

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get()->result();

        return $result;
    } 

    public function update_member($data)
    {
        $this->db->where('member_id', $data['member_id']);
        $this->db->update('members', $data);
    }

    public function check_member_email($email)
    {
        return $this->db->where('email', $email)->limit(1)->count_all_results('members') > 0;
    }

    public function check_member_username($username)
    {
        return $this->db->where('username', $username)->limit(1)->count_all_results('members') > 0;
    }

    public function insert_member($data)
    {
        $this->db->insert('members', $data);
        return $this->db->insert_id();
    }
}