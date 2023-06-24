<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Remove extends Base_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Remove_records');
        if ($this->input->post('pass') && $this->input->post('pass') != ""):
            if (!$this->check_pass(base64_decode($this->input->post('pass')))):
                $response = array('status' => 'error', 'message' => 'Password not matched.');
                $this->response($response);
            endif;
        else:
            $response = array('status' => 'error', 'message' => 'Password field should not be blank.');
            $this->response($response);
        endif;
    }

    function check_pass($password) {
        $user = $this->users->get_user_by_username($this->tank_auth->get_username());
        if (count((array) $user) > 0):
            $hasher = new PasswordHash(
                    $this->config->item('phpass_hash_strength', 'tank_auth'), $this->config->item('phpass_hash_portable', 'tank_auth'));
            if ($hasher->CheckPassword($password, $user->password)):
                return TRUE;
            endif;
        endif;

        return FALSE;
    }

    function response($response) {
        echo json_encode($response);
        die;
    }

    function banner($did = 0, $field = 'BannerID') {
        $id = ($did > 0) ? $did : (($this->input->post('id')) ? $this->input->post('id') : 0);
        $where = ($this->input->post('where')) ? $this->input->post('where') : '';
        $type = $this->input->post('type');
        $id = decrypt($id);
        if ($id > 0):
            $data_remove = $this->Remove_records->remove_data($id, $field, TBL_BANNER,$where,$type);
            if ($did > 0):
                return ($data_remove) ? TRUE : FALSE;
            else:
                $response = ($data_remove) ? array('status' => 'ok', 'message' => 'Data deleted successfully!') : array('status' => 'ok', 'message' => 'Data not deleted successfully!');
                $this->response($response);
            endif;

        endif;
    }

    function service_type($did = 0, $field = 'STID') {
        $id = ($did > 0) ? $did : (($this->input->post('id')) ? $this->input->post('id') : 0);
        $where = ($this->input->post('where')) ? $this->input->post('where') : '';
        $type = $this->input->post('type');
        $id = decrypt($id);
        if ($id > 0):
            $data_remove = $this->Remove_records->remove_data($id, $field, TBL_SERVICE_TYPE, $where,$type);
            if ($did > 0):
                return ($data_remove) ? TRUE : FALSE;
            else:
                $response = ($data_remove) ? array('status' => 'ok', 'message' => 'Data deleted successfully!') : array('status' => 'ok', 'message' => 'Data not deleted successfully!');
                $this->response($response);
            endif;

        endif;
    }

    function service($did = 0, $field = 'ServiceID') {
        $id = ($did > 0) ? $did : (($this->input->post('id')) ? $this->input->post('id') : 0);
        $where = ($this->input->post('where')) ? $this->input->post('where') : '';
        $type = $this->input->post('type');
        $id = decrypt($id);
        if ($id > 0):
            $data_remove = $this->Remove_records->remove_data($id, $field, TBL_SERVICES, $where,$type);
            if ($did > 0):
                return ($data_remove) ? TRUE : FALSE;
            else:
                $response = ($data_remove) ? array('status' => 'ok', 'message' => 'Data deleted successfully!') : array('status' => 'ok', 'message' => 'Data not deleted successfully!');
                $this->response($response);
            endif;

        endif;
    }

    function user($did = 0, $field = 'id') {
        $id = ($did > 0) ? $did : (($this->input->post('id')) ? $this->input->post('id') : 0);
        $where = ($this->input->post('where')) ? $this->input->post('where') : '';
        $type = $this->input->post('type');
        $id = decrypt($id);
        if ($id > 0):
            $data_remove = $this->Remove_records->remove_data($id, $field, TBL_USERS, $where,$type);
            if ($did > 0):
                return ($data_remove) ? TRUE : FALSE;
            else:
                $response = ($data_remove) ? array('status' => 'ok', 'message' => 'Data deleted successfully!') : array('status' => 'ok', 'message' => 'Data not deleted successfully!');
                $this->response($response);
            endif;

        endif;
    }

    function document($did = 0, $field = 'ID') {
        $id = ($did > 0) ? $did : (($this->input->post('id')) ? $this->input->post('id') : 0);
        $where = ($this->input->post('where')) ? $this->input->post('where') : '';
        $type = $this->input->post('type');
        $id = decrypt($id);
        if ($id > 0):
            $data_remove = $this->Remove_records->remove_data($id, $field, TBL_DOCUMENT,$where,$type);
            if ($did > 0):
                return ($data_remove) ? TRUE : FALSE;
            else:
                $response = ($data_remove) ? array('status' => 'ok', 'message' => 'Data deleted successfully!') : array('status' => 'ok', 'message' => 'Data not deleted successfully!');
                $this->response($response);
            endif;

        endif;
    }

    function user_service($did = 0, $field = 'ID') {
        $id = ($did > 0) ? $did : (($this->input->post('id')) ? $this->input->post('id') : 0);
        $where = ($this->input->post('where')) ? $this->input->post('where') : '';
        $type = $this->input->post('type');
        $id = decrypt($id);
        if ($id > 0):
            $data_remove = $this->Remove_records->remove_data($id, $field, TBL_USER_SERVICES,$where,$type);
            if ($did > 0):
                return ($data_remove) ? TRUE : FALSE;
            else:
                $response = ($data_remove) ? array('status' => 'ok', 'message' => 'Data deleted successfully!') : array('status' => 'ok', 'message' => 'Data not deleted successfully!');
                $this->response($response);
            endif;

        endif;
    }

    

}