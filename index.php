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

$configlocation = "includes/";
if (file_exists( 'includes/config.php' )) { require 'includes/includes.php'; }  else { header( 'Location: install' );}

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: login.php'); }

$postvarsx = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-sys-info','arg1' => 'json');

$curlx = curl_init();
curl_setopt($curlx, CURLOPT_URL, $vst_url);
curl_setopt($curlx, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curlx, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curlx, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curlx, CURLOPT_POST, true);
curl_setopt($curlx, CURLOPT_POSTFIELDS, http_build_query($postvarsx));
$serverconnection = array_values(json_decode(curl_exec($curlx), true))[0]['OS'];
if(!isset($serverconnection)) { unset($_SESSION['username']); setcookie('username', null, -1, '/'); unset($_SESSION['loggedin']); setcookie('loggedin', null, -1, '/'); header('Location: login.php'); exit;}

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-domains','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-dns-domains','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-mail-domains','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-databases','arg1' => $username,'arg2' => 'json')
);

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
$domainname = array_keys(json_decode(curl_exec($curl1), true));
$domaindata = array_values(json_decode(curl_exec($curl1), true));
$dnsname = array_keys(json_decode(curl_exec($curl2), true));
$dnsdata = array_values(json_decode(curl_exec($curl2), true));
$mailname = array_keys(json_decode(curl_exec($curl3), true));
$maildata = array_values(json_decode(curl_exec($curl3), true));
$dbname = array_keys(json_decode(curl_exec($curl4), true));
$dbdata = array_values(json_decode(curl_exec($curl4), true));

if(isset($admindata['LANGUAGE'])){ $locale = $ulang[$admindata['LANGUAGE']]; }
setlocale(LC_CTYPE, $locale);
setlocale(LC_MESSAGES, $locale);
bindtextdomain('messages', 'locale');
textdomain('messages');

$plugincustom = array();
$plugincustomcontent = array();

