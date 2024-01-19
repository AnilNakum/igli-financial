<?php
function success_elements()
{
    return array('<div class="alert alert-block alert-success fade in"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button>', '</div>');
}

function error_elements()
{
    return array('<div class="alert alert-block alert-danger fade in"><button type="button" class="close close-sm" data-dismiss="alert"><i class="fa fa-times"></i></button>', '</div>');
}

function add_edit_form()
{
    echo '<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="add_edit_form"></div>';
}

function full_popup()
{
    echo '<div class="cbp-spmenu cbp-spmenu-vertical-full cbp-spmenu-full-right" id="full_form"></div>';
}

function half_popup()
{
    echo '<div class="cbp-spmenu cbp-spmenu-vertical-half cbp-spmenu-half-right" id="half_form"></div>';
}

function static_from($data = '')
{
    echo '<div class="cbp-spmenu cbp-spmenu-vertical cbp-spmenu-right" id="static_popup">' . $data . '</div>';
}

function randomNumber()
{
    return rand(111, 9999);
}

function chek_array($array1, $array2)
{
    return !array_diff($array1, $array2) && !array_diff($array2, $array1);
}

function get_otp($DefaultOTP) {
    $OTP = rand(111111, 999999);
    if ($OTP == $DefaultOTP) {
        get_otp($DefaultOTP);
    }
    return $OTP;
}


function delete_file($inner_dir, $old_file_name = '')
{
    $ci = &get_instance();
    $upload_path = $inner_dir;
    if (!empty($old_file_name)) {
        $file_path = $upload_path . $old_file_name;
        if ($file_path != "" && file_exists($file_path)):
            unlink($file_path);
        endif;
        return true;
    }
    return false;
}

function upload_file($post_file_name, $inner_dir, $old_file_name = '', $ExConfig = array()) {
    $ci = & get_instance();
    $upload_path = UPLOAD_DIR . $inner_dir;
    if (!file_exists(UPLOAD_DIR)) : mkdir(UPLOAD_DIR, 0777, TRUE);
    endif;
    if (!file_exists($upload_path)) : mkdir($upload_path, 0777, TRUE);
    endif;
    $config['upload_path'] = $upload_path;
    $config['allowed_types'] = '*';
    $config['max_width'] = 0;
    $config['max_height'] = 0;
    $config['max_size'] = 0;
    $config['encrypt_name'] = TRUE;
    $ci->load->library('upload', $config);
    if (isset($_FILES[$post_file_name]["name"]) && $_FILES[$post_file_name]["name"] != "") {
        if ($ci->upload->do_upload($post_file_name)) {
            $upload_data = $ci->upload->data();
            $_config['image_library'] = 'gd2';
            $_config['source_image'] = $upload_data['full_path'];
            $_config['create_thumb'] = false;
            $_config = array_merge($_config, $ExConfig);
            $ci->load->library('image_lib', $_config);
            // $ci->image_lib->resize();
            $upload_data = $ci->upload->data();
            if (!empty($old_file_name)) {
                $file_path = UPLOAD_DIR . "/" . $old_file_name;
                if ($file_path != "" && file_exists($file_path)):
                    unlink($file_path);
                endif;
            }
            return $upload_data;
        } else {
            return $ci->upload->display_errors();
        }
    }
    return FALSE;
}



function generateRandomString($length = 15)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return encrypt($randomString);
}

function convert_date_format($date)
{
    if (!empty($date)) {
        //    $date = "10/24/2014";
        $date = DateTime::createFromFormat("m-d-Y", $date);
        return $date->format('Y-m-d');
    }
    return '';
}

function DatetimeFormat($date)
{
    if (!empty($date)) {
        $datetime  = $datetime = new DateTime( $date);
        return $datetime->format('d/m/Y h:i A');
    }
    return '';
}

function pr($arr = array(), $die = false)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    if ($die) {
        die;
    }
}

function get_username($pre = 'IGLI')
{
    $ci = &get_instance();
    $ci->load->helper('string');
    $username = $pre . random_string('nozero', 6);
    if ($ci->Common->check_username($username)) {
        return get_username($pre);
    } else {
        return $username;
    }
}

function encryptionKey()
{
    $username = strtolower(ENC_USERNAME);
    return array(hash("sha1", ENC_PASSWORD . $username), hash("sha1", $username . IVSEED));
}

function encrypt($str)
{
    $pass = str_split(str_pad('', strlen($str), ENC_PASSWORD, STR_PAD_RIGHT));
    $stra = str_split($str);
    foreach ($stra as $k => $v) {
        $tmp = ord($v) + ord($pass[$k]);
        $stra[$k] = chr($tmp > 255 ? ($tmp - 256) : $tmp);
    }
    $stra = join('', $stra);
    $stra = str_replace("\\", "TSCORE", $stra);
    $stra = str_replace("[", "SQUARELEFT", $stra);
    $stra = str_replace("]", "SQUARERIGHT", $stra);
    return $stra;
}

