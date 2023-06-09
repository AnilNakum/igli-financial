<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends Base_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('tank_auth');
    }

    function index() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            $data['user_id'] = $this->tank_auth->get_user_id();
            $data['username'] = $this->tank_auth->get_username();
            $this->view('welcome', $data);
        }
    }

}
