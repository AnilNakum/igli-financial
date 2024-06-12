<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Form_builder extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_title'] = "Manage IGLI Form Builder";       
        $User = $this->tank_auth->get_user_id(); 
        $data['Forms'] = $this->Common->get_all_info(TBL_FORM, $User ,'CreatedBy','isDeleted=0');
        $this->view('form-builder/form', $data);
    } 

    public function form_builder()
    {
        $data['page_title'] = "IGLI Form Builder";
       
        $this->view('form-builder/form-builder', $data);
    }


    public function edit_form($id)
    {
        $id = decrypt($id);
        if ($id > 0) {
            $data_obj = $this->Common->get_info(TBL_FORM, $id, 'FID');
            if (is_object($data_obj) && count((array) $data_obj) > 0) {
                $data["form_info"] = $data_obj;
            } else {
                redirect('form/');
            }
        }
        $data['page_title'] = "IGLI Form Builder :: Edit";
        $this->view('form-builder/form-builder', $data);
    }

    public function view_form($id)
    {
        $id = decrypt($id);
        if ($id > 0) {
            $data_obj = $this->Common->get_info(TBL_FORM, $id, 'FID');
            if (is_object($data_obj) && count((array) $data_obj) > 0) {
                $data["form_info"] = $data_obj;
            } else {
                redirect('form/');
            }
        }
        $data['page_title'] = "Form Preview";
        $this->partial('form-builder/form-view', $data);
    }

    public function submit_form()
    {
        // pr($this->input->post());die;
        if ($this->input->post()) { 
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $FormID = ($this->input->post('form_id') && $this->input->post('form_id') > 0) ? $this->input->post('form_id') : 0;
            $FormCode = ($this->input->post('form_code') && $this->input->post('form_code') != '') ? $this->input->post('form_code') : get_username('FD');
            $FormData = $this->input->post('formData');
            $post_data = array(
                "FormCode" => $FormCode,
                "FormName" => $this->input->post('formName'),
                "FormData" => json_encode($FormData),
                "FormURL" => 'form/igli_form/'.slugify($FormCode .'-'. $this->input->post('formName')),
                "Status" => $this->input->post('status') ?? 1
            );
            $fields = array(
                'id' => array('type' => 'INT', 'constraint' => 11)
            );
            foreach ($FormData as $i => $f) {
                if($f['type'] == 'text' || $f['type'] =='number' || $f['type'] =='date'){
                    $fields[$f['name']] = array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE);
                }else if ($f['type'] =='textarea' || $f['type'] =='file' || $f['type'] =='select' || $f['type'] =='checkbox-group' || $f['type'] =='radio-group'){
                    $fields[$f['name']] = array('type' => 'TEXT', 'null' => TRUE);
                }
            }

            
            if ($FormID > 0) {
                foreach ($fields as $key => $value) {                    
                   $this->Common->field_exists($key,$FormCode,$fields[$key]);
                }

                $post_data['UpdatedBy'] = $this->tank_auth->get_user_id();
                $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
                if ($this->Common->update_info(TBL_FORM, $FormID, $post_data, 'FID')) :
                    $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    else :
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    endif;
            }else{
                if($T = $this->Common->create_table($FormCode,$fields)){
                    $this->Common->query('ALTER TABLE '.$FormCode.'  ADD PRIMARY KEY (`id`)','');
                    $this->Common->query('ALTER TABLE '.$FormCode.'  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT','');
                }
                $post_data['CreatedBy'] = $this->tank_auth->get_user_id();
                $post_data['CreatedAt'] = date("Y-m-d H:i:s");
                if ($FormID = $this->Common->add_info(TBL_FORM, $post_data)) {
                    $response = array("status" => "ok", "heading" => "Add successfully...", "message" => "Details added successfully.");
                } else {
                    $response = array("status" => "error", "heading" => "Not Added successfully...", "message" => "Details not added successfully.");
                }
            }
        }
        echo json_encode($response);
        die;
    }

    public function manage()
    {
        $User = $this->tank_auth->get_user_id(); 
        $this->datatables->select('FID,FormName,FormCode,FormURL,Status,CreatedAt');

        if ($this->input->post('status')) {
            $this->datatables->where('Status', $this->input->post('status'));
        }
        $this->datatables->where('isDeleted', 0);
        $this->datatables->where('CreatedBy', $User);
        $this->datatables->from(TBL_FORM)
        ->edit_column('Status', '$1', 'Status(Status)')
        ->edit_column('CreatedAt', '$1', 'DatetimeFormat(CreatedAt)')
        ->add_column('action', '$1', 'form_action_row(FID,FormURL)');
        $this->datatables->unset_column('FormURL');
        echo $this->datatables->generate();
    }
    

    public function data_view($id){
        $id = decrypt($id);
        $Form = $this->Common->get_info(TBL_FORM, $id, 'FID');
        if($Form){
            $Form->Data = $this->Common->get_all_info($Form->FormCode);
            $data['Data'] = $Form;
            $data['page_title'] = $Form->FormName." Data";
        }else{
            $data['Data'] = [];
            $data['page_title'] = " Data";
        }

        $this->view('form/form-data', $data);        
    }


    public function pdf($id){
        $id = decrypt($id);
        $Form = $this->Common->get_info(TBL_FORM, $id, 'FID');
        if($Form){
            $data['form_info'] = $Form;
            $data['page_title'] = $Form->FormName." PDF Editor";
        }else{
            $data['form_info'] = [];
            $data['page_title'] = "PDF Editor";
        }

        $this->view('form/pdf-editor', $data);        
    }

    public function manage_form_data($id)
    {       
        $Form = $this->Common->get_info(TBL_FORM, $id, 'FID');
        $FormFiled = json_decode($Form->FormData);
        $Table = $Form->FormCode;
        $Str = 'id,';
        foreach ($FormFiled as $key => $value) {
            if($value->type != 'header' && $value->type != 'paragraph'){
                $Str .= $value->name.',';
            }
        }
        $Str .= 'is_deleted,created_at';

        $this->datatables->select($Str);
        if ($this->input->post('is_deleted')) {
            $this->datatables->where('is_deleted', $this->input->post('is_deleted'));
        }
    
        $this->datatables->from($Table);
        foreach ($FormFiled as $key => $value) {
            if($value->type != 'header' && $value->type != 'paragraph'){
                if($value->type == 'file'){   
                    $this->datatables->edit_column($value->name, '$1', 'GetFile('.$value->name.')');
                }
//                 if($value->type == 'checkbox-group'){                     
//                     $V = json_encode($value);
//                     $this->datatables->edit_column($value->name,'$1',  GetCheckBox($V): string{
// pr($V)
//                     });
                //     {
                //     $Str = '';
                //     $C = json_decode($value->name);
                    
                //     foreach ($C as $k => $v) {                        
                //         foreach ($value->values as $k1 => $v1) {
                //             if($v1->value == $v){
                //                 $Str .= $v1->label.',';
                //             }
                //         }
                //     }
                //     return $Str;
                //     }
                // );
                // }
            }
        }
        $this->datatables->edit_column('created_at', '$1', 'DatetimeFormat(created_at)')
        ->edit_column('is_deleted', '$1', 'isDeleted(is_deleted)')
        ->add_column('action', '$1', 'form_data_action_row(id)');
        echo $this->datatables->generate();
    }

    


}