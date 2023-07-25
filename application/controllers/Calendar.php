<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Calendar extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_title'] = "Compliance Calendar";
        $data['extra_js'] = ["fullcalendarscripts.bundle","calendar"];
        $this->view('calendar/calendar', $data);
    }

    public function add()
    {
        $data['page_title'] = "Add New Event ";
        $this->partial('calendar/event-form', $data);
    }

    public function update($id)
    {
        $id = decrypt($id);
        if ($id > 0) {
            $data_obj = $this->Common->get_info(TBL_EVENT, $id, 'ID');
            if (is_object($data_obj) && count((array) $data_obj) > 0) {
                $data["event_info"] = $data_obj;
            } else {
                redirect('calendar/');
            }
        }
        $data['page_title'] = "Update Event";
        $this->partial('calendar/event-form', $data);
    }

    public function submit_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $ID = ($this->input->post('id') && $this->input->post('id') > 0) ? $this->input->post('id') : 0;
            $this->form_validation
                ->set_rules('event_date', 'Event Date', 'required')
                ->set_rules('title', 'Event Title', 'required')
                ->set_rules('description', 'Event Description', 'required');
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {
                $dateTime = DateTime::createFromFormat('l d F Y - h:i A', $this->input->post('event_date'));
                $EventDate = $dateTime->format('Y-m-d H:i:s');

                $post_data = array(
                    "Title" => $this->input->post('title'),
                    "Description" => $this->input->post('description'),
                    "DateTime" => $EventDate,
                    "Status" => $this->input->post('status')
                );

                
                if ($ID > 0) {
                    $post_data['UpdatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
                    if ($this->Common->update_info(TBL_EVENT, $ID, $post_data, 'ID')) :
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    else :
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    endif;
                }else{
                    $post_data['CreatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['CreatedAt'] = date("Y-m-d H:i:s");
                    if ($ID = $this->Common->add_info(TBL_EVENT, $post_data)) {
                        $response = array("status" => "ok", "heading" => "Add successfully...", "message" => "Details added successfully.");
                    } else {
                        $response = array("status" => "error", "heading" => "Not Added successfully...", "message" => "Details not added successfully.");
                    }
                }

            } else {
                $response['error'] = $this->form_validation->error_array();
            }
            echo json_encode($response);
            die;
        }
    }
}