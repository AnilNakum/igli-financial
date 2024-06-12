<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Contact_support extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_title'] = "Manage Contact Support";
        $data['ContactSupport'] = $this->Common->get_all_info(TBL_CONTACT_SUPPORT);
        $this->view('contact-support/manage-contact-support', $data);
    }

    public function add()
    {
        $data['page_title'] = "Add Banner";
        $this->partial('contact-support/banner-form', $data);
    }

    public function update($id)
    {
        $id = decrypt($id);
        if ($id > 0) {
            $data_obj = $this->Common->get_info(TBL_CONTACT_SUPPORT, $id, 'ID');
            if (is_object($data_obj) && count((array) $data_obj) > 0) {
                $data["support_info"] = $data_obj;
            } else {
                redirect('contact-support/');
            }
        }
        $data['page_title'] = "Update Banner";
        $this->partial('contact-support/banner-form', $data);
    }

    public function view_contact($id)
    {
        $id = decrypt($id);
        if ($id > 0) {
            $select = 'c.*';
            $join = array(
                array('table' => TBL_USERS . ' u', 'on' => "c.CreatedBy=u.id", 'type' => ''),
            );
            $data_obj = $this->Common->get_info(TBL_CONTACT_SUPPORT . ' c', $id, 'c.id', '', $select, $join);
            if (is_object($data_obj) && count((array) $data_obj) > 0) {
                $data["support_info"] = $data_obj;
            } else {
                redirect('contact-support/');
            }
        }
        $data['page_title'] = "Contact Details";
        $this->partial('contact-support/view-contact', $data);
    }

    public function submit_form()
    {
        if ($this->input->post()) {
            $response = array("status" => "error", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $ID = ($this->input->post('id') && $this->input->post('id') > 0) ? $this->input->post('id') : 0;
            
                    if ($this->input->post('replay') == '' && $this->input->post('status') == 3) {
                        $response = array("status" => "error", "heading" => "Error", "message" => "Replay field should not be blank.");
                        echo json_encode($response);
                        die;
                    }

                    $post_data = array(
                        "Replay" => $this->input->post('replay'),
                        "Status" => $this->input->post('status')
                    );
                
                    $post_data['UpdatedBy'] = $this->tank_auth->get_user_id();
                    $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
                    if ($this->Common->update_info(TBL_CONTACT_SUPPORT, $ID, $post_data, 'ID')) :
                        $Data = $this->Common->get_info(TBL_CONTACT_SUPPORT, $ID,'id');
                        $user = $this->Common->get_info(TBL_USERS, $Data->CreatedBy,'id');
                        $mailData = array(
                            'username' => $user->name,
                            'Replay' => $this->input->post('replay'),
                            'TicketNo' => $Data->TicketNo,
                            'site_name' => $this->config->item('website_name', 'tank_auth')
                        );
                        $Subject = $this->config->item('website_name', 'tank_auth').' Update on Your Support Ticket';
                        $this->_send_email($Subject,'contact_replay', $user->email, $mailData);
                        
                        $response = array("status" => "ok", "heading" => "Updated successfully...", "message" => "Details updated successfully.");
                    else :
                        $response = array("status" => "error", "heading" => "Not Updated...", "message" => "Details not updated successfully.");
                    endif;
                

            echo json_encode($response);
            die;
        }
    }

    public function manage()
    {
        $this->datatables->select('c.ID,TicketNo,CONCAT(u.first_name," ",u.last_name) as  name,c.Subject,c.Status,c.CreatedAt');
        if ($this->input->post('status')) {
            $this->datatables->where('c.Status', $this->input->post('status'));
        }
        $this->datatables->where('c.isDeleted', 0);
        $this->datatables->join(TBL_USERS . ' u', 'u.id=c.CreatedBy', '');
        $this->datatables->from(TBL_CONTACT_SUPPORT .' c')
            ->edit_column('c.CreatedAt', '$1', 'DatetimeFormat(c.CreatedAt)')
            ->edit_column('c.Status', '$1', 'ContactStatus(c.Status)')
            ->add_column('action', '$1', 'support_action_row(c.ID)');
        $this->datatables->unset_column('c.ID');
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
        $this->email->send();
        // echo $this->email->print_debugger();
        // exit;
        return;
    }
}