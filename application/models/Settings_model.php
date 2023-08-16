<?php

class Settings_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_settings($code='')
    {
        if($code != ''){
            $this->db->where('Code', $code);
        }
        $result = $this->db->get(TBL_SETTINGS);
        $return = array();
        foreach ($result->result() as $results) {
            $return[$results->SettingKey] = $results->SettingValue;
        }
        return $return;
    }

    /*
    settings should be an array
    array('setting_key'=>'setting')
    $code is the item that is calling it
    ex. any shipping settings have the code "shipping"
     */

    public function save_settings($code, $values)
    {

        //get the settings first, this way, we can know if we need to update or insert settings
        //we're going to create an array of keys for the requested code
        $settings = $this->get_settings($code);

        //loop through the settings and add each one as a new row
        foreach ($values as $key => $value) {
            //if the key currently exists, update the setting
            if (array_key_exists($key, $settings)) {
                $update = array('SettingValue' => $value);
                $this->db->where('Code', $code);
                $this->db->where('SettingKey', $key);
                $this->db->update(TBL_SETTINGS, $update);
            }
            //if the key does not exist, add it
            else {
                $insert = array('Code' => $code, 'SettingKey' => $key, 'SettingValue' => $value);
                $this->db->insert(TBL_SETTINGS, $insert);
            }
        }
    }

    //delete any settings having to do with this particular code
    public function delete_settings($code)
    {
        $this->db->where('Code', $code);
        $this->db->delete(TBL_SETTINGS);
    }

    //this deletes a specific setting
    public function delete_setting($code, $setting_key)
    {
        $this->db->where('Code', $code);
        $this->db->where('setting_key', $setting_key);
        $this->db->delete(TBL_SETTINGS);
    }
}