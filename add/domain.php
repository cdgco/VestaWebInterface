<?php

session_start();

if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); }  else { header( 'Location: ../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

$postvars = array(
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user-ips','arg1' => $username,'arg2' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-templates-proxy','arg1' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-stats','arg1' => 'json'));

$curl0 = curl_init();
$curl1 = curl_init();
$curl2 = curl_init();
$curl3 = curl_init();
$curlstart = 0; 

while($curlstart <= 3) {
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
$userips = array_keys(json_decode(curl_exec($curl1), true));
$proxytemplates = array_values(json_decode(curl_exec($curl2), true));
$webstats = array_values(json_decode(curl_exec($curl3), true));
if(isset($admindata['LANGUAGE'])){ $locale = $ulang[$admindata['LANGUAGE']]; }
setlocale(LC_CTYPE, $locale); setlocale(LC_MESSAGES, $locale);
bindtextdomain('messages', '../locale');
textdomain('messages');

    foreach ($plugins as $result) {
        if (file_exists('../plugins/' . $result)) {
            if (file_exists('../plugins/' . $result . '/manifest.xml')) {
                $get = file_get_contents('../plugins/' . $result . '/manifest.xml');
                $xml   = simplexml_load_string($get, 'SimpleXMLElement', LIBXML_NOCDATA);
                $arr = json_decode(json_encode((array)$xml), TRUE);
                if (isset($arr['name']) && !empty($arr['name']) && isset($arr['fa-icon']) && !empty($arr['fa-icon']) && isset($arr['section']) && !empty($arr['section']) && isset($arr['admin-only']) && !empty($arr['admin-only'])){
                    array_push($pluginlinks,$result);
                    array_push($pluginnames,$arr['name']);
                    array_push($pluginicons,$arr['fa-icon']);
                    array_push($pluginsections,$arr['section']);
                    array_push($pluginadminonly,$arr['admin-only']);
                }

            }    
        }
    }
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
        <title><?php echo $sitetitle; ?> - WEB</title>
        <link href="../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
        <link href="../plugins/bower_components/footable/css/footable.bootstrap.css" rel="stylesheet">
        <link href="../plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
        <link href="../css/animate.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
        <link href="../css/colors/<?php if(isset($_COOKIE['theme'])) { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.min.css" />
        <?php if(GOOGLE_ANALYTICS_ID != ''){ echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . GOOGLE_ANALYTICS_ID . "'></script>
        <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '" . GOOGLE_ANALYTICS_ID . "');</script>"; } ?> 
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>

    <body class="fix-header" onload="checkDiv3();checkDiv4();checkDiv5();showauth();">
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
                            <li><a href="../profile.php"><i class="ti-home"></i> <?php echo _("My Account"); ?></a></li>
                            <li><a href="../profile.php?settings=open"><i class="ti-settings"></i> <?php echo _("Account Settings"); ?></a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="../process/logout.php"><i class="fa fa-power-off"></i> <?php echo _("Logout"); ?></a></li>
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
                        <span class="hide-menu"><?php echo _("Navigation"); ?></span>
                    </h3>  
                </div>
               <ul class="nav" id="side-menu">
                            <li> 
                                <a href="../index.php" class="waves-effect">
                                    <i class="mdi mdi-home fa-fw"></i> <span class="hide-menu"><?php echo _("Home"); ?></span>
                                </a> 
                            </li>

                            <li class="devider"></li>
                            <li>
                                <a href="#" class="waves-effect"><i  class="ti-user fa-fw"></i><span class="hide-menu"> <?php print_r($uname); ?><span class="fa arrow"></span></span>
                                </a>
                                <ul class="nav nav-second-level collapse" id="appendaccount" aria-expanded="false" style="height: 0px;">
                                    <li> <a href="../profile.php"><i class="ti-home fa-fw"></i> <span class="hide-menu"> <?php echo _("My Account"); ?></span></a></li>
                                    <li> <a href="../profile.php?settings=open"><i class="ti-settings fa-fw"></i> <span class="hide-menu"> <?php echo _("Acount Settings"); ?></span></a></li>
                                    <li> <a href="../log.php"><i class="ti-layout-list-post fa-fw"></i><span class="hide-menu"><?php echo _("Log"); ?></span></a> </li>
                                </ul>
                            </li>
                        <?php if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '<li class="devider"></li>
                            <li class="active"> <a href="#" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">'. _("Management") . '<span class="fa arrow"></span> </span></a>
                                <ul class="nav nav-second-level" id="appendmanagement">'; } ?>
                        <?php if ($webenabled == 'true') { echo '<li> <a href="../list/web.php" class="active"><i class="ti-world fa-fw"></i><span class="hide-menu">' . _("Web") . '</span></a> </li>'; } ?>
                        <?php if ($dnsenabled == 'true') { echo '<li> <a href="../list/dns.php"><i class="fa fa-sitemap fa-fw"></i><span class="hide-menu">' . _("DNS") . '</span></a> </li>'; } ?>
                        <?php if ($mailenabled == 'true') { echo '<li> <a href="../list/mail.php"><i class="fa fa-envelope fa-fw"></i><span class="hide-menu">' . _("Mail") . '</span></a> </li>'; } ?>
                        <?php if ($dbenabled == 'true') { echo '<li> <a href="../list/db.php"><i class="fa fa-database fa-fw"></i><span class="hide-menu">' . _("Database") . '</span></a> </li>'; } ?>
                        <?php if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '</ul>
                            </li>'; } ?>
                        <li> <a href="../list/cron.php" class="waves-effect" class="active"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu"><?php echo _("Cron Jobs"); ?></span></a> </li>
                        <li> <a href="../list/backups.php" class="waves-effect"><i  class="fa fa-cloud-upload fa-fw"></i> <span class="hide-menu"><?php echo _("Backups"); ?></span></a> </li>
                        <?php if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {} else { echo '<li class="devider"></li>
                            <li><a href="#" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">' . _("Apps") . '<span class="fa arrow"></span></span></a>
                                <ul class="nav nav-second-level" id="appendapps">'; } ?>
                        <?php if ($ftpurl != '') { echo '<li><a href="' . $ftpurl . '" target="_blank"><i class="fa fa-file-code-o fa-fw"></i><span class="hide-menu">' . _("FTP") . '</span></a></li>';} ?>
                        <?php if ($webmailurl != '') { echo '<li><a href="' . $webmailurl . '" target="_blank"><i class="fa fa-envelope-o fa-fw"></i><span class="hide-menu">' . _("Webmail") . '</span></a></li>';} ?>
                        <?php if ($phpmyadmin != '') { echo '<li><a href="' . $phpmyadmin . '" target="_blank"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">' . _("phpMyAdmin") . '</span></a></li>';} ?>
                        <?php if ($phppgadmin != '') { echo '<li><a href="' . $phppgadmin . '" target="_blank"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">' . _("phpPgAdmin") . '</span></a></li>';} ?>
                        <?php if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {} else { echo '</ul></li>';} ?>
                        <li class="devider"></li>
                        <li><a href="../process/logout.php" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu"><?php echo _("Log out"); ?></span></a></li>
                        <?php if ($oldcpurl == '' || $supporturl == '') {} else { echo '<li class="devider"></li>'; } ?>
                        <?php if ($oldcpurl != '') { echo '<li><a href="' . $oldcpurl . '" class="waves-effect"> <i class="fa fa-tachometer fa-fw"></i> <span class="hide-menu"> ' . _("Control Panel v1") . '</span></a></li>'; } ?>
                        <?php if ($supporturl != '') { echo '<li><a href="' . $supporturl . '" class="waves-effect" target="_blank"> <i class="fa fa-life-ring fa-fw"></i> <span class="hide-menu">' . _("Support") . '</span></a></li>'; } ?>
                        </ul>
            </div>
        </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title"><?php echo _("Add Domain"); ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-xs-12">
                            <div class="white-box">
                                <form class="form-horizontal form-material" autocomplete="off" method="post" action="../create/domain.php">
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Domain"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_domain" autocomplete="new-password" id="domain" onkeyup="checkwww();csrlink();" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group" style="overflow: visible;">
                                        <label class="col-md-12"><?php echo _("IP Address"); ?></label>
                                        <div class="col-md-12">
                                            <select class="form-control" name="v_ip">
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
                                        <label class="col-md-12"><?php echo _("DNS Support"); ?></label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input id="checkbox1" name="v_dnsenabled" type="checkbox" checked>
                                                <label for="checkbox1"> <?php echo _("Enabled"); ?> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Mail Support"); ?></label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input id="checkbox2" name="v_mailenabled" type="checkbox" checked>
                                                <label for="checkbox2"> <?php echo _("Enabled"); ?> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><a style="cursor: pointer;" onclick="toggle_visibility('togglediv');"><?php echo _("Advanced Options"); ?></a></label>
                                    </div>
                                    <div id="togglediv" style="display:none;">
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Aliases"); ?></label>
                                            <div class="col-md-12">
                                                <textarea class="form-control aliasfill" name="v_alias" rows="4"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Proxy Support"); ?></label>
                                            <div class="col-md-12">
                                                <div class="checkbox checkbox-info">
                                                    <input id="checkbox4" type="checkbox" name="v_proxyenabled" onclick="checkDiv();" checked >
                                                    <label for="checkbox4"> <?php echo _("Enabled"); ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" id="prxextdiv" style="margin-left: 2%;">
                                            <label class="col-md-12"><?php echo _("Proxy Extensions"); ?></label>
                                            <div class="col-md-12">
                                                <textarea class="form-control" rows="4" name="v_prxext" id="prxTextArea">jpeg, jpg, png, gif, bmp, ico, svg, tif, tiff, css, js, htm, html, ttf, otf, webp, woff, txt, csv, rtf, doc, docx, xls, xlsx, ppt, pptx, odf, odp, ods, odt, pdf, psd, ai, eot, eps, ps, zip, tar, tgz, gz, rar, bz2, 7z, aac, m4a, mp3, mp4, ogg, wav, wma, 3gp, avi, flv, m4v, mkv, mov, mp4, mpeg, mpg, wmv, exe, iso, dmg, swf</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("SSL Support"); ?></label>
                                            <div class="col-md-12">
                                                <div class="checkbox checkbox-info">
                                                    <input id="checkbox8" type="checkbox" name="v_sslenabled" onclick="checkDiv3();">
                                                    <label for="checkbox8"> <?php echo _("Enabled"); ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="ssl-div" style="margin-left: 4%;">
                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo _("Let's Encrypt Support"); ?></label>
                                                <div class="col-md-12">
                                                    <div class="checkbox checkbox-info">
                                                        <input id="checkbox6" type="checkbox" name="v_leenabled">
                                                        <label for="checkbox6"> <?php echo _("Enabled"); ?> </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo _("SSL Directory"); ?></label>
                                                <div class="col-md-12">
                                                    <select disabled name="v_ssldir" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static">
                                                        <option value="public_html" selected>public_html</option>
                                                        <option value="public_shtml">public_shtml</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo _("SSL Certificate"); ?> / <a class="sslfill"><?php echo _("Generate CSR"); ?></a></label>
                                                <div class="col-md-12">
                                                    <textarea style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static" disabled name="v_sslcrt" rows="4"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo _("SSL Key"); ?></label>
                                                <div class="col-md-12">
                                                    <textarea style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static" disabled name="v_sslkey" rows="4"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo _("SSL Certificate Authority / Intermediate"); ?></label>
                                                <div class="col-md-12">
                                                    <textarea style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static" disabled name="v_sslca" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Web Statistics"); ?></label>
                                            <div class="col-md-12">
                                                <select class="form-control select7" onchange="showauth()"name="v_webstats" id="select7">
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
                                                <label class="col-md-12"><?php echo _("Statistics Authorization"); ?></label>
                                                <div class="col-md-12">
                                                    <div class="checkbox checkbox-info">
                                                        <input id="checkbox10" type="checkbox" name="v_statsuserenabled" onclick="checkDiv5();">
                                                        <label for="checkbox10"> <?php echo _("Enabled"); ?> </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="stats-div" style="margin-left: 4%;">
                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo _("Username"); ?></label><br>
                                                <div class="col-md-12">
                                                    <input type="text" autocomplete="new-password" name="v_statsuname" class="form-control"> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="v_statspassword" class="col-md-12"><?php echo _("Password"); ?> / <a style="cursor:pointer" onclick="generatePassword2(10)"> <?php echo _("Generate"); ?></a></label>
                                                <div class="col-md-12 input-group" style="padding-left: 15px;">
                                                    <input type="password" class="form-control form-control-line" autocomplete="new-password" name="v_statspassword" id="statspassword">                                    <span class="input-group-btn"> 
                                                    <button class="btn btn-inverse" style="margin-right: 15px;" name="Show" onclick="toggler2(this)" id="tg2" type="button"><i class="ti-eye"></i></button> 
                                                    </span>  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Additional FTP"); ?></label>
                                            <div class="col-md-12">
                                                <div class="checkbox checkbox-info">
                                                    <input id="checkbox9" disabled type="checkbox" name="v_additionalftpenabled" onclick="checkDiv4();">
                                                    <label for="checkbox9"> <?php echo _("Enabled"); ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="ftp-div" style="margin-left: 4%;">

                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo _("Username"); ?></label><br>
                                                <div class="col-md-12">
                                                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                        <div class="input-group-addon"><?php print_r($uname); ?>_</div>
                                                        <input type="text" class="form-control" autocomplete="new-password" name="v_ftpuname" style="padding-left: 0.5%;">    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="col-md-12"><?php echo _("Password"); ?> / <a style="cursor:pointer" onclick="generatePassword(10)"> <?php echo _("Generate"); ?></a></label>
                                                <div class="col-md-12 input-group" style="padding-left: 15px;">
                                                    <input type="password" class="form-control form-control-line" autocomplete="new-password" name="password" id="password">                                    <span class="input-group-btn"> 
                                                    <button class="btn btn-inverse" style="margin-right: 15px;" name="Show" onclick="toggler(this)" id="tg" type="button"><i class="ti-eye"></i></button> 
                                                    </span>  </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo _("Path"); ?></label>
                                                <div class="col-md-12">
                                                    <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                        <div class="input-group-addon" id="dirfill"></div>
                                                        <input type="text" class="form-control" name="v_ftpdir" value="<?php echo $ftpdir[0]; ?>" style="padding-left: 0.5%;">    
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo _("Send FTP Credentials to Email:"); ?></label>
                                                <div class="col-md-12">
                                                    <input type="email" name="v_ftpnotification" autocomplete="new-password" class="form-control"> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" onclick="processLoader();"><?php echo _("Add Domain"); ?></button> &nbsp;
                                            <a href="../list/web.php" style="color: inherit;text-decoration: inherit;"><button class="btn btn-muted" type="button"><?php echo _("Back"); ?></button></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
               <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../includes/versioncheck.php'; ?> <?php echo _("by CDG Web Services"); ?>.</footer>
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
        <script src="../plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript">
            <?php 

            if(isset($pluginnames[0]) && $pluginnames[0] != '') {
                $currentplugin = 0; 
                do {
                    if (!strpos($pluginadminonly[$currentplugin] , 'y') && !strpos($pluginadminonly[$currentplugin] , 'Y')) {
                        $currentstring = "<li><a href='../plugins/" . $pluginlinks[$currentplugin] . "/' ><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";
                    }

                    else {
                             $currentstring = "<?php if($username == 'admin') { echo \"<li><a href='../plugins/" . $pluginnames[$currentplugin] . "/' ><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>\";} ?>";
                    }
                    echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');
                          var plugindata" . $currentplugin . " = \"" . $currentstring . "\";
                          plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n";
                    $currentplugin++;
                } while ($pluginnames[$currentplugin] != ''); }

            ?>
    </script>
        <script type="text/javascript">
            document.getElementById('select7').value = 'none'; 
            function showauth(){
                if(document.getElementById('select7').value != 'none') {
                    document.getElementById('statsauth').style.display = "block";
            }
            else {
                document.getElementById('statsauth').style.display = "none";
            }}
            function checkwww() {
                var domain = document.getElementById('domain').value;
                document.getElementsByClassName("aliasfill")[0].innerHTML = 'www.' + domain;
                var dirDomain = document.getElementById("dirfill");
                dirDomain.innerHTML = '/home/<?php print_r($uname); ?>/web/' + domain + '/';
            }
            function csrlink() {
                var domain = document.getElementById('domain').value;
                document.getElementsByClassName("sslfill")[0].href =  '../process/generatecsr.php?domain=' + domain;
            }
            function checkDiv(){
                if(document.getElementById("checkbox4").checked) {
                    document.getElementById('prxextdiv').style.display = 'block';
                }
                else {document.getElementById('prxextdiv').style.display = 'none';}
            }
            function checkDiv2(){
                if(document.getElementById("checkbox5").checked) {
                    document.getElementById('msg-div').style.display = 'block';
                }
                else {document.getElementById('msg-div').style.display = 'none';}
            } 
            function checkDiv3(){
                if(document.getElementById("checkbox8").checked) {
                    document.getElementById('ssl-div').style.display = 'block';
                }
                else {document.getElementById('ssl-div').style.display = 'none';}
            }
            function checkDiv4(){
                if(document.getElementById("checkbox9").checked) {
                    document.getElementById('ftp-div').style.display = 'block';
                }
                else {document.getElementById('ftp-div').style.display = 'none';}
            }
            function checkDiv5(){
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
            $('.datepicker').datepicker();
            (function () {
                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                    new CBPFWTabs(el);
                });
            })();

            jQuery(function($){
                $('.footable').footable();
            });
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
            function processLoader(){
            swal({
              title: '<?php echo _("Processing"); ?>',
              text: '',
              timer: 5000,
              onOpen: function () {
                swal.showLoading()
              }
            })};
        <?php
           if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "swal({title:'" . $errorcode[1] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            } 
        ?>
        </script>
    </body>
</html>