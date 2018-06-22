<?php

session_start();

if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

$requestdns = $_GET['domain'];

if (isset($requestdns) && $requestdns != '') {}
else { header('Location: ../list/dns.php'); }

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
        curl_setopt($cfns, CURLOPT_POSTFIELDS, http_build_query(array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-dns-records','arg1' => $username,'arg2' => $requestdns, 'arg3' => 'json')));

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
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-dns-records','arg1' => $username,'arg2' => $requestdns, 'arg3' => 'json'));

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
        <link rel="icon" type="image/ico" href="../plugins/images/favicon.ico">
        <title><?php echo $sitetitle; ?> - <?php echo _("DNS"); ?></title>
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
        <style>
            @font-face {
                font-family: 'fontello';
                src: url('../css/font/fontello.eot?3757582');
                src: url('../css/font/fontello.eot?3757582#iefix') format('embedded-opentype'),
                    url('../css/font/fontello.woff?3757582') format('woff'),
                    url('../css/font/fontello.ttf?3757582') format('truetype'),
                    url('../css/font/fontello.svg?3757582#fontello') format('svg');
                font-weight: normal;
                font-style: normal;
            }


            .icon-cloudflare
            {
                font-family: "fontello";
                font-style: normal;
                font-weight: normal;
                speak: none;
                font-size: 150%;
                top: -6.2px;
                position: relative;

        </style>
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
                            <!--This is dark logo icon--><img src="../plugins/images/admin-logo.png" alt="home" class="logo-1 dark-logo" /><!--This is light logo icon--><img src="../plugins/images/admin-logo-dark.png" alt="home" class="logo-1 light-logo" />
                            </b>
                            <!-- Logo text image you can use text also --><span class="hidden-xs">
                            <!--This is dark logo text--><img src="../plugins/images/admin-text.png" alt="home" class="hidden-xs dark-logo" /><!--This is light logo text--><img src="../plugins/images/admin-text-dark.png" alt="home" class="hidden-xs light-logo" />
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
                        <li> 
                            <a href="../index.php" class="waves-effect">
                                <i class="mdi mdi-home fa-fw"></i> <span class="hide-menu"><?php echo _("Home"); ?></span>
                            </a> 
                        </li>
                        <?php if($initialusername == "admin"){ echo 
                        '<li class="devider"></li>
                            <li> <a href="../#" class="waves-effect"><i class="mdi mdi-wrench fa-fw" data-icon="v"></i> <span class="hide-menu">' . _("Administration") . '<span class="fa arrow"></span> </span></a>
                                <ul class="nav nav-second-level">
                                    <li> <a href="../admin/list/users.php"><i class="ti-user fa-fw"></i><span class="hide-menu">' . _("Users") . '</span></a> </li>
                                    <li> <a href="../admin/list/packages.php"><i class="ti-package fa-fw"></i><span class="hide-menu">' . _("Packages") . '</span></a> </li>
                                    <li> <a href="../admin/list/ip.php"><i class="fa fa-sliders fa-fw"></i><span class="hide-menu">' . _("IP") . '</span></a> </li>
                                    <li> <a href="../admin/list/graphs.php"><i class="ti-pie-chart fa-fw"></i><span class="hide-menu">' . _("Graphs") . '</span></a> </li>
                                    <li> <a href="../admin/list/stats.php"><i class="ti-stats-up fa-fw"></i><span class="hide-menu">' . _("Statistics") . '</span></a> </li>
                                    <li> <a href="../admin/list/updates.php"><i class="mdi mdi-weather-cloudy fa-fw"></i><span class="hide-menu">' . _("Updates") . '</span></a> </li>
                                    <li> <a href="../admin/list/firewall.php"><i class="fa fa-shield fa-fw"></i><span class="hide-menu">' . _("Firewall") . '</span></a> </li>
                                    <li> <a href="../admin/list/server.php"><i class="fa fa-server fa-fw"></i><span class="hide-menu">' . _("Server") . '</span></a> </li>
                                </ul>
                            </li>';
                                                             } ?>
                        <li class="devider"></li>
                        <li>
                            <a href="#" class="waves-effect"><i  class="ti-user fa-fw"></i><span class="hide-menu"> <?php print_r($displayname); ?><span class="fa arrow"></span></span>
                            </a>
                            <ul class="nav nav-second-level collapse" id="appendaccount" aria-expanded="false" style="height: 0px;">
                                <li> <a href="../profile.php"><i class="ti-home fa-fw"></i> <span class="hide-menu"> <?php echo _("My Account"); ?></span></a></li>
                                <li> <a href="../profile.php?settings=open"><i class="ti-settings fa-fw"></i> <span class="hide-menu"> <?php echo _("Acount Settings"); ?></span></a></li>
                                <li> <a href="../log.php"><i class="ti-layout-list-post fa-fw"></i><span class="hide-menu"><?php echo _("Log"); ?></span></a> </li>
                            </ul>
                        </li>
                        <?php if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '<li class="devider"></li>
                            <li class="active"> <a href="#" class="waves-effect"><i class="mdi mdi-av-timer fa-fw" data-icon="v"></i> <span class="hide-menu">'. _("Management") . '<span class="fa arrow"></span> </span></a>
                                <ul class="nav nav-second-level" id="appendmanagement">'; } ?>
                        <?php if ($webenabled == 'true') { echo '<li> <a href="../list/web.php"><i class="ti-world fa-fw"></i><span class="hide-menu">' . _("Web") . '</span></a> </li>'; } ?>
                        <?php if ($dnsenabled == 'true') { echo '<li> <a href="../list/dns.php" class="active"><i class="fa fa-sitemap fa-fw"></i><span class="hide-menu">' . _("DNS") . '</span></a> </li>'; } ?>
                        <?php if ($mailenabled == 'true') { echo '<li> <a href="../list/mail.php"><i class="fa fa-envelope fa-fw"></i><span class="hide-menu">' . _("Mail") . '</span></a> </li>'; } ?>
                        <?php if ($dbenabled == 'true') { echo '<li> <a href="../list/db.php"><i class="fa fa-database fa-fw"></i><span class="hide-menu">' . _("Database") . '</span></a> </li>'; } ?>
                        <?php if ($webenabled == 'true' || $dnsenabled == 'true' || $mailenabled == 'true' || $dbenabled == 'true') { echo '</ul>
                            </li>'; } ?>
                        <li> <a href="../list/cron.php" class="waves-effect"><i  class="mdi mdi-settings fa-fw"></i> <span class="hide-menu"><?php echo _("Cron Jobs"); ?></span></a> </li>
                        <li> <a href="../list/backups.php" class="waves-effect"><i  class="fa fa-cloud-upload fa-fw"></i> <span class="hide-menu"><?php echo _("Backups"); ?></span></a> </li>
                        <?php if ($ftpurl == '' && $webmailurl == '' && $phpmyadmin == '' && $phppgadmin == '') {} else { echo '<li class="devider"></li>
                            <li><a href="#" class="waves-effect"><i class="mdi mdi-apps fa-fw"></i> <span class="hide-menu">' . _("Apps") . '<span class="fa arrow"></span></span></a>
                                <ul class="nav nav-second-level" id="appendapps">'; } ?>
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
                            <h4 class="page-title"><?php echo _("Manage DNS Domain"); ?></h4>
                        </div>
                        <ul id="cloudflare1" class="side-icon-text pull-right">
                            <li style="position: relative;top: -3px;">
                                <a onclick="confirmDelete2();" style="cursor: pointer;"><span class="circle circle-sm bg-danger di"><i class="ti-trash"></i></span><span><?php echo _("Delete DNS Domain"); ?></span>
                                </a>
                            </li>
                        </ul>
                        <ul id="cloudflare" class="side-icon-text pull-right" style="display:none;">
                            <li style="position: relative;top: -8px;">
                                <a onclick="confirmDelete2();" style="cursor: pointer;"><span class="circle circle-sm bg-danger di"><i class="ti-trash"></i></span><span><?php echo _("Delete DNS Domain"); ?></span>
                                </a>
                            </li>
                            <li style="position: relative;top: -8px;">
                                <a href="../create/cloudflare.php?domain=<?php echo $requestdns; ?>"><span style="top: 8px;position: relative;"class="circle circle-sm bg-warning di"><i class="icon-cloudflare">&#xe801;</i></span><span><?php echo _("Enable Cloudflare"); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-12">
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
                                <li><a href="../add/dnsrecord.php?domain=<?php echo $requestdns; ?>"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span><?php echo _("Add Record"); ?></span></a></li>
                                </ul>
                                <h3 class="box-title m-b-0"><?php echo _("DNS Records"); ?></h3><br>
                                <div class="table-responsive">
                                    <table class="table footable m-b-0" data-paging-size="10" data-paging="true" data-sorting="true">
                                        <thead>
                                            <tr>
                                                <th data-toggle="true"> <?php echo _("Record"); ?> </th>
                                                <th> <?php echo _("Type"); ?> </th>
                                                <th> <?php echo _("Value"); ?> </th>
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
                                                            <td>' . $dnsdata[$x1]['VALUE'] . '</td><td>
                                                            <button type="button" onclick="window.location=\'../edit/dnsrecord.php?domain=' . $requestdns . '&record=' . $dnsname[$x1] . '\';" class="btn color-button btn-outline btn-circle btn-md m-r-5" data-toggle="tooltip" data-original-title="' . _("Edit") . '"><i class="ti-pencil-alt"></i></button>
                                                            <button type="button" onclick="confirmDelete(\'' . $dnsname[$x1] . '\')" class="btn color-button btn-outline btn-circle btn-md m-r-5" data-toggle="tooltip" data-original-title="' . _("Delete") . '"><i class="icon-trash" ></i></button>
                                                            </td><td>';                                                                   
                                                    if($dnsdata[$x1]['SUSPENDED'] == "no"){ 
                                                        echo '<span class="label label-table label-success">' . _("Active") . '</span>';} 
                                                    else{ 
                                                        echo '<span class="label label-table label-danger">' . _("Suspended") . '</span>';} 
                                                    echo '</td>
                                                            <td>' . $dnsdata[$x1]['DATE'] . '</td>';
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
                <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../includes/versioncheck.php'; ?> <?php echo _("by CDG Web Services"); ?>.</footer>
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
        <script src="../js/footable-init.js"></script>
        <script src="../js/custom.js"></script>
        <script src="../js/dashboard1.js"></script>
        <script src="../js/cbpFWTabs.js"></script>
        <script src="../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.5/sweetalert2.all.js"></script>
        <script type="text/javascript">
            <?php 

            if(isset($pluginnames[0]) && $pluginnames[0] != '') {
                $currentplugin = 0; 
                do {
                    if (!strpos($pluginadminonly[$currentplugin] , 'y') && !strpos($pluginadminonly[$currentplugin] , 'Y')) {
                        $currentstring = "<li><a href='../plugins/" . $pluginlinks[$currentplugin] . "/' ><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";
                    }

                    else {
                        $currentstring = "<?php if($username == 'admin') { echo \"<li><a href='../plugins/" . $pluginnames[$currentplugin] . "/' ><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>\";} ?>";
                    }
                    echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');
                          var plugindata" . $currentplugin . " = \"" . $currentstring . "\";
                          plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n";
                    $currentplugin++;
                } while ($pluginnames[$currentplugin] != ''); }

            ?>
        </script>
        <script type="text/javascript">
            (function () {
                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                    new CBPFWTabs(el);
                });
            })();
        </script>
        <script>
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

                <?php if ($cfenabled != "off") { echo 'if(subDomain === false) {
                        document.getElementById("cloudflare").style.display = "block";
                        document.getElementById("cloudflare1").style.display = "none";
                    }
                    else { 
                        document.getElementById("cloudflare1").style.display = "block";
                        document.getElementById("cloudflare").style.display = "none"; }
                    }
                    subDomain();'; } ?>
                function confirmDelete(e){
                    e1 = String(e)
                    e0 = '<?php print_r($requestdns); ?>';
                    swal({
                        title: '<?php echo _("Delete DNS Record"); ?><br> #' + e1 +' ?',
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
                        window.location.replace("../delete/dnsrecord.php?domain=" + e0 + "&id=" +e1);
                    })}
                function confirmDelete2(){
                    swal({
                        title: '<?php echo _("Delete DNS Domain"); ?>:<br> <?php echo $requestdns; ?>' + ' ?',
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
                        window.location.replace("../delete/dns.php?domain=<?php echo $requestdns; ?>");
                    })}

                <?php
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

                ?>
        </script>
    </body>
</html>