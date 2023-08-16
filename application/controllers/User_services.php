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

    public function update($id)
    {
        $link = $_SERVER['HTTP_HOST'];
        $link_array = explode('/',$link);
        $page = end($link_array);
        $id = decrypt($id);
        if ($id > 0) {
            $data_obj = $this->Common->get_info(TBL_USER_SERVICES, $id, 'ID');
            if (is_object($data_obj) && count((array) $data_obj) > 0) {
                $data["us_info"] = $data_obj;
            } else {
                redirect('services/'.$page);
            }
        }
        $data['page_title'] = "Update Services Status";
        $data['type'] = $data_obj->ServiceStatus;
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
                $Reason = ($this->input->post('reason'))?$this->input->post('reason'):"None";
                $post_data = array(
                    "ServiceID" => $this->input->post('service_id'),
                    "UserID" => $this->input->post('user_id'),
                    "ServiceStatus" => $this->input->post('service_status'),
                    "ProgressStatus" => ($this->input->post('progress_status'))?$this->input->post('progress_status'):"On Going",
                    "Reason" => $Reason
                );
                
                if ($ID > 0) {
                    $userService =  $this->Common->get_info(TBL_USER_SERVICES, $ID, 'ID');
                    $user = $this->Common->get_info(TBL_USERS, $this->input->post('user_id'),'id');
                    $service = $this->Common->get_info(TBL_SERVICES, $this->input->post('service_id'),'ServiceID');

                    if($userService->ServiceStatus != $this->input->post('service_status')){
                        if($this->tank_auth->get_user_id() == 1){
                            $Name = 'Parth Mavani';
                        }else{
                            $subAdmin = $this->Common->get_info(TBL_USERS, $this->tank_auth->get_user_id(),'id');
                            $Name = $subAdmin->first_name.' '.$subAdmin->last_name;
                        }

                        if($user){
                            if($this->input->post('service_status') == 'onhold'){
                                $msgData = array(
                                    "name"=> 'service_hold_xv',
                                    "languageCode"=> "en", 
                                    'headerValues' => array(),
                                    'bodyValues' => array($Name,$service->ServiceTitle,$Reason),
                                );
                                send_wp_msg($user->phone,$msgData);
                            }else if($this->input->post('service_status') == 'completed'){
                                $msgData = array(
                                    "name"=> 'service_complete',
                                    "languageCode"=> "en", 
                                    'headerValues' => array(),
                                    'bodyValues' => array($service->ServiceTitle,$Name),
                                );
                                send_wp_msg($user->phone,$msgData);
                            }else{
                                $msgData = array(
                                    "name"=> 'ongoing_services',
                                    "languageCode"=> "en", 
                                    'headerValues' => array(),
                                    'bodyValues' => array($service->ServiceTitle,$Name),
                                );
                                send_wp_msg($user->phone,$msgData);
                            }
                        }
                    }

                    if($userService->ProgressStatus != $this->input->post('progress_status')){
                        if($this->input->post('progress_status') == 'Pending By Customer'){
                            $mailData = array(
                                'username' => $user->name,
                                'ServiceTitle' => $service->ServiceTitle,
                                'progressStatus' => 'Pending By Customer',
                                'Reason' => $Reason,
                                'site_name' => $this->config->item('website_name', 'tank_auth')
                            );
                            $Subject = $this->config->item('website_name', 'tank_auth').' Service:'.$service->ServiceTitle.' Status';
                            $this->_send_email($Subject,'pending_customer', $user->email, $mailData);
                        }
                    }

                    $post_data['UpdatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
                    if ($this->Common->update_info(TBL_USER_SERVICES, $ID, $post_data, 'ID')) {
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    } else {
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                     }
                }else{
                    if($this->input->post('service_status') == 'ongoing'){
                        $user = $this->Common->get_info(TBL_USERS, $this->input->post('user_id'),'id');
                        $service = $this->Common->get_info(TBL_SERVICES, $this->input->post('service_id'),'ServiceID');
                        if($this->tank_auth->get_user_id() == 1){
                            $Name = 'Parth Mavani';
                        }else{
                            $subAdmin = $this->Common->get_info(TBL_USERS, $this->tank_auth->get_user_id(),'id');
                            $Name = $subAdmin->first_name.' '.$subAdmin->last_name;
                        }
                        
                        $msgData = array(
                            "name"=> 'ongoing_services',
                            "languageCode"=> "en", 
                            'headerValues' => array(),
                            'bodyValues' => array($service->ServiceTitle,$Name),
                        );
                        send_wp_msg($user->phone,$msgData);
                    }

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
        if($page == 'ongoing'){
            $this->datatables->select('us.ID,s.ServiceTitle,CONCAT(u.first_name," ",u.last_name) as  name,us.ProgressStatus,us.CreatedAt');
        }else{
            $this->datatables->select('us.ID,s.ServiceTitle,CONCAT(u.first_name," ",u.last_name) as  name,us.CreatedAt');
        }
        
        $this->datatables->where('us.isDeleted', 0);
        $this->datatables->where('us.ServiceStatus',  $page );
    
        if(ROLE == 2){
            $this->datatables->where_in('s.ServiceID',USER_SERVICE);
        }
        
        $this->datatables->join(TBL_SERVICES . ' s', 's.ServiceID=us.ServiceID', '');
        $this->datatables->join(TBL_USERS . ' u', 'u.id=us.UserID', '');
        $this->datatables->from(TBL_USER_SERVICES.' us')
            ->edit_column('us.CreatedAt', '$1', 'DatetimeFormat(us.CreatedAt)');
        // if($page == 'ongoing'){
        //     $this->datatables->edit_column('us.CreatedAt', '$1', 'DatetimeFormat(us.CreatedAt)');
        // }
        $this->datatables->add_column('action', '$1', 'user_service_action_row(us.ID)');
        $this->datatables->unset_column('us.ID');
        echo $this->datatables->generate();
    }

    public function _send_email($subject,$type, $email, &$data)
    {
        $this->load->library('email');
        $this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
        $this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
        $this->email->to($email);
        $this->email->subject($subject, $this->config->item('website_name', 'tank_auth'));
        $this->email->message($this->load->view('email/' . $type . '-html', $data, true));
        $this->email->set_alt_message($this->load->view('email/' . $type . '-txt', $data, true));
        $this->email->send();
        // echo $this->email->print_debugger();
        // exit;
        return;
    }
}