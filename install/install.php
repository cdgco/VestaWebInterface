<?php
if ($_POST['x'] != '1') { if (file_exists( '../includes/config.php' )) { header( 'Location: ../index.php' );}; }

if($_POST['VESTA_SSL_ENABLED'] == 'on'){ $sslenabled = 'true'; }
else { $sslenabled = 'false'; }
if($_POST['ENABLE_WEB'] == 'on'){ $webenabled = 'true'; }
else { $webenabled = 'false'; }
if($_POST['ENABLE_DNS'] == 'on'){ $dnsenabled = 'true'; }
else { $dnsenabled = 'false'; }
if($_POST['ENABLE_MAIL'] == 'on'){ $mailenabled = 'true'; }
else { $mailenabled = 'false'; }
if($_POST['ENABLE_DB'] == 'on'){ $dbenabled = 'true'; }
else { $dbenabled = 'false'; }
if($_POST['ENABLE_OLDCPURL'] == 'on'){ $oldcplink = 'true'; }
else { $oldcplink = 'false'; }

$writestr = "<?php

//////////////////////////////////////////////////////////
// VESTA WEB INTERFACE CONFIGURATION - EDIT VALUES HERE //
//////////////////////////////////////////////////////////

// CPANEL SETTINGS //
date_default_timezone_set('".$_POST['TIMEZONE']."'); // Server Time Zone - See http://php.net/manual/en/timezones.php for syntax.
DEFINE('SITE_NAME', '".$_POST['SITENAME']."'); // Site name for use in page titles. Ex: 'My Host Company'.
DEFINE('THEME', '".$_POST['THEME']."'); // Accepted options are 'default', 'blue', 'purple' and 'orange'

// VESTA API SETTINGS //
DEFINE('VESTA_HOST_ADDRESS', '".$_POST['VESTA_HOST_ADDRESS']."'); // URL or IP Address of VestaCP. Ex: 'myhost.com' or '12.34.56.78'.
DEFINE('VESTA_SSL_ENABLED', '".$sslenabled."'); // If ssl is enabled on VestaCP - Ex: 'true' or 'false'.
DEFINE('VESTA_PORT', '".$_POST['VESTA_PORT']."'); // VestaCP port. Ex: '8083'.
DEFINE('VESTA_ADMIN_UNAME', '".$_POST['VESTA_ADMIN_UNAME']."'); // Username of VestaCP Admin account. Ex: 'admin'.
DEFINE('VESTA_ADMIN_PW', '".$_POST['VESTA_ADMIN_PW']."'); // Password for VestaCP Admin account. Ex: 'MyPassword1'.

// OPTIONAL SETTINGS //
DEFINE('FTP_URL', '".$_POST['FTP_URL']."'); // URL for Web FTP. Leave blank if you do not have a Web FTP Interface. Set as 'disabled' to remove the Web FTP option.
DEFINE('WEBMAIL_URL', '".$_POST['WEBMAIL_URL']."'); // Webmail URL. Leave blank for VestaCP default. Set as 'disabled' to remove the webmail option.
DEFINE('PHPMYADMIN_URL', '".$_POST['PHPMYADMIN_URL']."'); // phpMyAdmin URL. Leave blank for VestaCP default. Set as 'disabled; to remove phpMyAdmin option.
DEFINE('PHPPGADMIN_URL', '".$_POST['PHPPGADMIN_URL']."'); // phpPgAdmin URL. Leave blank for VestaCP default. Set as 'disabled; to remove phpPgAdmin option.
DEFINE('SUPPORT_URL', '".$_POST['SUPPORT_URL']."'); // Support URL. Leave blank or set to 'disabled' to disable.

// ENABLE OR DISABLE SECTIONS //
DEFINE('WEB_ENABLED', '".$webenabled."'); // Enable or disable web section. Ex: 'true' or 'false'.
DEFINE('DNS_ENABLED', '".$dnsenabled."'); // Enable or disable dns section. Ex: 'true' or 'false'.
DEFINE('MAIL_ENABLED', '".$mailenabled."'); // Enable or disable mail section. Ex: 'true' or 'false'.
DEFINE('DB_ENABLED', '".$dbenabled."'); // Enable or disable database section. Ex: 'true' or 'false'.
DEFINE('OLD_CP_LINK', '".$oldcplink."'); // Enable or disable link to old cpanel. Ex: 'true' or 'false'.

