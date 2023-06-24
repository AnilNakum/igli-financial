<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User_services extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        
    }

    public function ongoing()
    {
        $data['page_title'] = "User Ongoing Services";
        $data['Services'] = $this->Common->get_all_info(TBL_USER_SERVICES,'ongoing','ServiceStatus','isDeleted=0');
        $data['type'] = "ongoing";
        $this->view('user-services/manage-user-services', $data);
    }

    public function onhold()
    {
        $data['page_title'] = "User Hold Services";
        $data['Services'] = $this->Common->get_all_info(TBL_USER_SERVICES,'onhold','ServiceStatus','isDeleted=0');
        $data['type'] = "onhold";
        $this->view('user-services/manage-user-services', $data);
    }

    public function completed()
    {
        $data['page_title'] = "User Completed Services";
        $data['Services'] = $this->Common->get_all_info(TBL_USER_SERVICES,'completed','ServiceStatus','isDeleted=0');
        $data['type'] = "completed";
        $this->view('user-services/manage-user-services', $data);
    }
    
    public function add()
    {
        $link = $_SERVER['REQUEST_URI'];
        $link_array = explode('/',$link);
        $page = end($link_array);
        $data['page_title'] = "Assign New Services";
        $data['type'] = $page;
        $data['Services'] =  $this->Common->get_list(TBL_SERVICES, 'ServiceID', 'ServiceTitle', "Status=1 AND isDeleted=0");
        $data['Users'] =  $this->Common->get_list(TBL_USERS, 'id', 'first_name', "role_id=3 AND activated=1 AND isDeleted=0",false,false,false,'username');
        $this->partial('user-services/assign-service-form', $data);
    }

    public function submit_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $ID = ($this->input->post('id') && $this->input->post('id') > 0) ? $this->input->post('id') : 0;
            $this->form_validation
                ->set_rules('service_id', 'Service', 'required')
                ->set_rules('user_id', 'User', 'required')
                ->set_rules('service_status', 'Service Status', 'required');
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {
                
                $post_data = array(
                    "ServiceID" => $this->input->post('service_id'),
                    "UserID" => $this->input->post('user_id'),
                    "ServiceStatus" => $this->input->post('service_status'),
                );
                
                if ($ID > 0) {
                    $post_data['UpdatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
                    if ($this->Common->update_info(TBL_USER_SERVICES, $ID, $post_data, 'ID')) :
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    else :
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    endif;
                }else{
                    $post_data['CreatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['CreatedAt'] = date("Y-m-d H:i:s");
                    if ($ID = $this->Common->add_info(TBL_USER_SERVICES, $post_data)) {
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

    public function manage()
    {
        $link = $_SERVER['REQUEST_URI'];
        $link_array = explode('/',$link);
        $page = end($link_array);
        $this->datatables->select('us.ID,CONCAT(u.first_name," ",u.last_name) as  name,s.ServiceTitle,us.CreatedAt');
        
        $this->datatables->where('us.isDeleted', 0);
        $this->datatables->where('us.ServiceStatus',  $page );
    
        $this->datatables->join(TBL_SERVICES . ' s', 's.ServiceID=us.ServiceID', '');
        $this->datatables->join(TBL_USERS . ' u', 'u.id=us.UserID', '');
        $this->datatables->from(TBL_USER_SERVICES.' us')
            ->edit_column('us.CreatedAt', '$1', 'DatetimeFormat(us.CreatedAt)')
            ->add_column('action', '$1', 'user_service_action_row(us.ID)');
        $this->datatables->unset_column('us.ID');
        echo $this->datatables->generate();
    }
}