<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Task extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_title'] = "Manage Service Task";
        $User = $this->tank_auth->get_user_id();
        $data['ServiceTask'] =  $this->Common->get_all_info(TBL_USER_SERVICES_TASK, $User, "UserID");
        $this->view('task/manage-task', $data);
    }
    public function track()
    {
        $data['page_title'] = "Track Service Task";
        $User = $this->tank_auth->get_user_id();
        $data['ServiceTask'] =  $this->Common->get_all_info(TBL_USER_SERVICES_TASK, $User, "CreatedBy");
        $this->view('task/track-task', $data);
    }

    public function add()
    {
        $data['page_title'] = "Add Banner";
        $this->partial('banners/banner-form', $data);
    }

    public function view_task($id)
    {
        $id = decrypt($id);
        if ($id > 0) {
            $data_obj = $this->Common->get_info(TBL_USER_SERVICES_TASK, $id, 'ID');
            if (is_object($data_obj) && count((array) $data_obj) > 0) {
                $join = array(
                    array('table' => TBL_SERVICES . ' s', 'on' => "s.ServiceID=us.ServiceID", 'type' => ''),
                    array('table' => TBL_USERS . ' u', 'on' => "u.id=us.UserID", 'type' => ''),
                );
                $us_obj = $this->Common->get_info(TBL_USER_SERVICES.' us', $data_obj->USID, 'us.ID','1=1','*',$join);

                $data_obj->Services = $us_obj;
                $data["task_info"] = $data_obj;
            } else {
                redirect('task/');
            }
        }
        $data['page_title'] = "View Task Details";
        $this->partial('task/view-task', $data);
    }

    public function submit_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $ID = ($this->input->post('id') && $this->input->post('id') > 0) ? $this->input->post('id') : 0;
                $post_data = array(
                    "Status" => $this->input->post('task_status')
                );

                if ($ID > 0) {
                    $post_data['UpdatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
                    if ($this->Common->update_info(TBL_USER_SERVICES_TASK, $ID, $post_data, 'ID')) :
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    else :
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    endif;
                }else{
                    $post_data['CreatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['CreatedAt'] = date("Y-m-d H:i:s");
                    if ($BannerID = $this->Common->add_info(TBL_USER_SERVICES_TASK, $post_data)) {
                        $response = array("status" => "ok", "heading" => "Add successfully...", "message" => "Details added successfully.");
                    } else {
                        $response = array("status" => "error", "heading" => "Not Added successfully...", "message" => "Details not added successfully.");
                    }
                }
            echo json_encode($response);
            die;
        }
    }

    public function manage()
    {
        $User = $this->tank_auth->get_user_id();
        $this->datatables->select('ID,USID,TaskName,Status,CreatedBy,CreatedAt');

        if ($this->input->post('status')) {
            $this->datatables->where('Status', $this->input->post('status'));
        }
        $this->datatables->where('UserID', $User);
    
        $this->datatables->from(TBL_USER_SERVICES_TASK)
            ->edit_column('CreatedAt', '$1', 'DatetimeFormat(CreatedAt)')
            ->edit_column('Status', '$1', 'GetTaskStatus(Status)')
            ->edit_column('CreatedBy', '$1', 'PartnersName(CreatedBy)')
            ->add_column('action', '$1', 'task_action_row(ID,USID)');
        $this->datatables->unset_column('ID');
        $this->datatables->unset_column('USID');
        $this->datatables->order_by('CreatedAt','desc');
        echo $this->datatables->generate();
    }

    public function manage_track_task()
    {
        $User = $this->tank_auth->get_user_id();
        $this->datatables->select('ID,USID,TaskName,Status,UserID,CreatedAt');

        if ($this->input->post('status')) {
            $this->datatables->where('Status', $this->input->post('status'));
        }
        $this->datatables->where('CreatedBy', $User);
    
        $this->datatables->from(TBL_USER_SERVICES_TASK)
            ->edit_column('CreatedAt', '$1', 'DatetimeFormat(CreatedAt)')
            ->edit_column('Status', '$1', 'GetTaskStatus(Status)')
            ->edit_column('UserID', '$1', 'PartnersName(UserID)')
            ->add_column('action', '$1', 'task_action_row(ID,USID)');
        $this->datatables->unset_column('ID');
        $this->datatables->unset_column('USID');
        $this->datatables->order_by('CreatedAt','desc');
        echo $this->datatables->generate();
    }
}