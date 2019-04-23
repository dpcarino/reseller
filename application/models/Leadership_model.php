<?php

class Leadership_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert_preprocess($data)
    {
        $this->db->insert('leadership_preprocess', $data);
        return $this->db->insert_id();
    }

    public function insert_processed($data)
    {
        $this->db->insert('leadership_processed', $data);
        return $this->db->insert_id();
    }

    public function ProcessWeeklyIncome($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL ProcessWeeklyIncome(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership1($vcTransactionID){
        
        $this->db->trans_begin();

        $this->db->query('CALL Leadership1(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership2($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership2(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership3($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership3(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership4($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership4(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership5($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership5(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership6($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership6(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership7($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership7(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership8($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership8(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership9($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership9(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership10($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership10(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership11($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership11(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership12($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership12(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership13($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership13(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership14($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership14(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function Leadership15($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL Leadership15(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function LeadershipIncome($vcTransactionID){

        $this->db->trans_begin();

        $this->db->query('CALL LeadershipIncome(?)', array('vcTransactionID' => $vcTransactionID));

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_leadership_histories($transaction_id = false, $order_by = false){

        $this->db->select('*');
        $this->db->from('leadership_transactions');

        if($transaction_id){
            $this->db->like('transaction_id', $transaction_id);
        }

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get()->result();
        
        #error_log(print_r($this->db->last_query(), true), 0);

        return $result;
    }

    public function get_leadership_history_details($transaction_id, $membername = false, $headname = false, $order_by = false){

        $this->db->select('*');
        $this->db->from('leadership_details');

        if($membername){
            $this->db->join('heads', 'heads.head_id = leadership_details.leader_id');
            $this->db->join('members_detail', 'members_detail.member_id = heads.member_id');
            $this->db->like('members_detail.first_name', $membername);
            $this->db->or_like('members_detail.middle_name', $membername);            
            $this->db->or_like('members_detail.last_name', $membername);   
        }

        if($headname){
            $this->db->join('heads', 'heads.head_id = leadership_details.leader_id');
            $this->db->like('heads.headname', $headname);
        }        

        $this->db->where('transaction_id', $transaction_id);

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get()->result();

        return $result;
    }


    public function get_leadership_history_level($transaction_id, $details_id, $order_by = false){

        $this->db->select('*');
        $this->db->from('leadership_history');

        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('details_id', $details_id);

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get()->result();
                
        return $result;
    } 

    public function get_leadership_history_gsc($transaction_id, $leader_id, $order_by = false){

        $this->db->select('*');
        $this->db->from('gsc_history');

        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('head_id', $leader_id);

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get()->result();
                
        return $result;
    }

    public function get_history_gsc($head_id, $order_by = false){

        $this->db->select('*');
        $this->db->from('gsc_history');

        $this->db->where('head_id', $head_id);

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get()->result();
                
        return $result;
    }

    public function get_leadership_history($head_id, $order_by = false){

        $this->db->select('*');
        $this->db->from('gsc_history');

        $this->db->where('head_id', $head_id);

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get()->result();
                
        return $result;
    }

    public function get_history_details($transaction_id, $head_id, $order_by = false){

        $this->db->select('*');
        $this->db->from('leadership_details');

        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('leader_id', $head_id);

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get()->result();

        return $result;
    }

    public function get_history_level($transaction_id, $head_id, $order_by = false){

        $this->db->select('*');
        $this->db->from('leadership_history');

        $this->db->where('transaction_id', $transaction_id);
        $this->db->where('leader_id', $head_id);

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get()->result();
                
        return $result;
    } 
}