foreach ($plugins as $result) {
    if (file_exists('plugins/' . $result)) {
        if (file_exists('plugins/' . $result . '/manifest.xml')) {
            $get = file_get_contents('plugins/' . $result . '/manifest.xml');
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

?><!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/ico" href="plugins/images/<?php echo $cpfavicon; ?>">
        <title><?php echo $sitetitle; ?> - <?php echo _("Dashboard"); ?></title>
        <link href="plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="plugins/components/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
        <link href="plugins/components/footable/footable.bootstrap.css" rel="stylesheet">
        <link href="plugins/components/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet">
        <link href="plugins/components/metismenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link rel="stylesheet" href="plugins/components/sweetalert2/sweetalert2.min.css" />
        <link href="css/style.css" rel="stylesheet">
        <link href="css/colors/<?php if(isset($_COOKIE['theme']) && $themecolor != 'custom.css') { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <?php if($themecolor == "custom.css") { require( 'css/colors/custom.php'); } ?>
        <style>
            @media screen and (max-width: 1199px) {
                .resone { display:none !important;}
            }  
            @media screen and (max-width: 767px) {
                .restwo { display:none !important;}
            }    
            @media screen and (max-width: 540px) {
                .resthree { display:none !important;}
                .pagination > li > a, .pagination > li > span {
                    padding: 3px 9px !important;
                }
            } 
            .two-part li i {
                font-size: 36px;
                position: relative;
                top: 5px;
            }
        </style>
        <?php if(GOOGLE_ANALYTICS_ID != ''){ 
        echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . GOOGLE_ANALYTICS_ID . "'></script>
        <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '" . GOOGLE_ANALYTICS_ID . "');</script>"; } ?>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="fix-header">
        <?php if(INTERAKT_APP_ID != ''){ 
            echo '<script>
            window.mySettings = {
            first   _name: "' . $admindata['FNAME'] . '",
            last_name: "' . $admindata['LNAME'] . '",
            suspended: "' . $admindata['SUSPENDED'] . '",
            package: "' . $admindata['PACKAGE'] . '",
            language: "' . $admindata['LANGUAGE'] . '",
            uname: "' . $username . '",
            email: "' . $admindata['CONTACT'] . '",
            created_at: ' . strtotime($admindata['DATE'] . ' ' . $admindata['TIME']) . ',
            joined_at: "' . $admindata['DATE'] . ' ' . $admindata['TIME'] . '",
            app_id: "' . INTERAKT_APP_ID . '"
            };
            </script>'; } ?>
        <script async src="plugins/components/sweetalert2/sweetalert2.min.js"></script>
        <?php

        if(isset($_GET['rebuild'])){
            echo "<script> swal({title: '"; echo "Action Complete!', type: 'success'})</script>";}
        ?>
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
            </svg>
        </div>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top m-b-0">
                <div class="navbar-header">
                    <div class="top-left-part">
                        <a class="logo" href="index.php">
                            <img src="plugins/images/<?php echo $cpicon; ?>" alt="home" class="logo-1 dark-logo" />
                            <img src="plugins/images/<?php echo $cplogo; ?>" alt="home" class="hidden-xs dark-logo" />
                        </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-left">
                        <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>
                    </ul>
                    <ul class="nav navbar-top-links navbar-right pull-right">

                        <li class="dropdown">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"><b class="hidden-xs"><?php print_r($displayname); ?></b><span class="caret"></span> </a>
                            <ul class="dropdown-menu dropdown-user animated flipInY">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-text">
                                            <h4>
                                                <?php print_r($displayname); ?>
                                            </h4>
                                            <p class="text-muted">
                                                <?php print_r($admindata['CONTACT']); ?>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li role="separator" class="divider"></li>
                                <li><a href="profile.php"><i class="ti-home"></i> <?php echo _("My Account"); ?></a></li>
                                <li><a href="profile.php?settings=open"><i class="ti-settings"></i> <?php echo _("Account Settings"); ?></a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="process/logout.php"><i class="fa fa-power-off"></i> <?php echo _("Logout"); ?></a></li>
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
                        <?php indexMenu("./"); 
                              adminMenu("admin/list/", "");
                              profileMenu("./");
                              primaryMenu("list/", "process/", "");
                        ?>
                    </ul>
                </div>
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title" style="overflow:visible;">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title"><?php echo _("Host Dashboard"); ?></h4>
                        </div>
                        <div class="col-lg-2 col-sm-8 col-md-8 col-xs-12 pull-right restwo">
                            <div class="btn-group bootstrap-select input-group-btn" style="margin-right:257px;width:220px;">
                                <form id="rebuildform" action="process/rebuild.php" method="post">
                                    <select class="selectpicker pull-right m-l-20" name="action" data-style="form-control">
                                        <option value="rebuild-user"><?php echo _("Rebuild Account"); ?></option>
                                        <?php if ($webenabled == 'true') { echo '<option value="rebuild-web-domains">' . _("Rebuild Web") . '</option>'; } ?>
                                        <?php if ($dnsenabled == 'true') { echo '<option value="rebuild-dns-domains">' . _("Rebuild DNS") . '</option>'; } ?>
                                        <?php if ($mailenabled == 'true') { echo '<option value="rebuild-mail-domains">' . _("Rebuild Mail") . '</option>'; } ?>
                                        <?php if ($dbenabled == 'true') { echo '<option value="rebuild-databases">' . _("Rebuild DB") . '</option>'; } ?>
                                        <option value="rebuild-cron-jobs"><?php echo _("Rebuild Cron"); ?></option>
                                        <option value="update-user-counters"><?php echo _("Update Counters"); ?></option>
                                    </select>
                                    <input type="hidden" name="user" value="<?php echo $username; ?>" />
                                </form>
                            </div>
                            <div class="input-group-btn">
                                <button type="button" onclick='document.getElementById("rebuildform").submit();swal({title: "<?php echo _('Processing'); ?>", text: "",timer: 5000,onOpen: function () {swal.showLoading();}}).then(function () {},function (dismiss) {if (dismiss === "timer") {}})' class=" pull-right btn waves-effect waves-light color-button" style="left: -2px;"><i class="ti-angle-right"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="white-box">
                                <div class="row row-in">
                                    <div class="col-lg-3 col-sm-6 row-in-br">
                                        <ul class="col-in">
                                            <li>
                                                <span class="circle circle-md bg-danger"><i class="fa fa-cloud"></i></span>
                                            <li class="col-last">
                                                <h2 class="counter text-right m-t-15">
                                                    <?php echo formatMBNumOnly($admindata['U_BANDWIDTH'])." ".formatMBUnitOnly($admindata['U_BANDWIDTH'])." / ".formatMBNumOnly($admindata['BANDWIDTH'])." ".formatMBUnitOnly($admindata['BANDWIDTH']); ?>
                                                </h2>
                                            </li>
                                        </li><br><br>
                                        <li class="col-middle">
                                            <h4><?php echo _("Bandwidth"); ?></h4>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-sm-6 row-in-br  b-r-none">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-info"><i class="ti-harddrive"></i></span>
                                        </li>
                                        <li class="col-last">
                                            <h2 class="counter text-right m-t-15">
                                                <?php echo formatMBNumOnly($admindata['U_DISK'])." ".formatMBUnitOnly($admindata['U_DISK'])." / ".formatMBNumOnly($admindata['DISK_QUOTA'])." ".formatMBUnitOnly($admindata['DISK_QUOTA']); ?>
                                            </h2>
                                        </li>
                                        <br><br>
                                        <li class="col-middle">
                                            <h4><?php echo _("Disk Space"); ?></h4>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-sm-6 row-in-br">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-success"><i class=" ti-world"></i></span>
                                        </li>
                                        <li class="col-last">
                                            <h2 class="text-right m-t-15">
                                                <?php print_r($admindata['U_WEB_DOMAINS']); ?> /
                                                <?php if($admindata['WEB_DOMAINS'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($admindata['WEB_DOMAINS']); } ?>
                                            </h2>
                                        </li><br><br>
                                        <li class="col-middle">
                                            <h4><?php echo _("Web Domains"); ?></h4>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-3 col-sm-6  b-0">
                                    <ul class="col-in">
                                        <li>
                                            <span class="circle circle-md bg-warning"><i class="fa fa-envelope"></i></span>
                                        </li>
                                        <li class="col-last">
                                            <h2 class="text-right m-t-15">
                                                <?php print_r($admindata['U_MAIL_ACCOUNTS']); ?> /
                                                <?php if($admindata['MAIL_ACCOUNTS'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($admindata['MAIL_ACCOUNTS'] * $admindata['MAIL_DOMAINS']); } ?>
                                            </h2>
                                        </li><br><br>
                                        <li class="col-middle">
                                            <h4><?php echo _("Email Addresses"); ?></h4>

                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-8 col-lg-9">
                            <div class="manage-users">
                                <div class="sttabs tabs-style-iconbox">
                                    <nav>
                                        <ul>
                                            <?php if ($webenabled == 'true') { echo '<li><a href="#section-iconbox-1" class="sticon ti-world"><span>' . _("Web") . '</span></a></li>'; } ?>
                                            <?php if ($dnsenabled == 'true') { echo '<li><a href="#section-iconbox-2" class="sticon fa fa-sitemap"><span>' . _("DNS") . '</span></a></li>'; } ?>
                                            <?php if ($mailenabled == 'true') { echo '<li><a href="#section-iconbox-3" class="sticon fa fa-envelope"><span>' . _("Mail") . '</span></a></li>'; } ?>
                                            <?php if ($dbenabled == 'true') { echo '<li><a href="#section-iconbox-4" class="sticon fa fa-database"><span>' . _("Database") . '</span></a></li>'; } ?>
                                        </ul>
                                    </nav>
                                    <div class="content-wrap">
                                        <?php if ($webenabled != 'true') { echo '<!--';} ?>
                                        <section id="section-iconbox-1">
                                            <div class="p-20 row">
                                                <div class="col-sm-6">
                                                    <h3 class="m-t-0"><?php echo _("Manage Web Domains"); ?></h3>
                                                </div>
                                                <div class="col-sm-6 resone">
                                                    <ul class="side-icon-text pull-right">
                                                        <li><a href="add/domain.php"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span><?php echo _("Add Domain"); ?></span></a></li>
                                                        <li><a href="list/web.php"><span class="circle circle-sm bg-danger di"><i class="ti-pencil-alt"></i></span><span><?php echo _("Manage"); ?></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="table-responsive manage-table">
                                                <table class="table footable m-b-0" data-paging-size="5" data-paging="true" cellspacing="14"  data-page-size="5"  data-sorting="true">
                                                    <thead>
                                                        <tr>
                                                            <th data-toggle="true"><?php echo _("DOMAIN"); ?></th>
                                                            <th class="resthree" data-type="numeric"><?php echo _("DISK"); ?></th>
                                                            <th class="resthree" data-type="numeric"><?php echo _("BANDWIDTH"); ?></th>
                                                            <th class="resone"><?php echo _("SSL"); ?></th>
                                                            <th class="resone"><?php echo _("STATUS"); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody><?php
                                                        if($domainname[0] != '') {
                                                            $x1 = 0; 

                                                            do {
                                                                echo '<tr class="advance-table-row clickable-row" data-href="edit/domain.php?domain='.$domainname[$x1].'">
                                                                        <td>' . $domainname[$x1] . '</td>
                                                                        <td class="resthree" data-sort-value="' . $domaindata[$x1]['U_DISK'] . '">' . formatMB($domaindata[$x1]['U_DISK']) . '</td>
                                                                        <td class="resthree" data-sort-value="' . $domaindata[$x1]['U_BANDWIDTH'] . '">' . formatMB($domaindata[$x1]['U_BANDWIDTH']) . '</td>
                                                                        <td class="resone">';                                                                   
                                                                if($domaindata[$x1]['SSL'] == "yes"){ 
                                                                    echo '<span class="label label-table label-success">' . _("Enabled") . '</span>';} 
                                                                else{ 
                                                                    echo '<span class="label label-table label-danger">' . _("Disabled") . '</span>';} 
                                                                echo '</td><td class="resone">';                                                                   
                                                                if($domaindata[$x1]['SUSPENDED'] == "no"){ 
                                                                    echo '<span class="label label-table label-success">' . _("Active") . '</span>';} 
                                                                else{ 
                                                                    echo '<span class="label label-table label-danger">' . _("Suspended") . '</span>';} 
                                                                echo '</td>
                                                                    </tr>';
                                                                $x1++;
                                                            } while (isset($domainname[$x1])); }

                                                        ?></tbody>
                                                </table>
                                            </div>

                                        </section><?php if ($webenabled != 'true') { echo '-->';} ?>
                                        <?php if ($dnsenabled != 'true') { echo '<!--';} ?>
                                        <section id="section-iconbox-2">
                                            <div class="p-20 row">
                                                <div class="col-sm-6">
                                                    <h3 class="m-t-0"><?php echo _("Manage DNS Domains"); ?></h3>
                                                </div>
                                                <div class="col-sm-6 resone">
                                                    <ul class="side-icon-text pull-right">
                                                        <li><a href="add/dns.php"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span><?php echo _("Add DNS"); ?></span></a></li>
                                                        <li><a href="list/dns.php"><span class="circle circle-sm bg-danger di"><i class="ti-pencil-alt"></i></span><span><?php echo _("Manage"); ?></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="table-responsive manage-table">
                                                <table class="table footable m-b-0" data-paging-size="5" data-paging="true" cellspacing="14"  data-page-size="5"  data-sorting="true">
                                                    <thead>
                                                        <tr>
                                                            <th data-toggle="true"><?php echo _("DOMAIN"); ?></th>
                                                            <th class="resthree" data-type="numeric"><?php echo _("RECORDS"); ?></th>
                                                            <th class="resone"><?php echo _("STATUS"); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody><?php
                                                        if($dnsname[0] != '') {
                                                            $x2 = 0; 

                                                            do {
                                                                if(count(explode('.', $requestdns)) > 2) { 
                                                                    $sub = 'yes';
                                                                } else{ 
                                                                    $sub = 'no'; 
                                                                } 
                                                                if ($sub == "no") {
                                                                    if (CLOUDFLARE_EMAIL != '' && CLOUDFLARE_API_KEY != ''){
                                                                        $cfenabled = curl_init();

                                                                        curl_setopt($cfenabled, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones?name=" . $dnsname[$x2]);
                                                                        curl_setopt($cfenabled, CURLOPT_RETURNTRANSFER,true);
                                                                        curl_setopt($cfenabled, CURLOPT_SSL_VERIFYPEER, false);
                                                                        curl_setopt($cfenabled, CURLOPT_SSL_VERIFYHOST, false);
                                                                        curl_setopt($cfenabled, CURLOPT_CUSTOMREQUEST, "GET");
                                                                        curl_setopt($cfenabled, CURLOPT_HTTPHEADER, array(
                                                                            "X-Auth-Email: " . CLOUDFLARE_EMAIL,
                                                                            "X-Auth-Key: " . CLOUDFLARE_API_KEY));

                                                                        $cfdata = array_values(json_decode(curl_exec($cfenabled), true));
                                                                        $cfid = $cfdata[0][0]['id'];
                                                                        $cfname = $cfdata[0][0]['name'];
                                                                        if ($cfname != '' && isset($cfname) && $cfname == $dnsname[$x2]){

                                                                            $cfns = curl_init();
                                                                            curl_setopt($cfns, CURLOPT_URL, $vst_url);
                                                                            curl_setopt($cfns, CURLOPT_RETURNTRANSFER,true);
                                                                            curl_setopt($cfns, CURLOPT_SSL_VERIFYPEER, false);
                                                                            curl_setopt($cfns, CURLOPT_SSL_VERIFYHOST, false);
                                                                            curl_setopt($cfns, CURLOPT_POST, true);
                                                                            curl_setopt($cfns, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-dns-records','arg1' => $username,'arg2' => $dnsname[$x2], 'arg3' => 'json')));

                                                                            $cfdata = array_values(json_decode(curl_exec($cfns), true));

                                                                            $cfnumber = array_keys(json_decode(curl_exec($cfns), true));
                                                                            $requestArr = array_column(json_decode(curl_exec($cfns), true), 'TYPE');
                                                                            $requestrecord = array_search('NS', $requestArr);

                                                                            $nsvalue = $cfdata[$requestrecord]['VALUE'];
                                                                            if( strpos( $nsvalue, '.ns.cloudflare.com' ) !== false ) {
                                                                                $cfrecords = curl_init();

                                                                                curl_setopt($cfrecords, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/" . $cfid . "/dns_records");
                                                                                curl_setopt($cfrecords, CURLOPT_RETURNTRANSFER,true);
                                                                                curl_setopt($cfrecords, CURLOPT_SSL_VERIFYPEER, false);
                                                                                curl_setopt($cfrecords, CURLOPT_SSL_VERIFYHOST, false);
                                                                                curl_setopt($cfrecords, CURLOPT_CUSTOMREQUEST, "GET");
                                                                                curl_setopt($cfrecords, CURLOPT_HTTPHEADER, array(
                                                                                    "X-Auth-Email: " . CLOUDFLARE_EMAIL,
                                                                                    "X-Auth-Key: " . CLOUDFLARE_API_KEY));

                                                                                $cfdata2 = array_values(json_decode(curl_exec($cfrecords), true));
                                                                                $cfcount = $cfdata2[1]['count'];

                                                                                echo '<tr class="advance-table-row clickable-row" data-href="list/cfdomain.php?domain='.$dnsname[$x2].'">
                                                                                        <td>' . $dnsname[$x2] . '</td><td class="resthree" data-sort-value="' . $cfcount . '">' . $cfcount . '</td>';
                                                                                $recordcount = $recordcount + $cfcount;
                                                                            }
                                                                            else { echo '<tr class="advance-table-row clickable-row" data-href="list/dnsdomain.php?domain='.$dnsname[$x2].'">
                                                                                        <td>' . $dnsname[$x2] . '</td><td class="resthree" data-sort-value="' . $dnsdata[$x2]['RECORDS'] . '">' . $dnsdata[$x2]['RECORDS'] . '</td>'; 
                                                                                  $recordcount = $recordcount + $dnsdata[$x2]['RECORDS'];}
                                                                        }
                                                                        else { echo '<tr class="advance-table-row clickable-row" data-href="list/dnsdomain.php?domain='.$dnsname[$x2].'">
                                                                                        <td>' . $dnsname[$x2] . '</td><td class="resthree" data-sort-value="' . $dnsdata[$x2]['RECORDS'] . '">' . $dnsdata[$x2]['RECORDS'] . '</td>'; 
                                                                              $recordcount = $recordcount + $dnsdata[$x2]['RECORDS'];}
                                                                    }
                                                                    else { echo '<tr class="advance-table-row clickable-row" data-href="list/dnsdomain.php?domain='.$dnsname[$x2].'">
                                                                                        <td>' . $dnsname[$x2] . '</td><td class="resthree" data-sort-value="' . $dnsdata[$x2]['RECORDS'] . '">' . $dnsdata[$x2]['RECORDS'] . '</td>'; 
                                                                          $recordcount = $recordcount + $dnsdata[$x2]['RECORDS'];}
                                                                }
                                                                else { echo '<tr class="advance-table-row clickable-row" data-href="list/dnsdomain.php?domain='.$dnsname[$x2].'">
                                                                                        <td>' . $dnsname[$x2] . '</td><td class="resthree" data-sort-value="' . $dnsdata[$x2]['RECORDS'] . '">' . $dnsdata[$x2]['RECORDS'] . '</td>'; 
                                                                      $recordcount = $recordcount + $dnsdata[$x2]['RECORDS']; }
                                                                echo '<td class="resone">';                                                                   
                                                                if($dnsdata[$x2]['SUSPENDED'] == "no"){ 
                                                                    echo '<span class="label label-table label-success">' . _("Active") . '</span>';} 
                                                                else{ 
                                                                    echo '<span class="label label-table label-danger">' . _("Suspended") . '</span>';} 
                                                                echo '</td>
                                                                                    </tr>';
                                                                $x2++;
                                                            } while (isset($dnsname[$x2])); }

                                                        ?></tbody>
                                                </table>
                                            </div>
                                        </section><?php if ($dnsenabled != 'true') { echo '-->';} ?>
                                        <?php if ($mailenabled != 'true') { echo '<!--';} ?>
                                        <section id="section-iconbox-3">
                                            <div class="p-20 row">
                                                <div class="col-sm-6">
                                                    <h3 class="m-t-0"><?php echo _("Manage Mail Domains"); ?></h3>
                                                </div>
                                                <div class="col-sm-6 resone">
                                                    <ul class="side-icon-text pull-right">
                                                        <li><a href="add/mail.php"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span><?php echo _("Add Mail"); ?></span></a></li>
                                                        <li><a href="list/mail.php"><span class="circle circle-sm bg-danger di"><i class="ti-pencil-alt"></i></span><span><?php echo _("Manage"); ?></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="table-responsive manage-table">
                                                <table class="table footable m-b-0" data-paging-size="5" data-paging="true" cellspacing="14"  data-page-size="5"  data-sorting="true">
                                                    <thead>
                                                        <tr>
                                                            <th data-toggle="true"><?php echo _("DOMAIN"); ?></th>
                                                            <th class="resthree" data-type="numeric"><?php echo _("ACCOUNTS"); ?></th>
                                                            <th class="resone"><?php echo _("STATUS"); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody><?php
                                                        if($mailname[0] != '') {
                                                            $x3 = 0; 

                                                            do {
                                                                echo '<tr class="advance-table-row clickable-row" data-href="list/maildomain.php?domain='.$mailname[$x3].'">
                                                                    <td>' . $mailname[$x3] . '</td>
                                                                    <td class="resthree" data-sort-value="' . $maildata[$x3]['ACCOUNTS'] . '">' . $maildata[$x3]['ACCOUNTS'] . '</td>
                                                                    <td class="resone">';                                                                   
                                                                    if($maildata[$x3]['SUSPENDED'] == "no"){ 
                                                                        echo '<span class="label label-table label-success">' . _("Active") . '</span>';} 
                                                                    else{ 
                                                                        echo '<span class="label label-table label-danger">' . _("Suspended") . '</span>';} 
                                                                    echo '</td>
                                                                </tr>';
                                                                $x3++;
                                                            } while (isset($mailname[$x3])); }

                                                        ?></tbody>
                                                </table>
                                            </div>
                                        </section><?php if ($mailenabled != 'true') { echo '-->';} ?>
                                        <?php if ($dbenabled != 'true') { echo '<!--';} ?>
                                        <section id="section-iconbox-4">
                                            <div class="p-20 row">
                                                <div class="col-sm-6">
                                                    <h3 class="m-t-0"><?php echo _("Manage Databases"); ?></h3>
                                                </div>
                                                <div class="col-sm-6 resone">
                                                    <ul class="side-icon-text pull-right">
                                                        <li><a href="add/db.php"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span><?php echo _("Add Database"); ?></span></a></li>
                                                        <li><a href="list/db.php"><span class="circle circle-sm bg-danger di"><i class="ti-pencil-alt"></i></span><span><?php echo _("Manage"); ?></span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="table-responsive manage-table">
                                                <table class="table footable m-b-0" data-paging-size="5" data-paging="true" cellspacing="14"  data-page-size="5"  data-sorting="true">
                                                    <thead>
                                                        <tr>
                                                            <th data-toggle="true"><?php echo _("DATABASE"); ?></th>
                                                            <th class="resthree"><?php echo _("USER"); ?></th>
                                                            <th class="resone"><?php echo _("STATUS"); ?></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody><?php
                                                        if($dbname[0] != '') {
                                                            $x4 = 0; 

                                                            do {
                                                                echo '<tr class="advance-table-row clickable-row" data-href="edit/db.php?db='.$dbdata[$x4]['DATABASE'].'">
                                                                    <td>' . $dbdata[$x4]['DATABASE'] . '</td>
                                                                    <td class="resthree">' . $dbdata[$x4]['DBUSER'] . '</td>
                                                                    <td class="resone">';                                                                   
                                                                    if($dbdata[$x4]['SUSPENDED'] == "no"){ 
                                                                        echo '<span class="label label-table label-success">Active</span>';} 
                                                                    else{ 
                                                                        echo '<span class="label label-table label-danger">Suspended</span>';} 
                                                                    echo '</td>
                                                                </tr>';
                                                                $x4++;
                                                            } while (isset($dbname[$x4])); }

                                                        ?></tbody>
                                                </table>
                                            </div>
                                        </section><?php if ($dbenabled != 'true') { echo '-->';} ?>
                                    </div>
                                </div>
                            </div> 
                        </div> 
                        <div <?php if ($webenabled != 'true' && $dnsenabled != 'true' && $mailenabled != 'true' && $dbenabled != 'true') {echo 'style="display:none;"';} ?> class="col-lg-3 col-md-6">
                            <div class="white-box">
                                <h3 class="box-title"><?php echo _("Disk Quota Used"); ?></h3>
                                <ul class="country-state  p-t-20">

                                    <li>
                                        <h2>
                                            <?php echo formatMB($admindata['U_DISK']); ?></h2> <small><?php echo _("Total Disk Space"); ?></small>
                                        <div class="pull-right"><?php 
                                            if ($admindata['DISK_QUOTA'] != 0) {
                                                $diskpercent = (($admindata['U_DISK'] / $admindata['DISK_QUOTA']) * 100);
                                            } else { $diskpercent = '0'; }
                                            if(is_infinite($diskpercent)){ echo "0";}else{echo round($diskpercent);} ?>%</div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php if($diskpercent == " INF "){ echo "0 ";}else{echo $diskpercent;} ?>%;"> <span class="sr-only"><?php if($diskpercent == "INF"){ echo "0";}else{echo $diskpercent;} ?>%;">% Complete</span></div>
                                        </div>
                                    </li>
                                </ul><br><br>
                                <h3 class="box-title"><?php echo _("Disk Usage Breakdown"); ?></h3>
                                <ul class="country-state  p-t-20">
                                    <li>
                                        <h2>
                                            <?php  
                                                if ($admindata['U_DISK'] != 0) { $diskpercent1 = (($admindata['U_DISK_WEB'] / $admindata['U_DISK']) * 100); } 
                                                else { $diskpercent1 = '0'; } 
                                                echo formatMB($admindata['U_DISK_WEB']); 
                                            ?></h2> <small><?php echo _("Web Data"); ?></small>
                                        <div class="pull-right">
                                            <?php if($diskpercent1 == "INF"){ echo "0";}else{echo round($diskpercent1);} ?>%</div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php if($diskpercent1 == " INF "){ echo "0 ";}else{echo $diskpercent1;} ?>%;"> <span class="sr-only"><?php if($diskpercent1 == "INF"){ echo "0";}else{echo round($diskpercent1);} ?>% Complete</span></div>
                                        </div>
                                    </li>
                                    <li>
                                        <h2><?php 
                                                if ($admindata['U_DISK'] != '0') { $diskpercent2 = (($admindata['U_DISK_MAIL'] / $admindata['U_DISK']) * 100); } 
                                                else { $diskpercent2 = '0'; } 
                                                echo formatMB($admindata['U_DISK_MAIL']); 
                                            ?></h2> <small><?php echo _("Mail Data"); ?></small>
                                        <div class="pull-right">
                                            <?php if($diskpercent2 == "INF"){ echo "0";}else{echo round($diskpercent2);} ?>%</div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php if($diskpercent2 == " INF "){ echo "0 ";}else{echo $diskpercent2;} ?>%;"> <span class="sr-only"><?php if($diskpercent2 == "INF"){ echo "0";}else{echo round($diskpercent2);} ?>% Complete</span></div>
                                        </div>
                                    </li>
                                    <li>
                                        <h2>
                                            <?php 
                                                if ($admindata['U_DISK'] != '0') { $diskpercent3 = (($admindata['U_DISK_DB'] / $admindata['U_DISK']) * 100); } 
                                                else {  $diskpercent3 = '0'; } 
                                                echo formatMB($admindata['U_DISK_DB']); 
                                            ?></h2> <small><?php echo _("Databases"); ?></small>
                                        <div class="pull-right">
                                            <?php if($diskpercent3 == "INF"){ echo "0";}else{echo round($diskpercent3);} ?>%</div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php if($diskpercent3 == " INF "){ echo "0 ";}else{echo $diskpercent3;} ?>%;"> <span class="sr-only"><?php if($diskpercent3 == "INF"){ echo "0";}else{echo round($diskpercent3);} ?>% Complete</span></div>
                                        </div>
                                    </li>
                                    <li>
                                        <h2>
                                            <?php 
                                                if ($admindata['U_DISK'] != '0') { $diskpercent4 = (($admindata['U_DISK_DIRS'] / $admindata['U_DISK']) * 100); } 
                                                else { $diskpercent4 = '0'; } 
                                                echo formatMB($admindata['U_DISK_DIRS']); 
                                            ?></h2> <small><?php echo _("User Directories"); ?></small>
                                        <div class="pull-right">
                                            <?php if($diskpercent4 == "INF"){ echo "0";}else{echo round($diskpercent4);} ?>%</div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:<?php if($diskpercent4 == " INF "){ echo "0 ";}else{echo $diskpercent4;} ?>%;"> <span class="sr-only"><?php if($diskpercent4 == "INF"){ echo "0";}else{echo round($diskpercent4);} ?>% Complete</span></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-6 col-xs-12">
                                        <div class="white-box" style="margin:14px;">
                                            <h3 class="box-title"><?php echo _("DNS Domains"); ?></h3>
                                            <ul class="list-inline two-part">
                                                <li><i class="fa fa-list-alt text-danger"></i></li>
                                                <li class="text-right">
                                                    <h1>
                                                        <?php echo $admindata['U_DNS_DOMAINS']; ?> /
                                                        <?php if($admindata['DNS_DOMAINS'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($admindata['DNS_DOMAINS']); } ?>
                                                    </h1>
                                                </li><br><br>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-xs-12">
                                        <div class="white-box" style="margin:14px;">
                                            <h3 class="box-title"><?php echo _("DNS Records"); ?></h3>
                                            <ul class="list-inline two-part">
                                                <li><i class="fa fa-sitemap text-danger"></i></li>
                                                <li class="text-right">
                                                    <h1 id="recordcount">
                                                    </h1>
                                                </li><br><br>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-xs-12">
                                        <div class="white-box" style="margin:14px;">
                                            <h3 class="box-title"><?php echo _("Mail Domains"); ?></h3>
                                            <ul class="list-inline two-part">
                                                <li><i class="fa fa-envelope-square text-warning"></i></li>
                                                <li class="text-right">
                                                    <h1>
                                                        <?php echo $admindata['U_MAIL_DOMAINS']; ?> /
                                                        <?php if($admindata['MAIL_DOMAINS'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($admindata['MAIL_DOMAINS']); } ?>
                                                    </h1>
                                                </li><br><br>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-6 col-xs-12">
                                        <div class="white-box" style="margin:14px;">
                                            <h3 class="box-title"><?php echo _("Backups"); ?></h3>
                                            <ul class="list-inline two-part">
                                                <li><i class="ti-cloud-up text-info"></i></li>
                                                <li class="text-right">
                                                    <h1>
                                                        <?php echo $admindata['U_BACKUPS']; ?> /
                                                        <?php if($admindata['BACKUPS'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($admindata['BACKUPS']); } ?>
                                                    </h1>
                                                </li><br><br>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12 restwo">
                                <div class="news-slide m-b-30 dashboard-slide">
                                    <div class="vcarousel slide" style="margin:14px;">
                                        <div class="carousel-inner" style="height:415px;">
                                            <div class="active item">
                                                <div class="overlaybg"><img src="plugins/images/profile-menu.png" /></div>
                                                <div class="news-content"><span class="label label-danger label-rounded"><?php echo _("Account Details"); ?></span><br>

                                                    <div class="columnleft" style="margin-top:10px; float: left;">
                                                        <h2 style="width: 200%;"><?php echo _("Username"); ?>:
                                                            <?php print_r($username); ?><br><?php echo _("Email"); ?>:
                                                            <?php print_r($admindata['CONTACT']); ?><br><br> <?php echo _("Plan"); ?>:
                                                            <?php print_r($admindata['PACKAGE']); ?><br><?php echo _("Bandwidth"); ?>:
                                                            <?php if($admindata['BANDWIDTH'] == "unlimited"){ echo "Unlimited";} else { print_r($admindata['BANDWIDTH'] . " mb");} ?> <br><?php echo _("Disk Quota"); ?>:
                                                            <?php if($admindata['DISK_QUOTA'] == "unlimited"){ echo "Unlimited";} else { print_r($admindata['DISK_QUOTA'] . " mb");} ?>
                                                        </h2>


                                                    </div>

                                                    <div class="columnright" style="margin-top:10px; margin-right:80px;float: right;">
                                                        <h2><?php echo _("Nameservers"); ?>: <br>
                                                            <ul class="dashed">
                                                                <?php 
                                                                $nsArray = explode(',', ($admindata['NS'])); 

                                                                foreach ($nsArray as &$value) {
                                                                    $value = "<li>" . $value . "</li>";
                                                                }  
                                                                foreach($nsArray as $val) {
                                                                    echo $val;
                                                                } 
                                                                ?>
                                                            </ul>
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-xs-12">
                                <div class="white-box" style="margin:14px;">
                                    <h3 class="box-title"><?php echo _("Databases"); ?></h3>
                                    <ul class="list-inline two-part">
                                        <li><i class="fa fa-database text-purple"></i></li>
                                        <li class="text-right">
                                            <h1>
                                                <?php echo $admindata['U_DATABASES']; ?> /
                                                <?php if($admindata['DATABASES'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($admindata['DATABASES']); } ?>
                                            </h1>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-xs-12">
                                <div class="white-box" style="margin:14px;">
                                    <h3 class="box-title"><?php echo _("Cron Jobs"); ?></h3>
                                    <ul class="list-inline two-part">
                                        <li><i class="ti-timer text-inverse"></i></li>
                                        <li class="text-right">
                                            <h1>
                                                <?php echo $admindata['U_CRON_JOBS']; ?> /
                                                <?php if($admindata['CRON_JOBS'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($admindata['CRON_JOBS']); } ?>
                                            </h1>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <div class="white-box" style="margin:14px;">
                                    <h3 class="box-title"><?php echo _("Web Aliases"); ?></h3>
                                    <ul class="list-inline two-part">
                                        <li><i class="ti-layers text-success"></i></li>
                                        <li class="text-right">
                                            <h1>
                                                <?php echo $admindata['U_WEB_ALIASES']; ?> /
                                                <?php if($admindata['WEB_ALIASES'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($admindata['WEB_ALIASES'] * $admindata['WEB_DOMAINS']); } ?>
                                            </h1>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php hotkeys($configlocation); ?>
                    <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require 'includes/versioncheck.php'; ?> <?php echo _("by Carter Roeser"); ?>.</footer>
                </div>
            </div>
        </div>
        <script src="plugins/components/jquery/jquery.min.js"></script>
        <script src="plugins/components/jquery-toast-plugin/jquery.toast.min.js"></script>
        <script src="plugins/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="plugins/components/jquery-overlaps/jquery.overlaps.js"></script>
        <script src="plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="plugins/components/bootstrap-select/js/bootstrap-select.min.js"></script>
        <script src="plugins/components/metismenu/dist/metisMenu.min.js"></script>
        <script src="plugins/components/moment/moment.min.js"></script>
        <script src="plugins/components/footable/footable.min.js"></script>
        <script src="plugins/components/waves/waves.js"></script>
        <script src="js/main.js"></script>
        <script type="text/javascript">
            <?php 
            
            $pluginlocation = "plugins/"; if(isset($pluginnames[0]) && $pluginnames[0] != '') { $currentplugin = 0; do { if (strtolower($pluginhide[$currentplugin]) != 'y' && strtolower($pluginhide[$currentplugin]) != 'yes') { if (strtolower($pluginadminonly[$currentplugin]) != 'y' && strtolower($pluginadminonly[$currentplugin]) != 'yes') { if (strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; } else { $currentstring = "<li><a href='".$pluginlocation.$pluginlinks[$currentplugin]."/'><i class='fa ".$pluginicons[$currentplugin]." fa-fw'></i><span class='hide-menu'>"._($pluginnames[$currentplugin])."</span></a></li>"; }} else { if(strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";} } else { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; }}} echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');\n var plugindata" . $currentplugin . " = \"" . $currentstring . "\";\n plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n"; } $currentplugin++; } while ($pluginnames[$currentplugin] != ''); } 
            
            includeScript(); 
            
            ?>
            Waves.attach('.button', ['waves-effect']);
            Waves.init();
            
            document.getElementById("recordcount").innerHTML = "<?php if ($recordcount == "") { echo "0";} else { echo $recordcount; } ?>  / <?php if($admindata['DNS_RECORDS'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($admindata['DNS_DOMAINS'] * $admindata['DNS_RECORDS']); } ?>";
            
            (function($){
                window.onresize = function(event) {
                    if ($('#columnleft').overlaps('#columnright')) {
                        $('#columnright').hide();
                    }
                };
            });
            jQuery(document).ready(function($) {
                $(".clickable-row").click(function() {
                    window.location = $(this).data("href");
                });
            });
            jQuery(function($){
                $('.footable').footable();
            });
            
            !function(t){"use strict";function s(t,s){for(var i in s)s.hasOwnProperty(i)&&(t[i]=s[i]);return t}function i(t,i){this.el=t,this.options=s({},this.options),s(this.options,i),this._init()}i.prototype.options={start:0},i.prototype._init=function(){this.tabs=[].slice.call(this.el.querySelectorAll("nav > ul > li")),this.items=[].slice.call(this.el.querySelectorAll(".content-wrap > section")),this.current=-1,this._show(),this._initEvents()},i.prototype._initEvents=function(){var t=this;this.tabs.forEach(function(s,i){s.addEventListener("click",function(s){s.preventDefault(),t._show(i)})})},i.prototype._show=function(t){this.current>=0&&(this.tabs[this.current].className=this.items[this.current].className=""),this.current=void 0!==t?t:this.options.start>=0&&this.options.start<this.items.length?this.options.start:0,this.tabs[this.current].className="tab-current",this.items[this.current].className="content-current"},t.CBPFWTabs=i}(window);
            
            (function() { [].slice.call(document.querySelectorAll('.sttabs')).forEach(function(el) { new CBPFWTabs(el); }); })();
        </script>
        <?php if(INTERAKT_APP_ID != ''){ echo '
            <script>
              (function() {
              var interakt = document.createElement("script");
              interakt.type = "text/javascript"; interakt.async = true;
              interakt.src = "//cdn.interakt.co/interakt/' . INTERAKT_APP_ID . '.js";
              var scrpt = document.getElementsByTagName("script")[0];
              scrpt.parentNode.insertBefore(interakt, scrpt);
              })()
            </script>'; } ?>

    </body>
</html>