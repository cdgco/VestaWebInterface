<?php

session_start();
$configlocation = "../../includes/";
if (file_exists( '../../includes/config.php' )) { require( '../../includes/includes.php'); }  else { header( 'Location: ../../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php?to=admin/list/users.php'.$urlquery.$_SERVER['QUERY_STRING']); }
if($username != 'admin') { header("Location: ../../"); }

if(isset($adminenabled) && $adminenabled != 'true'){ header("Location: ../../error-pages/403.html"); }

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
        <title><?php echo $sitetitle; ?> - <?php echo _("Users"); ?></title>
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
                .reseight { display:block !important; 
                }
                .reseight p {
                    line-height: 5% !important;
                }
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
                            <h4 class="page-title"><?php echo _("Manage Users"); ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box"> <ul class="side-icon-text pull-right">
                                <li><a href="../add/user.php"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span class="ressix"><?php echo _("Add User"); ?></span></a></li>
                                </ul>
                                <h3 class="box-title m-b-0"><?php echo _("Users"); ?></h3><br>

                                <table class="table footable m-b-0" data-paging="false" data-sorting="true">
                                    <thead>
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
                                                    if($uxdata[$x1]['SUSPENDED'] != 'no') { echo '<br><br><b>Suspended</b>'; } echo '</td>
                                                    <td class="resseven">
                                                        <h2>' . $uxname[$x1] . '</h2>
                                                        <h5>' . $uxdata[$x1]['FNAME'] . ' ' . $uxdata[$x1]['LNAME'] . '</h5><br>
                                                        <div class="tworow" style="line-height: 30px;">
                                                            <div class="column">Bandwidth:</div>
                                                            <div class="column">' . formatMB($uxdata[$x1]['U_BANDWIDTH']) . '</div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:'; if($diskpercent == " INF "){ echo "0 ";}else{echo $bwpercent;} echo '%;"> 
                                                                <span class="sr-only">'; if($bwpercent == "INF"){ echo "0";}else{echo $bwpercent;} echo '%;">% Complete</span>
                                                            </div>
                                                        </div>
                                                        <div class="tworow" style="line-height: 30px;">
                                                            <div class="column">Disk:</div>
                                                            <div class="column">' . formatMB($uxdata[$x1]['U_DISK']) . '</div>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:'; if($diskpercent == " INF "){ echo "0 ";}else{echo $diskpercent;} echo '%;">
                                                                <span class="sr-only">'; if($diskpercent == "INF"){ echo "0";}else{echo $diskpercent;} echo '%;">% Complete</span>
                                                            </div>
                                                        </div>
                                                        <div class="tworow" style="line-height: 30px;">
                                                              <div class="column">Web: ' . formatMB($uxdata[$x1]['U_DISK_WEB']) . '<br>Mail: ' . formatMB($uxdata[$x1]['U_DISK_MAIL']) . '</div>
                                                              <div class="column">
                                                                <span class="ressix">Databases: ' . formatMB($uxdata[$x1]['U_DISK_DB']) . '<br></span>
                                                                <span class="reseight" style="display:none">DB: ' . formatMB($uxdata[$x1]['U_DISK_DB']) . '</span>
                                                                <span class="ressix">Directories: ' . formatMB($uxdata[$x1]['U_DISK_DIRS']) . '</span>
                                                                <span class="reseight" style="display:none">Dirs: ' . formatMB($uxdata[$x1]['U_DISK_DIRS']) . '</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="resthree">
                                                        <div class="resthree tworow" style="padding-top:110px; line-height: 30px;">
                                                              <div class="column">Web Domains:<br>DNS Domains:<br>Mail Domains:<br>Databases:<br>Cron Jobs:<br>Backups:</div>
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
                                                                  <div class="column">Email:<br>Package:<br>SSH Access:<br>IP Addresses:<br>Name Servers:</div>
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
                                                         <td class="resfive" style="padding-top:110px;line-height: 30px;">
                                                            <span class="resfour">
                                                                <a href="../process/loginas.php?user=' . $uxname[$x1] . '"><button type="button" data-toggle="tooltip" data-original-title="' . _("Login as") . ' ' . $uxname[$x1] . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-key"></i></button></a>
                                                            </span>
                                                            <span class="reseight" style="display:none">
                                                                <p>&nbsp</p>
                                                            </span>
                                                            <a href="../edit/user.php?user=' . $uxname[$x1] . '"><button type="button" data-toggle="tooltip" data-original-title="' . _("Edit") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-pencil-alt"></i></button></a>
                                                            <span class="reseight" style="display:none">
                                                                <p>&nbsp</p>
                                                            </span>
                                                            <span class="resfour">';
                                                                if ($uxdata[$x1]['SUSPENDED'] == 'no') { echo '<button type="button" onclick="confirmSuspend(\'' . $uxname[$x1] . '\')" data-toggle="tooltip" data-original-title="' . _("Suspend") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-lock"></i></button>'; }
                                                                else { echo '<button type="button" onclick="confirmUnsuspend(\'' . $uxname[$x1] . '\')" data-toggle="tooltip" data-original-title="' . _("Unsuspend") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-unlock"></i></button>'; }

                                                            echo '</span>
                                                            <span class="reseight" style="display:none">
                                                                <p>&nbsp</p>
                                                            </span>
                                                            <button onclick="confirmDelete(\'' . $uxname[$x1] . '\')" type="button" data-toggle="tooltip" data-original-title="' . _("Delete") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="icon-trash"></i></button>
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
                <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../../includes/versioncheck.php'; ?> <?php echo _("by CDG Web Services"); ?>.</footer>
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
            function confirmDelete(e){
                e1 = String(e)
                swal({
                    title: '<?php echo _("Delete"); ?> ' + e1 + '?',
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
                    window.location.replace("../delete/user.php?user=" + e1);
                })}
            function confirmSuspend(f){
                f1 = String(f)
                swal({
                    title: '<?php echo _("Suspend"); ?> ' + f1 +' ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<?php echo _("Confirm"); ?>'
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
                    window.location.replace("../suspend/user.php?user=" + f1);
                })}
            function confirmUnsuspend(f2){
                f2 = String(f2)
                swal({
                    title: '<?php echo _("Unsuspend"); ?> ' + f2 +' ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<?php echo _("Confirm"); ?>'
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
                    window.location.replace("../unsuspend/user.php?user=" + f2);
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