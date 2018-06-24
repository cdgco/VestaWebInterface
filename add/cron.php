<?php

session_start();
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

if(isset($cronenabled) && $cronenabled != 'true'){ header("Location: ../error-pages/403.html"); }

$postvars = array(
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'));

$curl0 = curl_init();
$curlstart = 0; 

while($curlstart <= 0) {
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
                        <!-- Logo -->
                        <a class="logo" href="../index.php">
                            <!-- Logo icon image, you can use font-icon also --><b>
                            <!--This is dark logo icon--><img src="../plugins/images/<?php echo $cpicon; ?>" alt="home" class="logo-1 dark-logo" /><!--This is light logo icon--><img src="../plugins/images/admin-logo-dark.png" alt="home" class="logo-1 light-logo" />
                            </b>
                            <!-- Logo text image you can use text also --><span class="hidden-xs">
                            <!--This is dark logo text--><img src="../plugins/images/<?php echo $cplogo; ?>" alt="home" class="hidden-xs dark-logo" /><!--This is light logo text--><img src="../plugins/images/admin-text-dark.png" alt="home" class="hidden-xs light-logo" />
                            </span> </a>
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
                              primaryMenu("../list/", "../process/", "cron");
                        ?>
                    </ul>
                </div>
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title"><?php echo _("Add Cron Job"); ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-horizontal form-material">
                            <div class="col-md-12 col-xs-12">
                                <div class="white-box">
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Command"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" form="vstobjects" name="v_cmd" class="form-control"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <form class="form-horizontal form-material" autocomplete="off" id="vstobjects" method="post" action="../create/cron.php">
                            <div class="col-md-8 col-xs-12">
                                <div class="white-box">
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Minute"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_min" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Hour"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_hour" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Day"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_day" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Month"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_month" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Day of Week"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_wday" class="form-control"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" onclick="processLoader();"><?php echo _("Add Cron"); ?></button> &nbsp;
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
                <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../includes/versioncheck.php'; ?> <?php echo _("by CDG Web Services"); ?>.</footer>
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
        <script src="../plugins/components/custom-select/custom-select.min.js"></script>
        <script src="../js/footable-init.js"></script>
        <script src="../js/custom.js"></script>
        <script src="../js/dashboard1.js"></script>
        <script src="../js/cbpFWTabs.js"></script>
        <script src="../plugins/components/styleswitcher/jQuery.style.switcher.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.js"></script>
        <script src="../plugins/components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript">
            <?php 
            
            includeScript();
            
            $pluginlocation = "../plugins/"; if(isset($pluginnames[0]) && $pluginnames[0] != '') { $currentplugin = 0; do { if (strtolower($pluginhide[$currentplugin]) != 'y' && strtolower($pluginhide[$currentplugin]) != 'yes') { if (strtolower($pluginadminonly[$currentplugin]) != 'y' && strtolower($pluginadminonly[$currentplugin]) != 'yes') { if (strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; } else { $currentstring = "<li><a href='".$pluginlocation.$pluginlinks[$currentplugin]."/'><i class='fa ".$pluginicons[$currentplugin]." fa-fw'></i><span class='hide-menu'>"._($pluginnames[$currentplugin])."</span></a></li>"; }} else { if(strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";} } else { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; }}} echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');\n var plugindata" . $currentplugin . " = \"" . $currentstring . "\";\n plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n"; } $currentplugin++; } while ($pluginnames[$currentplugin] != ''); } ?>
        </script>
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
            if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "swal({title:'" . $errorcode[1] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            } 
            ?>
        </script>
    </body>
</html>