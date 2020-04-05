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

session_set_cookie_params(['samesite' => 'none']); session_start();
$configlocation = "includes/";
if (file_exists( 'includes/config.php' )) { require( 'includes/includes.php'); }  else { header( 'Location: install' ); exit(); };

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: login.php?to=profile.php'); exit(); }

if(isset($profileenabled) && $profileenabled != 'true'){ header("Location: error-pages/403.html"); }

$postvars = array(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'));

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
if(isset($admindata['LANGUAGE'])){ $locale = $ulang[$admindata['LANGUAGE']]; }
_setlocale(LC_CTYPE, $locale);
_setlocale(LC_MESSAGES, $locale);
_bindtextdomain('messages', 'locale');
_textdomain('messages');

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
if($auth0) {

	$curl1 = curl_init();
        curl_setopt($curl1, CURLOPT_URL, 'https://' . $config["AUTH0_DOMAIN"] . '/oauth/token');
        curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl1, CURLOPT_POST, true);
        curl_setopt($curl1, CURLOPT_POSTFIELDS, "grant_type=client_credentials&client_id=".$config['AUTH0_CLIENT_ID']."&client_secret=".$config['AUTH0_CLIENT_SECRET']."&audience=https://".$config['AUTH0_DOMAIN']."/api/v2/");
	$auth0token = json_decode(curl_exec($curl1), true)['access_token'];
	if(isset($auth0token) && $auth0token != '') {

 		$curl2 = curl_init();
       		curl_setopt($curl2, CURLOPT_URL, 'https://' . $config["AUTH0_DOMAIN"] . '/api/v2/connections');
        	curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
	        curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
	        curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl2, CURLOPT_CUSTOMREQUEST, "GET");
	        curl_setopt($curl2, CURLOPT_POSTFIELDS, "");
		curl_setopt($curl2, CURLOPT_HTTPHEADER, array("Authorization: Bearer ".$auth0token, "cache-control: no-cache"));
		$auth0connections = json_decode(curl_exec($curl2), true);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/ico" href="plugins/images/<?php echo $cpfavicon; ?>">
        <title><?php echo $sitetitle; ?> - <?php echo __("Account"); ?></title>
        <link href="plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="plugins/components/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
        <link href="plugins/components/metismenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="plugins/components/select2/select2.min.css" rel="stylesheet">
        <link href="plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link href="plugins/components/bootstrap-brand-buttons/brand-buttons-inversed.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/9ce2a0b093.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="plugins/components/sweetalert2/sweetalert2.min.css" />
        <link href="css/style.css" rel="stylesheet">
        <link href="css/colors/<?php if(isset($_COOKIE['theme']) && $themecolor != 'custom.css') { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <?php if($themecolor == "custom.css") { require( 'css/colors/custom.php'); } ?>
        <style>
            .select2-results{
                max-height: 200px;
                padding: 0 0 0 4px;
                margin: 4px 4px 4px 0;
                position: relative;
                overflow-x: hidden;
                overflow-y: auto;
                -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
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
        <?php if(INTERAKT_APP_ID != ''){ echo '<script>
        window.mySettings = {
        first_name: "' . $admindata['FNAME'] . '",
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
        <script src="plugins/components/sweetalert2/sweetalert2.min.js"></script>
        <?php

        if(isset($_GET['password'])) { $pwcode = $_GET['password']; }
        if(isset($_GET['email'])) { $emailcode = $_GET['email']; }
        if(isset($_GET['lang'])) { $langcode = $_GET['lang']; }
        if(isset($_GET['ns'])) { $nscode = $_GET['ns']; }
        if(isset($_GET['name'])) { $namecode = $_GET['name']; }
        if(isset($_GET['password']) && isset($_GET['email']) && isset($_GET['lang']) && isset($_GET['ns']) && isset($_GET['name'])) { $answer1 = $pwcode + $emailcode + $langcode + $nscode + $namecode; }
        if(isset($answer1)) { $answer = (int)$answer1; }
        if(isset($pwcode) || isset($emailcode) || isset($langcode) || isset($nscode) || isset($namecode)){
        if($answer == "0") {
        echo "<script> Swal.fire({title:'" . __("Successfully Updated!") . "', icon:'success'})</script>";
        } 
        if(isset($answer) && $answer == "1" || isset($answer) && $answer == "2") { echo "<script> Swal.fire('" . __("Invalid data entered in form.") . "<br>" .  __("Please try again.") . "', '<br>"; 
        if(isset($pwcode) && $pwcode != "0"){ echo " P: " . $pwcode;}
        if(isset($emailcode) && $emailcode != "0"){ echo " E: " . $emailcode;}
        if(isset($langcode) && $langcode != "0"){ echo " L: " . $langcode;}
        if(isset($nscode) && $nscode != "0"){ echo " NS: " . $nscode;}
        if(isset($namecode) && $namecode != "0"){ echo " N: " . $namecode;}
        echo "', 'error')</script>";}
        if(isset($answer) && $answer > "2") { echo "<script> Swal.fire('" . __("Please try again or contact support.") . "', '<br>"; 
         if(isset($pwcode) && $pwcode != "0"){ echo " P: " . $pwcode;}
         if(isset($emailcode) && $emailcode != "0"){ echo " E: " . $emailcode;}
         if(isset($langcode) && $langcode != "0"){ echo " L: " . $langcode;}
         if(isset($nscode) && $nscode != "0"){ echo " NS: " . $nscode;}
         if(isset($namecode) && $namecode != "0"){ echo " N: " . $namecode;}
         echo "', 'error')</script>";}
        }
        ?>

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
                        <?php notifications(); ?>
                    </ul>
                    <ul class="nav navbar-top-links navbar-right pull-right">
                        <li>
                            <form class="app-search m-r-10" id="searchform" action="process/search.php" method="get">
                                <input type="text" placeholder="<?php echo __("Search..."); ?>" class="form-control" name="q"> <a href="javascript:void(0);" onclick="document.getElementById('searchform').submit();"><i class="fa fa-search"></i></a> </form>
                        </li>
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
                                <li><a href="profile.php"><i class="ti-home"></i> <?php echo __("My Account"); ?></a></li>
                                <li><a href="profile.php?settings=open"><i class="ti-settings"></i> <?php echo __("Account Settings"); ?></a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="process/logout.php"><i class="fa fa-power-off"></i> <?php echo __("Logout"); ?></a></li>
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
                        <?php indexMenu("./"); 
                              adminMenu("admin/list/", "");
                        ?>
                        <li class="devider"></li>
                        <li>
                            <a href="#" class="waves-effect"><i  class="ti-user fa-fw"></i><span class="hide-menu"> <?php print_r($displayname); ?><span class="fa arrow"></span></span>
                            </a>
                            <ul class="nav nav-second-level collapse" id="appendaccount">
                                <li> <a href="profile.php" id="profileactive"><i class="ti-home fa-fw <?php if(isset($_GET['settings']) && $_GET['settings'] == "open") { echo 'text-inverse';} ?>"></i> <span style="<?php if(isset($_GET['settings']) && $_GET['settings'] == "open") { echo 'color:#54667a;font-weight:300;';} ?>" class="hide-menu"> <?php echo __("My Account"); ?></span></a></li>
                                <li> <a href="profile.php?settings=open" id="settingsactive"><i class="ti-settings fa-fw "></i> <span class="hide-menu"> <?php echo __("Account Settings"); ?></span></a></li>
                                <li> <a href="log.php"><i class="ti-layout-list-post fa-fw"></i><span class="hide-menu"><?php echo __("Log"); ?></span></a> </li>
                            </ul>
                        </li>
                        <?php primaryMenu("list/", "process/", ""); ?>
                    </ul>
                </div>
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title"><?php echo __("My Account"); ?></h4> 
                        </div>
                        <?php headerad(); ?>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-xs-12">
                            <div class="white-box">
                                <div class="user-bg bg-theme"> 
                                    <div class="overlay-box bg-theme">
                                        <div class="user-content"><br><br>
                                            <h4 class="text-white"><?php print_r($username); ?></h4>
                                            <h5 class="text-white"><?php print_r($admindata['CONTACT']); ?></h5> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-xs-12">
                            <div class="white-box">
                                <ul class="nav nav-tabs tabs customtab">
                                    <li class="<?php if(!isset($_GET['settings']) || isset($_GET['settings']) && $_GET['settings'] != "open") { echo "active tab"; } else { echo "tab"; } ?>" >
                                        <a href="profile.php"> <span class="visible-xs"><i class="fa fa-user"></i></span> <span class="hidden-xs"><?php echo __("Account"); ?></span> </a>
                                    </li>
                                    <li class="<?php if(isset($_GET['settings']) && $_GET['settings'] == "open") { echo "active tab"; } else { echo "tab"; } ?>">
                                        <a href="profile.php?settings=open"> <span class="visible-xs"><i class="fa fa-cog"></i></span> <span class="hidden-xs"><?php echo __("Settings"); ?></span> </a>
                                    </li>
                                </ul>
                                <div class="tab-content ">
                                    <div class="tab-pane <?php if(!isset($_GET['settings']) || isset($_GET['settings']) && $_GET['settings'] != "open") { echo "active"; } ?>" id="profile">
                                        <div class="row">
                                            <div class="col-md-3 col-xs-6 b-r"> <strong><?php echo __("Name"); ?></strong>
                                                <br>
                                                <p class="text-muted"><?php print_r($admindata['FNAME'] . ' ' . $admindata['LNAME']); ?></p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong><?php echo __("Joined"); ?></strong>
                                                <br>
                                                <p class="text-muted"><?php $date=date_create($admindata['DATE'] . ' ' . $admindata['TIME']);
                                                    echo date_format($date,"F j, Y - g:i A"); ?></p>
                                            </div>
                                            <div class="col-md-3 col-xs-6 b-r"> <strong><?php echo __("Plan"); ?></strong>
                                                <br>
                                                <p class="text-muted"><?php print_r(ucfirst($admindata['PACKAGE'])); ?></p>
                                            </div>
                                            <div class="col-md-3 col-xs-6"> <strong><?php echo __("Language"); ?></strong>
                                                <br>
                                                <p class="text-muted"><?php if($admindata['LANGUAGE'] == ""){echo "Not Set";} else{ print_r($countries[$admindata['LANGUAGE']]);} ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <strong><?php echo __("Nameservers"); ?>:</strong>
                                        <p class="m-t-30">
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
                                        </p>
                                    <?php if($auth0) {
                                        echo '<hr>
                                        <strong>'.__("External Accounts").':</strong>
                                        <br><br>';
                                    
                                        if($auth0connections) {
                                            foreach($auth0connections as $connection) {
                                              socialloginhtmlsmall($connection['name']);
                                            }
                                            echo '<br><br><small>' . __('Note: You may only link 1 extenal account at a time. Linking a new account will unlink all other accounts.') . '</small>';
                                          }
                                          else {
                                              echo __("No external accounts available.");
                                          }
                                        }
                                    ?>
                                </div>
                                <div class="tab-pane <?php if(isset($_GET['settings']) && $_GET['settings'] == "open") { echo "active"; } ?>" id="settings">
                                    <form class="form-horizontal form-material" id="form" autocomplete="off" action="process/updatesettings.php" method="post">
                                        <input type="hidden" name="fname-x" value="<?php print_r($admindata['FNAME']); ?>"/>
                                        <input type="hidden" name="lname-x" value="<?php print_r($admindata['LNAME']); ?>"/>
                                        <input type="hidden" name="email-x" value="<?php print_r($admindata['CONTACT']); ?>"/>
                                        <input type="hidden" name="language-x" value="<?php print_r($admindata['LANGUAGE']); ?>"/>
                                        <input type="hidden" name="ns1-x" value="<?php print_r(explode(',', ($admindata['NS']))[0]); ?>"/>
                                        <input type="hidden" name="ns2-x" value="<?php print_r(explode(',', ($admindata['NS']))[1]); ?>"/>
                                        <input type="hidden" name="ns3-x" value="<?php print_r(explode(',', ($admindata['NS']))[2]); ?>"/>
                                        <input type="hidden" name="ns4-x" value="<?php print_r(explode(',', ($admindata['NS']))[3]); ?>"/>
                                        <input type="hidden" name="ns5-x" value="<?php print_r(explode(',', ($admindata['NS']))[4]); ?>"/>
                                        <input type="hidden" name="ns6-x" value="<?php print_r(explode(',', ($admindata['NS']))[5]); ?>"/>
                                        <input type="hidden" name="ns7-x" value="<?php print_r(explode(',', ($admindata['NS']))[6]); ?>"/>
                                        <input type="hidden" name="ns8-x" value="<?php print_r(explode(',', ($admindata['NS']))[7]); ?>"/>

                                        <div class="form-group">
                                            <label for="username" class="col-md-12"><?php echo __("Username"); ?></label>
                                            <div class="col-md-12">
                                                <input type="text" disabled value="<?php print_r($username); ?>" class="form-control form-control-line" name="username" id="username"> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="col-md-12"><?php echo __("Password"); ?> / <a style="cursor:pointer" onclick="generatePassword(10)"> <?php echo __("Generate"); ?></a></label>
                                            <div class="col-md-12 input-group" style="padding-left: 15px;">
                                                <input type="password" class="form-control form-control-line" autocomplete="new-password" name="password" id="password">                                    <span class="input-group-btn"> 
                                                <button class="btn btn-inverse" style="margin-right: 15px;" name="Show" onclick="toggler(this)" id="tg" type="button"><i class="ti-eye"></i></button> 
                                                </span> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12"><?php echo __("First Name"); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="fname" value="<?php print_r($admindata['FNAME']); ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-12"><?php echo __("Last Name"); ?></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="lname" value="<?php print_r($admindata['LNAME']); ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="email" class="col-md-12"><?php echo __("Email"); ?></label>
                                            <div class="col-md-12">
                                                <input type="email" value="<?php print_r($admindata['CONTACT']); ?>" class="form-control form-control-line" name="email" id="email"> 
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow: visible;">
                                            <label class="col-md-12"><?php echo __("Language"); ?></label>
                                            <div class="col-md-12">
                                                <select class="form-control select2" name="language" id="select2">
                                                    <option value="ar"><?php print_r($countries['ar']); ?></option>
                                                    <option value="bs"><?php print_r($countries['bs']); ?></option>
                                                    <option value="cn"><?php print_r($countries['cn']); ?></option>
                                                    <option value="cz"><?php print_r($countries['cz']); ?></option>
                                                    <option value="da"><?php print_r($countries['da']); ?></option>
                                                    <option value="de"><?php print_r($countries['de']); ?></option>
                                                    <option value="el"><?php print_r($countries['el']); ?></option>
                                                    <option value="en"><?php print_r($countries['en']); ?></option>
                                                    <option value="es"><?php print_r($countries['es']); ?></option>
                                                    <option value="fa"><?php print_r($countries['fa']); ?></option>
                                                    <option value="fi"><?php print_r($countries['fi']); ?></option>
                                                    <option value="fr"><?php print_r($countries['fr']); ?></option>
                                                    <option value="hu"><?php print_r($countries['hu']); ?></option>
                                                    <option value="id"><?php print_r($countries['id']); ?></option>
                                                    <option value="it"><?php print_r($countries['it']); ?></option>
                                                    <option value="ja"><?php print_r($countries['ja']); ?></option>
                                                    <option value="ka"><?php print_r($countries['ka']); ?></option>
                                                    <option value="nl"><?php print_r($countries['nl']); ?></option>
                                                    <option value="no"><?php print_r($countries['no']); ?></option>
                                                    <option value="pl"><?php print_r($countries['pl']); ?></option>
                                                    <option value="pt-BR"><?php print_r($countries['pt-BR']); ?></option>
                                                    <option value="pt"><?php print_r($countries['pt']); ?></option>
                                                    <option value="ro"><?php print_r($countries['ro']); ?></option>
                                                    <option value="ru"><?php print_r($countries['ru']); ?></option>
                                                    <option value="se"><?php print_r($countries['se']); ?></option>
                                                    <option value="tr"><?php print_r($countries['tr']); ?></option>
                                                    <option value="tw"><?php print_r($countries['tw']); ?></option>
                                                    <option value="ua"><?php print_r($countries['ua']); ?></option>
                                                    <option value="vi"><?php print_r($countries['vi']); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo __("Default Nameservers"); ?></label>
                                            <div class="col-md-12">
                                                <div><input type="text" value="<?php print_r(explode(',', ($admindata['NS']))[0]); ?>" class="form-control form-control-line" name="ns1" id="ns1x"><br></div>
                                                <div><input type="text" value="<?php print_r(explode(',', ($admindata['NS']))[1]); ?>" class="form-control form-control-line" name="ns2" id="ns2x"><br><div id="ns2wrapper"><a style="cursor:pointer;" id="addmore" onclick="add1();"><?php echo __("Add One"); ?></a></div></div>
                                                <div id="ns3" style="display:<?php if(explode(',', ($admindata['NS']))[2] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" value="<?php print_r(explode(',', ($admindata['NS']))[2]); ?>" class="form-control form-control-line" name="ns3" id="ns3x"><br><div id="ns3wrapper"><a style="cursor:pointer;" id="addmore1" onclick="add2();"><?php echo __("Add One"); ?></a> / <a style="cursor:pointer;" id="remove1" onclick="rem2();"><?php echo __("Remove One"); ?></a></div></div>
                                                <div id="ns4" style="display:<?php if(explode(',', ($admindata['NS']))[3] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" value="<?php print_r(explode(',', ($admindata['NS']))[3]); ?>" class="form-control form-control-line" name="ns4" id="ns4x"><br><div id="ns4wrapper"><a style="cursor:pointer;" id="addmore2" onclick="add3();"><?php echo __("Add One"); ?></a> / <a style="cursor:pointer;" id="remove2" onclick="rem3();"><?php echo __("Remove One"); ?></a></div></div>
                                                <div id="ns5" style="display:<?php if(explode(',', ($admindata['NS']))[4] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" value="<?php print_r(explode(',', ($admindata['NS']))[4]); ?>" class="form-control form-control-line" name="ns5" id="ns5x"><br><div id="ns5wrapper"><a style="cursor:pointer;" id="addmore3" onclick="add4();"><?php echo __("Add One"); ?></a> / <a style="cursor:pointer;" id="remove3" onclick="rem4();"><?php echo __("Remove One"); ?></a></div></div>
                                                <div id="ns6" style="display:<?php if(explode(',', ($admindata['NS']))[5] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" value="<?php print_r(explode(',', ($admindata['NS']))[5]); ?>" class="form-control form-control-line" name="ns6" id="ns6x"><br><div id="ns6wrapper"><a style="cursor:pointer;" id="addmore4" onclick="add5();"><?php echo __("Add One"); ?></a> / <a style="cursor:pointer;" id="remove4" onclick="rem5();"><?php echo __("Remove One"); ?></a></div></div>
                                                <div id="ns7" style="display:<?php if(explode(',', ($admindata['NS']))[6] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" value="<?php print_r(explode(',', ($admindata['NS']))[6]); ?>" class="form-control form-control-line" name="ns7" id="ns7x"><br><div id="ns7wrapper"><a style="cursor:pointer;" id="addmore5" onclick="add6();"><?php echo __("Add One"); ?></a> / <a style="cursor:pointer;" id="remove5" onclick="rem6();"><?php echo __("Remove One"); ?></a></div></div>
                                                <div id="ns8" style="display:<?php if(explode(',', ($admindata['NS']))[7] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" value="<?php print_r(explode(',', ($admindata['NS']))[7]); ?>" class="form-control form-control-line" name="ns8" id="ns8x"><br><div id="ns8wrapper"><a style="cursor:pointer;" id="remove6" onclick="rem7();"><?php echo __("Remove One"); ?></a></div></div>
                                            </div>
                                        </div>
                                        <?php if($themecolor != 'custom.css') { echo '
                                        <div class="form-group" style="overflow: visible;">
                                            <label class="col-md-12">' . __("Theme") . '</label>
                                            <div class="col-md-12">
                                                <select class="form-control" name="cookie">
                                                    <option value="default" '; if(base64_decode($_COOKIE["theme"]) == "default.css") { echo "selected"; } echo '>' . __("Default") . '</option>
                                                    <option value="blue" '; if(base64_decode($_COOKIE["theme"]) == "blue.css") { echo "selected"; } echo '>' . __("Blue") . '</option>
                                                    <option value="purple" '; if(base64_decode($_COOKIE["theme"]) == "purple.css") { echo "selected"; } echo '>' . __("Purple") . '</option>
                                                    <option value="orange" '; if(base64_decode($_COOKIE["theme"]) == "orange.css") { echo "selected"; } echo '>' . __("Orange") . '</option>
                                                    <option value="dark" '; if(base64_decode($_COOKIE["theme"]) == "dark.css") { echo "selected"; } echo '>' . __("Dark") . '</option>
                                                </select>
                                            </div>
                                        </div>'; } ?>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button class="btn btn-success" type="submit"><?php echo __("Update Profile"); ?></button> &nbsp;
                                                <a href="profile.php" style="color: inherit;text-decoration: inherit;"><button class="btn btn-muted" type="button" onclick="loadLoader();"><?php echo __("Back"); ?></button></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script> 
                    function submitForm() { document.getElementById("form").submit(); };
                    function exitForm() { window.location.href="profile.php"; };
                </script>
                <?php hotkeys($configlocation); ?>
            <?php footerad(); ?><footer class="footer text-center"><?php footer(); ?></footer>
        </div>
    </div>
    <script src="plugins/components/jquery/jquery.min.js"></script>
    <script src="plugins/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="plugins/components/popper.js/popper.js"></script>
    <script src="plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="plugins/components/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="plugins/components/metismenu/dist/metisMenu.min.js"></script>
    <script src="plugins/components/select2/select2.min.js"></script>
    <script src="plugins/components/waves/waves.js"></script>
    <script src="https://cdn.auth0.com/js/auth0/9.11/auth0.min.js"></script>
    <script src="js/notifications.js"></script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
        if(window.location.href.split("/").pop().includes('profile.php?settings=open#')) {
	    	window.history.pushState({}, document.title, "profile.php?settings=open");
	    }
        else if(window.location.href.split("/").pop().includes('profile.php?a=0#')) {
	    	window.history.pushState({}, document.title, "profile.php?a=0");
	    }
        else if(window.location.href.split("/").pop().includes('profile.php#')) {
	    	window.history.pushState({}, document.title, "profile.php");
	    }
        
        Waves.attach('.button', ['waves-effect']);
        Waves.init();
        var processLocation = "process/";
        
        $('#form').submit(function(ev) {
                ev.preventDefault();
                processLoader();
                this.submit();
            });
        function processLoader(){
                Swal.fire({
                    title: '<?php echo __("Processing"); ?>',
                    text: '',
                    onOpen: function () {
                        swal.showLoading()
                    }
                })};
        function loadLoader(){
            Swal.fire({
                title: '<?php echo __("Loading"); ?>',
                text: '',
                onOpen: function () {
                    swal.showLoading()
                }
            })};
        $(function () {
          $('[data-toggle="popper"]').popover({trigger: 'hover'})
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
        }
        $(document).ready(function() {
            $('.select2').select2();
        });

        document.getElementById('select2').value = '<?php print_r($admindata['LANGUAGE']); ?>';  


        <?php 
        
        if($auth0) {
            echo '
            var webAuth = new auth0.WebAuth({
                domain: "'.AUTH0_DOMAIN.'",
			    clientID: "'.AUTH0_CLIENT_ID.'",
			    responseMode: "query",
			    redirectUri: "'.$auth0location.'",
			    responseType: "code"
		    });
            function unlink(e){
                e1 = String(e)
                Swal.fire({
                  title: "'.__("Unlink Account?").'",
                  icon: "question",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "'.__("Confirm"). '"
                }).then((result) => {
                  if (result.value) {
                    Swal.fire({
                        title: "'.__("Processing").'",
                        text: "",
                        onOpen: function () {
                            swal.showLoading()
                        }
                    });
                   window.location.replace("process/unlink.php");
                  }
                })}
            function link(e){
                e1 = String(e)
                Swal.fire({
                  title: "'.__("Link Account?").'",
                  icon: "question",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#d33",
                  confirmButtonText: "'.__("Confirm"). '"
                }).then((result) => {
                  if (result.value) {
                    Swal.fire({
                        title: "'.__("Processing").'",
                        text: "",
                        onOpen: function () {
                            swal.showLoading()
                        }
                    });
                   window.location.replace("process/link.php?auth0=" + e1);
                  }
                })}';
        }

        processPlugins();
        includeScript();
        
        $checkcount = 2;
        $check1count = 3;

        while($checkcount <= 7) {
            echo "if( document.getElementById('ns" . $check1count . "x').value != '') {
                document.getElementById('ns" . $checkcount . "wrapper').style.display = 'none';
            }";

            $checkcount++;
            $check1count++;
        }

        $addcount = 1;
        $add1count = 2; 
        $add2count = 3; 


        while($addcount <= 6) {
            echo "function add" . $addcount ."() {
                if( document.getElementById('ns" . $add2count . "').style.display = 'none' ) {
                        document.getElementById('ns" . $add2count . "').style.display = 'block'; 
                        document.getElementById('ns" . $add1count . "wrapper').style.display = 'none';
                } 
            }";
            $addcount++;
            $add1count++;
            $add2count++;
        } 

        $remcount = 2;
        $rem1count = 3; 


        while($remcount <= 7) {
            echo "function rem" . $remcount ."() {
                if( document.getElementById('ns" . $rem1count . "').style.display = 'block' ) {
                    document.getElementById('ns" . $rem1count . "').style.display = 'none'; 
                    document.getElementById('ns" . $remcount . "wrapper').style.display = 'block';
                    document.getElementById('ns" . $rem1count . "x').value = '';
                } 
            }";
            $remcount++;
            $rem1count++;
        } 

        $returntotal = $_POST['r1'] + $_POST['r2'] + $_POST['r3'] + $_POST['r4'] + $_POST['r5'];
        if(isset($_POST['r1']) && $returntotal == 0) {
            echo "Swal.fire({title:'" . __("Successfully Updated!") . "', icon:'success'});";
        } 
        if(isset($_POST['a1']) && $_POST['a1'] == 0) {
            echo "Swal.fire({title:'" . __("Account Unlinked!") . "', icon:'success'});";
        } 
        if(isset($_GET['a']) && $_GET['a'] == 0) {
            echo "Swal.fire({title:'" . __("Account Linked!") . "', icon:'success'});";
        }
        
        if(isset($_POST['r1']) && $returntotal != 0) {
                echo "Swal.fire({title:'" . __("Error Updating Profile") . "', html:'" . __("Please try again or contact support.") . "<br><br><span onclick=\"$(\'.errortoggle\').toggle();\" class=\"swal-error-title\">View Error Code <i class=\"errortoggle fa fa-angle-double-right\"></i><i style=\"display:none;\" class=\"errortoggle fa fa-angle-double-down\"></i></span><span class=\"errortoggle\" style=\"display:none;\"><br><br>(E: " . $_POST['r1'] . "." . $_POST['r2'] . "." . $_POST['r3'] . "." . $_POST['r4'] . "." . $_POST['r5'] . ")</span>', icon:'error'});";
            }
        if(isset($_POST['a1']) && $_POST['a1'] != 0) {
                echo "Swal.fire({title:'" . __("Error Unlinking Account") . "', html:'" . __("Please try again or contact support.") . "<br><br><span onclick=\"$(\'.errortoggle\').toggle();\" class=\"swal-error-title\">View Error Code <i class=\"errortoggle fa fa-angle-double-right\"></i><i style=\"display:none;\" class=\"errortoggle fa fa-angle-double-down\"></i></span><span class=\"errortoggle\" style=\"display:none;\"><br><br>(E: " . $_POST['a1'] . ")</span>', icon:'error'});";
            }
        if(isset($_GET['a']) && $_GET['a'] != 0) {
                echo "Swal.fire({title:'" . __("Error Linking Account") . "', html:'" . __("Please try again or contact support.") . "<br><br><span onclick=\"$(\'.errortoggle\').toggle();\" class=\"swal-error-title\">View Error Code <i class=\"errortoggle fa fa-angle-double-right\"></i><i style=\"display:none;\" class=\"errortoggle fa fa-angle-double-down\"></i></span><span class=\"errortoggle\" style=\"display:none;\"><br><br>(E: " . $_GET['a'] . ")</span>', icon:'error'});";
            }
        ?>
        <?php if(INTERAKT_APP_ID != ''){ echo '
          (function() {
          var interakt = document.createElement("script");
          interakt.type = "text/javascript"; interakt.async = true;
          interakt.src = "//cdn.interakt.co/interakt/' . INTERAKT_APP_ID . '.js";
          var scrpt = document.getElementsByTagName("script")[0];
          scrpt.parentNode.insertBefore(interakt, scrpt);
          })()'; } ?>
        </script>
    </body>
</html>