<?php
date_default_timezone_set('Asia/Kolkata');
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    define("HOSTNAME", 'localhost');
    define("USERNAME", "root");
    define("PASSWORD", "");
    define("DATABASE", "igli_financial");
    $BASE_URL = 'http://' . $_SERVER['HTTP_HOST'] . '/igli-financial/';
} else if ($_SERVER['HTTP_HOST'] == 'iglifinancial.online') {
    define("HOSTNAME", "localhost");
    define("USERNAME", "u420404249_igli");
    define("PASSWORD", "Igli_financial_01");
    define("DATABASE", "u420404249_igli");
    $BASE_URL = 'https://' . $_SERVER['HTTP_HOST'] . '/';
}

define("WEBSITE", "IGLI Financial");
define("WEBSITE_NAME", "IGLI Financial");
define("WEBSITE_URL", "https://iglifinancial.com/");
define("WEBSITE_EMAIL", "info@iglifinancial.com");
define("SUPPORT_EMAIL", "info@iglifinancial.com");
define('BASE_URL', $BASE_URL);
define('ROOT_URL', BASE_URL);
define('ASSETS_PATH', BASE_URL . 'assets/');
define('DEFAULT_AVATAR', ASSETS_PATH . 'images/profile_av.jpg');
define("NO_IMAGE", ASSETS_PATH . "images/no_image.jpg");
define("NO_PROFILE", ASSETS_PATH . "images/noprofile.png");
define("NOT_FOUND", ASSETS_PATH . "images/data_not_found.png");
define("ENC_USERNAME", "IGLIFinancial");
define("ENC_PASSWORD", "!@#$%");
define("IVSEED", "!!!");
define('SITE_LOGO', ASSETS_PATH . 'images/logo.png');
define('EXT', '.php');
define('MAIL_LOGO_PATH', '');
define('BASE_TITLE', WEBSITE_NAME . ' - ');
define('FAVICON', ASSETS_PATH . 'images/favicon.png');
define('FAVICON_64', ASSETS_PATH . 'images/favicon.ico');
define('UNKNOWN_ERROR', 'Please Try Again.');
define('LOGIN_ERROR', 'Your session expired, Please restart aplication.');
define('UNKNOWN_WEB_ERROR', 'There was an unknown error that occurred. You will need to refresh the page to continue working.');

/** Upload */

define('UPLOAD_DIR', 'uploads/');
define('BANNER_IMG', 'banner/');
define('SERVICE_LOGO', 'service-logo/');
define('USER_PROFILE', 'user-profile/');
define('DOCUMENT', 'document/');
define("IMAGE_DIR", BASE_URL.UPLOAD_DIR);

define('PROTOCOL', 'smtp');
define('SMTP_HOST', "ssl://smtp.googlemail.com");
define('SMTP_PORT', "465");
define('SMTP_USER', "welcome.iglifinancial@gmail.com");
define('SMTP_PASS', "pvkzplieuxsufvob");
// define('SMTP_USER', "info.iglifinancial@gmail.com");
// define('SMTP_PASS', "rpwhocxqzqiptpsc");

define('SMSAUTHKEY', "69866AT3vL0g3m358ef28ef");

define('STATUS_TRUE', 200);
define('STATUS_FALSE', 400);
define('STATUS_LOGIN', 401);


define('HEADER_DETAILS', '<li class="text-primary"><b>Authorization</b> :Basic Q0hJTERSRU5TLUFDQURFTVktQVBJOkFQSUBDSElMRFJFTlMxMjM= (username : IGLIF-API , Password : API@CHILDRENS123</li><li class="text-primary"><b>X-CI-IGLIF-API-KEY</b> : kkcoswggwgwkkc8w4ok808o48kswc40c0www4wss</li><li class="text-primary"><b>X-CI-IGLIF-LOGIN-TOKEN</b> : login after get</li><li class="text-primary">User-Id : login after get</li>');

define('API_HEADER_DETAILS', '<li class="text-primary"><b>Authorization</b> :Basic Q0hJTERSRU5TLUFDQURFTVktQVBJOkFQSUBDSElMRFJFTlMxMjM= (username : IGLIF-API , Password : API@CHILDRENS123</li><li class="text-primary"><b>X-CI-IGLIF-API-KEY</b> : kkcoswggwgwkkc8w4ok808o48kswc40c0www4wss</li>');