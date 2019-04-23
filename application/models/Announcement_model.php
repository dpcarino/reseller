<?php

class Announcement_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_announcements()
    {
        $this->db->order_by('announcement_id', 'desc');
        $this->db->limit(2);

        $result = $this->db->get('announcements')->result();
        return $result;
    }

    public function get_all_announcements()
    {
        $this->db->order_by('announcement_id', 'desc');

        $result = $this->db->get('announcements')->result();
        return $result;
    }    

    public function get_announcement($announcement_id){

        $this->db->where('announcement_id', $announcement_id);

        $result = $this->db->get('announcements')->row();
        return $result;
    }

    public function get_announcement_notif(){

        $this->db->where('notify', 1);

        $result = $this->db->get('announcements')->row();
        return $result;
    }

    public function insert_annoucement($data)
    {
        $this->db->insert('announcements', $data);
        return $this->db->insert_id();
    }

    public function update_annoucement($data)
    {
        $this->db->where('announcement_id', $data['announcement_id']);
        $this->db->update('announcements', $data);
    }           
}