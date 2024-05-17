<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Auth extends Base_Controller
{

    public function __construct()
    {
        parent::__construct(true);

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('tank_auth');
        $this->load->library('session');
        $this->lang->load('tank_auth');
        $this->load->model('tank_auth/users');
    }

    public function index()
    {
        if ($message = $this->session->flashdata('message')) {
            $this->load->view('auth/general_message', array('message' => $message));
        } else {
            redirect('/auth/login/');
        }
    }

    /**
     * Login user on the site
     *
     * @return void
     */
    public function login()
    {
        if ($this->input->is_ajax_request()) {
            $_data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') and
                $this->config->item('use_username', 'tank_auth'));
            $_data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

            $this->form_validation->set_rules('login', 'Email', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('remember', 'Remember me', 'integer');
            if ($this->config->item('login_count_attempts', 'tank_auth') and ($login = $this->input->post('login'))) {
                $login = $this->security->xss_clean($login);
            } else {
                $login = '';
            }
            if ($this->form_validation->run()) { // validation ok
                if ($this->tank_auth->login(
                    $this->form_validation->set_value('login'),
                    $this->form_validation->set_value('password'),
                    $this->form_validation->set_value('remember'),
                    $_data['login_by_username'],
                    $_data['login_by_email']
                )) { // success
                    $data['status'] = 'ok';
                    $data['message'] = 'Successfully Login';
                } else {
                    $data['status'] = 'error';
                    $errors = $this->tank_auth->get_error_message();
                    if (isset($errors['banned'])) { // banned user
                        $data['error'] = $this->lang->line('auth_message_banned') . ' ' . $errors['banned'];
                    } elseif (isset($errors['not_activated'])) { // not activated user
                        $data['error'] = 'This user not activated';
                    } else { // fail
                        foreach ($errors as $k => $v) {
                            $data['error'][$k] = $this->lang->line($v);
                        }

                    }
                }
            } else {
                $data['status'] = 'error';
                $data['error'] = $this->form_validation->error_array();
            }
            echo json_encode($data);
            die();
        } else {
            if ($this->tank_auth->is_logged_in()) { // logged in
                redirect('');
            } elseif ($this->tank_auth->is_logged_in(false)) { // logged in, not activated
                redirect('/auth/send_again/');
            } else {
                $data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') and
                    $this->config->item('use_username', 'tank_auth'));
                $data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');

                $this->form_validation->set_rules('login', 'Email', 'trim|required|xss_clean');
                $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
                $this->form_validation->set_rules('remember', 'Remember me', 'integer');

                // Get login for counting attempts to login
                // if ($this->config->item('login_count_attempts', 'tank_auth') and ($login = $this->input->post('login'))) {
                //     $login = $this->security->xss_clean($login);
                // } else {
                //     $login = '';
                // }
                // $data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
                // if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
                //     if ($data['use_recaptcha']) {
                //         $this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|required|callback__check_recaptcha');
                //     } else {
                //         $this->form_validation->set_rules('captcha', 'Confirmation Code', 'trim|required|callback__check_captcha');
                //     }
                // }
                $data['errors'] = array();

                if ($this->form_validation->run()) { // validation ok
                    if ($this->tank_auth->login(
                        $this->form_validation->set_value('login'),
                        $this->form_validation->set_value('password'),
                        $this->form_validation->set_value('remember'),
                        $data['login_by_username'],
                        $data['login_by_email']
                    )) { // success
                        redirect('');
                    } else {
                        $errors = $this->tank_auth->get_error_message();
                        if (isset($errors['banned'])) { // banned user
                            $this->_show_message($this->lang->line('auth_message_banned') . ' ' . $errors['banned']);
                        } elseif (isset($errors['not_activated'])) { // not activated user
                            redirect('/auth/send_again/');
                        } else { // fail
                            foreach ($errors as $k => $v) {
                                $data['errors'][$k] = $this->lang->line($v);
                            }

                        }
                    }
                }
                //                $data['show_captcha'] = FALSE;
                //                if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
                //                    $data['show_captcha'] = TRUE;
                //                    if ($data['use_recaptcha']) {
                //                        $data['recaptcha_html'] = $this->_create_recaptcha();
                //                    } else {
                //                        $data['captcha_html'] = $this->_create_captcha();
                //                    }
                //                }
                $this->load->view('auth/login_form', $data);
            }
        }
    }

    public function ajax_form()
    {
        $responce['html'] = $this->partial('auth/login_ajax_form', array(), true);
        echo json_encode($responce);
        die;
    }

    public function social_login()
    {
        if ($this->input->post()) {
            $email = $this->input->post('email');
            $user = $this->Common->get_info(TBL_USERS, $email, 'email');
            if (!$user && !is_null($user)) {
                $name = explode(" ", $this->input->post('displayName'));
                $username = get_username('SE');

                if (!is_null($data = $this->tank_auth->create_user(
                    $username,
                    $name[0],
                    $name[1],
                    $email,
                    '',
                    $this->input->post('uid'),
                    $this->input->post('auth_provider'),
                    '',
                    ''
                ))) { // success

                    $post_data = array(
                        "customer_id" => $data['user_id'],
                        'email' => $email,
                        "phone" => '',
                        'status' => 'pending',
                    );

                    $post_data['created_at'] = date("Y-m-d H:i:s");
                    if ($seller_id = $this->Common->add_info(TBL_SELLERS, $post_data)) {

                        $userdata = array(
                            "user_id" => $seller_id,
                        );
                        $this->Common->update_info(TBL_USERS, $data['user_id'], $userdata, 'id');
                    }

                    $data['site_name'] = $this->config->item('website_name', 'tank_auth');

                    if ($this->config->item('email_account_details', 'tank_auth')) { // send "welcome" email
                        $this->_send_email('welcome', $data['email'], $data);
                    }
                }

                $user = $this->Common->get_info(TBL_USERS, $email, 'email');
            }
            $this->session->set_userdata(array(
                'user_id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'fullname' => $user->first_name . ' ' . $user->last_name,
                'status' => ($user->activated == 1) ? '1' : '0',
            ));
            $this->users->update_login_info(
                $user->id,
                $this->config->item('login_record_ip', 'tank_auth'),
                $this->config->item('login_record_time', 'tank_auth')
            );
            $response = array("status" => "ok", "heading" => "Login", "message" => "You have been successfully logged in.");
        }
        echo json_encode($response);
        die;
    }

    /**
     * Logout user
     *
     * @return void
     */
    public function logout()
    {
        $this->tank_auth->logout();

        $this->_show_message($this->lang->line('auth_message_logged_out'));
    }

    /**
     * Register user on the site
     *
     * @return void
     */
    public function register()
    {
        if ($this->tank_auth->is_logged_in()) { // logged in
            redirect('');
        } elseif ($this->tank_auth->is_logged_in(false)) { // logged in, not activated
            redirect('/auth/send_again/');
        } elseif (!$this->config->item('allow_registration', 'tank_auth')) { // registration is off
            $this->_show_message($this->lang->line('auth_message_registration_disabled'));
        } else {
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('phone', 'Phone Number', 'trim|required|numeric');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');

            $data['errors'] = array();

            $email_activation = $this->config->item('email_activation', 'tank_auth');

            if ($this->form_validation->run()) { // validation ok
                if ($this->input->post('firebase_uid') == '' || $this->input->post('auth_provider') != 'Phone') {
                    $data['errors']['phone_varified'] = 0;
                    $data['errors']['phone'] = 'Phone Number is Not Varified!';
                    $this->load->view('auth/register_form', $data);
                    return;
                }
                $username = get_username('SE');
                $email = strtolower($this->form_validation->set_value('email'));

                if (!is_null($data = $this->tank_auth->create_user(
                    $username,
                    $this->form_validation->set_value('first_name'),
                    $this->form_validation->set_value('last_name'),
                    $email,
                    $this->form_validation->set_value('phone'),
                    $this->input->post('firebase_uid'),
                    $this->input->post('auth_provider'),
                    $this->form_validation->set_value('password'),
                    $email_activation
                ))) { // success

                    $post_data = array(
                        "customer_id" => $data['id'],
                        "email" => $email,
                        "phone" => $this->form_validation->set_value('phone'),
                    );

                    $post_data['created_at'] = date("Y-m-d H:i:s");
                    if ($seller_id = $this->Common->add_info(TBL_SELLERS, $post_data)) {

                        $userdata = array(
                            "user_id" => $seller_id,
                        );
                        $this->Common->update_info(TBL_USERS, $data['id'], $userdata, 'id');
                    }

                    $data['site_name'] = $this->config->item('website_name', 'tank_auth');

                    if ($email_activation) { // send "activate" email
                        $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

                        $this->_send_email('activate', $data['email'], $data);

                        unset($data['password']); // Clear password (just for any case)

                        $this->_show_message($this->lang->line('auth_message_registration_completed_1'));
                        //$data['admin_not_allowed'] = $this->lang->line('auth_message_registration_completed_1');
                    } else {
                        if ($this->config->item('email_account_details', 'tank_auth')) { // send "welcome" email
                            $this->_send_email('welcome', $data['email'], $data);
                        }
                        unset($data['password']); // Clear password (just for any case)

                        $this->_show_message($this->lang->line('auth_message_registration_completed_2') . ' ' . anchor('/auth/login/', 'Login'));
                        // $data['admin_not_allowed'] = $this->lang->line('auth_message_registration_completed_2') . ' ' . anchor('/auth/login/', 'Login');
                    }
                } else {
                    $errors = $this->tank_auth->get_error_message();
                    foreach ($errors as $k => $v) {
                        $data['errors'][$k] = $this->lang->line($v);
                    }

                }

            }
            $this->load->view('auth/register_form', $data);
        }
    }

    public function is_phone_available($phone)
    {
        if ($this->Common->check_is_exists(TBL_USERS, $phone, 'phone')) {
            $response['message'] = 'Phone number is already used by another user. Please choose another number.';
            echo json_encode($response);
            die;
        } else {
            $response = array("status" => "ok");
        }
        echo json_encode($response);
        die;
    }

    /**
     * Send activation email again, to the same or new email address
     *
     * @return void
     */
    public function send_again()
    {
        if (!$this->tank_auth->is_logged_in(false)) { // not logged in or activated
            redirect('/auth/login/');
        } else {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

            $data['errors'] = array();

            if ($this->form_validation->run()) { // validation ok
                if (!is_null($data = $this->tank_auth->change_email(
                    $this->form_validation->set_value('email')
                ))) { // success
                    $data['site_name'] = $this->config->item('website_name', 'tank_auth');
                    $data['activation_period'] = $this->config->item('email_activation_expire', 'tank_auth') / 3600;

                    $this->_send_email('activate', $data['email'], $data);

                    $this->_show_message(sprintf($this->lang->line('auth_message_activation_email_sent'), $data['email']));
                    //$data['admin_not_allowed'] = sprintf($this->lang->line('auth_message_activation_email_sent'), $data['email']);
                } else {
                    $errors = $this->tank_auth->get_error_message();
                    foreach ($errors as $k => $v) {
                        $data['errors'][$k] = $this->lang->line($v);
                    }

                }
            }
            $this->load->view('auth/send_again_form', $data);
        }
    }

    /**
     * Activate user account.
     * User is verified by user_id and authentication code in the URL.
     * Can be called by clicking on link in mail.
     *
     * @return void
     */
    public function activate()
    {
        $user_id = $this->uri->segment(3);
        $new_email_key = $this->uri->segment(4);

        // Activate user
        if ($this->tank_auth->activate_user($user_id, $new_email_key)) { // success
            // $this->tank_auth->logout();
            // $this->_show_message($this->lang->line('auth_message_activation_completed') . ' ' . anchor('/auth/login/', 'Login'));
            $this->_show_message($this->lang->line('auth_message_activation_completed'));
        } else { // fail
            $this->_show_message($this->lang->line('auth_message_activation_failed'));
        }
    }

    /**
     * Generate reset code (to change password) and send it to user
     *
     * @return void
     */
    public function forgot_password()
    {
        if ($this->tank_auth->is_logged_in()) { // logged in
            redirect('');
        } elseif ($this->tank_auth->is_logged_in(false)) { // logged in, not activated
            redirect('/auth/send_again/');
        } else {
            $this->form_validation->set_rules('login', 'Email or login', 'trim|required|xss_clean');

            $data['errors'] = array();

            if ($this->form_validation->run()) { // validation ok
                if (!is_null($data = $this->tank_auth->forgot_password(
                    $this->form_validation->set_value('login')
                ))) {

                    $data['site_name'] = $this->config->item('website_name', 'tank_auth');

                    // Send email with password activation link
                    $this->_send_email('forgot_password', $data['email'], $data);

                    $this->_show_message($this->lang->line('auth_message_new_password_sent'));
                    //$data['admin_not_allowed'] = $this->lang->line('auth_message_new_password_sent');
                } else {
                    $errors = $this->tank_auth->get_error_message();
                    foreach ($errors as $k => $v) {
                        $data['errors'][$k] = $this->lang->line($v);
                    }

                }
            }
            $this->load->view('auth/forgot_password_form', $data);
        }
    }

    /**
     * Replace user password (forgotten) with a new one (set by user).
     * User is verified by user_id and authentication code in the URL.
     * Can be called by clicking on link in mail.
     *
     * @return void
     */
    public function reset_password()
    {
        $user_id = $this->uri->segment(3);
        $new_pass_key = $this->uri->segment(4);

        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']');
        $this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|matches[new_password]');

        $data['errors'] = array();

        if ($this->form_validation->run()) { // validation ok
            if (!is_null($data = $this->tank_auth->reset_password(
                $user_id,
                $new_pass_key,
                $this->form_validation->set_value('new_password')
            ))) { // success
                $data['site_name'] = $this->config->item('website_name', 'tank_auth');

                // Send email with new password
                //$this->_send_email('reset_password', $data['email'], $data);

                $this->_show_message($this->lang->line('auth_message_new_password_activated') . ' ' . anchor('/auth/login/', 'Login'));
            } else { // fail
                $this->_show_message($this->lang->line('auth_message_new_password_failed'));
            }
        } else {
            // Try to activate user by password key (if not activated yet)
            if ($this->config->item('email_activation', 'tank_auth')) {
                $this->tank_auth->activate_user($user_id, $new_pass_key, false);
            }

            if (!$this->tank_auth->can_reset_password($user_id, $new_pass_key)) {
                $this->_show_message($this->lang->line('auth_message_new_password_failed'));
            }
        }
        $this->load->view('auth/reset_password_form', $data);
    }

    /**
     * Change user password
     *
     * @return void
     */
    public function change_password()
    {
        if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
            redirect('/auth/login/');
        } else {
            $this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[' . $this->config->item('password_min_length', 'tank_auth') . ']|max_length[' . $this->config->item('password_max_length', 'tank_auth') . ']');
            $this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|matches[new_password]');

            $data['errors'] = array();

            if ($this->form_validation->run()) { // validation ok
                if ($this->tank_auth->change_password(
                    $this->form_validation->set_value('old_password'),
                    $this->form_validation->set_value('new_password')
                )) { // success
                    $this->_show_message($this->lang->line('auth_message_password_changed'));
                } else { // fail
                    $errors = $this->tank_auth->get_error_message();
                    foreach ($errors as $k => $v) {
                        $data['errors'][$k] = $this->lang->line($v);
                    }

                }
            }
            $this->load->view('auth/change_password_form', $data);
        }
    }

    /**
     * Change user email
     *
     * @return void
     */
    public function change_email()
    {
        if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
            redirect('/auth/login/');
        } else {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

            $data['errors'] = array();

            if ($this->form_validation->run()) { // validation ok
                if (!is_null($data = $this->tank_auth->set_new_email(
                    $this->form_validation->set_value('email'),
                    $this->form_validation->set_value('password')
                ))) { // success
                    $data['site_name'] = $this->config->item('website_name', 'tank_auth');

                    // Send email with new email address and its activation link
                    $this->_send_email('change_email', $data['new_email'], $data);

                    $this->_show_message(sprintf($this->lang->line('auth_message_new_email_sent'), $data['new_email']));
                } else {
                    $errors = $this->tank_auth->get_error_message();
                    foreach ($errors as $k => $v) {
                        $data['errors'][$k] = $this->lang->line($v);
                    }

                }
            }
            $this->load->view('auth/change_email_form', $data);
        }
    }

    /**
     * Replace user email with a new one.
     * User is verified by user_id and authentication code in the URL.
     * Can be called by clicking on link in mail.
     *
     * @return void
     */
    public function reset_email()
    {
        $user_id = $this->uri->segment(3);
        $new_email_key = $this->uri->segment(4);

        // Reset email
        if ($this->tank_auth->activate_new_email($user_id, $new_email_key)) { // success
            $this->tank_auth->logout();
            $this->_show_message($this->lang->line('auth_message_new_email_activated') . ' ' . anchor('/auth/login/', 'Login'));
        } else { // fail
            $this->_show_message($this->lang->line('auth_message_new_email_failed'));
        }
    }

    /**
     * Delete user from the site (only when user is logged in)
     *
     * @return void
     */
    public function unregister()
    {
        if (!$this->tank_auth->is_logged_in()) { // not logged in or not activated
            redirect('/auth/login/');
        } else {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

            $data['errors'] = array();

            if ($this->form_validation->run()) { // validation ok
                if ($this->tank_auth->delete_user(
                    $this->form_validation->set_value('password')
                )) { // success
                    $this->_show_message($this->lang->line('auth_message_unregistered'));
                } else { // fail
                    $errors = $this->tank_auth->get_error_message();
                    foreach ($errors as $k => $v) {
                        $data['errors'][$k] = $this->lang->line($v);
                    }

                }
            }
            $this->load->view('auth/unregister_form', $data);
        }
    }

    /**
     * Show info message
     *
     * @param    string
     * @return    void
     */
    public function _show_message($message)
    {
        $this->session->set_flashdata('message', $message);
        redirect('/auth/');
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
    }

    /**
     * Create CAPTCHA image to verify user as a human
     *
     * @return    string
     */
    public function _create_captcha()
    {
        $this->load->helper('captcha');

        $cap = create_captcha(array(
            'img_path' => './' . $this->config->item('captcha_path', 'tank_auth'),
            'img_url' => base_url() . $this->config->item('captcha_path', 'tank_auth'),
            'font_path' => './' . $this->config->item('captcha_fonts_path', 'tank_auth'),
            'font_size' => $this->config->item('captcha_font_size', 'tank_auth'),
            'img_width' => $this->config->item('captcha_width', 'tank_auth'),
            'img_height' => $this->config->item('captcha_height', 'tank_auth'),
            'show_grid' => $this->config->item('captcha_grid', 'tank_auth'),
            'expiration' => $this->config->item('captcha_expire', 'tank_auth'),
        ));

        // Save captcha params in session
        $this->session->set_flashdata(array(
            'captcha_word' => $cap['word'],
            'captcha_time' => $cap['time'],
        ));

        return $cap['image'];
    }

    /**
     * Callback function. Check if CAPTCHA test is passed.
     *
     * @param    string
     * @return    bool
     */
    public function _check_captcha($code)
    {
        $time = $this->session->flashdata('captcha_time');
        $word = $this->session->flashdata('captcha_word');

        list($usec, $sec) = explode(" ", microtime());
        $now = ((float) $usec + (float) $sec);

        if ($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
            $this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
            return false;
        } elseif (($this->config->item('captcha_case_sensitive', 'tank_auth') and
            $code != $word) or
            strtolower($code) != strtolower($word)
        ) {
            $this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
            return false;
        }
        return true;
    }

    /**
     * Create reCAPTCHA JS and non-JS HTML to verify user as a human
     *
     * @return    string
     */
    public function _create_recaptcha()
    {
        $this->load->helper('recaptcha');

        // Add custom theme so we can get only image
        $options = "<script>var RecaptchaOptions = {theme: 'custom', custom_theme_widget: 'recaptcha_widget'};</script>\n";

        // Get reCAPTCHA JS and non-JS HTML
        $html = recaptcha_get_html($this->config->item('recaptcha_public_key', 'tank_auth'));

        return $options . $html;
    }

    /**
     * Callback function. Check if reCAPTCHA test is passed.
     *
     * @return    bool
     */
    public function _check_recaptcha()
    {
        $this->load->helper('recaptcha');

        $resp = recaptcha_check_answer($this->config->item('recaptcha_private_key', 'tank_auth'), $_SERVER['REMOTE_ADDR'], $_POST['recaptcha_challenge_field'], $_POST['recaptcha_response_field']);

        if (!$resp->is_valid) {
            $this->form_validation->set_message('_check_recaptcha', $this->lang->line('auth_incorrect_captcha'));
            return false;
        }
        return true;
    }

    public function check_login()
    {
        if ($this->tank_auth->is_logged_in()) {
            $responce['status'] = 'login';
            $responce['email'] = $this->session->userdata('email');
        } else {
            $responce['status'] = 'logout';
        }
        echo json_encode($responce);
        die;
    }
    
    public function payment()
    {
        $data['page_title'] = "Manage Payments";
        $this->load->view('auth/ccavenue', $data);
    }

    public function save_payment()  {
        if ($this->input->post()) {
            $response = array("message" => "Please Wait...");
            // $response = array("status" => "success", "heading" => "Unknown Error", "message" => "There was an unknown error that occurred. You will need to refresh the page to continue working.");
            $id = ($this->input->post('user_id') && $this->input->post('user_id') > 0) ? $this->input->post('user_id') : 0;
            $this->form_validation
                ->set_rules('amount', 'Amount', 'required')
                ->set_rules('billing_name', 'Name', 'required')
                ->set_rules('billing_email', 'Email', 'required')
                ->set_rules('billing_tel', 'Phone No', 'required')
                ->set_rules('company_name', 'Company Name', 'required')
                ->set_rules('gst', 'GST No', 'required')
                ->set_rules('billing_address', 'Address', 'required');
            $this->form_validation->set_message('required', '{field} field should not be blank.');
            $error_element = error_elements();
            $this->form_validation->set_error_delimiters($error_element[0], $error_element[1]);
            if ($this->form_validation->run()) {
                $data=$this->input->post(array(
                    'tid'=>'tid',
                    'merchant_id'=>'merchant_id',
                    'order_id'=>'order_id',
                    'amount'=>'amount',
                    'currency'=>'currency',
                    'redirect_url'=>'redirect_url',
                    'cancel_url'=>'cancel_url',
                    'language'=>'language',
                    'billing_name'=>'billing_name',
                    'billing_address'=>'billing_address',
                    'delivery_city'=>'delivery_city',
                    'delivery_state'=>'delivery_state',
                    'delivery_zip'=>'delivery_zip',
                    'delivery_country'=>'delivery_country',
                    'billing_tel'=>'billing_tel',
                    'billing_email'=>'billing_email'

                ));

                $post_data = array( 
                    "TransactionID" => $this->input->post('tid'),
                    "OrderID" => $this->input->post('tid'),
                    "Amount" => $this->input->post('amount'),
                    "Name" => $this->input->post('billing_name'),
                    "Email" => $this->input->post('billing_email'),
                    "Phone" => $this->input->post('billing_tel'),
                    "CompanyName" => $this->input->post('company_name'),
                    "GST" => $this->input->post('gst'),
                    "Address" => $this->input->post('billing_address'),
                    "PaymentStatus" => 'Pending',
                );

                $post_data['CreatedAt'] = date("Y-m-d H:i:s");
                $PID = $this->Common->add_info(TBL_CCA_PAYMENT, $post_data);

                $merchant_data='';
                $working_key=CCA_WORKING_KEY;//Shared by CCAVENUES	
                $access_code=CCA_ACCESS_CODE;//Shared by CCAVENUES

                
                foreach ($data as $key => $value){
                    $merchant_data.=$key.'='.$value.'&';
                }

            	$this->load->library('ccavenue');
                $encrypted_data = $this->ccavenue->encrypt($merchant_data,$working_key); 

?>
        <form method="post" name="redirect"
            action="https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
            <?php
        echo "<input type=hidden name=encRequest value=$encrypted_data>";
        echo "<input type=hidden name=access_code value=$access_code>";
        ?>
        </form>
        
        <script language='javascript'>
        document.redirect.submit();
        </script>

<?php
echo "Please Wait...";
} else {
    $response['error'] = $this->form_validation->error_array();
    echo json_encode($response);
    die;
}
}
	}

    public function payment_handler(){
        $this->load->library('ccavenue');

	//$encrypted_data=$this->ccavenue->encrypt($merchant_data,$working_key); 


	$workingKey=CCA_WORKING_KEY;		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=$this->ccavenue->decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
	}

    $post_data = array(         
        "PaymentStatus" => 'completed',
        "Status" => $order_status,
        "CCResponse" => json_encode($decryptValues)
    );
   
    $post_data['UpdatedAt'] = date("Y-m-d H:i:s");
    $this->Common->update_info(TBL_CCA_PAYMENT,2, $post_data, 'PID');

	if($order_status==="Success")
	{
        $data['message'] = "Thank you for payment.";
		
	}
	else if($order_status==="Aborted")
	{
		$data['message'] = "Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
	
	}
	else if($order_status==="Failure")
	{
		$data['message']= "Thank you for shopping with us.However,the transaction has been declined.";
	}
	else
	{
		$data['message']= "Security Error. Illegal access detected";
        
	}
    
    $data['FormURL']= BASE_URL .'payment';
	
        $this->load->view('auth/payment_complete', $data);
    }
    public function payment_cancel(){
        $this->load->view('auth/payment_cancel', $data);
    }
}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */