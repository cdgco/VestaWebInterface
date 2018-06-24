<?php

////////////////////////////////////////////////////////////////////////////////
//                                                                            //
//         Vesta Web Interface Configuration, Variables and Functions         //
//                                                                            //
////////////////////////////////////////////////////////////////////////////////

// Require MySQL Credentials & Arrays of Countries, Languages and Error Codes in all pages
require("config.php"); require("arrays.php");

$configstyle = '1';

$con=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db);

if($configstyle != '2') {
    // Method 1: Initiate connection to MySQL DB and convert data into PHP Array
    if (!$con) { $mysqldown = 'yes'; }
    $config = array(); $result=mysqli_query($con,"SELECT VARIABLE,VALUE FROM " . $mysql_table . "config");
    while ($row = mysqli_fetch_assoc($result)) { $config[$row["VARIABLE"]] = $row["VALUE"]; }
    mysqli_free_result($result); mysqli_close($con);
}
else {
    // Method 2: Connection to MySQL, save config locally every 30 min, grab locally if connection fails.
    
    // Location of config.json. If possible, place outside of document root to ensure access is blocked.
    $co1 = $configlocation . "../tmp/";
    
    if (!$con) { $config = json_decode(file_get_contents( $co1 . 'config.json'), true); $mysqldown = 'yes'; }
    else { 
        $config = array(); $result=mysqli_query($con,"SELECT VARIABLE,VALUE FROM " . $mysql_table . "config");
        while ($row = mysqli_fetch_assoc($result)) { $config[$row["VARIABLE"]] = $row["VALUE"]; }
        mysqli_free_result($result); mysqli_close($con);
        if (!file_exists( $co1 . 'config.json' )) { 
            file_put_contents( $co1 . "config.json",json_encode($config));
        }  
        // Reload Config Every Hour (1800 Seconds) or if DB has been updated
        elseif ((time()-filemtime( $co1 . "config.json")) > 1800 || $config != json_decode(file_get_contents( $co1 . 'config.json'), true)) { 
            file_put_contents( $co1 . "config.json",json_encode($config)); 
        }
    }
}


// Grab Session data for username & status
$initialusername = base64_decode($_SESSION['username']);
$loggedin = base64_decode($_SESSION['loggedin']);

// System for login as user
if($initialusername == "admin" && isset($_SESSION['proxied']) && base64_decode($_SESSION['proxied']) != '')   {
    $username = base64_decode($_SESSION['proxied']);
    $uname = base64_decode($_SESSION['proxied']);
    $displayname = $initialusername . " &rarr; " . base64_decode($_SESSION['proxied']);
}  
else {
    $uname = $initialusername;
    $username = $initialusername;
    $displayname = $initialusername;
}

/////////////////////////////////////////////////////////////////////////////////                
//         Vesta Web Interface Configuration Conversions & Definitions         //
//                       Ordered the same as settings.php                      //
/////////////////////////////////////////////////////////////////////////////////


//////////////////////////
// Server Configuration //
//////////////////////////

date_default_timezone_set($config["TIMEZONE"]);
$sitetitle = $config["SITE_NAME"];
$themecolor = $config["THEME"] . '.css';
$locale = $config["LANGUAGE"];
if($config["DEFAULT_TO_ADMIN"] != 'true'){
    $defaulttoadmin = '';
}
else{
    $defaulttoadmin = $config["DEFAULT_TO_ADMIN"];
}
DEFINE('VESTA_HOST_ADDRESS', $config["VESTA_HOST_ADDRESS"]); 
if($config["VESTA_SSL_ENABLED"] == 'false'){
    $vst_ssl = 'http://';
}
else{
    $vst_ssl = 'https://';
}
if($config["VESTA_PORT"] == ''){
    $vesta_port = '8083';
}
else{
    $vesta_port = $config["VESTA_PORT"];
}

DEFINE('VESTA_ADMIN_UNAME', $config["VESTA_ADMIN_UNAME"]);
$vst_username = $config["VESTA_ADMIN_UNAME"];

