<?php

session_start();
$configlocation = "../../includes/";
            
if (file_exists( '../../includes/config.php' )) { require( '../../includes/includes.php'); }  else { header( 'Location: ../../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php?to=admin/list/server.php'.$urlquery.$_SERVER['QUERY_STRING']); }
if($username != 'admin') { header("Location: ../../"); }

if(isset($adminenabled) && $adminenabled != 'true'){ header("Location: ../../error-pages/403.html"); }

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-sys-info','arg1' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-sys-services','arg1' => 'json'),
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
$useremail = $admindata['CONTACT'];
$sysdata = array_values(json_decode(curl_exec($curl1), true));
$servicename = array_keys(json_decode(curl_exec($curl2), true));
$servicedata = array_values(json_decode(curl_exec($curl2), true));

if(isset($admindata['LANGUAGE'])){ $locale = $ulang[$admindata['LANGUAGE']]; }
setlocale("LC_CTYPE", $locale); setlocale("LC_MESSAGES", $locale);
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

function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours');
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
        <link rel="icon" type="image/ico" href="../../plugins/images/<?php echo $cpfavicon; ?>">
        <title><?php echo $sitetitle; ?> - <?php echo _("Server"); ?></title>
        <link href="../../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../plugins/components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
        <link href="../../plugins/components/footable/css/footable.bootstrap.css" rel="stylesheet">
        <link href="../../plugins/components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
        <link href="../../css/animate.css" rel="stylesheet">
        <link href="../../css/style.css" rel="stylesheet">
        <link href="../../plugins/components/toast-master/css/jquery.toast.css" rel="stylesheet">
        <link href="../../css/colors/<?php if(isset($_COOKIE['theme'])) { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.min.css" />
        <?php if(GOOGLE_ANALYTICS_ID != ''){ echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . GOOGLE_ANALYTICS_ID . "'></script>
        <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '" . GOOGLE_ANALYTICS_ID . "');</script>"; } ?>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
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
            } 
            @media screen and (max-width: 410px) {
                .resfive { display:none !important;}
            } 
        </style>
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
                              adminMenu("./", "server");
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
                            <h4 class="page-title"><?php echo _("Server"); ?></h4> </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <ul class="side-icon-text pull-right">
                                    <li><a href="../status/cpu.php"><span class="circle circle-sm bg-info di" style="padding-top: 11px;"><i class="ti-pulse"></i></span><span><wrapper class="resthree"><?php echo _("Show "); ?></wrapper><?php echo _("Status"); ?></span></a></li>
                                    <!-- <li><a href="#"><span class="circle circle-sm bg-info di" style="padding-top: 11px;"><i class="ti-settings"></i></span><span><?php echo _("Configure"); ?></span></a></li> -->
                                </ul><br><br><br>
                                <div class="table-responsive">
                                <table class="table footable m-b-0" data-sorting="true">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td><h1><b><?php print_r($sysdata[0]['HOSTNAME']); ?></b></h1><br><b><?php print_r($sysdata[0]['OS'] . ' ' . $sysdata[0]['VERSION']); ?></b> (<?php print_r($sysdata[0]['ARCH']); ?>)</td>
                                            <td><h1>&nbsp;</h1><br>Load Average: <b><?php print_r($sysdata[0]['LOADAVERAGE']); ?></b></td>
                                            <td class="restwo"><h1>&nbsp;</h1><br>Uptime: <b><?php 
                                                if (strpos(secondsToTime($sysdata[0]['UPTIME'] * 60),'0 days') !== false) {
                                                            echo str_replace('0 days, ', '', secondsToTime($sysdata[0]['UPTIME'] * 60));
                                                    }
                                                    else {
                                                        echo secondsToTime($sysdata[0]['UPTIME'] * 60);
                                                    }
                                                ?></b></td>
                                            <!-- <td><h2>&nbsp;</h2>
                                                <button type="button" data-toggle="tooltip" data-original-title="<?php echo _("Configure"); ?>" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-settings"></i></button>
                                                <button type="button" data-toggle="tooltip" data-original-title="<?php echo _("Restart"); ?>" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-reload"></i></button>
                                            </td> -->
                                        </tr>
                                    </tbody>
                                    </table>
                                </div>
                                    <div class="table-responsive">
                                    <table class="table footable m-b-0" data-paging="false" data-sorting="true">
                                        <tbody>
                                            <?php
                                            if($servicename[0] != '') { 
                                                $x1 = 0; 

                                                do {
                                                    echo '<tr'; if($servicedata[$x1]['STATE'] != 'running') { echo ' style="background: #efefef"'; } echo '>';
                                                        echo '<td></td>
                                                        <td></td>
                                                        <td><h2>' . $servicename[$x1] . '</h2><br>' . $servicedata[$x1]['SYSTEM'] . '<br>&nbsp;</td>
                                                        <td data-sort-value="' . $servicedata[$x1]['CPU'] . '"><h2>&nbsp;</h2><br>CPU: ' . $servicedata[$x1]['CPU'] . '</td>
                                                        <td data-sort-value="' . $servicedata[$x1]['MEM'] . '"><h2>&nbsp;</h2><br>Memory: ' . $servicedata[$x1]['MEM'] . '</td>
                                                        <td class="restwo" data-sort-value="' . $servicedata[$x1]['RTIME'] . '"><h2>&nbsp;</h2><br>Uptime: ';
                                                        if (strpos(secondsToTime($servicedata[$x1]['RTIME'] * 60),'0 days') !== false) {
                                                                echo str_replace('0 days, ', '', secondsToTime($servicedata[$x1]['RTIME'] * 60));
                                                        }
                                                        else {
                                                            echo secondsToTime($servicedata[$x1]['RTIME'] * 60);
                                                        }
                                                        echo '</td>';
                                                        /* <td><h4>&nbsp;</h4>
                                                        <button type="button" data-toggle="tooltip" data-original-title="' . _("Configure") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-settings"></i></button>';  
                                                        if ($servicedata[$x1]['STATE'] != 'running') { echo '<button type="button" data-toggle="tooltip" data-original-title="' . _("Start") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-control-play"></i></button>'; } else { echo '<button type="button" data-toggle="tooltip" data-original-title="' . _("Stop") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-control-stop"></i></button>'; }
                                                        echo '<button type="button" data-toggle="tooltip" data-original-title="' . _("Restart") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-reload"></i></button></td> */
                                                    echo '</tr>';
                                                    $x1++;
                                                } while (isset($servicename[$x1])); }
                                            ?>

                                        </tbody>
                                    </table>
                                </div>
                                    </div>
                            </div>
                        </div>
                        <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../../includes/versioncheck.php'; ?> <?php echo _("by Carter Roeser"); ?>.</footer>
                    </div>
                </div>
                <script src="../../plugins/components/jquery/dist/jquery.min.js"></script>
                <script src="../../plugins/components/toast-master/js/jquery.toast.js"></script>
                <script src="../../bootstrap/dist/js/bootstrap.min.js"></script>
                <script src="../../plugins/components/sidebar-nav/dist/sidebar-nav.min.js"></script>
                <script src="../../js/jquery.slimscroll.js"></script>
                <script src="../../js/waves.js"></script>
                <script src="../../plugins/components/moment/moment.js"></script>
                <script src="../../plugins/components/footable/js/footable.min.js"></script>
                <script src="../../plugins/components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
                <script src="../../js/footable-init.js"></script>
                <script src="../../js/custom.js"></script>
                <script src="../../js/dashboard1.js"></script>
                <script src="../../js/cbpFWTabs.js"></script>
                <script src="../../plugins/components/styleswitcher/jQuery.style.switcher.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.js"></script>
                <script type="text/javascript">
                    <?php 
            $pluginlocation = "../../plugins/"; if(isset($pluginnames[0]) && $pluginnames[0] != '') { $currentplugin = 0; do { if (strtolower($pluginhide[$currentplugin]) != 'y' && strtolower($pluginhide[$currentplugin]) != 'yes') { if (strtolower($pluginadminonly[$currentplugin]) != 'y' && strtolower($pluginadminonly[$currentplugin]) != 'yes') { if (strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; } else { $currentstring = "<li><a href='".$pluginlocation.$pluginlinks[$currentplugin]."/'><i class='fa ".$pluginicons[$currentplugin]." fa-fw'></i><span class='hide-menu'>"._($pluginnames[$currentplugin])."</span></a></li>"; }} else { if(strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";} } else { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; }}} echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');\n var plugindata" . $currentplugin . " = \"" . $currentstring . "\";\n plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n"; } $currentplugin++; } while ($pluginnames[$currentplugin] != ''); } ?> 

            (function () {
                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                    new CBPFWTabs(el);
                });
            })();
            jQuery(function($){
                $('.footable').footable();
            });

            <?php

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
            if(isset($_POST['r1']) && $_POST['r1'] == "0") {
                echo "swal({title:'" . _("Successfully Updated!") . "', type:'success'});";
            } 
            if(isset($_POST['r1']) && $_POST['r1'] > "0") { echo "swal({title:'" . $errorcode[$_POST['r1']] . "<br><br>" . _("Please try again later or contact support.") . "', type:'error'});";
                                                          }
            if(isset($_POST['delcode']) && $_POST['delcode'] > "0") { echo "swal({title:'" . $errorcode[$_POST['delcode']] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
                                                                    }
            if(isset($_POST['addcode']) && $_POST['addcode'] > "0") { echo "swal({title:'" . $errorcode[$_POST['addcode']] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
                                                                    }
            ?>
        </script>
    </body>
</html>