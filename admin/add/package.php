<?php

session_start();

    if (file_exists( '../../includes/config.php' )) { require( '../../includes/config.php'); }  else { header( 'Location: ../../install' );};

    if(base64_decode($_SESSION['loggedin']) == 'true') {}
      else { header('Location: ../../login.php'); }
    if($username != 'admin') { header("Location: ../../"); }

    $postvars = array(
      array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
      array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-templates','arg1' => 'json'),
      array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-templates-proxy','arg1' => 'json'),
      array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-dns-templates','arg1' => 'json'),
    );

    $curl0 = curl_init();
    $curl1 = curl_init();
    $curl2 = curl_init();
    $curl3 = curl_init();
    $curlstart = 0; 


    while($curlstart <= 3) {
        curl_setopt(${'curl' . $curlstart}, CURLOPT_URL, $vst_url);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_RETURNTRANSFER,true);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_POST, true);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
        $curlstart++;
    } 

    $admindata = json_decode(curl_exec($curl0), true)[$username];
    $webtemplates = array_values(json_decode(curl_exec($curl1), true));
    $proxytemplates = array_values(json_decode(curl_exec($curl2), true));
    $dnstemplates = array_values(json_decode(curl_exec($curl3), true));
    $useremail = $admindata['CONTACT'];
    if(isset($admindata['LANGUAGE'])){ $locale = $ulang[$admindata['LANGUAGE']]; }
    setlocale(LC_CTYPE, $locale); setlocale(LC_MESSAGES, $locale);
    bindtextdomain('messages', '../../locale');
    textdomain('messages');

    foreach ($plugins as $result) {
        if (file_exists('../../plugins/' . $result)) {
            if (file_exists('../../plugins/' . $result . '/manifest.xml')) {
                $get = file_get_contents('../../plugins/' . $result . '/manifest.xml');
                $xml   = simplexml_load_string($get, 'SimpleXMLElement', LIBXML_NOCDATA);
                $arr = json_decode(json_encode((array)$xml), TRUE);
                if (isset($arr['name']) && !empty($arr['name']) && isset($arr['fa-icon']) && !empty($arr['fa-icon']) && isset($arr['section']) && !empty($arr['section']) && isset($arr['admin-only']) && !empty($arr['admin-only'])){
                    array_push($pluginlinks,$result);
                    array_push($pluginnames,$arr['name']);
                    array_push($pluginicons,$arr['fa-icon']);
                    array_push($pluginsections,$arr['section']);
                    array_push($pluginadminonly,$arr['admin-only']);
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
    <link rel="icon" type="image/ico" href="../../plugins/images/favicon.ico">
    <title><?php echo $sitetitle; ?> - <?php echo _("Packages"); ?></title>
    <link href="../../bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <link href="../../plugins/bower_components/footable/css/footable.bootstrap.css" rel="stylesheet">
    <link href="../../plugins/bower_components/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
    <link href="../../plugins/bower_components/custom-select/custom-select.css" rel="stylesheet">
    <link href="../../css/animate.css" rel="stylesheet">
    <link href="../../css/style.css" rel="stylesheet">
    <link href="../../plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="../../css/colors/<?php if(isset($_COOKIE['theme'])) { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
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
                    <a class="logo" href="../../index.php">
                        <!-- Logo icon image, you can use font-icon also --><b>
                        <!--This is dark logo icon--><img src="../../plugins/images/admin-logo.png" alt="home" class="logo-1 dark-logo" /><!--This is light logo icon--><img src="../../plugins/images/admin-logo-dark.png" alt="home" class="logo-1 light-logo" />
                     </b>
                        <!-- Logo text image you can use text also --><span class="hidden-xs">
                        <!--This is dark logo text--><img src="../../plugins/images/admin-text.png" alt="home" class="hidden-xs dark-logo" /><!--This is light logo text--><img src="../../plugins/images/admin-text-dark.png" alt="home" class="hidden-xs light-logo" />
                     </span> </a>
                </div>
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
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
                            <li> 
                                <a href="../index.php" class=" waves-effect">
                                    <i class="mdi mdi-home fa-fw"></i> <span class="hide-menu"><?php echo _("Home"); ?></span>
                                </a> 
                            </li>
                            <li class="devider"></li>
                            <li> <a active href="../#" class="active waves-effect"><i class="mdi mdi-wrench fa-fw" data-icon="v"></i> <span class="hide-menu"><?php echo _("Administration"); ?><span class="fa arrow"></span> </span></a>
                                <ul class="nav nav-second-level in active">
                                    <li> <a href="../list/users.php"><i class="ti-user fa-fw"></i><span class="hide-menu"><?php echo _("Users"); ?></span></a> </li>
                                    <li class="active"> <a href="../list/packages.php" class="active"><i class="ti-package fa-fw"></i><span class="hide-menu"><?php echo _("Packages"); ?></span></a> </li>
                                    <li> <a href="../list/ip.php"><i class="fa fa-sliders fa-fw"></i><span class="hide-menu"><?php echo _("IP"); ?></span></a> </li>
                                    <li> <a href="../list/graphs.php"><i class="ti-pie-chart fa-fw"></i><span class="hide-menu"><?php echo _("Graphs"); ?></span></a> </li>
                                    <li> <a href="../list/stats.php"><i class="ti-stats-up fa-fw"></i><span class="hide-menu"><?php echo _("Statistics"); ?></span></a> </li>
                                    <li> <a href="../list/updates.php"><i class="mdi mdi-weather-cloudy fa-fw"></i><span class="hide-menu"><?php echo _("Updates"); ?></span></a> </li>
                                    <li> <a href="../list/firewall.php"><i class="fa fa-shield fa-fw"></i><span class="hide-menu"><?php echo _("Firewall"); ?></span></a> </li>
                                    <li> <a href="../list/server.php"><i class="fa fa-server fa-fw"></i><span class="hide-menu"><?php echo _("Server"); ?></span></a> </li>
                                </ul>
                            </li>
                            <li class="devider"></li>
                            <li>
                                <a href="../../#" class="waves-effect"><i  class="mdi mdi-account fa-fw"></i><span class="hide-menu"> <?php print_r($displayname); ?><span class="fa arrow"></span></span>
                                </a>
                                <ul class="nav nav-second-level collapse" id="appendaccount" aria-expanded="false" style="height: 0px;">
                                    <li> <a href="../../profile.php"><i class="ti-home fa-fw"></i> <span class="hide-menu"> <?php echo _("My Account"); ?></span></a></li>
                                    <li> <a href="../../profile.php?settings=open"><i class="ti-settings fa-fw"></i> <span class="hide-menu"> <?php echo _("Account Settings"); ?></span></a></li>
                                    <li> <a href="../../log.php"><i class="ti-layout-list-post fa-fw"></i><span class="hide-menu"><?php echo _("Log"); ?></span></a> </li>
                                </ul>
                            </li>
                        <?php if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '<li class="devider"></li>
                            <li> <a href="../../#" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">' . _("Management") . '<span class="fa arrow"></span> </span></a>
                                <ul class="nav nav-second-level" id="appendmanagement">'; } ?>
                        <?php if ($webenabled == 'true') { echo '<li> <a href="../../list/web.php"><i class="ti-world fa-fw"></i><span class="hide-menu">' . _("Web") . '</span></a> </li>'; } ?>
                        <?php if ($dnsenabled == 'true') { echo '<li> <a href="../../list/dns.php"><i class="fa fa-sitemap fa-fw"></i><span class="hide-menu">' . _("DNS") . '</span></a> </li>'; } ?>
                        <?php if ($mailenabled == 'true') { echo '<li> <a href="../../list/mail.php"><i class="fa fa-envelope fa-fw"></i><span class="hide-menu">' . _("Mail") . '</span></a> </li>'; } ?>
                        <?php if ($dbenabled == 'true') { echo '<li> <a href="../../list/db.php"><i class="fa fa-database fa-fw"></i><span class="hide-menu">' . _("Database") . '</span></a> </li>'; } ?>
                        <?php if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '</ul>
                            </li>'; } ?>
                        <li> <a href="../../list/cron.php" class="waves-effect"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu"><?php echo _("Cron Jobs"); ?></span></a> </li>
                        <li> <a href="../../list/backups.php" class="waves-effect"><i  class="fa fa-cloud-upload fa-fw"></i> <span class="hide-menu"><?php echo _("Backups"); ?></span></a> </li>
                        <?php if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {} else { echo '<li class="devider"></li>
                            <li><a href="../../#" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">' . _("Apps") . '<span class="fa arrow"></span></span></a>
                                <ul class="nav nav-second-level" id="appendapps">'; } ?>
                        <?php if ($ftpurl != '') { echo '<li><a href="../' . $ftpurl . '" target="_blank"><i class="fa fa-file-code-o fa-fw"></i><span class="hide-menu">' . _("FTP") . '</span></a></li>';} ?>
                        <?php if ($webmailurl != '') { echo '<li><a href="../../' . $webmailurl . '" target="_blank"><i class="fa fa-envelope-o fa-fw"></i><span class="hide-menu">' . _("Webmail") . '</span></a></li>';} ?>
                        <?php if ($phpmyadmin != '') { echo '<li><a href="../../' . $phpmyadmin . '" target="_blank"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">' . _("phpMyAdmin") . '</span></a></li>';} ?>
                        <?php if ($phppgadmin != '') { echo '<li><a href="../../' . $phppgadmin . '" target="_blank"><i class="fa fa-edit fa-fw"></i><span class="hide-menu">' . _("phpPgAdmin") . '</span></a></li>';} ?>
                        <?php if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {} else { echo '</ul></li>';} ?>
                        <li class="devider"></li>
                        <li><a href="../../process/logout.php" class="waves-effect"><i class="mdi mdi-logout fa-fw"></i> <span class="hide-menu"><?php echo _("Log out"); ?></span></a></li>
                        <?php if ($oldcpurl == '' || $supporturl == '') {} else { echo '<li class="devider"></li>'; } ?>
                        <?php if ($oldcpurl != '') { echo '<li><a href="../../' . $oldcpurl . '" class="waves-effect"> <i class="fa fa-tachometer fa-fw"></i> <span class="hide-menu"> ' . _("Control Panel v1") . '</span></a></li>'; } ?>
                        <?php if ($supporturl != '') { echo '<li><a href="../../' . $supporturl . '" class="waves-effect" target="_blank"> <i class="fa fa-life-ring fa-fw"></i> <span class="hide-menu">' . _("Support") . '</span></a></li>'; } ?>
            </div>
        </div>
        <div id="page-wrapper">
           <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"><?php echo _("Add Package"); ?></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="white-box">
                            <form class="form-horizontal form-material" autocomplete="off" method="post" action="../create/package.php">
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("Package Name"); ?></label>
                                    <div class="col-md-12">
                                        <input type="text" value="<?php print_r($packname[0]); ?>" name="v_package-name" class="form-control  form-control-line"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("Web Template"); ?></label>
                                    <div class="col-md-12">
                                        <select class="form-control select3" name="v_webtpl" id="select3">
                                            <?php
                                            if($webtemplates[0] != '') {
                                                $x2 = 0; 

                                                do {
                                                    echo '<option value="' . $webtemplates[$x2] . '">' . $webtemplates[$x2] . '</option>';
                                                    $x2++;
                                                } while ($webtemplates[$x2] != ''); }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("Proxy Template"); ?></label>
                                    <div class="col-md-12">
                                        <select class="form-control select4" name="v_prxtpl" id="select4">
                                            <?php
                                            if($proxytemplates[0] != '') {
                                                $x3 = 0; 

                                                do {
                                                    echo '<option value="' . $proxytemplates[$x3] . '">' . $proxytemplates[$x3] . '</option>';
                                                    $x3++;
                                                } while ($proxytemplates[$x3] != ''); }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("DNS Template"); ?></label>
                                    <div class="col-md-12">
                                        <select class="form-control select5" name="v_dnstpl" id="select5">
                                            <?php
                                            if($dnstemplates[0] != '') {
                                                $x4 = 0; 

                                                do {
                                                    echo '<option value="' . $dnstemplates[$x4] . '">' . $dnstemplates[$x4] . '</option>';
                                                    $x4++;
                                                } while ($dnstemplates[$x4] != ''); }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("Web Domains"); ?></label>
                                    <div class="col-md-12 input-group" style="padding-left: 15px;">
                                        <input type="text" class="form-control form-control-line" value="1" name="v_web-domains" id="ul1">
                                        <span class="input-group-btn"> 
                                            <button class="btn btn-outline-secondary" style="margin-right: 15px;" onclick="if(document.getElementById('ul1').value == 'unlimited') { document.getElementById('ul1').value = '1';} else { document.getElementById('ul1').value = 'unlimited';}" type="button">
                                                <i class="ti-infinite"></i>
                                            </button> 
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("Web Aliases"); ?></label>
                                    <div class="col-md-12 input-group" style="padding-left: 15px;">
                                        <input type="text" class="form-control form-control-line" value="1" name="v_web-aliases" id="ul2">
                                        <span class="input-group-btn"> 
                                            <button class="btn btn-outline-secondary" style="margin-right: 15px;" onclick="if(document.getElementById('ul2').value == 'unlimited') { document.getElementById('ul2').value = '1';} else { document.getElementById('ul2').value = 'unlimited';}" type="button">
                                                <i class="ti-infinite"></i>
                                            </button> 
                                        </span>
                                    </div>
                                </div>
                                <small class="form-text text-muted" style="top: -20px;position: relative;">Per Domain</small>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("DNS Domains"); ?></label>
                                    <div class="col-md-12 input-group" style="padding-left: 15px;">
                                        <input type="text" class="form-control form-control-line" value="1" name="v_dns-domains" id="ul3">
                                        <span class="input-group-btn"> 
                                            <button class="btn btn-outline-secondary" style="margin-right: 15px;" onclick="if(document.getElementById('ul3').value == 'unlimited') { document.getElementById('ul3').value = '1';} else { document.getElementById('ul3').value = 'unlimited';}" type="button">
                                                <i class="ti-infinite"></i>
                                            </button> 
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("DNS Records"); ?></label>
                                    <div class="col-md-12 input-group" style="padding-left: 15px;">
                                        <input type="text" class="form-control form-control-line" value="1" name="v_dns-records" id="ul4">
                                        <span class="input-group-btn"> 
                                            <button class="btn btn-outline-secondary" style="margin-right: 15px;" onclick="if(document.getElementById('ul4').value == 'unlimited') { document.getElementById('ul4').value = '1';} else { document.getElementById('ul4').value = 'unlimited';}" type="button">
                                                <i class="ti-infinite"></i>
                                            </button> 
                                        </span>
                                    </div>
                                </div>
                                <small class="form-text text-muted" style="top: -20px;position: relative;">Per Domain</small>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("Mail Domains"); ?></label>
                                    <div class="col-md-12 input-group" style="padding-left: 15px;">
                                        <input type="text" class="form-control form-control-line" value="1" name="v_mail-domains" id="ul5">
                                        <span class="input-group-btn"> 
                                            <button class="btn btn-outline-secondary" style="margin-right: 15px;" onclick="if(document.getElementById('ul5').value == 'unlimited') { document.getElementById('ul5').value = '1';} else { document.getElementById('ul5').value = 'unlimited';}" type="button">
                                                <i class="ti-infinite"></i>
                                            </button> 
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("Mail Accounts"); ?></label>
                                    <div class="col-md-12 input-group" style="padding-left: 15px;">
                                        <input type="text" class="form-control form-control-line" value="1" name="v_mail-accounts" id="ul6">
                                        <span class="input-group-btn"> 
                                            <button class="btn btn-outline-secondary" style="margin-right: 15px;" onclick="if(document.getElementById('ul6').value == 'unlimited') { document.getElementById('ul6').value = '1';} else { document.getElementById('ul6').value = 'unlimited';}" type="button">
                                                <i class="ti-infinite"></i>
                                            </button> 
                                        </span>
                                    </div>
                                </div>
                                <small class="form-text text-muted" style="top: -20px;position: relative;">Per Domain</small>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("Databases"); ?></label>
                                    <div class="col-md-12 input-group" style="padding-left: 15px;">
                                        <input type="text" class="form-control form-control-line" value="1" name="v_databases" id="ul7">
                                        <span class="input-group-btn"> 
                                            <button class="btn btn-outline-secondary" style="margin-right: 15px;" onclick="if(document.getElementById('ul7').value == 'unlimited') { document.getElementById('ul7').value = '1';} else { document.getElementById('ul7').value = 'unlimited';}" type="button">
                                                <i class="ti-infinite"></i>
                                            </button> 
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("Cron Jobs"); ?></label>
                                    <div class="col-md-12 input-group" style="padding-left: 15px;">
                                        <input type="text" class="form-control form-control-line" value="1" name="v_cron-jobs" id="ul8">
                                        <span class="input-group-btn"> 
                                            <button class="btn btn-outline-secondary" style="margin-right: 15px;" onclick="if(document.getElementById('ul8').value == 'unlimited') { document.getElementById('ul8').value = '1';} else { document.getElementById('ul8').value = 'unlimited';}" type="button">
                                                <i class="ti-infinite"></i>
                                            </button> 
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("Backups"); ?></label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control form-control-line" value="1" name="v_backups">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("Quota"); ?></label>
                                    <div class="col-md-12 input-group" style="padding-left: 15px;">
                                        <input type="text" class="form-control form-control-line" value="1000" name="v_quota" id="ul9">
                                        <span class="input-group-btn"> 
                                            <button class="btn btn-outline-secondary" style="margin-right: 15px;" onclick="if(document.getElementById('ul9').value == 'unlimited') { document.getElementById('ul9').value = '1000';} else { document.getElementById('ul9').value = 'unlimited';}" type="button">
                                                <i class="ti-infinite"></i>
                                            </button> 
                                        </span>
                                    </div>
                                </div>
                                <small class="form-text text-muted" style="top: -20px;position: relative;">In Megabytes</small>
                                <div class="form-group">
                                    <label class="col-md-12"><?php echo _("Bandwidth"); ?></label>
                                    <div class="col-md-12 input-group" style="padding-left: 15px;">
                                        <input type="text" class="form-control form-control-line" value="1000" name="v_bandwidth" id="ul10">
                                        <span class="input-group-btn"> 
                                            <button class="btn btn-outline-secondary" style="margin-right: 15px;" onclick="if(document.getElementById('ul10').value == 'unlimited') { document.getElementById('ul10').value = '1000';} else { document.getElementById('ul10').value = 'unlimited';}" type="button">
                                                <i class="ti-infinite"></i>
                                            </button> 
                                        </span>
                                    </div>
                                </div>
                                <small class="form-text text-muted" style="top: -20px;position: relative;">In Megabytes</small>
                                <div class="form-group" style="overflow: visible;">
                                    <label class="col-md-12"><?php echo _("SSH Access"); ?></label>
                                    <div class="col-md-12">
                                        <select class="form-control select2" name="ssh" id="sshselect">
                                            <option value="bash">bash</option>
                                            <option value="dash">dash</option>
                                            <option value="nologin" selected>nologin</option>
                                            <option value="rbash">rbash</option>
                                            <option value="rssh">rssh</option>
                                            <option value="screen">screen</option>
                                            <option value="sh">sh</option>
                                            <option value="tcsh">tcsh</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Default Nameservers"); ?></label>
                                            <div class="col-md-12">

                                                <div><input type="text" value="ns1.example.ltd" class="form-control form-control-line" name="ns1" id="ns1x"><br></div>

                                                <div><input type="text" value="ns2.example.ltd" class="form-control form-control-line" name="ns2" id="ns2x"><br><div id="ns2wrapper"><a style="cursor:pointer;" id="addmore" onclick="add1();"><?php echo _("Add One"); ?></a></div></div>

                                                <div id="ns3" style="display:<?php if(explode(',', ($packdata[0]['NS']))[2] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" class="form-control form-control-line" name="ns3" id="ns3x"><br><div id="ns3wrapper"><a style="cursor:pointer;" id="addmore1" onclick="add2();"><?php echo _("Add One"); ?></a> / <a style="cursor:pointer;" id="remove1" onclick="rem2();"><?php echo _("Remove One"); ?></a></div></div>

                                                <div id="ns4" style="display:<?php if(explode(',', ($packdata[0]['NS']))[3] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" class="form-control form-control-line" name="ns4" id="ns4x"><br><div id="ns4wrapper"><a style="cursor:pointer;" id="addmore2" onclick="add3();"><?php echo _("Add One"); ?></a> / <a style="cursor:pointer;" id="remove2" onclick="rem3();"><?php echo _("Remove One"); ?></a></div></div>

                                                <div id="ns5" style="display:<?php if(explode(',', ($packdata[0]['NS']))[4] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" class="form-control form-control-line" name="ns5" id="ns5x"><br><div id="ns5wrapper"><a style="cursor:pointer;" id="addmore3" onclick="add4();"><?php echo _("Add One"); ?></a> / <a style="cursor:pointer;" id="remove3" onclick="rem4();"><?php echo _("Remove One"); ?></a></div></div>

                                                <div id="ns6" style="display:<?php if(explode(',', ($packdata[0]['NS']))[5] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" class="form-control form-control-line" name="ns6" id="ns6x"><br><div id="ns6wrapper"><a style="cursor:pointer;" id="addmore4" onclick="add5();"><?php echo _("Add One"); ?></a> / <a style="cursor:pointer;" id="remove4" onclick="rem5();"><?php echo _("Remove One"); ?></a></div></div>

                                                <div id="ns7" style="display:<?php if(explode(',', ($packdata[0]['NS']))[6] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" class="form-control form-control-line" name="ns7" id="ns7x"><br><div id="ns7wrapper"><a style="cursor:pointer;" id="addmore5" onclick="add6();"><?php echo _("Add One"); ?></a> / <a style="cursor:pointer;" id="remove5" onclick="rem6();"><?php echo _("Remove One"); ?></a></div></div>

                                                <div id="ns8" style="display:<?php if(explode(',', ($packdata[0]['NS']))[7] == ''){ echo "none"; } else { echo "block"; } ?>"><input type="text" class="form-control form-control-line" name="ns8" id="ns8x"><br><div id="ns8wrapper"><a style="cursor:pointer;" id="remove6" onclick="rem7();"><?php echo _("Remove One"); ?></a></div></div>
                                            </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success" onclick="processLoader();"><?php echo _("Add Package"); ?></button> &nbsp;
                                            <a href="../list/packages.php" style="color: inherit;text-decoration: inherit;"><button class="btn btn-muted" type="button"><?php echo _("Back"); ?></button></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
           <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../../includes/versioncheck.php'; ?> <?php echo _("by CDG Web Services"); ?>.</footer>
    </div>
    </div>
    <script src="../../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="../../plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <script src="../../bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <script src="../../js/jquery.slimscroll.js"></script>
    <script src="../../js/waves.js"></script>
    <script src="../../plugins/bower_components/moment/moment.js"></script>
    <script src="../../plugins/bower_components/footable/js/footable.min.js"></script>
    <script src="../../plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="../../plugins/bower_components/custom-select/custom-select.min.js"></script>
    <script src="../../js/footable-init.js"></script>
    <script src="../../js/custom.js"></script>
    <script src="../../js/dashboard1.js"></script>
    <script src="../../js/cbpFWTabs.js"></script>
    <script src="../../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.js"></script>
    <script src="../../plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <script type="text/javascript">
        <?php 

        if(isset($pluginnames[0]) && $pluginnames[0] != '') {
            $currentplugin = 0; 
            do {
                if (!strpos($pluginadminonly[$currentplugin] , 'y') && !strpos($pluginadminonly[$currentplugin] , 'Y')) {
                    $currentstring = "<li><a href='../../plugins/" . $pluginlinks[$currentplugin] . "/' ><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";
                }

                else {
                         $currentstring = "<?php if($username == 'admin') { echo \"<li><a href='../../plugins/" . $pluginnames[$currentplugin] . "/' ><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>\";} ?>";
                }
                echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');
                      var plugindata" . $currentplugin . " = \"" . $currentstring . "\";
                      plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n";
                $currentplugin++;
            } while ($pluginnames[$currentplugin] != ''); }
        ?>  
            
            for (i = 0; i < document.getElementById('select3').length; ++i){
                if (document.getElementById('select3').options[i].value == "default"){
                  document.getElementById('select3').value = 'default';
                }
            }

            for (i = 0; i < document.getElementById('select4').length; ++i){
                if (document.getElementById('select4').options[i].value == "default"){
                  document.getElementById('select4').value = 'default';
                }
            }

            for (i = 0; i < document.getElementById('select5').length; ++i){
                if (document.getElementById('select5').options[i].value == "default"){
                  document.getElementById('select5').value = 'default';
                }
            }
</script>
    <script type="text/javascript">
$('.datepicker').datepicker();
        (function () {
                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                new CBPFWTabs(el);
            });
        })(); 
        <?php echo 'document.getElementById("typeselect").value = \'' . $firedata[0]['ACTION'] . '\';'; ?>
        <?php echo 'document.getElementById("protocolselect").value = \'' . $firedata[0]['PROTOCOL'] . '\';'; ?>
        jQuery(function($){
            $('.footable').footable();
        });
        $(document).ready(function() {
            $('.select2').select2();
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
        
                $checkcount = 2;
        $check1count = 3;

        while($checkcount <= 7) {
            echo "if( document.getElementById('ns" . $check1count . "x').value != '') {
            document.getElementById('ns" . $checkcount . "wrapper').style.display = 'none';
}";

            $checkcount++;
            $check1count++;
        }

        $addcount = 1;
        $add1count = 2; 
        $add2count = 3; 


        while($addcount <= 6) {
            echo "function add" . $addcount ."() {
if( document.getElementById('ns" . $add2count . "').style.display = 'none' ) {
            document.getElementById('ns" . $add2count . "').style.display = 'block'; 
            document.getElementById('ns" . $add1count . "wrapper').style.display = 'none';
        } 
}";
            $addcount++;
            $add1count++;
            $add2count++;
        } 

        $remcount = 2;
        $rem1count = 3; 


        while($remcount <= 7) {
            echo "function rem" . $remcount ."() {
if( document.getElementById('ns" . $rem1count . "').style.display = 'block' ) {
            document.getElementById('ns" . $rem1count . "').style.display = 'none'; 
            document.getElementById('ns" . $remcount . "wrapper').style.display = 'block';
            document.getElementById('ns" . $rem1count . "x').value = '';
        } 
}";
            $remcount++;
            $rem1count++;
        } 
        
           if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "swal({title:'" . $errorcode[1] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            } 
            if(isset($_POST['r1']) && $_POST['r1'] == "0") {
                echo "swal({title:'" . _("Successfully Updated!") . "', type:'success'});";
            } 
            if(isset($_POST['r1']) && $_POST['r1'] > "0") { echo "swal({title:'" . $errorcode[$_POST['r1']] . "<br><br>" . _("Please try again later or contact support.") . "', type:'error'});";
            }
        ?>
    </script>
</body>

</html>