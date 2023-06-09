<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Document extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_title'] = "Document";
        $data['Document'] = $this->Common->get_all_info(TBL_DOCUMENT);
        $this->view('document/manage-document', $data);
    }

    public function add()
    {
        $data['page_title'] = "Add New Document";
        $data['Users'] =  $this->Common->get_list(TBL_USERS, 'id', 'first_name', "role_id=3 AND activated=1 AND isDeleted=0",false,false,false,'username');
        $this->partial('document/document-form', $data);
    }

    public function submit_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $ID = ($this->input->post('document_id') && $this->input->post('document_id') > 0) ? $this->input->post('document_id') : 0;
            $this->form_validation
                ->set_rules('user_id', 'User', 'required')
                ->set_rules('doc_name', 'Document Name', 'required');
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {
                
                $post_data = array(
                    "UserID" => $this->input->post('user_id'),
                    "DocName" => $this->input->post('doc_name'),
                    "Status" => $this->input->post('status')
                );

                
                if (isset($_FILES['doc']['name']) && !empty($_FILES['doc']['name'])) {
                    $old_file = ($this->input->post('old_doc') && $this->input->post('old_doc') != "") ? $this->input->post('old_doc') : '';
                    $upload_path = DOCUMENT;
                    $upload_data = upload_file('doc', DOCUMENT, $old_file);
                    if (is_array($upload_data) && $upload_data['file_name'] != "") {
                        $post_data['Document'] = DOCUMENT.$upload_data['file_name'];
                    } else {
                        $response['message'] = $upload_data;
                        echo json_encode($response);
                        die;
                    }
                } else if (($this->input->post('old_doc') && empty($this->input->post('old_doc'))) || $ID == 0) {
                    $response = array("status" => "error", "heading" => "Document Missing", "message" => "Document Missing.");
                    echo json_encode($response);
                    die;
                }


                
                if ($ID > 0) {
                    $post_data['UpdatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
                    if ($this->Common->update_info(TBL_DOCUMENT, $ID, $post_data, 'ID')) :
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    else :
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    endif;
                }else{
                    $post_data['CreatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['CreatedAt'] = date("Y-m-d H:i:s");
                    if ($ID = $this->Common->add_info(TBL_DOCUMENT, $post_data)) {
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
        $this->datatables->select('d.ID,d.DocName,CONCAT(u.first_name," ",u.last_name) as  name,d.Status,d.CreatedAt');

        if ($this->input->post('status')) {
            $this->datatables->where('d.Status', $this->input->post('status'));
        }
        $this->datatables->where('d.isDeleted', 0);
    
        $this->datatables->join(TBL_USERS . ' u', 'u.id=d.UserID', '');
        $this->datatables->from(TBL_DOCUMENT.' d')
            ->edit_column('d.CreatedAt', '$1', 'DatetimeFormat(d.CreatedAt)')
            ->edit_column('d.Status', '$1', 'Status(d.Status)')
            ->add_column('action', '$1', 'document_action_row(d.ID)');
        $this->datatables->unset_column('d.ID');
        // $this->datatables->group_by('d.UserID'); 
        echo $this->datatables->generate();
    }
}