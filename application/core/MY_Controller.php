<?php

class Base_Controller extends CI_Controller
{

    public $Method = false;

    public function __construct($auth = false)
    {
        parent::__construct();
        //load base libraries, helpers and models
        $this->load->database();
        $this->load->model('Settings_model');
        $settings = $this->Settings_model->get_settings();

        foreach ($settings as $key => $setting) {
            $this->config->set_item($key, $setting);
        }
        $this->Method = $this->router->fetch_method();
        if (!$auth && $this->Method != 'submit') {
            if (!$this->tank_auth->is_logged_in()) {
                if ($this->input->is_ajax_request()) {
                    $sapi_type = php_sapi_name();
                    if (substr($sapi_type, 0, 3) == 'cgi') {
                        header("Status: 401 UNAUTHORIZED1");
                    } else {
                        header("HTTP/1.1 401 UNAUTHORIZED2");
                    }
                    die;
                } else {
                    redirect('/auth/login/');
                }
            }else{
                define('ROLE',$this->tank_auth->get_role_id());
                if(ROLE == 2){
                    $ServiceIDs = $this->Common->get_info(TBL_SUBADMIN_SERVICES, $this->tank_auth->get_user_id(), 'UserID',false,'ServiceID');
                    $ServiceID = '0';
                    $cnt = 0;
                    if($ServiceIDs){
                        foreach ($ServiceIDs as $key => $value) {
                            if($cnt != 0){
                                $ServiceID .= ',';
                            }
                            $ServiceID .=  $value;
                            $cnt++;
                        }
                    }
                    define('USER_SERVICE', $ServiceID);
                }
            }
        }
        // if ($this->tank_auth->is_admin()) {
            //     if ($this->input->is_ajax_request()) {
                //         $response['status'] = 'login';
                //         $response['email'] = $this->session->userdata('email');
                //         echo json_encode($response);
                //         die;
                //     } else {
                    //         redirect('admin');
                    //     }
                    // }
                }
                
                public function view($view, $data = false, $part = false)
                {
                    if ($this->tank_auth->is_logged_in() && $this->Method != 'submit') {
                        $data['login_username'] = $this->tank_auth->get_fullname();
                        $data['role_id'] = $this->tank_auth->get_role_id();
                       
            $this->load->view('includes/header', $data);
        }
        $this->load->view($view, $data, $part);
        if ($this->tank_auth->is_logged_in() && $this->Method != 'submit') {
            $this->load->view('includes/footer');
        }
    }

    public function partial($view, $data = false, $part = false)
    {
        return $this->load->view($view, $data, $part);
    }
}