DEFINE('VESTA_ADMIN_PW', $config["VESTA_ADMIN_PW"]);
$vst_password = $config["VESTA_ADMIN_PW"];

$KEY1 = $config["KEY1"]; $key1 = $config["KEY1"];
$KEY2 = $config["KEY2"]; $key2 = $config["KEY2"];
$warningson = strtolower($config["WARNINGS_ENABLED"]);

$cpicon = $config["ICON"];
$cplogo = $config["LOGO"];
$cpfavicon = $config["FAVICON"];

///////////////////////////////
// Enable / Disable Sections //
///////////////////////////////

if($config["WEB_ENABLED"] != 'true'){
    $webenabled = '';
}
else{
    $webenabled = $config["WEB_ENABLED"];
}
if($config["DNS_ENABLED"] != 'true'){
    $dnsenabled = '';
}
else{
    $dnsenabled = $config["DNS_ENABLED"];
}
if($config["MAIL_ENABLED"] != 'true'){
    $mailenabled = '';
}
else{
    $mailenabled = $config["MAIL_ENABLED"];
}
if($config["DB_ENABLED"] != 'true'){
    $dbenabled = '';
}
else{
    $dbenabled = $config["DB_ENABLED"];
}
if($config["ADMIN_ENABLED"] != 'true'){
    $adminenabled = '';
}
else{
    $adminenabled = $config["ADMIN_ENABLED"];
}
if($config["PROFILE_ENABLED"] != 'true'){
    $profileenabled = '';
}
else{
    $profileenabled = $config["PROFILE_ENABLED"];
}
if($config["CRON_ENABLED"] != 'true'){
    $cronenabled = '';
}
else{
    $cronenabled = $config["CRON_ENABLED"];
}
if($config["BACKUPS_ENABLED"] != 'true'){
    $backupsenabled = '';
}
else{
    $backupsenabled = $config["BACKUPS_ENABLED"];
}
if($config["REGISTRATIONS_ENABLED"] != 'true'){
    $regenabled = '';
}
else{
    $regenabled = $config["REGISTRATIONS_ENABLED"];
}
if($config["SOFTACULOUS_URL"] == 'false'){
    $softaculousurl = '';
}
else{
    $softaculousurl = $url8083 . '/softaculous';
}
if($config["OLD_CP_LINK"] == 'false'){
    $oldcpurl = '';
}
else{
    $oldcpurl = $url8083;
}
//////////
// MAIL //
//////////

$phpmailenabled = strtolower($config["PHPMAIL_ENABLED"]);
$mailfrom = $config["MAIL_FROM"];
$mailname = $config["MAIL_NAME"];
$smtpenabled = strtolower($config["SMTP_ENABLED"]);
$smtpport = $config["SMTP_PORT"];
$smtphost = $config["SMTP_HOST"];
$smtpauth = strtolower($config["SMTP_AUTH"]);
$smtpuname = $config["SMTP_UNAME"];
$smtppw = $config["SMTP_PW"];
$smtpenc = strtolower($config["SMTP_ENC"]);

////////////////////
// Optional Links //
////////////////////

if($config["FTP_URL"] == ''){
    $ftpurl = 'http://net2ftp.com/';
}
elseif($config["FTP_URL"] == 'disabled'){
    $ftpurl = '';
}
else{
    $ftpurl = $config["FTP_URL"];
}
if($config["WEBMAIL_URL"] == ''){
    $webmailurl = $vst_ssl . $config["VESTA_HOST_ADDRESS"] . '/webmail';
}
elseif($config["WEBMAIL_URL"] == 'disabled'){
    $webmailurl = '';
}
else{
    $webmailurl = $config["WEBMAIL_URL"];
}
if($config["PHPMYADMIN_URL"] == ''){
    $phpmyadmin = $vst_ssl . $config["VESTA_HOST_ADDRESS"] . '/phpmyadmin';
}
elseif($config["PHPMYADMIN_URL"] == 'disabled'){
    $phpmyadmin = '';
}
else{
    $phpmyadmin = $config["PHPMYADMIN_URL"];
}
if($config["PHPPGADMIN_URL"] == ''){
    $phppgadmin = $vst_ssl . $config["VESTA_HOST_ADDRESS"] . '/phppgadmin';
}
elseif($config["PHPPGADMIN_URL"] == 'disabled'){
    $phppgadmin = '';
}
else{
    $phppgadmin = $config["PHPPGADMIN_URL"];
}
if($config["SUPPORT_URL"] == ''){
    $supporturl = '';
}
elseif($config["SUPPORT_URL"] == 'disabled'){
    $supporturl = '';
}
else{
    $supporturl = $config["SUPPORT_URL"];
}

