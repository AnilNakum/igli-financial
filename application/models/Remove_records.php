<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Remove_records extends CI_Model {

    function __construct() {
        parent::__construct();
    }

//    public function set_db($db_name) {
//        $this->db = $this->load->database($db_name, TRUE);
//    }

    function remove_data($id, $field, $table, $where ,$type ) {
        if ($id && $field) {
            $this->db->where($field, $id);
        }
        if ($where) {
            $this->db->where($where);
        }
        if($type == 'soft'){
            $data = array(
                "isDeleted" => 1
            );
            return $this->db->update($table, $data);
        }else{
            return $this->db->delete($table);
        }
    }

}