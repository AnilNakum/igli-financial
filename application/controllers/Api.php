<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller
{
    public $USER_ID = false;
    public $Method = false;
    public $Class = false;

    function __construct() {
        parent::__construct();
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->model('tank_auth/users');
        $this->load->model('Rest_model');
        $this->load->model('Remove_records');
        
        $this->Method = $this->router->fetch_method();
        $this->Class = $this->router->fetch_class();
        $_POST = json_decode(file_get_contents("php://input"), true);
        if ($this->Class != 'login' && $this->Method != 'login' && $this->Class != 'register' && $this->Method != 'register' && $this->Method != 'forgot_password' && $this->Method != 'confirmopt' && $this->Method != 'resendopt') {
            $this->USER_ID = $this->_Check_Auth_Token();
        }
    }

    /**
     * Send email message of given type (activate, forgot_password, etc.)
     *
     * @param    string
     * @param    string
     * @param    array
     * @return    void
     */
    public function _send_email($type, $email, &$data)
    {
        $this->load->library('email');
        $this->email->from($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
        $this->email->reply_to($this->config->item('webmaster_email', 'tank_auth'), $this->config->item('website_name', 'tank_auth'));
        $this->email->to($email);
        $this->email->subject(sprintf($this->lang->line('auth_subject_' . $type), $this->config->item('website_name', 'tank_auth')));
        $this->email->message($this->load->view('email/' . $type . '-html', $data, true));
        $this->email->set_alt_message($this->load->view('email/' . $type . '-txt', $data, true));
        $this->email->send();
        // echo $this->email->print_debugger();
        // exit;
        return;
    }
    
    public function login_post() {
        $this->form_validation->set_rules('user', 'Username/Email/Phone', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->response(['status' => FALSE, 'message' => $this->convert_msg($this->form_validation->error_array()), 'data' => new stdClass()], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $Email = $this->post('user');
            $Password = $this->post('password');
            $DeviceID = $this->post('device_id');
            if (!is_null($User = $this->users->get_user_all($Email))) { // login ok
                // Does password match hash in database?
                $hasher = new PasswordHash(
                    $this->config->item('phpass_hash_strength', 'tank_auth'),
                    $this->config->item('phpass_hash_portable', 'tank_auth')
                );
                if ($hasher->CheckPassword($Password, $User->password)) {
                    if ($User->activated == 0) { // fail - not activated
                        $this->response(['status' => FALSE, 'message' => "Account Not Activated, Please Varify Your Email!"], REST_Controller::HTTP_BAD_REQUEST);
                    } else {
                        if($User->phone_verified == 0){
                            $DefaultOTP = "112233";
                            $OTP =$User->otp;
                            if ($OTP == '') {
                                $OTP = get_otp($DefaultOTP);
                                $user_data = array(
                                    "otp" => $OTP,
                                );
                                $this->Common->update_info(TBL_USERS,$User->id, $user_data,'id');
                            }

                            $OPT_SMS = "$OTP verification code.";
                            if (send_sms($User->phone, $OPT_SMS)) {
                                    $this->response(['status' => FALSE, 'message' => 'Please Varify Your Phone No. With OTP', "data" => ["phone" => $User->phone]], REST_Controller::HTTP_BAD_REQUEST);
                            }else{
                                $this->response(['status' => FALSE, 'message' => "OTP Send Fail, Please Try Again"], REST_Controller::HTTP_BAD_REQUEST);
                            }
                        }else{
                            $login_token = $this->Rest_model->get_new_token([
                                'api_key_id' => $this->_apiuser->id,
                                'user_id' => $User->id,
                                'ip_address' => $_SERVER['REMOTE_ADDR'],
                                'device_id' => $DeviceID
                            ]);
    
                            $this->response(['status' => TRUE,
                            'message' => 'Login successfully',
                            "data" => ['user' => $User,'user_id' => $User->id, 'login_token' => $login_token]]
                                , REST_Controller::HTTP_OK);
                        }
                    }
                }else{
                    $this->response(['status' => FALSE, 'message' => "Incorrect Password, Please Try Again"], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(['status' => FALSE, 'message' => "User Not Exist, Please Signup First"], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function register_post() {
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $this->response(['status' => FALSE, 'message' => $this->convert_msg($this->form_validation->error_array()), 'data' => new stdClass()], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $FirstName = $this->post('first_name');
            $LastName = $this->post('last_name');
            $Phone = $this->post('phone');
            $Email = $this->post('email');
            $Password = $this->post('password');
            $CPassword = $this->post('confirm_password');
            $DeviceID = $this->post('device_id');

            if (!$this->users->is_email_available($Email)) {
                $this->response(['status' => FALSE, 'message' => "Email is already used by another user. Please choose another email."], REST_Controller::HTTP_BAD_REQUEST);
            }else if (!$this->users->is_phone_available($Phone)) {
                $this->response(['status' => FALSE, 'message' => "Phone no is already used by another user. Please choose another Phone No."], REST_Controller::HTTP_BAD_REQUEST);
            }else{
                if ($Password != '') {
                   // Hash password using phpass
                    $hasher = new PasswordHash(
                        $this->config->item('phpass_hash_strength', 'tank_auth'),
                        $this->config->item('phpass_hash_portable', 'tank_auth')
                    );
                    $hashed_password = $hasher->HashPassword($Password);
                } else {
                    $hashed_password = '';
                }
                $Username = get_username();
                $data = array(
                    'username' => $Username,
                    'password' => $hashed_password,
                    "role_id" => 3,
                    "first_name" => $FirstName,
                    "last_name" => $LastName,
                    "name" => $FirstName.' '.$LastName,
                    'email' => $Email,
                    'phone' => $Phone,
                    'activated' => 1
                );

                $data['new_email_key'] = md5(rand() . microtime());
                if (!is_null($res = $this->users->create_user($data))) {
                    
                    $data['user_id'] = $res['user_id'];
                    $data['password'] = $Password;
                    
                    $data['site_name'] = $this->config->item('website_name', 'tank_auth');
                    // $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

                    // $this->_send_email('activate', $data['email'], $data);

                    // unset($data['password']); // Clear password (just for any case)

                    
                        if ($this->config->item('email_account_details', 'tank_auth')) { // send "welcome" email
                            $this->_send_email('welcome', $data['email'], $data);
                        }
                        unset($data['password']); // Clear password (just for any case)

                        $User = $this->users->get_user_by_email($Email);
                        // $login_token = $this->Rest_model->get_new_token([
                        //     'api_key_id' => $this->_apiuser->id,
                        //     'user_id' => $User->id,
                        //     'ip_address' => $_SERVER['REMOTE_ADDR'],
                        //     'device_id' => $DeviceID
                        // ]);

                        $DefaultOTP = "112233";
                        if ($User->otp == '') {
                            $OTP = get_otp($DefaultOTP);
                            $user_data = array(
                                "otp" => $OTP,
                            );
                            $this->Common->update_info(TBL_USERS,$User->id, $user_data,'id');
                        }
                        $OPT_SMS = "$OTP verification code.";
                        if (send_sms($User->phone, $OPT_SMS)) {
                            $this->response(['status' => TRUE,
                            // 'message' => 'You have successfully registered.Check your email address to verify your email.',
                            // "data" => ['user' => $User,$User,'user_id' => $User->id, 'login_token' => $login_token]]
                            'message' => 'You have successfully registered.OTP Send successfully.',
                            "data" => ["phone" => $User->phone]]
                                , REST_Controller::HTTP_OK);
                        }else{
                            $this->response(['status' => FALSE, 'message' => "OTP Send Fail, Please Try Again"], REST_Controller::HTTP_BAD_REQUEST);
                        }
                }else{
                    $this->response(['status' => FALSE, 'message' => "Something went wrong, Please try again."], REST_Controller::HTTP_BAD_REQUEST);
                }
            } 
            
        }
    }

    public function profile_get() {
        $User_info = $this->Common->get_info(TBL_USERS,$this->USER_ID,  'id','activated=1');
        if (!empty($User_info)) {
            $data['status'] = TRUE;
            $data['message'] = "Profile Found";
            $data["data"] = $User_info;
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => TRUE, 'message' => "Profile Not Found", 'data' => new stdClass()], REST_Controller::HTTP_OK);
        }
    }

    public function update_profile_post() {
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->response(['status' => FALSE, 'message' => $this->convert_msg($this->form_validation->error_array()), 'data' => new stdClass()], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $FirstName = $this->post('first_name');
            $LastName = $this->post('last_name');
            $Phone = $this->post('phone');
            $DeviceID = $this->post('device_id');

            if ($this->Common->check_is_exists(TBL_USERS,$Phone,'phone',$this->USER_ID,'id')) {
                $this->response(['status' => FALSE, 'message' => "Phone no is already used by another user. Please choose another Phone No."], REST_Controller::HTTP_BAD_REQUEST);
            }else{
                $data = array(
                    "first_name" => $FirstName,
                    "last_name" => $LastName,
                    "name" => $FirstName.' '.$LastName,
                    'phone' => $Phone,
                );
                $this->Common->update_info(TBL_USERS,$this->USER_ID, $data,'id');
                $User = $this->Common->get_info(TBL_USERS,$this->USER_ID,'id');

                $this->response(['status' => TRUE,
                'message' => 'Profile Updated successfully.',
                "data" => ["phone" => $User]]
                    , REST_Controller::HTTP_OK);     
                            
                       
            }
        } 
    }

    public function confirmopt_post() {
        $this->form_validation->set_rules('phone', 'Phone No', 'trim|required');
        $this->form_validation->set_rules('otp', 'OTP', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->response(['status' => FALSE, 'message' => $this->convert_msg($this->form_validation->error_array()), 'data' => new stdClass()], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $PhoneNo = $this->post('phone');
            $OTP = $this->post('otp');
            $DeviceID = $this->post('device_id');
            $DefaultOTP = "112233";

            if ($User = $this->Common->get_info(TBL_USERS,$PhoneNo,'phone')){
                if ($User->otp == $OTP || $DefaultOTP == $OTP) {
                    $login_token = $this->Rest_model->get_new_token([
                            'api_key_id' => $this->_apiuser->id,
                            'user_id' => $User->id,
                            'ip_address' => $_SERVER['REMOTE_ADDR'],
                            'device_id' => $DeviceID
                        ]);

                    $user_data = array(
                        "phone_verified" => 1,
                        "OTP" => ''
                    );
                    $this->Common->update_info(TBL_USERS,$User->id, $user_data,'id');

                    $this->response(['status' => TRUE,
                    'message' => 'Login successfully',
                    "data" => ['user' => $User,'user_id' => $User->id, 'login_token' => $login_token]]
                        , REST_Controller::HTTP_OK);
                } else {
                    $this->response(['status' => FALSE, 'message' => "The OTP entered is incorrect. Please enter correct OTP."], REST_Controller::HTTP_BAD_REQUEST);
                }
        } else {
            $this->response(['status' => FALSE, 'message' => "User Not Exist, Please Signup First"], REST_Controller::HTTP_BAD_REQUEST);
        }
        }
    }

    public function resendopt_post() {
        $this->form_validation->set_rules('phone', 'Phone No', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $this->response(['status' => FALSE, 'message' => $this->convert_msg($this->form_validation->error_array()), 'data' => new stdClass()], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $PhoneNo = $this->post('phone');
            if ($User = $this->Common->get_info(TBL_USERS,$PhoneNo,'phone')){
                if ($User->otp != '') {
                    $OTP = $User->otp;
                } else {
                    $OTP = rand(111111, 999999);
                }
                $OPT_SMS = "$OTP verification code.";
                if (send_sms($User->phone, $OPT_SMS)) {
                    $user_data = array(
                        "otp" => $OTP,
                    );
                    $this->Common->update_info(TBL_USERS,$User->id, $user_data,'id');
                    // Set the response and exit
                    $this->response(['status' => TRUE, 'message' => 'OTP ReSend successfully', "data" => ['phone' => $User->phone]], REST_Controller::HTTP_OK);
                } else {
                    $this->response(['status' => FALSE, 'message' => "OTP ReSend Fail, Please Try Again"], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response(['status' => FALSE, 'message' => "User Not Exist, Please Signup First"], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
     
    public function forgot_password_post() {
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->response(['status' => FALSE, 'message' => $this->convert_msg($this->form_validation->error_array()), 'data' => new stdClass()], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $Email = $this->post('email');
            if (!is_null($User = $this->users->get_user_by_email($Email))) { 
                $data = array(
                    'user_id' => $User->id,
                    'username' => $User->username,
                    'email' => $User->email,
                    'new_pass_key' => md5(rand() . microtime()),
                );

                $this->users->set_password_key($User->id, $data['new_pass_key']);
                $data['site_name'] = $this->config->item('website_name', 'tank_auth');

                    // Send email with password activation link
                    $this->_send_email('forgot_password', $data['email'], $data);

                    $this->response(['status' => TRUE,
                        'message' => 'An email with instructions for creating a new password has been sent to you.',
                        "data" => []]
                            , REST_Controller::HTTP_OK);
                    
                
            } else {
                $this->response(['status' => FALSE, 'message' => "Email mot exist!"], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function change_password_post() {
        $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
        $this->form_validation->set_rules('confirm_new_password', 'Confirm New Password', 'trim|required|matches[new_password]');
        if ($this->form_validation->run() == FALSE) {
            $this->response(['status' => FALSE, 'message' => $this->convert_msg($this->form_validation->error_array()), 'data' => new stdClass()], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $user_id = $this->USER_ID;
            $old_pass = $this->post('old_password');
            $new_pass = $this->post('new_password');
            if (!is_null($user = $this->users->get_user_by_id($user_id, true))) {

                // Check if old password correct
                $hasher = new PasswordHash(
                    $this->config->item('phpass_hash_strength', 'tank_auth'),
                    $this->config->item('phpass_hash_portable', 'tank_auth')
                );
                if ($hasher->CheckPassword($old_pass, $user->password)) { // success
                    // Hash new password using phpass
                    $hashed_password = $hasher->HashPassword($new_pass);
    
                    // Replace old password with new one
                    $this->users->change_password($user_id, $hashed_password);
                    $this->response(['status' => TRUE,
                        'message' => 'Your password has been successfully changed.']
                            , REST_Controller::HTTP_OK);
                } else { // fail
                    $this->response(['status' => FALSE, 'message' => "Incorrect password!"], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        }
    }

    public function logout_post() {
        if (!isset($this->rest->login_token)) {
            $this->response(['status' => FALSE, 'message' => "login_token_not_found"], REST_Controller::HTTP_BAD_REQUEST);
        }
        $this->load->library('form_validation');

       
            
            /* $this->_apiuser; || $this->rest->key; */
            $this->Rest_model->update_token($this->rest->login_token, ['is_active' => '0']);

            // Set the response and exit
            $this->response(['status' => TRUE, 'message' => 'logout_success'], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
    }

    public function banner_get($BannerID = false) {
        if ($BannerID) {
            $Banner_info = $this->Common->get_info(TBL_BANNER,$BannerID,  'BannerID','Status=1 AND isDeleted=0');
        } else {
            $OrderBy = array("field"=>'Order',"order"=>'asc');
            $Banner_info['banners'] = $this->Common->get_all_info(TBL_BANNER,1,'Status','isDeleted=0','*',false,false,$OrderBy);
        }
        if (!empty($Banner_info)) {
            $data['status'] = TRUE;
            $data['message'] = "Banner Found";
            $data["data"] = $Banner_info;
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => TRUE, 'message' => "Banner Not Found", 'data' => new stdClass()], REST_Controller::HTTP_OK);
        }
    }

    public function service_type_get($STID = false) {
        if ($STID) {
            $services_type_info = $this->Common->get_info(TBL_SERVICE_TYPE,$STID,  'STID','Status=1 AND isDeleted=0');
        } else {
            $OrderBy = array("field"=>'Order',"order"=>'asc');
            $services_type_info['types'] = $this->Common->get_all_info(TBL_SERVICE_TYPE,1,'Status','isDeleted=0','*',false,false,$OrderBy);
        }
        if (!empty($services_type_info)) {
            $data['status'] = TRUE;
            $data['message'] = "Service Type Found";
            $data["data"] = $services_type_info;
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => TRUE, 'message' => "Service Type Not Found", 'data' => new stdClass()], REST_Controller::HTTP_OK);
        }
    }

    public function services_get($ServiceType = false) {
        $join = array(
            array('table' => TBL_SERVICE_TYPE . ' st', 'on' => "st.STID=s.STID", 'type' => ''),
        );
        if ($ServiceType) {
            $services_info['services'] = $this->Common->get_all_info(TBL_SERVICES.' s',$ServiceType,'s.STID','s.Status=1 AND s.isDeleted=0','*',$join);
        } else {
            $services_info['services'] = $this->Common->get_all_info(TBL_SERVICES.' s',1,'s.Status','s.isDeleted=0','*',$join);
        }
        if (!empty($services_info)) {
            foreach ($services_info['services'] as $key => $value) {
                $User_info = $this->Common->get_info(TBL_USER_INTEREST,$value->ServiceID,'ServiceID','UserID='.$this->USER_ID);
                if (!empty($User_info)) {
                $services_info['services'][$key]->Save = "1";
            }else{
                    $services_info['services'][$key]->Save = "0";
                }
            }
            $data['status'] = TRUE;
            $data['message'] = "Services Found";
            $data["data"] = $services_info;
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => TRUE, 'message' => "Services Not Found", 'data' => new stdClass()], REST_Controller::HTTP_OK);
        }
    }

    public function search_services_post() {
        
            $Str = $this->post('search');
            if ($Str) {
                $services_info['services'] = $this->Common->get_all_info(TBL_SERVICES.' s',1,'s.Status','s.ServiceTitle like "%'.$Str.'%" AND s.isDeleted=0','*');
            } else {
                $services_info['services'] = $this->Common->get_all_info(TBL_SERVICES.' s',1,'s.Status','s.isDeleted=0','*');
            }
            if (!empty($services_info)) {
                foreach ($services_info['services'] as $key => $value) {
                    $User_info = $this->Common->get_info(TBL_USER_INTEREST,$value->ServiceID,'ServiceID','UserID='.$this->USER_ID);
                    if (!empty($User_info)) {
                    $services_info['services'][$key]->Save = "1";
                }else{
                        $services_info['services'][$key]->Save = "0";
                    }
                }
                $data['status'] = TRUE;
                $data['message'] = "Services Found";
                $data["data"] = $services_info;
                $this->response($data, REST_Controller::HTTP_OK);
            } else {
                $this->response(['status' => TRUE, 'message' => "Services Not Found", 'data' => new stdClass()], REST_Controller::HTTP_OK);
            }
    }

    public function top_services_get() {
        $top_info = $this->Common->get_info(TBL_TOP_SERVICES,1,'TopID');
        $services_info = [];
        foreach($top_info as $key=>$value) {
            if($key != 'TopID'){
                $s = $this->Common->get_info(TBL_SERVICES,$value,'ServiceID');
                array_push($services_info,$s);
            }
          }
        if (!empty($services_info)) {
            $sData['services'] = $services_info;
            $data['status'] = TRUE;
            $data['message'] = "Services Found";
            $data["data"] = $sData;
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => TRUE, 'message' => "Services Not Found", 'data' => new stdClass()], REST_Controller::HTTP_OK);
        }
    }

    public function contact_post() {
        $this->form_validation->set_rules('subject', 'Subject', 'trim|required');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->response(['status' => FALSE, 'message' => $this->convert_msg($this->form_validation->error_array()), 'data' => new stdClass()], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $Subject = $this->post('subject');
            $Message = $this->post('message');
            $UserID = $this->USER_ID;

            $data = array(
                'Subject' => $Subject,
                'Message' => $Message,
                'Status' => 1,
                'CreatedBy' => $UserID,
                'CreatedAt' => date("Y-m-d H:i:s")
            );

            if ($this->Common->add_info(TBL_CONTACT_SUPPORT, $data)) {
                $this->response(['status' => TRUE,
                'message' => 'Contact Request Sent successfully.']
                    , REST_Controller::HTTP_OK);
            } else {
                $this->response(['status' => FALSE, 'message' => "Something went wrong, Please try again!"], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function document_get($DocID = false) {
        if ($DocID) {
            $Doc_info = $this->Common->get_info(TBL_DOCUMENT,$DocID, 'ID','UserID = '.$this->USER_ID.' AND isDeleted=0');
        } else {
            $Doc_info['documents'] = $this->Common->get_all_info(TBL_DOCUMENT,1,'Status','UserID = '.$this->USER_ID.' AND isDeleted=0','*',false,false);
        }
        if (!empty($Doc_info)) {
            $data['status'] = TRUE;
            $data['message'] = "Document Found";
            $data["data"] = $Doc_info;
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => TRUE, 'message' => "Document Not Found", 'data' => new stdClass()], REST_Controller::HTTP_OK);
        }
    }

    public function my_service_get($ServiceStatus = false) {
        $join = array(
            array('table' => TBL_SERVICES . ' s', 'on' => "s.ServiceID=us.ServiceID", 'type' => ''),
        );
        if ($ServiceStatus) {
            $Service_info['services'] = $this->Common->get_all_info(TBL_USER_SERVICES.' us',$ServiceStatus, 'us.ServiceStatus','us.UserID = '.$this->USER_ID.' AND us.isDeleted=0','*',$join);
        } else {
            $Service_info['services'] = $this->Common->get_all_info(TBL_USER_SERVICES .' us',1,1,'us.UserID = '.$this->USER_ID.' AND us.isDeleted=0','*',$join,false);
        }
        if (!empty($Service_info)) {
            foreach ($Service_info['services'] as $key => $value) {
                $User_info = $this->Common->get_info(TBL_USER_INTEREST,$value->ServiceID,'ServiceID','UserID='.$this->USER_ID);
                if (!empty($User_info)) {
                $Service_info['services'][$key]->Save = "1";
            }else{
                    $Service_info['services'][$key]->Save = "0";
                }
            }
            $data['status'] = TRUE;
            $data['message'] = "Service Found";
            $data["data"] = $Service_info;
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => TRUE, 'message' => "Service Not Found", 'data' => new stdClass()], REST_Controller::HTTP_OK);
        }
    }

    public function interest_get() {
        $join = array(
            array('table' => TBL_SERVICES . ' s', 'on' => "s.ServiceID=us.ServiceID", 'type' => ''),
        );
            $Service_info['services'] = $this->Common->get_all_info(TBL_USER_INTEREST .' us',1,1,'us.UserID = '.$this->USER_ID,'*',$join,false);
        if (!empty($Service_info) && count($Service_info['services']) > 0) {
            foreach ($Service_info['services'] as $key => $value) {
                $User_info = $this->Common->get_info(TBL_USER_INTEREST,$value->ServiceID,'ServiceID','UserID='.$this->USER_ID);
                if (!empty($User_info)) {
                    $Service_info['services'][$key]->Save = "1";
                }else{
                    $Service_info['services'][$key]->Save = "0";
                }
            }
            $data['status'] = TRUE;
            $data['message'] = "Service Found";
            $data["data"] = $Service_info;
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => TRUE, 'message' => "Service Not Found", 'data' => new stdClass()], REST_Controller::HTTP_OK);
        }
    }

    public function interest_post() {
        $this->form_validation->set_rules('serviceid', 'Service', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->response(['status' => FALSE, 'message' => $this->convert_msg($this->form_validation->error_array()), 'data' => new stdClass()], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $ServiceID = $this->post('serviceid');
            $UserID = $this->USER_ID;

            if ($this->Common->check_is_exists(TBL_USER_INTEREST,$ServiceID,'ServiceID',0,'ID','UserID = '.$UserID)) {
                $data_remove = $this->Remove_records->remove_data($ServiceID, 'ServiceID', TBL_USER_INTEREST,'UserID = '.$UserID,'hard');

                $this->response(['status' => TRUE, 'message' => "Service Removed From Interest successfully."], REST_Controller::HTTP_OK);
            }else{
                $data = array(
                    'UserID' => $UserID,
                    'ServiceID' => $ServiceID,
                    'CreatedAt' => date("Y-m-d H:i:s")
                );

                if ($this->Common->add_info(TBL_USER_INTEREST, $data)) {
                    $this->response(['status' => TRUE,
                    'message' => 'Service Added To Interest successfully.']
                        , REST_Controller::HTTP_OK);
                } else {
                    $this->response(['status' => FALSE, 'message' => "Something went wrong, Please try again!"], REST_Controller::HTTP_BAD_REQUEST);
                }
            }
        }
    }

    public function calendar_get($EID = false) {
        if ($EID) {
            $event_info = $this->Common->get_info(TBL_EVENT,$EID, 'ID','isDeleted=0');
        } else {
            $event_info['events'] = $this->Common->get_all_info(TBL_EVENT,1,'Status','isDeleted=0','*',false,false);
        }
        if (!empty($event_info)) {
            $data['status'] = TRUE;
            $data['message'] = "Event Found";
            $data["data"] = $event_info;
            $this->response($data, REST_Controller::HTTP_OK);
        } else {
            $this->response(['status' => TRUE, 'message' => "Event Not Found", 'data' => new stdClass()], REST_Controller::HTTP_OK);
        }
    }
}