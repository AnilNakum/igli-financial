<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_info($table = "", $id, $field = "id", $whereCon = "", $all_field = '*', $join = false,  $GroupBy = false, $OrderBy = false)
    {
        if (!empty($id) && !empty($table)) {
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
                if (isset($OrderBy['field']))
                    $this->db->order_by($OrderBy['field'], $OrderBy['order']);
                else
                    foreach ($OrderBy as $Order)
                        $this->db->order_by($Order['field'], $Order['order']);
            }
            if (!empty($whereCon))
                $this->db->where($whereCon);
            if ($GroupBy)
                $this->db->group_by($GroupBy);
            $this->db->where($field, $id);
            $query = $this->db->get($table);
            if ($query->num_rows() > 0)
                return $query->row();
        }
        return NULL;
    }

    function query($query, $type)
    {
        return $this->db->query($query)->$type();
    }

    function add_info($table = "", $data)
    {
        if (!empty($data) && !empty($table)) {
            $this->db->insert($table, $data);
            return $this->db->insert_id();
        }
        return NULL;
    }

    function get_user_id_by_detail($user_id = false)
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

    function update_info($table = "", $id, $data, $field = "id", $whereCon = "", $ifAffected = FALSE)
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
        return NULL;
    }

    function check_is_exists($table = "", $name, $field_name = "", $id = 0, $field = "id", $whereCon = "")
    {
        $name = strtolower(preg_replace('#[^\w()/.%\-&]#', " ", $name));

        $this->db->select($field_name);
        if ($id > 0)
            $this->db->where($field . ' != ', $id);
        $this->db->where($field_name, $name);
        if (!empty($whereCon)) {
            $this->db->where($whereCon);
        }
        $query = $this->db->get($table);
        return $query->num_rows();
    }

    function get_all_info($table = "", $id = '', $field = "id", $whereCon = "", $all_field = '*',  $join = false, $count = false, $GroupBy = false, $OrderBy = false, $limit = false, $offset = false, $having = false)
    {
        if (!empty($table)) {
            $this->db->select($all_field);
            if (!empty($whereCon))
                $this->db->where($whereCon);
            if ($join && count($join) > 0) {
                if (isset($join['table']))
                    $this->db->join($join['table'], $join['on'], $join['type']);
                else
                    foreach ($join as $j)
                        $this->db->join($j['table'], $j['on'], $j['type']);
            }
            if ($OrderBy) {
                if (isset($OrderBy['field']))
                    $this->db->order_by($OrderBy['field'], $OrderBy['order']);
                else
                    foreach ($OrderBy as $Order)
                        $this->db->order_by($Order['field'], $Order['order']);
            }
            if ($limit)
                $this->db->limit($limit);
            if ($offset)
                $this->db->offset($offset);
            if ($having)
                $this->db->having($having);
            if ($id != "")
                $this->db->where($field, $id);
            if ($GroupBy)
                $this->db->group_by($GroupBy);
            $query = $this->db->get($table);
            if ($count)
                return $query->num_rows();
            if ($query->num_rows() > 0)
                return $query->result();
        }
        return array();
    }

    function remove_data($id, $field, $table, $whereCon = "")
    {
        $this->db->where($field, $id);
        if (!empty($whereCon)) {
            $this->db->where($whereCon);
        }
        return $this->db->delete($table);
    }

    function get_all_item($table = '', $MappingTable = '', $ClassID = '', $ValueField = 'id', $NameField = 'name', $MappingField = 'id', $ClassField = '', $whereCon = '', $ExtraField = false)
    {
        if (!empty($table) && !empty($MappingTable) && !empty($ClassID)) {
            $T1 = ' T1';
            $T2 = ' T2';
            $this->db->select("$T1.$ValueField, $T1.$NameField , $ExtraField");
            $data_array = array();
            if (!empty($whereCon)) {
                $this->db->where($whereCon);
            }
            $this->db->join($MappingTable . $T2, "$T2.$MappingField = $T1.$ValueField AND $T2.$ClassField = $ClassID", 'left');
            $this->db->where("$T2.$MappingField IS NULL");
            $query = $this->db->get($table . $T1);
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    if ($ExtraField) :
                        $data_array[$row->$ValueField] = $row->$NameField . ' (' . $row->$ExtraField . ')';
                    else :
                        $data_array[$row->$ValueField] = $row->$NameField;
                    endif;
                }
            }
            return $data_array;
        }
        return Null;
    }

    function get_list($table = "", $ValueField = 'id', $NameField = 'name', $whereCon = '', $ExtraField = false, $StaticVal = false, $join = false, $order_by = false, $group_by = false)
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
                                    $x = ' - ';
                                } else {
                                    $x = '';
                                }
                                $NField = $NField . $x . $row->$Filed;
                            }
                            $data_array[$row->$NValueField] = $row->$NNameField . ' ( ' . $NField . ' )';
                        } else {
                            $data_array[$row->$NValueField] = $row->$NNameField . ' (' . $row->$NExtraField . ')';
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
        return NULL;
    }

    function get_last_id($table, $id)
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

    function check_email_id($email = '', $id = 0)
    {
        $this->db->select('*');
        if ($id > 0)
            $this->db->where('id!=', $id);
        $this->db->where('email', strtolower($email));
        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }

    function check_username($username = '', $id = 0)
    {
        $this->db->select('*');
        if ($id > 0)
            $this->db->where('id!=', $id);
        $this->db->where('username', $username);
        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }

    function get_setting_value($SettingKey)
    {
        if (!empty($SettingKey)) {
            $this->db->select('*');
            $this->db->where('SettingKey', $SettingKey);
            $query = $this->db->get(TBL_SETTING);
            if ($query->num_rows() > 0) {
                return $query->row()->SettingValue;
            }
        }
        return NULL;
    }

    function update_setting_value($SettingKey, $SettingValue)
    {
        if (!empty($SettingKey) && !empty($SettingValue)) {
            $this->db->where('SettingKey', $SettingKey);
            return $this->db->update(TBL_SETTING, array('SettingValue' => $SettingValue));
        }
        return NULL;
    }

    function check_staff_email($email, $class_id = false, $class_oprater = '=', $StaffID = false)
    {
        $this->db->select('*');
        $this->db->where('email', $email);
        $query = $this->db->get(TBL_USERS);
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            $this->db->select('*');
            if ($class_id) {
                $this->db->where('ClassID' . $class_oprater . $class_id);
            }
            if ($StaffID) {
                $this->db->where('StaffID != ' . $StaffID);
            }
            $this->db->where('Email', $email);
            $query = $this->db->get(TBL_STAFF_CLASS_MAPPING);
            if ($query->num_rows() > 0) {
                return $query->result();
            }
        }
        return NULL;
    }

    public function check_exists_email($email, $id)
    {
        $email = strtolower($email);
        $final_query = " SELECT (Email) as email FROM " . TBL_STAFF_CLASS_MAPPING . " WHERE Email = '$email' UNION ALL SELECT (email) as email FROM " . TBL_USERS . " WHERE email = '$email' AND id!=$id";
        $query = $this->db->query($final_query);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }

    public function check_exists_phone($phone, $id)
    {
        $final_query = " SELECT * FROM " . TBL_STUDENT . " WHERE Mobile = '$phone' AND UserID!=$id";
        $query = $this->db->query($final_query);
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }

    public function check_not_common_unique($email, $phone, $adharnumber)
    {
        $final_query = 'select count(*) as Total from (SELECT id as UserID, aadhar_no, email as Email, "" as Mobile, "users" as tbl_type FROM ' . TBL_USERS . ' u WHERE u.email = "' . $email . '" OR aadhar_no = "' . $adharnumber . '" UNION ALL SELECT UserID,"" as aadhar_no, "" as Email, Mobile, "student" as tbl_type FROM ' . TBL_STUDENT . ' s  WHERE Mobile = "' . $phone . '" UNION ALL SELECT st.UserID,"" as aadhar_no, Email, Mobile, "staff_class_mapping" as tbl_type FROM ' . TBL_STAFF_CLASS_MAPPING . ' sm JOIN ' . TBL_STAFF . ' as st ON st.StaffID=sm.StaffID WHERE Email = "' . $email . '" OR Mobile = "' . $phone . '") as tem GROUP BY UserID';
        $query = $this->db->query($final_query);
        if ($query->num_rows() > 1) {
            return false;
        } else {
            return true;
        }
    }

    //    function get_branch_total($SurveyID) {
    //        $Branch = $this->db->query("SELECT COUNT(cc.BranchID) AS TotalBranch FROM " . TBL_COURSE_BATCH . " cb JOIN " . TBL_SURVEY_BATCH . " sb ON sb.BatchID=cb.CourseBatchID JOIN " . TBL_CLASSES_COURSE . " cc ON cc.ClassCourseID=cb.ClassCourseID WHERE sb.SurveyID=$SurveyID GROUP BY cc.BranchID")->row();
    //        if (isset($Branch->TotalBranch)) {
    //            return $Branch->TotalBranch;
    //        } else {
    //            return 0;
    //        }
    //    }
}
