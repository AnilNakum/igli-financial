<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Common extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->dbforge();
    }

    public function query($query, $type)
    {
        if($type != ''){
            return $this->db->query($query)->$type();
        }else{
            return $this->db->query($query);
        }
    }

    public function create_table($table,$fields) {
        array_push($fields,'is_deleted INT default 0');
        array_push($fields,'created_at datetime default current_timestamp');
        $this->dbforge->add_field($fields);
        return $this->dbforge->create_table($table, TRUE);
    }

    public function add_field($table,$fields) {
        return $this->db->add_field($table, $fields);
    }

    public function field_exists($field,$table,$data) {
        $DB = $this->db;
        if (!$this->db->field_exists($field,$table))
        {   
            $fields = array(
                $field => $data
            );         
            // pr($fields);die;
            return $this->dbforge->add_column($table, $fields);//$this->add_field($table,$fields);
        }
        return;
    }

    public function get_info($table = "", $id = false, $field = "id", $whereCon = "", $all_field = '*', $join = false, $GroupBy = false, $OrderBy = false, $having = false)
    {
        $this->db->select($all_field);
        if ($join) {
            if (isset($join['table'])) {
                $this->db->join($join['table'], $join['on'], $join['type']);
            } else {
                foreach ($join as $j) {
                    $this->db->join($j['table'], $j['on'], $j['type']);
                }
            }
        }
        if ($OrderBy) {
            if (isset($OrderBy['field'])) {
                $this->db->order_by($OrderBy['field'], $OrderBy['order']);
            } else {
                foreach ($OrderBy as $Order) {
                    $this->db->order_by($Order['field'], $Order['order']);
                }
            }

        }
        if (!empty($whereCon)) {
            $this->db->where($whereCon);
        }

        if ($having) {
            $this->db->having($having);
        }

        if ($GroupBy) {
            $this->db->group_by($GroupBy);
        }

        if ($id && $field) {
            $this->db->where($field, $id);
        }
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function get_all_info($table = "", $id = '', $field = "id", $whereCon = "", $all_field = '*', $join = false, $GroupBy = false, $OrderBy = false, $count = false, $limit = false, $offset = false, $having = false, $QueryGet = false, $SubQuery = false)
    {
        if (!empty($table)) {
            $this->db->select($all_field);
            if (!empty($whereCon)) {
                $this->db->where($whereCon);
            }

            if ($join && count($join) > 0) {
                if (isset($join['table'])) {
                    $this->db->join($join['table'], $join['on'], $join['type']);
                } else {
                    foreach ($join as $j) {
                        $this->db->join($j['table'], $j['on'], $j['type']);
                    }
                }

            }
            if ($OrderBy) {
                if (isset($OrderBy['field'])) {
                    $this->db->order_by($OrderBy['field'], $OrderBy['order']);
                } else {
                    foreach ($OrderBy as $Order) {
                        $this->db->order_by($Order['field'], $Order['order']);
                    }
                }

            }
            if ($limit) {
                $this->db->limit($limit);
            }

            if ($offset) {
                $this->db->offset($offset);
            }

            if ($having) {
                $this->db->having($having);
            }

            if ($id != "") {
                $this->db->where($field, $id);
            }

            if ($GroupBy) {
                $this->db->group_by($GroupBy);
            }

            $query = $this->db->get($table);
            if ($count) {
                if ($QueryGet) {
                    return array($this->db->last_query(), $query->num_rows());
                } else {
                    return $query->num_rows();
                }
            }

            if ($query->num_rows() > 0) {
                if ($QueryGet) {
                    return array($this->db->last_query(), $query->result());
                } else {
                    if ($SubQuery && is_array($SubQuery)) {
                        $MainResult = array();
                        foreach ($query->result() as $key => $result):
                            $result = (array) $result;
                            if (!isset($SubQuery['return_field'])) {
                                foreach ($SubQuery as $SubQuery2) {
                                    $_SubQuery = array();
                                    $params = array('return_field', 'table', 'id', 'field', 'where', 'select', 'join', 'group', 'order', 'count', 'limit', 'offset', 'having', 'query', 'subquery');
                                    foreach ($params as $param) {
                                        $_SubQuery[$param] = (isset($SubQuery2[$param])) ? $SubQuery2[$param] : "";
                                    }

                                    $SubResult = $this->get_all_info($_SubQuery['table'], $result[$_SubQuery['id']], $_SubQuery['field'], $_SubQuery['where'], $_SubQuery['select'], $_SubQuery['join'], $_SubQuery['group'], $_SubQuery['order'], $_SubQuery['count'], $_SubQuery['limit'], $_SubQuery['offset'], $_SubQuery['having'], $_SubQuery['query'], $_SubQuery['subquery']);
                                    $result[$_SubQuery['return_field']] = $SubResult;
                                }
                                $MainResult[$key] = (object) $result;
                            } else {
                                $_SubQuery = array();
                                $params = array('return_field', 'table', 'id', 'field', 'where', 'select', 'join', 'group', 'order', 'count', 'limit', 'offset', 'having', 'query', 'subquery');
                                foreach ($params as $param) {
                                    $_SubQuery[$param] = (isset($SubQuery[$param])) ? $SubQuery[$param] : "";
                                }

                                $SubResult = $this->get_all_info($_SubQuery['table'], $result[$_SubQuery['id']], $_SubQuery['field'], $_SubQuery['where'], $_SubQuery['select'], $_SubQuery['join'], $_SubQuery['group'], $_SubQuery['order'], $_SubQuery['count'], $_SubQuery['limit'], $_SubQuery['offset'], $_SubQuery['having'], $_SubQuery['query'], $_SubQuery['subquery']);
                                $result[$_SubQuery['return_field']] = $SubResult;
                                $MainResult[$key] = (object) $result;
                            }
                        endforeach;
                        return (object) $MainResult;
                    } else {
                        return $query->result();
                    }
                }
            }
        }
        if ($QueryGet) {
            return array($this->db->last_query(), array());
        } else {
            return array();
        }
    }

    public function add_info($table = "", $data = "")
    {
        if (!empty($data) && !empty($table)) {
            $this->db->insert($table, $data);
            return $this->db->insert_id();
        }
        return null;
    }

    public function update_info($table, $id, $data, $field = "id", $whereCon = "", $ifAffected = false)
    {
        if (!empty($id) && !empty($table)) {
            if (!empty($whereCon)) {
                $this->db->where($whereCon);
            }
            $this->db->where($field, $id);
            if ($ifAffected) {
                $this->db->update($table, $data);
                if ($this->db->affected_rows() > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return $this->db->update($table, $data);
            }
        }
        return null;
    }

    public function get_list($table = "", $ValueField = 'id', $NameField = 'name', $whereCon = '', $join = false, $group_by = false, $order_by = false, $ExtraField = false, $StaticVal = false, $Seprator = '-', $other = false)
    {
        if (!empty($table)) {
            if (is_array($ExtraField)) {
                $_ExtraField = implode(',', $ExtraField);
            } else {
                $_ExtraField = $ExtraField;
            }
            $this->db->select("$ValueField, $NameField , $_ExtraField");
            if ($join) {
                if (isset($join['table'])) {
                    $this->db->join($join['table'], $join['on'], $join['type']);
                } else {
                    foreach ($join as $j) {
                        $this->db->join($j['table'], $j['on'], $j['type']);
                    }
                }
            }
            $data_array = array();
            if (!empty($whereCon)) {
                $this->db->where($whereCon);
            }
            if ($order_by) {
                $this->db->order_by($order_by);
            }
            if ($group_by) {
                $this->db->group_by($group_by);
            }
            $query = $this->db->get($table);
            if ($query->num_rows() > 0) {
                $NValueField = str_replace('.', '', trim(substr($ValueField, strpos($ValueField, '.'))));
                if (is_array($ExtraField)) {
                    foreach ($ExtraField as $NewField) {
                        $NExtraField[] = str_replace('.', '', trim(substr($NewField, strpos($NewField, '.'))));
                    }
                } else {
                    $NExtraField = str_replace('.', '', trim(substr($ExtraField, strpos($ExtraField, '.'))));
                }
                $NNameField = str_replace('.', '', trim(substr($NameField, strpos($NameField, '.'))));

                foreach ($query->result() as $row) {
                    if ($ExtraField) {
                        if (is_array($NExtraField)) {
                            $NField = '';
                            foreach ($NExtraField as $Filed) {
                                if ($NField != '') {
                                    $x = " $Seprator ";
                                } else {
                                    $x = '';
                                }
                                $NField = $NField . $x . $row->$Filed;
                            }
                            $data_array[$row->$NValueField] = $row->$NNameField . ' ( ' . $NField . ' )';
                        } else {
                            if ($other) {
                                $data_array[$row->$NValueField] = $row->$NNameField . ' ' . $row->$NExtraField;
                            } else {
                                $data_array[$row->$NValueField] = $row->$NNameField . ' (' . $row->$NExtraField . ')';
                            }
                        }
                    } elseif ($StaticVal && $ExtraField) {
                        $data_array[$row->$NValueField] = $row->$NNameField . ' (' . $row->$NExtraField . ' - ' . $StaticVal . ')';
                    } elseif ($StaticVal) {
                        $data_array[$row->$NValueField] = $row->$NNameField . ' (' . $StaticVal . ')';
                    } else {
                        $data_array[$row->$NValueField] = $row->$NNameField;
                    }
                }
            }
            return $data_array;
        }
        return null;
    }

    public function get_user_id_by_detail($user_id = false)
    {
        if ($user_id) {
            $this->db->select('*');
            $this->db->where("id", $user_id);
            $query = $this->db->get(TBL_USERS);
            if ($query->num_rows() > 0) {
                return $query->row();
            }
        }
        return false;
    }

    public function check_is_exists($table, $name, $field_name = "", $id = 0, $field = "id", $whereCon = "")
    {
        $name = strtolower(preg_replace('#[^\w()/.%\-&]#', " ", $name));

        $this->db->select($field_name);
        if ($id > 0 && $id != '') {
            $this->db->where($field . ' != ', $id);
        }

        $this->db->where($field_name, $name);
        if (!empty($whereCon)) {
            $this->db->where($whereCon);
        }
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    public function remove_data($table, $id, $field, $whereCon = "")
    {
        $this->db->where($field, $id);
        if (!empty($whereCon)) {
            $this->db->where($whereCon);
        }
        return $this->db->delete($table);
    }

    public function soft_remove_data($table, $id, $field, $data, $whereCon = "")
    {
        if (!empty($id) && !empty($table)) {
            if (!empty($whereCon)) {
                $this->db->where($whereCon);
            }
            $this->db->where($field, $id);
            return $this->db->update($table, $data);
        }
        return null;
    }

    public function get_last_id($table, $id)
    {
        $this->db->select($id);
        $this->db->limit(1);
        $this->db->order_by($id, "DESC");
        $query = $this->db->get($table);
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;
    }

    public function check_username($username = '', $id = 0)
    {
        $this->db->select('*');
        if ($id > 0) {
            $this->db->where('id!=', $id);
        }

        $this->db->where('username', $username);
        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return null;
    }
}