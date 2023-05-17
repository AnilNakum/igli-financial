<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Not_found extends Base_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $sapi_type = php_sapi_name();
        if (substr($sapi_type, 0, 3) == 'cgi')
            header("Status: 404 Not Found");
        else
            header("HTTP/1.1 404 Not Found");

        if ($this->input->is_ajax_request()) {
            echo 'Page not found';
            die;
        } else {
            $data['page_title'] = "Page not found";
            $this->view('404', $data);
        }
    }

}
