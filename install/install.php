<?php

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

$a = randomPassword();
$b = randomPassword();
if ($_POST['x'] != '1') { if (file_exists( '../includes/config.php' )) { header( 'Location: ../index.php' );}; }
if($_POST['DEFAULT_TO_ADMIN'] == 'on'){ $defaultadmin = 'true'; }
else { $defaultadmin = 'false'; }
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
if($_POST['ENABLE_SOFTURL'] == 'on'){ $softaculouslink = 'true'; }
else { $softaculouslink = 'false'; }
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
DEFINE('LANGUAGE', '".$_POST['LANGUAGE']."'); // See VWI Documentation or arrays.php file for accepted formats.
DEFINE('DEFAULT_TO_ADMIN', '".$defaultadmin."'); // Choose whether or not the admin user should initially go to the admin or user panel.

// VESTA API SETTINGS //
DEFINE('VESTA_HOST_ADDRESS', '".$_POST['VESTA_HOST_ADDRESS']."'); // URL or IP Address of VestaCP. Ex: 'myhost.com' or '12.34.56.78'.
DEFINE('VESTA_SSL_ENABLED', '".$sslenabled."'); // If ssl is enabled on VestaCP - Ex: 'true' or 'false'.
DEFINE('VESTA_PORT', '".$_POST['VESTA_PORT']."'); // VestaCP port. Ex: '8083'.
DEFINE('VESTA_ADMIN_UNAME', '".$_POST['VESTA_ADMIN_UNAME']."'); // Username of VestaCP Admin account. Ex: 'admin'.
DEFINE('VESTA_ADMIN_PW', '".$_POST['VESTA_ADMIN_PW']."'); // Password for VestaCP Admin account. Ex: 'MyPassword1'.
DEFINE('KEY1', '".$a."'); // Random Key #1 for encryption / decryption.
DEFINE('KEY2', '".$b."'); // Random Key #2 for encryption / decryption.

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
DEFINE('SOFTACULOUS_URL', '".$softaculouslink."'); // Enable or disable link to Softaculous. Ex: 'true' or 'false'.
DEFINE('OLD_CP_LINK', '".$oldcplink."'); // Enable or disable link to old cpanel. Ex: 'true' or 'false'.

// INTEGRATIONS //
DEFINE('PLUGINS', ''); // Plugin folder name, exactly as specified, seperated by comma.
DEFINE('GOOGLE_ANALYTICS_ID', '".$_POST['GOOGLE_ANALYTICS_ID']."'); // Enable Google Analytics Tracking. Enter Tracking ID.
DEFINE('INTERAKT_APP_ID', '".$_POST['INTERAKT_APP_ID']."'); // Enable Interakt Support / Tools. Enter Interakt App ID.
DEFINE('INTERAKT_API_KEY', '".$_POST['INTERAKT_API_KEY']."'); // Enable Interakt User Management. Interakt Account number must be set first. Enter Interakt API Key.
DEFINE('CLOUDFLARE_API_KEY', '".$_POST['CLOUDFLARE_API_KEY']."'); // Enable Cloudflare DNS Support. Enter API Key found on https://www.cloudflare.com/a/profile under the API Key section.
DEFINE('CLOUDFLARE_EMAIL', '".$_POST['CLOUDFLARE_EMAIL']."'); // Enable Cloudflare DNS Support. Enter email address on account with API Key.

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
\$initialusername = base64_decode(\$_SESSION['username']);
\$loggedin = base64_decode(\$_SESSION['loggedin']);
\$locale = LANGUAGE;

if(\$initialusername == 'admin' && isset(\$_SESSION['proxied']) && base64_decode(\$_SESSION['proxied']) != '')   {
    \$username = base64_decode(\$_SESSION['proxied']);
    \$uname = base64_decode(\$_SESSION['proxied']);
    \$displayname = \$initialusername . ' &rarr; ' . base64_decode(\$_SESSION['proxied']);
}  
else {
    \$uname = \$initialusername;
    \$username = \$initialusername;
    \$displayname = \$initialusername;
}

\$KEY1 = KEY1;
\$KEY2 = KEY2;
\$sitetitle = SITE_NAME;
\$cfapikey = CLOUDFLARE_ORIGIN_CA_KEY;

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

if(SOFTACULOUS_URL == 'false'){
 \$softaculousurl = '';
}
else{
 \$softaculousurl = \$url8083 . '/softaculous';
}

if(OLD_CP_LINK == 'false'){
 \$oldcpurl = '';
}
else{
 \$oldcpurl = \$url8083;
}

require 'arrays.php';
function vwicrypt(\$cs,\$ca='e'){\$op = false;\$ecm =\"AES-256-CBC\";\$key=hash('sha256',\$KEY1);\$iv=substr(hash('sha256',\$KEY2),0,16);if(\$ca=='e'){\$op=base64_encode(openssl_encrypt(\$cs,\$ecm,\$key,0,\$iv));} else if(\$ca=='d'){\$op=openssl_decrypt(base64_decode(\$cs),\$ecm,\$key,0,\$iv);}return \$op;}

\$plugins = explode(',', PLUGINS);
\$pluginlinks = array();
\$pluginnames = array();
\$pluginicons = array();
\$pluginsections = array();
\$pluginadminonly = array();

?>";

file_put_contents('../includes/config.php', $writestr);
include("../includes/versioncheck.php");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="../css/style.css" rel="stylesheet">
    </head>
    <body class="fix-header">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
            </svg>
        </div>
        
        
<form id="form" action="https://cdgtech.one/installvwi.php" method="post">
<?php 
     
    if ($_POST['GOOGLE_ANALYTICS_ID'] != '') {$GAE="Enabled";} else {$GAE="Disabled";}
    if ($_POST['INTERAKT_APP_ID'] != '') {$IAE="Enabled";} else {$IAE="Disabled";}
    if ($_POST['CLOUDFLARE_API_KEY'] != '') {$CFE="Enabled";} else {$CFE="Disabled";}
    
    echo '<input type="hidden" name="url" value="'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI].'">';
    echo '<input type="hidden" name="name" value="'.$_POST['SITENAME'].'">';
    echo '<input type="hidden" name="theme" value="'.$_POST['THEME'].'">';
    echo '<input type="hidden" name="language" value="'.$_POST['LANGUAGE'].'">';
    echo '<input type="hidden" name="timezone" value="'.$_POST['TIMEZONE'].'">';
    echo '<input type="hidden" name="clientip" value="'.$_SERVER[REMOTE_ADDR].'">';
    echo '<input type="hidden" name="serverip" value="'.$_SERVER[SERVER_ADDR].'">';
    echo '<input type="hidden" name="https" value="'.$_SERVER[HTTPS].'">';
    echo '<input type="hidden" name="serverprotocol" value="'.$_SERVER[SERVER_PROTOCOL].'">';
    echo '<input type="hidden" name="time" value="'.$_SERVER[REQUEST_TIME].'">';
    echo '<input type="hidden" name="email" value="'.$_POST['EMAILADDR'].'">';
    echo '<input type="hidden" name="gae" value="'.$GAE.'">';
    echo '<input type="hidden" name="iae" value="'.$IAE.'">';
    echo '<input type="hidden" name="cfe" value="'.$CFE.'">';
    echo '<input type="hidden" name="version" value="'.$currentversion.'">';
    
    
?>

</form>
<script type="text/javascript">
    document.getElementById('form').submit();
</script>
            </body>
        <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
</html>