function decrypt($str)
{
    $str = str_replace("SQUARELEFT", "[", $str);
    $str = str_replace("SQUARERIGHT", "]", $str);
    $str = str_replace("TSCORE", "\\", $str);
    $pass = str_split(str_pad('', strlen($str), ENC_PASSWORD, STR_PAD_RIGHT));
    $stra = str_split($str);
    foreach ($stra as $k => $v) {
        $tmp = ord($v) - ord($pass[$k]);
        $stra[$k] = chr($tmp < 0 ? ($tmp + 256) : $tmp);
    }
    return join('', $stra);
}

// function encrypt_($pure_string)
// {
//     $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
//     $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
//     $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, ENC_PASSWORD, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
//     return $encrypted_string;
// }

function mysql_date($date = false)
{
    $date = ($date) ? $date : date('Y-m-d H:i:s');
    return date("Y-m-d H:i:s", strtotime($date));
}

function clean($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

function send_sms($mobileNumber, $message)
{
    // $curl = curl_init();

    // curl_setopt_array($curl, array(
    // CURLOPT_URL => 'https://api.interakt.ai/v1/public/message/',
    // CURLOPT_RETURNTRANSFER => true,
    // CURLOPT_ENCODING => '',
    // CURLOPT_MAXREDIRS => 10,
    // CURLOPT_TIMEOUT => 0,
    // CURLOPT_FOLLOWLOCATION => true,
    // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    // CURLOPT_CUSTOMREQUEST => 'POST',
    // CURLOPT_POSTFIELDS =>'{
    //     "countryCode": "91", 
    //     "phoneNumber": '.$mobileNumber.', 
    //     "type": "Template", 
    //     "template": {
    //         "name": "delivered_alert_101", 
    //         "languageCode": "en", 
    //         "headerValues": [
    //             "Alert" 
    //         ],
    //         "bodyValues": [
    //             "There", 
    //             "1234" 
    //         ],
    //         "buttonValues": {
    //             "0" : [
    //                 "12344" 
    //             ]
    //         }
    //     }
    // }',
    // CURLOPT_HTTPHEADER => array(
    //     'Authorization: Basic 23456',
    //     'content-type: application/json'
    // ),
    // ));

    // $response = curl_exec($curl);

    // curl_close($curl);
    // echo $response->result;

    return true;
}

function send_wp_msg($mobileNumber, $data)
{
    $curl = curl_init();

    $Template = json_encode($data);
    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.interakt.ai/v1/public/message/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "countryCode": "91", 
        "phoneNumber": '.$mobileNumber.', 
        "type": "Template", 
        "template": '.$Template.'
    }',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Basic SmppTjFrZWRLbW5KUzhDT2loVWloMHpnaEsyUVI2YjVQYlRSc0FTX19sRTo=',
        'content-type: application/json'
    ),
    ));

    $response = json_decode(curl_exec($curl));

    curl_close($curl);
    return $response->result;
    // return true;
}

function capital($string)
{
    return ucwords(strtolower($string));
}



function slugify($text, string $divider = '-')
{
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, $divider);

    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function getFileSize($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    $data = curl_exec($ch);
    $fileSize = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    $httpResponseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $fileSize;
}


function does_url_exists($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($code == 200) {
        $status = true;
    } else {
        $status = false;
    }
    curl_close($ch);
    return $status;
}


/*
* @param1 : Plain String
* @param2 : Working key provided by CCAvenue
* @return : Decrypted String
*/
function cca_encrypt($plainText,$key)
{
	$key = cca_hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	$encryptedText = bin2hex($openMode);
	return $encryptedText;
}

/*
* @param1 : Encrypted String
* @param2 : Working key provided by CCAvenue
* @return : Plain String
*/
function cca_decrypt($encryptedText,$key)
{
	$key = cca_hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$encryptedText = cca_hextobin($encryptedText);
	$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	return $decryptedText;
}

function cca_hextobin($hexString) 
 { 
	$length = strlen($hexString); 
	$binString="";   
	$count=0; 
	while($count<$length) 
	{       
	    $subString =substr($hexString,$count,2);           
	    $packedString = pack("H*",$subString); 
	    if ($count==0)
	    {
			$binString=$packedString;
	    } 
	    
	    else 
	    {
			$binString.=$packedString;
	    } 
	    
	    $count+=2; 
	} 
        return $binString; 
  } 
