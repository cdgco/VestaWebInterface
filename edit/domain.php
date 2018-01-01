***REMOVED***

require '../includes/config.php';

if(base64_decode($_COOKIE['loggedin']) == 'true') {***REMOVED***
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
$useremail = $admindata[CONTACT];
$domainname = array_keys(json_decode(curl_exec($curl1), true));
$domaindata = array_values(json_decode(curl_exec($curl1), true));
$webtemplates = array_values(json_decode(curl_exec($curl2), true));
$proxytemplates = array_values(json_decode(curl_exec($curl3), true));
$userips = array_keys(json_decode(curl_exec($curl4), true));
$domainssl = array_values(json_decode(curl_exec($curl5), true));
$webstats = array_values(json_decode(curl_exec($curl6), true));

if ($domainname[0] == '') { header('Location: ../list/web.php'); ***REMOVED***
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
        <title>***REMOVED*** echo $sitetitle; ***REMOVED*** - Web</title>
        <link href="../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
        <link href="../plugins/bower_components/footable/css/footable.bootstrap.css" rel="stylesheet">
        <link href="../plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
        <link href="../css/animate.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/colors/blue.css" id="theme" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.min.css" />
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
                                <li><a href="../profile.php"><i class="ti-home"></i> My Account</a></li>
                                <li><a href="../profile.php?settings=open"><i class="ti-settings"></i> Account Setting</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../process/logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
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
                            <span class="hide-menu">Navigation</span>
                        </h3>  
                    </div>
                    <ul class="nav" id="side-menu">
                        <li> <a href="../index.php" class="waves-effect"><i class="mdi mdi-home fa-fw"></i> <span class="hide-menu">Dashboard</span></a> </li>
                        <li class="devider"></li>
                        <li>
                            <a active href="#" class="waves-effect"><i class="ti-user fa-fw"></i><span class="hide-menu"> ***REMOVED*** print_r($uname); ***REMOVED***<span class="fa arrow"></span></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li> <a href="../profile.php"><i class="ti-home fa-fw"></i> <span class="hide-menu"> My Account</span></a></li>
                                <li> <a active href="../profile.php?settings=open"><i class="ti-settings fa-fw"></i> <span class="hide-menu"> Account Setting</span></a></li>
                            </ul>
                        </li>
                        <li class="devider"></li>
                        <li class="active"> <a href="#" class="awaves-effect"><i class="mdi mdi-av-timer fa-fw" aria-expanded="true" data-icon="v"></i> <span class="hide-menu">Management <span class="fa arrow"></span> </span></a>
                            <ul class="nav nav-second-level">
                                <li> <a href="../list/web.php" class="active"><i class="ti-world fa-fw"></i><span class="hide-menu">Web</span></a> </li>
                                <li> <a href="../list/dns.php"><i class="fa fa-sitemap fa-fw"></i><span class="hide-menu">DNS</span></a> </li>
                                <li> <a href="../list/mail.php"><i class="fa fa-envelope fa-fw"></i><span class="hide-menu">Mail</span></a> </li>
                                <li> <a href="../list/db.php"><i class="fa fa-database fa-fw"></i><span class="hide-menu">Database</span></a> </li>
                            </ul>
                        </li>
                        <li> <a href="../list/cron.php" class="waves-effect"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">Cron Jobs</span></a> </li>
                        <li> <a href="../list/backups.php" class="waves-effect"><i  class="fa fa-cloud-upload fa-fw"></i> <span class="hide-menu">Backups</span></a> </li>   
                        <li class="devider"></li>                
                        <li><a href="#" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">Apps<span class="fa arrow"></span></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="https://webftp.cdgtech.one"><i class="fa fa-file-code-o fa-fw"></i><span class="hide-menu">FTP</span></a></li>
                                <li><a href="https://usermail.cdgtech.one"><i class="fa fa-envelope-o fa-fw"></i><span class="hide-menu">Webmail</span></a></li>
                                <li><a href="https://host.cdgtech.one/phpmyadmin"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">phpMyAdmin</span></a></li>

                            </ul>
                        </li>
                        <li class="devider"></li>
                        <li><a href="../process/logout.php" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">Log out</span></a></li>
                        <li class="devider"></li>
                        <li><a href="https://host.cdgtech.one:8083" class="waves-effect"> <i class="fa fa-tachometer fa-fw"></i> <span class="hide-menu"> Control Panel v1</span></a></li>
                        <li><a href="http://cdgsupport.epizy.com" class="waves-effect"> <i class="fa fa-life-ring fa-fw"></i> <span class="hide-menu">Support</span></a></li>
                    </ul>
                </div>
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title">Edit Web Domain</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="panel"> 
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center>DOMAIN</center>
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
                                            <center>CREATED</center>
                                        </div>
                                        <div class="panel-body">
                                            <center>
                                                <h2>
                                                    ***REMOVED*** $date=date_create($domaindata[0][DATE] . ' ' . $domaindata[0][TIME]); echo date_format($date,"F j, Y - g:i A"); ***REMOVED***
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
                                            <center>STATUS</center>
                                        </div>
                                        <div class="panel-body">
                                            <center>
                                                <h2>
                                                    ***REMOVED*** if ($domaindata[0][SUSPENDED] == 'no') {echo 'Active';***REMOVED*** else {echo 'Suspended';***REMOVED******REMOVED***
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
                                <form class="form-horizontal form-material" autocomplete="off">
                                    <div class="form-group" style="overflow: visible;">
                                        <label class="col-md-12">IP Address</label>
                                        <div class="col-md-12">
                                            <select class="form-control select1" name="language" id="select1">
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
                                        <label class="col-md-12">Aliases</label>
                                        <div class="col-md-12">
                                            <textarea class="form-control" rows="4" id="aliasTextArea">
                                                ***REMOVED*** $aliasArray = explode(',', ($domaindata[0][ALIAS]));

                                                foreach ($aliasArray as &$value) {
                                                    $value = $value . "&#013;&#010;";
                                                ***REMOVED***
                                                foreach($aliasArray as $val) {
                                                    echo $val;
                                                ***REMOVED*** ***REMOVED***
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Web Template</label>
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="language" id="select2">
                                                ***REMOVED***
                                                if($webtemplates[0] != '') {
                                                    $x1 = 0; 

                                                    do {
                                                        echo '<option value="' . $webtemplates[$x1] . '">' . $webtemplates[$x1] . '</option>';
                                                        $x1++;
                                                    ***REMOVED*** while ($webtemplates[$x1] != ''); ***REMOVED***

                                                ***REMOVED***
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Proxy Support</label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input id="checkbox4" type="checkbox" onclick="checkDiv();" ***REMOVED*** if($domaindata[0][PROXY] == '') {***REMOVED*** else {echo 'checked';***REMOVED*** ***REMOVED*** >
                                                <label for="checkbox4"> Enabled </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="prxy-div" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12">Proxy Template</label>
                                            <div class="col-md-12">
                                                <select class="form-control select3" name="language" id="select3">
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
                                            <label class="col-md-12">Proxy Extensions</label>
                                            <div class="col-md-12">
                                                <textarea class="form-control" rows="2" id="prxTextArea">
                                                    ***REMOVED*** echo $domaindata[0][PROXY_EXT]; ***REMOVED***
                                                </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">SSL Support</label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input id="checkbox5" type="checkbox" onclick="checkDiv2();" ***REMOVED*** if($domaindata[0][SSL] == 'no') {***REMOVED*** else {echo 'checked';***REMOVED*** ***REMOVED*** >
                                                <label for="checkbox5"> Enabled </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="ssl-div" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12">Let's Encrypt Support</label>
                                            <div class="col-md-12">
                                                <div class="checkbox checkbox-info">
                                                    <input id="checkbox6" type="checkbox">
                                                    <label for="checkbox6"> Enabled </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="col-md-12">SSL Directory</label>
                                            <div class="col-md-12">
                                                <select class="form-control select3" name="language" id="select3">
                                                    <option value="public_html" ***REMOVED*** if($domaindata[0][SSL_HOME] == 'same') {echo 'selected';***REMOVED*** ***REMOVED***>public_html</option>
                                                    <option value="public_shtml" ***REMOVED*** if($domaindata[0][SSL_HOME] == 'single') {echo 'selected';***REMOVED*** ***REMOVED***>public_shtml</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">SSL Certificate / <a href="../process/generatecsr.php?domain=***REMOVED*** echo $requestdomain; ***REMOVED***">Generate CSR</a></label>
                                            <div class="col-md-12">
                                                <textarea class="form-control" rows="4" id="crtTextArea">
                                                    ***REMOVED*** print_r($domainssl[0][CRT]); ***REMOVED***</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">SSL Key</label>
                                            <div class="col-md-12">
                                                <textarea class="form-control" rows="4" id="keyTextArea">
                                                    ***REMOVED*** print_r($domainssl[0][KEY]); ***REMOVED***</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">SSL Certificate Authority / Intermediate</label>
                                            <div class="col-md-12">
                                                <textarea class="form-control" rows="4" id="caTextArea">
                                                    ***REMOVED*** print_r($domainssl[0][CA]); ***REMOVED***</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-left: 0.1%;display:<? if($domainssl[0][CRT] != ''){echo 'block';***REMOVED*** else { echo 'none';***REMOVED*** ***REMOVED***">
                                            <ul class="list-unstyled">
                                                <li>Subject:  ***REMOVED*** print_r($domainssl[0][SUBJECT]); ***REMOVED***</li>
                                                <li>Aliases:  ***REMOVED*** print_r($domainssl[0][ALIASES]); ***REMOVED***</li>
                                                <li>Not Before:  ***REMOVED*** print_r($domainssl[0][NOT_BEFORE]); ***REMOVED***</li>
                                                <li>Not After:  ***REMOVED*** print_r($domainssl[0][NOT_AFTER]); ***REMOVED***</li>
                                                <li>Signature:  ***REMOVED*** print_r($domainssl[0][SIGNATURE]); ***REMOVED***</li>
                                                <li>Pub Key:  ***REMOVED*** print_r($domainssl[0][PUB_KEY]); ***REMOVED***</li>
                                                <li>Issuer:  ***REMOVED*** print_r($domainssl[0][ISSUER]); ***REMOVED***</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Web Statistics</label>
                                        <div class="col-md-12">
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
                                            <label class="col-md-12">Statistics Authorization</label>
                                            <div class="col-md-12">
                                                <div class="checkbox checkbox-info">
                                                    <input id="checkbox10" type="checkbox" ***REMOVED*** if($domaindata[0][STATS_USER] != '') {echo 'checked';***REMOVED*** ***REMOVED*** onclick="checkDiv4();">
                                                    <label for="checkbox10"> Enabled </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="stats-div" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12">Username</label><br>
                                            <div class="col-md-12">
                                                <input type="text" name="v_statsuname" autocomplete="new-password" class="form-control" value="***REMOVED*** echo $domaindata[0][STATS_USER]; ***REMOVED***"> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="v_statspassword" class="col-md-12">Password / <a style="cursor:pointer" onclick="generatePassword2(10)"> Generate</a></label>
                                            <div class="col-md-12 input-group" style="padding-left: 15px;">
                                                <input type="password" autocomplete="new-password" class="form-control form-control-line" name="v_statspassword" id="statspassword">                                    <span class="input-group-btn"> 
                                                <button class="btn btn-info" style="margin-right: 15px;" name="Show" onclick="toggler2(this)" id="tg2" type="button"><i class="ti-eye"></i></button> 
                                                </span>  
                                            </div>
                                        </div>
                                    </div>
                                    ***REMOVED***
                                    $ftpuser = explode(':', ($domaindata[0][FTP_USER])); 
                                    $ftpdir = explode(':', ($domaindata[0][FTP_PATH])); 
                                    ***REMOVED***
                                    <div class="form-group">
                                        <label class="col-md-12">Additional FTP</label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input id="checkbox9" type="checkbox" ***REMOVED*** if($ftpuser[0]) {echo 'checked';***REMOVED*** ***REMOVED*** onclick="checkDiv3();">
                                                <label for="checkbox9"> Enabled </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="ftp-div" style="margin-left: 4%;">

                                        <div class="form-group">
                                            <label class="col-md-12">Username</label><br>
                                            <div class="col-md-12">
                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <div class="input-group-addon">***REMOVED*** print_r($uname); ***REMOVED***_</div>
                                                    <input type="text" class="form-control" value="***REMOVED*** $prefix = $uname . '_'; $str = $ftpuser[0]; if (substr($str, 0, strlen($prefix)) == $prefix) { $str = substr($str, strlen($prefix));***REMOVED*** print_r($str); ***REMOVED***" style="padding-left: 0.5%;">    
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-md-12">Password / <a style="cursor:pointer" onclick="generatePassword(10)"> Generate</a></label>
                                            <div class="col-md-12 input-group" style="padding-left: 15px;">
                                                <input type="password" class="form-control form-control-line" name="password" id="password">                                    <span class="input-group-btn"> 
                                                <button class="btn btn-info" style="margin-right: 15px;" name="Show" onclick="toggler(this)" id="tg" type="button"><i class="ti-eye"></i></button> 
                                                </span>  </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Path</label>
                                            <div class="col-md-12">
                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <div class="input-group-addon">/home/***REMOVED*** print_r($uname); ***REMOVED***/web/***REMOVED*** print_r($requestdomain); ***REMOVED***</div>
                                                    <input type="text" class="form-control" value="***REMOVED*** echo $ftpdir[0]; ***REMOVED***" style="padding-left: 0.5%;">    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button disabled class="btn btn-success">Update Domain</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer text-center">&copy; Copyright ***REMOVED*** echo date("Y") . ' ' . $sitetitle; ***REMOVED***. All Rights Reserved. Powered by VestaCP, CDG Web Services, & WrapPixel.</footer>
            </div>
        </div>
        <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
        <script src="../js/jquery.slimscroll.js"></script>
        <script src="../js/waves.js"></script>
        <script src="../plugins/bower_components/moment/moment.js"></script>
        <script src="../plugins/bower_components/footable/js/footable.min.js"></script>
        <script src="../plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="../plugins/bower_components/custom-select/custom-select.min.js"></script>
        <script src="../js/footable-init.js"></script>
        <script src="../js/custom.min.js"></script>
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

            var myTxtArea = document.getElementById('aliasTextArea');
            var myTxtArea2 = document.getElementById('prxTextArea');
            var myTxtArea3 = document.getElementById('crtTextArea');
            var myTxtArea4 = document.getElementById('keyTextArea');
            var myTxtArea5 = document.getElementById('caTextArea');

            myTxtArea.value = myTxtArea.value.replace(/^\s*|\s*$/g,'');
            myTxtArea2.value = myTxtArea2.value.replace(/^\s*|\s*$/g,'');
            myTxtArea3.value = myTxtArea3.value.replace(/^\s*|\s*$/g,'');
            myTxtArea4.value = myTxtArea4.value.replace(/^\s*|\s*$/g,'');
            myTxtArea5.value = myTxtArea5.value.replace(/^\s*|\s*$/g,'');

            document.getElementById('select2').value = '<? print_r($domaindata[0][TPL]); ***REMOVED***'; 

            if ('<? print_r($domaindata[0][PROXY]); ***REMOVED***' == '') {  document.getElementById('select3').value = 'default';  ***REMOVED***
            else { document.getElementById('select3').value = '<? print_r($domaindata[0][PROXY]); ***REMOVED***'; ***REMOVED***
            if ('<? print_r($domaindata[0][PROXY_EXT]); ***REMOVED***' == '') {  document.getElementById('select3').value = 'jpg,jpeg,gif,png,ico,svg,css,zip,tgz,gz,rar,bz2,doc,xls,exe,pdf,ppt,txt,odt,ods,odp,odf,tar,wav,bmp,rtf,js,mp3,avi,mpeg,flv,html,htm';  ***REMOVED***
            else { document.getElementById('select3').value = '<? print_r($domaindata[0][PROXY]); ***REMOVED***'; ***REMOVED***
            if ('<? print_r($domaindata[0][STATS]); ***REMOVED***' == '') {  document.getElementById('select6').value = 'none';  ***REMOVED***
            else { document.getElementById('select6').value = '<? print_r($domaindata[0][STATS]); ***REMOVED***'; ***REMOVED***
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
            function confirmDelete(e){
                e1 = String(e)
                swal({
                    title: 'Delete Web Domain:<br>' + e1 +' ?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                ***REMOVED***).then(function () {
                    swal({
                        title: 'Processing',
                        text: '',
                        timer: 5000,
                        onOpen: function () {
                            swal.showLoading()
                        ***REMOVED***
                    ***REMOVED***).then(
                        function () {***REMOVED***,
                        // handling the promise rejection
                        function (dismiss) {
                            if (dismiss === 'timer') {
                                console.log('I was closed by the timer')
                            ***REMOVED***
                        ***REMOVED***
                    )
                    $.ajax({  
                        type: "GET",  
                        url: "../delete/domain.php",  
                        data: { 'domain':e1, 'verified':'yes' ***REMOVED***,
                        success:  function(){ window.location = "web.php?delcode=0"; ***REMOVED***,
                        error:  function(){ window.location = "web.php?delcode=0"; ***REMOVED***
                    ***REMOVED***)
                ***REMOVED***)***REMOVED***

            ***REMOVED*** if($_GET['delcode'] == "0"){ echo "swal({title:'Successfully Deleted!', type:'success'***REMOVED***);";***REMOVED*** ***REMOVED***
        </script>
    </body>

</html>