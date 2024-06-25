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
        $data['Users'] =  $this->Common->get_list(TBL_USERS, 'id', 'name', "role_id=3 AND activated=1 AND isDeleted=0",false,false,false,['username','email','phone']);
        $this->partial('document/document-form', $data);
    }

    public function submit_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $ID = ($this->input->post('document_id') && $this->input->post('document_id') > 0) ? $this->input->post('document_id') : 0;
            $this->form_validation
                ->set_rules('user_id[]', 'User', 'required')
                ->set_rules('doc_name', 'Document Name', 'required');
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {
                if($this->input->post('user_id')){
                    $Users = implode(',', $this->input->post('user_id'));
                }
                $post_data = array(
                    "UserID" => $Users,
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

                        
                        if($this->tank_auth->get_user_id() == 1){
                            $Name = 'Parth Mavani (+91 9409494483)';
                            $No = '9409494483';
                        }else{
                            $subAdmin = $this->Common->get_info(TBL_USERS, $this->tank_auth->get_user_id(),'id');
                            $Name = $subAdmin->first_name.' '.$subAdmin->last_name . '('.$subAdmin->phone.')';
                            $No = $subAdmin->phone;
                        }
                        
                        foreach ($this->input->post('user_id') as $key => $U) {
                            $user = $this->Common->get_info(TBL_USERS, $U,'id');
                            $mailData = array(
                                'username' => $user->name,
                                'DocName' => $this->input->post('doc_name'),
                                'RMName' => $Name,
                                'Document' => $post_data['Document'],
                                'site_name' => $this->config->item('website_name', 'tank_auth')
                            );
                            $Subject = $this->config->item('website_name', 'tank_auth').' - Document Uploaded';
                            $this->_send_email($Subject,'document_uploaded', $user->email, $mailData);
                        }

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
        // $this->datatables->select('d.ID,d.DocName,CONCAT(u.first_name," ",u.last_name) as  name,d.Status,d.CreatedAt');
        $this->datatables->select('d.ID,d.DocName,d.UserID,d.Status,d.CreatedAt');

        if ($this->input->post('status')) {
            $this->datatables->where('d.Status', $this->input->post('status'));
        }
        $this->datatables->where('d.isDeleted', 0);
        $this->datatables->where('d.CreatedBy', $this->tank_auth->get_user_id());
    
        // $this->datatables->join(TBL_USERS . ' u', 'u.id=d.UserID', '');
        $this->datatables->from(TBL_DOCUMENT.' d')
            ->edit_column('d.UserID', '$1', 'PartnersName(d.UserID)')
            ->edit_column('d.CreatedAt', '$1', 'DatetimeFormat(d.CreatedAt)')
            ->edit_column('d.Status', '$1', 'Status(d.Status)')
            ->add_column('action', '$1', 'document_action_row(d.ID)');
        $this->datatables->unset_column('d.ID');
        // $this->datatables->group_by('d.UserID'); 
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
        if($data['Document'] != ''){
            $this->email->attach(IMAGE_DIR.$data['Document']);
        }
        $this->email->send();
        // echo $this->email->print_debugger();
        // exit;
        return;
    }
}