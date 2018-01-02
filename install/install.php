<?php

$writestr = "<?php\n
\n
//////////////////////////////////////////////////////////\n
// VESTA WEB INTERFACE CONFIGURATION - EDIT VALUES HERE //\n
//////////////////////////////////////////////////////////\n
\n
// CPANEL SETTINGS //\n
date_default_timezone_set('$_POST['']'); // Server Time Zone - See http://php.net/manual/en/timezones.php for syntax.\n
DEFINE('SITE_NAME', '$_POST['']'); // Site name for use in page titles. Ex: 'My Host Company'.\n
DEFINE('THEME', '$_POST['']'); // Accepted options are 'default', 'blue', 'purple' and 'orange'\n
\n
// VESTA API SETTINGS //\n
DEFINE('VESTA_HOST_ADDRESS', '$_POST['']'); // URL or IP Address of VestaCP. Ex: 'myhost.com' or '12.34.56.78'.\n
DEFINE('VESTA_SSL_ENABLED', '$_POST['']'); // If ssl is enabled on VestaCP - Ex: 'true' or 'false'.\n
DEFINE('VESTA_PORT', '$_POST['']'); // VestaCP port. Ex: '8083'.\n
DEFINE('VESTA_ADMIN_UNAME', '$_POST['']'); // Username of VestaCP Admin account. Ex: 'admin'.\n
DEFINE('VESTA_ADMIN_PW', '$_POST['']'); // Password for VestaCP Admin account. Ex: 'MyPassword1'.\n
\n
// OPTIONAL SETTINGS //\n
DEFINE('FTP_URL', '$_POST['']'); // URL for Web FTP. Leave blank if you do not have a Web FTP Interface. Set as 'disabled' to remove the Web FTP option.\n
DEFINE('WEBMAIL_URL', '$_POST['']'); // Webmail URL. Leave blank for VestaCP default. Set as 'disabled' to remove the webmail option.\n
DEFINE('PHPMYADMIN_URL', '$_POST['']'); // phpMyAdmin URL. Leave blank for VestaCP default. Set as 'disabled; to remove phpMyAdmin option.\n
DEFINE('PHPPGADMIN_URL', '$_POST['']'); // phpPgAdmin URL. Leave blank for VestaCP default. Set as 'disabled; to remove phpPgAdmin option.\n
DEFINE('SUPPORT_URL', '$_POST['']'); // Support URL. Leave blank or set to 'disabled' to disable.\n
\n
// ENABLE OR DISABLE SECTIONS //\n
DEFINE('WEB_ENABLED', '$webenabled'); // Enable or disable web section. Ex: 'true' or 'false'.\n
DEFINE('DNS_ENABLED', '$dnsenabled); // Enable or disable dns section. Ex: 'true' or 'false'.\n
DEFINE('MAIL_ENABLED', '$dnsenabled); // Enable or disable mail section. Ex: 'true' or 'false'.\n
DEFINE('DB_ENABLED', '$dbenabled); // Enable or disable database section. Ex: 'true' or 'false'.\n
DEFINE('OLD_CP_LINK', '$oldcplink); // Enable or disable link to old cpanel. Ex: 'true' or 'false'.\n
\n
// INTEGRATIONS //\n
DEFINE('GOOGLE_ANALYTICS_ID', '$_POST['']'); // Enable Google Analytics Tracking. Enter Tracking ID.\n
DEFINE('INTERAKT_APP_ID', '$_POST['']'); // Enable Interakt Support / Tools. Enter Interakt App ID.\n
DEFINE('INTERAKT_API_KEY', '$_POST['']'); // Enable Interakt User Management. Interakt Account number must be set first. Enter Interakt API Key.\n
\n
///////////////////////////////////////////////////////////////////////\n
// DO NOT EDIT BELOW THIS LINE - CONVERTING AND PROCESSING CONSTANTS //\n
///////////////////////////////////////////////////////////////////////\n
\n
if(VESTA_SSL_ENABLED == 'false'){\n
 \$vst_ssl = 'http://';\n
}\n
else{\n
 \$vst_ssl = 'https://';\n
}\n
\n
if(VESTA_PORT == ''){\n
 \$vesta_port = '8083';\n
}\n
else{\n
 \$vesta_port = VESTA_PORT;\n
}\n
\n
if(FTP_URL == ''){\n
 \$ftpurl = 'http://net2ftp.com/';\n
}\n
elseif(FTP_URL == 'disabled'){\n
 \$ftpurl = '';\n
}\n
else{\n
 \$ftpurl = FTP_URL;\n
}\n
\n
if(WEB_ENABLED != 'true'){\n
 \$webenabled = '';\n
}\n
else{\n
 \$webenabled = WEB_ENABLED;\n
}\n
if(DNS_ENABLED != 'true'){\n
 \$dnsenabled = '';\n
}\n
else{\n
 \$dnsenabled = DNS_ENABLED;\n
}\n
if(MAIL_ENABLED != 'true'){\n
 \$mailenabled = '';\n
}\n
else{\n
 \$mailenabled = MAIL_ENABLED;\n
}\n
if(DB_ENABLED != 'true'){\n
 \$dbenabled = '';\n
}\n
else{\n
 \$dbenabled = DB_ENABLED;\n
}\n
\n
\$vst_url = \$vst_ssl . VESTA_HOST_ADDRESS . ':' . \$vesta_port . '/api/';\n
\$url8083 = \$vst_ssl . VESTA_HOST_ADDRESS . ':' . \$vesta_port;\n
\$vst_username = VESTA_ADMIN_UNAME;\n
\$vst_password = VESTA_ADMIN_PW;\n
\$themecolor = THEME . '.css';\n
\$uname = base64_decode(\$_COOKIE['username']);\n
\$loggedin = base64_decode(\$_COOKIE['loggedin']);\n
\$username = \$uname;\n
\$sitetitle = SITE_NAME;\n
\n
if(WEBMAIL_URL == ''){\n
 \$webmailurl = \$vst_ssl . VESTA_HOST_ADDRESS . '/webmail';\n
}\n
elseif(WEBMAIL_URL == 'disabled'){\n
 \$webmailurl = '';\n
}\n
else{\n
 \$webmailurl = WEBMAIL_URL;\n
}\n
\n
if(PHPMYADMIN_URL == ''){\n
 \$phpmyadmin = \$vst_ssl . VESTA_HOST_ADDRESS . '/phpmyadmin';\n
}\n
elseif(PHPMYADMIN_URL == 'disabled'){\n
 \$phpmyadmin = '';\n
}\n
else{\n
 \$phpmyadmin = PHPMYADMIN_URL;\n
}\n
\n
if(PHPPGADMIN_URL == ''){\n
 \$phppgadmin = \$vst_ssl . VESTA_HOST_ADDRESS . '/phppgadmin';\n
}\n
elseif(PHPPGADMIN_URL == 'disabled'){\n
 \$phppgadmin = '';\n
}\n
else{\n
 \$phppgadmin = PHPPGADMIN_URL;\n
}\n
\n
if(SUPPORT_URL == ''){\n
 \$supporturl = '';\n
}\n
elseif(SUPPORT_URL == 'disabled'){\n
 \$supporturl = '';\n
}\n
else{\n
 \$supporturl = SUPPORT_URL;\n
}\n
\n
if(OLD_CP_LINK == 'false'){\n
 \$oldcpurl = '';\n
}\n
else{\n
 \$oldcpurl = \$url8083;\n
}\n
\n
include 'functions.php'\n
?>"

file_put_contents('../includes/config.php', $writestr);
?>

<meta http-equiv="refresh" content=".1; url=../test.php">