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
else { header('Location: ../../login.php?to=admin/list/stats.php'.$urlquery.$_SERVER['QUERY_STRING']); }
if($username != 'admin') { header("Location: ../../"); }

if (isset($_GET['user']) && $_GET['user'] != '' && $username == 'admin') { $logusername = $_GET['user'];}
else { $logusername = $username;}

if(isset($adminenabled) && $adminenabled != 'true'){ header("Location: ../../error-pages/403.html"); }

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user-stats','arg1' => $logusername,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-users','arg1' => 'json'));

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
$statsname = array_keys(json_decode(curl_exec($curl1), true));
$statsdata = array_values(json_decode(curl_exec($curl1), true));
$sysusers = array_keys(json_decode(curl_exec($curl2), true));
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
        <title><?php echo $sitetitle; ?> - <?php echo _("Stats"); ?></title>
        <link href="../../plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href='../../plugins/components/bootstrap-select/css/bootstrap-select.min.css' rel="stylesheet">
        <link href="../../plugins/components/footable/footable.bootstrap.css" rel="stylesheet">
        <link href="../../plugins/components/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet">
        <link href="../../plugins/components/metismenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="../../plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../plugins/components/sweetalert2/sweetalert2.min.css" />
        <link href="../../css/style.css" rel="stylesheet">
        <link href="../../css/colors/<?php if(isset($_COOKIE['theme']) && $themecolor != 'custom.css') { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <?php if($themecolor == "custom.css") { require( '../../css/colors/custom.php'); } ?>
        <style>
            @media screen and (max-width: 1199px) {
                .resone { display:none !important;}
            }  
            @media screen and (max-width: 991px) {
                .restwo { display:none !important;}
            }    
            @media screen and (max-width: 767px) {
                .resthree { display:none !important;}
            } 
            @media screen and (max-width: 540px) {
                .resfour { display:none !important;}
                .resfourshow { display:inline-block !important;}
            } 
            @media screen and (max-width: 410px) {
                .resfive { display:none !important;}
                .resfiveshow { display:inline-block !important; width:65px !important;}
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
                        <a class="logo" href="../../index.php">
                            <img src="../../plugins/images/<?php echo $cpicon; ?>" alt="home" class="logo-1 dark-logo" />
                            <img src="../../plugins/images/<?php echo $cplogo; ?>" alt="home" class="hidden-xs dark-logo" />
                        </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-left">
                        <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>  
                        <?php notifications(); ?>
                    </ul>
                    <ul class="nav navbar-top-links navbar-right pull-right">
                        <li>
                            <form class="app-search m-r-10" id="searchform" action="../../process/search.php" method="get">
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
                              adminMenu("./", "stats");
                              profileMenu("../../");
                              primaryMenu("../../list/", "../../process/", "");
                        ?>
                    </ul>
                </div>
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title" style="overflow:visible;">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title"><?php echo _("User Stats"); ?></h4> 
                        </div>
                        <?php if($username == 'admin'){ echo 
                            '<div class="col-lg-2 col-sm-8 col-md-8 col-xs-12 pull-right">
                                <div style="margin-right:257px;width:220px;" class="btn-group bootstrap-select input-group-btn">
                                    <form id="loguserform" action="stats.php" method="get">
                                        <select class="selectpicker pull-right m-l-20" id="loguser" name="user" data-style="form-control">';
                                           if($sysusers[0] != '') {
                                               $x2 = 0; 
                                               do {
                                                   echo '<option value="' . $sysusers[$x2] . '">' . $sysusers[$x2] . '</option>';
                                                   $x2++;
                                               } while ($sysusers[$x2] != ''); }         
                                         echo '</select>
                                    </form>
                                </div>
                                <div class="input-group-btn">
                                    <button type="button" onclick=\'document.getElementById("loguserform").submit();swal({title: "' . _('Processing') . '", text: "",timer: 5000,onOpen: function () {swal.showLoading();}}).then(function () {},function (dismiss) {if (dismiss === "timer") {}})\' class=" pull-right btn waves-effect waves-light color-button"><i class="ti-angle-right"></i></button>
                                </div>
                            </div>'; 
                        } ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <div class="table-responsive">
                                <table class="table footable m-b-0"  data-sorting="true">
                                    <thead>
                                        <tr>
                                            <th data-type="date" data-format-string="MMMM YYYY" data-sorted="true" data-direction="DESC"> <?php echo _("Date"); ?> </th>
                                            <th data-sortable="false"> <?php echo _("Bandwidth"); ?> </th>
                                            <th data-sortable="false"> <?php echo _("Disk"); ?> </th>
                                            <th data-breakpoints="all"><?php echo _("Disk"); ?></th>
                                            <th data-breakpoints="all"><?php echo _("Web"); ?></th>
                                            <th data-breakpoints="all"><?php echo _("DNS"); ?></th>
                                            <th data-breakpoints="all"><?php echo _("Mail"); ?></th>
                                            <th data-breakpoints="all"><?php echo _("Databases"); ?></th>
                                            <th data-breakpoints="all"><?php echo _("Cron Jobs"); ?></th>
                                            <th data-breakpoints="all"><?php echo _("IP Addresses"); ?></th>
                                            <th data-breakpoints="all"><?php echo _("Backups"); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if($statsname[0] != '') {
                                            $x1 = 0; 

                                            do {
                                                echo '<tr>
                                                    <td data-sort-value="' . date("F Y", strtotime($statsname[$x1])) . '">' . date("F Y", strtotime($statsname[$x1])) . '</td>
                                                    <td>' . formatMB($statsdata[$x1]['U_BANDWIDTH']) . '</td>
                                                    <td>' . formatMB($statsdata[$x1]['U_DISK']) . '</td>
                                                    
                                                    
                                                    <td><br><b>Web:</b> ' . formatMB($statsdata[$x1]['U_DISK_WEB']) . '<br><b>Mail:</b> ' . formatMB($statsdata[$x1]['U_DISK_MAIL']) . '<br><b>Databases:</b> ' . formatMB($statsdata[$x1]['U_DISK_DB']) . '<br><b>User Directories:</b> ' . formatMB($statsdata[$x1]['U_DISK_DIRS']) . '</td>
                                                    <td><br><b>Domains:</b> ' . $statsdata[$x1]['U_WEB_DOMAINS'] . '<br><b>SSL Domains:</b> ' . $statsdata[$x1]['U_WEB_SSL'] . '<br><b>Aliases:</b> ' . $statsdata[$x1]['U_WEB_ALIASES'] . '</td>
                                                    <td><br><b>Domains:</b> ' . $statsdata[$x1]['U_DNS_DOMAINS'] . '<br><b>Records:</b> ' . $statsdata[$x1]['U_DNS_RECORDS'] . '</td>
                                                    <td><br><b>Domains:</b> ' . $statsdata[$x1]['U_MAIL_DOMAINS'] . '<br><b>Accounts:</b> ' . $statsdata[$x1]['U_MAIL_ACCOUNTS'] . '</td>
                                                    
                                                    
                                                    <td>' . $statsdata[$x1]['U_DATABASES'] . '</td>
                                                    <td>' . $statsdata[$x1]['U_CRON_JOBS'] . '</td>
                                                    <td>' . $statsdata[$x1]['IP_OWNED'] . '</td>
                                                    <td>' . $statsdata[$x1]['U_BACKUPS'] . '</td>
                                                </tr>';
                                                $x1++;
                                            } while ($statsname[$x1] != ''); }
                                        ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php hotkeys($configlocation); ?>
                <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../../includes/versioncheck.php'; ?> <?php echo _("by Carter Roeser"); ?>.</footer>
            </div>
        </div>
        <script src="../../plugins/components/jquery/jquery.min.js"></script>
        <script src="../../plugins/components/jquery-toast-plugin/jquery.toast.min.js"></script>
        <script src="../../plugins/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../../plugins/components/sweetalert2/sweetalert2.min.js"></script>
        <script src="../../plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../../plugins/components/bootstrap-select/js/bootstrap-select.min.js"></script>
        <script src="../../plugins/components/metismenu/dist/metisMenu.min.js"></script>
        <script src="../../plugins/components/moment/moment.min.js"></script>
        <script src="../../plugins/components/footable/footable.min.js"></script>
        <script src="../../plugins/components/waves/waves.js"></script>
        <script src="../../js/notifications.js"></script>
        <script src="../../js/main.js"></script>
        <script type="text/javascript">
            Waves.attach('.button', ['waves-effect']);
            Waves.init();
            var processLocation = "../../process/";
            <?php 
            $pluginlocation = "../../plugins/"; if(isset($pluginnames[0]) && $pluginnames[0] != '') { $currentplugin = 0; do { if (strtolower($pluginhide[$currentplugin]) != 'y' && strtolower($pluginhide[$currentplugin]) != 'yes') { if (strtolower($pluginadminonly[$currentplugin]) != 'y' && strtolower($pluginadminonly[$currentplugin]) != 'yes') { if (strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; } else { $currentstring = "<li><a href='".$pluginlocation.$pluginlinks[$currentplugin]."/'><i class='fa ".$pluginicons[$currentplugin]." fa-fw'></i><span class='hide-menu'>"._($pluginnames[$currentplugin])."</span></a></li>"; }} else { if(strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";} } else { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; }}} echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');\n var plugindata" . $currentplugin . " = \"" . $currentstring . "\";\n plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n"; } $currentplugin++; } while ($pluginnames[$currentplugin] != ''); } ?> 

            jQuery(function($){
                $('.footable').footable();
            });

            <?php
            if ($username = 'admin') { echo 'document.getElementById("loguser").value = \'' . $logusername . '\';';}
            
            includeScript();
            
            if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "swal({title:'" . $errorcode[1] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            } 
            if(isset($_POST['delcode']) && $_POST['delcode'] == "0") {
                echo "swal({title:'" . _("Successfully Deleted!") . "', type:'success'});";
            } 
            if(isset($_POST['addcode']) && $_POST['addcode'] == "0") {
                echo "swal({title:'" . _("Successfully Created!") . "', type:'success'});";
            } 
            if(isset($_POST['delcode']) && $_POST['delcode'] > "0") { echo "swal({title:'" . $errorcode[$_POST['delcode']] . "<br><br>" . _("Please try again later or contact support.") . "', type:'error'});";
                                                                    }
            if(isset($_POST['addcode']) && $_POST['addcode'] > "0") { echo "swal({title:'" . $errorcode[$_POST['addcode']] . "<br><br>" . _("Please try again later or contact support.") . "', type:'error'});";
                                                                    }
            ?>
        </script>
    </body>
</html>