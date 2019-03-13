<?php

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2018 Carter Roeser <carter@cdgtech.one>
* https://cdgco.github.io/VestaWebInterface
*
* Vesta Web Interface is free software: you can redistribute it and/or modify
* it under the terms of version 3 of the GNU General Public License as published 
* by the Free Software Foundation.
*
* Vesta Web Interface is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with Vesta Web Interface.  If not, see
* <https://github.com/cdgco/VestaWebInterface/blob/master/LICENSE>.
*
*/

session_start();
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' ); exit(); };

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php?to=add/domain.php'); exit();  }

if(isset($webenabled) && $webenabled != 'true'){ header("Location: ../error-pages/403.html"); exit(); }

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user-ips','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-templates-proxy','arg1' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-stats','arg1' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-sys-config','arg1' => 'json'));

$curl0 = curl_init();
$curl1 = curl_init();
$curl2 = curl_init();
$curl3 = curl_init();
$curl4 = curl_init();
$curlstart = 0; 

while($curlstart <= 4) {
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
$sysconfigdata = array_values(json_decode(curl_exec($curl4), true))[0];
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
            if (isset($arr['name']) && !empty($arr['name']) && isset($arr['fa-icon']) && !empty($arr['fa-icon']) && isset($arr['section']) && !empty($arr['section']) && isset($arr['admin-only']) && !empty($arr['admin-only']) && isset($arr['new-tab']) && !empty($arr['new-tab']) && isset($arr['hide']) && !empty($arr['hide'])){
                array_push($pluginlinks,$result);
                array_push($pluginnames,$arr['name']);
                array_push($pluginicons,$arr['fa-icon']);
                array_push($pluginsections,$arr['section']);
                array_push($pluginadminonly,$arr['admin-only']);
                array_push($pluginnewtab,$arr['new-tab']);
                array_push($pluginhide,$arr['hide']);
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
        <link rel="icon" type="image/ico" href="../plugins/images/<?php echo $cpfavicon; ?>">
        <title><?php echo $sitetitle . ' - ' . _("Web"); ?></title>
        <link href="../plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../plugins/components/metismenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="../plugins/components/select2/select2.min.css" rel="stylesheet">
        <link href="../plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../plugins/components/sweetalert2/sweetalert2.min.css" />
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/colors/<?php if(isset($_COOKIE['theme']) && $themecolor != 'custom.css') { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <?php if($themecolor == "custom.css") { require( '../css/colors/custom.php'); } ?>
        <?php if(GOOGLE_ANALYTICS_ID != ''){ echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . GOOGLE_ANALYTICS_ID . "'></script>
        <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '" . GOOGLE_ANALYTICS_ID . "');</script>"; } ?> 
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="fix-header" onload="checkDiv3();checkDiv4();checkDiv5();showauth();">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
            </svg>
        </div>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top m-b-0">
                <div class="navbar-header">
                    <div class="top-left-part">
                        <a class="logo" href="../index.php">
                            <img src="../plugins/images/<?php echo $cpicon; ?>" alt="home" class="logo-1 dark-logo" />
                            <img src="../plugins/images/<?php echo $cplogo; ?>" alt="home" class="hidden-xs dark-logo" />
                        </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-left">
                        <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>
                        <?php notifications(); ?>
                    </ul>
                    <ul class="nav navbar-top-links navbar-right pull-right">
                        <li>
                            <form class="app-search m-r-10" id="searchform" action="../process/search.php" method="get">
                                <input type="text" placeholder="<?php echo _("Search..."); ?>" class="form-control" name="q"> <a href="javascript:void(0);" onclick="document.getElementById('searchform').submit();"><i class="fa fa-search"></i></a> </form>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"><b class="hidden-xs"><?php print_r($displayname); ?></b><span class="caret"></span> </a>
                            <ul class="dropdown-menu dropdown-user animated flipInY">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-text">
                                            <h4><?php print_r($displayname); ?></h4>
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
                        <?php indexMenu("../"); 
                              adminMenu("../admin/list/", "");
                              profileMenu("../");
                              primaryMenu("../list/", "../process/", "web");
                        ?>
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
                                <form class="form-horizontal form-material" autocomplete="off" method="post" id="form" action="../create/domain.php">
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Domain"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_domain" autocomplete="new-password" id="domain" onkeyup="checkwww();csrlink();" class="form-control" required> 
                                        </div>
                                    </div>
                                    <div class="form-group" style="overflow: visible;">
                                        <label class="col-md-12"><?php echo _("IP Address"); ?></label>
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="v_ip">
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
                                    <?php if(checkService('bind9') !== false && $admindata['DNS_DOMAINS'] != '0') { echo ""; ?>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("DNS Support"); ?></label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input id="checkbox1" name="v_dnsenabled" type="checkbox" checked>
                                                <label for="checkbox1"> <?php echo _("Enabled"); ?> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo ""; } 
                                    if(checkService('exim') !== false && $admindata['MAIL_DOMAINS'] != '0') { echo ""; ?>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Mail Support"); ?></label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input id="checkbox2" name="v_mailenabled" type="checkbox" checked>
                                                <label for="checkbox2"> <?php echo _("Enabled"); ?> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <?php echo ""; } ?>
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
                                        <?php if($sysconfigdata['PROXY_SYSTEM'] != '') { echo ""; ?>
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
                                        <?php echo ""; }?>
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
                                                    <select name="v_ssldir" class="form-control form-control-static select2" <?php if(checkService('vsftpd') === false && checkService('proftpd') === false) { echo "disabled"; } ?> <?php if($apienabled == 'true'){ echo "disabled"; } ?>>
                                                        <option value="public_html" selected>public_html</option>
                                                        <option value="public_shtml">public_shtml</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo _("SSL Certificate"); ?> / <a class="sslfill"  target="_blank"><?php echo _("Generate CSR"); ?></a></label>
                                                <div class="col-md-12">
                                                    <textarea class="form-control form-control-static" name="v_sslcrt" rows="4" <?php if(checkService('vsftpd') === false && checkService('proftpd') === false) { echo "disabled"; } ?> <?php if($apienabled == 'true'){ echo "disabled"; } ?>></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo _("SSL Key"); ?></label>
                                                <div class="col-md-12">
                                                    <textarea class="form-control form-control-static" name="v_sslkey" rows="4" <?php if(checkService('vsftpd') === false && checkService('proftpd') === false) { echo "disabled"; } ?> <?php if($apienabled == 'true'){ echo "disabled"; } ?>></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-12"><?php echo _("SSL Certificate Authority / Intermediate"); ?></label>
                                                <div class="col-md-12">
                                                    <textarea class="form-control form-control-static" name="v_sslca" rows="4" <?php if(checkService('vsftpd') === false && checkService('proftpd') === false) { echo "disabled"; } ?> <?php if($apienabled == 'true'){ echo "disabled"; } ?>></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Web Statistics"); ?></label>
                                            <div class="col-md-12">
                                                <select class="form-control select7 select2" onchange="showauth()"name="v_webstats" id="select7">
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
                                                <label for="v_statspassword" class="col-md-12"><?php echo _("Password"); ?> / <a style="cursor:pointer" onclick="generatePassword(10, 'statspassword', 'tgstats')"> <?php echo _("Generate"); ?></a></label>
                                                <div class="col-md-12 input-group" style="padding-left: 15px;">
                                                    <input type="password" class="form-control form-control-line" autocomplete="new-password" name="v_statspassword" id="statspassword">         <span class="input-group-btn"> 
                                                    <button class="btn btn-inverse" style="margin-right: 15px;" name="Show" onclick="toggler(this, 'statspassword')" id="tgstats" type="button"><i class="ti-eye"></i></button> 
                                                    </span>  
                                                </div>
                                            </div>
                                        </div>
                                        <?php if(checkService('vsftpd') !== false || checkService('proftpd') !== false) { echo ""; ?>
                                        
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Additional FTP"); ?></label>
                                            <div class="col-md-12">
                                                <div class="checkbox checkbox-info">
                                                    <input id="checkbox9" type="checkbox" name="v_additionalftpenabled" onclick="checkDiv4();">
                                                    <label for="checkbox9"> <?php echo _("Enabled"); ?> </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="ftp-div" style="margin-left: 4%;">
                                            <div class="ftp-account" accnum="1">
                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo _("FTP Account"); ?> #1</label><hr>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo _("Username"); ?></label><br>
                                                    <div class="col-md-12">
                                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                            <div class="input-group-addon"><?php echo $uname; ?>_</div>
                                                            <input type="text" class="form-control" autocomplete="new-password" name="v_ftpuname1" style="padding-left: 0.5%;">    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password" class="col-md-12"><?php echo _("Password"); ?> / <a style="cursor:pointer" onclick="generatePassword(10, 'password1', 'tg1')"> <?php echo _("Generate"); ?></a></label>
                                                    <div class="col-md-12 input-group" style="padding-left: 15px;">
                                                        <input type="password" class="form-control form-control-line" autocomplete="new-password" name="v_ftppw1" id="password1">                  <span class="input-group-btn"> 
                                                        <button class="btn btn-inverse" style="margin-right: 15px;" name="Show" onclick="toggler(this, 'password1')" id="tg1" type="button"><i class="ti-eye"></i></button> 
                                                        </span>  </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo _("Path"); ?></label>
                                                    <div class="col-md-12">
                                                        <div class="input-group mb-2 mr-sm-2 mb-sm-0">
                                                            <div class="input-group-addon dirfill"></div>
                                                            <input type="text" class="form-control" name="v_ftpdir1" style="padding-left: 0.5%;">    
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if($phpmailenabled == 'true') { echo ""; ?>
                                                <div class="form-group">
                                                    <label class="col-md-12"><?php echo _("Send FTP Credentials to Email:"); ?></label>
                                                    <div class="col-md-12">
                                                        <input type="email" name="v_ftpnotif1" autocomplete="new-password" class="form-control"> 
                                                    </div>
                                                </div>
                                                <?php echo ""; } ?>
                                            </div>
                                            <p id="FtpControl"><a href="javascript:void(0);" onclick="addFtpAccount();">Add One</a><span id="removeFtpBtn"> / <a href="javascript:void(0);" onclick="removeFtpAccount();">Remove One</a></span></p><br><br>
                                        </div>
                                        <?php echo ""; } ?>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" type="submit"><?php echo _("Add Domain"); ?></button> &nbsp;
                                            <a href="../list/web.php" style="color: inherit;text-decoration: inherit;"><button onclick="loadLoader();" class="btn btn-muted" type="button"><?php echo _("Back"); ?></button></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script> 
                    function submitForm() { document.getElementById("form").submit(); };
                    function exitForm() { window.location.href="../list/web.php"; };
                </script>
                <?php hotkeys($configlocation); ?>
                <footer class="footer text-center"><?php footer(); ?></footer>
            </div>
        </div>
        <script src="../plugins/components/jquery/jquery.min.js"></script>
        <script src="../plugins/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../plugins/components/sweetalert2/sweetalert2.min.js"></script>
        <script src="../plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../plugins/components/metismenu/dist/metisMenu.min.js"></script>
        <script src="../plugins/components/select2/select2.min.js"></script>
        <script src="../plugins/components/waves/waves.js"></script>
        <script src="../js/notifications.js"></script>
        <script src="../js/main.js"></script>
        <script type="text/javascript">
            Waves.attach('.button', ['waves-effect']);
            Waves.init();
            var processLocation = "../process/";
            $('#form').submit(function(ev) {
                ev.preventDefault();
                processLoader();
                this.submit();
            });
            <?php 
            $pluginlocation = "../plugins/"; if(isset($pluginnames[0]) && $pluginnames[0] != '') { $currentplugin = 0; do { if (strtolower($pluginhide[$currentplugin]) != 'y' && strtolower($pluginhide[$currentplugin]) != 'yes') { if (strtolower($pluginadminonly[$currentplugin]) != 'y' && strtolower($pluginadminonly[$currentplugin]) != 'yes') { if (strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; } else { $currentstring = "<li><a href='".$pluginlocation.$pluginlinks[$currentplugin]."/'><i class='fa ".$pluginicons[$currentplugin]." fa-fw'></i><span class='hide-menu'>"._($pluginnames[$currentplugin])."</span></a></li>"; }} else { if(strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";} } else { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; }}} echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');\n var plugindata" . $currentplugin . " = \"" . $currentstring . "\";\n plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n"; } $currentplugin++; } while ($pluginnames[$currentplugin] != ''); } ?>
            $('.select2').select2();
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
                
                divs = document.getElementsByClassName( 'dirfill' );

                [].slice.call( divs ).forEach(function ( div ) {
                    div.innerHTML = '/home/<?php print_r($uname); ?>/web/' + domain + '/';
                });
                
            }
            function csrlink() {
                var domain = document.getElementById('domain').value;
                document.getElementsByClassName("sslfill")[0].href =  '../process/generatecsr.php?domain=' + domain;
            }
            function checkDiv(){
                <?php if($sysconfigdata['PROXY_SYSTEM'] != '') { echo ""; ?>
                if(document.getElementById("checkbox4").checked) {
                    document.getElementById('prxextdiv').style.display = 'block';
                }
                else {document.getElementById('prxextdiv').style.display = 'none';}
                <?php echo ""; }?>
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
                <?php if(checkService('vsftpd') !== false || checkService('proftpd') !== false) { echo '
                if(document.getElementById("checkbox9").checked) {
                    document.getElementById("ftp-div").style.display = "block";
                }
                else {document.getElementById("ftp-div").style.display = "none";}'; } ?>
            }
            function checkDiv5(){
                if(document.getElementById("checkbox10").checked) {
                    document.getElementById('stats-div').style.display = 'block';
                }
                else {document.getElementById('stats-div').style.display = 'none';}
            }

            if($('.ftp-account').length >= 2) { $('#removeFtpBtn').show(); }
            else { $('#removeFtpBtn').hide(); }
            
            function addFtpAccount(){
                var startingAcc = $('#ftp-div').find('.ftp-account:last').attr('accnum');
                startingAcc++;
                var objTo = document.getElementById('FtpControl');
                var newAcc = document.createElement("div");
                newAcc.setAttribute("class", "ftp-account");
                newAcc.setAttribute("accnum", startingAcc);
                 newAcc.innerHTML = '<div class="form-group"><label class="col-md-12"><?php echo _("FTP Account"); ?> #'+startingAcc+'</label><hr></div><div class="form-group"><label class="col-md-12"><?php echo _("Username"); ?></label><br><div class="col-md-12"><div class="input-group mb-2 mr-sm-2 mb-sm-0"><div class="input-group-addon"><?php echo $uname; ?>_</div><input type="text" class="form-control" autocomplete="new-password" name="v_ftpuname'+startingAcc+'" style="padding-left: 0.5%;"></div></div></div><div class="form-group"><label for="password" class="col-md-12"><?php echo _("Password"); ?> / <a style="cursor:pointer" onclick="generatePassword(10, \'password'+startingAcc+'\', \'tg'+startingAcc+'\')"> <?php echo _("Generate"); ?></a></label><div class="col-md-12 input-group" style="padding-left: 15px;"><input type="password" class="form-control form-control-line" autocomplete="new-password" name="v_ftppw'+startingAcc+'" id="password'+startingAcc+'"><span class="input-group-btn"><button class="btn btn-inverse" style="margin-right: 15px;" name="Show" onclick="toggler(this, \'password'+startingAcc+'\')" id="tg'+startingAcc+'" type="button"><i class="ti-eye"></i></button></span></div></div><div class="form-group"><label class="col-md-12"><?php echo _("Path"); ?></label><div class="col-md-12"><div class="input-group mb-2 mr-sm-2 mb-sm-0"><div class="input-group-addon dirfill"></div><input type="text" class="form-control" name="v_ftpdir'+startingAcc+'" style="padding-left: 0.5%;"></div></div></div><?php if($phpmailenabled == 'true') { echo ""; ?><div class="form-group"><label class="col-md-12"><?php echo _("Send FTP Credentials to Email:"); ?></label><div class="col-md-12"><input type="email" name="v_ftpnotif'+startingAcc+'" autocomplete="new-password" class="form-control"></div></div><?php echo ""; } ?>';
                $('#ftp-div').find('.ftp-account:last').append(newAcc);
                if($('.ftp-account').length >= 2) { $('#removeFtpBtn').show(); }
                else { $('#removeFtpBtn').hide(); }
                checkwww();
            }
           
           function removeFtpAccount() {
               $('#ftp-div').find('.ftp-account:last').remove();
               if($('.ftp-account').length >= 2) { $('#removeFtpBtn').show(); }
                else { $('#removeFtpBtn').hide(); }
           }
            
            function toggle_visibility(id) {
                var e = document.getElementById(id);
                if(e.style.display == 'block')
                    e.style.display = 'none';
                else
                    e.style.display = 'block';
            }
            function toggler(e, f) {
                if( e.name == 'Hide' ) {
                    e.name = 'Show'
                    document.getElementById(f).type="password";
                } else {
                    e.name = 'Hide'
                    document.getElementById(f).type="text";
                }
            }
            function generatePassword(length, g, h) {
                var password = '', character; 
                while (length > password.length) {
                    if (password.indexOf(character = String.fromCharCode(Math.floor(Math.random() * 94) + 33), Math.floor(password.length / 94) * 94) < 0) {
                        password += character;
                    }
                }
                document.getElementById(g).value = password;
                document.getElementById(h).name='Hide';
                document.getElementById(g).type="text";
            }
            function processLoader(){
                swal({
                    title: '<?php echo _("Processing"); ?>',
                    text: '',
                    onOpen: function () {
                        swal.showLoading()
                    }
                })};
            function loadLoader(){
                swal({
                    title: '<?php echo _("Loading"); ?>',
                    text: '',
                    onOpen: function () {
                        swal.showLoading()
                    }
                })};
            
           <?php 
            includeScript();
            if($warningson == "all"){
                if(isset($apienabled) && $apienabled == 'true') {
                    echo "toast2({
                            title: '" . _("Feature Disabled") . "',
                            text: '" . _("Custom SSL Certificates are incompatible with API Key Authentication.") . "',
                            type: 'error'
                        });";
                } 
            }
            elseif($warningson == "admin" && $initialusername == "admin"){
                if(isset($apienabled) && $apienabled == 'true') {
                    echo "toast2({
                            title: '" . _("Feature Disabled") . "',
                            text: '" . _("Custom SSL Certificates are incompatible with API Key Authentication.") . "',
                            type: 'error'
                        });";

                } 
            }
            
            if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "swal({title:'" . $errorcode[1] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            } 
            ?>
        </script>
    </body>
</html>