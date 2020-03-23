<?php

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2020 Carter Roeser <carter@cdgtech.one>
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
else { header('Location: ../login.php?to=add/cron.php'); exit();  }

if(isset($cronenabled) && $cronenabled != 'true'){ header("Location: ../error-pages/403.html"); exit(); }

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'));

$curl0 = curl_init();
$curlstart = 0; 

while($curlstart <= 0) {
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
if(isset($admindata['LANGUAGE'])){ $locale = $ulang[$admindata['LANGUAGE']]; }
_setlocale(LC_CTYPE, $locale); _setlocale(LC_MESSAGES, $locale);
_bindtextdomain('messages', '../locale');
_textdomain('messages');

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
        <title><?php echo $sitetitle; ?> - <?php echo __("Cron Jobs"); ?></title>
        <link href="../plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../plugins/components/metismenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="../plugins/components/select2/select2.min.css" rel="stylesheet">
        <link href="../plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../plugins/components/sweetalert2/sweetalert2.min.css" />
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/colors/<?php if(isset($_COOKIE['theme']) && $themecolor != 'custom.css') { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <?php if($themecolor == "custom.css") { require( '../css/colors/custom.php'); } ?>
        <style>
        @media screen and (max-width: 1199px) {
                .resone { display:none !important;}
            }  
        </style>
        <?php if(GOOGLE_ANALYTICS_ID != ''){ echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . GOOGLE_ANALYTICS_ID . "'></script>
        <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '" . GOOGLE_ANALYTICS_ID . "');</script>"; } ?> 
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="fix-header">
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
                                <input type="text" placeholder="<?php echo __("Search..."); ?>" class="form-control" name="q"> <a href="javascript:void(0);" onclick="document.getElementById('searchform').submit();"><i class="fa fa-search"></i></a> </form>
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
                                <li><a href="../profile.php"><i class="ti-home"></i> <?php echo __("My Account"); ?></a></li>
                                <li><a href="../profile.php?settings=open"><i class="ti-settings"></i> <?php echo __("Account Settings"); ?></a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../process/logout.php"><i class="fa fa-power-off"></i> <?php echo __("Logout"); ?></a></li>
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
                            <span class="hide-menu"><?php echo __("Navigation"); ?></span>
                        </h3>  
                    </div>
                    <ul class="nav" id="side-menu">
                        <?php indexMenu("../"); 
                              adminMenu("../admin/list/", "");
                              profileMenu("../");
                              primaryMenu("../list/", "../process/", "cron");
                        ?>
                    </ul>
                </div>
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title"><?php echo __("Add Cron Job"); ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-horizontal form-material">
                            <div class="col-md-12 col-xs-12">
                                <div class="white-box">
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo __("Command"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" form="vstobjects" name="v_cmd" class="form-control" required> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <form class="form-horizontal form-material" autocomplete="off" id="vstobjects" method="post" action="../create/cron.php">
                            <div class="col-md-8 col-xs-12">
                                <div class="white-box">
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo __("Minute"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_min" class="form-control" required> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo __("Hour"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_hour" class="form-control" required> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo __("Day"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_day" class="form-control" required> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo __("Month"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_month" class="form-control" required> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo __("Day of Week"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_wday" class="form-control" required> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" type="submit"><?php echo __("Add Cron"); ?></button> &nbsp;
                                            <a href="../list/cron.php" style="color: inherit;text-decoration: inherit;"><button onclick="loadLoader();" class="btn btn-muted" type="button"><?php echo __("Back"); ?></button></a>
                                        </div>
                                    </div>
                                </div>
                            </div> </form>
                        <div class="col-lg-4 col-xs-12 resone">
                            <div class="white-box">
                                <div> 
                                    <center>
                                        <h3>
                                            <?php echo __("Cron Generator"); ?>
                                        </h3>
                                    </center><br>
                                    <div class="overlay-box" style="background: #fff;">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a  href="#1" data-toggle="tab"><?php echo __("Minutes"); ?></a>
                                            </li>
                                            <li><a href="#2" data-toggle="tab"><?php echo __("Hourly"); ?></a>
                                            </li>
                                            <li><a href="#3" data-toggle="tab"><?php echo __("Daily"); ?></a>
                                            </li>
                                            <li><a href="#4" data-toggle="tab"><?php echo __("Weekly"); ?></a>
                                            </li>
                                            <li><a href="#5" data-toggle="tab"><?php echo __("Monthly"); ?></a>
                                            </li>
                                        </ul>
                                        <div class="tab-content  generator">
                                            <div class="tab-pane active" id="1">
                                                <form class="form-horizontal form-material" autocomplete="off" action="javascript:void(0);">
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo __("Run Command"); ?></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control select2" name="h_min" >
                                                                <option value="*" selected="selected"><?php echo __("every minute"); ?></option>
                                                                <option value="*/2"><?php echo __("every two minutes"); ?></option>
                                                                <option value="*/5"><?php echo __("every"); ?> 5</option>
                                                                <option value="*/10"><?php echo __("every"); ?> 10</option>
                                                                <option value="*/15"><?php echo __("every"); ?> 15</option>
                                                                <option value="*/30"><?php echo __("every"); ?> 30</option>
                                                            </select>
                                                            <input type="hidden" name="h_hour" value="*">
                                                            <input type="hidden" name="h_day" value="*">
                                                            <input type="hidden" name="h_month" value="*">
                                                            <input type="hidden" name="h_wday" value="*">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-success"><?php echo __("Generate"); ?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="2">
                                                <form class="form-horizontal form-material" autocomplete="off" action="javascript:void(0);">
                                                    <input type="hidden" name="h_day" value="*">
                                                    <input type="hidden" name="h_month" value="*">
                                                    <input type="hidden" name="h_wday" value="*">
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo __("Run Command"); ?></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control select2" name="h_hour">
                                                                <option value="*" selected="selected"><?php echo __("every hour"); ?></option>
                                                                <option value="*/2"><?php echo __("every two hours"); ?></option>
                                                                <option value="*/6"><?php echo __("every"); ?> 6</option>
                                                                <option value="*/12"><?php echo __("every"); ?> 12</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo __("Minute"); ?></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control select2" name="h_min">
                                                                <option value="0" selected="selected">00</option>
                                                                <option value="15">15</option>
                                                                <option value="30">30</option>
                                                                <option value="45">45</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-success"><?php echo __("Generate"); ?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="3">
                                                <form class="form-horizontal form-material" autocomplete="off" action="javascript:void(0);">
                                                    <input type="hidden" name="h_month" value="*">
                                                    <input type="hidden" name="h_wday" value="*">
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo __("Run Command"); ?></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control select2" name="h_day">
                                                                <option value="*" selected="selected"><?php echo __("every day"); ?></option>
                                                                <option value="1-31/2"><?php echo __("every odd day"); ?></option>
                                                                <option value="*/2"><?php echo __("every even day"); ?></option>
                                                                <option value="*/3"><?php echo __("every"); ?> 3</option>
                                                                <option value="*/5"><?php echo __("every"); ?> 5</option>
                                                                <option value="*/10"><?php echo __("every"); ?> 10</option>
                                                                <option value="*/15"><?php echo __("every"); ?> 15</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-6 pull-left"><?php echo __("Hour"); ?></label><label class="col-sm-6 pull-right"><?php echo __("Minute"); ?></label>
                                                        <div class="col-sm-6 pull-left">
                                                            <select class="form-control select2" name="h_hour">
                                                                <option value="0">00</option>
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="3">03</option>
                                                                <option value="4">04</option>
                                                                <option value="5">05</option>
                                                                <option value="6">06</option>
                                                                <option value="7">07</option>
                                                                <option value="8">08</option>
                                                                <option value="9">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12" selected="selected">12</option>
                                                                <option value="13">13</option>
                                                                <option value="14">14</option>
                                                                <option value="15">15</option>
                                                                <option value="16">16</option>
                                                                <option value="17">17</option>
                                                                <option value="18">18</option>
                                                                <option value="19">19</option>
                                                                <option value="20">20</option>
                                                                <option value="21">21</option>
                                                                <option value="22">22</option>
                                                                <option value="23">23</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6 pull-right">
                                                            <select class="form-control select2" name="h_min">
                                                                <option value="0" selected="selected">00</option>
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="5">05</option>
                                                                <option value="10">10</option>
                                                                <option value="15">15</option>
                                                                <option value="20">20</option>
                                                                <option value="25">25</option>
                                                                <option value="30">30</option>
                                                                <option value="35">35</option>
                                                                <option value="40">40</option>
                                                                <option value="45">45</option>
                                                                <option value="50">50</option>
                                                                <option value="55">55</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-success"><?php echo __("Generate"); ?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="4">
                                                <form class="form-horizontal form-material" autocomplete="off" action="javascript:void(0);">
                                                    <input type="hidden" name="h_month" value="*">
                                                    <input type="hidden" name="h_day" value="*">
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo __("Run Command"); ?></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control select2" name="h_wday">
                                                                <option value="*" selected="selected"><?php echo __("every day"); ?></option>
                                                                <option value="1,2,3,4,5"><?php echo __("weekdays (5 days)"); ?></option>
                                                                <option value="0,6"><?php echo __("weekend (2 days)"); ?></option>
                                                                <option value="1"><?php echo __("Monday"); ?></option>
                                                                <option value="2"><?php echo __("Tuesday"); ?></option>
                                                                <option value="3"><?php echo __("Wednesday"); ?></option>
                                                                <option value="4"><?php echo __("Thursday"); ?></option>
                                                                <option value="5"><?php echo __("Friday"); ?></option>
                                                                <option value="6"><?php echo __("Saturday"); ?></option>
                                                                <option value="0"><?php echo __("Sunday"); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-6 pull-left"><?php echo __("Hour"); ?></label><label class="col-sm-6 pull-right"><?php echo __("Minute"); ?></label>
                                                        <div class="col-sm-6 pull-left">
                                                            <select class="form-control select2" name="h_hour">
                                                                <option value="0">00</option>
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="3">03</option>
                                                                <option value="4">04</option>
                                                                <option value="5">05</option>
                                                                <option value="6">06</option>
                                                                <option value="7">07</option>
                                                                <option value="8">08</option>
                                                                <option value="9">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12" selected="selected">12</option>
                                                                <option value="13">13</option>
                                                                <option value="14">14</option>
                                                                <option value="15">15</option>
                                                                <option value="16">16</option>
                                                                <option value="17">17</option>
                                                                <option value="18">18</option>
                                                                <option value="19">19</option>
                                                                <option value="20">20</option>
                                                                <option value="21">21</option>
                                                                <option value="22">22</option>
                                                                <option value="23">23</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6 pull-right">
                                                            <select class="form-control select2" name="h_min">
                                                                <option value="0" selected="selected">00</option>
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="5">05</option>
                                                                <option value="10">10</option>
                                                                <option value="15">15</option>
                                                                <option value="20">20</option>
                                                                <option value="25">25</option>
                                                                <option value="30">30</option>
                                                                <option value="35">35</option>
                                                                <option value="40">40</option>
                                                                <option value="45">45</option>
                                                                <option value="50">50</option>
                                                                <option value="55">55</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-success"><?php echo __("Generate"); ?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="5">
                                                <form class="form-horizontal form-material" autocomplete="off" action="javascript:void(0);">
                                                    <input type="hidden" name="h_wday" value="*">
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo __("Run Command"); ?></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control select2" name="h_month">
                                                                <option value="*" selected="selected"><?php echo __("every month"); ?></option>
                                                                <option value="1-11/2"><?php echo __("every odd month"); ?></option>
                                                                <option value="*/2"><?php echo __("every even month"); ?></option>
                                                                <option value="*/3"><?php echo __("every"); ?> 3</option>
                                                                <option value="*/6"><?php echo __("every"); ?> 6</option>
                                                                <option value="1"><?php echo __("January"); ?></option>
                                                                <option value="2"><?php echo __("February"); ?></option>
                                                                <option value="3"><?php echo __("March"); ?></option>
                                                                <option value="4"><?php echo __("April"); ?></option>
                                                                <option value="5"><?php echo __("May"); ?></option>
                                                                <option value="6"><?php echo __("June"); ?></option>
                                                                <option value="7"><?php echo __("July"); ?></option>
                                                                <option value="8"><?php echo __("August"); ?></option>
                                                                <option value="9"><?php echo __("September"); ?></option>
                                                                <option value="10"><?php echo __("October"); ?></option>
                                                                <option value="11"><?php echo __("November"); ?></option>
                                                                <option value="12"><?php echo __("December"); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo __("Date"); ?></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control select2" name="h_day">
                                                                <option value="1" selected="selected">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="8">8</option>
                                                                <option value="9">9</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                                <option value="13">13</option>
                                                                <option value="14">14</option>
                                                                <option value="15">15</option>
                                                                <option value="16">16</option>
                                                                <option value="17">17</option>
                                                                <option value="18">18</option>
                                                                <option value="19">19</option>
                                                                <option value="20">20</option>
                                                                <option value="21">21</option>
                                                                <option value="22">22</option>
                                                                <option value="23">23</option>
                                                                <option value="24">24</option>
                                                                <option value="25">25</option>
                                                                <option value="26">26</option>
                                                                <option value="27">27</option>
                                                                <option value="28">28</option>
                                                                <option value="29">29</option>
                                                                <option value="30">30</option>
                                                                <option value="31">31</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-6 pull-left"><?php echo __("Hour"); ?></label><label class="col-sm-6 pull-right"><?php echo __("Minute"); ?></label>
                                                        <div class="col-sm-6 pull-left">
                                                            <select class="form-control select2" name="h_hour">
                                                                <option value="0">00</option>
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="3">03</option>
                                                                <option value="4">04</option>
                                                                <option value="5">05</option>
                                                                <option value="6">06</option>
                                                                <option value="7">07</option>
                                                                <option value="8">08</option>
                                                                <option value="9">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12" selected="selected">12</option>
                                                                <option value="13">13</option>
                                                                <option value="14">14</option>
                                                                <option value="15">15</option>
                                                                <option value="16">16</option>
                                                                <option value="17">17</option>
                                                                <option value="18">18</option>
                                                                <option value="19">19</option>
                                                                <option value="20">20</option>
                                                                <option value="21">21</option>
                                                                <option value="22">22</option>
                                                                <option value="23">23</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6 pull-right">
                                                            <select class="form-control select2" name="h_min">
                                                                <option value="0" selected="selected">00</option>
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="5">05</option>
                                                                <option value="10">10</option>
                                                                <option value="15">15</option>
                                                                <option value="20">20</option>
                                                                <option value="25">25</option>
                                                                <option value="30">30</option>
                                                                <option value="35">35</option>
                                                                <option value="40">40</option>
                                                                <option value="45">45</option>
                                                                <option value="50">50</option>
                                                                <option value="55">55</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-success"><?php echo __("Generate"); ?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script> 
                    function submitForm() { document.getElementById("form").submit(); };
                    function exitForm() { window.location.href="../list/cron.php"; };
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
            $('#vstobjects').submit(function(ev) {
                ev.preventDefault();
                processLoader();
                this.submit();
            });
            <?php 
            
            processPlugins();
            includeScript();
            
            ?>

            $('.generator form').submit(function(){
                $('#vstobjects input[name=v_min]').val($(this).find(':input[name=h_min]').val());
                $('#vstobjects input[name=v_hour]').val($(this).find(':input[name=h_hour]').val());
                $('#vstobjects input[name=v_day]').val($(this).find(':input[name=h_day]').val());
                $('#vstobjects input[name=v_month]').val($(this).find(':input[name=h_month]').val());
                $('#vstobjects input[name=v_wday]').val($(this).find(':input[name=h_wday]').val());

                return false;
            });
            $('.select2').select2();
            function processLoader(){
                swal({
                    title: '<?php echo __("Processing"); ?>',
                    text: '',
                    onOpen: function () {
                        swal.showLoading()
                    }
                })};
            function loadLoader(){
                swal({
                    title: '<?php echo __("Loading"); ?>',
                    text: '',
                    onOpen: function () {
                        swal.showLoading()
                    }
                })};
            <?php
            if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "swal({title:'" . $errorcode[1] . "', html:'" . __("Please try again or contact support.") . "', type:'error'});";
            }
            ?>
        </script>
    </body>
</html>