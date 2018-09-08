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
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php?to=edit/mailaccount.php'.$urlquery.$_SERVER['QUERY_STRING']); }

if(isset($mailenabled) && $mailenabled != 'true'){ header("Location: ../error-pages/403.html"); }

$requestdomain = $_GET['domain'];
$requestaccount = $_GET['account'];

if (isset($requestdomain) && $requestdomain != '' && isset($requestaccount) && $requestaccount != '') {}
else { header('Location: ../list/mail.php'); }

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-mail-account','arg1' => $username,'arg2' => $requestdomain, 'arg3' => $requestaccount, 'arg4' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-mail-account-autoreply','arg1' => $username,'arg2' => $requestdomain, 'arg3' => $requestaccount, 'arg4' => 'json'));


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
$useremail = $admindata['CONTACT'];
$maildata = array_values(json_decode(curl_exec($curl1), true));
$mailname = array_keys(json_decode(curl_exec($curl1), true));
$autoreplydata = array_values(json_decode(curl_exec($curl2), true));
$autoreplyname = array_keys(json_decode(curl_exec($curl2), true));
/* if ($mailname[0] == '') { header('Location: ../list/mail.php'); } */
if(isset($admindata['LANGUAGE'])){ $locale = $ulang[$admindata['LANGUAGE']]; }
setlocale("LC_CTYPE", $locale); setlocale("LC_MESSAGES", $locale);
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
        <title><?php echo $sitetitle; ?> - <?php echo _("Mail"); ?></title>
        <link href="../plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../plugins/components/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet">
        <link href="../plugins/components/metismenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="../plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../plugins/components/sweetalert2/sweetalert2.min.css" />
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/colors/<?php if(isset($_COOKIE['theme'])) { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <style>
            @media screen and (max-width: 1199px) {
                .resone { display:none !important;}
            }  
            @media screen and (max-width: 991px) {
                .restwo { display:none !important;}
            }    
            @media screen and (max-width: 767px) {
                .resfour { display:none !important; }
                .bg-title ul.side-icon-text {
                    position: relative;
                    top: -20px;
                }
                h4.page-title {
                    position: relative;
                    top: 20px;
                }
            }
            @media screen and (max-width: 540px) {
                .resthree { display:none !important;}
            } 
        </style>
        <?php if(GOOGLE_ANALYTICS_ID != ''){ echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . GOOGLE_ANALYTICS_ID . "'></script>
        <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '" . GOOGLE_ANALYTICS_ID . "');</script>"; } ?> 
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="fix-header" onload="checkDiv();">
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
                    </ul>
                    <ul class="nav navbar-top-links navbar-right pull-right">

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
                              primaryMenu("../list/", "../process/", "mail");
                        ?>
                    </ul>
                </div>
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title"><?php echo _("Edit Mail Account"); ?></h4>
                        </div>
                        <ul class="side-icon-text pull-right">
                            <li style="position: relative;top: -3px;">
                                <a onclick="confirmDelete();" style="cursor: pointer;"><span class="circle circle-sm bg-danger di"><i class="ti-trash"></i></span><span class="resfour"><wrapper class="restwo"><?php echo _("Delete Mail"); ?> </wrapper><?php echo _("Account"); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="row restwo">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center><?php echo _("CREATED"); ?></center>
                                        </div>
                                        <div class="panel-body">
                                            <center>
                                                <h2>
                                                    <?php $date=date_create($maildata[0]['DATE'] . ' ' . $maildata[0]['TIME']); echo date_format($date,"F j, Y - g:i A"); ?>
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
                                            <center><?php echo _("STATUS"); ?></center>
                                        </div>
                                        <div class="panel-body">
                                            <center>
                                                <h2>
                                                    <?php if ($maildata[0]['SUSPENDED'] == 'no') {echo _("Active");} else {echo _("Suspended");}?>
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
                                <form class="form-horizontal form-material" autocomplete="off" method="post" id="form" action="../change/mailaccount.php">
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Email Addresss"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" disabled value="<?php echo $requestaccount . '@' . $requestdomain; ?>" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static"> 
                                            <input type="hidden" name="v_domain" value="<?php echo $requestdomain; ?>"> 
                                            <input type="hidden" name="v_account" value="<?php echo $requestaccount; ?>"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-md-12"><?php echo _("Password"); ?> / <a style="cursor:pointer" onclick="generatePassword(10)"> <?php echo _("Generate"); ?></a></label>
                                        <div class="col-md-12 input-group" style="padding-left: 15px;">
                                            <input type="password" onkeyup="fillSpan()" autocomplete="new-password" class="form-control form-control-line" name="password" id="password">                                    <span class="input-group-btn"> 
                                            <button class="btn btn-inverse" style="margin-right: 15px;" name="Show" onclick="toggler(this)" id="tg" type="button"><i class="ti-eye"></i></button> 
                                            </span>  </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-md-12"><?php echo _("Quota"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" disabled value="<?php print_r($maildata[0]['QUOTA']); ?>" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;"class="form-control uneditable-input form-control-static"> 
                                            <small class="form-text text-muted"><?php echo _("In Megabytes"); ?></small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Aliases"); ?></label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_alias-x" value="<?php $aliasArray = explode(',', ($maildata[0]['ALIAS']));foreach ($aliasArray as &$value) {$value = $value . "&#013;&#010;";} foreach($aliasArray as $val) {echo $val;}?>">
                                            <textarea class="form-control" name="v_alias" rows="4" id="aliasTextArea"><?php $aliasArray = explode(',', ($maildata[0]['ALIAS']));foreach ($aliasArray as &$value) {$value = $value . "&#013;&#010;";} foreach($aliasArray as $val) {echo $val;}?></textarea>
                                            <small class="form-text text-muted"><?php echo _("Use Local-Part"); ?></small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Forward To"); ?></label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_forward-x" value="<?php $fwdArray = explode(',', ($maildata[0]['FWD']));foreach ($fwdArray as &$value1) {$value1 = $value1. "&#013;&#010;";}foreach($fwdArray as $val1){echo $val1;}?>">
                                            <textarea class="form-control" name="v_forward" rows="4" id="forwardTextArea"><?php $fwdArray = explode(',', ($maildata[0]['FWD']));foreach ($fwdArray as &$value1) {$value1 = $value1. "&#013;&#010;";}foreach($fwdArray as $val1){echo $val1;}?></textarea>
                                            <small class="form-text text-muted"><?php echo _("One or more email addresses"); ?></small>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Don't Store Forwarded Mail"); ?></label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input type="hidden" name="v_fwd_to_x" value="<?php echo $maildata[0]['FWD_ONLY']; ?>">
                                                <input id="checkbox4" name="v_fwd_to" type="checkbox" <?php if($maildata[0]['FWD_ONLY'] == 'yes') {echo 'checked';} ?> >
                                                <label for="checkbox4"> <?php echo _("Enabled"); ?> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Autoreply"); ?></label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input type="hidden" name="v_autoreply-x" value="<?php echo $maildata[0]['AUTOREPLY']; ?>">
                                                <input id="checkbox5" name="v_autoreply" type="checkbox" onclick="checkDiv();" <?php if($maildata[0]['AUTOREPLY'] == 'yes') {echo 'checked';} ?> >
                                                <label for="checkbox5"> <?php echo _("Enabled"); ?> </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="msg-div" style="margin-left: 4%;">
                                        <label class="col-md-12"><?php echo _("Message"); ?></label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_message_x" value="<?php $aliasArray = explode(',', ($autoreplydata[0]['MSG']));
                                                                                           foreach ($aliasArray as &$value) {
                                                                                               echo str_replace("\r\n", "\n", $value);
                                                                                           } ?>">
                                            <textarea class="form-control" name="v_message" rows="4"><?php $aliasArray = explode(',', ($autoreplydata[0]['MSG']));
                                                foreach ($aliasArray as &$value) {
                                                    echo str_replace("\r\n", "\n", $value);
                                                } ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" type="submit"><?php echo _("Update Account"); ?></button> &nbsp;
                                            <a href="../list/maildomain.php?domain=<?php echo $requestdomain; ?>" style="color: inherit;text-decoration: inherit;"><button onclick="loadLoader();" class="btn btn-muted" type="button"><?php echo _("Back"); ?></button></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-4 col-xs-12 resone">
                            <div class="white-box">
                                <div> 
                                    <center> <h3>
                                        <?php echo _("Authentication Settings"); ?>
                                        </h3></center><br>
                                    <div class="overlay-box" style="background: #fff;">
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a  href="#1" data-toggle="tab"><?php echo _("Use Server Hostname"); ?></a>
                                            </li>
                                            <li><a href="#2" data-toggle="tab"><?php echo _("Use Domain Hostname"); ?> </a>
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
                                                    <li><a href="#5" data-toggle="tab"><?php echo _("No Authentication"); ?></a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content ">
                                                    <div class="tab-pane active" id="3">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    <?php echo _("Username"); ?>:	<br>   
                                                                    <?php echo _("Password"); ?>:	<br>
                                                                    IMAP <?php echo _("hostname"); ?>:	<br>
                                                                    IMAP <?php echo _("port"); ?>:	<br>
                                                                    IMAP <?php echo _("security"); ?>:	<br>
                                                                    IMAP <?php echo _("auth method"); ?>:<br>
                                                                    SMTP <?php echo _("hostname"); ?>:<br>
                                                                    SMTP <?php echo _("port"); ?>:	<br>
                                                                    SMTP <?php echo _("security"); ?>:<br>	
                                                                    SMTP <?php echo _("auth method"); ?>:	<br>
                                                                    <?php echo _("Webmail"); ?> URL:	<br>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <p>
                                                                    <?php echo $requestaccount . '@' . $requestdomain; ?><br>   
                                                                    <span class="mailPW"></span><br>
                                                                    <?php echo VESTA_HOST_ADDRESS; ?><br>
                                                                    143<br>
                                                                    STARTTLS<br>
                                                                    <?php echo _("Normal Password"); ?><br>
                                                                    <?php echo VESTA_HOST_ADDRESS; ?><br>
                                                                    587<br>
                                                                    STARTTLS<br>	
                                                                    <?php echo _("Normal Password"); ?><br>
                                                                    <a href="<?php echo $webmailurl; ?>"><?php echo $webmailurl; ?></a><br>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="4">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    <?php echo _("Username"); ?>:	<br>   
                                                                    <?php echo _("Password"); ?>:	<br>
                                                                    IMAP <?php echo _("hostname"); ?>:	<br>
                                                                    IMAP <?php echo _("port"); ?>:	<br>
                                                                    IMAP <?php echo _("security"); ?>:	<br>
                                                                    IMAP <?php echo _("auth method"); ?>:<br>
                                                                    SMTP <?php echo _("hostname"); ?>:<br>
                                                                    SMTP <?php echo _("port"); ?>:	<br>
                                                                    SMTP <?php echo _("security"); ?>:<br>	
                                                                    SMTP <?php echo _("auth method"); ?>:	<br>
                                                                    <?php echo _("Webmail"); ?> URL:	<br>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <p>
                                                                    <?php echo $requestaccount . '@' . $requestdomain; ?><br>   
                                                                    <span class="mailPW"></span><br>
                                                                    <?php echo VESTA_HOST_ADDRESS; ?><br>
                                                                    993<br>
                                                                    SSL<br>
                                                                    <?php echo _("Normal Password"); ?><br>
                                                                    <?php echo VESTA_HOST_ADDRESS; ?><br>
                                                                    465<br>
                                                                    SSL<br>	
                                                                    <?php echo _("Normal Password"); ?><br>
                                                                    <a href="<?php echo $webmailurl; ?>"><?php echo $webmailurl; ?></a><br>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="5">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    <?php echo _("Username"); ?>:	<br>   
                                                                    <?php echo _("Password"); ?>:	<br>
                                                                    IMAP <?php echo _("hostname"); ?>:	<br>
                                                                    IMAP <?php echo _("port"); ?>:	<br>
                                                                    IMAP <?php echo _("security"); ?>:	<br>
                                                                    IMAP <?php echo _("auth method"); ?>:<br>
                                                                    SMTP <?php echo _("hostname"); ?>:<br>
                                                                    SMTP <?php echo _("port"); ?>:	<br>
                                                                    SMTP <?php echo _("security"); ?>:<br>	
                                                                    SMTP <?php echo _("auth method"); ?>:	<br>
                                                                    <?php echo _("Webmail"); ?> URL:	<br>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <p>
                                                                    <?php echo $requestaccount . '@' . $requestdomain; ?><br>   
                                                                    <span class="mailPW"></span><br>
                                                                    <?php echo VESTA_HOST_ADDRESS; ?><br>
                                                                    143<br>
                                                                    <?php echo _("No Encryption"); ?><br>
                                                                    <?php echo _("Normal Password"); ?><br>
                                                                    <?php echo VESTA_HOST_ADDRESS; ?><br>
                                                                    25<br>
                                                                    <?php echo _("No Encryption"); ?><br>	
                                                                    <?php echo _("Normal Password"); ?><br>
                                                                    <a href="<?php echo $webmailurl; ?>"><?php echo $webmailurl; ?></a><br>
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
                                                    <li><a href="#8" data-toggle="tab"><?php echo _("No Authentication"); ?></a>
                                                    </li>
                                                </ul>
                                                <div class="tab-content ">
                                                    <div class="tab-pane active" id="6">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    <?php echo _("Username"); ?>:	<br>   
                                                                    <?php echo _("Password"); ?>:	<br>
                                                                    IMAP <?php echo _("hostname"); ?>:	<br>
                                                                    IMAP <?php echo _("port"); ?>:	<br>
                                                                    IMAP <?php echo _("security"); ?>:	<br>
                                                                    IMAP <?php echo _("auth method"); ?>:<br>
                                                                    SMTP <?php echo _("hostname"); ?>:<br>
                                                                    SMTP <?php echo _("port"); ?>:	<br>
                                                                    SMTP <?php echo _("security"); ?>:<br>	
                                                                    SMTP <?php echo _("auth method"); ?>:	<br>
                                                                    <?php echo _("Webmail"); ?> URL:	<br>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <p>
                                                                    <?php echo $requestaccount . '@' . $requestdomain; ?><br>   
                                                                    <span class="mailPW"></span><br>
                                                                    <?php echo $requestdomain; ?><br>
                                                                    143<br>
                                                                    STARTTLS<br>
                                                                    <?php echo _("Normal Password"); ?><br>
                                                                    <?php echo $requestdomain; ?><br>
                                                                    587<br>
                                                                    STARTTLS<br>	
                                                                    <?php echo _("Normal Password"); ?><br>
                                                                    <a href="<?php echo $webmailurl; ?>"><?php echo $webmailurl; ?></a><br>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="7">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    <?php echo _("Username"); ?>:	<br>   
                                                                    <?php echo _("Password"); ?>:	<br>
                                                                    IMAP <?php echo _("hostname"); ?>:	<br>
                                                                    IMAP <?php echo _("port"); ?>:	<br>
                                                                    IMAP <?php echo _("security"); ?>:	<br>
                                                                    IMAP <?php echo _("auth method"); ?>:<br>
                                                                    SMTP <?php echo _("hostname"); ?>:<br>
                                                                    SMTP <?php echo _("port"); ?>:	<br>
                                                                    SMTP <?php echo _("security"); ?>:<br>	
                                                                    SMTP <?php echo _("auth method"); ?>:	<br>
                                                                    <?php echo _("Webmail"); ?> URL:	<br>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <p>
                                                                    <?php echo $requestaccount . '@' . $requestdomain; ?><br>   
                                                                    <span class="mailPW"></span><br>
                                                                    <?php echo $requestdomain; ?><br>
                                                                    993<br>
                                                                    SSL<br>
                                                                    <?php echo _("Normal Password"); ?><br>
                                                                    <?php echo $requestdomain; ?><br>
                                                                    465<br>
                                                                    SSL<br>	
                                                                    <?php echo _("Normal Password"); ?><br>
                                                                    <a href="<?php echo $webmailurl; ?>"><?php echo $webmailurl; ?></a><br>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="8">
                                                        <div class="row">
                                                            <div class="col-sm-5">
                                                                <p>
                                                                    <?php echo _("Username"); ?>:	<br>   
                                                                    <?php echo _("Password"); ?>:	<br>
                                                                    IMAP <?php echo _("hostname"); ?>:	<br>
                                                                    IMAP <?php echo _("port"); ?>:	<br>
                                                                    IMAP <?php echo _("security"); ?>:	<br>
                                                                    IMAP <?php echo _("auth method"); ?>:<br>
                                                                    SMTP <?php echo _("hostname"); ?>:<br>
                                                                    SMTP <?php echo _("port"); ?>:	<br>
                                                                    SMTP <?php echo _("security"); ?>:<br>	
                                                                    SMTP <?php echo _("auth method"); ?>:	<br>
                                                                    <?php echo _("Webmail"); ?> URL:	<br>
                                                                </p>
                                                            </div>
                                                            <div class="col-sm-7">
                                                                <p>
                                                                    <?php echo $requestaccount . '@' . $requestdomain; ?><br>   
                                                                    <span class="mailPW"></span><br>
                                                                    <?php echo $requestdomain; ?><br>
                                                                    143<br>
                                                                    <?php echo _("No Encryption"); ?><br>
                                                                    <?php echo _("Normal Password"); ?><br>
                                                                    <?php echo $requestdomain; ?><br>
                                                                    25<br>
                                                                    <?php echo _("No Encryption"); ?><br>	
                                                                    <?php echo _("Normal Password"); ?><br>
                                                                    <a href="<?php echo $webmailurl; ?>"><?php echo $webmailurl; ?></a><br>
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
                <script> 
                    function submitForm() { document.getElementById("form").submit(); };
                    function exitForm() { window.location.href="../list/maildomain.php?domain=<?php echo $requestdomain; ?>"; };
                </script>
                <?php hotkeys($configlocation); ?>
                <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../includes/versioncheck.php'; ?> <?php echo _("by Carter Roeser"); ?>.</footer>
            </div>
        </div>
        <script src="../plugins/components/jquery/jquery.min.js"></script>
        <script src="../plugins/components/jquery-toast-plugin/jquery.toast.min.js"></script>
        <script src="../plugins/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../plugins/components/sweetalert2/sweetalert2.min.js"></script>
        <script src="../plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../plugins/components/metismenu/dist/metisMenu.min.js"></script>
        <script src="../plugins/components/waves/waves.js"></script>
        <script src="../js/main.js"></script>
        <script type="text/javascript">
            Waves.attach('.button', ['waves-effect']);
            Waves.init();
            
            <?php 
            $pluginlocation = "../plugins/"; if(isset($pluginnames[0]) && $pluginnames[0] != '') { $currentplugin = 0; do { if (strtolower($pluginhide[$currentplugin]) != 'y' && strtolower($pluginhide[$currentplugin]) != 'yes') { if (strtolower($pluginadminonly[$currentplugin]) != 'y' && strtolower($pluginadminonly[$currentplugin]) != 'yes') { if (strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; } else { $currentstring = "<li><a href='".$pluginlocation.$pluginlinks[$currentplugin]."/'><i class='fa ".$pluginicons[$currentplugin]." fa-fw'></i><span class='hide-menu'>"._($pluginnames[$currentplugin])."</span></a></li>"; }} else { if(strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";} } else { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; }}} echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');\n var plugindata" . $currentplugin . " = \"" . $currentstring . "\";\n plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n"; } $currentplugin++; } while ($pluginnames[$currentplugin] != ''); } ?>

            $('#form').submit(function(ev) {
                ev.preventDefault();
                processLoader();
                this.submit();
            });
 
            function checkDiv(){
                if(document.getElementById("checkbox5").checked) {
                    document.getElementById('msg-div').style.display = 'block';
                }
                else {document.getElementById('msg-div').style.display = 'none';}
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
            function confirmDelete(){
                swal({
                    title: '<?php echo _("Delete Mail Account"); ?>:<br> <?php echo $requestaccount . '@' . $requestdomain;  ?>' + ' ?',
                    text: "<?php echo _("You won't be able to revert this!"); ?>",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<?php echo _("Yes, delete it!"); ?>'
                }).then(function () {
                    swal({
                        title: '<?php echo _("Processing"); ?>',
                        text: '',
                        onOpen: function () {
                            swal.showLoading()
                        }
                    }).then(
                        function () {},
                        function (dismiss) {}
                    )
                    window.location.replace("../delete/mailaccount.php?domain=<?php echo $requestdomain; ?>&account=<?php echo $requestaccount; ?>");
                })}
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
            
            if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "swal({title:'" . $errorcode[1] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            } 

            $returntotal = $_POST['r1'] + $_POST['r2'] + $_POST['r3'] + $_POST['r4'] + $_POST['r5'];
            if(isset($_POST['r1']) && $returntotal == 0) {
                echo "swal({title:'" . _("Successfully updated!") . "', type:'success'});";
            } 
            if(isset($_POST['r1']) && $returntotal != 0) {
                echo "swal({title:'" . _("Error Updating Mail Account") . "<br>" . "(E: " . $_POST['r1'] . "." . $_POST['r2'] . "." . $_POST['r3'] . "." . $_POST['r4'] . "." . $_POST['r5'] . ") <br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            }

            ?>
        </script>
    </body>
</html>