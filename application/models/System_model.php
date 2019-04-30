<?php

class System_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save_system_log($data)
    {
        $this->db->insert('system_logs', $data);
        return $this->db->insert_id();
    }

    public function get_all_system_log()
    {
        $this->db->order_by('system_log_id', 'desc');

        $result = $this->db->get('system_logs')->result();
        return $result;
    } 

    public function get_settings($systemkey){

        $this->db->where('systemkey', $systemkey);
        $result = $this->db->get('settings_system');
        
        $return = array();
        foreach($result->result() as $results)
        {
            $return[$results->setting_key]  = $results->setting;
        }
        return $return;        
    }

    public function get_elite_settings(){

        $result = $this->db->get('settings_elite');
        
        $return = array();
        foreach($result->result() as $results)
        {
            $return[$results->name]  = $results->value;
        }
        return $return;        
    }

    function save_settings($code, $values)
    {
    
        $settings   = $this->get_settings($code);

        foreach($values as $key=>$value)
        {
            if(array_key_exists($key, $settings))
            {
                $update = array('setting'=>$value);
                $this->db->where('systemkey', $code);
                $this->db->where('setting_key',$key);
                $this->db->update('settings_system', $update);
            }
            else
            {
                $insert = array('systemkey'=>$code, 'setting_key'=>$key, 'setting'=>$value);
                $this->db->insert('settings_system', $insert);
            }
            
        }        
    }    

    function save_elite_settings($values)
    {
    
        $settings   = $this->get_elite_settings();

        foreach($values as $key=>$value)
        {
            if(array_key_exists($key, $settings))
            {
                $update = array('value'=>$value);
                $this->db->where('name',$key);
                $this->db->update('settings_elite', $update);
            }
            else
            {
                $insert = array('name'=>$key, 'value'=>$value);
                $this->db->insert('settings_elite', $insert);
            }
            
        }        
    }    
}