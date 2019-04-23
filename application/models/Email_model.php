<?php
class Email_model extends CI_Model {

	public function get_message($id)
	{
		$res = $this->db->where('id', $id)->get('email_templates');
		return $res->row_array();
	}

	public function get_email_group($id)
	{
		$res = $this->db->where('id', $id)->get('email_groups');
		return $res->row_array();
	}


    public function bulk_email_members()
    {
    	$this->db->where('activation_email_sent', 0);
    	$this->db->where('is_corpo !=', 1);
    	$this->db->where('email !=', '');
        $this->db->limit(50);

        $result = $this->db->get('members')->result();
        return $result;
    }
}