// INTEGRATIONS //
DEFINE('GOOGLE_ANALYTICS_ID', '".$_POST['GOOGLE_ANALYTICS_ID']."'); // Enable Google Analytics Tracking. Enter Tracking ID.
DEFINE('INTERAKT_APP_ID', '".$_POST['INTERAKT_APP_ID']."'); // Enable Interakt Support / Tools. Enter Interakt App ID.
DEFINE('INTERAKT_API_KEY', '".$_POST['INTERAKT_API_KEY']."'); // Enable Interakt User Management. Interakt Account number must be set first. Enter Interakt API Key.

///////////////////////////////////////////////////////////////////////
// DO NOT EDIT BELOW THIS LINE - CONVERTING AND PROCESSING CONSTANTS //
///////////////////////////////////////////////////////////////////////

if(VESTA_SSL_ENABLED == 'false'){
 \$vst_ssl = 'http://';
}
else{
 \$vst_ssl = 'https://';
}

if(VESTA_PORT == ''){
 \$vesta_port = '8083';
}
else{
 \$vesta_port = VESTA_PORT;
}

if(FTP_URL == ''){
 \$ftpurl = 'http://net2ftp.com/';
}
elseif(FTP_URL == 'disabled'){
 \$ftpurl = '';
}
else{
 \$ftpurl = FTP_URL;
}

if(WEB_ENABLED != 'true'){
 \$webenabled = '';
}
else{
 \$webenabled = WEB_ENABLED;
}
if(DNS_ENABLED != 'true'){
 \$dnsenabled = '';
}
else{
 \$dnsenabled = DNS_ENABLED;
}
if(MAIL_ENABLED != 'true'){
 \$mailenabled = '';
}
else{
 \$mailenabled = MAIL_ENABLED;
}
if(DB_ENABLED != 'true'){
 \$dbenabled = '';
}
else{
 \$dbenabled = DB_ENABLED;
}

\$vst_url = \$vst_ssl . VESTA_HOST_ADDRESS . ':' . \$vesta_port . '/api/';
\$url8083 = \$vst_ssl . VESTA_HOST_ADDRESS . ':' . \$vesta_port;
\$vst_username = VESTA_ADMIN_UNAME;
\$vst_password = VESTA_ADMIN_PW;
\$themecolor = THEME . '.css';
\$uname = base64_decode(\$_COOKIE['username']);
\$loggedin = base64_decode(\$_COOKIE['loggedin']);
\$username = \$uname;
\$sitetitle = SITE_NAME;

if(WEBMAIL_URL == ''){
 \$webmailurl = \$vst_ssl . VESTA_HOST_ADDRESS . '/webmail';
}
elseif(WEBMAIL_URL == 'disabled'){
 \$webmailurl = '';
}
else{
 \$webmailurl = WEBMAIL_URL;
}

if(PHPMYADMIN_URL == ''){
 \$phpmyadmin = \$vst_ssl . VESTA_HOST_ADDRESS . '/phpmyadmin';
}
elseif(PHPMYADMIN_URL == 'disabled'){
 \$phpmyadmin = '';
}
else{
 \$phpmyadmin = PHPMYADMIN_URL;
}

if(PHPPGADMIN_URL == ''){
 \$phppgadmin = \$vst_ssl . VESTA_HOST_ADDRESS . '/phppgadmin';
}
elseif(PHPPGADMIN_URL == 'disabled'){
 \$phppgadmin = '';
}
else{
 \$phppgadmin = PHPPGADMIN_URL;
}

if(SUPPORT_URL == ''){
 \$supporturl = '';
}
elseif(SUPPORT_URL == 'disabled'){
 \$supporturl = '';
}
else{
 \$supporturl = SUPPORT_URL;
}

if(OLD_CP_LINK == 'false'){
 \$oldcpurl = '';
}
else{
 \$oldcpurl = \$url8083;
}

include 'functions.php'
?>";

file_put_contents('../includes/config.php', $writestr);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Install Vesta Web Interface</title>
<style>
body {
  padding-top: 50px;
}
.starter-template {
  padding: 40px 15px;
  text-align: center;
}
</style>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="container">
      <div class="starter-template">
        <h1>Configuration Complete!</h1><br>
        <p class="lead">Please delete the 'install' directory to prevent any security issues. <br><br>If you have not already installed the VWI Backend,<br> run the command "bash <(curl -s -L https://git.io/vbjOd)" <br>on your vesta server or follow the instructions on the <a href="https://github.com/cdgco/VestaWebInterface">GitHub Repo</a></p><br>
          <a href="../index.php"><button class="btn btn-info btn-lg">Launch Control Panel</button></a>
      </div>
    </div>
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.2/js/bootstrap.min.js"></script>
  </body>
</html>