//////////////////////////
// Optional Integration //
//////////////////////////
$plugins = explode(",", $config["PLUGINS"]);
$pluginlinks = array();
$pluginnames = array();
$pluginicons = array();
$pluginsections = array();
$pluginadminonly = array();
$pluginnewtab = array();
$pluginhide = array();

DEFINE('GOOGLE_ANALYTICS_ID', $config["GOOGLE_ANALYTICS_ID"]);
DEFINE('INTERAKT_APP_ID', $config["INTERAKT_APP_ID"]);
DEFINE('INTERAKT_API_KEY', $config["INTERAKT_API_KEY"]);
DEFINE('CLOUDFLARE_API_KEY', $config["CLOUDFLARE_API_KEY"]);
$cfapikey = $config["CLOUDFLARE_API_KEY"];
DEFINE('CLOUDFLARE_EMAIL', $config["CLOUDFLARE_EMAIL"]);


$vst_url = $vst_ssl . $config["VESTA_HOST_ADDRESS"] . ':' . $vesta_port . '/api/';
$url8083 = $vst_ssl . $config["VESTA_HOST_ADDRESS"] . ':' . $vesta_port;

///////////////////
// VWI Functions //
///////////////////

function vwicrypt($cs,$ca='e') { 
    $op = false; $ecm ="AES-256-CBC"; $key=hash('sha256',$KEY1); $iv=substr(hash('sha256',$KEY2),0,16); 
    if($ca=='e'){
        $op=base64_encode(openssl_encrypt($cs,$ecm,$key,0,$iv));
    } 
    elseif($ca=='d'){
        $op=openssl_decrypt(base64_decode($cs),$ecm,$key,0,$iv);
    }
    return $op;
}
function indexMenu($l1) {
    echo '<li> 
            <a href="' . $l1 . 'index.php" class="waves-effect">
                <i class="mdi mdi-home fa-fw"></i> <span class="hide-menu">' . _("Home") . '</span>
            </a> 
        </li>';
}
function adminMenu($l2, $a1) {
    global $adminenabled;
    global $initialusername;
    if($initialusername == "admin" && isset($adminenabled) && $adminenabled != ''){
    echo '<li class="devider"></li>
            <li> <a href="#" class="waves-effect"><i class="mdi mdi-wrench fa-fw" data-icon="v"></i> <span class="hide-menu">' . _("Administration") . '<span class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level'; if(isset($a1) && $a1 != '') { echo ' in'; } echo '">
                    <li> <a href="' . $l2 . 'users.php"'; if($a1 == 'users') { echo ' class="active"'; } echo '><i class="ti-user fa-fw"></i><span class="hide-menu">' . _("Users") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'packages.php"'; if($a1 == 'packages') { echo ' class="active"'; } echo '><i class="ti-package fa-fw"></i><span class="hide-menu">' . _("Packages") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'ip.php"'; if($a1 == 'ip') { echo ' class="active"'; } echo '><i class="fa fa-sliders fa-fw"></i><span class="hide-menu">' . _("IP") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'graphs.php"'; if($a1 == 'graph') { echo ' class="active"'; } echo '><i class="ti-pie-chart fa-fw"></i><span class="hide-menu">' . _("Graphs") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'stats.php"'; if($a1 == 'stats') { echo ' class="active"'; } echo '><i class="ti-stats-up fa-fw"></i><span class="hide-menu">' . _("Statistics") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'updates.php"'; if($a1 == 'updates') { echo ' class="active"'; } echo '><i class="mdi mdi-weather-cloudy fa-fw"></i><span class="hide-menu">' . _("Updates") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'firewall.php"'; if($a1 == 'firewall') { echo ' class="active"'; } echo '><i class="fa fa-shield fa-fw"></i><span class="hide-menu">' . _("Firewall") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'server.php"'; if($a1 == 'server') { echo ' class="active"'; } echo '><i class="fa fa-server fa-fw"></i><span class="hide-menu">' . _("Server") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'settings.php"'; if($a1 == 'settings') { echo ' class="active"'; } echo '><i class="fa fa-cogs fa-fw"></i><span class="hide-menu">' . _("Settings") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'plugins.php"'; if($a1 == 'plugins') { echo ' class="active"'; } echo '><i class="fa fa-puzzle-piece fa-fw"></i><span class="hide-menu">' . _("Plugins") . '</span></a> </li>
                </ul>
            </li>';
    } 
}
function profileMenu($l3) {
    global $displayname; global $profileenabled;
    if(isset($profileenabled) && $profileenabled != ''){
    echo
        '<li class="devider"></li>
        <li>
            <a href="#" class="waves-effect"><i  class="ti-user fa-fw"></i><span class="hide-menu">' . $displayname . '<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level collapse" id="appendaccount">
                <li> <a href="' . $l3 . 'profile.php"><i class="ti-home fa-fw"></i> <span class="hide-menu">' . _("My Account") . '</span></a></li>
                <li> <a href="' . $l3 . 'profile.php?settings=open"><i class="ti-settings fa-fw"></i> <span class="hide-menu">' . _("Account Settings") . '</span></a></li>
                <li> <a href="' . $l3 . 'log.php"><i class="ti-layout-list-post fa-fw"></i><span class="hide-menu">' . _("Log") . '</span></a> </li>
            </ul>
        </li>';
    }
}
function primaryMenu($l4, $l5, $a2) {
        global $webenabled; global $dnsenabled; global $mailenabled; global $dbenabled; global $ftpurl; global $webmailurl; global $phpmyadmin; global $phppgadmin; global $oldcpurl; global $supporturl; global $cronenabled; global $backupsenabled; global $softaculousurl;
        if ($webenabled != 'true' && $dnsenabled != 'true' && $mailenabled != 'true' && $dbenabled != 'true') {} else { echo '<li class="devider"></li>
            <li'; if($a2 == 'web' || $a2 == 'dns' || $a2 == 'mail' || $a2 == 'db') { echo ' class="active"'; } echo '> <a href="#" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">' . _("Management") . '<span class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level" id="appendmanagement">'; }
        if ($webenabled == 'true') { echo '<li> <a href="' . $l4 . 'web.php"'; if($a2 == 'web') { echo ' class="active"'; } echo '><i class="ti-world fa-fw"></i><span class="hide-menu">' . _("Web") . '</span></a> </li>'; }
        if ($dnsenabled == 'true') { echo '<li> <a href="' . $l4 . 'dns.php"'; if($a2 == 'dns') { echo ' class="active"'; } echo '><i class="fa fa-sitemap fa-fw"></i><span class="hide-menu">' . _("DNS") . '</span></a> </li>'; }
        if ($mailenabled == 'true') { echo '<li> <a href="' . $l4 . 'mail.php"'; if($a2 == 'mail') { echo ' class="active"'; } echo '><i class="fa fa-envelope fa-fw"></i><span class="hide-menu">' . _("Mail") . '</span></a> </li>'; }
        if ($dbenabled == 'true') { echo '<li> <a href="' . $l4 . 'db.php"'; if($a2 == 'db') { echo ' class="active"'; } echo '><i class="fa fa-database fa-fw"></i><span class="hide-menu">' . _("Database") . '</span></a> </li>'; }
        if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '</ul>
            </li>'; }
        if(isset($cronenabled) && $cronenabled != ''){
        echo '<li> <a href="' . $l4 . 'cron.php" class="waves-effect'; if($a2 == 'cron') { echo ' active'; } echo '"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">' . _("Cron Jobs") . '</span></a> </li>'; }
        if(isset($backupsenabled) && $backupsenabled != ''){
        echo '<li> <a href="' . $l4 . 'backups.php" class="waves-effect'; if($a2 == 'backups') { echo ' active'; } echo '"><i  class="fa fa-cloud-upload fa-fw"></i> <span class="hide-menu">' . _("Backups") . '</span></a> </li>'; }
        if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '' && $softaculousurl == '') {} else { echo '<li class="devider"></li>
            <li><a href="#" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">' . _("Apps") . '<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level" id="appendapps">'; }
        if ($ftpurl != '') { echo '<li><a href="' . $ftpurl . '" target="_blank"><i class="fa fa-file-code-o fa-fw"></i><span class="hide-menu">' . _("FTP") . '</span></a></li>';}
        if ($webmailurl != '') { echo '<li><a href="' . $webmailurl . '" target="_blank"><i class="fa fa-envelope-o fa-fw"></i><span class="hide-menu">' . _("Webmail") . '</span></a></li>';}
        if ($phpmyadmin != '') { echo '<li><a href="' . $phpmyadmin . '" target="_blank"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">' . _("phpMyAdmin") . '</span></a></li>';}
        if ($phppgadmin != '') { echo '<li><a href="' . $phppgadmin . '" target="_blank"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">' . _("phpPgAdmin") . '</span></a></li>';}
        if ($softaculousurl != '') { echo '<li><a href="' . $softaculousurl . '" target="_blank"><i class="icon-softaculous">&#xe801;</i><span class="hide-menu">' . _("Softaculous") . '</span></a></li>';}
        if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '' && $softaculousurl == '') {} else { echo '</ul></li>';}
        echo '<li class="devider"></li>
        <li><a href="' . $l5 . 'logout.php" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">' . _("Log out") . '</span></a></li>';
        if ($oldcpurl == '' || $supporturl == '') {} else { echo '<li class="devider"></li>'; }
        if ($oldcpurl != '') { echo '<li><a href="' . $oldcpurl . '" class="waves-effect"> <i class="fa fa-tachometer fa-fw"></i> <span class="hide-menu"> ' . _("Control Panel v1") . '</span></a></li>'; }
        if ($supporturl != '') { echo '<li><a href="' . $supporturl . '" class="waves-effect" target="_blank"> <i class="fa fa-life-ring fa-fw"></i> <span class="hide-menu">' . _("Support") . '</span></a></li>'; }
}
function includeScript() {
    global $configlocation; global $mysqldown; global $initialusername; global $warningson;
    if($warningson == "all"){
        if(substr(sprintf('%o', fileperms($configlocation)), -4) == '0777') {
            echo "$.toast({
                    heading: '"._("Warning")."', 
                    text: '"._("Includes folder has not been secured")."',
                    icon: 'warning',
                    position: 'top-right',
                    hideAfter: 3500,
                    bgColor: '#ff8000'
                });";

        } 
        if(isset($mysqldown) && $mysqldown == 'yes') {
            echo "$.toast({
                    heading: '" . _("Database Error") . "',
                    text: '" . _("MySQL Server Failed To Connect") . "',
                    icon: 'error',
                    position: 'top-right',
                    hideAfter: false
                });";

        } 
    }
    elseif($warningson == "admin" && $initialusername == "admin"){
        if(substr(sprintf('%o', fileperms($configlocation)), -4) == '0777') {
            echo "$.toast({
                    heading: '"._("Warning")."', 
                    text: '"._("Includes folder has not been secured")."',
                    icon: 'warning',
                    position: 'top-right',
                    hideAfter: 3500,
                    bgColor: '#ff8000'
                });";

        } 
        if(isset($mysqldown) && $mysqldown == 'yes') {
            echo "$.toast({
                    heading: '" . _("Database Error") . "',
                    text: '" . _("MySQL Server Failed To Connect") . "',
                    icon: 'error',
                    position: 'top-right',
                    hideAfter: false
                });";

        } 
    }
}
?>