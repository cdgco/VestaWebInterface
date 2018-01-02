***REMOVED***

$writestr = "***REMOVED***\n
\n
***REMOVED***\n
***REMOVED***\n
***REMOVED***\n
\n
***REMOVED***\n
date_default_timezone_set('$_POST['']'); // Server Time Zone - See http://php.net/manual/en/timezones.php for syntax.\n
DEFINE('SITE_NAME', '$_POST['']'); // Site name for use in page titles. Ex: 'My Host Company'.\n
DEFINE('THEME', '$_POST['']'); // Accepted options are 'default', 'blue', 'purple' and 'orange'\n
\n
***REMOVED***\n
DEFINE('VESTA_HOST_ADDRESS', '$_POST['']'); // URL or IP Address of VestaCP. Ex: 'myhost.com' or '12.34.56.78'.\n
DEFINE('VESTA_SSL_ENABLED', '$_POST['']'); // If ssl is enabled on VestaCP - Ex: 'true' or 'false'.\n
DEFINE('VESTA_PORT', '$_POST['']'); // VestaCP port. Ex: '8083'.\n
DEFINE('VESTA_ADMIN_UNAME', '$_POST['']'); // Username of VestaCP Admin account. Ex: 'admin'.\n
DEFINE('VESTA_ADMIN_PW', '$_POST['']'); // Password for VestaCP Admin account. Ex: 'MyPassword1'.\n
\n
***REMOVED***\n
DEFINE('FTP_URL', '$_POST['']'); // URL for Web FTP. Leave blank if you do not have a Web FTP Interface. Set as 'disabled' to remove the Web FTP option.\n
DEFINE('WEBMAIL_URL', '$_POST['']'); // Webmail URL. Leave blank for VestaCP default. Set as 'disabled' to remove the webmail option.\n
DEFINE('PHPMYADMIN_URL', '$_POST['']'); // phpMyAdmin URL. Leave blank for VestaCP default. Set as 'disabled; to remove phpMyAdmin option.\n
DEFINE('PHPPGADMIN_URL', '$_POST['']'); // phpPgAdmin URL. Leave blank for VestaCP default. Set as 'disabled; to remove phpPgAdmin option.\n
DEFINE('SUPPORT_URL', '$_POST['']'); // Support URL. Leave blank or set to 'disabled' to disable.\n
\n
***REMOVED***\n
DEFINE('WEB_ENABLED', '$webenabled'); // Enable or disable web section. Ex: 'true' or 'false'.\n
DEFINE('DNS_ENABLED', '$dnsenabled); // Enable or disable dns section. Ex: 'true' or 'false'.\n
DEFINE('MAIL_ENABLED', '$dnsenabled); // Enable or disable mail section. Ex: 'true' or 'false'.\n
DEFINE('DB_ENABLED', '$dbenabled); // Enable or disable database section. Ex: 'true' or 'false'.\n
DEFINE('OLD_CP_LINK', '$oldcplink); // Enable or disable link to old cpanel. Ex: 'true' or 'false'.\n
\n
***REMOVED***\n
DEFINE('GOOGLE_ANALYTICS_ID', '$_POST['']'); // Enable Google Analytics Tracking. Enter Tracking ID.\n
DEFINE('INTERAKT_APP_ID', '$_POST['']'); // Enable Interakt Support / Tools. Enter Interakt App ID.\n
DEFINE('INTERAKT_API_KEY', '$_POST['']'); // Enable Interakt User Management. Interakt Account number must be set first. Enter Interakt API Key.\n
\n
***REMOVED***/////////////\n
***REMOVED***\n
***REMOVED***/////////////\n
\n
***REMOVED***\n
 \$vst_ssl = 'http://';\n
***REMOVED***\n
***REMOVED***\n
 \$vst_ssl = 'https://';\n
***REMOVED***\n
\n
***REMOVED***\n
 \$vesta_port = '8083';\n
***REMOVED***\n
***REMOVED***\n
 \$vesta_port = VESTA_PORT;\n
***REMOVED***\n
\n
***REMOVED***\n
 \$ftpurl = 'http://net2ftp.com/';\n
***REMOVED***\n
***REMOVED***\n
 \$ftpurl = '';\n
***REMOVED***\n
***REMOVED***\n
 \$ftpurl = FTP_URL;\n
***REMOVED***\n
\n
***REMOVED***\n
 \$webenabled = '';\n
***REMOVED***\n
***REMOVED***\n
 \$webenabled = WEB_ENABLED;\n
***REMOVED***\n
***REMOVED***\n
 \$dnsenabled = '';\n
***REMOVED***\n
***REMOVED***\n
 \$dnsenabled = DNS_ENABLED;\n
***REMOVED***\n
***REMOVED***\n
 \$mailenabled = '';\n
***REMOVED***\n
***REMOVED***\n
 \$mailenabled = MAIL_ENABLED;\n
***REMOVED***\n
***REMOVED***\n
 \$dbenabled = '';\n
***REMOVED***\n
***REMOVED***\n
 \$dbenabled = DB_ENABLED;\n
***REMOVED***\n
\n
\$vst_url = \$vst_ssl . VESTA_HOST_ADDRESS . ':' . \$vesta_port . '/api/';\n
\$url8083 = \$vst_ssl . VESTA_HOST_ADDRESS . ':' . \$vesta_port;\n
\***REMOVED***\n
\***REMOVED***\n
\***REMOVED***\n
\$uname = base64_decode(\$_COOKIE['username']);\n
\$loggedin = base64_decode(\$_COOKIE['loggedin']);\n
\$username = \$uname;\n
\***REMOVED***\n
\n
***REMOVED***\n
 \$webmailurl = \$vst_ssl . VESTA_HOST_ADDRESS . '/webmail';\n
***REMOVED***\n
***REMOVED***\n
 \$webmailurl = '';\n
***REMOVED***\n
***REMOVED***\n
 \$webmailurl = WEBMAIL_URL;\n
***REMOVED***\n
\n
***REMOVED***\n
 \$phpmyadmin = \$vst_ssl . VESTA_HOST_ADDRESS . '/phpmyadmin';\n
***REMOVED***\n
***REMOVED***\n
 \$phpmyadmin = '';\n
***REMOVED***\n
***REMOVED***\n
 \$phpmyadmin = PHPMYADMIN_URL;\n
***REMOVED***\n
\n
***REMOVED***\n
 \$phppgadmin = \$vst_ssl . VESTA_HOST_ADDRESS . '/phppgadmin';\n
***REMOVED***\n
***REMOVED***\n
 \$phppgadmin = '';\n
***REMOVED***\n
***REMOVED***\n
 \$phppgadmin = PHPPGADMIN_URL;\n
***REMOVED***\n
\n
***REMOVED***\n
 \$supporturl = '';\n
***REMOVED***\n
***REMOVED***\n
 \$supporturl = '';\n
***REMOVED***\n
***REMOVED***\n
 \$supporturl = SUPPORT_URL;\n
***REMOVED***\n
\n
***REMOVED***\n
 \$oldcpurl = '';\n
***REMOVED***\n
***REMOVED***\n
 \$oldcpurl = \$url8083;\n
***REMOVED***\n
\n
include 'functions.php'\n
***REMOVED***"

file_put_contents('../includes/config.php', $writestr);
***REMOVED***

<meta http-equiv="refresh" content=".1; url=../test.php">