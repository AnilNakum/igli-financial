<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Form extends Base_Controller
{

    public function __construct()
    {
        parent::__construct(true);

        $this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        redirect('/auth/login/');
    }

    public function igli_form($key)
    {
        $data['Data'] = $this->Common->get_info(TBL_FORM, 'form/igli_form/'.$key, 'FormURL');
        $this->partial('auth/form',$data);
    }

    public function submit_form()
    {
        if ($this->input->post()) {
            // pr($_FILES);die;
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $FID = ($this->input->post('form_id') && $this->input->post('form_id') > 0) ? $this->input->post('form_id') : 0;
            $FormCode = $this->input->post('form_code');
            $Form = $this->Common->get_info(TBL_FORM, $FormCode , 'FormCode');
            $FormData = json_decode($Form->FormData); 
            $this->form_validation->set_rules('form_id', 'Form Data', 'required');
            $post_data = array();
            foreach ($FormData as $i => $f) {
                if($f->type != 'header' && $f->type != 'paragraph' && $f->type != 'file'){
                    if($f->type != 'checkbox-group'){
                        $post_data[$f->name] = $this->input->post($f->name);
                    }else{
                        $post_data[$f->name] = json_encode($this->input->post($f->name));
                    }
                }
                if(isset($f->required) && $f->required == 'true'  && $f->type != 'file'){
                    $this->form_validation->set_rules($f->name, $f->label, 'required');
                }
               
            } 
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {

                foreach ($FormData as $i => $f) {
                    if($f->type == 'file'){
                        if($f->multiple == 'true'){
                                if (isset($_FILES[$f->name]['name']) && !empty($_FILES[$f->name]['name'][0])) {
                                $cpt =count($_FILES[$f->name]['name']);
                                for($i=0; $i<$cpt; $i++)
                                {                                  
                                    $_FILES[$f->name.'-'.$i]['name'] = $_FILES[$f->name]['name'][$i];
                                    $_FILES[$f->name.'-'.$i]['full_path'] = $_FILES[$f->name]['full_path'][$i];
                                    $_FILES[$f->name.'-'.$i]['type'] =  $_FILES[$f->name]['type'][$i];
                                    $_FILES[$f->name.'-'.$i]['tmp_name'] = $_FILES[$f->name]['tmp_name'][$i];
                                    $_FILES[$f->name.'-'.$i]['error'] =  $_FILES[$f->name]['error'][$i];
                                    $_FILES[$f->name.'-'.$i]['size'] =  $_FILES[$f->name]['size'][$i];    
    
                                    $Path = 'form/'.$FormCode.'/';
                                    $upload_path = $Path;
                                    $upload_data = upload_file($f->name.'-'.$i, $Path);
                                    if (is_array($upload_data) && $upload_data['file_name'] != "") {
                                        $IMG[$i] = $Path.$upload_data['file_name'];
                                    } else {
                                        $response['message'] = $upload_data;
                                        echo json_encode($response);
                                        die;
                                    }
                                    $post_data[$f->name] =json_encode($IMG);
                                }
    
                            } else if(isset($f->required) && $f->required == 'true'){
                                $response = array("status" => "error", "heading" => $f->label." should not be blank", "message" => $f->label." should not be blank.");
                                echo json_encode($response);
                                die;
                            }
                        }else{
                            if (isset($_FILES[$f->name]['name']) && !empty($_FILES[$f->name]['name'])) {
                                $Path = 'form/'.$FormCode.'/';
                                $upload_path = $Path;
                                $upload_data = upload_file($f->name, $Path);
                                if (is_array($upload_data) && $upload_data['file_name'] != "") {
                                    $post_data[$f->name] = $Path.$upload_data['file_name'];
                                } else {
                                    $response['message'] = $upload_data;
                                    echo json_encode($response);
                                    die;
                                }
                            } else if(isset($f->required) && $f->required == 'true'){
                                $response = array("status" => "error", "heading" => $f->label." should not be blank", "message" => $f->label." should not be blank.");
                                echo json_encode($response);
                                die;
                            }
                        }
                    }
                }


                $post_data['created_at'] = date("Y-m-d H:i:s");
                $Data = $post_data;
                if ($FormID = $this->Common->add_info($FormCode, $Data)) {
                    $response = array("status" => "ok", "heading" => "Add successfully...", "message" => "Details added successfully.","FormCode" => $FormCode);
                } else {
                    $response = array("status" => "error", "heading" => "Not Added successfully...", "message" => "Details not added successfully.");
                }
            } else {
                $response['error'] = $this->form_validation->error_array();
            }
            echo json_encode($response);
            die; 
        }
    }

    public function complete($FormCode = '')
    {
        if($FormCode != ''){

            $data['Data'] = $this->Common->get_info(TBL_FORM, $FormCode, 'FormCode');
            $data['FormURL'] = 'form/igli_form/'.slugify($FormCode .'-'. $data['Data']->FormName);
            
            $this->partial('auth/form-complete',$data);
        }else{
             redirect('https://iglifinancial.com/');
        }
    }

    public function export_form_data($id) {
        $id = decrypt($id);
        $Form = $this->Common->get_info(TBL_FORM, $id, 'FID');
        if($Form){
            $FormFiled = json_decode($Form->FormData);
            $Data = $this->Common->get_all_info($Form->FormCode,0,'is_deleted');
            // create file name
            $filename = $Form->FormCode."-". date("d-m-Y").".csv";
            // load excel library
            $this->load->library('excel');
            // $listInfo = $this->export->exportList();
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $hed = 0;$row = 1;
            foreach ($FormFiled as $key1 => $value1) {
                if($value1->type != 'header' && $value1->type != 'paragraph'){
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($hed, $row, $value1->label);
                    $hed++;
                }
            }

            $row = 2; 
            foreach ($Data as $list) {
                $col = 0;
                foreach ($FormFiled as $key => $value) {
                    if($value->type != 'header' && $value->type != 'paragraph'){
                        $Name = $value->name;
                        $Str = $list->$Name;

                        if($value->type == 'checkbox-group'){  
                            $Str = '';
                            $C = json_decode($list->$Name);
                            foreach ($C as $k => $v) {                        
                                foreach ($value->values as $k1 => $v1) {
                                    if($v1->value == $v){
                                        $Str .= $v1->label;
                                        if(count($C) >= $k+2){
                                            $Str .= ',';
                                        }
                                    }
                                }
                            }       
                        }
                        if($value->type == 'select'){   
                            $Str = '';                        
                            if($value->multiple == 'true'){
                                $C = json_decode($list->$Name);
                                foreach ($C as $k => $v) {                        
                                    foreach ($value->values as $k1 => $v1) {
                                        if($v1->value == $v){
                                            $Str .= $v1->label;
                                            if(count($C) >= $k+2){
                                                $Str .= ',';
                                            }
                                        }
                                    }
                                }                               
                            }else{   
                                foreach ($value->values as $k1 => $v1) {
                                    if($v1->value == $list->$Name){
                                        $Str .= $v1->label;                                    
                                    }
                                }
                            }
                        }    
                        if($value->type == 'radio-group'){  
                            $Str = '';
                            foreach ($value->values as $k1 => $v1) {
                                if($v1->value == $list->$Name){
                                    $Str .= $v1->label;                                    
                                }
                            }
                        }   
                        if($value->type == 'file'){
                            $Str = '';       
                            if($value->multiple == 'true'){
                                $I = json_decode($list->$Name);
                                if(is_array($I)){
                                    foreach ($I as $k2 => $v2) {
                                        $Str .= IMAGE_DIR . $v2.', ';
                                    }
                                }
                            }else{
                                $Str = IMAGE_DIR . $list->$Name;
                            }

                        }                                    
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $Str);
                        $col++;
                    }
                }
                $row++;
            }     
            header('Content-Type: application/vnd.ms-excel'); 
            header('Content-Disposition: attachment;filename="'.$filename.'"');
            header('Cache-Control: max-age=0'); 
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
            $objWriter->save('php://output'); 
        }else{
            redirect('form-data/data-view/');
        }
   }

   function pdf($ID) {
    $link = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $link_array = explode('/',$link);

    $FormCode =  $link_array[count($link_array)-2];
    $ID =  decrypt(end($link_array));

    pr($link_array[count($link_array)-2]);
    pr($ID);die;

    $Form = $this->Common->get_info(TBL_FORM, $FormCode, 'FormCode');
    $Data = $this->Common->get_info($FormCode, $ID,'id');

    $this->load->library('pdf');
    $pdfName = time().'.pdf';
    $file_to_save = UPLOAD_DIR.'/pdf/'.$pdfName;
    $phrase  = $Form->PdfView;
    $name = [];
    $value   = [];
    $FormFiled = json_decode($Form->FormData);
    foreach ($FormFiled as $K => $V) { 
        if($V->type != 'header' && $V->type != 'paragraph'){ 
            $FName =  $V->name;
            $Str = $Data->$FName;
            if($V->type == 'checkbox-group'){  
                $Str = '';
                $C = json_decode($Data->$FName);
                foreach ($C as $kx => $vx) {                        
                    foreach ($V->values as $k1 => $v1) {
                        if($v1->value == $vx){
                            $Str .= $v1->label;
                            if(count($C) >= $kx+2){
                                $Str .= ',';
                            }
                        }
                    }
                }       
            }
            if($V->type == 'select'){   
                $Str = '';                        
                if($V->multiple == 'true'){
                    $C = json_decode($Data->$FName);
                    foreach ($C as $k => $v) {                        
                        foreach ($V->values as $k1 => $v1) {
                            if($v1->value == $v){
                                $Str .= $v1->label;
                                if(count($C) >= $k+2){
                                    $Str .= ',';
                                }
                            }
                        }
                    }                               
                }else{   
                    foreach ($V->values as $k1 => $v1) {
                        if($v1->value == $Data->$FName){
                            $Str .= $v1->label;                                    
                        }
                    }
                }
            }    
            if($V->type == 'radio-group'){  
                $Str = '';
                foreach ($V->values as $k1 => $v1) {
                    if($v1->value == $Data->$FName){
                        $Str .= $v1->label;                                    
                    }
                }
            }   
            if($V->type == 'file'){
                $Str = '';       
                if($V->multiple == 'true'){
                    $I = json_decode($Data->$FName);
                    if(is_array($I)){
                        foreach ($I as $k2 => $v2) {
                            $Str .= IMAGE_DIR . $v2.', ';
                        }
                    }
                }else{
                    $Str = IMAGE_DIR . $Data->$FName;
                }

            }  

            array_push($name,'{'.$FName.'}');
            array_push($value,$Str);
        }
    }
    // pr($name);
    // pr($value);die;
    
    $newPhrase = str_replace($name, $value, $phrase);
    $html = '
    <html>
    <head>
    <title>::'.$Form->FormName.'::</title>
    <style>
            // @import url("https://fonts.googleapis.com/css?family=Muli:300,400,600,700");           
            body {
                font-family: "Muli", sans-serif;
            }
        </style>                       
        </head>
        <body class="theme-blue sidebar-collapse">
            '.$newPhrase.'
        </body>
    </html>';
    // pr($html);die;

    $dompdf = new PDF();
    $dompdf->load_html($html);
    $dompdf->render();
    $output = $dompdf->output();
    file_put_contents($file_to_save, $dompdf->output()); 
    header('Content-type: application/pdf');
    header('Content-Disposition: inline; filename="'.$pdfName.'"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file_to_save));
    header('Accept-Ranges: bytes');
    readfile($file_to_save);
    unlink($file_to_save);
   }



    public function submit_pdf_form() {
        // pr($this->input->post());
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $FID = ($this->input->post('form_id') && $this->input->post('form_id') > 0) ? $this->input->post('form_id') : 0;
            $this->form_validation->set_rules('PdfView', 'PDF View', 'required');           
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {      
                $post_data = array(
                    "PdfView" => $this->input->post('PdfView'),
                    "Status" => $this->input->post('status')                   
                ); 
                if ($FID > 0) {
                    $post_data['UpdatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
                    if ($this->Common->update_info(TBL_FORM, $FID, $post_data, 'FID')) {
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    }else {
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    }
                }                
            } else {
                $response['error'] = $this->form_validation->error_array();
            }
            echo json_encode($response);
            die; 
        }
    }
}