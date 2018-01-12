***REMOVED***
if ($_POST['x'] != '1') { if (file_exists( '../includes/config.php' )) { header( 'Location: ../index.php' );***REMOVED***; ***REMOVED***

if($_POST['VESTA_SSL_ENABLED'] == 'on'){ $sslenabled = 'true'; ***REMOVED***
else { $sslenabled = 'false'; ***REMOVED***
if($_POST['ENABLE_WEB'] == 'on'){ $webenabled = 'true'; ***REMOVED***
else { $webenabled = 'false'; ***REMOVED***
if($_POST['ENABLE_DNS'] == 'on'){ $dnsenabled = 'true'; ***REMOVED***
else { $dnsenabled = 'false'; ***REMOVED***
if($_POST['ENABLE_MAIL'] == 'on'){ $mailenabled = 'true'; ***REMOVED***
else { $mailenabled = 'false'; ***REMOVED***
if($_POST['ENABLE_DB'] == 'on'){ $dbenabled = 'true'; ***REMOVED***
else { $dbenabled = 'false'; ***REMOVED***
if($_POST['ENABLE_OLDCPURL'] == 'on'){ $oldcplink = 'true'; ***REMOVED***
else { $oldcplink = 'false'; ***REMOVED***

$writestr = "***REMOVED***

***REMOVED***
***REMOVED***
***REMOVED***

***REMOVED***
date_default_timezone_set('".$_POST['TIMEZONE']."'); // Server Time Zone - See http://php.net/manual/en/timezones.php for syntax.
DEFINE('SITE_NAME', '".$_POST['SITENAME']."'); // Site name for use in page titles. Ex: 'My Host Company'.
DEFINE('THEME', '".$_POST['THEME']."'); // Accepted options are 'default', 'blue', 'purple' and 'orange'

***REMOVED***
DEFINE('VESTA_HOST_ADDRESS', '".$_POST['VESTA_HOST_ADDRESS']."'); // URL or IP Address of VestaCP. Ex: 'myhost.com' or '12.34.56.78'.
DEFINE('VESTA_SSL_ENABLED', '".$sslenabled."'); // If ssl is enabled on VestaCP - Ex: 'true' or 'false'.
DEFINE('VESTA_PORT', '".$_POST['VESTA_PORT']."'); // VestaCP port. Ex: '8083'.
DEFINE('VESTA_ADMIN_UNAME', '".$_POST['VESTA_ADMIN_UNAME']."'); // Username of VestaCP Admin account. Ex: 'admin'.
DEFINE('VESTA_ADMIN_PW', '".$_POST['VESTA_ADMIN_PW']."'); // Password for VestaCP Admin account. Ex: 'MyPassword1'.

***REMOVED***
DEFINE('FTP_URL', '".$_POST['FTP_URL']."'); // URL for Web FTP. Leave blank if you do not have a Web FTP Interface. Set as 'disabled' to remove the Web FTP option.
DEFINE('WEBMAIL_URL', '".$_POST['WEBMAIL_URL']."'); // Webmail URL. Leave blank for VestaCP default. Set as 'disabled' to remove the webmail option.
DEFINE('PHPMYADMIN_URL', '".$_POST['PHPMYADMIN_URL']."'); // phpMyAdmin URL. Leave blank for VestaCP default. Set as 'disabled; to remove phpMyAdmin option.
DEFINE('PHPPGADMIN_URL', '".$_POST['PHPPGADMIN_URL']."'); // phpPgAdmin URL. Leave blank for VestaCP default. Set as 'disabled; to remove phpPgAdmin option.
DEFINE('SUPPORT_URL', '".$_POST['SUPPORT_URL']."'); // Support URL. Leave blank or set to 'disabled' to disable.

***REMOVED***
DEFINE('WEB_ENABLED', '".$webenabled."'); // Enable or disable web section. Ex: 'true' or 'false'.
DEFINE('DNS_ENABLED', '".$dnsenabled."'); // Enable or disable dns section. Ex: 'true' or 'false'.
DEFINE('MAIL_ENABLED', '".$mailenabled."'); // Enable or disable mail section. Ex: 'true' or 'false'.
DEFINE('DB_ENABLED', '".$dbenabled."'); // Enable or disable database section. Ex: 'true' or 'false'.
DEFINE('OLD_CP_LINK', '".$oldcplink."'); // Enable or disable link to old cpanel. Ex: 'true' or 'false'.

***REMOVED***
DEFINE('GOOGLE_ANALYTICS_ID', '".$_POST['GOOGLE_ANALYTICS_ID']."'); // Enable Google Analytics Tracking. Enter Tracking ID.
DEFINE('INTERAKT_APP_ID', '".$_POST['INTERAKT_APP_ID']."'); // Enable Interakt Support / Tools. Enter Interakt App ID.
DEFINE('INTERAKT_API_KEY', '".$_POST['INTERAKT_API_KEY']."'); // Enable Interakt User Management. Interakt Account number must be set first. Enter Interakt API Key.

***REMOVED***/////////////
***REMOVED***
***REMOVED***/////////////

***REMOVED***
 \$vst_ssl = 'http://';
***REMOVED***
***REMOVED***
 \$vst_ssl = 'https://';
***REMOVED***

***REMOVED***
 \$vesta_port = '8083';
***REMOVED***
***REMOVED***
 \$vesta_port = VESTA_PORT;
***REMOVED***

***REMOVED***
 \$ftpurl = 'http://net2ftp.com/';
***REMOVED***
***REMOVED***
 \$ftpurl = '';
***REMOVED***
***REMOVED***
 \$ftpurl = FTP_URL;
***REMOVED***

***REMOVED***
 \$webenabled = '';
***REMOVED***
***REMOVED***
 \$webenabled = WEB_ENABLED;
***REMOVED***
***REMOVED***
 \$dnsenabled = '';
***REMOVED***
***REMOVED***
 \$dnsenabled = DNS_ENABLED;
***REMOVED***
***REMOVED***
 \$mailenabled = '';
***REMOVED***
***REMOVED***
 \$mailenabled = MAIL_ENABLED;
***REMOVED***
***REMOVED***
 \$dbenabled = '';
***REMOVED***
***REMOVED***
 \$dbenabled = DB_ENABLED;
***REMOVED***

\$vst_url = \$vst_ssl . VESTA_HOST_ADDRESS . ':' . \$vesta_port . '/api/';
\$url8083 = \$vst_ssl . VESTA_HOST_ADDRESS . ':' . \$vesta_port;
\***REMOVED***
\***REMOVED***
\***REMOVED***
\$uname = base64_decode(\$_SESSION['username']);
\$loggedin = base64_decode(\$_SESSION['loggedin']);
\***REMOVED***
\$username = \$uname;
\***REMOVED***

***REMOVED***
 \$webmailurl = \$vst_ssl . VESTA_HOST_ADDRESS . '/webmail';
***REMOVED***
***REMOVED***
 \$webmailurl = '';
***REMOVED***
***REMOVED***
 \$webmailurl = WEBMAIL_URL;
***REMOVED***

***REMOVED***
 \$phpmyadmin = \$vst_ssl . VESTA_HOST_ADDRESS . '/phpmyadmin';
***REMOVED***
***REMOVED***
 \$phpmyadmin = '';
***REMOVED***
***REMOVED***
 \$phpmyadmin = PHPMYADMIN_URL;
***REMOVED***

***REMOVED***
 \$phppgadmin = \$vst_ssl . VESTA_HOST_ADDRESS . '/phppgadmin';
***REMOVED***
***REMOVED***
 \$phppgadmin = '';
***REMOVED***
***REMOVED***
 \$phppgadmin = PHPPGADMIN_URL;
***REMOVED***

***REMOVED***
 \$supporturl = '';
***REMOVED***
***REMOVED***
 \$supporturl = '';
***REMOVED***
***REMOVED***
 \$supporturl = SUPPORT_URL;
***REMOVED***

***REMOVED***
 \$oldcpurl = '';
***REMOVED***
***REMOVED***
 \$oldcpurl = \$url8083;
***REMOVED***
***REMOVED***

***REMOVED***";

file_put_contents('../includes/config.php', $writestr);
header("Location: https://cdgtech.one/install.php?url=" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI] . '&name=' . $_POST['SITENAME']);
***REMOVED***