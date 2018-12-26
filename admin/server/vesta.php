<?php

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2018 Carter Roeser <carter@cdgtech.one>
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

session_start();
$configlocation = "../../includes/";
if (file_exists( '../../includes/config.php' )) { require( '../../includes/includes.php'); }  else { header( 'Location: ../../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../../login.php?to=admin/server/vesta.php'.$urlquery.$_SERVER['QUERY_STRING']); }
if($username != 'admin') { header("Location: ../../"); }

if(isset($adminenabled) && $adminenabled != 'true'){ header("Location: ../../error-pages/403.html"); }

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-sys-info','arg1' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-get-sys-timezone'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-sys-config','arg1' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-sys-vesta-ssl','arg1' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-backup-host','arg1' => 'ftp','arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-backup-host','arg1' => 'sftp','arg2' => 'json'));

$curl0 = curl_init();
$curl1 = curl_init();
$curl2 = curl_init();
$curl3 = curl_init();
$curl4 = curl_init();
$curl5 = curl_init();
$curl6 = curl_init();
$curlstart = 0; 


while($curlstart <= 6) {
    curl_setopt(${'curl' . $curlstart}, CURLOPT_URL, $vst_url);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_RETURNTRANSFER,true);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_POST, true);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
    $curlstart++;
} 

$admindata = json_decode(curl_exec($curl0), true)[$username];
$sysdata = array_values(json_decode(curl_exec($curl1), true));
$systimezone = curl_exec($curl2);
$sysconfig = array_values(json_decode(curl_exec($curl3), true));
$sysssl = array_values(json_decode(curl_exec($curl4), true));
$ftpconf = array_values(json_decode(curl_exec($curl5), true));
$sftpconf = array_values(json_decode(curl_exec($curl6), true));
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

