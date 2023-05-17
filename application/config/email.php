<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|    http://codeigniter.com/user_guide/libraries/email.html
|
 */
$config['protocol'] = PROTOCOL;
$config['smtp_host'] = SMTP_HOST;
$config['smtp_port'] = SMTP_PORT;
$config['smtp_user'] = SMTP_USER;
$config['smtp_pass'] = SMTP_PASS;
$config['smtp_crypto'] = 'security'; //can be 'ssl' or 'tls' for example
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";

/* End of file email.php */
/* Location: ./application/config/email.php */
