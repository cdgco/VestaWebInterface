<?php

if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); }  else { header( 'Location: ../install' );};

if(base64_decode($_COOKIE['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

$requestdomain = $_GET['domain'];

if (isset($requestdomain) && $requestdomain != '') {}
else { header('Location: ../list/web.php'); }

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
    curl_setopt(${'curl' . $curlstart}, CURLOPT_URL, $vst_url);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_RETURNTRANSFER,true);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_POST, true);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
    $curlstart++;
} 

$admindata = json_decode(curl_exec($curl0), true)[$username];
$useremail = $admindata['CONTACT'];
$domainname = array_keys(json_decode(curl_exec($curl1), true));
$domaindata = array_values(json_decode(curl_exec($curl1), true));
$webtemplates = array_values(json_decode(curl_exec($curl2), true));
$proxytemplates = array_values(json_decode(curl_exec($curl3), true));
$userips = array_keys(json_decode(curl_exec($curl4), true));
$domainssl = array_values(json_decode(curl_exec($curl5), true));
$webstats = array_values(json_decode(curl_exec($curl6), true));

if ($domainname[0] == '') { header('Location: ../list/web.php'); }
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
        <title><?php echo $sitetitle; ?> - Web</title>
        <link href="../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
        <link href="../plugins/bower_components/footable/css/footable.bootstrap.css" rel="stylesheet">
        <link href="../plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
        <link href="../css/animate.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/colors/<?php echo $themecolor; ?>" id="theme" rel="stylesheet">
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
                            <li> 
                                <a href="../index.php" class="waves-effect">
                                    <i class="mdi mdi-home fa-fw"></i> <span class="hide-menu">Dashboard</span>
                                </a> 
                            </li>

                            <li class="devider"></li>
                            <li>
                                <a href="#" class="waves-effect"><i  class="ti-user fa-fw"></i><span class="hide-menu"> <?php print_r($uname); ?><span class="fa arrow"></span></span>
                                </a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                                    <li> <a href="../profile.php"><i class="ti-home fa-fw"></i> <span class="hide-menu"> My Account</span></a></li>
                                    <li> <a href="../profile.php?settings=open"><i class="ti-settings fa-fw"></i> <span class="hide-menu"> Account Setting</span></a></li>
                                </ul>
                            </li>
                            <?php if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '<li class="devider"></li>
                                <li class="active"> <a href="#" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">Management <span class="fa arrow"></span> </span></a>
                                    <ul class="nav nav-second-level">'; } ?>
                            <?php if ($webenabled == 'true') { echo '<li> <a href="../list/web.php" class="active"><i class="ti-world fa-fw"></i><span class="hide-menu">Web</span></a> </li>'; } ?>
                            <?php if ($dnsenabled == 'true') { echo '<li> <a href="../list/dns.php"><i class="fa fa-sitemap fa-fw"></i><span class="hide-menu">DNS</span></a> </li>'; } ?>
                            <?php if ($mailenabled == 'true') { echo '<li> <a href="../list/mail.php"><i class="fa fa-envelope fa-fw"></i><span class="hide-menu">Mail</span></a> </li>'; } ?>
                            <?php if ($dbenabled == 'true') { echo '<li> <a href="../list/db.php"><i class="fa fa-database fa-fw"></i><span class="hide-menu">Database</span></a> </li>'; } ?>
                            <?php if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '</ul>
                                </li>'; } ?>
                            <li> <a href="../list/cron.php" class="waves-effect"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu">Cron Jobs</span></a> </li>
                            <li> <a href="../list/backups.php" class="waves-effect"><i  class="fa fa-cloud-upload fa-fw"></i> <span class="hide-menu">Backups</span></a> </li>
                            <?php if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {} else { echo '<li class="devider"></li>
                                <li><a href="#" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">Apps<span class="fa arrow"></span></span></a>
                                    <ul class="nav nav-second-level">'; } ?>
                            <?php if ($ftpurl != '') { echo '<li><a href="' . $ftpurl . '"><i class="fa fa-file-code-o fa-fw"></i><span class="hide-menu">FTP</span></a></li>';} ?>
                            <?php if ($webmailurl != '') { echo '<li><a href="' . $webmailurl . '"><i class="fa fa-envelope-o fa-fw"></i><span class="hide-menu">Webmail</span></a></li>';} ?>
                            <?php if ($phpmyadmin != '') { echo '<li><a href="' . $phpmyadmin . '"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">phpMyAdmin</span></a></li>';} ?>
                            <?php if ($phppgadmin != '') { echo '<li><a href="' . $phppgadmin . '"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">phpPgAdmin</span></a></li>';} ?>
                            <?php if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {} else { echo '</ul></li>';} ?>
                            <li class="devider"></li>
                            <li><a href="process/logout.php" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu">Log out</span></a></li>
                            <?php if ($oldcpurl == '' || $supporturl == '') {} else { echo '<li class="devider"></li>'; } ?>
                            <?php if ($oldcpurl != '') { echo '<li><a href="' . $oldcpurl . '" class="waves-effect"> <i class="fa fa-tachometer fa-fw"></i> <span class="hide-menu"> Control Panel v1</span></a></li>'; } ?>
                            <?php if ($supporturl != '') { echo '<li><a href="' . $supporturl . '" class="waves-effect"> <i class="fa fa-life-ring fa-fw"></i> <span class="hide-menu">Support</span></a></li>'; } ?>
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
                                            <center><h2><?php print_r($domainname[0]); ?></h2></center>
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
                                                    <?php $date=date_create($domaindata[0]['DATE'] . ' ' . $domaindata[0]['TIME']); echo date_format($date,"F j, Y - g:i A"); ?>
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
                                                    <?php if ($domaindata[0]['SUSPENDED'] == 'no') {echo 'Active';} else {echo 'Suspended';}?>
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
                                        <label class="col-md-12">IP Address</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_domain" value="<?php echo $requestdomain; ?>">
                                            <input type="hidden" name="v_ip-x" value="<?php echo $domaindata[0]['IP']; ?>">
                                            <select class="form-control select1" name="v_ip" id="select1">
                                                <?php
                                                if($userips[0] != '') {
                                                    $x4 = 0; 

                                                    do {
                                                        echo '<option value="' . $userips[$x4] . '">' . $userips[$x4] . '</option>';
                                                        $x4++;
                                                    } while ($userips[$x4] != ''); }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Aliases</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_alias-x" value="<?php echo $domaindata[0]['ALIAS']; ?>"> 
                                            <textarea class="form-control" rows="4" name="v_alias"><?php 
                                                $aliasArray = explode(',', ($domaindata[0]['ALIAS']));

                                                foreach ($aliasArray as &$value) {
                                                    $value = $value . "&#013;&#010;";
                                                }
                                                foreach($aliasArray as $val) {
                                                    echo $val;
                                                } ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Web Template</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_tpl-x" value="<?php echo $domaindata[0]['TPL']; ?>">
                                            <select class="form-control select2" name="v_tpl" id="select2"><?php
                                                if($webtemplates[0] != '') {
                                                    $x1 = 0; 

                                                    do {
                                                        echo '<option value="' . $webtemplates[$x1] . '">' . $webtemplates[$x1] . '</option>';
                                                        $x1++;
                                                    } while ($webtemplates[$x1] != ''); }

                                                ?></select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Proxy Support</label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input type="hidden" name="v_prxenabled-x" value="<?php if($domaindata[0]['PROXY'] != '') {echo 'yes';} ?>">
                                                <input id="checkbox4" type="checkbox" name="v_prxenabled" onclick="checkDiv();" <?php if($domaindata[0]['PROXY'] != '') {echo 'checked';} ?> >
                                                <label for="checkbox4"> Enabled </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="prxy-div" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12">Proxy Template</label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_prxtpl-x" value="<?php echo $domaindata[0]['PROXY']; ?>">
                                                <select class="form-control select3" name="v_prxtpl" id="select3">
                                                    <?php
                                                    if($proxytemplates[0] != '') {
                                                        $x2 = 0; 

                                                        do {
                                                            echo '<option value="' . $proxytemplates[$x2] . '">' . $proxytemplates[$x2] . '</option>';
                                                            $x2++;
                                                        } while ($proxytemplates[$x2] != ''); }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">Proxy Extensions</label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_prxext-x" value="<?php echo $domaindata[0]['PROXY_EXT']; ?>">
                                                <textarea class="form-control" rows="2" id="prxext" name="v_prxext"><?php echo $domaindata[0]['PROXY_EXT']; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">SSL Support</label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input type="hidden" name="v_sslenabled-x" value="<?php echo $domaindata[0]['SSL']; ?>">
                                                <input id="checkbox5" type="checkbox" name="v_sslenabled" onclick="checkDiv2();" <?php if($domaindata[0]['SSL'] == 'no') {} else {echo 'checked';} ?> >
                                                <label for="checkbox5"> Enabled </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="ssl-div" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12">Let's Encrypt Support</label>
                                            <div class="col-md-12">
                                                <div class="checkbox checkbox-info">
                                                    <input type="hidden" name="v_leeanbled-x" value="<?php echo $domaindata[0]['LETSENCRYPT']; ?>">
                                                    <input id="checkbox6" name="v_leenabled" type="checkbox" <?php if($domaindata[0]['LETSENCRYPT'] == 'no') {} else {echo 'checked';} ?>>
                                                    <label for="checkbox6"> Enabled </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <label class="col-md-12">SSL Directory</label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_ssldir-x" value="<?php echo $domaindata[0]['SSL_HOME']; ?>">
                                                <select class="form-control" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static" disabled name="v_ssldir">
                                                    <option value="same" <?php if($domaindata[0]['SSL_HOME'] == 'same') {echo 'selected';} ?>>public_html</option>
                                                    <option value="single" <?php if($domaindata[0]['SSL_HOME'] == 'single') {echo 'selected';} ?>>public_shtml</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">SSL Certificate / <a href="../process/generatecsr.php?domain=<?php echo $requestdomain; ?>">Generate CSR</a></label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_sslcrt-x" value="<?php echo $domaindata[0]['CRT']; ?>">
                                                <textarea class="form-control" rows="4" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static" disabled name="v_sslcrt"><?php print_r($domainssl[0]['CRT']); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">SSL Key</label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_sslkey-x" value="<?php echo $domaindata[0]['KEY']; ?>">
                                                <textarea class="form-control" rows="4" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static" disabled name="v_sslkey"><?php print_r($domainssl[0]['KEY']); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12">SSL Certificate Authority / Intermediate</label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_sslca-x" value="<?php echo $domaindata[0]['CA']; ?>">
                                                <textarea class="form-control" rows="4" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static" disabled name="v_sslca"><?php print_r($domainssl[0]['CA']); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-left: 0.1%;display:<? if($domainssl[0]['CRT'] != ''){echo 'block';} else { echo 'none';} ?>">
                                            <ul class="list-unstyled">
                                                <li>Subject:  <?php print_r($domainssl[0]['SUBJECT']); ?></li>
                                                <li>Aliases:  <?php print_r($domainssl[0]['ALIASES']); ?></li>
                                                <li>Not Before:  <?php print_r($domainssl[0]['NOT_BEFORE']); ?></li>
                                                <li>Not After:  <?php print_r($domainssl[0]['NOT_AFTER']); ?></li>
                                                <li>Signature:  <?php print_r($domainssl[0]['SIGNATURE']); ?></li>
                                                <li>Pub Key:  <?php print_r($domainssl[0]['PUB_KEY']); ?></li>
                                                <li>Issuer:  <?php print_r($domainssl[0]['ISSUER']); ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Web Statistics</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_webstats-x" value="<?php if ($domaindata[0]['STATS'] == '') {echo 'none'; } else { echo $domaindata[0]['STATS']; } ?>">
                                            <select class="form-control select6" name="v_webstats" onchange="showauth()" id="select6">
                                                <?php
                                                if($webstats[0] != '') {
                                                    $x6 = 0; 

                                                    do {
                                                        echo '<option value="' . $webstats[$x6] . '">' . $webstats[$x6] . '</option>';
                                                        $x6++;
                                                    } while ($webstats[$x6] != ''); }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div id="statsauth" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12">Statistics Authorization</label>
                                            <div class="col-md-12">
                                                <div class="checkbox checkbox-info">
                                                    <input type="hidden" name="v_statsuserenabled-x" value="<?php if($domaindata[0]['STATS_USER'] == '') {echo '';} else {echo 'yes';} ?>">
                                                    <input id="checkbox10" type="checkbox" name="v_statsuserenabled" <?php if($domaindata[0]['STATS_USER'] != '') {echo 'checked';} ?> onclick="checkDiv4();">
                                                    <label for="checkbox10"> Enabled </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="stats-div" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12">Username</label><br>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_statsuname-x" value="<?php echo $domaindata[0]['STATS_USER']; ?>">
                                                <input type="text" name="v_statsuname" autocomplete="new-password" class="form-control" value="<?php echo $domaindata[0]['STATS_USER']; ?>"> 
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
                                    <?php
                                    $ftpuser = explode(':', ($domaindata[0]['FTP_USER'])); 
                                    $ftpdir = explode(':', ($domaindata[0]['FTP_PATH'])); 
                                    ?>
                                    <div class="form-group">
                                        <label class="col-md-12">Additional FTP</label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input type="hidden" name="v_additionalftpenabled-x" value="<?php if($ftpuser[0]) {echo 'yes';} else { echo 'no'; }?>">
                                                <input id="checkbox9" disabled type="checkbox" name="v_addittionalftpenabled" <?php if($ftpuser[0]) {echo 'checked';} ?> onclick="checkDiv3();">
                                                <label for="checkbox9"> Enabled </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="ftp-div" style="margin-left: 4%;">

                                        <div class="form-group">
                                            <label class="col-md-12">Username</label><br>
                                            <div class="col-md-12">
                                                <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                    <div class="input-group-addon"><?php print_r($uname); ?>_</div>
                                                    <input type="hidden" name="v_ftpuname-x" value="<?php $prefix = $uname . '_'; $str = $ftpuser[0]; if (substr($str, 0, strlen($prefix)) == $prefix) { $str = substr($str, strlen($prefix));} print_r($str); ?>">
                                                    <input type="text" class="form-control" name="v_ftpuname" value="<?php $prefix = $uname . '_'; $str = $ftpuser[0]; if (substr($str, 0, strlen($prefix)) == $prefix) { $str = substr($str, strlen($prefix));} print_r($str); ?>" style="padding-left: 0.5%;">    
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
                                                    <input type="hidden" name="v_ftpdir-x" value="<?php echo $ftpdir[0]; ?>">
                                                    <div class="input-group-addon">/home/<?php print_r($uname); ?>/web/<?php print_r($requestdomain); ?>/</div>
                                                    <input type="text" class="form-control" name="v_ftpdir" value="<?php echo $ftpdir[0]; ?>" style="padding-left: 0.5%;">    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" type="submit">Update Domain</button> &nbsp;
                                            <a href="../list/web.php" style="color: inherit;text-decoration: inherit;"><button class="btn btn-muted" type="button">Back</button></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer text-center">&copy; Copyright <?php echo date("Y") . ' ' . $sitetitle; ?>. All Rights Reserved. Vesta Web Interface <?php require '../includes/versioncheck.php'; ?> by CDG Web Services.</footer>
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
        <script src="../js/custom.js"></script>
        <script src="../js/dashboard1.js"></script>
        <script src="../js/cbpFWTabs.js"></script>
        <script src="../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.js"></script>
        <script type="text/javascript">
            (function () {
                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                    new CBPFWTabs(el);
                });
            })();

            document.getElementById('select1').value = '<?php print_r($domaindata[0]['IP']); ?>'; 
            document.getElementById('select2').value = '<?php print_r($domaindata[0]['TPL']); ?>'; 

            if ('<? print_r($domaindata[0]['PROXY']); ?>' == '') {  document.getElementById('select3').value = 'default';  }
            else { document.getElementById('select3').value = '<? print_r($domaindata[0]['PROXY']); ?>'; }
            if ('<? print_r($domaindata[0]['PROXY_EXT']); ?>' == '') {  document.getElementById('prxext').value = 'jpeg, jpg, png, gif, bmp, ico, svg, tif, tiff, css, js, htm, html, ttf, otf, webp, woff, txt, csv, rtf, doc, docx, xls, xlsx, ppt, pptx, odf, odp, ods, odt, pdf, psd, ai, eot, eps, ps, zip, tar, tgz, gz, rar, bz2, 7z, aac, m4a, mp3, mp4, ogg, wav, wma, 3gp, avi, flv, m4v, mkv, mov, mp4, mpeg, mpg, wmv, exe, iso, dmg, swf';  }
            else { document.getElementById('prxext').value = '<? print_r($domaindata[0]['PROXY_EXT']); ?>'; }
            if ('<? print_r($domaindata[0]['STATS']); ?>' == '') {  document.getElementById('select6').value = 'none';  }
            else { document.getElementById('select6').value = '<? print_r($domaindata[0]['STATS']); ?>'; }

            function showauth(){
                if(document.getElementById('select6').value != 'none') {
                    document.getElementById('statsauth').style.display = "block";
                }
                else {
                    document.getElementById('statsauth').style.display = "none";
                }}
            function checkDiv(){
                if(document.getElementById("checkbox4").checked) {
                    document.getElementById('prxy-div').style.display = 'block';
                }
                else {document.getElementById('prxy-div').style.display = 'none';}
            }
            function checkDiv2(){
                if(document.getElementById("checkbox5").checked) {
                    document.getElementById('ssl-div').style.display = 'block';
                }
                else {document.getElementById('ssl-div').style.display = 'none';}
            }
            function checkDiv3(){
                if(document.getElementById("checkbox9").checked) {
                    document.getElementById('ftp-div').style.display = 'block';
                }
                else {document.getElementById('ftp-div').style.display = 'none';}
            }
            function checkDiv4(){
                if(document.getElementById("checkbox10").checked) {
                    document.getElementById('stats-div').style.display = 'block';
                }
                else {document.getElementById('stats-div').style.display = 'none';}
            }
            function toggle_visibility(id) {
                var e = document.getElementById(id);
                if(e.style.display == 'block')
                    e.style.display = 'none';
                else
                    e.style.display = 'block';
            }
            function toggler(e) {
                if( e.name == 'Hide' ) {
                    e.name = 'Show'
                    document.getElementById('password').type="password";
                } else {
                    e.name = 'Hide'
                    document.getElementById('password').type="text";
                }
            }
            function toggler2(e) {
                if( e.name == 'Hide' ) {
                    e.name = 'Show'
                    document.getElementById('statspassword').type="password";
                } else {
                    e.name = 'Hide'
                    document.getElementById('statspassword').type="text";
                }
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
            function generatePassword2(length) {
                var password = '', character; 
                while (length > password.length) {
                    if (password.indexOf(character = String.fromCharCode(Math.floor(Math.random() * 94) + 33), Math.floor(password.length / 94) * 94) < 0) {
                        password += character;
                    }
                }
                document.getElementById('statspassword').value = password;
                document.getElementById('tg2').name='Hide';
                document.getElementById('statspassword').type="text";
                fillSpan();
            }
            jQuery(function($){
                $('.footable').footable();
            });
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