<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Rest_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    private function aes256Encrypt($data) {
        $key = config_item('encryption_key');
        if (32 !== strlen($key)) {
            $key = hash('SHA256', $key, true);
        }
        $padding = 16 - (strlen($data) % 16);
        $data .= str_repeat(chr($padding), $padding);
        return mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16));
    }

    private function aes256Decrypt($data) {
        $key = config_item('encryption_key');
        if (32 !== strlen($key)) {
            $key = hash('SHA256', $key, true);
        }
        $data = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $data, MCRYPT_MODE_CBC, str_repeat("\0", 16));
        $padding = ord($data[strlen($data) - 1]);
        return substr($data, 0, -$padding);
    }

    function get_new_token($data) {
        $key = $this->generate_token();
        $this->_insert_token($key, $data);
        return $key;
    }

    function generate_token() {
        do {
// Generate a random salt
            $salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);

// If an error occurred, then fall back to the previous method
            if ($salt === FALSE) {
                $salt = hash('sha256', time() . mt_rand());
            }

            $new_token = substr($salt, 0, 32);
        } while ($this->_token_exists($new_token));

        return $new_token;
    }

    function get_token($key) {
        return $this->db->where('token', $key)
                        ->where('is_active', '1')
                        ->get('api_login_tokens')
                        ->row();
    }

    private function _token_exists($key) {
        return $this->db->where('token', $key)
                        ->where('is_active', '1')
                        ->count_all_results('api_login_tokens') > 0;
    }

    private function _insert_token($key, $data) {
        $data['token'] = $key;
        $data['is_active'] = '1';
        $data['date_created'] = mysql_date();
        return $this->db->set($data)->insert('api_login_tokens');
    }

    function update_token($key, $data) {
        return $this->db->where('token', $key)->update('api_login_tokens', $data);
    }

    function deactive_user_tokens($user_id) {
        return $this->db->where('user_id', $user_id)->update('api_login_tokens', array('is_active' => '0'));
    }

    function delete_token($key) {
        return $this->db->where('token', $key)->delete('api_login_tokens');
    }

}
