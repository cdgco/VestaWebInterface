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
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' ); exit();};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php?to=list/dnsdomain.php' . $urlquery . $_SERVER['QUERY_STRING']); exit(); }

if(isset($dnsenabled) && $dnsenabled != 'true'){ header("Location: ../error-pages/403.html"); exit(); }

$requestdns = $_GET['domain'];

if (isset($requestdns) && $requestdns != '') {}
else { header('Location: ../list/dns.php'); exit(); }

if (CLOUDFLARE_EMAIL != '' && CLOUDFLARE_API_KEY != ''){
    $cfenabled = curl_init();

    curl_setopt($cfenabled, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones?name=" . $requestdns);
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
    if ($cfname != '' && isset($cfname) && $cfname == $requestdns){

        $cfns = curl_init();
        curl_setopt($cfns, CURLOPT_URL, $vst_url);
        curl_setopt($cfns, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($cfns, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($cfns, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($cfns, CURLOPT_POST, true);
        curl_setopt($cfns, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-dns-records','arg1' => $username,'arg2' => $requestdns, 'arg3' => 'json')));

        $cfdata = array_values(json_decode(curl_exec($cfns), true));

        $cfnumber = array_keys(json_decode(curl_exec($cfns), true));
        $requestArr = array_column(json_decode(curl_exec($cfns), true), 'TYPE');
        $requestrecord = array_search('NS', $requestArr);

        $nsvalue = $cfdata[$requestrecord]['VALUE'];
        if( strpos( $nsvalue, '.ns.cloudflare.com' ) !== false ) {
            header('Location: ../list/cfdomain.php?domain='.$requestdns);
        }
    }
}

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-dns-records','arg1' => $username,'arg2' => $requestdns, 'arg3' => 'json'));

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
if (CLOUDFLARE_EMAIL == '' || CLOUDFLARE_API_KEY == ''){ $cfenabled = 'off'; }
$admindata = json_decode(curl_exec($curl0), true)[$username];
$useremail = $admindata['CONTACT'];
$dnsname = array_keys(json_decode(curl_exec($curl1), true));
$dnsdata = array_values(json_decode(curl_exec($curl1), true));
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
        <title><?php echo $sitetitle; ?> - <?php echo _("DNS"); ?></title>
        <link href="../plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../plugins/components/footable/footable.bootstrap.css" rel="stylesheet">
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
                h2 { font-size: 4vw; }
                .bg-title ul.side-icon-text {
                    position: relative;
                    top: -20px;
                }
                h4.page-title {
                    position: relative;
                    top: 20px;
                }
            } 
            .icon-cloudflare { top: -6.2px; }
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
                              primaryMenu("./", "../process/", "dns");
                        ?>
                    </ul>
                </div>
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title"><?php echo _("Manage DNS Domain"); ?></h4>
                        </div>
                        <ul id="cloudflare1" class="side-icon-text pull-right">
                            <li style="position: relative;top: -3px;">
                                <a onclick="confirmDelete2();" style="cursor: pointer;"><span class="circle circle-sm bg-danger di"><i class="ti-trash"></i></span><span class="resthree"><wrapper class="restwo"><?php echo _("Delete DNS"); ?> </wrapper><?php echo _("Domain"); ?></span>
                                </a>
                            </li>
                        </ul>
                        <ul id="cloudflare" class="side-icon-text pull-right" style="display:none;">
                            <li style="position: relative;top: -8px;">
                                <a onclick="confirmDelete2();" style="cursor: pointer;"><span class="circle circle-sm bg-danger di"><i class="ti-trash"></i></span><span class="resthree"><wrapper class="restwo"><?php echo _("Delete DNS"); ?> </wrapper><?php echo _("Domain"); ?></span>
                                </a>
                            </li>
                            <li style="position: relative;top: -8px;">
                                <a href="../create/cloudflare.php?domain=<?php echo $requestdns; ?>"><span style="top: 8px;position: relative;"class="circle circle-sm bg-success di"><i class="icon-cloudflare">&#xe800;</i></span><span class="resthree"><wrapper class="restwo"><?php echo _("Enable"); ?> </wrapper><?php echo _("Cloudflare"); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center><?php echo _("DOMAIN"); ?></center>
                                        </div>
                                        <div class="panel-body">
                                            <center><h2><?php print_r($requestdns); ?></h2></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box"> <ul class="side-icon-text pull-right">
                                <li><a href="../add/dnsrecord.php?domain=<?php echo $requestdns; ?>"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span class="resthree"><wrapper class="restwo"><?php echo _("Add"); ?> </wrapper><?php echo _("Record"); ?></span></a></li>
                                </ul>
                                <h3 class="box-title m-b-0"><wrapper class="restwo"><?php echo _("DNS"); ?> </wrapper><?php echo _("Records"); ?></h3><br>
                                <div class="table-responsive">
                                    <table class="table footable m-b-0" data-sorting="true">
                                        <thead>
                                            <tr>
                                                <th data-toggle="true"> <?php echo _("Record"); ?> </th>
                                                <th> <?php echo _("Type"); ?> </th>
                                                <th style="max-width:10%"> <?php echo _("Value"); ?> </th>
                                                <th data-sortable="false"> <?php echo _("Action"); ?> </th>
                                                <th data-breakpoints="all"> <?php echo _("Status"); ?> </th>
                                                <th data-breakpoints="all" data-format-string="YYYY-MM-DD" data-sorted="true" data-direction="DESC"> <?php echo _("Created"); ?> </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            if($dnsname[0] != '') {
                                                $x1 = 0; 

                                                do {
                                                    echo '<tr>
                                                            <td>' . $dnsdata[$x1]['RECORD'] . '</td>
                                                            <td>' . $dnsdata[$x1]['TYPE'] . '</td>
                                                            <td style="max-width: 240px;overflow-wrap: break-word;overflow: auto;">' . $dnsdata[$x1]['VALUE'] . '</td>
                                                            <td><a href="../edit/dnsrecord.php?domain=' . $requestdns . '&record=' . $dnsname[$x1] . '"><button type="button" class="btn color-button btn-outline btn-circle btn-md m-r-5" data-toggle="tooltip" data-original-title="' . _("Edit") . '"><i class="ti-pencil-alt"></i></button></a>
                                                                
                                                                <button type="button" onclick="confirmDelete(\'' . $dnsname[$x1] . '\');" class="btn color-button btn-outline btn-circle btn-md m-r-5" data-toggle="tooltip" data-original-title="' . _("Delete") . '"><i class="fa fa-trash-o" ></i></button>
                                                            </td><td>';                                                                   
                                                    if($dnsdata[$x1]['SUSPENDED'] == "no"){ 
                                                        echo '<span class="label label-table label-success">' . _("Active") . '</span>';} 
                                                    else{ 
                                                        echo '<span class="label label-table label-danger">' . _("Suspended") . '</span>';} 
                                                    echo '</td>
                                                            <td>' . $dnsdata[$x1]['DATE'] . '</td></tr>';
                                                    $x1++;
                                                } while ($dnsname[$x1] != ''); }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script> 
                    function addNewObj() { window.location.href="../add/dnsrecord.php?domain=<?php echo $requestdns; ?>"; };
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
            function subDomain() {

                url = '<?php echo $requestdns; ?>';
                url = url.replace(new RegExp(/^\s+/),"");
                url = url.replace(new RegExp(/\s+$/),"");
                url = url.replace(new RegExp(/\\/g),"/");
                url = url.replace(new RegExp(/^http\:\/\/|^https\:\/\/|^ftp\:\/\//i),"");
                url = url.replace(new RegExp(/^www\./i),"");
                url = url.replace(new RegExp(/\/(.*)/),"");
                if (url.match(new RegExp(/\.[a-z]{2,3}\.[a-z]{2}$/i))) {
                    url = url.replace(new RegExp(/\.[a-z]{2,3}\.[a-z]{2}$/i),"");
                } else if (url.match(new RegExp(/\.[a-z]{2,4}$/i))) {
                    url = url.replace(new RegExp(/\.[a-z]{2,4}$/i),"");
                }
                var subDomain = (url.match(new RegExp(/\./g))) ? true : false;
            }

                <?php if ($cfenabled != "off") { echo 'if(subDomain === false) {
                        document.getElementById("cloudflare").style.display = "block";
                        document.getElementById("cloudflare1").style.display = "none";
                    }
                    else { 
                        document.getElementById("cloudflare1").style.display = "block";
                        document.getElementById("cloudflare").style.display = "none";
                    }
                    subDomain();'; } ?>
            function confirmDelete(e){
                e1 = String(e)
                e0 = '<?php print_r($requestdns); ?>';
                Swal({
                  title: '<?php echo _("Delete DNS Record"); ?><br> #' + e1 +' ?',
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
                  window.location.replace("../delete/dnsrecord.php?domain=" + e0 + "&id=" +e1);
                  }
                })}
            function confirmDelete2(){
                Swal({
                 title: '<?php echo _("Delete DNS Domain"); ?>:<br> <?php echo $requestdns; ?>' + ' ?',
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
                  window.location.replace("../delete/dns.php?domain=<?php echo $requestdns; ?>");
                  }
                })}

                <?php
            
            includeScript();
            
                if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "swal({title:'" . $errorcode[1] . "', html:'" . _("Please try again or contact support.") . "', type:'error'});";
            }
                if(isset($_POST['delcode']) && $_POST['delcode'] == "0") {
                    echo "swal({title:'" . _("Successfully Deleted!") . "', type:'success'});";
                } 
                if(isset($_POST['addcode']) && $_POST['addcode'] == "0") {
                    echo "swal({title:'" . _("Successfully Created!") . "', type:'success'});";
                } 
                if(isset($_POST['delcode']) && $_POST['delcode'] > "0") {
                echo "swal({title:'" . $errorcode[$_POST['delcode']] . "', html:'" . _("Please try again or contact support.") . "', type:'error'});";
            }
            if(isset($_POST['addcode']) && $_POST['addcode'] > "0") {
                echo "swal({title:'" . $errorcode[$_POST['addcode']] . "', html:'" . _("Please try again or contact support.") . "', type:'error'});";
            }

                ?>
        </script>
    </body>
</html>