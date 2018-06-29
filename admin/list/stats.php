<?php

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
        <title><?php echo $sitetitle; ?> - <?php echo _("Stats"); ?></title>
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
                .resfourshow { display:inline-block !important;}
            } 
            @media screen and (max-width: 410px) {
                .resfive { display:none !important;}
                .resfiveshow { display:inline-block !important; width:65px !important;}
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
                                            <th class="resfour" data-sortable="false"> <?php echo _("Bandwidth"); ?> </th>
                                            <th class="resfive" data-sortable="false"> <?php echo _("Disk"); ?> </th>
                                            <th data-breakpoints="all"><?php echo _("Disk"); ?></th>
                                            <th data-breakpoints="all"><?php echo _("Web"); ?> <span class="resfiveshow" style="display:none;"><?php echo _("Domains"); ?></span></th>
                                            <th data-breakpoints="all"><?php echo _("DNS"); ?> <span class="resfiveshow" style="display:none;"><?php echo _("Domains"); ?></span></th>
                                            <th data-breakpoints="all"><?php echo _("Mail"); ?> <span class="resfiveshow" style="display:none;"><?php echo _("Domains"); ?></span></th>
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
                                                    <td class="resfour">' . formatMB($statsdata[$x1]['U_BANDWIDTH']) . '</td>
                                                    <td class="resfive">' . formatMB($statsdata[$x1]['U_DISK']) . '</td>
                                                    <td><wrapper class="resfive"><br><b>Web:</b> ' . formatMB($statsdata[$x1]['U_DISK_WEB']) . '<br><b>Mail:</b> ' . formatMB($statsdata[$x1]['U_DISK_MAIL']) . '<br><b class="resfour">Databases:</b><b class="resfourshow" style="display:none">DB:</b> ' . formatMB($statsdata[$x1]['U_DISK_DB']) . '<br><b class="resfour">User Directories:</b><b class="resfourshow" style="display:none">User:</b> ' . formatMB($statsdata[$x1]['U_DISK_DIRS']) . '</wrapper><wrapper style="display:none" class="resfiveshow">' . formatMB($statsdata[$x1]['U_DISK']) . '</wrapper></td>
                                                    <td><wrapper class="resfive"><br><b>Domains:</b> ' . $statsdata[$x1]['U_WEB_DOMAINS'] . '<br><b>SSL<b class="resfour"> Domains</b>:</b> ' . $statsdata[$x1]['U_WEB_SSL'] . '<br><b>Aliases:</b> ' . $statsdata[$x1]['U_WEB_ALIASES'] . '</wrapper><wrapper style="display:none" class="resfiveshow">' . $statsdata[$x1]['U_WEB_DOMAINS'] . '</wrapper></td>
                                                    <td><wrapper class="resfive"><br><b>Domains:</b> ' . $statsdata[$x1]['U_DNS_DOMAINS'] . '<br><b>Records:</b> ' . $statsdata[$x1]['U_DNS_RECORDS'] . '</wrapper><wrapper style="display:none" class="resfiveshow">' . $statsdata[$x1]['U_DNS_DOMAINS'] . '</wrapper></td>
                                                    <td><wrapper class="resfive"><br><b>Domains:</b> ' . $statsdata[$x1]['U_MAIL_DOMAINS'] . '<br><b>Accounts:</b> ' . $statsdata[$x1]['U_MAIL_ACCOUNTS'] . '</wrapper><wrapper style="display:none" class="resfiveshow">' . $statsdata[$x1]['U_MAIL_DOMAINS'] . '</wrapper></td>
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

            if ($username = 'admin') { echo 'document.getElementById("loguser").value = \'' . $logusername . '\';';}

            ?>
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
            if(isset($_POST['delcode']) && $_POST['delcode'] > "0") { echo "swal({title:'" . $errorcode[$_POST['delcode']] . "<br><br>" . _("Please try again later or contact support.") . "', type:'error'});";
                                                                    }
            if(isset($_POST['addcode']) && $_POST['addcode'] > "0") { echo "swal({title:'" . $errorcode[$_POST['addcode']] . "<br><br>" . _("Please try again later or contact support.") . "', type:'error'});";
                                                                    }
            ?>
        </script>
    </body>
</html>