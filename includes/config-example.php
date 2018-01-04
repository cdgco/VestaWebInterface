
<?php

//////////////////////////////////////////////////////////
// VESTA WEB INTERFACE CONFIGURATION - EDIT VALUES HERE //
//////////////////////////////////////////////////////////

// CPANEL SETTINGS //
date_default_timezone_set('America/Los_Angeles'); // Server Time Zone - See http://php.net/manual/en/timezones.php for syntax.
DEFINE('SITE_NAME', 'My Host'); // Site name for use in page titles. Ex: 'My Host Company'.
DEFINE('THEME', 'default'); // Accepted options are 'default', 'blue', 'purple' and 'orange'

// VESTA API SETTINGS //
DEFINE('VESTA_HOST_ADDRESS', ''); // URL or IP Address of VestaCP. Ex: 'myhost.com' or '12.34.56.78'.
DEFINE('VESTA_SSL_ENABLED', 'true'); // If ssl is enabled on VestaCP - Ex: 'true' or 'false'.
DEFINE('VESTA_PORT', '8083'); // VestaCP port. Ex: '8083'.
DEFINE('VESTA_ADMIN_UNAME', 'admin'); // Username of VestaCP Admin account. Ex: 'admin'.
DEFINE('VESTA_ADMIN_PW', ''); // Password for VestaCP Admin account. Ex: 'MyPassword1'.

// OPTIONAL SETTINGS //
DEFINE('FTP_URL', ''); // URL for Web FTP. Leave blank if you do not have a Web FTP Interface. Set as 'disabled' to remove the Web FTP option.
DEFINE('WEBMAIL_URL', ''); // Webmail URL. Leave blank for VestaCP default. Set as 'disabled' to remove the webmail option.
DEFINE('PHPMYADMIN_URL', ''); // phpMyAdmin URL. Leave blank for VestaCP default. Set as 'disabled; to remove phpMyAdmin option.
DEFINE('PHPPGADMIN_URL', 'disabled'); // phpPgAdmin URL. Leave blank for VestaCP default. Set as 'disabled; to remove phpPgAdmin option.
DEFINE('SUPPORT_URL', 'disabled'); // Support URL. Leave blank or set to 'disabled' to disable.

// ENABLE OR DISABLE SECTIONS //
DEFINE('WEB_ENABLED', 'true'); // Enable or disable web section. Ex: 'true' or 'false'.
DEFINE('DNS_ENABLED', 'true'); // Enable or disable dns section. Ex: 'true' or 'false'.
DEFINE('MAIL_ENABLED', 'true'); // Enable or disable mail section. Ex: 'true' or 'false'.
DEFINE('DB_ENABLED', 'true'); // Enable or disable database section. Ex: 'true' or 'false'.
DEFINE('OLD_CP_LINK', 'true'); // Enable or disable link to old cpanel. Ex: 'true' or 'false'.

// INTEGRATIONS //
DEFINE('GOOGLE_ANALYTICS_ID', ''); // Enable Google Analytics Tracking. Enter Tracking ID.
DEFINE('INTERAKT_APP_ID', ''); // Enable Interakt Support / Tools. Enter Interakt App ID.
DEFINE('INTERAKT_API_KEY', ''); // Enable Interakt User Management. Interakt Account number must be set first. Enter Interakt API Key.

///////////////////////////////////////////////////////////////////////
// DO NOT EDIT BELOW THIS LINE - CONVERTING AND PROCESSING CONSTANTS //
///////////////////////////////////////////////////////////////////////

if(VESTA_SSL_ENABLED == 'false'){
    $vst_ssl = 'http://';
}
else{
    $vst_ssl = 'https://';
}

if(VESTA_PORT == ''){
    $vesta_port = '8083';
}
else{
    $vesta_port = VESTA_PORT;
}

if(FTP_URL == ''){
    $ftpurl = 'http://net2ftp.com/';
}
elseif(FTP_URL == 'disabled'){
    $ftpurl = '';
}
else{
    $ftpurl = FTP_URL;
}

if(WEB_ENABLED != 'true'){
    $webenabled = '';
}
else{
    $webenabled = WEB_ENABLED;
}
if(DNS_ENABLED != 'true'){
    $dnsenabled = '';
}
else{
    $dnsenabled = DNS_ENABLED;
}
if(MAIL_ENABLED != 'true'){
    $mailenabled = '';
}
else{
    $mailenabled = MAIL_ENABLED;
}
if(DB_ENABLED != 'true'){
    $dbenabled = '';
}
else{
    $dbenabled = DB_ENABLED;
}

$vst_url = $vst_ssl . VESTA_HOST_ADDRESS . ':' . $vesta_port . '/api/';
$url8083 = $vst_ssl . VESTA_HOST_ADDRESS . ':' . $vesta_port;
$vst_username = VESTA_ADMIN_UNAME;
$vst_password = VESTA_ADMIN_PW;
$themecolor = THEME . '.css';
$uname = base64_decode($_COOKIE['username']);
$loggedin = base64_decode($_COOKIE['loggedin']);
$username = $uname;
$sitetitle = SITE_NAME;

if(WEBMAIL_URL == ''){
    $webmailurl = $vst_ssl . VESTA_HOST_ADDRESS . '/webmail';
}
elseif(WEBMAIL_URL == 'disabled'){
    $webmailurl = '';
}
else{
    $webmailurl = WEBMAIL_URL;
}

if(PHPMYADMIN_URL == ''){
    $phpmyadmin = $vst_ssl . VESTA_HOST_ADDRESS . '/phpmyadmin';
}
elseif(PHPMYADMIN_URL == 'disabled'){
    $phpmyadmin = '';
}
else{
    $phpmyadmin = PHPMYADMIN_URL;
}

if(PHPPGADMIN_URL == ''){
    $phppgadmin = $vst_ssl . VESTA_HOST_ADDRESS . '/phppgadmin';
}
elseif(PHPPGADMIN_URL == 'disabled'){
    $phppgadmin = '';
}
else{
    $phppgadmin = PHPPGADMIN_URL;
}

if(SUPPORT_URL == ''){
    $supporturl = '';
}
elseif(SUPPORT_URL == 'disabled'){
    $supporturl = '';
}
else{
    $supporturl = SUPPORT_URL;
}

if(OLD_CP_LINK == 'false'){
    $oldcpurl = '';
}
else{
    $oldcpurl = $url8083;
}

?>
