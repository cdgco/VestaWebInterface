<?php

session_start();

if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); }  else { header( 'Location: ../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

$requestjob = $_GET['job'];

if (isset($requestjob) && $requestjob != '') {}
else { header('Location: ../list/mail.php'); }

$postvars = array(
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-cron-job','arg1' => $username,'arg2' => $requestjob, 'arg3' => 'json'));

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
$crondata = array_values(json_decode(curl_exec($curl1), true));
$cronname = array_keys(json_decode(curl_exec($curl1), true));
if ($cronname[0] == '') { header('Location: ../list/cron.php'); }
if(isset($admindata['LANGUAGE'])){ $locale = $ulang[$admindata['LANGUAGE']]; }
setlocale(LC_CTYPE, $locale); setlocale(LC_MESSAGES, $locale);
bindtextdomain('messages', '../locale');
textdomain('messages');
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" type="image/ico" href="../plugins/images/favicon.ico">
        <title><?php echo $sitetitle; ?> - <?php echo _("Cron Jobs"); ?></title>
        <link href="../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
        <link href="../plugins/bower_components/footable/css/footable.bootstrap.css" rel="stylesheet">
        <link href="../plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
        <link href="../css/animate.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
        <link href="../css/colors/<?php if(isset($_COOKIE['theme'])) { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.min.css" />
        <?php if(GOOGLE_ANALYTICS_ID != ''){ echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . GOOGLE_ANALYTICS_ID . "'></script>
        <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '" . GOOGLE_ANALYTICS_ID . "');</script>"; } ?> 
        <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    </head>

    <body class="fix-header">
        <!-- ============================================================== -->
        <!-- Preloader -->
        <!-- ============================================================== -->
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
            </svg>
        </div>
        <div id="wrapper">
            <nav class="navbar navbar-default navbar-static-top m-b-0">
                <div class="navbar-header">
                    <div class="top-left-part">
                        <!-- Logo -->
                        <a class="logo" href="../index.php">
                            <!-- Logo icon image, you can use font-icon also --><b>
                            <!--This is dark logo icon--><img src="../plugins/images/admin-logo.png" alt="home" class="logo-1 dark-logo" /><!--This is light logo icon--><img src="../plugins/images/admin-logo-dark.png" alt="home" class="logo-1 light-logo" />
                            </b>
                            <!-- Logo text image you can use text also --><span class="hidden-xs">
                            <!--This is dark logo text--><img src="../plugins/images/admin-text.png" alt="home" class="hidden-xs dark-logo" /><!--This is light logo text--><img src="../plugins/images/admin-text-dark.png" alt="home" class="hidden-xs light-logo" />
                            </span> </a>
                    </div>
                    <!-- /Logo -->
                    <!-- Search input and Toggle icon -->
                    <ul class="nav navbar-top-links navbar-left">
                        <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>      
                    </ul>
                    <ul class="nav navbar-top-links navbar-right pull-right">

                        <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"><b class="hidden-xs"><?php print_r($uname); ?></b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-text">
                                        <h4><?php print_r($uname); ?></h4>
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
                            <li> 
                                <a href="../index.php" class="waves-effect">
                                    <i class="mdi mdi-home fa-fw"></i> <span class="hide-menu"><?php echo _("Dashboard"); ?></span>
                                </a> 
                            </li>

                            <li class="devider"></li>
                            <li>
                                <a href="#" class="waves-effect"><i  class="ti-user fa-fw"></i><span class="hide-menu"> <?php print_r($uname); ?><span class="fa arrow"></span></span>
                                </a>
                                <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                                    <li> <a href="../profile.php"><i class="ti-home fa-fw"></i> <span class="hide-menu"> <?php echo _("My Account"); ?></span></a></li>
                                    <li> <a href="../profile.php?settings=open"><i class="ti-settings fa-fw"></i> <span class="hide-menu"> <?php echo _("Acount Settings"); ?></span></a></li>
                                </ul>
                            </li>
                        <?php if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '<li class="devider"></li>
                            <li> <a href="#" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">'. _("Management") . '<span class="fa arrow"></span> </span></a>
                                <ul class="nav nav-second-level">'; } ?>
                        <?php if ($webenabled == 'true') { echo '<li> <a href="../list/web.php"><i class="ti-world fa-fw"></i><span class="hide-menu">' . _("Web") . '</span></a> </li>'; } ?>
                        <?php if ($dnsenabled == 'true') { echo '<li> <a href="../list/dns.php"><i class="fa fa-sitemap fa-fw"></i><span class="hide-menu">' . _("DNS") . '</span></a> </li>'; } ?>
                        <?php if ($mailenabled == 'true') { echo '<li> <a href="../list/mail.php"><i class="fa fa-envelope fa-fw"></i><span class="hide-menu">' . _("Mail") . '</span></a> </li>'; } ?>
                        <?php if ($dbenabled == 'true') { echo '<li> <a href="../list/db.php"><i class="fa fa-database fa-fw"></i><span class="hide-menu">' . _("Database") . '</span></a> </li>'; } ?>
                        <?php if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '</ul>
                            </li>'; } ?>
                        <li> <a href="../list/cron.php" class="waves-effect active"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu"><?php echo _("Cron Jobs"); ?></span></a> </li>
                        <li> <a href="../list/backups.php" class="waves-effect"><i  class="fa fa-cloud-upload fa-fw"></i> <span class="hide-menu"><?php echo _("Backups"); ?></span></a> </li>
                        <?php if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {} else { echo '<li class="devider"></li>
                            <li><a href="#" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">' . _("Apps") . '<span class="fa arrow"></span></span></a>
                                <ul class="nav nav-second-level">'; } ?>
                        <?php if ($ftpurl != '') { echo '<li><a href="' . $ftpurl . '" target="_blank"><i class="fa fa-file-code-o fa-fw"></i><span class="hide-menu">' . _("FTP") . '</span></a></li>';} ?>
                        <?php if ($webmailurl != '') { echo '<li><a href="' . $webmailurl . '" target="_blank"><i class="fa fa-envelope-o fa-fw"></i><span class="hide-menu">' . _("Webmail") . '</span></a></li>';} ?>
                        <?php if ($phpmyadmin != '') { echo '<li><a href="' . $phpmyadmin . '" target="_blank"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">' . _("phpMyAdmin") . '</span></a></li>';} ?>
                        <?php if ($phppgadmin != '') { echo '<li><a href="' . $phppgadmin . '" target="_blank"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">' . _("phpPgAdmin") . '</span></a></li>';} ?>
                        <?php if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {} else { echo '</ul></li>';} ?>
                        <li class="devider"></li>
                        <li><a href="../process/logout.php" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu"><?php echo _("Log out"); ?></span></a></li>
                        <?php if ($oldcpurl == '' || $supporturl == '') {} else { echo '<li class="devider"></li>'; } ?>
                        <?php if ($oldcpurl != '') { echo '<li><a href="' . $oldcpurl . '" class="waves-effect"> <i class="fa fa-tachometer fa-fw"></i> <span class="hide-menu"> ' . _("Control Panel v1") . '</span></a></li>'; } ?>
                        <?php if ($supporturl != '') { echo '<li><a href="' . $supporturl . '" class="waves-effect" target="_blank"> <i class="fa fa-life-ring fa-fw"></i> <span class="hide-menu">' . _("Support") . '</span></a></li>'; } ?>
                        </ul>
                </div>
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title"><?php echo _("Edit Cron Job"); ?></h4>
                        </div>
                           <ul class="side-icon-text pull-right">
                            <li style="position: relative;top: -3px;">
                                <a onclick="confirmDelete();" style="cursor: pointer;"><span class="circle circle-sm bg-danger di"><i class="ti-trash"></i></span><span><?php echo _("Delete Cron Job"); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center><?php echo _("CREATED"); ?></center>
                                        </div>
                                        <div class="panel-body">
                                            <center>
                                                <h2>
                                                    <?php $date=date_create($crondata[0]['DATE'] . ' ' . $crondata[0]['TIME']); echo date_format($date,"F j, Y - g:i A"); ?>
                                                </h2>
                                            </center>
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
                                            <center><?php echo _("STATUS"); ?></center>
                                        </div>
                                        <div class="panel-body">
                                            <center>
                                                <h2>
                                                    <?php if ($crondata[0]['SUSPENDED'] == 'no') {echo 'Active';} else {echo 'Suspended';}?>
                                                </h2>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-horizontal form-material">
                            <div class="col-md-12 col-xs-12">
                                <div class="white-box">
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Command"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" form="vstobjects" name="v_cmd" value="<?php echo $crondata[0]['CMD']; ?>" class="form-control"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <form class="form-horizontal form-material" autocomplete="off" id="vstobjects" method="post" action="../change/cron.php">
                            <input type="hidden" name="v_job" value="<?php echo $requestjob; ?>"> 
                            <div class="col-md-8 col-xs-12">
                                <div class="white-box">
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Minute"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_min" value="<?php echo $crondata[0]['MIN']; ?>" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Hour"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_hour" value="<?php echo $crondata[0]['HOUR']; ?>" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Day"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_day" value="<?php echo $crondata[0]['DAY']; ?>" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Month"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_month" value="<?php echo $crondata[0]['MONTH']; ?>" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Day of Week"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_wday" value="<?php echo $crondata[0]['WDAY']; ?>" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" onclick="processLoader();"><?php echo _("Update Cron"); ?></button> &nbsp;
                                            <a href="../list/cron.php" style="color: inherit;text-decoration: inherit;"><button class="btn btn-muted" type="button"><?php echo _("Back"); ?></button></a>
                                        </div>
                                    </div>
                                </div>
                            </div> </form>
                        <div class="col-lg-4 col-xs-12">
                            <div class="white-box">
                                <div> 
                                    <center>
                                        <h3>
                                            <?php echo _("Cron Generator"); ?>
                                        </h3>
                                    </center><br>
                                    <div class="overlay-box" style="background: #fff;">
                                        <ul class="nav nav-tabs">
                                            <li class="active"><a  href="#1" data-toggle="tab"><?php echo _("Minutes"); ?></a>
                                            </li>
                                            <li><a href="#2" data-toggle="tab"><?php echo _("Hourly"); ?></a>
                                            </li>
                                            <li><a href="#3" data-toggle="tab"><?php echo _("Daily"); ?></a>
                                            </li>
                                            <li><a href="#4" data-toggle="tab"><?php echo _("Weekly"); ?></a>
                                            </li>
                                            <li><a href="#5" data-toggle="tab"><?php echo _("Monthly"); ?></a>
                                            </li>
                                        </ul>
                                        <div class="tab-content  generator">
                                            <div class="tab-pane active" id="1">
                                                <form class="form-horizontal form-material" autocomplete="off" action="javascript:void(0);">
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo _("Run Command"); ?></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control" name="h_min" >
                                                                <option value="*" selected="selected"><?php echo _("every minute"); ?></option>
                                                                <option value="*/2"><?php echo _("every two minutes"); ?></option>
                                                                <option value="*/5"><?php echo _("every"); ?> 5</option>
                                                                <option value="*/10"><?php echo _("every"); ?> 10</option>
                                                                <option value="*/15"><?php echo _("every"); ?> 15</option>
                                                                <option value="*/30"><?php echo _("every"); ?> 30</option>
                                                            </select>
                                                    <input type="hidden" name="h_hour" value="*">
                                                    <input type="hidden" name="h_day" value="*">
                                                    <input type="hidden" name="h_month" value="*">
                                                    <input type="hidden" name="h_wday" value="*">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-success"><?php echo _("Generate"); ?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="2">
                                                <form class="form-horizontal form-material" autocomplete="off" action="javascript:void(0);">
                                                    <input type="hidden" name="h_day" value="*">
                                                    <input type="hidden" name="h_month" value="*">
                                                    <input type="hidden" name="h_wday" value="*">
                                                    <div class="form-group">
                                                        <label class="col-md-12">Run Command</label>
                                                        <div class="col-md-12">
                                                            <select class="form-control" name="h_hour">
                                                                <option value="*" selected="selected"><?php echo _("every hour"); ?></option>
                                                                <option value="*/2"><?php echo _("every two hours"); ?></option>
                                                                <option value="*/6"><?php echo _("every"); ?> 6</option>
                                                                <option value="*/12"><?php echo _("every"); ?> 12</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo _("Minute"); ?></label>
                                                    <div class="col-md-12">
                                                        <select class="form-control" name="h_min">
                                                            <option value="0" selected="selected">00</option>
                                                            <option value="15">15</option>
                                                            <option value="30">30</option>
                                                            <option value="45">45</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <button class="btn btn-success"><?php echo _("Generate"); ?></button>
                                                    </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="3">
                                                <form class="form-horizontal form-material" autocomplete="off" action="javascript:void(0);">
                                                    <input type="hidden" name="h_month" value="*">
                                                    <input type="hidden" name="h_wday" value="*">
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo _("Run Command"); ?></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control" name="h_day">
                                                                <option value="*" selected="selected"><?php echo _("every day"); ?></option>
                                                                <option value="1-31/2"><?php echo _("every odd day"); ?></option>
                                                                <option value="*/2"><?php echo _("every even day"); ?></option>
                                                                <option value="*/3"><?php echo _("every"); ?> 3</option>
                                                                <option value="*/5"><?php echo _("every"); ?> 5</option>
                                                                <option value="*/10"><?php echo _("every"); ?> 10</option>
                                                                <option value="*/15"><?php echo _("every"); ?> 15</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-6 pull-left"<?php echo _("Hour"); ?></label><label class="col-sm-6 pull-right"><?php echo _("Minute"); ?></label>
                                                        <div class="col-sm-6 pull-left">
                                                            <select class="form-control" name="h_hour">
                                                                <option value="0">00</option>
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="3">03</option>
                                                                <option value="4">04</option>
                                                                <option value="5">05</option>
                                                                <option value="6">06</option>
                                                                <option value="7">07</option>
                                                                <option value="8">08</option>
                                                                <option value="9">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12" selected="selected">12</option>
                                                                <option value="13">13</option>
                                                                <option value="14">14</option>
                                                                <option value="15">15</option>
                                                                <option value="16">16</option>
                                                                <option value="17">17</option>
                                                                <option value="18">18</option>
                                                                <option value="19">19</option>
                                                                <option value="20">20</option>
                                                                <option value="21">21</option>
                                                                <option value="22">22</option>
                                                                <option value="23">23</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6 pull-right">
                                                            <select class="form-control" name="h_min">
                                                                <option value="0" selected="selected">00</option>
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="5">05</option>
                                                                <option value="10">10</option>
                                                                <option value="15">15</option>
                                                                <option value="20">20</option>
                                                                <option value="25">25</option>
                                                                <option value="30">30</option>
                                                                <option value="35">35</option>
                                                                <option value="40">40</option>
                                                                <option value="45">45</option>
                                                                <option value="50">50</option>
                                                                <option value="55">55</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-success"><?php echo _("Generate"); ?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="4">
                                                <form class="form-horizontal form-material" autocomplete="off" action="javascript:void(0);">
                                                    <input type="hidden" name="h_month" value="*">
                                                    <input type="hidden" name="h_day" value="*">
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo _("Run Command"); ?></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control" name="h_wday">
                                                                <option value="*" selected="selected"><?php echo _("every day"); ?></option>
                                                                <option value="1,2,3,4,5"><?php echo _("weekdays (5 days)"); ?></option>
                                                                <option value="0,6"><?php echo _("weekend (2 days)"); ?></option>
                                                                <option value="1"><?php echo _("Monday"); ?></option>
                                                                <option value="2"><?php echo _("Tuesday"); ?></option>
                                                                <option value="3"><?php echo _("Wednesday"); ?></option>
                                                                <option value="4"><?php echo _("Thursday"); ?></option>
                                                                <option value="5"><?php echo _("Friday"); ?></option>
                                                                <option value="6"><?php echo _("Saturday"); ?></option>
                                                                <option value="0"><?php echo _("Sunday"); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <div class="form-group">
                                                    <label class="col-sm-6 pull-left"><?php echo _("Hour"); ?></label><label class="col-sm-6 pull-right"><?php echo _("Minute"); ?></label>
                                                    <div class="col-sm-6 pull-left">
                                                        <select class="form-control" name="h_hour">
                                                            <option value="0">00</option>
                                                            <option value="1">01</option>
                                                            <option value="2">02</option>
                                                            <option value="3">03</option>
                                                            <option value="4">04</option>
                                                            <option value="5">05</option>
                                                            <option value="6">06</option>
                                                            <option value="7">07</option>
                                                            <option value="8">08</option>
                                                            <option value="9">09</option>
                                                            <option value="10">10</option>
                                                            <option value="11">11</option>
                                                            <option value="12" selected="selected">12</option>
                                                            <option value="13">13</option>
                                                            <option value="14">14</option>
                                                            <option value="15">15</option>
                                                            <option value="16">16</option>
                                                            <option value="17">17</option>
                                                            <option value="18">18</option>
                                                            <option value="19">19</option>
                                                            <option value="20">20</option>
                                                            <option value="21">21</option>
                                                            <option value="22">22</option>
                                                            <option value="23">23</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 pull-right">
                                                        <select class="form-control" name="h_min">
                                                            <option value="0" selected="selected">00</option>
                                                            <option value="1">01</option>
                                                            <option value="2">02</option>
                                                            <option value="5">05</option>
                                                            <option value="10">10</option>
                                                            <option value="15">15</option>
                                                            <option value="20">20</option>
                                                            <option value="25">25</option>
                                                            <option value="30">30</option>
                                                            <option value="35">35</option>
                                                            <option value="40">40</option>
                                                            <option value="45">45</option>
                                                            <option value="50">50</option>
                                                            <option value="55">55</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12">
                                                        <button class="btn btn-success"><?php echo _("Generate"); ?></button>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="5">
                                                <form class="form-horizontal form-material" autocomplete="off" action="javascript:void(0);">
                                                    <input type="hidden" name="h_wday" value="*">
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo _("Run Command"); ?></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control" name="h_month">
                                                                <option value="*" selected="selected"><?php echo _("every month"); ?></option>
                                                                <option value="1-11/2"><?php echo _("every odd month"); ?></option>
                                                                <option value="*/2"><?php echo _("every even month"); ?></option>
                                                                <option value="*/3"><?php echo _("every"); ?> 3</option>
                                                                <option value="*/6"><?php echo _("every"); ?> 6</option>
                                                                <option value="1"><?php echo _("January"); ?></option>
                                                                <option value="2"><?php echo _("February"); ?></option>
                                                                <option value="3"><?php echo _("March"); ?></option>
                                                                <option value="4"><?php echo _("April"); ?></option>
                                                                <option value="5"><?php echo _("May"); ?></option>
                                                                <option value="6"><?php echo _("June"); ?></option>
                                                                <option value="7"><?php echo _("July"); ?></option>
                                                                <option value="8"><?php echo _("August"); ?></option>
                                                                <option value="9"><?php echo _("September"); ?></option>
                                                                <option value="10"><?php echo _("October"); ?></option>
                                                                <option value="11"><?php echo _("November"); ?></option>
                                                                <option value="12"><?php echo _("December"); ?></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-12"><?php echo _("Date"); ?></label>
                                                        <div class="col-md-12">
                                                            <select class="form-control" name="h_day">
                                                                <option value="1" selected="selected">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                                <option value="6">6</option>
                                                                <option value="7">7</option>
                                                                <option value="8">8</option>
                                                                <option value="9">9</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12">12</option>
                                                                <option value="13">13</option>
                                                                <option value="14">14</option>
                                                                <option value="15">15</option>
                                                                <option value="16">16</option>
                                                                <option value="17">17</option>
                                                                <option value="18">18</option>
                                                                <option value="19">19</option>
                                                                <option value="20">20</option>
                                                                <option value="21">21</option>
                                                                <option value="22">22</option>
                                                                <option value="23">23</option>
                                                                <option value="24">24</option>
                                                                <option value="25">25</option>
                                                                <option value="26">26</option>
                                                                <option value="27">27</option>
                                                                <option value="28">28</option>
                                                                <option value="29">29</option>
                                                                <option value="30">30</option>
                                                                <option value="31">31</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-6 pull-left"><?php echo _("Hour"); ?></label><label class="col-sm-6 pull-right"><?php echo _("Minute"); ?></label>
                                                        <div class="col-sm-6 pull-left">
                                                            <select class="form-control" name="h_hour">
                                                                <option value="0">00</option>
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="3">03</option>
                                                                <option value="4">04</option>
                                                                <option value="5">05</option>
                                                                <option value="6">06</option>
                                                                <option value="7">07</option>
                                                                <option value="8">08</option>
                                                                <option value="9">09</option>
                                                                <option value="10">10</option>
                                                                <option value="11">11</option>
                                                                <option value="12" selected="selected">12</option>
                                                                <option value="13">13</option>
                                                                <option value="14">14</option>
                                                                <option value="15">15</option>
                                                                <option value="16">16</option>
                                                                <option value="17">17</option>
                                                                <option value="18">18</option>
                                                                <option value="19">19</option>
                                                                <option value="20">20</option>
                                                                <option value="21">21</option>
                                                                <option value="22">22</option>
                                                                <option value="23">23</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6 pull-right">
                                                            <select class="form-control" name="h_min">
                                                                <option value="0" selected="selected">00</option>
                                                                <option value="1">01</option>
                                                                <option value="2">02</option>
                                                                <option value="5">05</option>
                                                                <option value="10">10</option>
                                                                <option value="15">15</option>
                                                                <option value="20">20</option>
                                                                <option value="25">25</option>
                                                                <option value="30">30</option>
                                                                <option value="35">35</option>
                                                                <option value="40">40</option>
                                                                <option value="45">45</option>
                                                                <option value="50">50</option>
                                                                <option value="55">55</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <button class="btn btn-success"><?php echo _("Generate"); ?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer text-center">&copy; <?php echo _("Copyright"); ?> <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("All Rights Reserved. Vesta Web Interface"); ?> <?php require '../includes/versioncheck.php'; ?> <?php echo _("by CDG Web Services"); ?>.</footer>
            </div>
        </div>
        <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../plugins/bower_components/toast-master/js/jquery.toast.js"></script>
        <script src="../bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
        <script src="../js/jquery.slimscroll.js"></script>
        <script src="../js/waves.js"></script>
        <script src="../plugins/bower_components/moment/moment.js"></script>
        <script src="../plugins/bower_components/footable/js/footable.min.js"></script>
        <script src="../plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
        <script src="../plugins/bower_components/custom-select/custom-select.min.js"></script>
        <script src="../js/footable-init.js"></script>
        <script src="../js/custom.js"></script>
        <script src="../js/dashboard1.js"></script>
        <script src="../js/cbpFWTabs.js"></script>
        <script src="../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.js"></script>
        <script src="../plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript">
            $('.generator form').submit(function(){
                $('#vstobjects input[name=v_min]').val($(this).find(':input[name=h_min]').val());
                $('#vstobjects input[name=v_hour]').val($(this).find(':input[name=h_hour]').val());
                $('#vstobjects input[name=v_day]').val($(this).find(':input[name=h_day]').val());
                $('#vstobjects input[name=v_month]').val($(this).find(':input[name=h_month]').val());
                $('#vstobjects input[name=v_wday]').val($(this).find(':input[name=h_wday]').val());

                return false;
            });
            jQuery(function($){
                $('.footable').footable();
            });
            function confirmDelete(){
            swal({
              title: '<?php echo _("Delete Cron Job"); ?>:<br> #<?php echo $requestjob; ?>' + ' ?',
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
              timer: 5000,
              onOpen: function () {
                swal.showLoading()
              }
            }).then(
              function () {},
              function (dismiss) {}
            )
            window.location.replace("../delete/cron.php?job=<?php echo $requestjob; ?>");
        })}
            function processLoader(){
            swal({
              title: '<?php echo _("Processing"); ?>',
              text: '',
              timer: 5000,
              onOpen: function () {
                swal.showLoading()
              }
            })};
            
            <?php

            if(isset($_POST['returncode']) && $_POST['returncode'] == "0") {
                echo "swal({title:'" . _("Successfully Updated!") . "', type:'success'});";
            } 
            if(isset($_POST['returncode']) && $_POST['returncode'] > "0") { echo "swal({title:'" . $errorcode[$_POST['returncode']] . "<br><br>" . _("Please try again later or contact support.") . "', type:'error'});";
            }
    
?>
        </script>
    </body>

</html>