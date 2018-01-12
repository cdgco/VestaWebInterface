***REMOVED***

session_start();

if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); ***REMOVED***  else { header( 'Location: ../install' );***REMOVED***;

if(base64_decode($_SESSION['loggedin']) == 'true') {***REMOVED***
else { header('Location: ../login.php'); ***REMOVED***

$requestdomain = $_GET['domain'];

if (isset($requestdomain) && $requestdomain != '') {***REMOVED***
else { header('Location: ../list/web.php'); ***REMOVED***

$postvars = array(
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-domain','arg1' => $username,'arg2' => $requestdomain, 'arg3' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-templates','arg1' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-templates-proxy','arg1' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user-ips','arg1' => $username,'arg2' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-domain-ssl','arg1' => $username,'arg2' => $requestdomain,'arg3' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-stats','arg1' => 'json'));

$curl0 = curl_init();
$curl1 = curl_init();
$curl2 = curl_init();
$curl3 = curl_init();
$curl4 = curl_init();
$curl5 = curl_init();
$curl6 = curl_init();
$curlstart = 0; 

while($curlstart <= 6) {
    curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_URL, $vst_url);
    curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_RETURNTRANSFER,true);
    curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_POST, true);
    curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
    $curlstart++;
***REMOVED*** 

$admindata = json_decode(curl_exec($curl0), true)[$username];
$useremail = $admindata['CONTACT'];
$domainname = array_keys(json_decode(curl_exec($curl1), true));
$domaindata = array_values(json_decode(curl_exec($curl1), true));
$webtemplates = array_values(json_decode(curl_exec($curl2), true));
$proxytemplates = array_values(json_decode(curl_exec($curl3), true));
$userips = array_keys(json_decode(curl_exec($curl4), true));
$domainssl = array_values(json_decode(curl_exec($curl5), true));
$webstats = array_values(json_decode(curl_exec($curl6), true));

if ($domainname[0] == '') { header('Location: ../list/web.php'); ***REMOVED***
if(isset($admindata['LANGUAGE'])){ $locale = $ulang[$admindata['LANGUAGE']]; ***REMOVED***
setlocale(LC_CTYPE, $locale); setlocale(LC_MESSAGES, $locale);
bindtextdomain('messages', '../locale');
textdomain('messages');
***REMOVED***

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/ico" href="../plugins/images/favicon.ico">
        <title>***REMOVED*** echo $sitetitle; ***REMOVED*** - ***REMOVED*** echo _("Web"); ***REMOVED***</title>
        <link href="../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
        <link href="../plugins/bower_components/footable/css/footable.bootstrap.css" rel="stylesheet">
        <link href="../plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
        <link href="../css/animate.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
        <link href="../css/colors/***REMOVED*** if(isset($_COOKIE['theme'])) { echo base64_decode($_COOKIE['theme']); ***REMOVED*** else {echo $themecolor; ***REMOVED*** ***REMOVED***" id="theme" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.min.css" />
        ***REMOVED*** if(isset(GOOGLE_ANALYTICS_ID)){ echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . GOOGLE_ANALYTICS_ID . "'></script>
        <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);***REMOVED*** gtag('js', new Date()); gtag('config', '" . GOOGLE_ANALYTICS_ID . "');</script>"; ***REMOVED*** 
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>

    <body class="fix-header" onload="checkDiv();checkDiv2();checkDiv3();checkDiv4();showauth();">
        <!-- ============================================================== -->
        <!-- Preloader -->
        <!-- ============================================================== -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
            </svg>
        </div>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top m-b-0">
                <div class="navbar-header">
                    <div class="top-left-part">
                        <!-- Logo -->
                        <a class="logo" href="../index.php">
                            <!-- Logo icon image, you can use font-icon also --><b>
                            <!--This is dark logo icon--><img src="../plugins/images/admin-logo.png" alt="home" class="logo-1 dark-logo" /><!--This is light logo icon--><img src="../plugins/images/admin-logo-dark.png" alt="home" class="logo-1 light-logo" />
                            </b>
                            <!-- Logo text image you can use text also --><span class="hidden-xs">
                            <!--This is dark logo text--><img src="../plugins/images/admin-text.png" alt="home" class="hidden-xs dark-logo" /><!--This is light logo text--><img src="../plugins/images/admin-text-dark.png" alt="home" class="hidden-xs light-logo" />
                            </span> </a>
                    </div>
                    <!-- /Logo -->
                    <!-- Search input and Toggle icon -->
                    <ul class="nav navbar-top-links navbar-left">
                        <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>      
                    </ul>
                    <ul class="nav navbar-top-links navbar-right pull-right">

                        <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"><b class="hidden-xs">***REMOVED*** print_r($uname); ***REMOVED***</b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-text">
                                        <h4>***REMOVED*** print_r($uname); ***REMOVED***</h4>
                                        <p class="text-muted">***REMOVED*** print_r($useremail); ***REMOVED***</p></div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="../profile.php"><i class="ti-home"></i> ***REMOVED*** echo _("My Account"); ***REMOVED***</a></li>
                            <li><a href="../profile.php?settings=open"><i class="ti-settings"></i> ***REMOVED*** echo _("Account Settings"); ***REMOVED***</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="../process/logout.php"><i class="fa fa-power-off"></i> ***REMOVED*** echo _("Logout"); ***REMOVED***</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3>
                        <span class="fa-fw open-close">
                            <i class="ti-menu hidden-xs"></i>
                            <i class="ti-close visible-xs"></i>
                        </span> 
                        <span class="hide-menu">***REMOVED*** echo _("Navigation"); ***REMOVED***</span>
                    </h3>  
                </div>
               <ul class="nav" id="side-menu">
                            <li> 
                                <a href="../index.php" class="waves-effect">
                                    <i class="mdi mdi-home fa-fw"></i> <span class="hide-menu">***REMOVED*** echo _("Dashboard"); ***REMOVED***</span>
                                </a> 
                            </li>

                            <li class="devider"></li>
                            <li>
                                <a href="#" class="waves-effect"><i  class="ti-user fa-fw"></i><span class="hide-menu"> ***REMOVED*** print_r($uname); ***REMOVED***<span class="fa arrow"></span></span>
                                </a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                                    <li> <a href="../profile.php"><i class="ti-home fa-fw"></i> <span class="hide-menu"> ***REMOVED*** echo _("My Account"); ***REMOVED***</span></a></li>
                                    <li> <a href="../profile.php?settings=open"><i class="ti-settings fa-fw"></i> <span class="hide-menu"> ***REMOVED*** echo _("Acount Settings"); ***REMOVED***</span></a></li>
                                </ul>
                            </li>
                        ***REMOVED*** if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '<li class="devider"></li>
                            <li class="active"> <a href="#" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">'. _("Management") . '<span class="fa arrow"></span> </span></a>
                                <ul class="nav nav-second-level">'; ***REMOVED*** ***REMOVED***
                        ***REMOVED*** if ($webenabled == 'true') { echo '<li> <a href="../list/web.php" class="active"><i class="ti-world fa-fw"></i><span class="hide-menu">' . _("Web") . '</span></a> </li>'; ***REMOVED*** ***REMOVED***
                        ***REMOVED*** if ($dnsenabled == 'true') { echo '<li> <a href="../list/dns.php"><i class="fa fa-sitemap fa-fw"></i><span class="hide-menu">' . _("DNS") . '</span></a> </li>'; ***REMOVED*** ***REMOVED***
                        ***REMOVED*** if ($mailenabled == 'true') { echo '<li> <a href="../list/mail.php"><i class="fa fa-envelope fa-fw"></i><span class="hide-menu">' . _("Mail") . '</span></a> </li>'; ***REMOVED*** ***REMOVED***
                        ***REMOVED*** if ($dbenabled == 'true') { echo '<li> <a href="../list/db.php"><i class="fa fa-database fa-fw"></i><span class="hide-menu">' . _("Database") . '</span></a> </li>'; ***REMOVED*** ***REMOVED***
                        ***REMOVED*** if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '</ul>
                            </li>'; ***REMOVED*** ***REMOVED***
                        <li> <a href="../list/cron.php" class="waves-effect"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">***REMOVED*** echo _("Cron Jobs"); ***REMOVED***</span></a> </li>
                        <li> <a href="../list/backups.php" class="waves-effect"><i  class="fa fa-cloud-upload fa-fw"></i> <span class="hide-menu">***REMOVED*** echo _("Backups"); ***REMOVED***</span></a> </li>
                        ***REMOVED*** if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {***REMOVED*** else { echo '<li class="devider"></li>
                            <li><a href="#" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">' . _("Apps") . '<span class="fa arrow"></span></span></a>
                                <ul class="nav nav-second-level">'; ***REMOVED*** ***REMOVED***
                        ***REMOVED*** if ($ftpurl != '') { echo '<li><a href="' . $ftpurl . '" target="_blank"><i class="fa fa-file-code-o fa-fw"></i><span class="hide-menu">' . _("FTP") . '</span></a></li>';***REMOVED*** ***REMOVED***
                        ***REMOVED*** if ($webmailurl != '') { echo '<li><a href="' . $webmailurl . '" target="_blank"><i class="fa fa-envelope-o fa-fw"></i><span class="hide-menu">' . _("Webmail") . '</span></a></li>';***REMOVED*** ***REMOVED***
                        ***REMOVED*** if ($phpmyadmin != '') { echo '<li><a href="' . $phpmyadmin . '" target="_blank"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">' . _("phpMyAdmin") . '</span></a></li>';***REMOVED*** ***REMOVED***
                        ***REMOVED*** if ($phppgadmin != '') { echo '<li><a href="' . $phppgadmin . '" target="_blank"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">' . _("phpPgAdmin") . '</span></a></li>';***REMOVED*** ***REMOVED***
                        ***REMOVED*** if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {***REMOVED*** else { echo '</ul></li>';***REMOVED*** ***REMOVED***
                        <li class="devider"></li>
                        <li><a href="../process/logout.php" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">***REMOVED*** echo _("Log out"); ***REMOVED***</span></a></li>
                        ***REMOVED*** if ($oldcpurl == '' || $supporturl == '') {***REMOVED*** else { echo '<li class="devider"></li>'; ***REMOVED*** ***REMOVED***
                        ***REMOVED*** if ($oldcpurl != '') { echo '<li><a href="' . $oldcpurl . '" class="waves-effect"> <i class="fa fa-tachometer fa-fw"></i> <span class="hide-menu"> ' . _("Control Panel v1") . '</span></a></li>'; ***REMOVED*** ***REMOVED***
                        ***REMOVED*** if ($supporturl != '') { echo '<li><a href="' . $supporturl . '" class="waves-effect" target="_blank"> <i class="fa fa-life-ring fa-fw"></i> <span class="hide-menu">' . _("Support") . '</span></a></li>'; ***REMOVED*** ***REMOVED***
                        </ul>
                </div>
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title">***REMOVED*** echo _("Edit Web Domain"); ***REMOVED***</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="panel"> 
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center>***REMOVED*** echo _("DOMAIN"); ***REMOVED***</center>
                                        </div>
                                        <div class="panel-body">
                                            <center><h2>***REMOVED*** print_r($domainname[0]); ***REMOVED***</h2></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center>***REMOVED*** echo _("CREATED"); ***REMOVED***</center>
                                        </div>
                                        <div class="panel-body">
                                            <center>
                                                <h2>
                                                    ***REMOVED*** $date=date_create($domaindata[0]['DATE'] . ' ' . $domaindata[0]['TIME']); echo date_format($date,"F j, Y - g:i A"); ***REMOVED***
                                                </h2>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center>***REMOVED*** echo _("STATUS"); ***REMOVED***</center>
                                        </div>
                                        <div class="panel-body">
                                            <center>
                                                <h2>
                                                    ***REMOVED*** if ($domaindata[0]['SUSPENDED'] == 'no') {echo _("Active");***REMOVED*** else {echo _("Suspended");***REMOVED******REMOVED***
                                                </h2>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <form class="form-horizontal form-material" autocomplete="off" autocomplete="off" method="post" action="../change/domain.php">
                                    <div class="form-group" style="overflow: visible;">
                                        <label class="col-md-12">***REMOVED*** echo _("IP Address"); ***REMOVED***</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_domain" value="***REMOVED*** echo $requestdomain; ***REMOVED***">
                                            <input type="hidden" name="v_ip-x" value="***REMOVED*** echo $domaindata[0]['IP']; ***REMOVED***">
                                            <select class="form-control select1" name="v_ip" id="select1">
                                                ***REMOVED***
                                                if($userips[0] != '') {
                                                    $x4 = 0; 

                                                    do {
                                                        echo '<option value="' . $userips[$x4] . '">' . $userips[$x4] . '</option>';
                                                        $x4++;
                                                    ***REMOVED*** while ($userips[$x4] != ''); ***REMOVED***

                                                ***REMOVED***
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">***REMOVED*** echo _("Aliases"); ***REMOVED***</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_alias-x" value="***REMOVED*** echo $domaindata[0]['ALIAS']; ***REMOVED***"> 
                                            <textarea class="form-control" rows="4" name="v_alias">***REMOVED*** 
                                                $aliasArray = explode(',', ($domaindata[0]['ALIAS']));

                                                foreach ($aliasArray as &$value) {
                                                    $value = $value . "&#013;&#010;";
                                                ***REMOVED***
                                                foreach($aliasArray as $val) {
                                                    echo $val;
                                                ***REMOVED*** ***REMOVED***</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">***REMOVED*** echo _("Web Template"); ***REMOVED***</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_tpl-x" value="***REMOVED*** echo $domaindata[0]['TPL']; ***REMOVED***">
                                            <select class="form-control select2" name="v_tpl" id="select2">***REMOVED***
                                                if($webtemplates[0] != '') {
                                                    $x1 = 0; 

                                                    do {
                                                        echo '<option value="' . $webtemplates[$x1] . '">' . $webtemplates[$x1] . '</option>';
                                                        $x1++;
                                                    ***REMOVED*** while ($webtemplates[$x1] != ''); ***REMOVED***

                                                ***REMOVED***</select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">***REMOVED*** echo _("Proxy Support"); ***REMOVED***</label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input type="hidden" name="v_prxenabled-x" value="***REMOVED*** if($domaindata[0]['PROXY'] != '') {echo 'yes';***REMOVED*** ***REMOVED***">
                                                <input id="checkbox4" type="checkbox" name="v_prxenabled" onclick="checkDiv();" ***REMOVED*** if($domaindata[0]['PROXY'] != '') {echo 'checked';***REMOVED*** ***REMOVED*** >
                                                <label for="checkbox4"> ***REMOVED*** echo _("Enabled"); ***REMOVED*** </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="prxy-div" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12">***REMOVED*** echo _("Proxy Template"); ***REMOVED***</label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_prxtpl-x" value="***REMOVED*** echo $domaindata[0]['PROXY']; ***REMOVED***">
                                                <select class="form-control select3" name="v_prxtpl" id="select3">
                                                    ***REMOVED***
                                                    if($proxytemplates[0] != '') {
                                                        $x2 = 0; 

                                                        do {
                                                            echo '<option value="' . $proxytemplates[$x2] . '">' . $proxytemplates[$x2] . '</option>';
                                                            $x2++;
                                                        ***REMOVED*** while ($proxytemplates[$x2] != ''); ***REMOVED***

                                                    ***REMOVED***
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">***REMOVED*** echo _("Proxy Extensions"); ***REMOVED***</label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_prxext-x" value="***REMOVED*** echo $domaindata[0]['PROXY_EXT']; ***REMOVED***">
                                                <textarea class="form-control" rows="2" id="prxext" name="v_prxext">***REMOVED*** echo $domaindata[0]['PROXY_EXT']; ***REMOVED***</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">***REMOVED*** echo _("SSL Support"); ***REMOVED***</label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input type="hidden" name="v_sslenabled-x" value="***REMOVED*** echo $domaindata[0]['SSL']; ***REMOVED***">
                                                <input id="checkbox5" type="checkbox" name="v_sslenabled" onclick="checkDiv2();" ***REMOVED*** if($domaindata[0]['SSL'] == 'no') {***REMOVED*** else {echo 'checked';***REMOVED*** ***REMOVED*** >
                                                <label for="checkbox5"> ***REMOVED*** echo _("Enabled"); ***REMOVED*** </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="ssl-div" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12">***REMOVED*** echo _("Let's Encrypt Support"); ***REMOVED***</label>
                                            <div class="col-md-12">
                                                <div class="checkbox checkbox-info">
                                                    <input type="hidden" name="v_leeanbled-x" value="***REMOVED*** echo $domaindata[0]['LETSENCRYPT']; ***REMOVED***">
                                                    <input id="checkbox6" name="v_leenabled" type="checkbox" ***REMOVED*** if($domaindata[0]['LETSENCRYPT'] == 'no') {***REMOVED*** else {echo 'checked';***REMOVED*** ***REMOVED***>
                                                    <label for="checkbox6"> ***REMOVED*** echo _("Enabled"); ***REMOVED*** </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="col-md-12">***REMOVED*** echo _("SSL Directory"); ***REMOVED***</label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_ssldir-x" value="***REMOVED*** echo $domaindata[0]['SSL_HOME']; ***REMOVED***">
                                                <select class="form-control" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static" disabled name="v_ssldir">
                                                    <option value="same" ***REMOVED*** if($domaindata[0]['SSL_HOME'] == 'same') {echo 'selected';***REMOVED*** ***REMOVED***>public_html</option>
                                                    <option value="single" ***REMOVED*** if($domaindata[0]['SSL_HOME'] == 'single') {echo 'selected';***REMOVED*** ***REMOVED***>public_shtml</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">***REMOVED*** echo _("SSL Certificate"); ***REMOVED*** / <a href="../process/generatecsr.php?domain=***REMOVED*** echo $requestdomain; ***REMOVED***">***REMOVED*** echo _("Generate CSR"); ***REMOVED***</a></label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_sslcrt-x" value="***REMOVED*** echo $domaindata[0]['CRT']; ***REMOVED***">
                                                <textarea class="form-control" rows="4" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static" disabled name="v_sslcrt">***REMOVED*** print_r($domainssl[0]['CRT']); ***REMOVED***</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">***REMOVED*** echo _("SSL Key"); ***REMOVED***</label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_sslkey-x" value="***REMOVED*** echo $domaindata[0]['KEY']; ***REMOVED***">
                                                <textarea class="form-control" rows="4" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static" disabled name="v_sslkey">***REMOVED*** print_r($domainssl[0]['KEY']); ***REMOVED***</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">***REMOVED*** echo _("SSL Certificate Authority / Intermediate"); ***REMOVED***</label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_sslca-x" value="***REMOVED*** echo $domaindata[0]['CA']; ***REMOVED***">
                                                <textarea class="form-control" rows="4" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static" disabled name="v_sslca">***REMOVED*** print_r($domainssl[0]['CA']); ***REMOVED***</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-left: 0.1%;display:<? if($domainssl[0]['CRT'] != ''){echo 'block';***REMOVED*** else { echo 'none';***REMOVED*** ***REMOVED***">
                                            <ul class="list-unstyled">
                                                <li>***REMOVED*** echo _("Subject"); ***REMOVED***:  ***REMOVED*** print_r($domainssl[0]['SUBJECT']); ***REMOVED***</li>
                                                <li>***REMOVED*** echo _("Aliases"); ***REMOVED***:  ***REMOVED*** print_r($domainssl[0]['ALIASES']); ***REMOVED***</li>
                                                <li>***REMOVED*** echo _("Not Before"); ***REMOVED***:  ***REMOVED*** print_r($domainssl[0]['NOT_BEFORE']); ***REMOVED***</li>
                                                <li>***REMOVED*** echo _("Not After"); ***REMOVED***:  ***REMOVED*** print_r($domainssl[0]['NOT_AFTER']); ***REMOVED***</li>
                                                <li>***REMOVED*** echo _("Signature"); ***REMOVED***:  ***REMOVED*** print_r($domainssl[0]['SIGNATURE']); ***REMOVED***</li>
                                                <li>***REMOVED*** echo _("Pub Key"); ***REMOVED***:  ***REMOVED*** print_r($domainssl[0]['PUB_KEY']); ***REMOVED***</li>
                                                <li>***REMOVED*** echo _("Issuer"); ***REMOVED***:  ***REMOVED*** print_r($domainssl[0]['ISSUER']); ***REMOVED***</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">***REMOVED*** echo _("Web Statistics"); ***REMOVED***</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_webstats-x" value="***REMOVED*** if ($domaindata[0]['STATS'] == '') {echo 'none'; ***REMOVED*** else { echo $domaindata[0]['STATS']; ***REMOVED*** ***REMOVED***">
                                            <select class="form-control select6" name="v_webstats" onchange="showauth()" id="select6">
                                                ***REMOVED***
                                                if($webstats[0] != '') {
                                                    $x6 = 0; 

                                                    do {
                                                        echo '<option value="' . $webstats[$x6] . '">' . $webstats[$x6] . '</option>';
                                                        $x6++;
                                                    ***REMOVED*** while ($webstats[$x6] != ''); ***REMOVED***

                                                ***REMOVED***
                                            </select>
                                        </div>
                                    </div>
                                    <div id="statsauth" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12">***REMOVED*** echo _("Statistics Authorization"); ***REMOVED***</label>
                                            <div class="col-md-12">
                                                <div class="checkbox checkbox-info">
                                                    <input type="hidden" name="v_statsuserenabled-x" value="***REMOVED*** if($domaindata[0]['STATS_USER'] == '') {echo '';***REMOVED*** else {echo 'yes';***REMOVED*** ***REMOVED***">
                                                    <input id="checkbox10" type="checkbox" name="v_statsuserenabled" ***REMOVED*** if($domaindata[0]['STATS_USER'] != '') {echo 'checked';***REMOVED*** ***REMOVED*** onclick="checkDiv4();">
                                                    <label for="checkbox10"> ***REMOVED*** echo _("Enabled"); ***REMOVED*** </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="stats-div" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12">***REMOVED*** echo _("Username"); ***REMOVED***</label><br>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_statsuname-x" value="***REMOVED*** echo $domaindata[0]['STATS_USER']; ***REMOVED***">
                                                <input type="text" name="v_statsuname" autocomplete="new-password" class="form-control" value="***REMOVED*** echo $domaindata[0]['STATS_USER']; ***REMOVED***"> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="v_statspassword" class="col-md-12">***REMOVED*** echo _("Password"); ***REMOVED*** / <a style="cursor:pointer" onclick="generatePassword2(10)"> ***REMOVED*** echo _("Generate"); ***REMOVED***</a></label>
                                            <div class="col-md-12 input-group" style="padding-left: 15px;">
                                                <input type="password" autocomplete="new-password" class="form-control form-control-line" name="v_statspassword" id="statspassword">                                    <span class="input-group-btn"> 
                                                <button class="btn btn-info" style="margin-right: 15px;" name="Show" onclick="toggler2(this)" id="tg2" type="button"><i class="ti-eye"></i></button> 
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    ***REMOVED***
                                    $ftpuser = explode(':', ($domaindata[0]['FTP_USER'])); 
                                    $ftpdir = explode(':', ($domaindata[0]['FTP_PATH'])); 
                                    ***REMOVED***
                                    <div class="form-group">
                                        <label class="col-md-12">***REMOVED*** echo _("Additional FTP"); ***REMOVED***</label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input type="hidden" name="v_additionalftpenabled-x" value="***REMOVED*** if($ftpuser[0]) {echo 'yes';***REMOVED*** else { echo 'no'; ***REMOVED******REMOVED***">
                                                <input id="checkbox9" disabled type="checkbox" name="v_addittionalftpenabled" ***REMOVED*** if($ftpuser[0]) {echo 'checked';***REMOVED*** ***REMOVED*** onclick="checkDiv3();">
                                                <label for="checkbox9"> ***REMOVED*** echo _("Enabled"); ***REMOVED*** </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="ftp-div" style="margin-left: 4%;">

                                        <div class="form-group">
                                            <label class="col-md-12">***REMOVED*** echo _("Username"); ***REMOVED***</label><br>
                                            <div class="col-md-12">
                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <div class="input-group-addon">***REMOVED*** print_r($uname); ***REMOVED***_</div>
                                                    <input type="hidden" name="v_ftpuname-x" value="***REMOVED*** $prefix = $uname . '_'; $str = $ftpuser[0]; if (substr($str, 0, strlen($prefix)) == $prefix) { $str = substr($str, strlen($prefix));***REMOVED*** print_r($str); ***REMOVED***">
                                                    <input type="text" class="form-control" name="v_ftpuname" value="***REMOVED*** $prefix = $uname . '_'; $str = $ftpuser[0]; if (substr($str, 0, strlen($prefix)) == $prefix) { $str = substr($str, strlen($prefix));***REMOVED*** print_r($str); ***REMOVED***" style="padding-left: 0.5%;">    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-md-12">***REMOVED*** echo _("Password"); ***REMOVED*** / <a style="cursor:pointer" onclick="generatePassword(10)"> ***REMOVED*** echo _("Generate"); ***REMOVED***</a></label>
                                            <div class="col-md-12 input-group" style="padding-left: 15px;">
                                                <input type="password" class="form-control form-control-line" name="password" id="password">                                    <span class="input-group-btn"> 
                                                <button class="btn btn-info" style="margin-right: 15px;" name="Show" onclick="toggler(this)" id="tg" type="button"><i class="ti-eye"></i></button> 
                                                </span>  </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">***REMOVED*** echo _("Path"); ***REMOVED***</label>
                                            <div class="col-md-12">
                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <input type="hidden" name="v_ftpdir-x" value="***REMOVED*** echo $ftpdir[0]; ***REMOVED***">
                                                    <div class="input-group-addon">/home/***REMOVED*** print_r($uname); ***REMOVED***/web/***REMOVED*** print_r($requestdomain); ***REMOVED***/</div>
                                                    <input type="text" class="form-control" name="v_ftpdir" value="***REMOVED*** echo $ftpdir[0]; ***REMOVED***" style="padding-left: 0.5%;">    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" type="submit">***REMOVED*** echo _("Update Domain"); ***REMOVED***</button> &nbsp;
                                            <a href="../list/web.php" style="color: inherit;text-decoration: inherit;"><button class="btn btn-muted" type="button">***REMOVED*** echo _("Back"); ***REMOVED***</button></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer text-center">&copy; ***REMOVED*** echo _("Copyright"); ***REMOVED*** ***REMOVED*** echo date("Y") . ' ' . $sitetitle; ***REMOVED***. ***REMOVED*** echo _("All Rights Reserved. Vesta Web Interface"); ***REMOVED*** ***REMOVED*** require '../includes/versioncheck.php'; ***REMOVED*** ***REMOVED*** echo _("by CDG Web Services"); ***REMOVED***.</footer>
            </div>
        </div>
        <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../plugins/bower_components/toast-master/js/jquery.toast.js"></script>
        <script src="../bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
        <script src="../js/jquery.slimscroll.js"></script>
        <script src="../js/waves.js"></script>
        <script src="../plugins/bower_components/moment/moment.js"></script>
        <script src="../plugins/bower_components/footable/js/footable.min.js"></script>
        <script src="../plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="../plugins/bower_components/custom-select/custom-select.min.js"></script>
        <script src="../js/footable-init.js"></script>
        <script src="../js/custom.js"></script>
        <script src="../js/dashboard1.js"></script>
        <script src="../js/cbpFWTabs.js"></script>
        <script src="../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.js"></script>
        <script type="text/javascript">
            (function () {
                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                    new CBPFWTabs(el);
                ***REMOVED***);
            ***REMOVED***)();

            document.getElementById('select1').value = '***REMOVED*** print_r($domaindata[0]['IP']); ***REMOVED***'; 
            document.getElementById('select2').value = '***REMOVED*** print_r($domaindata[0]['TPL']); ***REMOVED***'; 

            if ('<? print_r($domaindata[0]['PROXY']); ***REMOVED***' == '') {  document.getElementById('select3').value = 'default';  ***REMOVED***
            else { document.getElementById('select3').value = '<? print_r($domaindata[0]['PROXY']); ***REMOVED***'; ***REMOVED***
            if ('<? print_r($domaindata[0]['PROXY_EXT']); ***REMOVED***' == '') {  document.getElementById('prxext').value = 'jpeg, jpg, png, gif, bmp, ico, svg, tif, tiff, css, js, htm, html, ttf, otf, webp, woff, txt, csv, rtf, doc, docx, xls, xlsx, ppt, pptx, odf, odp, ods, odt, pdf, psd, ai, eot, eps, ps, zip, tar, tgz, gz, rar, bz2, 7z, aac, m4a, mp3, mp4, ogg, wav, wma, 3gp, avi, flv, m4v, mkv, mov, mp4, mpeg, mpg, wmv, exe, iso, dmg, swf';  ***REMOVED***
            else { document.getElementById('prxext').value = '<? print_r($domaindata[0]['PROXY_EXT']); ***REMOVED***'; ***REMOVED***
            if ('<? print_r($domaindata[0]['STATS']); ***REMOVED***' == '') {  document.getElementById('select6').value = 'none';  ***REMOVED***
            else { document.getElementById('select6').value = '<? print_r($domaindata[0]['STATS']); ***REMOVED***'; ***REMOVED***

            function showauth(){
                if(document.getElementById('select6').value != 'none') {
                    document.getElementById('statsauth').style.display = "block";
                ***REMOVED***
                else {
                    document.getElementById('statsauth').style.display = "none";
                ***REMOVED******REMOVED***
            function checkDiv(){
                if(document.getElementById("checkbox4").checked) {
                    document.getElementById('prxy-div').style.display = 'block';
                ***REMOVED***
                else {document.getElementById('prxy-div').style.display = 'none';***REMOVED***
            ***REMOVED***
            function checkDiv2(){
                if(document.getElementById("checkbox5").checked) {
                    document.getElementById('ssl-div').style.display = 'block';
                ***REMOVED***
                else {document.getElementById('ssl-div').style.display = 'none';***REMOVED***
            ***REMOVED***
            function checkDiv3(){
                if(document.getElementById("checkbox9").checked) {
                    document.getElementById('ftp-div').style.display = 'block';
                ***REMOVED***
                else {document.getElementById('ftp-div').style.display = 'none';***REMOVED***
            ***REMOVED***
            function checkDiv4(){
                if(document.getElementById("checkbox10").checked) {
                    document.getElementById('stats-div').style.display = 'block';
                ***REMOVED***
                else {document.getElementById('stats-div').style.display = 'none';***REMOVED***
            ***REMOVED***
            function toggle_visibility(id) {
                var e = document.getElementById(id);
                if(e.style.display == 'block')
                    e.style.display = 'none';
                else
                    e.style.display = 'block';
            ***REMOVED***
            function toggler(e) {
                if( e.name == 'Hide' ) {
                    e.name = 'Show'
                    document.getElementById('password').type="password";
                ***REMOVED*** else {
                    e.name = 'Hide'
                    document.getElementById('password').type="text";
                ***REMOVED***
            ***REMOVED***
            function toggler2(e) {
                if( e.name == 'Hide' ) {
                    e.name = 'Show'
                    document.getElementById('statspassword').type="password";
                ***REMOVED*** else {
                    e.name = 'Hide'
                    document.getElementById('statspassword').type="text";
                ***REMOVED***
            ***REMOVED***
            function generatePassword(length) {
                var password = '', character; 
                while (length > password.length) {
                    if (password.indexOf(character = String.fromCharCode(Math.floor(Math.random() * 94) + 33), Math.floor(password.length / 94) * 94) < 0) {
                        password += character;
                    ***REMOVED***
                ***REMOVED***
                document.getElementById('password').value = password;
                document.getElementById('tg').name='Hide';
                document.getElementById('password').type="text";
                fillSpan();
            ***REMOVED***
            function generatePassword2(length) {
                var password = '', character; 
                while (length > password.length) {
                    if (password.indexOf(character = String.fromCharCode(Math.floor(Math.random() * 94) + 33), Math.floor(password.length / 94) * 94) < 0) {
                        password += character;
                    ***REMOVED***
                ***REMOVED***
                document.getElementById('statspassword').value = password;
                document.getElementById('tg2').name='Hide';
                document.getElementById('statspassword').type="text";
                fillSpan();
            ***REMOVED***
            jQuery(function($){
                $('.footable').footable();
            ***REMOVED***);
        </script>
    </body>

</html>