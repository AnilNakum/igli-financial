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
        $data['page_title'] = "IGLI Form Builder";
       
        $this->view('form-builder/form-builder', $data);
    }
}