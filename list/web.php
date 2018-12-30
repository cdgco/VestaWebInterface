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
else { header('Location: ../login.php?to=list/web.php' . $urlquery . $_SERVER['QUERY_STRING']); }

if(isset($webenabled) && $webenabled != 'true'){ header("Location: ../error-pages/403.html"); }

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-domains','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-sys-config','arg1' => 'json'));

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
$domainname = array_keys(json_decode(curl_exec($curl1), true));
$domaindata = array_values(json_decode(curl_exec($curl1), true));
$sysconfigdata = array_values(json_decode(curl_exec($curl2), true))[0];

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
        <title><?php echo $sitetitle; ?> - <?php echo _("Web"); ?></title>
        <link href="../plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../plugins/components/footable/footable.bootstrap.css" rel="stylesheet">
        <link href="../plugins/components/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet">
        <link href="../plugins/components/metismenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="../plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../plugins/components/sweetalert2/sweetalert2.min.css" />
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/colors/<?php if(isset($_COOKIE['theme']) && $themecolor != 'custom.css') { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <?php if($themecolor == "custom.css") { require( '../css/colors/custom.php'); } ?>
        <style>
            @media screen and (max-width: 1199px) {
                .resone { display:none !important;}
            }  
            @media screen and (max-width: 991px) {
                .restwo { display:none !important;}
            }    
            @media screen and (max-width: 767px) {
                .resthree { display:none !important;}
                td { font-size: 12px; }
            } 
            @media screen and (max-width: 540px) {
                .resfour { display:none !important;}
                .resfourshow { display:block !important;}
                td { font-size: 11px; }
            } 
            @media screen and (max-width: 410px) {
                .resfive { display:none !important;}
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
                                <input type="text" placeholder="<?php echo _("Search..."); ?>" class="form-control" name="q"> <a href="javascript:void(0);" onclick="document.getElementById('searchform').submit();"><i class="fa fa-search"></i></a> </form>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"><b class="hidden-xs"><?php print_r($displayname); ?></b><span class="caret"></span> </a>
                            <ul class="dropdown-menu dropdown-user animated flipInY">
                                <li>
                                    <div class="dw-user-box">
                                        <div class="u-text">
                                            <h4><?php print_r($displayname); ?></h4>
                                            <p class="text-muted"><?php print_r($useremail); ?></p>
                                        </div>
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
                              primaryMenu("./", "../process/", "");
                        ?>
                    </ul>
                </div>
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title"><?php echo _("Manage Web Domains"); ?></h4>
                        </div>
                    </div>
                    <div class="row resone">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center><?php echo _("DOMAINS"); ?></center>
                                        </div>
                                        <div class="panel-body">
                                            <center><h2><?php print_r($admindata['U_WEB_DOMAINS']); ?></h2></center>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center><?php echo _("ALIASES"); ?></center>
                                        </div>
                                        <div class="panel-body">
                                            <center><h2><?php print_r($admindata['U_WEB_ALIASES']); ?></h2></center>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center><?php echo _("SUSPENDED"); ?></center>
                                        </div>
                                        <div class="panel-body">
                                            <center><h2><?php print_r($admindata['SUSPENDED_WEB']); ?></h2></center>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box"> <ul class="side-icon-text pull-right">
                                <li><a href="../add/domain.php"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span class="resthree"><wrapper class="restwo"><?php echo _("Add "); ?></wrapper><?php echo _("Domain"); ?></span></a></li>
                                </ul>
                                <h3 class="box-title m-b-0"><?php echo _("Web Domains"); ?></h3><br>
                                <div class="table-responsive">
                                <table class="table footable m-b-0" data-sorting="true">
                                    <thead>
                                        <tr>
                                            <th data-toggle="true"><span class="resfive"><?php echo _("Domain"); ?></span> <?php echo _("Name"); ?></th>
                                            <th class="restwo" data-type="numeric"> <?php echo _("Disk Usage"); ?> </th>
                                            <th class="restwo" data-type="numeric"> <?php echo _("Bandwidth"); ?> </th>
                                            <th class="resone"> <?php echo _("Status"); ?> </th>
                                            <th class="resone" data-type="date" data-format-string="YYYY-MM-DD" data-sorted="true" data-direction="DESC"> <?php echo _("Created"); ?> </th>
                                            <th data-sortable="false"><?php echo _("Action"); ?></th>
                                            <th data-breakpoints="all"><?php echo _("Aliases"); ?></th>
                                            <th data-breakpoints="all"><span class="resfour"><?php echo _("Web "); ?></span><?php echo _("Template"); ?></th>
                                            <?php if($sysconfigdata['PROXY_SYSTEM'] != '') { echo '<th data-breakpoints="all"><span class="resfour">'. _("Proxy Template"). '</span><span style="display:none;" class="resfourshow">'._("Proxy").'</span></th>'; }
                                            if($sysconfigdata['WEB_BACKEND'] != '') { echo '<th data-breakpoints="all"><span class="resfour">'. _("Backend Template").'</span><span style="display:none;" class="resfourshow">'._("Backend").'</span></th>'; }
                                            if(checkService('vsftpd') !== false || checkService('proftpd') !== false) { echo '
                                            <th data-breakpoints="all"><span class="resfour">' . _("Additional FTP") . '</span><span style="display:none;" class="resfourshow">' . _("FTP").'</span></th>'; } ?>
                                            <th data-breakpoints="all"><span class="resfour"><?php echo _("Web Statistics"); ?></span><span class="resfourshow" style="display:none;"><?php echo _("Stats"); ?></span></th>
                                            <th data-breakpoints="all"><?php echo _("IP"); ?> </th>
                                            <th data-breakpoints="all"><?php echo _("SSL"); ?> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if($domainname[0] != '') { 
                                            $x1 = 0; 

                                            do {
                                                echo '<tr'; if($domaindata[$x1]['SUSPENDED'] != 'no') { echo ' style="background: #efefef"'; } echo '>
                                                        <td>' . $domainname[$x1] . '</td>
                                                        <td class="restwo" data-sort-value="' . $domaindata[$x1]['U_DISK'] . '">' . formatMB($domaindata[$x1]['U_DISK']) . '</td>
                                                        <td class="restwo" data-sort-value="' . $domaindata[$x1]['U_BANDWIDTH'] . '">' . formatMB($domaindata[$x1]['U_BANDWIDTH']) . '</td>
                                                        <td class="resone">';                                                                   
                                                        if($domaindata[$x1]['SUSPENDED'] == "no"){ 
                                                            echo '<span class="label label-table label-success">' . _("Active") . '</span>';} 
                                                        else{ 
                                                            echo '<span class="label label-table label-danger">' . _("Suspended") . '</span>';} 
                                                        echo '</td>
                                                        <td class="resone" data-sort-value="' . $domaindata[$x1]['DATE'] . '">' . $domaindata[$x1]['DATE'] . '</td><td>
                                                            <a href="../edit/domain.php?domain=' . $domainname[$x1] . '"><button type="button" data-toggle="tooltip" data-original-title="' . _("Edit") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-pencil-alt"></i></button></a>
                                                            <a href="../log/access.php?domain=' . $domainname[$x1] . '"><button type="button" data-toggle="tooltip" data-original-title="' . _("View Logs") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-menu-alt"></i></button></a>';

                                                            if ($initialusername == "admin" && $domaindata[$x1]['SUSPENDED'] == 'no') { echo '<button type="button" onclick="confirmSuspend(\'' . $domainname[$x1] . '\')" data-toggle="tooltip" data-original-title="' . _("Suspend") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-lock"></i></button>'; }
                                                            elseif ($initialusername == "admin" && $domaindata[$x1]['SUSPENDED'] == 'yes') { echo '<button type="button" onclick="confirmUnsuspend(\'' . $domainname[$x1] . '\')" data-toggle="tooltip" data-original-title="' . _("Unsuspend") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-unlock"></i></button>'; }
                                                            echo '<button onclick="confirmDelete(\'' . $domainname[$x1] . '\')" type="button" data-toggle="tooltip" data-original-title="' . _("Delete") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="fa fa-trash-o"></i></button>'; if($domaindata[$x1]['STATS'] != ""){  echo '<button type="button" onclick="window.location=\'http://' . $domainname[$x1] . '/vstats/\';" data-toggle="tooltip" data-original-title="' . _("View Stats") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-stats-up"></i></button>';} echo '
                                                        </td>
                                                        <td>'; if(implode(', ', explode(",", $domaindata[$x1]['ALIAS'])) == "") { echo _("None");} else{ echo implode(', ', explode(",", $domaindata[$x1]['ALIAS']));} echo '</td>
                                                        <td>' . ucfirst($domaindata[$x1]['TPL']) . '</td>';
                                                        if($sysconfigdata['PROXY_SYSTEM'] != '') { echo '<td>';
                                                            if($domaindata[$x1]['PROXY'] != '') { echo
                                                                ucfirst($domaindata[$x1]['PROXY']) . '</td>';
                                                            }  
                                                            else { echo 'None'; }
                                                        }
                                                        if($sysconfigdata['WEB_BACKEND'] != '') { echo '<td>';
                                                            if($domaindata[$x1]['BACKEND'] != '') { echo
                                                                ucfirst($domaindata[$x1]['BACKEND']) . '</td>';
                                                            }  
                                                            else { echo 'None'; }
                                                        }
                                                        if(checkService('vsftpd') !== false || checkService('proftpd') !== false) { echo '
                                                        <td>'; if($domaindata[$x1]['FTP_USER'] == ""){ 
                                                            echo _("None");} 
                                                            else{ 
                                                                echo $domaindata[$x1]['FTP_USER'];} 
                                                        echo '</td>'; }
                                                        echo '<td>'; if($domaindata[$x1]['STATS'] == ""){ 
                                                            echo _("None");} 
                                                            else{ 
                                                                echo ucfirst($domaindata[$x1]['STATS']);} 
                                                        echo '</td><td>' . $domaindata[$x1]['IP'] . '</td>      
                                                        <td>'; if($domaindata[$x1]['SSL'] == "no"){ 
                                                            echo '<span class="label label-table label-danger">' . _("Disabled") . '</span>';} 
                                                        else{ 
                                                            echo '<span class="label label-table label-success">' . _("Enabled") . '</span>';} 
                                                        echo '</td>
                                                    </tr>';
                                                $x1++;
                                            } while (isset($domainname[$x1])); }
                                        ?>
                                    </tbody>
                                </table>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    function addNewObj() { window.location.href="../add/domain.php"; };
                </script>
                <?php hotkeys($configlocation); ?>
                <footer class="footer text-center"><?php footer(); ?></footer>
            </div>
        </div>
        <script src="../plugins/components/jquery/jquery.min.js"></script>
        <script src="../plugins/components/jquery-toast-plugin/jquery.toast.min.js"></script>
        <script src="../plugins/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../plugins/components/sweetalert2/sweetalert2.min.js"></script>
        <script src="../plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../plugins/components/metismenu/dist/metisMenu.min.js"></script>
        <script src="../plugins/components/moment/moment.min.js"></script>
        <script src="../plugins/components/footable/footable.min.js"></script>
        <script src="../plugins/components/waves/waves.js"></script>
        <script src="../js/notifications.js"></script>
        <script src="../js/main.js"></script>
        <script type="text/javascript">
            Waves.attach('.button', ['waves-effect']);
            Waves.init();
            var processLocation = "../process/";
            <?php 
            $pluginlocation = "../plugins/"; if(isset($pluginnames[0]) && $pluginnames[0] != '') { $currentplugin = 0; do { if (strtolower($pluginhide[$currentplugin]) != 'y' && strtolower($pluginhide[$currentplugin]) != 'yes') { if (strtolower($pluginadminonly[$currentplugin]) != 'y' && strtolower($pluginadminonly[$currentplugin]) != 'yes') { if (strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; } else { $currentstring = "<li><a href='".$pluginlocation.$pluginlinks[$currentplugin]."/'><i class='fa ".$pluginicons[$currentplugin]." fa-fw'></i><span class='hide-menu'>"._($pluginnames[$currentplugin])."</span></a></li>"; }} else { if(strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";} } else { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; }}} echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');\n var plugindata" . $currentplugin . " = \"" . $currentstring . "\";\n plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n"; } $currentplugin++; } while ($pluginnames[$currentplugin] != ''); } ?>
 
            jQuery(function($){
                $('.footable').footable();
            });
            
            function confirmDelete(e){
                e1 = String(e)
                Swal({
                  title: '<?php echo _("Delete Web Domain"); ?>:<br>' + e1 +' ?',
                  text: "<?php echo _("You won't be able to revert this!"); ?>",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: '<?php echo _("Yes, delete it!"); ?>'
                }).then((result) => {
                  if (result.value) {
                    swal({
                        title: '<?php echo _("Processing"); ?>',
                        text: '',
                        onOpen: function () {
                            swal.showLoading()
                        }
                    });
                   window.location.replace("../delete/domain.php?domain=" + e1);
                  }
                })}
            function confirmSuspend(f){
                f1 = String(f)
                Swal({
                  title: '<?php echo _("Suspend Web Domain"); ?>:<br> ' + f1 +' ?',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: '<?php echo _("Confirm"); ?>'
                }).then((result) => {
                  if (result.value) {
                    swal({
                        title: '<?php echo _("Processing"); ?>',
                        text: '',
                        onOpen: function () {
                            swal.showLoading()
                        }
                    });
                   window.location.replace("../admin/suspend/domain.php?user=<?php echo $username; ?>&resource=" + f1);
                  }
                })}
            function confirmUnsuspend(f2){
                f2 = String(f2)
                Swal({
                  title: '<?php echo _("Unsuspend Web Domain"); ?>:<br> ' + f2 +' ?',
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: '<?php echo _("Confirm"); ?>'
                }).then((result) => {
                  if (result.value) {
                    swal({
                        title: '<?php echo _("Processing"); ?>',
                        text: '',
                        onOpen: function () {
                            swal.showLoading()
                        }
                    });
                   window.location.replace("../admin/unsuspend/domain.php?user=<?php echo $username; ?>&resource=" + f2);
                  }
                })}

            <?php

            
            includeScript();
            
            $deltotal = $_POST['r1'] + $_POST['r2'] + $_POST['r3'];
            if(isset($_POST['r1']) && $deltotal == 0) {
                echo "swal({title:'" . _("Successfully Deleted!") . "', type:'success'});";
            } 
            if(isset($_POST['r1']) && $deltotal != 0) {
                echo "swal({title:'" . _("Error Deleting Web Domain") . "<br>" . "(E: " . $_POST['r1'] . "." . $_POST['r2'] . "." . $_POST['r3'] . ")" . _("Please try again or contact support.") . "<br><br>', type:'error'});";
            }

            $addtotal = $_POST['a1'] + $_POST['a2'] + $_POST['a3'] + $_POST['a4'] + $_POST['a5'] + $_POST['a6'] + $_POST['a7'] + $_POST['a8'];
            if(isset($_POST['a1']) && $addtotal == 0) {
                echo "swal({title:'" . _("Successfully Created!") . "', type:'success'});";
            } 
            if(isset($_POST['a1']) && $addtotal != 0) {
                echo "swal({title:'" . _("Error Creating Web Domain") . "<br>"  . "(E: " . $_POST['a1'] . "." . $_POST['a2'] . "." . $_POST['a3'] . "." . $_POST['a4'] . "." . $_POST['a5'] . "." . $_POST['a6'] . "." . $_POST['a7'] . "." . $_POST['a8'] . ")" . _("Please try again or contact support.") . "<br><br>', type:'error'});";
            }
            if(isset($_POST['u1']) && $_POST['u1'] == 0) {
                echo "swal({title:'" . _("Successfully Updated!") . "', type:'success'});";
            } 
            if(isset($_POST['u1']) && $_POST['u1'] != 0) {
                echo "swal({title:'" . $errorcode[$_POST['u1']] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            }
            ?>
        </script>
    </body>
</html>