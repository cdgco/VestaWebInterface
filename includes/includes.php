<?php

include("config.php");

$con=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db); $config = array();
$result=mysqli_query($con,"SELECT VARIABLE,VALUE FROM " . $mysql_table . "config");
while ($row = mysqli_fetch_assoc($result)) { $config[$row["VARIABLE"]] = $row["VALUE"]; }
mysqli_free_result($result); mysqli_close($con);


date_default_timezone_set($config["TIMEZONE"]);


if($config["DEFAULT_TO_ADMIN"] != 'true'){
    $defaulttoadmin = '';
}
else{
    $defaulttoadmin = $config["DEFAULT_TO_ADMIN"];
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

if($config["FTP_URL"] == ''){
    $ftpurl = 'http://net2ftp.com/';
}
elseif($config["FTP_URL"] == 'disabled'){
    $ftpurl = '';
}
else{
    $ftpurl = $config["FTP_URL"];
}

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

DEFINE('VESTA_HOST_ADDRESS', $config["VESTA_HOST_ADDRESS"]); 
DEFINE('VESTA_ADMIN_UNAME', $config["VESTA_ADMIN_UNAME"]);
DEFINE('VESTA_ADMIN_PW', $config["VESTA_ADMIN_PW"]);

DEFINE('GOOGLE_ANALYTICS_ID', $config["GOOGLE_ANALYTICS_ID"]);
DEFINE('INTERAKT_APP_ID', $config["INTERAKT_APP_ID"]);
DEFINE('INTERAKT_API_KEY', $config["INTERAKT_API_KEY"]);
DEFINE('CLOUDFLARE_API_KEY', $config["CLOUDFLARE_API_KEY"]);
DEFINE('CLOUDFLARE_EMAIL', $config["CLOUDFLARE_EMAIL"]);

$key1 = $config["KEY1"];
$key2 = $config["KEY2"];

$vst_url = $vst_ssl . $config["VESTA_HOST_ADDRESS"] . ':' . $vesta_port . '/api/';
$url8083 = $vst_ssl . $config["VESTA_HOST_ADDRESS"] . ':' . $vesta_port;
$vst_username = $config["VESTA_ADMIN_UNAME"];
$vst_password = $config["VESTA_ADMIN_PW"];
$themecolor = $config["THEME"] . '.css';
$initialusername = base64_decode($_SESSION['username']);
$loggedin = base64_decode($_SESSION['loggedin']);
$locale = $config["LANGUAGE"];

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
$sitetitle = $config["SITE_NAME"];
$cfapikey = $config["CLOUDFLARE_API_KEY"];

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

require 'arrays.php';
function vwicrypt($cs,$ca='e'){$op = false;$ecm ="AES-256-CBC";$key=hash('sha256',$KEY1);$iv=substr(hash('sha256',$KEY2),0,16);if($ca=='e'){$op=base64_encode(openssl_encrypt($cs,$ecm,$key,0,$iv));} else if($ca=='d'){$op=openssl_decrypt(base64_decode($cs),$ecm,$key,0,$iv);}return $op;}

$plugins = explode(",", $config["PLUGINS"]);
$pluginlinks = array();
$pluginnames = array();
$pluginicons = array();
$pluginsections = array();
$pluginadminonly = array();

function indexMenu($l1) {
    echo '<li> 
            <a active href="' . $l1 . 'index.php" class="active waves-effect">
                <i class="mdi mdi-home fa-fw"></i> <span class="hide-menu">' . _("Home") . '</span>
            </a> 
        </li>';
}

function adminMenu($l2, $a1) {
    if(base64_decode($_SESSION['username']) == "admin"){
    echo '<li class="devider"></li>
            <li> <a href="#" class="waves-effect"><i class="mdi mdi-wrench fa-fw" data-icon="v"></i> <span class="hide-menu">' . _("Administration") . '<span class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level'; if(isset($a1) || $a1 != '') { echo ' in'; } echo '>
                    <li> <a href="' . $l2 . 'users.php"'; if($a1 == 'users') { echo ' class="active"'; } echo '><i class="ti-user fa-fw"></i><span class="hide-menu">' . _("Users") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'packages.php"'; if($a1 == 'packages') { echo ' class="active"'; } echo '><i class="ti-package fa-fw"></i><span class="hide-menu">' . _("Packages") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'ip.php"'; if($a1 == 'ip') { echo ' class="active"'; } echo '><i class="fa fa-sliders fa-fw"></i><span class="hide-menu">' . _("IP") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'graphs.php"'; if($a1 == 'graph') { echo ' class="active"'; } echo '><i class="ti-pie-chart fa-fw"></i><span class="hide-menu">' . _("Graphs") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'stats.php"'; if($a1 == 'stats') { echo ' class="active"'; } echo '><i class="ti-stats-up fa-fw"></i><span class="hide-menu">' . _("Statistics") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'updates.php"'; if($a1 == 'updates') { echo ' class="active"'; } echo '><i class="mdi mdi-weather-cloudy fa-fw"></i><span class="hide-menu">' . _("Updates") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'firewall.php"'; if($a1 == 'firewall') { echo ' class="active"'; } echo '><i class="fa fa-shield fa-fw"></i><span class="hide-menu">' . _("Firewall") . '</span></a> </li>
                    <li> <a href="' . $l2 . 'server.php"'; if($a1 == 'server') { echo ' class="active"'; } echo '><i class="fa fa-server fa-fw"></i><span class="hide-menu">' . _("Server") . '</span></a> </li>
                </ul>
            </li>';
    } 
}
function profileMenu($l3) {
    echo
        '<li class="devider"></li>
        <li>
            <a href="#" class="waves-effect"><i  class="ti-user fa-fw"></i><span class="hide-menu">';
            if(base64_decode($_SESSION['username']) == "admin" && isset($_SESSION['proxied']) && base64_decode($_SESSION['proxied']) != '')   {
                echo base64_decode($_SESSION['username']) . " &rarr; " . base64_decode($_SESSION['proxied']);
            }  
            else {
                echo base64_decode($_SESSION['username']);
            }
            echo '<span class="fa arrow"></span></span>
            </a>
            <ul class="nav nav-second-level collapse" id="appendaccount" aria-expanded="false" style="height: 0px;">
                <li> <a href="' . $l3 . 'profile.php"><i class="ti-home fa-fw"></i> <span class="hide-menu">' . _("My Account") . '</span></a></li>
                <li> <a href="' . $l3 . 'profile.php?settings=open"><i class="ti-settings fa-fw"></i> <span class="hide-menu">' . _("Account Settings") . '</span></a></li>
                <li> <a href="' . $l3 . 'log.php"><i class="ti-layout-list-post fa-fw"></i><span class="hide-menu">' . _("Log") . '</span></a> </li>
            </ul>
        </li>';
}
function primaryMenu($l4, $l5, $a2) {
        global $webenabled; global $dnsenabled; global $mailenabled; global $dbenabled; global $ftpurl; global $webmailurl; global $phpmyadmin; global $phppgadmin; global $oldcpurl; global $supporturl;
        if ($webenabled != 'true' && $dnsenabled != 'true' && $mailenabled != 'true' && $dbenabled != 'true') {} else { echo '<li class="devider"></li>
            <li'; if($a2 == 'web' || $a2 == 'dns' || $a2 == 'mail' || $a2 == 'db') { echo ' class="active"'; } echo '> <a href="#" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">' . _("Management") . '<span class="fa arrow"></span> </span></a>
                <ul class="nav nav-second-level" id="appendmanagement">'; }
        if ($webenabled == 'true') { echo '<li> <a href="' . $l4 . 'web.php"'; if($a2 == 'web') { echo ' class="active"'; } echo '><i class="ti-world fa-fw"></i><span class="hide-menu">' . _("Web") . '</span></a> </li>'; }
        if ($dnsenabled == 'true') { echo '<li> <a href="' . $l4 . 'list/dns.php"'; if($a2 == 'dns') { echo ' class="active"'; } echo '><i class="fa fa-sitemap fa-fw"></i><span class="hide-menu">' . _("DNS") . '</span></a> </li>'; }
        if ($mailenabled == 'true') { echo '<li> <a href="' . $l4 . 'list/mail.php"'; if($a2 == 'mail') { echo ' class="active"'; } echo '><i class="fa fa-envelope fa-fw"></i><span class="hide-menu">' . _("Mail") . '</span></a> </li>'; }
        if ($dbenabled == 'true') { echo '<li> <a href="' . $l4 . 'list/db.php"'; if($a2 == 'db') { echo ' class="active"'; } echo '><i class="fa fa-database fa-fw"></i><span class="hide-menu">' . _("Database") . '</span></a> </li>'; }
        if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '</ul>
            </li>'; } echo
        '<li> <a href="' . $l4 . 'cron.php" class="waves-effect'; if($a2 == 'cron') { echo ' active'; } echo '"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">' . _("Cron Jobs") . '</span></a> </li>
        <li> <a href="' . $l4 . 'backups.php" class="waves-effect'; if($a2 == 'backups') { echo ' active'; } echo '"><i  class="fa fa-cloud-upload fa-fw"></i> <span class="hide-menu">' . _("Backups") . '</span></a> </li>';
        if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {} else { echo '<li class="devider"></li>
            <li><a href="#" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">' . _("Apps") . '<span class="fa arrow"></span></span></a>
                <ul class="nav nav-second-level" id="appendapps">'; }
        if ($ftpurl != '') { echo '<li><a href="' . $ftpurl . '" target="_blank"><i class="fa fa-file-code-o fa-fw"></i><span class="hide-menu">' . _("FTP") . '</span></a></li>';}
        if ($webmailurl != '') { echo '<li><a href="' . $webmailurl . '" target="_blank"><i class="fa fa-envelope-o fa-fw"></i><span class="hide-menu">' . _("Webmail") . '</span></a></li>';}
        if ($phpmyadmin != '') { echo '<li><a href="' . $phpmyadmin . '" target="_blank"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">' . _("phpMyAdmin") . '</span></a></li>';}
        if ($phppgadmin != '') { echo '<li><a href="' . $phppgadmin . '" target="_blank"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">' . _("phpPgAdmin") . '</span></a></li>';}
        if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {} else { echo '</ul></li>';}
        echo '<li class="devider"></li>
        <li><a href="' . $l5 . 'process/logout.php" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">' . _("Log out") . '</span></a></li>';
        if ($oldcpurl == '' || $supporturl == '') {} else { echo '<li class="devider"></li>'; }
        if ($oldcpurl != '') { echo '<li><a href="' . $oldcpurl . '" class="waves-effect"> <i class="fa fa-tachometer fa-fw"></i> <span class="hide-menu"> ' . _("Control Panel v1") . '</span></a></li>'; }
        if ($supporturl != '') { echo '<li><a href="' . $supporturl . '" class="waves-effect" target="_blank"> <i class="fa fa-life-ring fa-fw"></i> <span class="hide-menu">' . _("Support") . '</span></a></li>'; }
}
?>