<?php

class Packages_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_packages()
    {
        $this->db->where('status', 0);
        $result = $this->db->get('packages')->result();

        return $result;
    }

    public function get_package($package_id){

        $this->db->where('package_id', $package_id);

        $result = $this->db->get('packages')->row();
        return $result;
    }

    public function get_all_packages($order_by = false)
    {

        if ($order_by) $this->db->order_by($order_by);

        $result = $this->db->get('packages')->result();

        return $result;
    }

    public function insert_package($data)
    {
        $this->db->insert('packages', $data);
        return $this->db->insert_id();
    }

    public function update_package($data)
    {
        $this->db->where('package_id', $data['package_id']);
        $this->db->update('packages', $data);
    }  
}