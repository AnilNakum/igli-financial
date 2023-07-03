<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Services extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_title'] = "Manage Services";
        $data['Services'] = $this->Common->get_all_info(TBL_SERVICES);
        $data['ServiceTypes'] =  $this->Common->get_list(TBL_SERVICE_TYPE, 'STID', 'Name', "Status=1 AND isDeleted=0");
        $this->view('services/manage-services', $data);
    }

    public function type()
    {
        $data['page_title'] = "Manage Service Type";
        $data['ServiceType'] = $this->Common->get_all_info(TBL_SERVICE_TYPE);
        $this->view('services/manage-services-type', $data);
    }

    public function manage_type()
    {
        $this->datatables->select('Order,STID,Name,Status,CreatedAt');

        if ($this->input->post('status')) {
            $this->datatables->where('Status', $this->input->post('status'));
        }
        $this->datatables->where('isDeleted', 0);
    
        $this->datatables->from(TBL_SERVICE_TYPE)
            ->edit_column('CreatedAt', '$1', 'DatetimeFormat(CreatedAt)')
            ->edit_column('Status', '$1', 'Status(Status)')
            ->add_column('action', '$1', 'service_type_action_row(STID)');
        $this->datatables->unset_column('STID');
        $this->datatables->unset_column('Order');
        $this->datatables->order_by('Order','asc');
        echo $this->datatables->generate();
    }

    public function add_type()
    {
        $data['page_title'] = "Add Service Type";
        $this->partial('services/service-type-form', $data);
    }

    public function update_type($id)
    {
        $id = decrypt($id);
        if ($id > 0) {
            $data_obj = $this->Common->get_info(TBL_SERVICE_TYPE, $id, 'STID');
            if (is_object($data_obj) && count((array) $data_obj) > 0) {
                $data["services_type_info"] = $data_obj;
            } else {
                redirect('services/type');
            }
        }
        $data['page_title'] = "Update Service Type";
        $this->partial('services/service-type-form', $data);
    }

    public function submit_type_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $ServicesTypeID = ($this->input->post('services_type_id') && $this->input->post('services_type_id') > 0) ? $this->input->post('services_type_id') : 0;
            $this->form_validation
                ->set_rules('services_type_name', 'Name', 'required');
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {
                
                $post_data = array(
                    "Name" => $this->input->post('services_type_name'),
                    "Order" => $this->input->post('order'),
                    "Status" => $this->input->post('status')
                );
                
                if ($ServicesTypeID > 0) {
                    $post_data['UpdatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
                    if ($this->Common->update_info(TBL_SERVICE_TYPE, $ServicesTypeID, $post_data, 'STID')) :
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    else :
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    endif;
                }else{
                    $post_data['CreatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['CreatedAt'] = date("Y-m-d H:i:s");
                    if ($ServicesTypeID = $this->Common->add_info(TBL_SERVICE_TYPE, $post_data)) {
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

    public function add()
    {
        $data['page_title'] = "Add Service";
        $data['ServiceTypes'] =  $this->Common->get_list(TBL_SERVICE_TYPE, 'STID', 'Name', "Status=1 AND isDeleted=0");
        $this->partial('services/service-form', $data);
    }

    public function update($id)
    {
        $id = decrypt($id);
        if ($id > 0) {
            $data_obj = $this->Common->get_info(TBL_SERVICES, $id, 'ServiceID');
            if (is_object($data_obj) && count((array) $data_obj) > 0) {
                $data["service_info"] = $data_obj;
            } else {
                redirect('services/');
            }
        }
        $data['page_title'] = "Update Service";
        $data['ServiceTypes'] =  $this->Common->get_list(TBL_SERVICE_TYPE, 'STID', 'Name', "Status=1 AND isDeleted=0");
        $this->partial('services/service-form', $data);
    }

    public function submit_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $ServiceID = ($this->input->post('service_id') && $this->input->post('service_id') > 0) ? $this->input->post('service_id') : 0;
            $this->form_validation
                ->set_rules('service_type', 'Service Type', 'required')
                ->set_rules('service_title', 'Service Title', 'required')
                ->set_rules('amount', 'Amount', 'required')
                ->set_rules('amount_type', 'amount Type', 'required')
                ->set_rules('discount_amount', 'Discount Amount', 'required')
                ->set_rules('discount_amount_type', 'Discount Amount Type', 'required')
                ->set_rules('ongoing', 'Ongoing', 'required')
                ->set_rules('benefits', 'Benefits', 'required')
                ->set_rules('documents', 'Documents', 'required')
                ->set_rules('deliverables', 'Deliverables', 'required');
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {
                
                $post_data = array(
                    "STID" => $this->input->post('service_type'),
                    "ServiceTitle" => $this->input->post('service_title'),
                    "Amount" => $this->input->post('amount'),
                    "AmountType" => $this->input->post('amount_type'),
                    "DiscountAmount" => $this->input->post('discount_amount'),
                    "DiscountAmountType" => $this->input->post('discount_amount_type'),
                    "OnGoing" => $this->input->post('ongoing'),
                    "Benefits" => $this->input->post('benefits'),
                    "Documents" => $this->input->post('documents'),
                    "Deliverables" => $this->input->post('deliverables'),
                    "Status" => $this->input->post('status')
                );

                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    $old_file = ($this->input->post('old_image') && $this->input->post('old_image') != "") ? $this->input->post('old_image') : '';
                    $upload_path = SERVICE_LOGO;
                    $upload_data = upload_file('image', SERVICE_LOGO, $old_file);
                    if (is_array($upload_data) && $upload_data['file_name'] != "") {
                        $post_data['Logo'] = SERVICE_LOGO.$upload_data['file_name'];
                    } else {
                        $response['message'] = $upload_data;
                        echo json_encode($response);
                        die;
                    }
                } else if (($this->input->post('old_image') && empty($this->input->post('old_image'))) || $ServiceID == 0) {
                    $response = array("status" => "error", "heading" => "Service Logo Missing", "message" => "Service Logo Missing.");
                    echo json_encode($response);
                    die;
                }


                
                if ($ServiceID > 0) {
                    $post_data['UpdatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
                    if ($this->Common->update_info(TBL_SERVICES, $ServiceID, $post_data, 'ServiceID')) :
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    else :
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    endif;
                }else{
                    $post_data['CreatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['CreatedAt'] = date("Y-m-d H:i:s");
                    if ($ServiceID = $this->Common->add_info(TBL_SERVICES, $post_data)) {
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
        
        $this->datatables->select('s.Logo,s.ServiceID,st.Name,s.ServiceTitle,s.Status,s.CreatedAt');

        if ($this->input->post('type')) {
            $this->datatables->where('s.STID', $this->input->post('type'));
        }
        if ($this->input->post('status')) {
            $this->datatables->where('s.Status', $this->input->post('status'));
        }
        if(ROLE == 2){
            $this->datatables->where_in('s.ServiceID',USER_SERVICE);
        }
        $this->datatables->where('s.isDeleted', 0);
        $this->datatables->join(TBL_SERVICE_TYPE . ' st', 'st.STID=s.STID', '');
        $this->datatables->from(TBL_SERVICES.' s')
            ->edit_column('s.CreatedAt', '$1', 'DatetimeFormat(s.CreatedAt)')
            ->edit_column('s.Logo', '$1', 'GetImage(s.Logo)')
            ->edit_column('s.Status', '$1', 'Status(s.Status)')
            ->add_column('action', '$1', 'service_action_row(s.ServiceID)');
        $this->datatables->unset_column('s.ServiceID');
        echo $this->datatables->generate();
    }

    public function top_services()
    {
        $data['page_title'] = "Manage Top Services";
        $data["service_info"]  = $this->Common->get_info(TBL_TOP_SERVICES, 1, 'TopID');
        $data['Services'] =  $this->Common->get_list(TBL_SERVICES, 'ServiceID', 'ServiceTitle', "Status=1 AND isDeleted=0");
        $this->view('services/manage-top-services', $data);
    }

    public function submit_top_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
                $post_data = array(
                    "Service1" => $this->input->post('service1'),
                    "Service2" => $this->input->post('service2'),
                    "Service3" => $this->input->post('service3'),
                    "Service4" => $this->input->post('service4'),
                    "Service5" => $this->input->post('service5'),
                    "Service6" => $this->input->post('service6'),
                    "Service7" => $this->input->post('service7'),
                    "Service8" => $this->input->post('service8'),
                    "Service9" => $this->input->post('service9'),
                );

                if ($this->Common->update_info(TBL_TOP_SERVICES, 1, $post_data, 'TopID')) {
                    $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                }else {
                    $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                }
            echo json_encode($response);
            die;
        }
    }
}