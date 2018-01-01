<?php

require '../includes/config.php';

if(base64_decode($_COOKIE['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

$requestdomain = $_GET['domain'];
$requestaccount = $_GET['account'];

if (isset($requestdomain) && $requestdomain != '' && isset($requestaccount) && $requestaccount != '') {}
else { header('Location: ../list/mail.php'); }

$postvars = array(
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-mail-account','arg1' => $username,'arg2' => $requestdomain, 'arg3' => $requestaccount, 'arg4' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-mail-account-autoreply','arg1' => $username,'arg2' => $requestdomain, 'arg3' => $requestaccount, 'arg4' => 'json'));


$curl0 = curl_init();
$curl1 = curl_init();
$curl2 = curl_init();
$curlstart = 0; 

while($curlstart <= 2) {
    curl_setopt(${'curl' . $curlstart}, CURLOPT_URL, $vst_url);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_RETURNTRANSFER,true);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_POST, true);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
    $curlstart++;
} 

$admindata = json_decode(curl_exec($curl0), true)[$username];
$useremail = $admindata[CONTACT];
$maildata = array_values(json_decode(curl_exec($curl1), true));
$mailname = array_keys(json_decode(curl_exec($curl1), true));
$autoreplydata = array_values(json_decode(curl_exec($curl2), true));
$autoreplyname = array_keys(json_decode(curl_exec($curl2), true));
/* if ($mailname[0] == '') { header('Location: ../list/mail.php'); } */
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/ico" href="../plugins/images/favicon.ico">
        <title><?php echo $sitetitle; ?> - MAIL</title>
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

    <body class="fix-header" onload="checkDiv();">
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
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"><b class="hidden-xs"><?php print_r($uname); ?></b><span class="caret"></span> </a>
                            <ul class="dropdown-menu dropdown-user animated flipInY">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-text">
                                            <h4><?php print_r($uname); ?></h4>
                                            <p class="text-muted"><?php print_r($useremail); ?></p></div>
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
                            <a active href="#" class="waves-effect"><i class="ti-user fa-fw"></i><span class="hide-menu"> <?php print_r($uname); ?><span class="fa arrow"></span></span></a>
                            <ul class="nav nav-second-level collapse">
                                <li> <a href="../profile.php"><i class="ti-home fa-fw"></i> <span class="hide-menu"> My Account</span></a></li>
                                <li> <a active href="../profile.php?settings=open"><i class="ti-settings fa-fw"></i> <span class="hide-menu"> Account Setting</span></a></li>
                            </ul>
                        </li>
                        <li class="devider"></li>
                        <li class="active"> <a href="#" class="awaves-effect"><i class="mdi mdi-av-timer fa-fw" aria-expanded="true" data-icon="v"></i> <span class="hide-menu">Management <span class="fa arrow"></span> </span></a>
                            <ul class="nav nav-second-level">
                                <li> <a href="../list/web.php"><i class="ti-world fa-fw"></i><span class="hide-menu">Web</span></a> </li>
                                <li> <a href="../list/dns.php"><i class="fa fa-sitemap fa-fw"></i><span class="hide-menu">DNS</span></a> </li>
                                <li> <a href="../list/mail.php" class="active"><i class="fa fa-envelope fa-fw"></i><span class="hide-menu">Mail</span></a> </li>
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
                        <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title">Edit Mail Account - <? echo $requestaccount . '@' . $requestdomain; ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center>CREATED</center>
                                        </div>
                                        <div class="panel-body">
                                            <center>
                                                <h2>
                                                    <?php $date=date_create($maildata[0][DATE] . ' ' . $maildata[0][TIME]); echo date_format($date,"F j, Y - g:i A"); ?>
                                                </h2>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center>STATUS</center>
                                        </div>
                                        <div class="panel-body">
                                            <center>
                                                <h2>
                                                    <?php if ($maildata[0][SUSPENDED] == 'no') {echo 'Active';} else {echo 'Suspended';}?>
                                                </h2>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-xs-12">
                            <div class="white-box">
                                <form class="form-horizontal form-material" method="post">
                                    <div class="form-group">
                                        <label class="col-md-12">Email Address</label>
                                        <div class="col-md-12">
                                            <input type="text" disabled value="<? echo $requestaccount . '@' . $requestdomain; ?>" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static"> 
                                            <input type="hidden" name="v_domain" value="<? echo $requestdomain; ?>"> 
                                            <input type="hidden" name="v_account" value="<? echo $requestaccount; ?>"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-md-12">Password / <a style="cursor:pointer" onclick="generatePassword(10)"> Generate</a></label>
                                        <div class="col-md-12 input-group" style="padding-left: 15px;">
                                            <input type="password" onkeyup="fillSpan()" class="form-control form-control-line" name="password" id="password">                                    <span class="input-group-btn"> 
                                            <button class="btn btn-info" style="margin-right: 15px;" name="Show" onclick="toggler(this)" id="tg" type="button"><i class="ti-eye"></i></button> 
                                            </span>  </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-md-12">Quota</label>
                                        <div class="col-md-12">
                                            <input type="text" disabled value="<? print_r($maildata[0][QUOTA]); ?>" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static"> 
                                            <small class="form-text text-muted">In Megabytes</small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Aliases</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_alias-x" value="<?php $aliasArray = explode(',', ($maildata[0][ALIAS]));foreach ($aliasArray as &$value) {$value = $value . "&#013;&#010;";} foreach($aliasArray as $val) {echo $val;}?>">
                                            <textarea class="form-control" name="v_alias" rows="4" id="aliasTextArea"><?php $aliasArray = explode(',', ($maildata[0][ALIAS]));foreach ($aliasArray as &$value) {$value = $value . "&#013;&#010;";} foreach($aliasArray as $val) {echo $val;}?></textarea>
                                            <small class="form-text text-muted">Use Local-Part</small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Forward To</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_forward-x" value="<?php $fwdArray = explode(',', ($maildata[0][FWD]));foreach ($fwdArray as &$value1) {$value1 = $value1. "&#013;&#010;";}foreach($fwdArray as $val1){echo $val1;}?>">
                                            <textarea class="form-control" name="v_forward" rows="4" id="forwardTextArea"><?php $fwdArray = explode(',', ($maildata[0][FWD]));foreach ($fwdArray as &$value1) {$value1 = $value1. "&#013;&#010;";}foreach($fwdArray as $val1){echo $val1;}?></textarea>
                                            <small class="form-text text-muted">One Or More Email Addresses</small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Don't Store Forwarded Mail</label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input type="hidden" name="v_fwd_to_x" value="<?php echo $maildata[0][FWD_ONLY]; ?>">
                                                <input id="checkbox4" name="v_fwd_to" type="checkbox" <?php if($maildata[0][FWD_ONLY] == 'yes') {echo 'checked';} ?> >
                                                <label for="checkbox4"> Enabled </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Autoreply</label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input type="hidden" name="v_autoreply-x" value="<?php echo $maildata[0][AUTOREPLY]; ?>">
                                                <input id="checkbox5" name="v_autoreply" type="checkbox" onclick="checkDiv();" <?php if($maildata[0][AUTOREPLY] == 'yes') {echo 'checked';} ?> >
                                                <label for="checkbox5"> Enabled </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="msg-div" style="margin-left: 4%;">
                                        <label class="col-md-12">Message</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_message_x" value="<?php $aliasArray = explode(',', ($autoreplydata[0][MSG]));
                                                foreach ($aliasArray as &$value) {
                                                    echo str_replace("\r\n", "\n", $value);
                                                } ?>">
                                            <textarea class="form-control" name="v_message" rows="4"><?php $aliasArray = explode(',', ($autoreplydata[0][MSG]));
                                                foreach ($aliasArray as &$value) {
                                                    echo str_replace("\r\n", "\n", $value);
                                                } ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button disabled class="btn btn-success">Update Account</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12">
                            <div class="white-box">
                                <div> 
                                    <center> <h3>
                                        Authentication Settings
                                        </h3></center><br>
                                    <div class="overlay-box" style="background: #fff;">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a  href="#1" data-toggle="tab">Use Server Hostname</a>
                                            </li>
                                            <li><a href="#2" data-toggle="tab">Use Domain Hostname </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content ">
                                            <div class="tab-pane active" id="1">
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a  href="#3" data-toggle="tab">TLS</a>
                                                    </li>
                                                    <li><a href="#4" data-toggle="tab">SSL</a>
                                                    </li>
                                                    <li><a href="#5" data-toggle="tab">No Authentication</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content ">
                                                    <div class="tab-pane active" id="3">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    Username:	<br>   
                                                                    Password:	<br>
                                                                    IMAP hostname:	<br>
                                                                    IMAP port:	<br>
                                                                    IMAP security:	<br>
                                                                    IMAP auth method:<br>
                                                                    SMTP hostname:<br>
                                                                    SMTP port:	<br>
                                                                    SMTP security:<br>	
                                                                    SMTP auth method:	<br>
                                                                    Webmail URL:	<br>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <p>
                                                                    <? echo $requestaccount . '@' . $requestdomain; ?><br>   
                                                                    <span class="mailPW"></span><br>
                                                                    <? echo VESTA_HOST_ADDRESS; ?><br>
                                                                    143<br>
                                                                    STARTTLS<br>
                                                                    Normal Password<br>
                                                                    <? echo VESTA_HOST_ADDRESS; ?><br>
                                                                    587<br>
                                                                    STARTTLS<br>	
                                                                    Normal Password	<br>
                                                                    <a href="<? echo $webmailurl; ?>"><? echo $webmailurl; ?></a><br>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="4">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    Username:	<br>   
                                                                    Password:	<br>
                                                                    IMAP hostname:	<br>
                                                                    IMAP port:	<br>
                                                                    IMAP security:	<br>
                                                                    IMAP auth method:<br>
                                                                    SMTP hostname:<br>
                                                                    SMTP port:	<br>
                                                                    SMTP security:<br>	
                                                                    SMTP auth method:	<br>
                                                                    Webmail URL:	<br>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <p>
                                                                    <? echo $requestaccount . '@' . $requestdomain; ?><br>   
                                                                    <span class="mailPW"></span><br>
                                                                    <? echo VESTA_HOST_ADDRESS; ?><br>
                                                                    993<br>
                                                                    SSL<br>
                                                                    Normal Password<br>
                                                                    <? echo VESTA_HOST_ADDRESS; ?><br>
                                                                    465<br>
                                                                    SSL<br>	
                                                                    Normal Password	<br>
                                                                    <a href="<? echo $webmailurl; ?>"><? echo $webmailurl; ?></a><br>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="5">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    Username:	<br>   
                                                                    Password:	<br>
                                                                    IMAP hostname:	<br>
                                                                    IMAP port:	<br>
                                                                    IMAP security:	<br>
                                                                    IMAP auth method:<br>
                                                                    SMTP hostname:<br>
                                                                    SMTP port:	<br>
                                                                    SMTP security:<br>	
                                                                    SMTP auth method:	<br>
                                                                    Webmail URL:	<br>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <p>
                                                                    <? echo $requestaccount . '@' . $requestdomain; ?><br>   
                                                                    <span class="mailPW"></span><br>
                                                                    <? echo VESTA_HOST_ADDRESS; ?><br>
                                                                    143<br>
                                                                    No Encryption<br>
                                                                    Normal Password<br>
                                                                    <? echo VESTA_HOST_ADDRESS; ?><br>
                                                                    25<br>
                                                                    No Encryption<br>	
                                                                    Normal Password	<br>
                                                                    <a href="<? echo $webmailurl; ?>"><? echo $webmailurl; ?></a><br>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="2">
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a  href="#6" data-toggle="tab">TLS</a>
                                                    </li>
                                                    <li><a href="#7" data-toggle="tab">SSL</a>
                                                    </li>
                                                    <li><a href="#8" data-toggle="tab">No Authentication</a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content ">
                                                    <div class="tab-pane active" id="6">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    Username:	<br>   
                                                                    Password:	<br>
                                                                    IMAP hostname:	<br>
                                                                    IMAP port:	<br>
                                                                    IMAP security:	<br>
                                                                    IMAP auth method:<br>
                                                                    SMTP hostname:<br>
                                                                    SMTP port:	<br>
                                                                    SMTP security:<br>	
                                                                    SMTP auth method:	<br>
                                                                    Webmail URL:	<br>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <p>
                                                                    <? echo $requestaccount . '@' . $requestdomain; ?><br>   
                                                                    <span class="mailPW"></span><br>
                                                                    <? echo $requestdomain; ?><br>
                                                                    143<br>
                                                                    STARTTLS<br>
                                                                    Normal Password<br>
                                                                    <? echo $requestdomain; ?><br>
                                                                    587<br>
                                                                    STARTTLS<br>	
                                                                    Normal Password	<br>
                                                                    <a href="<? echo $webmailurl; ?>"><? echo $webmailurl; ?></a><br>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="7">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    Username:	<br>   
                                                                    Password:	<br>
                                                                    IMAP hostname:	<br>
                                                                    IMAP port:	<br>
                                                                    IMAP security:	<br>
                                                                    IMAP auth method:<br>
                                                                    SMTP hostname:<br>
                                                                    SMTP port:	<br>
                                                                    SMTP security:<br>	
                                                                    SMTP auth method:	<br>
                                                                    Webmail URL:	<br>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <p>
                                                                    <? echo $requestaccount . '@' . $requestdomain; ?><br>   
                                                                    <span class="mailPW"></span><br>
                                                                    <? echo $requestdomain; ?><br>
                                                                    993<br>
                                                                    SSL<br>
                                                                    Normal Password<br>
                                                                    <? echo $requestdomain; ?><br>
                                                                    465<br>
                                                                    SSL<br>	
                                                                    Normal Password	<br>
                                                                    <a href="<? echo $webmailurl; ?>"><? echo $webmailurl; ?></a><br>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="8">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    Username:	<br>   
                                                                    Password:	<br>
                                                                    IMAP hostname:	<br>
                                                                    IMAP port:	<br>
                                                                    IMAP security:	<br>
                                                                    IMAP auth method:<br>
                                                                    SMTP hostname:<br>
                                                                    SMTP port:	<br>
                                                                    SMTP security:<br>	
                                                                    SMTP auth method:	<br>
                                                                    Webmail URL:	<br>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <p>
                                                                    <? echo $requestaccount . '@' . $requestdomain; ?><br>   
                                                                    <span class="mailPW"></span><br>
                                                                    <? echo $requestdomain; ?><br>
                                                                    143<br>
                                                                    No Encryption<br>
                                                                    Normal Password<br>
                                                                    <? echo $requestdomain; ?><br>
                                                                    25<br>
                                                                    No Encryption<br>	
                                                                    Normal Password	<br>
                                                                    <a href="<? echo $webmailurl; ?>"><? echo $webmailurl; ?></a><br>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer text-center">&copy; Copyright <?php echo date("Y") . ' ' . $sitetitle; ?>. All Rights Reserved. Powered by VestaCP, CDG Web Services, & WrapPixel.</footer>
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
        <script src="../plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript">
            $('.datepicker').datepicker();
            (function () {
                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                    new CBPFWTabs(el);
                });
            })();
            function checkDiv(){
                if(document.getElementById("checkbox5").checked) {
                    document.getElementById('msg-div').style.display = 'block';
                }
                else {document.getElementById('msg-div').style.display = 'none';}
            } 
            jQuery(function($){
                $('.footable').footable();
            });
            function toggler(e) {
                if( e.name == 'Hide' ) {
                    e.name = 'Show'
                    document.getElementById('password').type="password";
                } else {
                    e.name = 'Hide'
                    document.getElementById('password').type="text";
                }
            }
            function fillSpan() {
                var mailPW = document.getElementById('password').value;
                document.getElementsByClassName("mailPW")[0].innerHTML = mailPW;
                document.getElementsByClassName("mailPW")[1].innerHTML = mailPW;
                document.getElementsByClassName("mailPW")[2].innerHTML = mailPW;
                document.getElementsByClassName("mailPW")[3].innerHTML = mailPW;
                document.getElementsByClassName("mailPW")[4].innerHTML = mailPW;
                document.getElementsByClassName("mailPW")[5].innerHTML = mailPW;
                }
            function generatePassword(length) {
                var password = '', character; 
                while (length > password.length) {
                    if (password.indexOf(character = String.fromCharCode(Math.floor(Math.random() * 94) + 33), Math.floor(password.length / 94) * 94) < 0) {
                        password += character;
                    }
                }
                document.getElementById('password').value = password;
                document.getElementById('tg').name='Hide';
                document.getElementById('password').type="text";
                fillSpan();
            }
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
                }).then(function () {
                    swal({
                        title: 'Processing',
                        text: '',
                        timer: 5000,
                        onOpen: function () {
                            swal.showLoading()
                        }
                    }).then(
                        function () {},
                        // handling the promise rejection
                        function (dismiss) {
                            if (dismiss === 'timer') {
                                console.log('I was closed by the timer')
                            }
                        }
                    )
                    $.ajax({  
                        type: "GET",  
                        url: "../delete/domain.php",  
                        data: { 'domain':e1, 'verified':'yes' },
                        success:  function(){ window.location = "web.php?delcode=0"; },
                        error:  function(){ window.location = "web.php?delcode=0"; }
                    })
                })}

            <?php if($_GET['delcode'] == "0"){ echo "swal({title:'Successfully Deleted!', type:'success'});";} ?>
        </script>
    </body>

</html>