<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dashboard extends Base_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data['page_title'] = WEBSITE_NAME . " Dashboard";
        $data['extra_js'] = ["morrisscripts.bundle"];
        $User = $this->tank_auth->get_user_id();
        if(ROLE == 2){
            $data['Services'] =  $this->Common->get_all_info(TBL_SERVICES, 0 ,'isDeleted',"ServiceID IN (".USER_SERVICE.")", '*', false, false,false, true);
            $data['Ongoing'] =  $this->Common->get_all_info(TBL_USER_SERVICES, 0, "isDeleted","AdminID = $User AND ServiceStatus='ongoing'",'*', false, false,false, true);
            $data['Onhold'] =  $this->Common->get_all_info(TBL_USER_SERVICES, 0, "isDeleted","AdminID = $User AND ServiceStatus='onhold'",'*', false, false,false, true);
            $data['Completed'] =  $this->Common->get_all_info(TBL_USER_SERVICES, 0, "isDeleted","AdminID = $User AND ServiceStatus='completed'",'*', false, false,false, true);
        }else{
            $data['Services'] =  $this->Common->get_all_info(TBL_SERVICES, 0 ,'isDeleted',"", '*', false, false,false, true);
            $data['Ongoing'] =  $this->Common->get_all_info(TBL_USER_SERVICES, 0, "isDeleted","AdminID = $User AND ServiceStatus='ongoing'",'*', false, false,false, true);
            $data['Onhold'] =  $this->Common->get_all_info(TBL_USER_SERVICES, 0, "isDeleted","AdminID = $User AND ServiceStatus='onhold'",'*', false, false,false, true);
            $data['Completed'] =  $this->Common->get_all_info(TBL_USER_SERVICES, 0, "isDeleted","AdminID = $User AND ServiceStatus='completed'",'*', false, false,false, true);
            $data['Users'] =  $this->Common->get_all_info(TBL_USERS, 1, "activated","isDeleted = 0 AND role_id = 3",'*', false, false,false, true);
            $data['SubAdmin'] =  $this->Common->get_all_info(TBL_USERS, 1, "activated","isDeleted = 0 AND role_id = 2",'*', false, false,false, true);
            $data['Contact'] =  $this->Common->get_all_info(TBL_CONTACT_SUPPORT, 0, "isDeleted","",'*', false, false,false, true);
            $data['Event'] =  $this->Common->get_all_info(TBL_EVENT, 0, "isDeleted","",'*', false, false,false, true);
        }
        $this->view('dashboard/dashboard', $data);
    }
}