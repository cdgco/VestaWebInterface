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
$configlocation = "../../includes/";
if (file_exists( '../../includes/config.php' )) { require( '../../includes/includes.php'); }  else { header( 'Location: ../../install' ); exit();};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../../login.php?to=admin/list/users.php'.$urlquery.$_SERVER['QUERY_STRING']); exit(); }
if($username != 'admin') { header("Location: ../../"); exit(); }

if(isset($adminenabled) && $adminenabled != 'true'){ header("Location: ../../error-pages/403.html"); exit(); }

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-users','arg1' => 'json'));

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
$uxname = array_keys(json_decode(curl_exec($curl1), true));
$uxdata = array_values(json_decode(curl_exec($curl1), true));
if(isset($admindata['LANGUAGE'])){ $locale = $ulang[$admindata['LANGUAGE']]; }
_setlocale('LC_CTYPE', $locale); _setlocale('LC_MESSAGES', $locale);
_bindtextdomain('messages', '../../locale');
_textdomain('messages');

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
        <title><?php echo $sitetitle; ?> - <?php echo __("Users"); ?></title>
        <link href="../../plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../plugins/components/footable/footable.bootstrap.css" rel="stylesheet">
        <link href="../../plugins/components/metismenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="../../plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../plugins/components/sweetalert2/sweetalert2.min.css" />
        <link href="../../css/style.css" rel="stylesheet">
        <link href="../../css/colors/<?php if(isset($_COOKIE['theme']) && $themecolor != 'custom.css') { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <?php if($themecolor == "custom.css") { require( '../../css/colors/custom.php'); } ?>
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
            @media screen and (max-width: 600px) {
                .resfour { display:block !important;}
                .resfive { display:block !important; }
                .ressix { display:none !important; }
            }
            @media screen and (max-width: 450px) {
                .resfive { display:block !important;
                    position: relative !important;
                    right: 10px !important;
                }
                .resseven {
                    font-size: 12px !important;
                    position: relative !important;
                    right: 10px !important;
                }
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
                                <li><a href="../../profile.php"><i class="ti-home"></i> <?php echo __("My Account"); ?></a></li>
                                <li><a href="../../profile.php?settings=open"><i class="ti-settings"></i> <?php echo __("Account Settings"); ?></a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="../../process/logout.php"><i class="fa fa-power-off"></i> <?php echo __("Logout"); ?></a></li>
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
                        <?php indexMenu("../../"); 
                              adminMenu("./", "users");
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
                            <h4 class="page-title"><?php echo __("Manage Users"); ?></h4>
                        </div>
                        <?php headerad(); ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box"> <ul class="side-icon-text pull-right">
                                <li><a href="../add/user.php"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span class="ressix"><wrapper class="resthree"><?php echo __("Add") ?> </wrapper><?php echo __("User"); ?></span></a></li>
                                </ul>
                                <h3 class="box-title m-b-0"><?php echo __("Users"); ?></h3><br>
                                <div class="table-responsive">
                                <table class="table footable m-b-0" data-paging="false" data-sorting="true">
                                    <thead style="display:none;">
                                        <tr>
                                            <th class="resone" data-type="numeric" data-sorted="true" data-direction="DESC"></th>
                                            <th data-sortable="false"></th>
                                            <th class="resthree" data-sortable="false"></th>
                                            <th class="restwo" data-sortable="false"></th>
                                            <th class="resfive" data-sortable="false"></th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php
                                        if($uxname[0] != '') { 
                                            $x1 = 0; 

                                            do {

                                                if ($uxdata[$x1]['DISK_QUOTA'] != 0) {
                                                    $diskpercent = (($uxdata[$x1]['U_DISK'] / $uxdata[$x1]['DISK_QUOTA']) * 100);
                                                } else { $diskpercent = '0'; }
                                                if ($uxdata[$x1]['BANDWIDTH'] != 0) {
                                                    $bwpercent = (($uxdata[$x1]['U_BANDWIDTH'] / $uxdata[$x1]['BANDWIDTH']) * 100);
                                                } else { $bwpercent = '0'; }
                                                echo '<tr'; if($uxdata[$x1]['SUSPENDED'] != 'no') { echo ' style="background: #efefef"'; } echo '>
                                                    <td class="resone" style="padding-top: 32px;" data-sort-value="' . strtotime($uxdata[$x1]['DATE'] . ' ' . $uxdata[$x1]['TIME']) . '">' . $uxdata[$x1]['DATE'];  
                                                    if($uxdata[$x1]['SUSPENDED'] != 'no') { echo '<br><br><b>'.__("Suspended").'</b>'; } echo '</td>
                                                    <td>
                                                        <h2>' . $uxname[$x1] . '</h2>
                                                        <h5>' . $uxdata[$x1]['FNAME'] . ' ' . $uxdata[$x1]['LNAME'] . '</h5><br>
                                                        <div class="tworow" style="line-height: 30px;">
                                                            <div class="column">'.__("Bandwidth").':</div>
                                                            <div class="column">' . formatMB($uxdata[$x1]['U_BANDWIDTH']) . '</div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:'; if($diskpercent == " INF "){ echo "0 ";}else{echo $bwpercent;} echo '%;"> 
                                                                <span class="sr-only">'; if($bwpercent == "INF"){ echo "0";}else{echo $bwpercent;} echo '%;">% Complete</span>
                                                            </div>
                                                        </div>
                                                        <div class="tworow" style="line-height: 30px;">
                                                            <div class="column">'.__("Disk").':</div>
                                                            <div class="column">' . formatMB($uxdata[$x1]['U_DISK']) . '</div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:'; if($diskpercent == " INF "){ echo "0 ";}else{echo $diskpercent;} echo '%;">
                                                                <span class="sr-only">'; if($diskpercent == "INF"){ echo "0";}else{echo $diskpercent;} echo '%;">% Complete</span>
                                                            </div>
                                                        </div>
                                                        <div class="tworow" style="line-height: 30px;">
                                                              <div class="column">'.__("Web").': ' . formatMB($uxdata[$x1]['U_DISK_WEB']) . '<br>'.__("Mail").': ' . formatMB($uxdata[$x1]['U_DISK_MAIL']) . '</div>
                                                              <div class="column">
                                                                '.__("Databases").': ' . formatMB($uxdata[$x1]['U_DISK_DB']) . '<br>
                                                                '.__("Directories").': ' . formatMB($uxdata[$x1]['U_DISK_DIRS']) . '
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="resthree">
                                                        <div class="resthree tworow" style="padding-top:110px; line-height: 30px;">
                                                              <div class="column">'.__("Web Domains").':<br>'.__("DNS Domains").':<br>'.__("Mail Domains").':<br>'.__("Databases").':<br>'.__("Cron Jobs").':<br>'.__("Backups").':</div>
                                                              <div class="column">' . $uxdata[$x1]['U_WEB_DOMAINS'] . ' / ';
                                                                    if($uxdata[$x1]['WEB_DOMAINS'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($uxdata[$x1]['WEB_DOMAINS']); } 
                                                                    echo '<br>' . $uxdata[$x1]['U_DNS_DOMAINS'] . ' / ';
                                                                    if($uxdata[$x1]['DNS_DOMAINS'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($uxdata[$x1]['DNS_DOMAINS']); } 
                                                                    echo '<br>' . $uxdata[$x1]['U_MAIL_DOMAINS'] . ' / ';
                                                                    if($uxdata[$x1]['MAIL_DOMAINS'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($uxdata[$x1]['MAIL_DOMAINS']); } 
                                                                    echo '<br>' . $uxdata[$x1]['U_DATABASES'] . ' / ';
                                                                    if($uxdata[$x1]['DATABASES'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($uxdata[$x1]['DATABASES']); } 
                                                                    echo '<br>' . $uxdata[$x1]['U_CRON_JOBS'] . ' / ';
                                                                    if($uxdata[$x1]['CRON_JOBS'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($uxdata[$x1]['CRON_JOBS']); } 
                                                                    echo '<br>' . $uxdata[$x1]['U_BACKUPS'] . ' / ';
                                                                    if($uxdata[$x1]['BACKUPS'] == "unlimited"){echo "<i class='ti-infinite'></i>";} else{ print_r($uxdata[$x1]['BACKUPS']); } 
                                                                echo '</div>
                                                            </div>
                                                      </td>
                                                      <td class="restwo">
                                                            <div class="restwo tworow" style="padding-top:110px;line-height: 30px;">
                                                                  <div class="column">'.__("Email").':<br>'.__("Package").':<br>'.__("SSH Access").':<br>'.__("IP Addresses").':<br>'.__("Nameservers").':</div>
                                                                  <div class="column">' . $uxdata[$x1]['CONTACT'] . '<br>' . $uxdata[$x1]['PACKAGE'] . '<br>' . $uxdata[$x1]['SHELL'] . '<br>' . $uxdata[$x1]['IP_OWNED'] . '<br>
                                                                    <ul style="list-style: none;padding-left:0;line-height: 25px;">';
                                                                        $nsArray = explode(',', ($uxdata[$x1]['NS'])); 

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
                                                         <td style="padding-top:110px;line-height: 30px;">
                                                                <a href="../process/loginas.php?user=' . $uxname[$x1] . '"><button type="button" data-toggle="tooltip" data-original-title="' . __("Login as") . ' ' . $uxname[$x1] . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-key"></i></button></a>
                                                            <a href="../edit/user.php?user=' . $uxname[$x1] . '"><button type="button" data-toggle="tooltip" data-original-title="' . __("Edit") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-pencil-alt"></i></button></a>';
                                                                if ($uxdata[$x1]['SUSPENDED'] == 'no') { echo '<button type="button" onclick="confirmSuspend(\'' . $uxname[$x1] . '\')" data-toggle="tooltip" data-original-title="' . __("Suspend") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-lock"></i></button>'; }
                                                                else { echo '<button type="button" onclick="confirmUnsuspend(\'' . $uxname[$x1] . '\')" data-toggle="tooltip" data-original-title="' . __("Unsuspend") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-unlock"></i></button>'; }

                                                            echo '<button onclick="confirmDelete(\'' . $uxname[$x1] . '\')" type="button" data-toggle="tooltip" data-original-title="' . __("Delete") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="fa fa-trash-o"></i></button>
                                                        </td>
                                                    </tr>';
                                                $x1++;
                                            } while (isset($uxname[$x1])); }
                                        ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script> 
                    function addNewObj() { window.location.href="../add/user.php"; };
                </script>
                <?php hotkeys($configlocation); ?>
                <?php footerad(); ?><footer class="footer text-center"><?php footer(); ?></footer>
            </div>
        </div>
        <script src="../../plugins/components/jquery/jquery.min.js"></script>
        <script src="../../plugins/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../../plugins/components/sweetalert2/sweetalert2.min.js"></script>
        <script src="../../plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../../plugins/components/metismenu/dist/metisMenu.min.js"></script>
        <script src="../../plugins/components/moment/moment.min.js"></script>
        <script src="../../plugins/components/footable/footable.min.js"></script>
        <script src="../../plugins/components/waves/waves.js"></script>
        <script src="../../js/notifications.js" one="<?php echo $configlocation; ?>"></script>
        <script src="../../js/main.js"></script>
        <script type="text/javascript">
	    if(window.location.href.split("/").pop().includes('#')) {
	    	window.history.pushState({}, document.title, "users.php");
	    }

            Waves.attach('.button', ['waves-effect']);
            Waves.init();
            var processLocation = "../../process/";

            jQuery(function($){
                $('.footable').footable();
            });
            function confirmDelete(e){
                e1 = String(e)
                Swal.fire({
                  title: '<?php echo __("Delete"); ?> ' + e1 + '?',
                    text: "<?php echo __("You won't be able to revert this!"); ?>",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: '<?php echo __("Yes, delete it!"); ?>'
                }).then((result) => {
                  if (result.value) {
                    Swal.fire({
                        title: '<?php echo __("Processing"); ?>',
                        text: '',
                        onOpen: function () {
                            swal.showLoading()
                        }
                    });
                   window.location.replace("../delete/user.php?user=" + e1);
                  }
                })}

            function confirmSuspend(f){
                f1 = String(f)
                Swal.fire({
                  title: '<?php echo __("Suspend"); ?> ' + f1 +' ?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: '<?php echo __("Confirm"); ?>'
                }).then((result) => {
                  if (result.value) {
                    Swal.fire({
                        title: '<?php echo __("Processing"); ?>',
                        text: '',
                        onOpen: function () {
                            swal.showLoading()
                        }
                    });
                   window.location.replace("../suspend/user.php?user=" + f1);
                  }
                })}
            function confirmUnsuspend(f2){
                f2 = String(f2)
                Swal.fire({
                  title: '<?php echo __("Unsuspend"); ?> ' + f2 +' ?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: '<?php echo __("Confirm"); ?>'
                }).then((result) => {
                  if (result.value) {
                    Swal.fire({
                        title: '<?php echo __("Processing"); ?>',
                        text: '',
                        onOpen: function () {
                            swal.showLoading()
                        }
                    });
                   window.location.replace("../unsuspend/user.php?user=" + f2);
                  }
                })}

            <?php

            processPlugins();
            includeScript();
            
            if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "Swal.fire({title:'" . $errorcode[1] . "', html:'" . __("Please try again or contact support.") . "', icon:'error'});";
            }
            if(isset($_POST['delcode']) && $_POST['delcode'] == "0") {
                echo "Swal.fire({title:'" . __("Successfully Deleted!") . "', icon:'success'});";
            } 
            if(isset($_POST['addcode']) && $_POST['addcode'] == "0") {
                echo "Swal.fire({title:'" . __("Successfully Created!") . "', icon:'success'});";
            } 
            if(isset($_POST['r1']) && $_POST['r1'] == "0") {
                echo "Swal.fire({title:'" . __("Successfully Updated!") . "', icon:'success'});";
            } 
            if(isset($_POST['r1']) && $_POST['r1'] > "0") {
                echo "Swal.fire({title:'" . $errorcode[$_POST['r1']] . "', html:'" . __("Please try again or contact support.") . "', icon:'error'});";
            } 
            if(isset($_POST['delcode']) && $_POST['delcode'] > "0") {
                echo "Swal.fire({title:'" . $errorcode[$_POST['delcode']] . "', html:'" . __("Please try again or contact support.") . "', icon:'error'});";
            }
            if(isset($_POST['addcode']) && $_POST['addcode'] > "0") {
                echo "Swal.fire({title:'" . $errorcode[$_POST['addcode']] . "', html:'" . __("Please try again or contact support.") . "', icon:'error'});";
            }
            ?>
        </script>
    </body>
</html>