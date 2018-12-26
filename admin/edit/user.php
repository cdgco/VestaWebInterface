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
$configlocation = "../../includes/";
if (file_exists( '../../includes/config.php' )) { require( '../../includes/includes.php'); }  else { header( 'Location: ../../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../../login.php?to=admin/edit/user.php'.$urlquery.$_SERVER['QUERY_STRING']); }
if($username != 'admin') { header("Location: ../../"); }

if(isset($adminenabled) && $adminenabled != 'true'){ header("Location: ../../error-pages/403.html"); }

if(!isset($_GET['user'])) { header("Location: ../list/users.php"); }
$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user-packages','arg1' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $_GET['user'],'arg2' => 'json'),

);

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
$packname = array_keys(json_decode(curl_exec($curl1), true));
$uxname = array_keys(json_decode(curl_exec($curl2), true));
$uxdata = array_values(json_decode(curl_exec($curl2), true));
$useremail = $admindata['CONTACT'];
if(isset($admindata['LANGUAGE'])){ $locale = $ulang[$admindata['LANGUAGE']]; }
setlocale(LC_CTYPE, $locale); setlocale(LC_MESSAGES, $locale);
bindtextdomain('messages', '../../locale');
textdomain('messages');

foreach ($plugins as $result) {
    if (file_exists('../../plugins/' . $result)) {
        if (file_exists('../../plugins/' . $result . '/manifest.xml')) {
            $get = file_get_contents('../../plugins/' . $result . '/manifest.xml');
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
        <link rel="icon" type="image/ico" href="../../plugins/images/<?php echo $cpfavicon; ?>">
        <title><?php echo $sitetitle; ?> - <?php echo _("Users"); ?></title>
        <link href="../../plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../plugins/components/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet">
        <link href="../../plugins/components/metismenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="../../plugins/components/select2/select2.min.css" rel="stylesheet">
        <link href="../../plugins/components/animate.css/animate.min.css" rel="stylesheet">
        link rel="stylesheet" href="../../plugins/components/sweetalert2/sweetalert2.min.css" />
        <link href="../../css/style.css" rel="stylesheet">
        <link href="../../css/colors/<?php if(isset($_COOKIE['theme']) && $themecolor != 'custom.css') { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <?php if($themecolor == "custom.css") { require( '../../css/colors/custom.php'); } ?>
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
                        <a class="logo" href="../../index.php">
                            <img src="../../plugins/images/<?php echo $cpicon; ?>" alt="home" class="logo-1 dark-logo" />
                            <span class="hidden-xs">
                                <img src="../../plugins/images/<?php echo $cplogo; ?>" alt="home" class="hidden-xs dark-logo" />
                            </span>
                        </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-left">
                        <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>      
                    </ul>
                    <ul class="nav navbar-top-links navbar-right pull-right">
                        <li>
                            <form class="app-search m-r-10" id="searchform" action="../../process/search.php" method="get">
                                <input type="text" placeholder="Search..." class="form-control" name="q"> <a href="javascript:void(0);" onclick="document.getElementById('searchform').submit();"><i class="fa fa-search"></i></a> </form>
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
                                <li><a href="../../profile.php"><i class="ti-home"></i> <?php echo _("My Account"); ?></a></li>
                                <li><a href="../../profile.php?settings=open"><i class="ti-settings"></i> <?php echo _("Account Settings"); ?></a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../process/logout.php"><i class="fa fa-power-off"></i> <?php echo _("Logout"); ?></a></li>
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
                        <?php indexMenu("../../"); 
                              adminMenu("../list/", "users");
                              profileMenu("../../");
                              primaryMenu("../../list/", "../../process/", "");
                        ?>
                    </ul>
                </div>
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title"><?php echo _("Edit User"); ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <form class="form-horizontal form-material" autocomplete="off" method="post" id="form" action="../change/user.php">
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Username"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" disabled value="<?php echo $uxname[0]; ?>" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;" class="form-control uneditable-input form-control-static"> 
                                            <input type="hidden" name="v_username" value="<?php echo $uxname[0]; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="col-md-12"><?php echo _("Password"); ?> / <a style="cursor:pointer" onclick="generatePassword(10)"> <?php echo _("Generate"); ?></a></label>
                                        <div class="col-md-12 input-group" style="padding-left: 15px;">
                                            <input type="password" style="padding-left: 0.5%;" autocomplete="new-password" class="form-control form-control-line" name="password" id="password">                                    <span class="input-group-btn"> 
                                            <button class="btn btn-inverse" style="margin-right: 15px;" name="Show" onclick="toggler(this)" id="tg" type="button"><i class="ti-eye"></i></button> 
                                            </span>  </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Email"); ?></label>
                                        <div class="col-md-12">
                                            <input type="email" name="email" value="<?php echo $uxdata[0]["CONTACT"]; ?>" class="form-control form-control-line" required>
                                            <input type="hidden" name="email-x" value='<?php echo $uxdata[0]["CONTACT"]; ?>'>
                                        </div>
                                    </div>
                                    <div class="form-group" style="overflow: visible;">
                                        <label class="col-md-12"><?php echo _("Package"); ?></label>
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="package" id="packageselect">
                                                <?php
                                                if($packname[0] != '') {
                                                    $x4 = 0; 

                                                    do {
                                                        echo '<option value="' . $packname[$x4] . '">' . $packname[$x4] . '</option>';
                                                        $x4++;
                                                    } while ($packname[$x4] != ''); }

                                                ?>
                                            </select>
                                            <input type="hidden" name="package-x" value='<?php echo $uxdata[0]["PACKAGE"]; ?>'>
                                        </div>
                                    </div>
                                    <div class="form-group" style="overflow: visible;">
                                        <label class="col-md-12"><?php echo _("Language"); ?></label>
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="language" id="langselect">

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
                                            <input type="hidden" name="language-x" value='<?php echo $uxdata[0]["LANGUAGE"]; ?>'>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("First Name"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="fname" value="<?php echo $uxdata[0]["FNAME"]; ?>" class="form-control form-control-line" required>
                                            <input type="hidden" name="fname-x" value='<?php echo $uxdata[0]["FNAME"]; ?>'>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Last Name"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="lname" value="<?php echo $uxdata[0]["LNAME"]; ?>" class="form-control form-control-line" required>
                                            <input type="hidden" name="lname-x" value='<?php echo $uxdata[0]["LNAME"]; ?>'>
                                        </div>
                                    </div>
                                    <div class="form-group" style="overflow: visible;">
                                        <label class="col-md-12"><?php echo _("SSH Access"); ?></label>
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="ssh" id="sshselect">
                                                <option value="bash">bash</option>
                                                <option value="dash">dash</option>
                                                <option value="nologin" selected="">nologin</option>
                                                <option value="rbash">rbash</option>
                                                <option value="rssh">rssh</option>
                                                <option value="screen">screen</option>
                                                <option value="sh">sh</option>
                                                <option value="tcsh">tcsh</option>
                                            </select>
                                            <input type="hidden" name="ssh-x" value='<?php echo $uxdata[0]["SHELL"]; ?>'>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Default Nameservers"); ?></label>
                                        <div class="col-md-12">

                                            <div><input type="text" value="<?php print_r(explode(',', ($uxdata[0]['NS']))[0]); ?>" class="form-control form-control-line" name="ns1" id="ns1x" required><br></div>

                                            <div><input type="text" value="<?php print_r(explode(',', ($uxdata[0]['NS']))[1]); ?>" class="form-control form-control-line" name="ns2" id="ns2x" required><br><div id="ns2wrapper"><a style="cursor:pointer;" id="addmore" onclick="add1();"><?php echo _("Add One"); ?></a></div></div>

                                            <div id="ns3" style="display:<?php if(explode(',', ($uxdata[0]['NS']))[2] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" value="<?php print_r(explode(',', ($uxdata[0]['NS']))[2]); ?>" class="form-control form-control-line" name="ns3" id="ns3x"><br><div id="ns3wrapper"><a style="cursor:pointer;" id="addmore1" onclick="add2();"><?php echo _("Add One"); ?></a> / <a style="cursor:pointer;" id="remove1" onclick="rem2();"><?php echo _("Remove One"); ?></a></div></div>

                                            <div id="ns4" style="display:<?php if(explode(',', ($uxdata[0]['NS']))[3] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" value="<?php print_r(explode(',', ($uxdata[0]['NS']))[3]); ?>" class="form-control form-control-line" name="ns4" id="ns4x"><br><div id="ns4wrapper"><a style="cursor:pointer;" id="addmore2" onclick="add3();"><?php echo _("Add One"); ?></a> / <a style="cursor:pointer;" id="remove2" onclick="rem3();"><?php echo _("Remove One"); ?></a></div></div>

                                            <div id="ns5" style="display:<?php if(explode(',', ($uxdata[0]['NS']))[4] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" value="<?php print_r(explode(',', ($uxdata[0]['NS']))[4]); ?>" class="form-control form-control-line" name="ns5" id="ns5x"><br><div id="ns5wrapper"><a style="cursor:pointer;" id="addmore3" onclick="add4();"><?php echo _("Add One"); ?></a> / <a style="cursor:pointer;" id="remove3" onclick="rem4();"><?php echo _("Remove One"); ?></a></div></div>

                                            <div id="ns6" style="display:<?php if(explode(',', ($uxdata[0]['NS']))[5] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" value="<?php print_r(explode(',', ($uxdata[0]['NS']))[5]); ?>" class="form-control form-control-line" name="ns6" id="ns6x"><br><div id="ns6wrapper"><a style="cursor:pointer;" id="addmore4" onclick="add5();"><?php echo _("Add One"); ?></a> / <a style="cursor:pointer;" id="remove4" onclick="rem5();"><?php echo _("Remove One"); ?></a></div></div>

                                            <div id="ns7" style="display:<?php if(explode(',', ($uxdata[0]['NS']))[6] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" value="<?php print_r(explode(',', ($uxdata[0]['NS']))[6]); ?>" class="form-control form-control-line" name="ns7" id="ns7x"><br><div id="ns7wrapper"><a style="cursor:pointer;" id="addmore5" onclick="add6();"><?php echo _("Add One"); ?></a> / <a style="cursor:pointer;" id="remove5" onclick="rem6();"><?php echo _("Remove One"); ?></a></div></div>

                                            <div id="ns8" style="display:<?php if(explode(',', ($uxdata[0]['NS']))[7] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" value="<?php print_r(explode(',', ($uxdata[0]['NS']))[7]); ?>" class="form-control form-control-line" name="ns8" id="ns8x"><br><div id="ns8wrapper"><a style="cursor:pointer;" id="remove6" onclick="rem7();"><?php echo _("Remove One"); ?></a></div></div>
                                        </div>
                                        <input type="hidden" name="ns1-x" value='<?php echo explode(',', ($uxdata[0]['NS']))[0]; ?>'>
                                        <input type="hidden" name="ns2-x" value='<?php echo explode(',', ($uxdata[0]['NS']))[1]; ?>'>
                                        <input type="hidden" name="ns3-x" value='<?php echo explode(',', ($uxdata[0]['NS']))[2]; ?>'>
                                        <input type="hidden" name="ns4-x" value='<?php echo explode(',', ($uxdata[0]['NS']))[3]; ?>'>
                                        <input type="hidden" name="ns5-x" value='<?php echo explode(',', ($uxdata[0]['NS']))[4]; ?>'>
                                        <input type="hidden" name="ns6-x" value='<?php echo explode(',', ($uxdata[0]['NS']))[5]; ?>'>
                                        <input type="hidden" name="ns7-x" value='<?php echo explode(',', ($uxdata[0]['NS']))[6]; ?>'>
                                        <input type="hidden" name="ns8-x" value='<?php echo explode(',', ($uxdata[0]['NS']))[7]; ?>'>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" type="submit"><?php echo _("Update User"); ?></button> &nbsp;
                                            <a href="../list/users.php" style="color: inherit;text-decoration: inherit;"><button onclick="loadLoader();" class="btn btn-muted" type="button"><?php echo _("Back"); ?></button></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script> 
                    function submitForm() { document.getElementById("form").submit(); };
                    function exitForm() { window.location.href="../list/users.php"; };
                </script>
                <?php hotkeys($configlocation); ?>
                <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../../includes/versioncheck.php'; ?> <?php echo _("by Carter Roeser"); ?>.</footer>
            </div>
        </div>
        <script src="../../plugins/components/jquery/jquery.min.js"></script>
        <script src="../../plugins/components/jquery-toast-plugin/jquery.toast.min.js"></script>
        <script src="../../plugins/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../../plugins/components/sweetalert2/sweetalert2.min.js"></script>
        <script src="../../plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../../plugins/components/metismenu/dist/metisMenu.min.js"></script>
        <script src="../../plugins/components/select2/select2.min.js"></script>
        <script src="../../plugins/components/waves/waves.js"></script>
        <script src="../../js/main.js"></script>
        <script type="text/javascript">
            Waves.attach('.button', ['waves-effect']);
            Waves.init();
            
            <?php 
            $pluginlocation = "../../plugins/"; if(isset($pluginnames[0]) && $pluginnames[0] != '') { $currentplugin = 0; do { if (strtolower($pluginhide[$currentplugin]) != 'y' && strtolower($pluginhide[$currentplugin]) != 'yes') { if (strtolower($pluginadminonly[$currentplugin]) != 'y' && strtolower($pluginadminonly[$currentplugin]) != 'yes') { if (strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; } else { $currentstring = "<li><a href='".$pluginlocation.$pluginlinks[$currentplugin]."/'><i class='fa ".$pluginicons[$currentplugin]." fa-fw'></i><span class='hide-menu'>"._($pluginnames[$currentplugin])."</span></a></li>"; }} else { if(strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";} } else { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; }}} echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');\n var plugindata" . $currentplugin . " = \"" . $currentstring . "\";\n plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n"; } $currentplugin++; } while ($pluginnames[$currentplugin] != ''); } ?> 

            $('#form').submit(function(ev) {
                ev.preventDefault();
                processLoader();
                this.submit();
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
            }
            <?php echo 'document.getElementById("packageselect").value = \'' . $uxdata[0]['PACKAGE'] . '\';'; ?>
            <?php echo 'document.getElementById("langselect").value = \'' . $uxdata[0]['LANGUAGE'] . '\';'; ?>
            <?php echo 'document.getElementById("sshselect").value = \'' . $uxdata[0]['SHELL'] . '\';'; ?>
            function toggler(e) {
                if( e.name == 'Hide' ) {
                    e.name = 'Show'
                    document.getElementById('password').type="password";
                } else {
                    e.name = 'Hide'
                    document.getElementById('password').type="text";
                }
            }
            $(document).ready(function() {
                $('.select2').select2();
            });
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
            
            includeScript();
            
            if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "swal({title:'" . $errorcode[1] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            } 
            $returntotal = $_POST['r1'] + $_POST['r2'] + $_POST['r3'] + $_POST['r4'] + $_POST['r5'] + $_POST['r6'] + $_POST['r7'];
            if(isset($_POST['r1']) && $returntotal == 0) {
                echo "swal({title:'" . _("Successfully Updated!") . "', type:'success'});";
            } 
            if(isset($_POST['r1']) && $returntotal != 0) {
                echo "swal({title:'" . _("Error Updating User") . "<br>" . "(E: " . $_POST['r1'] . "." . $_POST['r2'] . "." . $_POST['r3'] . "." . $_POST['r4'] . "." . $_POST['r5'] . "." . $_POST['r6'] . "." . $_POST['r7'] . ")<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            }
            ?>
        </script>
    </body>
</html>