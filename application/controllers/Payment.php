<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Payment extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_title'] = "Manage Payments";
        $data['Payments'] = $this->Common->get_all_info(TBL_PAYMENT);
        $this->view('payments/manage-payments', $data);
    }

    public function add()
    {
        $data['page_title'] = "Add Payment";
        $data['Services'] =  $this->Common->get_list(TBL_SERVICES, 'ServiceID', 'ServiceTitle', "Status=1 AND isDeleted=0");
        $data['Users'] =  $this->Common->get_list(TBL_USERS, 'id', 'first_name', "role_id=3 AND activated=1 AND isDeleted=0",false,false,false,'username');
        $this->partial('payments/payment-form', $data);
    }

    public function update($id)
    {
        $id = decrypt($id);
        if ($id > 0) {
            $data_obj = $this->Common->get_info(TBL_PAYMENT, $id, 'PID');
            if (is_object($data_obj) && count((array) $data_obj) > 0) {
                $data["payment_info"] = $data_obj;
            } else {
                redirect('payments/');
            }
        }
        $data['page_title'] = "Update Payment";
        $data['Services'] =  $this->Common->get_list(TBL_SERVICES, 'ServiceID', 'ServiceTitle', "Status=1 AND isDeleted=0");
        $data['Users'] =  $this->Common->get_list(TBL_USERS, 'id', 'first_name', "role_id=3 AND activated=1 AND isDeleted=0",false,false,false,'username');
        $this->partial('payments/payment-form', $data);
    }

    public function submit_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $PID = ($this->input->post('payment_id') && $this->input->post('payment_id') > 0) ? $this->input->post('payment_id') : 0;
            $this->form_validation
                ->set_rules('service_id', 'Service', 'required')
                ->set_rules('user_id', 'User', 'required')
                ->set_rules('due_amount', 'Due Amount', 'required');
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {
                
                $post_data = array(
                    "ServiceID" => $this->input->post('service_id'),
                    "UserID" => $this->input->post('user_id'),
                    "DueAmount" => $this->input->post('due_amount'),
                );
                
                if ($PID > 0) {
                    $post_data['UpdatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
                    if ($this->Common->update_info(TBL_PAYMENT, $PID, $post_data, 'PID')) :
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    else :
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    endif;
                }else{
                    $post_data['CreatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['CreatedAt'] = date("Y-m-d H:i:s");
                    if ($PID = $this->Common->add_info(TBL_PAYMENT, $post_data)) {
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
        $this->datatables->select('p.PID,s.ServiceTitle,CONCAT(u.first_name," ",u.last_name) as  name,p.DueAmount,p.CreatedAt');

        // if ($this->input->post('payment_status')) {
        //     $this->datatables->where('p.PaymentStatus', $this->input->post('payment_status'));
        // }
        // if ($this->input->post('status')) {
        //     $this->datatables->where('p.Status', $this->input->post('status'));
        // }
    
        $this->datatables->join(TBL_SERVICES . ' s', 's.ServiceID=p.ServiceID', '');
        $this->datatables->join(TBL_USERS . ' u', 'u.id=p.UserID', '');
        $this->datatables->from(TBL_PAYMENT.' p')
        // ->edit_column('p.PaymentStatus', '$1', 'PaymentStatus(p.PaymentStatus)')
        // ->edit_column('p.Status', '$1', 'PStatus(p.Status)')
        ->edit_column('p.CreatedAt', '$1', 'DatetimeFormat(p.CreatedAt)')
        ->add_column('action', '$1', 'payment_action_row(p.PID)');
        $this->datatables->unset_column('PID');
        echo $this->datatables->generate();
    }
}