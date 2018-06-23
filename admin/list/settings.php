<?php

session_start();

if (file_exists( '../../includes/config.php' )) { require( '../../includes/includes.php'); }  else { header( 'Location: ../../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../../login.php'); }
if($username != 'admin') { header("Location: ../../"); }

if(isset($adminenabled) && $adminenabled != 'true'){ header("Location: ../../error-pages/403.html"); }

$postvars = array(
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json')
);

$curl0 = curl_init();
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
        <link rel="icon" type="image/ico" href="../../plugins/images/favicon.ico">
        <title><?php echo $sitetitle; ?> - <?php echo _("Settings"); ?></title>
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

    <body class="fix-header" onload="checkDiv();">
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
                              adminMenu("./", "settings");
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
                            <h4 class="page-title"><?php echo _("Edit Panel Settings"); ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <form class="form-horizontal form-material" autocomplete="off" method="post" action="../change/settings.php" enctype="multipart/form-data">
                                    <h3>Server Configuration</h3><br><hr><br>
                                    <div class="form-group"  style="overflow: visible;">
                                        <label class="col-md-12">Server Timezone</label>
                                        <div class="col-md-12">
                                            <select id="timeselect" name="TIMEZONE" class="form-control select2">
                                                <option value="Pacific/Midway">(UTC-11:00) Midway Island</option>
                                                <option value="Pacific/Samoa">(UTC-11:00) Samoa</option>
                                                <option value="Pacific/Honolulu">(UTC-10:00) Hawaii</option>
                                                <option value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands</option>
                                                <option value="Pacific/Gambier">(GMT-09:00) Gambier Islands</option>
                                                <option value="US/Alaska">(UTC-09:00) Alaska</option>
                                                <option value="America/Los_Angeles">(UTC-08:00) Pacific Time (US &amp; Canada)</option>
                                                <option value="America/Tijuana">(UTC-08:00) Tijuana</option>
                                                <option value="US/Arizona">(UTC-07:00) Arizona</option>
                                                <option value="America/Chihuahua">(UTC-07:00) Chihuahua</option>
                                                <option value="America/Chihuahua">(UTC-07:00) La Paz</option>
                                                <option value="America/Mazatlan">(UTC-07:00) Mazatlan</option>
                                                <option value="US/Mountain">(UTC-07:00) Mountain Time (US &amp; Canada)</option>
                                                <option value="America/Managua">(UTC-06:00) Central America</option>
                                                <option value="US/Central">(UTC-06:00) Central Time (US &amp; Canada)</option>
                                                <option value="America/Mexico_City">(UTC-06:00) Guadalajara</option>
                                                <option value="America/Mexico_City">(UTC-06:00) Mexico City</option>
                                                <option value="America/Monterrey">(UTC-06:00) Monterrey</option>
                                                <option value="Canada/Saskatchewan">(UTC-06:00) Saskatchewan</option>
                                                <option value="America/Bogota">(UTC-05:00) Bogota</option>
                                                <option value="US/Eastern">(UTC-05:00) Eastern Time (US &amp; Canada)</option>
                                                <option value="US/East-Indiana">(UTC-05:00) Indiana (East)</option>
                                                <option value="America/Lima">(UTC-05:00) Lima</option>
                                                <option value="America/Bogota">(UTC-05:00) Quito</option>
                                                <option value="Canada/Atlantic">(UTC-04:00) Atlantic Time (Canada)</option>
                                                <option value="America/Caracas">(UTC-04:30) Caracas</option>
                                                <option value="America/La_Paz">(UTC-04:00) La Paz</option>
                                                <option value="America/Santiago">(UTC-04:00) Santiago</option>
                                                <option value="Canada/Newfoundland">(UTC-03:30) Newfoundland</option>
                                                <option value="America/Sao_Paulo">(UTC-03:00) Brasilia</option>
                                                <option value="America/Argentina/Buenos_Aires">(UTC-03:00) Buenos Aires</option>
                                                <option value="America/Argentina/Buenos_Aires">(UTC-03:00) Georgetown</option>
                                                <option value="America/Godthab">(UTC-03:00) Greenland</option>
                                                <option value="America/Noronha">(UTC-02:00) Mid-Atlantic</option>
                                                <option value="Atlantic/Azores">(UTC-01:00) Azores</option>
                                                <option value="Atlantic/Cape_Verde">(UTC-01:00) Cape Verde Is.</option>
                                                <option value="Africa/Casablanca">(UTC+00:00) Casablanca</option>
                                                <option value="Europe/London">(UTC+00:00) Edinburgh</option>
                                                <option value="Etc/Greenwich">(UTC+00:00) Greenwich Mean Time : Dublin</option>
                                                <option value="Europe/Lisbon">(UTC+00:00) Lisbon</option>
                                                <option value="Europe/London">(UTC+00:00) London</option>
                                                <option value="Africa/Monrovia">(UTC+00:00) Monrovia</option>
                                                <option value="UTC">(UTC+00:00) UTC</option>
                                                <option value="Europe/Amsterdam">(UTC+01:00) Amsterdam</option>
                                                <option value="Europe/Belgrade">(UTC+01:00) Belgrade</option>
                                                <option value="Europe/Berlin">(UTC+01:00) Berlin</option>
                                                <option value="Europe/Berlin">(UTC+01:00) Bern</option>
                                                <option value="Europe/Bratislava">(UTC+01:00) Bratislava</option>
                                                <option value="Europe/Brussels">(UTC+01:00) Brussels</option>
                                                <option value="Europe/Budapest">(UTC+01:00) Budapest</option>
                                                <option value="Europe/Copenhagen">(UTC+01:00) Copenhagen</option>
                                                <option value="Europe/Ljubljana">(UTC+01:00) Ljubljana</option>
                                                <option value="Europe/Madrid">(UTC+01:00) Madrid</option>
                                                <option value="Europe/Paris">(UTC+01:00) Paris</option>
                                                <option value="Europe/Prague">(UTC+01:00) Prague</option>
                                                <option value="Europe/Rome">(UTC+01:00) Rome</option>
                                                <option value="Europe/Sarajevo">(UTC+01:00) Sarajevo</option>
                                                <option value="Europe/Skopje">(UTC+01:00) Skopje</option>
                                                <option value="Europe/Stockholm">(UTC+01:00) Stockholm</option>
                                                <option value="Europe/Vienna">(UTC+01:00) Vienna</option>
                                                <option value="Europe/Warsaw">(UTC+01:00) Warsaw</option>
                                                <option value="Africa/Lagos">(UTC+01:00) West Central Africa</option>
                                                <option value="Europe/Zagreb">(UTC+01:00) Zagreb</option>
                                                <option value="Europe/Athens">(UTC+02:00) Athens</option>
                                                <option value="Europe/Bucharest">(UTC+02:00) Bucharest</option>
                                                <option value="Africa/Cairo">(UTC+02:00) Cairo</option>
                                                <option value="Africa/Harare">(UTC+02:00) Harare</option>
                                                <option value="Europe/Helsinki">(UTC+02:00) Helsinki</option>
                                                <option value="Europe/Istanbul">(UTC+02:00) Istanbul</option>
                                                <option value="Asia/Jerusalem">(UTC+02:00) Jerusalem</option>
                                                <option value="Europe/Helsinki">(UTC+02:00) Kyiv</option>
                                                <option value="Africa/Johannesburg">(UTC+02:00) Pretoria</option>
                                                <option value="Europe/Riga">(UTC+02:00) Riga</option>
                                                <option value="Europe/Sofia">(UTC+02:00) Sofia</option>
                                                <option value="Europe/Tallinn">(UTC+02:00) Tallinn</option>
                                                <option value="Europe/Vilnius">(UTC+02:00) Vilnius</option>
                                                <option value="Asia/Baghdad">(UTC+03:00) Baghdad</option>
                                                <option value="Asia/Kuwait">(UTC+03:00) Kuwait</option>
                                                <option value="Europe/Minsk">(UTC+03:00) Minsk</option>
                                                <option value="Africa/Nairobi">(UTC+03:00) Nairobi</option>
                                                <option value="Asia/Riyadh">(UTC+03:00) Riyadh</option>
                                                <option value="Europe/Volgograd">(UTC+03:00) Volgograd</option>
                                                <option value="Asia/Tehran">(UTC+03:30) Tehran</option>
                                                <option value="Asia/Muscat">(UTC+04:00) Abu Dhabi</option>
                                                <option value="Asia/Baku">(UTC+04:00) Baku</option>
                                                <option value="Europe/Moscow">(UTC+04:00) Moscow</option>
                                                <option value="Asia/Muscat">(UTC+04:00) Muscat</option>
                                                <option value="Europe/Moscow">(UTC+04:00) St. Petersburg</option>
                                                <option value="Asia/Tbilisi">(UTC+04:00) Tbilisi</option>
                                                <option value="Asia/Yerevan">(UTC+04:00) Yerevan</option>
                                                <option value="Asia/Kabul">(UTC+04:30) Kabul</option>
                                                <option value="Asia/Karachi">(UTC+05:00) Islamabad</option>
                                                <option value="Asia/Karachi">(UTC+05:00) Karachi</option>
                                                <option value="Asia/Tashkent">(UTC+05:00) Tashkent</option>
                                                <option value="Asia/Calcutta">(UTC+05:30) Chennai</option>
                                                <option value="Asia/Kolkata">(UTC+05:30) Kolkata</option>
                                                <option value="Asia/Calcutta">(UTC+05:30) Mumbai</option>
                                                <option value="Asia/Calcutta">(UTC+05:30) New Delhi</option>
                                                <option value="Asia/Calcutta">(UTC+05:30) Sri Jayawardenepura</option>
                                                <option value="Asia/Katmandu">(UTC+05:45) Kathmandu</option>
                                                <option value="Asia/Almaty">(UTC+06:00) Almaty</option>
                                                <option value="Asia/Dhaka">(UTC+06:00) Astana</option>
                                                <option value="Asia/Dhaka">(UTC+06:00) Dhaka</option>
                                                <option value="Asia/Yekaterinburg">(UTC+06:00) Ekaterinburg</option>
                                                <option value="Asia/Rangoon">(UTC+06:30) Rangoon</option>
                                                <option value="Asia/Bangkok">(UTC+07:00) Bangkok</option>
                                                <option value="Asia/Bangkok">(UTC+07:00) Hanoi</option>
                                                <option value="Asia/Jakarta">(UTC+07:00) Jakarta</option>
                                                <option value="Asia/Novosibirsk">(UTC+07:00) Novosibirsk</option>
                                                <option value="Asia/Hong_Kong">(UTC+08:00) Beijing</option>
                                                <option value="Asia/Chongqing">(UTC+08:00) Chongqing</option>
                                                <option value="Asia/Hong_Kong">(UTC+08:00) Hong Kong</option>
                                                <option value="Asia/Krasnoyarsk">(UTC+08:00) Krasnoyarsk</option>
                                                <option value="Asia/Kuala_Lumpur">(UTC+08:00) Kuala Lumpur</option>
                                                <option value="Australia/Perth">(UTC+08:00) Perth</option>
                                                <option value="Asia/Singapore">(UTC+08:00) Singapore</option>
                                                <option value="Asia/Taipei">(UTC+08:00) Taipei</option>
                                                <option value="Asia/Ulan_Bator">(UTC+08:00) Ulaan Bataar</option>
                                                <option value="Asia/Urumqi">(UTC+08:00) Urumqi</option>
                                                <option value="Asia/Irkutsk">(UTC+09:00) Irkutsk</option>
                                                <option value="Asia/Tokyo">(UTC+09:00) Osaka</option>
                                                <option value="Asia/Tokyo">(UTC+09:00) Sapporo</option>
                                                <option value="Asia/Seoul">(UTC+09:00) Seoul</option>
                                                <option value="Asia/Tokyo">(UTC+09:00) Tokyo</option>
                                                <option value="Australia/Adelaide">(UTC+09:30) Adelaide</option>
                                                <option value="Australia/Darwin">(UTC+09:30) Darwin</option>
                                                <option value="Australia/Brisbane">(UTC+10:00) Brisbane</option>
                                                <option value="Australia/Canberra">(UTC+10:00) Canberra</option>
                                                <option value="Pacific/Guam">(UTC+10:00) Guam</option>
                                                <option value="Australia/Hobart">(UTC+10:00) Hobart</option>
                                                <option value="Australia/Melbourne">(UTC+10:00) Melbourne</option>
                                                <option value="Pacific/Port_Moresby">(UTC+10:00) Port Moresby</option>
                                                <option value="Australia/Sydney">(UTC+10:00) Sydney</option>
                                                <option value="Asia/Yakutsk">(UTC+10:00) Yakutsk</option>
                                                <option value="Asia/Vladivostok">(UTC+11:00) Vladivostok</option>
                                                <option value="Pacific/Auckland">(UTC+12:00) Auckland</option>
                                                <option value="Pacific/Fiji">(UTC+12:00) Fiji</option>
                                                <option value="Pacific/Kwajalein">(UTC+12:00) International Date Line West</option>
                                                <option value="Asia/Kamchatka">(UTC+12:00) Kamchatka</option>
                                                <option value="Asia/Magadan">(UTC+12:00) Magadan</option>
                                                <option value="Pacific/Fiji">(UTC+12:00) Marshall Is.</option>
                                                <option value="Asia/Magadan">(UTC+12:00) New Caledonia</option>
                                                <option value="Asia/Magadan">(UTC+12:00) Solomon Is.</option>
                                                <option value="Pacific/Auckland">(UTC+12:00) Wellington</option>
                                                <option value="Pacific/Tongatapu">(UTC+13:00) Nuku'alofa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Site Name</label>  
                                        <div class="col-md-12">
                                            <input id="textinput" name="SITENAME" type="text" value="<?php echo $sitetitle; ?>" class="form-control input-md" required="">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Theme</label>
                                        <div class="col-md-12">
                                            <select id="themeselect" name="THEME" class="form-control select2">
                                                <option value="default">Default</option>
                                                <option value="blue">Blue</option>
                                                <option value="purple">Purple</option>
                                                <option value="orange">Orange</option>
                                                <option value="orange">Dark</option>
                                            </select>
                                        </div>
                                    </div>             
                                    <div class="form-group" style="overflow: visible;">
                                        <label class="col-md-12"><?php echo _("Language"); ?></label>
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="LANGUAGE" id="languageselect">
                                                <option value="<?php print_r($ulang['ar']); ?>"><?php print_r($countries['ar']); ?></option>
                                                <option value="<?php print_r($ulang['bs']); ?>"><?php print_r($countries['bs']); ?></option>
                                                <option value="<?php print_r($ulang['cn']); ?>>"><?php print_r($countries['cn']); ?></option>
                                                <option value="<?php print_r($ulang['cz']); ?>"><?php print_r($countries['cz']); ?></option>
                                                <option value="<?php print_r($ulang['da']); ?>"><?php print_r($countries['da']); ?></option>
                                                <option value="<?php print_r($ulang['de']); ?>"><?php print_r($countries['de']); ?></option>
                                                <option value="<?php print_r($ulang['el']); ?>>"><?php print_r($countries['el']); ?></option>
                                                <option value="<?php print_r($ulang['en']); ?>"><?php print_r($countries['en']); ?></option>
                                                <option value="<?php print_r($ulang['es']); ?>"><?php print_r($countries['es']); ?></option>
                                                <option value="<?php print_r($ulang['fa']); ?>"><?php print_r($countries['fa']); ?></option>
                                                <option value="<?php print_r($ulang['fi']); ?>"><?php print_r($countries['fi']); ?></option>
                                                <option value="<?php print_r($ulang['fr']); ?>"><?php print_r($countries['fr']); ?></option>
                                                <option value="<?php print_r($ulang['hu']); ?>"><?php print_r($countries['hu']); ?></option>
                                                <option value="<?php print_r($ulang['id']); ?>"><?php print_r($countries['id']); ?></option>
                                                <option value="<?php print_r($ulang['it']); ?>"><?php print_r($countries['it']); ?></option>
                                                <option value="<?php print_r($ulang['ja']); ?>"><?php print_r($countries['ja']); ?></option>
                                                <option value="<?php print_r($ulang['ka']); ?>"><?php print_r($countries['ka']); ?></option>
                                                <option value="<?php print_r($ulang['nl']); ?>"><?php print_r($countries['nl']); ?></option>
                                                <option value="<?php print_r($ulang['no']); ?>"><?php print_r($countries['no']); ?></option>
                                                <option value="<?php print_r($ulang['pl']); ?>"><?php print_r($countries['pl']); ?></option>
                                                <option value="<?php print_r($ulang['pt-BR']); ?>"><?php print_r($countries['pt-BR']); ?></option>
                                                <option value="<?php print_r($ulang['pt']); ?>"><?php print_r($countries['pt']); ?></option>
                                                <option value="<?php print_r($ulang['ro']); ?>"><?php print_r($countries['ro']); ?></option>
                                                <option value="<?php print_r($ulang['ru']); ?>"><?php print_r($countries['ru']); ?></option>
                                                <option value="<?php print_r($ulang['se']); ?>"><?php print_r($countries['se']); ?></option>
                                                <option value="<?php print_r($ulang['tr']); ?>"><?php print_r($countries['tr']); ?></option>
                                                <option value="<?php print_r($ulang['tw']); ?>"><?php print_r($countries['tw']); ?></option>
                                                <option value="<?php print_r($ulang['ua']); ?>"><?php print_r($countries['ua']); ?></option>
                                                <option value="<?php print_r($ulang['vi']); ?>"><?php print_r($countries['vi']); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Default To Admin</label>
                                        <div class="col-md-12">
                                            <div class="radio-info">
                                            <label class="radio-inline"><input value="true" type="radio" name="DEFAULT_TO_ADMIN" <?php if($config["DEFAULT_TO_ADMIN"] == 'true'){ echo 'checked'; } ?>/>Enabled</label>
                                            <label class="radio-inline"><input value="false" type="radio" name="DEFAULT_TO_ADMIN" <?php if($config["DEFAULT_TO_ADMIN"] == 'false'){ echo 'checked'; } ?>/>Disabled</label>
                                            </div><p style="line-height:2px">&nbsp;</p>
                                            <span class="help-block">Choose whether or not the admin should go to the admin panel or home after login.</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Vesta Host Address</label>  
                                        <div class="col-md-12">
                                            <input id="VESTA_HOST_ADDRESS" name="VESTA_HOST_ADDRESS" type="text" value="<?php echo $config["VESTA_HOST_ADDRESS"]; ?>" class="form-control input-md" required="">
                                            <span class="help-block">VestaCP Host URL or IP Address</span>  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Vesta SSL</label>
                                        <div class="col-md-12">
                                            <div class="radio-info">
                                            <label class="radio-inline"><input value="true" type="radio" name="VESTA_SSL_ENABLED" <?php if($config["VESTA_SSL_ENABLED"] == 'true'){ echo 'checked'; } ?>/>Enabled</label>
                                            <label class="radio-inline"><input value="false" type="radio" name="VESTA_SSL_ENABLED" <?php if($config["VESTA_SSL_ENABLED"] == 'false'){ echo 'checked'; } ?>/>Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="VESTA_PORT">Vesta Port</label>  
                                        <div class="col-md-12">
                                            <input id="VESTA_PORT" name="VESTA_PORT" type="text" value="<?php echo $vesta_port; ?>" class="form-control input-md">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="VESTA_ADMIN_UNAME">Vesta Admin Username</label>  
                                        <div class="col-md-12">
                                            <input id="VESTA_ADMIN_UNAME" name="VESTA_ADMIN_UNAME" type="text" value="<?php echo $vst_username; ?>" class="form-control input-md" required="">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="VESTA_ADMIN_PW">Vesta Admin Password</label>
                                        <div class="col-md-12">
                                            <input id="VESTA_ADMIN_PW" name="VESTA_ADMIN_PW" type="text" value="<?php echo $vst_password; ?>" class="form-control input-md" required="">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Current Icon:</label><br>
                                        <img src="../../plugins/images/<?php echo $cpicon; ?>" style="border:1px solid black;height: 40px;right: -20px;position: relative;"/>&nbsp;&nbsp;<img src="../../plugins/images/<?php echo $cpicon; ?>" style="background-color:black;height: 40px;right: -20px;position: relative;"/><br><br>
                                        <label class="col-md-12">New Icon:</label>
                                        <div class="col-md-12">
                                            <input name="ICON" id="file" accept=".png,.gif,.jpg,.jpeg" type="file" class="form-control input-md">
                                            <span class="help-block">Recommended 40x40px .png or .gif. (.png, .gif, .jpg, and .jpeg up to 1MB allowed.)</span>  
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Current Logo:</label><br>
                                        <img src="../../plugins/images/<?php echo $cplogo; ?>" style="border:1px solid black;height:60px;right: -20px;position: relative;"/>&nbsp;&nbsp;<img src="../../plugins/images/<?php echo $cplogo; ?>" style="background-color:black;height: 60px;right: -20px;position: relative;"/><br><br>
                                        <label class="col-md-12">New Logo:</label>
                                        <div class="col-md-12">
                                            <input name="LOGO" id="file2" accept=".png,.gif,.jpg,.jpeg" type="file" class="form-control input-md">
                                            <span class="help-block">Recommended 134x24px .png or .gif. (.png, .gif, .jpg, and .jpeg up to 1MB allowed.)</span>  
                                        </div>
                                    </div>
                                    
                                    <br><h3>Enable / Disable Sections</h3><br><hr><br>
                                    <div class="form-group">
                                        <label class="col-md-12">Web Enabled</label>
                                        <div class="col-md-12">
                                            <div class="radio-info">
                                            <label class="radio-inline"><input value="true" type="radio" name="ENABLE_WEB" <?php if($config["WEB_ENABLED"] == 'true'){ echo 'checked'; } ?>/>Enabled</label>
                                            <label class="radio-inline"><input value="false" type="radio" name="ENABLE_WEB" <?php if($config["WEB_ENABLED"] == 'false'){ echo 'checked'; } ?>/>Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">DNS Enabled</label>
                                        <div class="col-md-12">
                                            <div class="radio-info">
                                            <label class="radio-inline"><input value="true" type="radio" name="ENABLE_DNS" <?php if($config["DNS_ENABLED"] == 'true'){ echo 'checked'; } ?>/>Enabled</label>
                                            <label class="radio-inline"><input value="false" type="radio" name="ENABLE_DNS" <?php if($config["DNS_ENABLED"] == 'false'){ echo 'checked'; } ?>/>Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Mail Enabled</label>
                                        <div class="col-md-12">
                                            <div class="radio-info">
                                            <label class="radio-inline"><input value="true" type="radio" name="ENABLE_MAIL" <?php if($config["MAIL_ENABLED"] == 'true'){ echo 'checked'; } ?>/>Enabled</label>
                                            <label class="radio-inline"><input value="false" type="radio" name="ENABLE_MAIL" <?php if($config["MAIL_ENABLED"] == 'false'){ echo 'checked'; } ?>/>Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Database Enabled</label>
                                        <div class="col-md-12">
                                            <div class="radio-info">
                                            <label class="radio-inline"><input value="true" type="radio" name="ENABLE_DB" <?php if($config["DB_ENABLED"] == 'true'){ echo 'checked'; } ?>/>Enabled</label>
                                            <label class="radio-inline"><input value="false" type="radio" name="ENABLE_DB" <?php if($config["DB_ENABLED"] == 'false'){ echo 'checked'; } ?>/>Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Admin Panel Enabled</label>
                                        <div class="col-md-12">
                                            <div class="radio-info">
                                            <label class="radio-inline"><input value="true" type="radio" name="ENABLE_ADMIN" <?php if($config["ADMIN_ENABLED"] == 'true'){ echo 'checked'; } ?>/>Enabled</label>
                                            <label class="radio-inline"><input value="false" type="radio" name="ENABLE_ADMIN" <?php if($config["ADMIN_ENABLED"] == 'false'){ echo 'checked'; } ?>/>Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Profile Page Enabled</label>
                                        <div class="col-md-12">
                                            <div class="radio-info">
                                            <label class="radio-inline"><input value="true" type="radio" name="ENABLE_PROFILE" <?php if($config["PROFILE_ENABLED"] == 'true'){ echo 'checked'; } ?>/>Enabled</label>
                                            <label class="radio-inline"><input value="false" type="radio" name="ENABLE_PROFILE" <?php if($config["PROFILE_ENABLED"] == 'false'){ echo 'checked'; } ?>/>Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Cron Enabled</label>
                                        <div class="col-md-12">
                                            <div class="radio-info">
                                            <label class="radio-inline"><input value="true" type="radio" name="ENABLE_CRON" <?php if($config["CRON_ENABLED"] == 'true'){ echo 'checked'; } ?>/>Enabled</label>
                                            <label class="radio-inline"><input value="false" type="radio" name="ENABLE_CRON" <?php if($config["CRON_ENABLED"] == 'false'){ echo 'checked'; } ?>/>Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Backups Enabled</label>
                                        <div class="col-md-12">
                                            <div class="radio-info">
                                            <label class="radio-inline"><input value="true" type="radio" name="ENABLE_BACKUPS" <?php if($config["BACKUPS_ENABLED"] == 'true'){ echo 'checked'; } ?>/>Enabled</label>
                                            <label class="radio-inline"><input value="false" type="radio" name="ENABLE_BACKUPS" <?php if($config["BACKUPS_ENABLED"] == 'false'){ echo 'checked'; } ?>/>Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Registrations Enabled</label>
                                        <div class="col-md-12">
                                            <div class="radio-info">
                                            <label class="radio-inline"><input value="true" type="radio" name="ENABLE_REG" <?php if($config["REGISTRATIONS_ENABLED"] == 'true'){ echo 'checked'; } ?>/>Enabled</label>
                                            <label class="radio-inline"><input value="false" type="radio" name="ENABLE_REG" <?php if($config["REGISTRATIONS_ENABLED"] == 'false'){ echo 'checked'; } ?>/>Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Softaculous Enabled</label>
                                        <div class="col-md-12">
                                            <div class="radio-info">
                                            <label class="radio-inline"><input value="true" type="radio" name="ENABLE_SOFTURL" <?php if($config["SOFTACULOUS_URL"] == 'true'){ echo 'checked'; } ?>/>Enabled</label>
                                            <label class="radio-inline"><input value="false" type="radio" name="ENABLE_SOFTURL" <?php if($config["SOFTACULOUS_URL"] == 'false'){ echo 'checked'; } ?>/>Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Link to Old CP Enabled</label>
                                        <div class="col-md-12">
                                            <div class="radio-info">
                                            <label class="radio-inline"><input value="true" type="radio" name="ENABLE_OLDCPURL" <?php if($config["OLD_CP_LINK"] == 'true'){ echo 'checked'; } ?>/>Enabled</label>
                                            <label class="radio-inline"><input value="false" type="radio" name="ENABLE_OLDCPURL" <?php if($config["OLD_CP_LINK"] == 'false'){ echo 'checked'; } ?>/>Disabled</label>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                        <h3>Optional Links</h3><br><hr><br>
                                    <div class="form-group">
                                        <label class="col-md-12" for="FTP_URL">FTP Client URL</label>  
                                        <div class="col-md-12">
                                            <input id="FTP_URL" name="FTP_URL" type="text" value="<?php echo $config["FTP_URL"]; ?>" class="form-control input-md">
                                            <span class="help-block">Leave blank for default or enter 'disabled' to disable.</span> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="WEBMAIL_URL">Webmail URL</label>  
                                        <div class="col-md-12">
                                            <input id="WEBMAIL_URL" name="WEBMAIL_URL" type="text" value="<?php echo $config["WEBMAIL_URL"]; ?>" class="form-control input-md">
                                            <span class="help-block">Leave blank for default or enter 'disabled' to disable.</span>  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="PHPMYADMIN_URL">phpMyAdmin URL</label>  
                                        <div class="col-md-12">
                                            <input id="PHPMYADMIN_URL" name="PHPMYADMIN_URL" type="text" value="<?php echo $config["PHPMYADMIN_URL"]; ?>" class="form-control input-md">
                                            <span class="help-block">Leave blank for default or enter 'disabled' to disable.</span>  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="PHPPGADMIN_URL">phpPgAdmin URL</label>  
                                        <div class="col-md-12">
                                            <input id="PHPPGADMIN_URL" name="PHPPGADMIN_URL" type="text" value="<?php echo $config["PHPPGADMIN_URL"]; ?>" class="form-control input-md">
                                            <span class="help-block">Leave blank for default or enter 'disabled' to disable.</span>  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="SUPPORT_URL">Support URL</label>  
                                        <div class="col-md-12">
                                            <input id="SUPPORT_URL" name="SUPPORT_URL" type="text" value="<?php echo $config["SUPPORT_URL"]; ?>" class="form-control input-md">
                                            <span class="help-block">Leave blank or enter 'disabled' to disable.</span>  
                                        </div>
                                    </div>
                                    <br><h3>Optional Integrations</h3><br><hr><br>
                                    <div class="form-group">
                                        <label class="col-md-12" for="PLUGINS">Plugins</label>  
                                        <div class="col-md-12">
                                            <input id="PLUGINS" name="PLUGINS" type="text" value="<?php echo $config["PLUGINS"]; ?>" class="form-control input-md">
                                            <span class="help-block">Comma seperated list of installed plugins.</span>  
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="GOOGLE_ANALYTICS_ID">Google Analytics ID</label>  
                                        <div class="col-md-12">
                                            <input id="GOOGLE_ANALYTICS_ID" name="GOOGLE_ANALYTICS_ID" type="text" value="<?php echo $config["GOOGLE_ANALYTICS_ID"]; ?>" class="form-control input-md">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="INTERAKT_APP_ID">Interakt App ID</label>  
                                        <div class="col-md-12">
                                            <input id="INTERAKT_APP_ID" name="INTERAKT_APP_ID" type="text" value="<?php echo $config["INTERAKT_APP_ID"]; ?>" class="form-control input-md">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="INTERAKT_API_KEY">Interakt API Key</label>  
                                        <div class="col-md-12">
                                            <input id="INTERAKT_API_KEY" name="INTERAKT_API_KEY" type="text" value="<?php echo $config["INTERAKT_API_KEY"]; ?>" class="form-control input-md">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="CLOUDFLARE_API_KEY">Cloudflare API Key</label>  
                                        <div class="col-md-12">
                                            <input id="CLOUDFLARE_API_KEY" name="CLOUDFLARE_API_KEY" type="text" value="<?php echo $config["CLOUDFLARE_API_KEY"]; ?>" class="form-control input-md">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12" for="CLOUDFLARE_EMAIL">Cloudflare Account Email Address</label>  
                                        <div class="col-md-12">
                                            <input id="CLOUDFLARE_EMAIL" name="CLOUDFLARE_EMAIL" type="text" value="<?php echo $config["CLOUDFLARE_EMAIL"]; ?>" class="form-control input-md">

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" onclick="processLoader();"><?php echo _("Update Settings"); ?></button> &nbsp;
                                            <a href="../list/firewall.php" style="color: inherit;text-decoration: inherit;"><button class="btn btn-muted" type="button"><?php echo _("Back"); ?></button></a>
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
            $pluginlocation = "../../plugins/"; if(isset($pluginnames[0]) && $pluginnames[0] != '') { $currentplugin = 0; do { if (strtolower($pluginhide[$currentplugin]) != 'y' && strtolower($pluginhide[$currentplugin]) != 'yes') { if (strtolower($pluginadminonly[$currentplugin]) != 'y' && strtolower($pluginadminonly[$currentplugin]) != 'yes') { if (strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; } else { $currentstring = "<li><a href='".$pluginlocation.$pluginlinks[$currentplugin]."/'><i class='fa ".$pluginicons[$currentplugin]." fa-fw'></i><span class='hide-menu'>"._($pluginnames[$currentplugin])."</span></a></li>"; }} else { if(strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";} } else { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; }}} echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');\n var plugindata" . $currentplugin . " = \"" . $currentstring . "\";\n plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n"; } $currentplugin++; } while ($pluginnames[$currentplugin] != ''); } ?> 
        </script>
        <script type="text/javascript">
            var uploadField = document.getElementById("file");

            uploadField.onchange = function() {
                if(this.files[0].size > 1048576){
                   alert("Icon is too big! 1MB Limit.");
                   this.value = "";
                };
            };
            var uploadField2 = document.getElementById("file2");

            uploadField2.onchange = function() {
                if(this.files[0].size > 1048576){
                   alert("Logo is too big! 1MB Limit.");
                   this.value = "";
                };
            };
            
            $('.datepicker').datepicker();
            (function () {
                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                    new CBPFWTabs(el);
                });
            })(); 
            <?php echo 'document.getElementById("timeselect").value = \'' . $config["TIMEZONE"] . '\';';
                  echo 'document.getElementById("themeselect").value = \'' . $config["THEME"] . '\';';
                  echo 'document.getElementById("languageselect").value = \'' . $locale . '\';'; ?>
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
                    timer: 100000,
                    onOpen: function () {
                        swal.showLoading()
                    }
                })};
            <?php
            if(isset($_POST['r1']) && $_POST['r1'] == "0") {
                echo "swal({title:'" . _("Successfully Updated!") . "', type:'success'});";
            } 
            if(isset($_POST['r1']) && $_POST['r1'] > "0") { echo "swal({title:'Error Updating: " . $_POST['r1'] . ". Please Try Again.', type:'error'});";
                                                          }
            ?>
        </script>
    </body>
</html>