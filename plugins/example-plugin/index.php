<?php

session_start();
$configlocation = "../../includes/";
if (file_exists( '../../includes/config.php' )) { require( '../../includes/includes.php'); }  else { header( 'Location: ../../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../../login.php'); }

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'));

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
bindtextdomain('messages', '../../locale');
textdomain('messages');

foreach ($plugins as $result) {
    if (file_exists('../' . $result)) {
        if (file_exists('../' . $result . '/manifest.xml')) {
            $get = file_get_contents('../' . $result . '/manifest.xml');
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
        <link rel="icon" type="image/ico" href="../images/<?php echo $cpfavicon; ?>">
        <title><?php echo $sitetitle; ?> - <?php echo _("Example Plugin"); ?></title>
        <link href="../components/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="../components/metismenu/metisMenu.min.css" rel="stylesheet">
        <link href="../components/footable//footable.bootstrap.css" rel="stylesheet">
        <link href="../components/select2/select2.min.css" rel="stylesheet">
        <link href="../components/animate.css/animate.min.css" rel="stylesheet">
        <link href="../../css/style.css" rel="stylesheet">
        <link href="../components/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet">
        <link href="../../css/colors/<?php if(isset($_COOKIE['theme'])) { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <link rel="stylesheet" href="../components/sweetalert2/sweetalert2.min.css" />
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
                            <img src="../images/<?php echo $cpicon; ?>" alt="home" class="logo-1 dark-logo" />
                            <img src="../images/<?php echo $cplogo; ?>" alt="home" class="hidden-xs dark-logo" />
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
                              adminMenu("../../admin/list/", "");
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
                            <h4 class="page-title"><?php echo _("Example Plugin"); ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <p>This is an example plugin.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php hotkeys($configlocation); ?>
                <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../../includes/versioncheck.php'; ?> <?php echo _("by Carter Roeser"); ?>.</footer>
            </div>
        </div>
        <script src="../components/jquery/jquery.min.js"></script>
        <script src="../components/jquery-toast-plugin/jquery.toast.min.js"></script>
        <script src="../components/bootstrap/js/bootstrap.min.js"></script>
        <script src="../components/metismenu/metisMenu.min.js"></script>
        <script src="../components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../../js/waves.js"></script>
        <script src="../components/moment/moment.min.js"></script>
        <script src="../components/footable//footable.min.js"></script>
        <script src="../components/select2/select2.min.js"></script>
        <script src="../../js/footable-init.js"></script>
        <script src="../../js/custom.js"></script>
        <script src="../../js/cbpFWTabs.js"></script>
        <script src="../components/sweetalert2/sweetalert2.min.js"></script>
        <script type="text/javascript">
            <?php 
            
            includeScript();
            
            $pluginlocation = "../"; if(isset($pluginnames[0]) && $pluginnames[0] != '') { $currentplugin = 0; do { if (strtolower($pluginhide[$currentplugin]) != 'y' && strtolower($pluginhide[$currentplugin]) != 'yes') { if (strtolower($pluginadminonly[$currentplugin]) != 'y' && strtolower($pluginadminonly[$currentplugin]) != 'yes') { if (strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; } else { $currentstring = "<li><a href='".$pluginlocation.$pluginlinks[$currentplugin]."/'><i class='fa ".$pluginicons[$currentplugin]." fa-fw'></i><span class='hide-menu'>"._($pluginnames[$currentplugin])."</span></a></li>"; }} else { if(strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";} } else { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; }}} echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');\n var plugindata" . $currentplugin . " = \"" . $currentstring . "\";\n plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n"; } $currentplugin++; } while ($pluginnames[$currentplugin] != ''); } ?>
        </script>
    </body>
</html>