$vcpservices = curl_init();
curl_setopt($vcpservices, CURLOPT_URL, $vst_url);
curl_setopt($vcpservices, CURLOPT_RETURNTRANSFER,true);
curl_setopt($vcpservices, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($vcpservices, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($vcpservices, CURLOPT_POST, true);
curl_setopt($vcpservices, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-sys-services', 'arg1' => 'json')));
$servicedata = curl_exec($vcpservices);

if( strpos( $servicedata, 'mysql' ) !== false ) { 

    $vcpmysql = curl_init();
    curl_setopt($vcpmysql, CURLOPT_URL, $vst_url);
    curl_setopt($vcpmysql, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($vcpmysql, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($vcpmysql, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($vcpmysql, CURLOPT_POST, true);
    curl_setopt($vcpmysql, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-database-host', 'arg1' => 'mysql', 'arg2' => 'localhost', 'arg3' => 'json')));
    $mysqldata = array_values(json_decode(curl_exec($vcpmysql), true))[0];
}

if( strpos( $servicedata, 'postgresql' ) !== false ) { 

    $vcppostgresql = curl_init();
    curl_setopt($vcppostgresql, CURLOPT_URL, $vst_url);
    curl_setopt($vcppostgresql, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($vcppostgresql, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($vcppostgresql, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($vcppostgresql, CURLOPT_POST, true);
    curl_setopt($vcppostgresql, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-database-host', 'arg1' => 'pgsql', 'arg2' => 'localhost', 'arg3' => 'json')));
    $pgsqldata = array_values(json_decode(curl_exec($vcppostgresql), true))[0];
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/ico" href="../../plugins/images/<?php echo $cpfavicon; ?>">
        <title><?php echo $sitetitle; ?> - <?php echo _("Server"); ?></title>
        <link href="../../plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../../plugins/components/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet">
        <link href="../../plugins/components/metismenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="../../plugins/components/select2/select2.min.css" rel="stylesheet">
        <link href="../../plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../plugins/components/sweetalert2/sweetalert2.min.css" />
        <link href="../../css/style.css" rel="stylesheet">
        <link href="../../css/colors/<?php if(isset($_COOKIE['theme']) && $themecolor != 'custom.css') { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <?php if($themecolor == "custom.css") { require( '../../css/colors/custom.php'); } ?>
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
                    </ul>
                    <ul class="nav navbar-top-links navbar-right pull-right">
                        <li>
                            <form class="app-search m-r-10" id="searchform" action="../../process/search.php" method="get">
                                <input type="text" placeholder="<?php echo _("Search..."); ?>" class="form-control" name="q"> <a href="javascript:void(0);" onclick="document.getElementById('searchform').submit();"><i class="fa fa-search"></i></a> </form>
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
                              adminMenu("../list/", "server");
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
                            <h4 class="page-title"><?php echo _("Configure Server"); ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                
                                <form class="form-horizontal form-material" method="post" id="form" action="../change/vesta.php">
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Hostname"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_hostname" value="<?php echo $sysdata[0]['HOSTNAME']; ?>" class="form-control form-control-line" required>
                                            <input type="hidden" name="v_hostname-x" value="<?php echo $sysdata[0]['HOSTNAME']; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group"  style="overflow: visible;">
                                        <label class="col-md-12">Timezone</label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_timezone-x" value="<?php echo preg_replace('/\s+/', '', $systimezone); ?>">
                                            <select id="timeselect" name="v_timezone" class="form-control select2">
                                                <option value="UTC">UTC (UTC+00:00)</option>
                                                <option value="HAST">HAST ((UTC-10:00)</option>
                                                <option value="HADT">HADT (UTC-10:00)</option>
                                                <option value="AKST">AKST (UTC-09:00)</option>
                                                <option value="AKDT">AKDT (UTC-09:00)</option>
                                                <option value="PST">PST (UTC-08:00)</option>
                                                <option value="PDT">PDT (UTC-08:00)</option>
                                                <option value="MST">MST (UTC-07:00)</option>
                                                <option value="MDT">MDT (UTC-07:00)</option>
                                                <option value="CST">CST (UTC-06:00)</option>
                                                <option value="CDT">CDT (UTC-06:00)</option>
                                                <option value="EST">EST (UTC-05:00)</option>
                                                <option value="EDT">EDT (UTC-05:00)</option>
                                                <option value="AST">AST (UTC+03:00)</option>
                                                <option value="ADT">ADT (UTC-04:00)</option>
                                                <option value="Africa/Abidjan">Africa/Abidjan (UTC+00:00)</option>
                                                <option value="Africa/Accra">Africa/Accra (UTC+00:00)</option>
                                                <option value="Africa/Addis_Ababa">Africa/Addis_Ababa (UTC+03:00)</option>
                                                <option value="Africa/Algiers">Africa/Algiers (UTC+01:00)</option>
                                                <option value="Africa/Asmara">Africa/Asmara (UTC+03:00)</option>
                                                <option value="Africa/Bamako">Africa/Bamako (UTC+00:00)</option>
                                                <option value="Africa/Bangui">Africa/Bangui (UTC+01:00)</option>
                                                <option value="Africa/Banjul">Africa/Banjul (UTC+00:00)</option>
                                                <option value="Africa/Bissau">Africa/Bissau (UTC+00:00)</option>
                                                <option value="Africa/Blantyre">Africa/Blantyre (UTC+02:00)</option>
                                                <option value="Africa/Brazzaville">Africa/Brazzaville (UTC+01:00)</option>
                                                <option value="Africa/Bujumbura">Africa/Bujumbura (UTC+02:00)</option>
                                                <option value="Africa/Cairo">Africa/Cairo (UTC+02:00)</option>
                                                <option value="Africa/Casablanca">Africa/Casablanca (UTC+01:00)</option>
                                                <option value="Africa/Ceuta">Africa/Ceuta (UTC+02:00)</option>
                                                <option value="Africa/Conakry">Africa/Conakry (UTC+00:00)</option>
                                                <option value="Africa/Dakar">Africa/Dakar (UTC+00:00)</option>
                                                <option value="Africa/Dar_es_Salaam">Africa/Dar_es_Salaam (UTC+03:00)</option>
                                                <option value="Africa/Djibouti">Africa/Djibouti (UTC+03:00)</option>
                                                <option value="Africa/Douala">Africa/Douala (UTC+01:00)</option>
                                                <option value="Africa/El_Aaiun">Africa/El_Aaiun (UTC+01:00)</option>
                                                <option value="Africa/Freetown">Africa/Freetown (UTC+00:00)</option>
                                                <option value="Africa/Gaborone">Africa/Gaborone (UTC+02:00)</option>
                                                <option value="Africa/Harare">Africa/Harare (UTC+02:00)</option>
                                                <option value="Africa/Johannesburg">Africa/Johannesburg (UTC+02:00)</option>
                                                <option value="Africa/Juba">Africa/Juba (UTC+03:00)</option>
                                                <option value="Africa/Kampala">Africa/Kampala (UTC+03:00)</option>
                                                <option value="Africa/Khartoum">Africa/Khartoum (UTC+03:00)</option>
                                                <option value="Africa/Kigali">Africa/Kigali (UTC+02:00)</option>
                                                <option value="Africa/Kinshasa">Africa/Kinshasa (UTC+01:00)</option>
                                                <option value="Africa/Lagos">Africa/Lagos (UTC+01:00)</option>
                                                <option value="Africa/Libreville">Africa/Libreville (UTC+01:00)</option>
                                                <option value="Africa/Lome">Africa/Lome (UTC+00:00)</option>
                                                <option value="Africa/Luanda">Africa/Luanda (UTC+01:00)</option>
                                                <option value="Africa/Lubumbashi">Africa/Lubumbashi (UTC+02:00)</option>
                                                <option value="Africa/Lusaka">Africa/Lusaka (UTC+02:00)</option>
                                                <option value="Africa/Malabo">Africa/Malabo (UTC+01:00)</option>
                                                <option value="Africa/Maputo">Africa/Maputo (UTC+02:00)</option>
                                                <option value="Africa/Maseru">Africa/Maseru (UTC+02:00)</option>
                                                <option value="Africa/Mbabane">Africa/Mbabane (UTC+02:00)</option>
                                                <option value="Africa/Mogadishu">Africa/Mogadishu (UTC+03:00)</option>
                                                <option value="Africa/Monrovia">Africa/Monrovia (UTC+00:00)</option>
                                                <option value="Africa/Nairobi">Africa/Nairobi (UTC+03:00)</option>
                                                <option value="Africa/Ndjamena">Africa/Ndjamena (UTC+01:00)</option>
                                                <option value="Africa/Niamey">Africa/Niamey (UTC+01:00)</option>
                                                <option value="Africa/Nouakchott">Africa/Nouakchott (UTC+00:00)</option>
                                                <option value="Africa/Ouagadougou">Africa/Ouagadougou (UTC+00:00)</option>
                                                <option value="Africa/Porto-Novo">Africa/Porto-Novo (UTC+01:00)</option>
                                                <option value="Africa/Sao_Tome">Africa/Sao_Tome (UTC+00:00)</option>
                                                <option value="Africa/Tripoli">Africa/Tripoli (UTC+02:00)</option>
                                                <option value="Africa/Tunis">Africa/Tunis (UTC+01:00)</option>
                                                <option value="Africa/Windhoek">Africa/Windhoek (UTC+01:00)</option>
                                                <option value="America/Adak">America/Adak (UTC-09:00)</option>
                                                <option value="America/Anchorage">America/Anchorage (UTC-08:00)</option>
                                                <option value="America/Anguilla">America/Anguilla (UTC-04:00)</option>
                                                <option value="America/Antigua">America/Antigua (UTC-04:00)</option>
                                                <option value="America/Araguaina">America/Araguaina (UTC-03:00)</option>
                                                <option value="America/Argentina/Buenos_Aires">America/Argentina/Buenos_Aires (UTC-03:00)</option>
                                                <option value="America/Argentina/Catamarca">America/Argentina/Catamarca (UTC-03:00)</option>
                                                <option value="America/Argentina/Cordoba">America/Argentina/Cordoba (UTC-03:00)</option>
                                                <option value="America/Argentina/Jujuy">America/Argentina/Jujuy (UTC-03:00)</option>
                                                <option value="America/Argentina/La_Rioja">America/Argentina/La_Rioja (UTC-03:00)</option>
                                                <option value="America/Argentina/Mendoza">America/Argentina/Mendoza (UTC-03:00)</option>
                                                <option value="America/Argentina/Rio_Gallegos">America/Argentina/Rio_Gallegos (UTC-03:00)</option>
                                                <option value="America/Argentina/Salta">America/Argentina/Salta (UTC-03:00)</option>
                                                <option value="America/Argentina/San_Juan">America/Argentina/San_Juan (UTC-03:00)</option>
                                                <option value="America/Argentina/San_Luis">America/Argentina/San_Luis (UTC-03:00)</option>
                                                <option value="America/Argentina/Tucuman">America/Argentina/Tucuman (UTC-03:00)</option>
                                                <option value="America/Argentina/Ushuaia">America/Argentina/Ushuaia (UTC-03:00)</option>
                                                <option value="America/Aruba">America/Aruba (UTC-04:00)</option>
                                                <option value="America/Asuncion">America/Asuncion (UTC-04:00)</option>
                                                <option value="America/Atikokan">America/Atikokan (UTC-05:00)</option>
                                                <option value="America/Bahia">America/Bahia (UTC-03:00)</option>
                                                <option value="America/Bahia_Banderas">America/Bahia_Banderas (UTC-05:00)</option>
                                                <option value="America/Barbados">America/Barbados (UTC-04:00)</option>
                                                <option value="America/Belem">America/Belem (UTC-03:00)</option>
                                                <option value="America/Belize">America/Belize (UTC-06:00)</option>
                                                <option value="America/Blanc-Sablon">America/Blanc-Sablon (UTC-04:00)</option>
                                                <option value="America/Boa_Vista">America/Boa_Vista (UTC-04:00)</option>
                                                <option value="America/Bogota">America/Bogota (UTC-05:00)</option>
                                                <option value="America/Boise">America/Boise (UTC-06:00)</option>
                                                <option value="America/Cambridge_Bay">America/Cambridge_Bay (UTC-06:00)</option>
                                                <option value="America/Campo_Grande">America/Campo_Grande (UTC-04:00)</option>
                                                <option value="America/Cancun">America/Cancun (UTC-05:00)</option>
                                                <option value="America/Caracas">America/Caracas (UTC-04:00)</option>
                                                <option value="America/Cayenne">America/Cayenne (UTC-03:00)</option>
                                                <option value="America/Cayman">America/Cayman (UTC-05:00)</option>
                                                <option value="America/Chicago">America/Chicago (UTC-05:00)</option>
                                                <option value="America/Chihuahua">America/Chihuahua (UTC-06:00)</option>
                                                <option value="America/Costa_Rica">America/Costa_Rica (UTC-06:00)</option>
                                                <option value="America/Creston">America/Creston (UTC-07:00)</option>
                                                <option value="America/Cuiaba">America/Cuiaba (UTC-04:00)</option>
                                                <option value="America/Curacao">America/Curacao (UTC-04:00)</option>
                                                <option value="America/Danmarkshavn">America/Danmarkshavn (UTC+00:00)</option>
                                                <option value="America/Dawson">America/Dawson (UTC-07:00)</option>
                                                <option value="America/Dawson_Creek">America/Dawson_Creek (UTC-07:00)</option>
                                                <option value="America/Denver">America/Denver (UTC-06:00)</option>
                                                <option value="America/Detroit">America/Detroit (UTC-04:00)</option>
                                                <option value="America/Dominica">America/Dominica (UTC-04:00)</option>
                                                <option value="America/Edmonton">America/Edmonton (UTC-06:00)</option>
                                                <option value="America/Eirunepe">America/Eirunepe (UTC-05:00)</option>
                                                <option value="America/El_Salvador">America/El_Salvador (UTC-06:00)</option>
                                                <option value="America/Fort_Nelson">America/Fort_Nelson (UTC-07:00)</option>
                                                <option value="America/Fortaleza">America/Fortaleza (UTC-03:00)</option>
                                                <option value="America/Glace_Bay">America/Glace_Bay (UTC-03:00)</option>
                                                <option value="America/Godthab">America/Godthab (UTC-02:00)</option>
                                                <option value="America/Goose_Bay">America/Goose_Bay (UTC-03:00)</option>
                                                <option value="America/Grand_Turk">America/Grand_Turk (UTC-04:00)</option>
                                                <option value="America/Grenada">America/Grenada (UTC-04:00)</option>
                                                <option value="America/Guadeloupe">America/Guadeloupe (UTC-04:00)</option>
                                                <option value="America/Guatemala">America/Guatemala (UTC-06:00)</option>
                                                <option value="America/Guayaquil">America/Guayaquil (UTC-05:00)</option>
                                                <option value="America/Guyana">America/Guyana (UTC-04:00)</option>
                                                <option value="America/Halifax">America/Halifax (UTC-03:00)</option>
                                                <option value="America/Havana">America/Havana (UTC-04:00)</option>
                                                <option value="America/Hermosillo">America/Hermosillo (UTC-07:00)</option>
                                                <option value="America/Indiana/Indianapolis">America/Indiana/Indianapolis (UTC-04:00)</option>
                                                <option value="America/Indiana/Knox">America/Indiana/Knox (UTC-05:00)</option>
                                                <option value="America/Indiana/Marengo">America/Indiana/Marengo (UTC-04:00)</option>
                                                <option value="America/Indiana/Petersburg">America/Indiana/Petersburg (UTC-04:00)</option>
                                                <option value="America/Indiana/Tell_City">America/Indiana/Tell_City (UTC-05:00)</option>
                                                <option value="America/Indiana/Vevay">America/Indiana/Vevay (UTC-04:00)</option>
                                                <option value="America/Indiana/Vincennes">America/Indiana/Vincennes (UTC-04:00)</option>
                                                <option value="America/Indiana/Winamac">America/Indiana/Winamac (UTC-04:00)</option>
                                                <option value="America/Inuvik">America/Inuvik (UTC-06:00)</option>
                                                <option value="America/Iqaluit">America/Iqaluit (UTC-04:00)</option>
                                                <option value="America/Jamaica">America/Jamaica (UTC-05:00)</option>
                                                <option value="America/Juneau">America/Juneau (UTC-08:00)</option>
                                                <option value="America/Kentucky/Louisville">America/Kentucky/Louisville (UTC-04:00)</option>
                                                <option value="America/Kentucky/Monticello">America/Kentucky/Monticello (UTC-04:00)</option>
                                                <option value="America/Kralendijk">America/Kralendijk (UTC-04:00)</option>
                                                <option value="America/La_Paz">America/La_Paz (UTC-04:00)</option>
                                                <option value="America/Lima">America/Lima (UTC-05:00)</option>
                                                <option value="America/Los_Angeles">America/Los_Angeles (UTC-07:00)</option>
                                                <option value="America/Lower_Princes">America/Lower_Princes (UTC-04:00)</option>
                                                <option value="America/Maceio">America/Maceio (UTC-03:00)</option>
                                                <option value="America/Managua">America/Managua (UTC-06:00)</option>
                                                <option value="America/Manaus">America/Manaus (UTC-04:00)</option>
                                                <option value="America/Marigot">America/Marigot (UTC-04:00)</option>
                                                <option value="America/Martinique">America/Martinique (UTC-04:00)</option>
                                                <option value="America/Matamoros">America/Matamoros (UTC-05:00)</option>
                                                <option value="America/Mazatlan">America/Mazatlan (UTC-06:00)</option>
                                                <option value="America/Menominee">America/Menominee (UTC-05:00)</option>
                                                <option value="America/Merida">America/Merida (UTC-05:00)</option>
                                                <option value="America/Metlakatla">America/Metlakatla (UTC-08:00)</option>
                                                <option value="America/Mexico_City">America/Mexico_City (UTC-05:00)</option>
                                                <option value="America/Miquelon">America/Miquelon (UTC-02:00)</option>
                                                <option value="America/Moncton">America/Moncton (UTC-03:00)</option>
                                                <option value="America/Monterrey">America/Monterrey (UTC-05:00)</option>
                                                <option value="America/Montevideo">America/Montevideo (UTC-03:00)</option>
                                                <option value="America/Montserrat">America/Montserrat (UTC-04:00)</option>
                                                <option value="America/Nassau">America/Nassau (UTC-04:00)</option>
                                                <option value="America/New_York">America/New_York (UTC-04:00)</option>
                                                <option value="America/Nipigon">America/Nipigon (UTC-04:00)</option>
                                                <option value="America/Nome">America/Nome (UTC-08:00)</option>
                                                <option value="America/Noronha">America/Noronha (UTC-02:00)</option>
                                                <option value="America/North_Dakota/Beulah">America/North_Dakota/Beulah (UTC-05:00)</option>
                                                <option value="America/North_Dakota/Center">America/North_Dakota/Center (UTC-05:00)</option>
                                                <option value="America/North_Dakota/New_Salem">America/North_Dakota/New_Salem (UTC-05:00)</option>
                                                <option value="America/Ojinaga">America/Ojinaga (UTC-06:00)</option>
                                                <option value="America/Panama">America/Panama (UTC-05:00)</option>
                                                <option value="America/Pangnirtung">America/Pangnirtung (UTC-04:00)</option>
                                                <option value="America/Paramaribo">America/Paramaribo (UTC-03:00)</option>
                                                <option value="America/Phoenix">America/Phoenix (UTC-07:00)</option>
                                                <option value="America/Port-au-Prince">America/Port-au-Prince (UTC-05:00)</option>
                                                <option value="America/Port_of_Spain">America/Port_of_Spain (UTC-04:00)</option>
                                                <option value="America/Porto_Velho">America/Porto_Velho (UTC-04:00)</option>
                                                <option value="America/Puerto_Rico">America/Puerto_Rico (UTC-04:00)</option>
                                                <option value="America/Rainy_River">America/Rainy_River (UTC-05:00)</option>
                                                <option value="America/Rankin_Inlet">America/Rankin_Inlet (UTC-05:00)</option>
                                                <option value="America/Recife">America/Recife (UTC-03:00)</option>
                                                <option value="America/Regina">America/Regina (UTC-06:00)</option>
                                                <option value="America/Resolute">America/Resolute (UTC-05:00)</option>
                                                <option value="America/Rio_Branco">America/Rio_Branco (UTC-05:00)</option>
                                                <option value="America/Santarem">America/Santarem (UTC-03:00)</option>
                                                <option value="America/Santiago">America/Santiago (UTC-03:00)</option>
                                                <option value="America/Santo_Domingo">America/Santo_Domingo (UTC-04:00)</option>
                                                <option value="America/Sao_Paulo">America/Sao_Paulo (UTC-03:00)</option>
                                                <option value="America/Scoresbysund">America/Scoresbysund (UTC+00:00)</option>
                                                <option value="America/Sitka">America/Sitka (UTC-08:00)</option>
                                                <option value="America/St_Barthelemy">America/St_Barthelemy (UTC-04:00)</option>
                                                <option value="America/St_Johns">America/St_Johns (UTC-02:30)</option>
                                                <option value="America/St_Kitts">America/St_Kitts (UTC-04:00)</option>
                                                <option value="America/St_Lucia">America/St_Lucia (UTC-04:00)</option>
                                                <option value="America/St_Thomas">America/St_Thomas (UTC-04:00)</option>
                                                <option value="America/St_Vincent">America/St_Vincent (UTC-04:00)</option>
                                                <option value="America/Swift_Current">America/Swift_Current (UTC-06:00)</option>
                                                <option value="America/Tegucigalpa">America/Tegucigalpa (UTC-06:00)</option>
                                                <option value="America/Thule">America/Thule (UTC-03:00)</option>
                                                <option value="America/Thunder_Bay">America/Thunder_Bay (UTC-04:00)</option>
                                                <option value="America/Tijuana">America/Tijuana (UTC-07:00)</option>
                                                <option value="America/Toronto">America/Toronto (UTC-04:00)</option>
                                                <option value="America/Tortola">America/Tortola (UTC-04:00)</option>
                                                <option value="America/Vancouver">America/Vancouver (UTC-07:00)</option>
                                                <option value="America/Whitehorse">America/Whitehorse (UTC-07:00)</option>
                                                <option value="America/Winnipeg">America/Winnipeg (UTC-05:00)</option>
                                                <option value="America/Yakutat">America/Yakutat (UTC-08:00)</option>
                                                <option value="America/Yellowknife">America/Yellowknife (UTC-06:00)</option>
                                                <option value="Antarctica/Casey">Antarctica/Casey (UTC+11:00)</option>
                                                <option value="Antarctica/Davis">Antarctica/Davis (UTC+07:00)</option>
                                                <option value="Antarctica/DumontDUrville">Antarctica/DumontDUrville (UTC+10:00)</option>
                                                <option value="Antarctica/Macquarie">Antarctica/Macquarie (UTC+11:00)</option>
                                                <option value="Antarctica/Mawson">Antarctica/Mawson (UTC+05:00)</option>
                                                <option value="Antarctica/McMurdo">Antarctica/McMurdo (UTC+12:00)</option>
                                                <option value="Antarctica/Palmer">Antarctica/Palmer (UTC-03:00)</option>
                                                <option value="Antarctica/Rothera">Antarctica/Rothera (UTC-03:00)</option>
                                                <option value="Antarctica/Syowa">Antarctica/Syowa (UTC+03:00)</option>
                                                <option value="Antarctica/Troll">Antarctica/Troll (UTC+02:00)</option>
                                                <option value="Antarctica/Vostok">Antarctica/Vostok (UTC+06:00)</option>
                                                <option value="Arctic/Longyearbyen">Arctic/Longyearbyen (UTC+02:00)</option>
                                                <option value="Asia/Aden">Asia/Aden [(UTC+03:00)</option>
                                                <option value="Asia/Almaty">Asia/Almaty (UTC+06:00)</option>
                                                <option value="Asia/Amman">Asia/Amman (UTC+03:00)</option>
                                                <option value="Asia/Anadyr">Asia/Anadyr (UTC+12:00)</option>
                                                <option value="Asia/Aqtau">Asia/Aqtau (UTC+05:00)</option>
                                                <option value="Asia/Aqtobe">Asia/Aqtobe (UTC+05:00)</option>
                                                <option value="Asia/Ashgabat">Asia/Ashgabat (UTC+05:00)</option>
                                                <option value="Asia/Atyrau">Asia/Atyrau (UTC+05:00)</option>
                                                <option value="Asia/Baghdad">Asia/Baghdad (UTC+03:00)</option>
                                                <option value="Asia/Bahrain">Asia/Bahrain (UTC+03:00)</option>
                                                <option value="Asia/Baku">Asia/Baku (UTC+04:00)</option>
                                                <option value="Asia/Bangkok">Asia/Bangkok (UTC+07:00)</option>
                                                <option value="Asia/Barnaul">Asia/Barnaul (UTC+07:00)</option>
                                                <option value="Asia/Beirut">Asia/Beirut (UTC+03:00)</option>
                                                <option value="Asia/Bishkek">Asia/Bishkek (UTC+06:00)</option>
                                                <option value="Asia/Brunei">Asia/Brunei (UTC+08:00)</option>
                                                <option value="Asia/Chita">Asia/Chita (UTC+09:00)</option>
                                                <option value="Asia/Choibalsan">Asia/Choibalsan (UTC+09:00)</option>
                                                <option value="Asia/Colombo">Asia/Colombo (UTC+05:30)</option>
                                                <option value="Asia/Damascus">Asia/Damascus (UTC+03:00)</option>
                                                <option value="Asia/Dhaka">Asia/Dhaka (UTC+06:00)</option>
                                                <option value="Asia/Dili">Asia/Dili (UTC+09:00)</option>
                                                <option value="Asia/Dubai">Asia/Dubai (UTC+04:00)</option>
                                                <option value="Asia/Dushanbe">Asia/Dushanbe (UTC+05:00)</option>
                                                <option value="Asia/Famagusta">Asia/Famagusta (UTC+03:00)</option>
                                                <option value="Asia/Gaza">Asia/Gaza (UTC+03:00)</option>
                                                <option value="Asia/Hebron">Asia/Hebron (UTC+03:00)</option>
                                                <option value="Asia/Ho_Chi_Minh">Asia/Ho_Chi_Minh (UTC+07:00)</option>
                                                <option value="Asia/Hong_Kong">Asia/Hong_Kong (UTC+08:00)</option>
                                                <option value="Asia/Hovd">Asia/Hovd (UTC+08:00)</option>
                                                <option value="Asia/Irkutsk">Asia/Irkutsk (UTC+08:00)</option>
                                                <option value="Asia/Jakarta">Asia/Jakarta (UTC+07:00)</option>
                                                <option value="Asia/Jayapura">Asia/Jayapura (UTC+09:00)</option>
                                                <option value="Asia/Jerusalem">Asia/Jerusalem (UTC+03:00)</option>
                                                <option value="Asia/Kabul">Asia/Kabul (UTC+04:30)</option>
                                                <option value="Asia/Kamchatka">Asia/Kamchatka (UTC+12:00)</option>
                                                <option value="Asia/Karachi">Asia/Karachi (UTC+05:00)</option>
                                                <option value="Asia/Kathmandu">Asia/Kathmandu (UTC+05:45)</option>
                                                <option value="Asia/Khandyga">Asia/Khandyga (UTC+09:00)</option>
                                                <option value="Asia/Kolkata">Asia/Kolkata (UTC+05:30)</option>
                                                <option value="Asia/Krasnoyarsk">Asia/Krasnoyarsk (UTC+07:00)</option>
                                                <option value="Asia/Kuala_Lumpur">Asia/Kuala_Lumpur (UTC+08:00)</option>
                                                <option value="Asia/Kuching">Asia/Kuching (UTC+08:00)</option>
                                                <option value="Asia/Kuwait">Asia/Kuwait (UTC+03:00)</option>
                                                <option value="Asia/Macau">Asia/Macau (UTC+08:00)</option>
                                                <option value="Asia/Magadan">Asia/Magadan (UTC+11:00)</option>
                                                <option value="Asia/Makassar">Asia/Makassar (UTC+08:00)</option>
                                                <option value="Asia/Manila">Asia/Manila (UTC+08:00)</option>
                                                <option value="Asia/Muscat">Asia/Muscat (UTC+04:00)</option>
                                                <option value="Asia/Nicosia">Asia/Nicosia (UTC+03:00)</option>
                                                <option value="Asia/Novokuznetsk">Asia/Novokuznetsk (UTC+07:00)</option>
                                                <option value="Asia/Novosibirsk">Asia/Novosibirsk (UTC+07:00)</option>
                                                <option value="Asia/Omsk">Asia/Omsk (UTC+06:00)</option>
                                                <option value="Asia/Oral">Asia/Oral (UTC+05:00)</option>
                                                <option value="Asia/Phnom_Penh">Asia/Phnom_Penh (UTC+07:00)</option>
                                                <option value="Asia/Pontianak">Asia/Pontianak (UTC+07:00)</option>
                                                <option value="Asia/Pyongyang">Asia/Pyongyang (UTC+08:30)</option>
                                                <option value="Asia/Qatar">Asia/Qatar (UTC+03:00)</option>
                                                <option value="Asia/Qyzylorda">Asia/Qyzylorda (UTC+06:00)</option>
                                                <option value="Asia/Riyadh">Asia/Riyadh (UTC+03:00)</option>
                                                <option value="Asia/Sakhalin">Asia/Sakhalin (UTC+11:00)</option>
                                                <option value="Asia/Samarkand">Asia/Samarkand (UTC+05:00)</option>
                                                <option value="Asia/Seoul">Asia/Seoul (UTC+09:00)</option>
                                                <option value="Asia/Shanghai">Asia/Shanghai (UTC+08:00)</option>
                                                <option value="Asia/Singapore">Asia/Singapore (UTC+08:00)</option>
                                                <option value="Asia/Srednekolymsk">Asia/Srednekolymsk (UTC+11:00)</option>
                                                <option value="Asia/Taipei">Asia/Taipei (UTC+08:00)</option>
                                                <option value="Asia/Tashkent">Asia/Tashkent (UTC+05:00)</option>
                                                <option value="Asia/Tbilisi">Asia/Tbilisi (UTC+04:00)</option>
                                                <option value="Asia/Tehran">Asia/Tehran (UTC+04:30)</option>
                                                <option value="Asia/Thimphu">Asia/Thimphu (UTC+06:00)</option>
                                                <option value="Asia/Tokyo">Asia/Tokyo (UTC+09:00)</option>
                                                <option value="Asia/Tomsk">Asia/Tomsk (UTC+07:00)</option>
                                                <option value="Asia/Ulaanbaatar">Asia/Ulaanbaatar (UTC+09:00)</option>
                                                <option value="Asia/Urumqi">Asia/Urumqi (UTC+06:00)</option>
                                                <option value="Asia/Ust-Nera">Asia/Ust-Nera (UTC+10:00)</option>
                                                <option value="Asia/Vientiane">Asia/Vientiane (UTC+07:00)</option>
                                                <option value="Asia/Vladivostok">Asia/Vladivostok (UTC+10:00)</option>
                                                <option value="Asia/Yakutsk">Asia/Yakutsk (UTC+09:00)</option>
                                                <option value="Asia/Yangon">Asia/Yangon (UTC+06:30)</option>
                                                <option value="Asia/Yekaterinburg">Asia/Yekaterinburg (UTC+05:00)</option>
                                                <option value="Asia/Yerevan">Asia/Yerevan (UTC+04:00)</option>
                                                <option value="Atlantic/Azores">Atlantic/Azores (UTC+00:00)</option>
                                                <option value="Atlantic/Bermuda">Atlantic/Bermuda (UTC-03:00)</option>
                                                <option value="Atlantic/Canary">Atlantic/Canary (UTC+01:00)</option>
                                                <option value="Atlantic/Cape_Verde">Atlantic/Cape_Verde (UTC-01:00)</option>
                                                <option value="Atlantic/Faroe">Atlantic/Faroe (UTC+01:00)</option>
                                                <option value="Atlantic/Madeira">Atlantic/Madeira (UTC+01:00)</option>
                                                <option value="Atlantic/Reykjavik">Atlantic/Reykjavik (UTC+00:00)</option>
                                                <option value="Atlantic/South_Georgia">Atlantic/South_Georgia (UTC-02:00)</option>
                                                <option value="Atlantic/St_Helena">Atlantic/St_Helena (UTC+00:00)</option>
                                                <option value="Atlantic/Stanley">Atlantic/Stanley (UTC-03:00)</option>
                                                <option value="Australia/Adelaide">Australia/Adelaide (UTC+09:30)</option>
                                                <option value="Australia/Brisbane">Australia/Brisbane (UTC+10:00)</option>
                                                <option value="Australia/Broken_Hill">Australia/Broken_Hill (UTC+09:30)</option>
                                                <option value="Australia/Currie">Australia/Currie (UTC+10:00)</option>
                                                <option value="Australia/Darwin">Australia/Darwin (UTC+09:30)</option>
                                                <option value="Australia/Eucla">Australia/Eucla (UTC+08:45)</option>
                                                <option value="Australia/Hobart">Australia/Hobart (UTC+10:00)</option>
                                                <option value="Australia/Lindeman">Australia/Lindeman (UTC+10:00)</option>
                                                <option value="Australia/Lord_Howe">Australia/Lord_Howe (UTC+10:30)</option>
                                                <option value="Australia/Melbourne">Australia/Melbourne (UTC+10:00)</option>
                                                <option value="Australia/Perth">Australia/Perth (UTC+08:00)</option>
                                                <option value="Australia/Sydney">Australia/Sydney (UTC+10:00)</option>
                                                <option value="Europe/Amsterdam">Europe/Amsterdam (UTC+02:00)</option>
                                                <option value="Europe/Andorra">Europe/Andorra (UTC+02:00)</option>
                                                <option value="Europe/Astrakhan">Europe/Astrakhan (UTC+04:00)</option>
                                                <option value="Europe/Athens">Europe/Athens (UTC+03:00)</option>
                                                <option value="Europe/Belgrade">Europe/Belgrade (UTC+02:00)</option>
                                                <option value="Europe/Berlin">Europe/Berlin (UTC+02:00)</option>
                                                <option value="Europe/Bratislava">Europe/Bratislava (UTC+02:00)</option>
                                                <option value="Europe/Brussels">Europe/Brussels (UTC+02:00)</option>
                                                <option value="Europe/Bucharest">Europe/Bucharest (UTC+03:00)</option>
                                                <option value="Europe/Budapest">Europe/Budapest (UTC+02:00)</option>
                                                <option value="Europe/Busingen">Europe/Busingen (UTC+02:00)</option>
                                                <option value="Europe/Chisinau">Europe/Chisinau (UTC+03:00)</option>
                                                <option value="Europe/Copenhagen">Europe/Copenhagen (UTC+02:00)</option>
                                                <option value="Europe/Dublin">Europe/Dublin (UTC+01:00)</option>
                                                <option value="Europe/Gibraltar">Europe/Gibraltar (UTC+02:00)</option>
                                                <option value="Europe/Guernsey">Europe/Guernsey (UTC+01:00)</option>
                                                <option value="Europe/Helsinki">Europe/Helsinki (UTC+03:00)</option>
                                                <option value="Europe/Isle_of_Man">Europe/Isle_of_Man (UTC+01:00)</option>
                                                <option value="Europe/Istanbul">Europe/Istanbul (UTC+03:00)</option>
                                                <option value="Europe/Jersey">Europe/Jersey(UTC+01:00)</option>
                                                <option value="Europe/Kaliningrad">Europe/Kaliningrad (UTC+02:00)</option>
                                                <option value="Europe/Kiev">Europe/Kiev (UTC+03:00)</option>
                                                <option value="Europe/Kirov">Europe/Kirov (UTC+03:00)</option>
                                                <option value="Europe/Lisbon">Europe/Lisbon (UTC+01:00)</option>
                                                <option value="Europe/Ljubljana">Europe/Ljubljana (UTC+02:00)</option>
                                                <option value="Europe/London">Europe/London (UTC+01:00)</option>
                                                <option value="Europe/Luxembourg">Europe/Luxembourg (UTC+02:00)</option>
                                                <option value="Europe/Madrid">Europe/Madrid (UTC+02:00)</option>
                                                <option value="Europe/Malta">Europe/Malta (UTC+02:00)</option>
                                                <option value="Europe/Mariehamn">Europe/Mariehamn (UTC+03:00)</option>
                                                <option value="Europe/Minsk">Europe/Minsk (UTC+03:00)</option>
                                                <option value="Europe/Monaco">Europe/Monaco (UTC+02:00)</option>
                                                <option value="Europe/Moscow">Europe/Moscow (UTC+03:00)</option>
                                                <option value="Europe/Oslo">Europe/Oslo (UTC+02:00)</option>
                                                <option value="Europe/Paris">Europe/Paris (UTC+02:00)</option>
                                                <option value="Europe/Podgorica">Europe/Podgorica (UTC+02:00)</option>
                                                <option value="Europe/Prague">Europe/Prague (UTC+02:00)</option>
                                                <option value="Europe/Riga">Europe/Riga (UTC+03:00)</option>
                                                <option value="Europe/Rome">Europe/Rome (UTC+02:00)</option>
                                                <option value="Europe/Samara">Europe/Samara (UTC+04:00)</option>
                                                <option value="Europe/San_Marino">Europe/San_Marino (UTC+02:00)</option>
                                                <option value="Europe/Sarajevo">Europe/Sarajevo (UTC+02:00)</option>
                                                <option value="Europe/Saratov">Europe/Saratov (UTC+04:00)</option>
                                                <option value="Europe/Simferopol">Europe/Simferopol (UTC+03:00)</option>
                                                <option value="Europe/Skopje">Europe/Skopje (UTC+02:00)</option>
                                                <option value="Europe/Sofia">Europe/Sofia (UTC+03:00)</option>
                                                <option value="Europe/Stockholm">Europe/Stockholm (UTC+02:00)</option>
                                                <option value="Europe/Tallinn">Europe/Tallinn (UTC+03:00)</option>
                                                <option value="Europe/Tirane">Europe/Tirane (UTC+02:00)</option>
                                                <option value="Europe/Ulyanovsk">Europe/Ulyanovsk (UTC+04:00)</option>
                                                <option value="Europe/Uzhgorod">Europe/Uzhgorod (UTC+03:00)</option>
                                                <option value="Europe/Vaduz">Europe/Vaduz (UTC+02:00)</option>
                                                <option value="Europe/Vatican">Europe/Vatican (UTC+02:00)</option>
                                                <option value="Europe/Vienna">Europe/Vienna (UTC+02:00)</option>
                                                <option value="Europe/Vilnius">Europe/Vilnius (UTC+03:00)</option>
                                                <option value="Europe/Volgograd">Europe/Volgograd (UTC+03:00)</option>
                                                <option value="Europe/Warsaw">Europe/Warsaw (UTC+02:00)</option>
                                                <option value="Europe/Zagreb">Europe/Zagreb (UTC+02:00)</option>
                                                <option value="Europe/Zaporozhye">Europe/Zaporozhye (UTC+03:00)</option>
                                                <option value="Europe/Zurich">Europe/Zurich (UTC+02:00)</option>
                                                <option value="Indian/Antananarivo">Indian/Antananarivo (UTC+03:00)</option>
                                                <option value="Indian/Chagos">Indian/Chagos (UTC+06:00)</option>
                                                <option value="Indian/Christmas">Indian/Christmas (UTC+07:00)</option>
                                                <option value="Indian/Cocos">Indian/Cocos (UTC+06:30)</option>
                                                <option value="Indian/Comoro">Indian/Comoro (UTC+03:00)</option>
                                                <option value="Indian/Kerguelen">Indian/Kerguelen (UTC+05:00)</option>
                                                <option value="Indian/Mahe">Indian/Mahe (UTC+04:00)</option>
                                                <option value="Indian/Maldives">Indian/Maldives (UTC+05:00)</option>
                                                <option value="Indian/Mauritius">Indian/Mauritius (UTC+04:00)</option>
                                                <option value="Indian/Mayotte">Indian/Mayotte (UTC+03:00)</option>
                                                <option value="Indian/Reunion">Indian/Reunion (UTC+04:00)</option>
                                                <option value="Pacific/Apia">Pacific/Apia (UTC+13:00)</option>
                                                <option value="Pacific/Auckland">Pacific/Auckland (UTC+12:00)</option>
                                                <option value="Pacific/Bougainville">Pacific/Bougainville (UTC+11:00)</option>
                                                <option value="Pacific/Chatham">Pacific/Chatham (UTC+12:45)</option>
                                                <option value="Pacific/Chuuk">Pacific/Chuuk (UTC+10:00)</option>
                                                <option value="Pacific/Easter">Pacific/Easter (UTC-05:00)</option>
                                                <option value="Pacific/Efate">Pacific/Efate (UTC+11:00)</option>
                                                <option value="Pacific/Enderbury">Pacific/Enderbury (UTC+13:00)</option>
                                                <option value="Pacific/Fakaofo">Pacific/Fakaofo (UTC+13:00)</option>
                                                <option value="Pacific/Fiji">Pacific/Fiji (UTC+12:00)</option>
                                                <option value="Pacific/Funafuti">Pacific/Funafuti (UTC+12:00)</option>
                                                <option value="Pacific/Galapagos">Pacific/Galapagos (UTC-06:00)</option>
                                                <option value="Pacific/Gambier">Pacific/Gambier (UTC-09:00)</option>
                                                <option value="Pacific/Guadalcanal">Pacific/Guadalcanal (UTC+11:00)</option>
                                                <option value="Pacific/Guam">Pacific/Guam (UTC+10:00)</option>
                                                <option value="Pacific/Honolulu">Pacific/Honolulu (UTC-10:00)</option>
                                                <option value="Pacific/Johnston">Pacific/Johnston (UTC-10:00)</option>
                                                <option value="Pacific/Kiritimati">Pacific/Kiritimati (UTC+14:00)</option>
                                                <option value="Pacific/Kosrae">Pacific/Kosrae (UTC+11:00)</option>
                                                <option value="Pacific/Kwajalein">Pacific/Kwajalein (UTC+12:00)</option>
                                                <option value="Pacific/Majuro">Pacific/Majuro (UTC+12:00)</option>
                                                <option value="Pacific/Marquesas">Pacific/Marquesas (UTC-09:30)</option>
                                                <option value="Pacific/Midway">Pacific/Midway (UTC-11:00)</option>
                                                <option value="Pacific/Nauru">Pacific/Nauru (UTC+12:00)</option>
                                                <option value="Pacific/Niue">Pacific/Niue (UTC-11:00)</option>
                                                <option value="Pacific/Norfolk">Pacific/Norfolk (UTC+11:00)</option>
                                                <option value="Pacific/Noumea">Pacific/Noumea (UTC+11:00)</option>
                                                <option value="Pacific/Pago_Pago">Pacific/Pago_Pago (UTC-11:00)</option>
                                                <option value="Pacific/Palau">Pacific/Palau (UTC+09:00)</option>
                                                <option value="Pacific/Pitcairn">Pacific/Pitcairn (UTC-08:00)</option>
                                                <option value="Pacific/Pohnpei">Pacific/Pohnpei (UTC+11:00)</option>
                                                <option value="Pacific/Port_Moresby">Pacific/Port_Moresby (UTC+10:00)</option>
                                                <option value="Pacific/Rarotonga">Pacific/Rarotonga (UTC-10:00)</option>
                                                <option value="Pacific/Saipan">Pacific/Saipan (UTC+10:00)</option>
                                                <option value="Pacific/Tahiti">Pacific/Tahiti (UTC-10:00)</option>
                                                <option value="Pacific/Tarawa">Pacific/Tarawa (UTC+12:00)</option>
                                                <option value="Pacific/Tongatapu">Pacific/Tongatapu (UTC+13:00)</option>
                                                <option value="Pacific/Wake">Pacific/Wake (UTC+12:00)</option>
                                                <option value="Pacific/Wallis">Pacific/Wallis (UTC+12:00)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" style="overflow: visible;">
                                        <label class="col-md-12"><?php echo _("Default Language"); ?></label>
                                        <div class="col-md-12">
                                            <input type="hidden" name="v_language-x" value="<?php print_r($sysconfig[0]["LANGUAGE"]); ?>">
                                            <select class="form-control select2" name="v_language" id="langselect">
                                                <option value="ar"><?php print_r($countries['ar']); ?></option>
                                                <option value="bs"><?php print_r($countries['bs']); ?></option>
                                                <option value="cn"><?php print_r($countries['cn']); ?></option>
                                                <option value="cz"><?php print_r($countries['cz']); ?></option>
                                                <option value="da"><?php print_r($countries['da']); ?></option>
                                                <option value="de"><?php print_r($countries['de']); ?></option>
                                                <option value="el"><?php print_r($countries['el']); ?></option>
                                                <option value="en"><?php print_r($countries['en']); ?></option>
                                                <option value="es"><?php print_r($countries['es']); ?></option>
                                                <option value="fa"><?php print_r($countries['fa']); ?></option>
                                                <option value="fi"><?php print_r($countries['fi']); ?></option>
                                                <option value="fr"><?php print_r($countries['fr']); ?></option>
                                                <option value="hu"><?php print_r($countries['hu']); ?></option>
                                                <option value="id"><?php print_r($countries['id']); ?></option>
                                                <option value="it"><?php print_r($countries['it']); ?></option>
                                                <option value="ja"><?php print_r($countries['ja']); ?></option>
                                                <option value="ka"><?php print_r($countries['ka']); ?></option>
                                                <option value="nl"><?php print_r($countries['nl']); ?></option>
                                                <option value="no"><?php print_r($countries['no']); ?></option>
                                                <option value="pl"><?php print_r($countries['pl']); ?></option>
                                                <option value="pt-BR"><?php print_r($countries['pt-BR']); ?></option>
                                                <option value="pt"><?php print_r($countries['pt']); ?></option>
                                                <option value="ro"><?php print_r($countries['ro']); ?></option>
                                                <option value="ru"><?php print_r($countries['ru']); ?></option>
                                                <option value="se"><?php print_r($countries['se']); ?></option>
                                                <option value="tr"><?php print_r($countries['tr']); ?></option>
                                                <option value="tw"><?php print_r($countries['tw']); ?></option>
                                                <option value="ua"><?php print_r($countries['ua']); ?></option>
                                                <option value="vi"><?php print_r($countries['vi']); ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group" id="toggle1" style="overflow:visible;">
                                        <a href="javascript:void(0);"><label class="col-md-12" style="cursor:pointer;"><?php echo _("Web"); ?> <span id="togglein1">&#9658;</span></label></a>
                                    </div>
                                    <div class="form-group" id="div1" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Proxy Server"); ?><?php if($sysconfig[0]['PROXY_SYSTEM'] == 'nginx') { echo ' / <a href="nginx.php">' . _("Configure") . '</a>'; } ?></label>
                                            <div class="col-md-12">
                                                <input type="text" disabled value="<?php if($sysconfig[0]['PROXY_SYSTEM'] != '') { echo $sysconfig[0]['PROXY_SYSTEM']; } else { echo 'None'; } ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Web Server"); ?></label>
                                            <div class="col-md-12">
                                                <input type="text" disabled value="<?php if($sysconfig[0]['WEB_SYSTEM'] != '') { echo $sysconfig[0]['WEB_SYSTEM']; } else { echo 'None'; } ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Backend Server"); ?> </label>
                                            <div class="col-md-12">
                                                <input type="text" disabled value="<?php if($sysconfig[0]['WEB_BACKEND'] != '') { echo $sysconfig[0]['WEB_BACKEND']; } else { echo 'None'; } ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="toggle2" style="overflow:visible;cursor:pointer;">
                                        <a href="javascript:void(0);"><label class="col-md-12" style="cursor:pointer;"><?php echo _("DNS"); ?> <span id="togglein2">&#9658;</span></label></a>
                                    </div>
                                    <div class="form-group" id="div2" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("DNS Server"); ?></label>
                                            <div class="col-md-12">
                                                <input type="text" disabled value="<?php if($sysconfig[0]['DNS_SYSTEM'] != '') { echo $sysconfig[0]['DNS_SYSTEM']; } else { echo 'None'; } ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow: visible;">
                                            <label class="col-md-12"><?php echo _("DNS Cluster"); ?></label>
                                            <div class="col-md-12">
                                                <select class="form-control select2" disabled id="dns-clusterselect">
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="toggle3" style="overflow:visible;cursor:pointer;">
                                        <a href="javascript:void(0);"><label class="col-md-12" style="cursor:pointer;"><?php echo _("Mail"); ?> <span id="togglein3">&#9658;</span></label></a>
                                    </div>
                                    <div class="form-group" id="div3" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Mail Server"); ?></label>
                                            <div class="col-md-12">
                                                <input type="text" disabled value="<?php if($sysconfig[0]['MAIL_SYSTEM'] != '') { echo $sysconfig[0]['MAIL_SYSTEM']; } else { echo "None"; } ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Antivirus"); ?></label>
                                            <div class="col-md-12">
                                                <input type="text" disabled value="<?php if($sysconfig[0]['ANTIVIRUS_SYSTEM'] != '') { echo $sysconfig[0]['ANTIVIRUS_SYSTEM']; } else { echo "None"; } ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Antispam"); ?></label>
                                            <div class="col-md-12">
                                                <input type="text" disabled value="<?php if($sysconfig[0]['ANTISPAM_SYSTEM'] != '') { echo $sysconfig[0]['ANTISPAM_SYSTEM']; } else { echo "None"; } ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group" id="toggle4" style="overflow:visible;cursor:pointer;">
                                        <a href="javascript:void(0);"><label class="col-md-12" style="cursor:pointer;"><?php echo _("DB"); ?> <span id="togglein4">&#9658;</span></label></a>
                                    </div>
                                    <div class="form-group" id="div4" style="margin-left: 4%;">
                                        <div class="form-group" style="overflow: visible;">
                                            <label class="col-md-12"><?php echo _("MySQL Support"); ?></label>
                                            <div class="col-md-12">
                                                <select class="form-control select2" disabled id="mysql">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <?php if( strpos( $servicedata, 'mysql' ) !== false ) { echo '
                                        <div class="form-group" id="div13" style="margin-left: 4%;">
                                                <div class="form-group">
                                                    <label class="col-md-12">' .  _("Host") . '</label>
                                                    <div class="col-md-12">
                                                        <input type="text" disabled value="' . $mysqldata["HOST"]. '" class="form-control form-control-line"> 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12">' . _("Password") . '</label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="v_mysql_root_pw" value="" class="form-control form-control-line"> 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12">' ._("Maximum Number of Databases").'</label>
                                                    <div class="col-md-12">
                                                        <input type="text" disabled value="'.$mysqldata["MAX_DB"].'" class="form-control form-control-line"> 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12">' . _("Current Number of Databases") . '</label>
                                                    <div class="col-md-12">
                                                        <input type="text" disabled value="'. $mysqldata["U_DB_BASES"].'" class="form-control form-control-line"> 
                                                    </div>
                                                </div>
                                            </div>';
                            } ?>
                                        <div class="form-group" style="overflow: visible;">
                                            <label class="col-md-12"><?php echo _("PostgreSQL Support"); ?></label>
                                            <div class="col-md-12">
                                                <select class="form-control select2" disabled id="postgresql">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <?php if( strpos( $servicedata, 'postgresql' ) !== false ) { echo '<div class="form-group" id="div14" style="margin-left: 4%;">
                                                <div class="form-group">
                                                    <label class="col-md-12">' . _("Host") . '</label>
                                                    <div class="col-md-12">
                                                        <input type="text" disabled value="'.$pgsqldata["HOST"].'" class="form-control form-control-line"> 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12">' . _("Password") . '</label>
                                                    <div class="col-md-12">
                                                        <input type="text" name="v_pgsql_root_pw" value="" class="form-control form-control-line"> 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12">' ._("Maximum Number of Databases"). '</label>
                                                    <div class="col-md-12">
                                                        <input type="text" disabled value="'. $pgsqldata["MAX_DB"].'" class="form-control form-control-line"> 
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-12">'._("Current Number of Databases").'</label>
                                                    <div class="col-md-12">
                                                        <input type="text" disabled value="'. $pgsqldata["U_DB_BASES"].'" class="form-control form-control-line"> 
                                                    </div>
                                                </div>
                                                
                                            </div>'; } ?>
                                        </div>
                                    <div class="form-group" id="toggle5" style="overflow:visible;cursor:pointer;">
                                        <a href="javascript:void(0);"><label class="col-md-12" style="cursor:pointer;"><?php echo _("Backup"); ?> <span id="togglein5">&#9658;</span></label></a>
                                    </div>
                                    <div class="form-group" id="div5" style="margin-left: 4%;">
                                        <div class="form-group" style="overflow: visible;">
                                            <label class="col-md-12"><?php echo _("Local Backup"); ?></label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_backupsystem-x" value="<?php if (strpos($sysconfig[0]["BACKUP_SYSTEM"], 'local') !== false) { echo 'yes'; } else { echo 'no'; } ?>">
                                                <select class="form-control select2" name="v_backupsystem" id="backup-localselect">
                                                    <option value="yes">Yes</option>
                                                    <option value="no">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" style="overflow: visible;">
                                            <label class="col-md-12"><?php echo _("Compression Level"); ?></label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_backupgzip-x" value="<?php echo $sysconfig[0]["BACKUP_GZIP"]; ?>">
                                                <select class="form-control select2" name="v_backupgzip" id="backup-compselect">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Directory"); ?></label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_backupdir-x" value="<?php echo $sysconfig[0]["BACKUP"]; ?>">
                                                <input type="text" name="v_backupdir" value="<?php if($sysconfig[0]['BACKUP'] != '') { echo $sysconfig[0]['BACKUP']; } else { echo '/backup'; } ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                        <?php /*
                                        <div class="form-group" id="toggle51" style="overflow:visible;cursor:pointer;">
                                            <a href="javascript:void(0);"><label class="col-md-12" style="cursor:pointer;"><?php echo _("Remote Backup"); ?> <span id="togglein51">&#9658;</span></label></a>
                                        </div>
                                        <div class="form-group" id="div51" style="margin-left: 4%;">
                                            <div class="form-group" style="overflow: visible;">
                                            <label class="col-md-12"><?php echo _("Protocol"); ?></label>
                                            <div class="col-md-12">
                                                <select class="form-control select2" id="backup-remoteselect">
                                                    <option value="ftp">FTP</option>
                                                    <option value="sftp">SFTP</option>
                                                </select>
                                            </div>
                                        </div>
                                            <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Host"); ?></label>
                                            <div class="col-md-12">
                                                <input type="text" value="<?php if (strpos($sysconfig[0]["BACKUP_SYSTEM"], 'sftp') !== false) { echo $sftpconf[0]["HOST"]; } else { echo $ftpconf[0]["HOST"]; } ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                            <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Username"); ?></label>
                                            <div class="col-md-12">
                                                <input type="text" value="<?php if (strpos($sysconfig[0]["BACKUP_SYSTEM"], 'sftp') !== false) { echo $sftpconf[0]["USERNAME"]; } else { echo $ftpconf[0]["USERNAME"]; } ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                            <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Password"); ?></label>
                                            <div class="col-md-12">
                                                <input type="text" value="" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                            <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Directory"); ?></label>
                                            <div class="col-md-12">
                                                <input type="text" value="<?php if (strpos($sysconfig[0]["BACKUP_SYSTEM"], 'sftp') !== false) { echo $sftpconf[0]["BPATH"]; } else { echo $ftpconf[0]["BPATH"]; } ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                        </div>
                                     */ ?>
                                        </div>
                                    <div class="form-group" id="toggle6" style="overflow:visible;cursor:pointer;">
                                        <a href="javascript:void(0);"><label class="col-md-12" style="cursor:pointer;"><?php echo _("Vesta SSL"); ?> <span id="togglein6">&#9658;</span></label></a>
                                    </div>
                                    <div class="form-group" id="div6" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("SSL Certificate"); ?></label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_sslcrt-x" value="<?php echo $sysssl[0]['CRT']; ?>">
                                                <textarea class="form-control" rows="4" class="form-control form-control-static" name="v_sslcrt" <?php if($apienabled == 'true'){ echo "disabled"; } ?>><?php print_r($sysssl[0]['CRT']); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("SSL Key"); ?></label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_sslkey-x" value="<?php echo $sysssl[0]['KEY']; ?>">
                                                <textarea class="form-control" rows="4" class="form-control form-control-static" name="v_sslkey" <?php if($apienabled == 'true'){ echo "disabled"; } ?>><?php print_r($sysssl[0]['KEY']); ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group" style="margin-left: 0.1%;display:<?php if($sysssl[0]['NOT_BEFORE'] != ''){echo 'block';} else { echo 'none';} ?>">
                                            <ul class="list-unstyled">
                                                <li><?php echo _("Subject"); ?>:  <?php print_r($sysssl[0]['SUBJECT']); ?></li>
                                                <li><?php echo _("Aliases"); ?>:  <?php print_r($sysssl[0]['ALIASES']); ?></li>
                                                <li><?php echo _("Not Before"); ?>:  <?php print_r($sysssl[0]['NOT_BEFORE']); ?></li>
                                                <li><?php echo _("Not After"); ?>:  <?php print_r($sysssl[0]['NOT_AFTER']); ?></li>
                                                <li><?php echo _("Signature"); ?>:  <?php print_r($sysssl[0]['SIGNATURE']); ?></li>
                                                <li><?php echo _("Pub Key"); ?>:  <?php print_r($sysssl[0]['PUB_KEY']); ?></li>
                                                <li><?php echo _("Issuer"); ?>:  <?php print_r($sysssl[0]['ISSUER']); ?></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="form-group" id="toggle7" style="overflow:visible;cursor:pointer;">
                                        <a href="javascript:void(0);"><label class="col-md-12" style="cursor:pointer;"><?php echo _("Vesta Control Panel Plugins"); ?> <span id="togglein7">&#9658;</span></label></a>
                                    </div>
                                    <div class="form-group" id="div7" style="margin-left: 4%;">
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Version"); ?></label>
                                            <div class="col-md-12">
                                                <input type="text" disabled value="<?php echo $sysconfig[0]['VERSION']; ?>" class="form-control form-control-line"> 
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("FileSystem Disk Quota"); ?></label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_quota-x" value="<?php print_r($sysconfig[0]["DISK_QUOTA"]); ?>">
                                                <select class="form-control select2" name="v_quota" id="diskquota">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Firewall"); ?></label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_firewall-x" value="<?php if($sysconfig[0]["FIREWALL_SYSTEM"] != '' && $sysconfig[0]["FIREWALL_SYSTEM"] != 'no') { echo 'yes'; } else { echo 'no'; } ?>">
                                                <select class="form-control select2" name="v_firewall" id="firewall">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Reseller Role"); ?></label>
                                            <div class="col-md-12">
                                                <select class="form-control select2" disabled id="resellerrole">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Backup Migration Manager"); ?></label>
                                            <div class="col-md-12">
                                                <select class="form-control select2" disabled id="backupmigration">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                        <label class="col-md-12"><?php echo _("SFTP Chroot"); ?></label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_sftpjail-x" value="<?php if($sysconfig[0]["SFTPJAIL_KEY"] != '') {echo 'yes'; } else { echo 'no'; } ?>">
                                                <select class="form-control select2" name="v_sftpjail" id="sftpchroot">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="div10" style="margin-left: 4%;">
                                            <p><?php echo _("Restrict users so that they cannot use SSH and access only their home directory. This is a commercial module, you would need to purchace license key to enable it."); ?></p>
                                            <input type="hidden" name="v_sftpjail-key-x" value="<?php echo $sysconfig[0]["SFTPJAIL_KEY"]; ?>">
                                            <?php if($sysconfig[0]["SFTPJAIL_KEY"] != '') {echo '<div class="form-group">
                                                <label class="col-md-12">' . _("License Key") . '</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="v_sftpjail-key" value="' . $sysconfig[0]["SFTPJAIL_KEY"] . '" class="form-control form-control-line"> 
                                                </div>
                                            </div>'; }
                                            else { echo '<div class="form-group">
                                                <label class="col-md-12">' . _("Enter License Key") . '</label>
                                                <div class="col-md-12">
                                                    <input type="text" value="" name="v_sftpjail-key" class="form-control form-control-line"> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <a href="https://vestacp.com/checkout/2co.php?product_id=6&referer=' . $_SERVER['HTTP_HOST'] . '" style="color: inherit;text-decoration: inherit;"><button class="btn btn-success" type="button">' . _("Buy License $3/Month") . '</button></a>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                      <a href="https://vestacp.com/checkout/2co.php?product_id=9&referer=' . $_SERVER['HTTP_HOST'] . '" style="color: inherit;text-decoration: inherit;"><button class="btn btn-success" type="button">' . _("Buy Lifetime License $18") . '</button></a>
                                                </div>
                                            </div>
                                            <span class="help-block">' . _("2Checkout.com Inc. (Ohio, USA) is a payment facilitator for goods and services provided by vestacp.com.") . '</span>'; } ?>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("File Manager"); ?></label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_filemanager-x" value="<?php echo $sysconfig[0]["FILEMANAGER_KEY"]; ?>">
                                                <select class="form-control select2" name="v_filemanager" id="filemanager">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="div11" style="margin-left: 4%;">
                                            <p><?php echo _("Browse, copy, edit, view, and retrieve all of your web domain files using fully featured File Manager. This is a commercial module, you would need to purchace license key to enable it."); ?></p>
                                            <input type="hidden" name="v_filemanager-key-x" value="<?php if($sysconfig[0]["FILEMANAGER_KEY"] != '') { echo 'yes'; } else { echo 'no'; } ?>">
                                            <?php if($sysconfig[0]["FILEMANAGER_KEY"] != '') { echo '<div class="form-group">
                                                <label class="col-md-12">' . _("License Key") . '</label>
                                                <div class="col-md-12">
                                                    <input type="text" name="v_filemanager-key" value="' . $sysconfig[0]["FILEMANAGER_KEY"] . '" class="form-control form-control-line"> 
                                                </div>
                                            </div>'; }
                                            else { echo '<div class="form-group">
                                                <label class="col-md-12">' . _("Enter License Key") . '</label>
                                                <div class="col-md-12">
                                                    <input type="text" value="" name="v_filemanager-key" class="form-control form-control-line"> 
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <a href="https://vestacp.com/checkout/2co.php?product_id=7&referer=' . $_SERVER['HTTP_HOST'] . '" style="color: inherit;text-decoration: inherit;"><button class="btn btn-success" type="button">' . _("Buy License $5/Month") . '</button></a>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                      <a href="https://vestacp.com/checkout/2co.php?product_id=8&referer=' . $_SERVER['HTTP_HOST'] . '" style="color: inherit;text-decoration: inherit;"><button class="btn btn-success" type="button">' . _("Buy Lifetime License $50") . '</button></a>
                                                </div>
                                            </div>
                                            <span class="help-block">' . _("2Checkout.com Inc. (Ohio, USA) is a payment facilitator for goods and services provided by vestacp.com.") . '</span>'; } ?>
                                              
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Softaculous"); ?></label>
                                            <div class="col-md-12">
                                                <input type="hidden" name="v_softaculous-x" value="<?php echo $sysconfig[0]["BACKUP"]; ?>">
                                                <select class="form-control select2" name="v_softaculous" id="softaculous">
                                                    <option value="no">No</option>
                                                    <option value="yes">Yes</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="div12" style="margin-left: 4%;">
                                            <p>* <?php echo _("Plugin installation will run in background."); ?><br><br><?php echo _("Softaculous is a great Auto Installer having 426 great scripts, 1115 PHP Classes and we are still adding more. Softaculous is ideal for Web Hosting companies and it could give a significant boost to your sales. These scripts cover most of the uses a customer could ever have. We have covered a wide array of Categories so that everyone could find the required script one would need to power their Web Site."); ?></p>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                      <a href="https://www.softaculous.com/softaculous/" style="color: inherit;text-decoration: inherit;"><button class="btn btn-success" type="button"><?php echo _("Get Premium License"); ?></button></a>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" type="submit"><?php echo _("Save"); ?></button> &nbsp;
                                            <a href="../list/server.php" style="color: inherit;text-decoration: inherit;"><button onclick="loadLoader();" class="btn btn-muted" type="button"><?php echo _("Back"); ?></button></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script> 
                    function submitForm() { document.getElementById("form").submit(); };
                    function exitForm() { window.location.href="../list/server.php"; };
                </script>
                <?php hotkeys($configlocation); ?>
                <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../../includes/versioncheck.php'; ?> <?php echo _("by Carter Roeser"); ?>.</footer>
            </div>
        </div>
        <script src="../../plugins/components/jquery/jquery.min.js"></script>
        <script src="../../plugins/components/jquery-toast-plugin/jquery.toast.min.js"></script>
        <script src="../../plugins/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../../plugins/components/sweetalert2/sweetalert2.min.js"></script>
        <script src="../../plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../../plugins/components/metismenu/dist/metisMenu.min.js"></script>
        <script src="../../plugins/components/select2/select2.min.js"></script>
        <script src="../../plugins/components/waves/waves.js"></script>
        <script src="../../js/main.js"></script>
        <script type="text/javascript">
            Waves.attach('.button', ['waves-effect']);
            Waves.init();
            
            <?php 
            $pluginlocation = "../../plugins/"; if(isset($pluginnames[0]) && $pluginnames[0] != '') { $currentplugin = 0; do { if (strtolower($pluginhide[$currentplugin]) != 'y' && strtolower($pluginhide[$currentplugin]) != 'yes') { if (strtolower($pluginadminonly[$currentplugin]) != 'y' && strtolower($pluginadminonly[$currentplugin]) != 'yes') { if (strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; } else { $currentstring = "<li><a href='".$pluginlocation.$pluginlinks[$currentplugin]."/'><i class='fa ".$pluginicons[$currentplugin]." fa-fw'></i><span class='hide-menu'>"._($pluginnames[$currentplugin])."</span></a></li>"; }} else { if(strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";} } else { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; }}} echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');\n var plugindata" . $currentplugin . " = \"" . $currentstring . "\";\n plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n"; } $currentplugin++; } while ($pluginnames[$currentplugin] != ''); } ?> 

            $('#form').submit(function(ev) {
                ev.preventDefault();
                processLoader();
                this.submit();
            });
            $('#div1').hide();
            $( "#toggle1" ).click(function() {     
                if($('#div1:visible').length) {
                    $('#div1').hide();
                    document.getElementById('togglein1').innerHTML = '&#9658;';
                }
                else {
                    $('#div1').show();
                    document.getElementById('togglein1').innerHTML = '&#9660;';
                }
            });
             $('#div2').hide();
            $( "#toggle2" ).click(function() {     
                if($('#div2:visible').length) {
                    $('#div2').hide();
                    document.getElementById('togglein2').innerHTML = '&#9658;';
                }
                else {
                    $('#div2').show();
                    document.getElementById('togglein2').innerHTML = '&#9660;';
                }
            });
             $('#div3').hide();
            $( "#toggle3" ).click(function() {     
                if($('#div3:visible').length) {
                    $('#div3').hide();
                    document.getElementById('togglein3').innerHTML = '&#9658;';
                }
                else {
                    $('#div3').show();
                    document.getElementById('togglein3').innerHTML = '&#9660;';
                }
            });
             $('#div4').hide();
            $( "#toggle4" ).click(function() {     
                if($('#div4:visible').length) {
                    $('#div4').hide();
                    document.getElementById('togglein4').innerHTML = '&#9658;';
                }
                else {
                    $('#div4').show();
                    document.getElementById('togglein4').innerHTML = '&#9660;';
                }
            });
             $('#div5').hide();
            $( "#toggle5" ).click(function() {     
                if($('#div5:visible').length) {
                    $('#div5').hide();
                    document.getElementById('togglein5').innerHTML = '&#9658;';
                }
                else {
                    $('#div5').show();
                    document.getElementById('togglein5').innerHTML = '&#9660;';
                }
            });
            /*
            $('#div51').hide();
            $( "#toggle51" ).click(function() {     
                if($('#div51:visible').length) {
                    $('#div51').hide();
                    document.getElementById('togglein51').innerHTML = '&#9658;';
                }
                else {
                    $('#div51').show();
                    document.getElementById('togglein51').innerHTML = '&#9660;';
                }
            }); */
             $('#div6').hide();
            $( "#toggle6" ).click(function() {     
                if($('#div6:visible').length) {
                    $('#div6').hide();
                    document.getElementById('togglein6').innerHTML = '&#9658;';
                }
                else {
                    $('#div6').show();
                    document.getElementById('togglein6').innerHTML = '&#9660;';
                }
            });
             $('#div7').hide();
            $( "#toggle7" ).click(function() {     
                if($('#div7:visible').length) {
                    $('#div7').hide();
                    document.getElementById('togglein7').innerHTML = '&#9658;';
                }
                else {
                    $('#div7').show();
                    document.getElementById('togglein7').innerHTML = '&#9660;';
                }
            });
            document.getElementById('sftpchroot').value = '<?php if($sysconfig[0]["SFTPJAIL_KEY"] != '') { echo 'yes'; } else { echo 'no'; } ?>';  
            $(function () {
                var val = $("#sftpchroot").val();
                if(val === "yes") {
                    $("#div10").show();
                }
                else if(val != "yes") {
                    $("#div10").hide();
                }
              });
            $(function () {
              $("#sftpchroot").change(function() {
                var val1 = $(this).val();
                if(val1 === "yes") {
                    $("#div10").show();
                }
                else if(val1 != "custom") {
                    $("#div10").hide();
                }
              });
            });
            document.getElementById('filemanager').value = '<?php if($sysconfig[0]["FILEMANAGER_KEY"] != '') { echo 'yes'; } else { echo 'no'; } ?>';   
            $(function () {
                var val = $("#filemanager").val();
                if(val === "yes") {
                    $("#div11").show();
                }
                else if(val != "yes") {
                    $("#div11").hide();
                }
              });
            $(function () {
              $("#filemanager").change(function() {
                var val1 = $(this).val();
                if(val1 === "yes") {
                    $("#div11").show();
                }
                else if(val1 != "custom") {
                    $("#div11").hide();
                }
              });
            });
            document.getElementById('softaculous').value = '<?php if($sysconfig[0]["SOFTACULOUS"] != '' && $sysconfig[0]["SOFTACULOUS"] != 'no') { echo 'yes'; } else { echo "no"; } ?>';  
            $(function () {
                var val = $("#softaculous").val();
                if(val === "yes") {
                    $("#div12").show();
                }
                else if(val != "yes") {
                    $("#div12").hide();
                }
              });
            $(function () {
              $("#softaculous").change(function() {
                var val1 = $(this).val();
                if(val1 === "yes") {
                    $("#div12").show();
                }
                else if(val1 != "custom") {
                    $("#div12").hide();
                }
              });
            });
            
            <?php 
            $systimezone = preg_replace('/\s+/', '', $systimezone);
            echo 'document.getElementById("timeselect").value = \'' . $systimezone . '\';'; 
            ?>
            document.getElementById('langselect').value = '<?php print_r($sysconfig[0]["LANGUAGE"]); ?>'; 
            document.getElementById('backup-localselect').value = '<?php if (strpos($sysconfig[0]["BACKUP_SYSTEM"], 'local') !== false) {
    echo 'yes'; } else { echo 'no'; } ?>';  
           <?php /* document.getElementById('backup-remoteselect').value = '<?php if (strpos($sysconfig[0]["BACKUP_SYSTEM"], 'sftp') !== false) {
    echo 'sftp'; } if (strpos($sysconfig[0]["BACKUP_SYSTEM"], 'ftp') !== false) {
    echo 'ftp'; } ?>'; */ ?>  
            document.getElementById('backup-compselect').value = '<?php print_r($sysconfig[0]["BACKUP_GZIP"]); ?>';  
            document.getElementById('dns-clusterselect').value = '<?php if($sysconfig[0]["DNS_CLUSTER"] == "") { echo "no"; } else { echo "yes"; } ?>'; 
            document.getElementById('diskquota').value = '<?php print_r($sysconfig[0]["DISK_QUOTA"]); ?>';  
            document.getElementById('mysql').value = '<?php if( strpos( $servicedata, 'mysql' ) !== false ) { echo "yes"; } else { echo "no"; } ?>';  
            document.getElementById('postgresql').value = '<?php if( strpos( $servicedata, 'postgresql' ) !== false ) { echo "yes"; } else { echo "no"; } ?>';  
            document.getElementById('firewall').value = '<?php if($sysconfig[0]["FIREWALL_SYSTEM"] != '' && $sysconfig[0]["FIREWALL_SYSTEM"] != 'no') { echo 'yes'; } else { echo 'no'; } ?>';  
            document.getElementById('resellerrole').value = "no";
            document.getElementById('backupmigration').value = "no";
            $(document).ready(function() {
                $('.select2').select2();
            });
            function processLoader(){
                swal({
                    title: '<?php echo _("Processing"); ?>',
                    text: '',
                    onOpen: function () {
                        swal.showLoading()
                    }
                })};
            function loadLoader(){
                swal({
                    title: '<?php echo _("Loading"); ?>',
                    text: '',
                    onOpen: function () {
                        swal.showLoading()
                    }
                })};
            <?php
            
            includeScript();
            
           if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "swal({title:'" . $errorcode[1] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            } 
            
            $returntotal = $_POST['r1'] + $_POST['r2'] + $_POST['r3'] + $_POST['r4'] + $_POST['r5'] + $_POST['r6'] + $_POST['r7'] + $_POST['r8'] + $_POST['r9'] + $_POST['r10'] + $_POST['r11'] + $_POST['r12'] + $_POST['r13'] + $_POST['r14'];
            
            if(isset($_POST['r1']) && $returntotal == 0) {
                echo "swal({title:'" . _("Successfully Updated!") . "', type:'success'});";
            } 
            if(isset($_POST['r1']) && $returntotal != 0) {
                echo "swal({title:'" . _("Error Updating User") . "<br>" . "(E: " . $_POST['r1'] . "." . $_POST['r2'] . "." . $_POST['r3'] . "." . $_POST['r4'] . "." . $_POST['r5'] . "." . $_POST['r6'] . "." . $_POST['r7'] . "." . $_POST['r8'] . "." . $_POST['r9'] . "." . $_POST['r10'] . "." . $_POST['r11'] . "." . $_POST['r12'] . "." . $_POST['r13'] . "." . $_POST['r14'] . ")<br><br>" . _("Please try again or contact support.") . "', type:'error'});"; }
            ?>
        </script>
    </body>
</html>