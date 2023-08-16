<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting extends Base_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('language');
        $this->lang->load('setting');
    }

    public function index()
    {
        $data['config_date'] = $this->Settings_model->get_settings('default');
        $data['page_title'] = "General Setting";
        $this->view('setting/manage', $data);
    }

    public function submit_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            foreach ($this->input->post() as $key => $value) {
                    $this->form_validation->set_rules($key, 'lang:' . $key, 'required');
            }
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {
                $save = $this->input->post();
                $this->Settings_model->save_settings('default', $save);

                $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
            } else {
                $response['error'] = $this->form_validation->error_array();
            }
            echo json_encode($response);
            die;
        }
    }

    public function pages()
    {
        $data['config_date'] = $this->Settings_model->get_settings('page');
        $data['page_title'] = "Help Pages Setting";
        $this->view('setting/pages', $data);
    }

    public function submit_page_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            foreach ($this->input->post() as $key => $value) {
                $this->form_validation->set_rules($key, 'lang:' . $key, 'required');
            }
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {
                $save = $this->input->post();
                $this->Settings_model->save_settings('page', $save);
                $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
            } else {
                $response['error'] = $this->form_validation->error_array();
            }
            echo json_encode($response);
            die;
        }
    }

}