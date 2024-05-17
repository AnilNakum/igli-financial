<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Ccavenue_payment extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_title'] = "Manage Ccavenue Payments";
        $data['Payments'] = $this->Common->get_all_info(TBL_CCA_PAYMENT);
        $this->view('cca-payments/manage-payments', $data);
    }

    public function add()
    {
        $data['page_title'] = "Add Payment";
        $data['Services'] =  $this->Common->get_list(TBL_SERVICES, 'ServiceID', 'ServiceTitle', "Status=1 AND isDeleted=0");
        $data['Users'] =  $this->Common->get_list(TBL_USERS, 'id', 'first_name', "role_id=3 AND activated=1 AND isDeleted=0",false,false,false,'username');
        $this->partial('cca-payments/payment-form', $data);
    }

    public function update($id)
    {
        $id = decrypt($id);
        if ($id > 0) {
            $data_obj = $this->Common->get_info(TBL_CCA_PAYMENT, $id, 'PID');
            if (is_object($data_obj) && count((array) $data_obj) > 0) {
                $data["payment_info"] = $data_obj;
            } else {
                redirect('cca-payments/');
            }
        }
        $data['page_title'] = "Update Payment";
        $data['Services'] =  $this->Common->get_list(TBL_SERVICES, 'ServiceID', 'ServiceTitle', "Status=1 AND isDeleted=0");
        $data['Users'] =  $this->Common->get_list(TBL_USERS, 'id', 'first_name', "role_id=3 AND activated=1 AND isDeleted=0",false,false,false,'username');
        $this->partial('cca-payments/payment-form', $data);
    }

    public function submit_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $PID = ($this->input->post('payment_id') && $this->input->post('payment_id') > 0) ? $this->input->post('payment_id') : 0;
            $this->form_validation
                ->set_rules('service_id', 'Service', 'required')
                ->set_rules('user_id[]', 'User', 'required')
                ->set_rules('due_amount', 'Due Amount', 'required');
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {
                if($this->input->post('user_id')){
                    $Users = implode(',', $this->input->post('user_id'));
                }
                $post_data = array( 
                    "ServiceID" => $this->input->post('service_id'),
                    "UserID" => $Users,
                    "DueAmount" => $this->input->post('due_amount'),
                    "PaymentStatus" => $this->input->post('payment_status'),
                    "Status" => $this->input->post('status'),
                );
                
                if ($PID > 0) {
                    if($this->input->post('payment_status') == 'completed'){
                        foreach ($this->input->post('user_id') as $key => $U) {
                            $user = $this->Common->get_info(TBL_USERS, $U,'id');
                            $Name = $user->first_name.' '.$user->last_name;
                            $msgData = array(
                                "name"=> 'payment_received__rq',
                                "languageCode"=> "en", 
                                'headerValues' => array(),
                                'bodyValues' => array($Name,$this->input->post('due_amount')),
                            );
                            send_wp_msg($user->phone,$msgData);
                        }
                    }
                    $post_data['UpdatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
                    if ($this->Common->update_info(TBL_CCA_PAYMENT, $PID, $post_data, 'PID')) :
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    else :
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    endif;
                }else{
                    if($this->input->post('payment_status') == 'pending'){
                        $service = $this->Common->get_info(TBL_SERVICES, $this->input->post('service_id'),'ServiceID');
                        foreach ($this->input->post('user_id') as $key => $U) {
                            $user = $this->Common->get_info(TBL_USERS, $U,'id');
                            $Name = $user->first_name.' '.$user->last_name;
                            $msgData = array(
                                "name"=> 'payment_due',
                                "languageCode"=> "en", 
                                'headerValues' => array(),
                                'bodyValues' => array($Name,$service->ServiceTitle,date("d-m-Y"),$this->input->post('due_amount')),
                            );
                            send_wp_msg($user->phone,$msgData);
                        }
                    }
                    if($this->input->post('payment_status') == 'completed'){
                        foreach ($this->input->post('user_id') as $key => $U) {
                            $user = $this->Common->get_info(TBL_USERS, $U,'id');
                            $Name = $user->first_name.' '.$user->last_name;
                            $msgData = array(
                                "name"=> 'payment_received__rq',
                                "languageCode"=> "en", 
                                'headerValues' => array(),
                                'bodyValues' => array($Name,$this->input->post('due_amount')),
                            );
                            send_wp_msg($user->phone,$msgData);
                        }
                    }

                    $post_data['CreatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['CreatedAt'] = date("Y-m-d H:i:s");
                    if ($PID = $this->Common->add_info(TBL_CCA_PAYMENT, $post_data)) {
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
        $this->datatables->select('p.PID,p.TransactionID,p.Name,p.Phone,p.Amount,p.PaymentStatus,p.CreatedAt');

        if ($this->input->post('payment_status')) {
            $this->datatables->where('p.PaymentStatus', $this->input->post('payment_status'));
        }
    
        $this->datatables->from(TBL_CCA_PAYMENT.' p')
        ->edit_column('p.PaymentStatus', '$1', 'PaymentStatus(p.PaymentStatus)')
        ->edit_column('p.CreatedAt', '$1', 'DatetimeFormat(p.CreatedAt)')
        ->add_column('action', '$1', 'cca_payment_action_row(p.PID)');
        $this->datatables->unset_column('PID');
        echo $this->datatables->generate();
    }
}