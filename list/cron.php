<?php

session_start();
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};
require_once '../includes/cronparser.php';

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php?to=list/cron.php' . $urlquery . $_SERVER['QUERY_STRING']); }

if(isset($cronenabled) && $cronenabled != 'true'){ header("Location: ../error-pages/403.html"); }

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-cron-jobs','arg1' => $username,'arg2' => 'json'));

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
$cronname = array_keys(json_decode(curl_exec($curl1), true));
$crondata = array_values(json_decode(curl_exec($curl1), true));
if(isset($admindata['LANGUAGE'])){ $locale = $ulang[$admindata['LANGUAGE']]; }
setlocale("LC_CTYPE", $locale); setlocale("LC_MESSAGES", $locale);
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
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/ico" href="../plugins/images/<?php echo $cpfavicon; ?>">
        <title><?php echo $sitetitle; ?> - <?php echo _("Cron Jobs"); ?></title>
        <link href="../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../plugins/components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
        <link href="../plugins/components/footable/css/footable.bootstrap.css" rel="stylesheet">
        <link href="../plugins/components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
        <link href="../css/animate.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../plugins/components/toast-master/css/jquery.toast.css" rel="stylesheet">
        <link href="../css/colors/<?php if(isset($_COOKIE['theme'])) { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
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
                        <a class="logo" href="../index.php">
                            <img src="../plugins/images/<?php echo $cpicon; ?>" alt="home" class="logo-1 dark-logo" />
                            <img src="../plugins/images/<?php echo $cplogo; ?>" alt="home" class="hidden-xs dark-logo" />
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
                            <h4 class="page-title"><?php echo _("Manage Cron Jobs"); ?></h4>
                        </div>
                    </div>
                    <div class="row restwo">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center><?php echo _("CRON JOBS"); ?></center>
                                        </div>
                                        <div class="panel-body">
                                            <center><h2><?php print_r($admindata['U_CRON_JOBS']); ?></h2></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center><?php echo _("SUSPENDED"); ?></center>
                                        </div>
                                        <div class="panel-body">
                                            <center><h2><?php print_r($admindata['SUSPENDED_CRON']); ?></h2></center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <ul class="side-icon-text pull-right">
                                    <li><a href="../add/cron.php"><span class="circle circle-sm bg-success di" style="padding-top: 11px;"><i class="fa fa-plus"></i></span><span class="resthree"><wrapper class="restwo"><?php echo _("Add "); ?></wrapper><?php echo _("Cron Job"); ?></span></a></li>
                                    <?php if($admindata['CRON_REPORTS'] == "yes"){ echo '<li class="resthree"><a href="#" onclick="notifyOff()"><span class="circle circle-sm bg-danger di" style="padding-top: 11px;"><i class="fa fa-power-off"></i></span><span><wrapper class="restwo">' . _("Disable Cron ") . '</wrapper>' . _("Notifications") . '</span></a></li>';} if($admindata['CRON_REPORTS'] == "no"){ echo '<li class="resthree"><a href="#" onclick="notifyOn()"><span class="circle circle-sm bg-success di" style="padding-top: 11px;"><i class="fa fa-power-off"></i></span><span><wrapper class="restwo">' . _("Enable Cron ") . '</wrapper>' . _("Enable Cron Notifications") . '</span></a></li>';} ?>
                                </ul>
                                <h3 class="box-title m-b-0"><?php echo _("Cron Jobs"); ?></h3><br>
                                <div class="table-responsive">
                                <table class="table footable m-b-0" data-sorting="true">
                                    <thead>
                                        <tr>
                                            <th class="restwo" data-toggle="true" data-type="numeric"> <?php echo _("Job"); ?></th>
                                            <th> <?php echo _("Command"); ?> </th>
                                            <th class="resone"> <?php echo _("Status"); ?> </th>
                                            <th class="resone" data-type="date" data-format-string="YYYY-MM-DD" data-sorted="true" data-direction="DESC"> <?php echo _("Created"); ?> </th>
                                            <th data-sortable="false"> <?php echo _("Action"); ?> </th>
                                            <th data-breakpoints="all"> <?php echo _("Frequency"); ?> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if($cronname[0] != '') {
                                            $x1 = 0; 

                                            do {
                                                $c1 = $crondata[$x1]['MIN'];
                                                $c2 = $crondata[$x1]['HOUR'];
                                                $c3 = $crondata[$x1]['DAY'];
                                                $c4 = $crondata[$x1]['MONTH'];
                                                $c5 = $crondata[$x1]['WDAY'];
                                                $crontime = $c1 .' '.$c2 .' '.$c3 .' '.$c4 .' '.$c5;
                                                $schedule = CronSchedule::fromCronString($crontime);
                                                echo '<tr'; if($crondata[$x1]['SUSPENDED'] != 'no') { echo ' style="background: #efefef"'; } echo '>
                                                    <td class="restwo" data-sort-value="' . $cronname[$x1] . '">' . $cronname[$x1] . '</td>
                                                    <td>' . $crondata[$x1]['CMD'] . '</td>
                                                    <td class="resone">';                                                                   
                                                if($crondata[$x1]['SUSPENDED'] == "no"){ 
                                                    echo '<span class="label label-table label-success">' . _("Active") . '</span>';} 
                                                else{ 
                                                    echo '<span class="label label-table label-danger">' . _("Suspended") . '</span>';} 
                                                echo '</td>
                                                      <td class="resone" data-sort-value="' . $crondata[$x1]['DATE'] . '">' . $crondata[$x1]['DATE'] . '</td><td>
                                                          <a href="../edit/cron.php?job=' . $cronname[$x1] . '"><button type="button" data-toggle="tooltip" data-original-title="' . _("Edit") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="fa fa-cog"></i></button></a>';
                                                          if ($initialusername == "admin" && $crondata[$x1]['SUSPENDED'] == 'no') { echo '<button type="button" onclick="confirmSuspend(\'' . $cronname[$x1] . '\')" data-toggle="tooltip" data-original-title="' . _("Suspend") . '" class="restwo btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-lock"></i></button>'; }
                                                          elseif ($initialusername == "admin" && $crondata[$x1]['SUSPENDED'] == 'yes') { echo '<button type="button" onclick="confirmUnsuspend(\'' . $cronname[$x1] . '\')" data-toggle="tooltip" data-original-title="' . _("Unsuspend") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-unlock"></i></button>'; }   
                                                          echo '<button onclick="confirmDelete(\'' . $cronname[$x1] . '\')" type="button" data-toggle="tooltip" data-original-title="' . _("Delete") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="icon-trash"></i></button>
                                                      </td>
                                                      <td>'; echo $schedule->asNaturalLanguage() . ' ( ' . $crontime . ' )</td>                        
                                                    </tr>';
                                                $x1++;
                                            } while ($cronname[$x1] != ''); }
                                        ?>
                                    </tbody>
                                </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../includes/versioncheck.php'; ?> <?php echo _("by Carter Roeser"); ?>.</footer>
            </div>
        </div>
        <script src="../plugins/components/jquery/dist/jquery.min.js"></script>
        <script src="../plugins/components/toast-master/js/jquery.toast.js"></script>
        <script src="../bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../plugins/components/sidebar-nav/dist/sidebar-nav.min.js"></script>
        <script src="../js/jquery.slimscroll.js"></script>
        <script src="../js/waves.js"></script>
        <script src="../plugins/components/moment/moment.js"></script>
        <script src="../plugins/components/footable/js/footable.min.js"></script>
        <script src="../plugins/components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="../js/footable-init.js"></script>
        <script src="../js/custom.js"></script>
        <script src="../js/dashboard1.js"></script>
        <script src="../js/cbpFWTabs.js"></script>
        <script src="../plugins/components/styleswitcher/jQuery.style.switcher.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.js"></script>
        <script type="text/javascript">
            <?php 
            $pluginlocation = "../plugins/"; if(isset($pluginnames[0]) && $pluginnames[0] != '') { $currentplugin = 0; do { if (strtolower($pluginhide[$currentplugin]) != 'y' && strtolower($pluginhide[$currentplugin]) != 'yes') { if (strtolower($pluginadminonly[$currentplugin]) != 'y' && strtolower($pluginadminonly[$currentplugin]) != 'yes') { if (strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; } else { $currentstring = "<li><a href='".$pluginlocation.$pluginlinks[$currentplugin]."/'><i class='fa ".$pluginicons[$currentplugin]." fa-fw'></i><span class='hide-menu'>"._($pluginnames[$currentplugin])."</span></a></li>"; }} else { if(strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";} } else { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; }}} echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');\n var plugindata" . $currentplugin . " = \"" . $currentstring . "\";\n plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n"; } $currentplugin++; } while ($pluginnames[$currentplugin] != ''); } ?>

            (function () {
                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                    new CBPFWTabs(el);
                });
            })();

            jQuery(function($){
                $('.footable').footable();
            });

            function notifyOff(){
                swal({
                    title: '<?php echo _("Processing"); ?>',
                    text: '',
                    onOpen: function () {
                        swal.showLoading()
                    }
                }).then(

                    $.ajax({  
                        type: "POST",  
                        url: "../process/reportsoff.php",  
                        data: { 'verified':'yes' },      
                        success: function(data){
                            swal.close();
                            swal({title:'<?php echo _("Successfully Updated!"); ?>', type:'success', allowOutsideClick:false, allowEscapeKey:false, allowEnterKey:false});
                            swal.disableButtons();
                            setTimeout(function(){
                                window.location="cron.php";
                            }, 2000);


                        },
                        error: function(){
                            swal.close();
                            swal({title:'<?php echo _("Please try again later or contact support."); ?>', type:'error'});
                        }  
                    }),
                    function () {},
                    function (dismiss) {
                        if (dismiss === 'timer') {
                        }
                    }
                )}

            function notifyOn(){
                swal({
                    title: '<?php echo _("Processing"); ?>',
                    text: '',
                    onOpen: function () {
                        swal.showLoading()
                    }
                }).then(

                    $.ajax({  
                        type: "POST",  
                        url: "../process/reportson.php",  
                        data: { 'verified':'yes' },      
                        success: function(data){
                            swal.close();
                            swal({title:'<?php echo _("Successfully Updated!"); ?>', type:'success', allowOutsideClick:false, allowEscapeKey:false, allowEnterKey:false});
                            swal.disableButtons();
                            setTimeout(function(){
                                window.location="cron.php";
                            }, 2000);

                        },
                        error: function(){
                            swal.close();
                            swal({title:'<?php echo _("Please try again later or contact support."); ?>', type:'error'});
                        }  
                    }),
                    function () {},
                    function (dismiss) {
                        if (dismiss === 'timer') {
                        }
                    }
                )}


            function confirmDelete(e){
                e1 = String(e)
                swal({
                    title: '<?php echo _("Delete Cron Job"); ?>: ' + e1 +' ?',
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
                    window.location.replace("../delete/cron.php?job=" + e1);
                })}
            function confirmSuspend(f){
                f1 = String(f)
                swal({
                    title: '<?php echo _("Suspend Cron Job"); ?>: ' + f1 +' ?',
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
                    window.location.replace("../admin/suspend/cron.php?user=<?php echo $username; ?>&resource=" + f1);
                })}
            function confirmUnsuspend(f2){
                f2 = String(f2)
                swal({
                    title: '<?php echo _("Unsuspend Cron Job"); ?>: ' + f2 +' ?',
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
                    window.location.replace("../admin/unsuspend/cron.php?user=<?php echo $username; ?>&resource=" + f2);
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
            if(isset($_POST['delcode']) && $_POST['delcode'] > "0") { echo "swal({title:'" . $errorcode[$_POST['delcode']] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
                                                                    }
            if(isset($_POST['addcode']) && $_POST['addcode'] > "0") { echo "swal({title:'" . $errorcode[$_POST['addcode']] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
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