<?php

class Settings_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_cities()
    {
        $this->db->group_by('name');
        $this->db->order_by('name', 'ASC');

        $result = $this->db->get('cities')->result();

        return $result;
    } 

    public function get_all_provinces()
    {
        $this->db->order_by('name', 'ASC');

        $result = $this->db->get('provinces')->result();

        return $result;
    }

    public function get_all_citizenships()
    {
        $this->db->order_by('nationality', 'ASC');

        $result = $this->db->get('citizenship')->result();

        return $result;
    }

    public function get_setting_member($status_number)
    {
        $this->db->where('status_number', $status_number);

        $result = $this->db->get('settings_member')->row();
        return $result;
    }

    public function get_setting_members()
    {
        $result = $this->db->get('settings_member')->result();

        return $result;
    }
}