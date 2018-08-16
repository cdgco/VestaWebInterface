<?php

/** 
*
* Vesta Web Interface v0.5.1-Beta
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
else { header('Location: ../login.php?to=admin/list/packages.php'.$urlquery.$_SERVER['QUERY_STRING']); }
if($username != 'admin') { header("Location: ../../"); }

if(isset($adminenabled) && $adminenabled != 'true'){ header("Location: ../../error-pages/403.html"); }

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user-packages','arg1' => 'json'));

$curl0 = curl_init();
$curl1 = curl_init();
$curlstart = 0; 

while($curlstart <= 1) {
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
$packname = array_keys(json_decode(curl_exec($curl1), true));
$packdata = array_values(json_decode(curl_exec($curl1), true));
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
        <title><?php echo $sitetitle; ?> - <?php echo _("Packages"); ?></title>
        <link href="../../plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../plugins/components/metismenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="../../plugins/components/footable/compiled/footable.bootstrap.css" rel="stylesheet">
        <link href="../../plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link href="../../css/style.css" rel="stylesheet">
        <link href="../../plugins/components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet">
        <link href="../../css/colors/<?php if(isset($_COOKIE['theme'])) { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <link rel="stylesheet" href="../../plugins/components/sweetalert2/dist/sweetalert2.min.css" />
        <?php if(GOOGLE_ANALYTICS_ID != ''){ echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . GOOGLE_ANALYTICS_ID . "'></script>
        <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '" . GOOGLE_ANALYTICS_ID . "');</script>"; } ?>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            .column {
                float: left;
                width: 50%;
            }
            .tworow:after {
                content: "";
                display: table;
                clear: both;
            }
            @media screen and (max-width: 1400px) {
                .resone { display:none !important;}
            }      
            @media screen and (max-width: 1275px) {
                .restwo { display:none !important;}
            }
            @media screen and (max-width: 875px) {
                .resthree { display:none !important;}
            }
            @media screen and (max-width: 767px) {
                .resfour { display:none !important;}
                .resbutton { padding-top:35px !important; line-height: inherit !important;}
            }  
            @media screen and (max-width: 540px) {
                .resfive { display:none !important; }
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
                              adminMenu("./", "packages");
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
                            <h4 class="page-title"><?php echo _("Manage Packages"); ?></h4> </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box"> <ul class="side-icon-text pull-right">
                                <li><a href="../add/package.php"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span class="resfour"><wrapper class="resthree"><?php echo _("Add") ?> </wrapper><?php echo _("Package"); ?></span></a></li>
                                </ul>
                                <h3 class="box-title m-b-0"><?php echo _("Packages"); ?></h3><br>
                                <div class="table-responsive">
                                <table class="table footable m-b-0" data-paging="false" data-sorting="true">
                                    <thead>
                                        <tr>
                                            <th class="resone" data-type="numeric" data-sorted="true" data-direction="DESC"></th>
                                            <th class="resfour" data-sortable="false"></th>
                                            <th class="resthree" data-sortable="false"></th>
                                            <th class="restwo" data-sortable="false"></th>
                                            <th data-sortable="false"></th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php
                                        if($packname[0] != '') { 
                                            $x1 = 0; 

                                            do {

                                                echo '<tr>
                                                        <td class="resone" style="padding-top: 32px;" data-sort-value="' . strtotime($packdata[$x1]['DATE'] . ' ' . $packdata[$x1]['TIME']) . '">' . $packdata[$x1]['DATE'];  echo '</td>
                                                        <td>
                                                            <h2>' . $packname[$x1] . '</h2><br>
                                                            <div class="resfour tworow" style="line-height: 30px;">
                                                                <div class="column">Web Template:<br>Proxy Template:<br>DNS Template:<br>SSH Access:<br>Web Domains:<br>Web Aliases</div>
                                                                <div class="column">' . $packdata[$x1]['WEB_TEMPLATE'] . '<br>' . $packdata[$x1]['PROXY_TEMPLATE'] . '<br>' . $packdata[$x1]['DNS_TEMPLATE'] . '<br>' . $packdata[$x1]['SHELL'] . '<br>' . $packdata[$x1]['WEB_DOMAINS'] . '<br>' . $packdata[$x1]['WEB_ALIASES'] . '</div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="resthree tworow" style="padding-top:72px; line-height: 30px;">
                                                                <div class="column">DNS Domains:<br>DNS Records:<br>Mail Domains:<br>Mail Accounts:<br>Databases:<br>Cron Jobs</div>
                                                                <div class="column">' . $packdata[$x1]['DNS_DOMAINS'] . '<br>' . $packdata[$x1]['DNS_RECORDS'] . '<br>' . $packdata[$x1]['MAIL_DOMAINS'] . '<br>' . $packdata[$x1]['MAIL_ACCOUNTS'] . '<br>' . $packdata[$x1]['DATABASES'] . '<br>' . $packdata[$x1]['CRON_JOBS'] . '</div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="restwo tworow" style="padding-top:72px; line-height: 30px;">
                                                                <div class="column">Backups:<br>Bandwidth:<br>Disk Space:<br>Nameservers:</div>
                                                                <div class="column">' . $packdata[$x1]['BACKUPS'] . '<br>' . $packdata[$x1]['BANDWIDTH'] . '<br>' . $packdata[$x1]['DISK_QUOTA'] . '<br>
                                                                    <ul style="list-style: none;padding-left:0;line-height: 25px;">';
                                                                        $nsArray = explode(',', ($packdata[$x1]['NS'])); 

                                                                        foreach ($nsArray as &$value) {
                                                                            $value = "<li>" . $value . "</li>";
                                                                        }  
                                                                        foreach($nsArray as $val) {
                                                                            echo $val;
                                                                        } 
                                                                    echo '</ul>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td style="padding-top:110px;line-height: 30px;" class="resbutton">
                                                            <a href="../edit/package.php?package=' . $packname[$x1] . '"><button type="button" data-toggle="tooltip" data-original-title="' . _("Edit") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-pencil-alt"></i></button></a><span>';
                                                            echo '</span><button onclick="confirmDelete(\'' . $packname[$x1] . '\')" type="button" data-toggle="tooltip" data-original-title="' . _("Delete") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>';
                                                $x1++;
                                            } while (isset($packname[$x1])); }
                                        ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script> 
                    function addNewObj() { window.location.href="../add/package.php"; };
                </script>
                <?php hotkeys($configlocation); ?>
                <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../../includes/versioncheck.php'; ?> <?php echo _("by Carter Roeser"); ?>.</footer>
            </div>
        </div>
        <script src="../../plugins/components/jquery/dist/jquery.min.js"></script>
        <script src="../../plugins/components/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
        <script src="../../plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../../plugins/components/metismenu/dist/metisMenu.min.js"></script>
        <script src="../../js/jquery.slimscroll.js"></script>
        <script src="../../js/waves.js"></script>
        <script src="../../js/moment.min.js"></script>
        <script src="../../plugins/components/footable/compiled/footable.min.js"></script>
        <script src="../../js/footable-init.js"></script>
        <script src="../../js/custom.js"></script>
        <script src="../../js/cbpFWTabs.js"></script>
        <script src="../../plugins/components/sweetalert2/dist/sweetalert2.min.js"></script>
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
            function confirmDelete(e,f){
                e1 = String(e)
                e2 = String(f)
                swal({
                    title: '<?php echo _("Delete package:"); ?> ' + e1 + ' ?',
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
                    window.location.replace("../delete/package.php?package=" + e1);
                })}

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