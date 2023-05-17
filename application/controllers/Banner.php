<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Banner extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_title'] = "Manage Banners";
        $data['Banners'] = $this->Common->get_all_info(TBL_BANNER);
        $this->view('banners/manage-banners', $data);
    }

    public function add()
    {
        $data['page_title'] = "Add Banner";
        $this->partial('banners/banner-form', $data);
    }

    public function update($id)
    {
        $id = decrypt($id);
        if ($id > 0) {
            $data_obj = $this->Common->get_info(TBL_BANNER, $id, 'BannerID');
            if (is_object($data_obj) && count((array) $data_obj) > 0) {
                $data["banner_info"] = $data_obj;
            } else {
                redirect('banners/');
            }
        }
        $data['page_title'] = "Update Banner";
        $this->partial('banners/banner-form', $data);
    }

    public function submit_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $BannerID = ($this->input->post('banner_id') && $this->input->post('banner_id') > 0) ? $this->input->post('banner_id') : 0;
            $this->form_validation
                ->set_rules('banner_title', 'Banner Title', 'required')
                ->set_rules('description', 'Description', 'required');
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {
                
                $post_data = array(
                    "Title" => $this->input->post('banner_title'),
                    "Description" => $this->input->post('description'),
                    "Order" => $this->input->post('order'),
                    "Status" => $this->input->post('status')
                );

                if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
                    $old_file = ($this->input->post('old_image') && $this->input->post('old_image') != "") ? $this->input->post('old_image') : '';
                    $upload_path = BANNER_IMG;
                    $upload_data = upload_file('image', BANNER_IMG, $old_file);
                    if (is_array($upload_data) && $upload_data['file_name'] != "") {
                        $post_data['Image'] = BANNER_IMG.$upload_data['file_name'];
                    } else {
                        $response['message'] = $upload_data;
                        echo json_encode($response);
                        die;
                    }
                } else if (($this->input->post('old_image') && empty($this->input->post('old_image'))) || $BannerID == 0) {
                    $response = array("status" => "error", "heading" => "Banner Image Missing", "message" => "Banner Image Missing.");
                    echo json_encode($response);
                    die;
                }


                
                if ($BannerID > 0) {
                    $post_data['UpdatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
                    if ($this->Common->update_info(TBL_BANNER, $BannerID, $post_data, 'BannerID')) :
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    else :
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    endif;
                }else{
                    $post_data['CreatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['CreatedAt'] = date("Y-m-d H:i:s");
                    if ($BannerID = $this->Common->add_info(TBL_BANNER, $post_data)) {
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
        $this->datatables->select('Order,BannerID,Image,Title,Status,CreatedAt');

        if ($this->input->post('status')) {
            $this->datatables->where('Status', $this->input->post('status'));
        }
        $this->datatables->where('isDeleted', 0);
    
        $this->datatables->from(TBL_BANNER)
            ->edit_column('CreatedAt', '$1', 'DatetimeFormat(CreatedAt)')
            ->edit_column('Image', '$1', 'GetImage(Image)')
            ->edit_column('Status', '$1', 'Status(Status)')
            ->add_column('action', '$1', 'banner_action_row(BannerID)');
        $this->datatables->unset_column('BannerID');
        $this->datatables->unset_column('Order');
        $this->datatables->order_by('Order','asc');
        echo $this->datatables->generate();
    }
}