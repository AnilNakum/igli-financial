<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class User extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_title'] = "Manage Users";
        $data['Users'] = $this->Common->get_all_info(TBL_USERS,3,'role_id','isDeleted=0');
        $this->view('users/manage-users', $data);
    }

    public function add()
    {
        $data['page_title'] = "Add User";
        $data['Username'] = get_username();
        $this->partial('users/user-form', $data);
    }

    public function update($id)
    {
        $id = decrypt($id);
        if ($id > 0) {
            $data_obj = $this->Common->get_info(TBL_USERS, $id, 'id');
            if (is_object($data_obj) && count((array) $data_obj) > 0) {
                $data["user_info"] = $data_obj;
            } else {
                redirect('users/');
            }
        }
        $data['page_title'] = "Update User";
        $this->partial('users/user-form', $data);
    }

    public function submit_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $id = ($this->input->post('user_id') && $this->input->post('user_id') > 0) ? $this->input->post('user_id') : 0;
            $this->form_validation
                ->set_rules('first_name', 'First Name', 'required')
                ->set_rules('last_name', 'Last Name', 'required')
                ->set_rules('email', 'Email', 'required')
                ->set_rules('phone', 'Phone No', 'required')
                ->set_rules('password', 'Password', 'required')
                ->set_rules('re_password', 'Confirm Password', 'required|matches[password]');
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {
                
                $post_data = array(
                    "username" => $this->input->post('username'),
                    "first_name" => $this->input->post('first_name'),
                    "last_name" => $this->input->post('last_name'),
                    "name" => $this->input->post('first_name').' '. $this->input->post('last_name'),
                    "email" => $this->input->post('email'),
                    "phone" => $this->input->post('phone'),
                    "activated" => $this->input->post('activated'),
                    "role_id" => 3
                );

                if($this->input->post('password') != '111'){
                    // Hash password using phpass
                    $Password = $this->input->post('password');
                    $hasher = new PasswordHash(
                        $this->config->item('phpass_hash_strength', 'tank_auth'),
                        $this->config->item('phpass_hash_portable', 'tank_auth')
                    );
                    $post_data['password'] = $hasher->HashPassword($Password);
                }

                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    $old_file = ($this->input->post('old_image') && $this->input->post('old_image') != "") ? $this->input->post('old_image') : '';
                    $upload_path = USER_PROFILE;
                    $upload_data = upload_file('image', USER_PROFILE, $old_file);
                    if (is_array($upload_data) && $upload_data['file_name'] != "") {
                        $post_data['profile_image_name'] = USER_PROFILE.$upload_data['file_name'];
                    } else {
                        $response['message'] = $upload_data;
                        echo json_encode($response);
                        die;
                    }
                }                 
                if ($id > 0) {
                    $post_data['modified'] = date("Y-m-d H:i:s");
                    if ($this->Common->update_info(TBL_USERS, $id, $post_data, 'id')) :
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    else :
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    endif;
                }else{
                    $post_data['created'] = date("Y-m-d H:i:s");
                    if ($id = $this->Common->add_info(TBL_USERS, $post_data)) {
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
        $this->datatables->select('profile_image_name,id,username,CONCAT(first_name," ",last_name) as  name,email,phone,activated,created');

        
        if ($this->input->post('status')) {
            $Status = $this->input->post('status');
            if($Status != 1){
                $Status = 0;
            }
            $this->datatables->where('activated', $Status);
        }
        $this->datatables->where('isDeleted', 0);
        $this->datatables->where('role_id', 3);
        $this->datatables->from(TBL_USERS)
            ->edit_column('created', '$1', 'DatetimeFormat(created)')
            ->edit_column('profile_image_name', '$1', 'GetUserImage(profile_image_name)')
            ->edit_column('activated', '$1', 'Status(activated)')
            ->add_column('action', '$1', 'user_action_row(id)');
        $this->datatables->unset_column('id');
        echo $this->datatables->generate();
    }

    public function export_user() {
        $Users = $this->Common->get_all_info(TBL_USERS,3,'role_id','isDeleted=0');
        // create file name
        $fileName = 'data-'.time().'.xlsx';  
        // load excel library
        $this->load->library('excel');
        // $listInfo = $this->export->exportList();
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        // set Header
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Username');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Email');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Contact No');
        // set Row
        $rowCount = 2;
        foreach ($Users as $list) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list->username);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list->name);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list->email);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list->phone);
            $rowCount++;
        }
        foreach(range('A','D') as $columnID) {
            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
                ->setAutoSize(true);
        }
        
        $filename = "Users-". date("d-m-Y").".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output'); 
 
    }
}