<?php

session_start();
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php?to=list/dns.php' . $urlquery . $_SERVER['QUERY_STRING']); }

if(isset($dnsenabled) && $dnsenabled != 'true'){ header("Location: ../error-pages/403.html"); }

$postvars = array(
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-dns-domains','arg1' => $username,'arg2' => 'json'));

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
$dnsname = array_keys(json_decode(curl_exec($curl1), true));
$dnsdata = array_values(json_decode(curl_exec($curl1), true));
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
        <title><?php echo $sitetitle; ?> - <?php echo _("DNS"); ?></title>
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
                td { font-size: 12px; }
            } 
            @media screen and (max-width: 540px) {
                .resfour { display:none !important;}
                .reseight { display:block !important; 
                }
                .reseight p {
                    line-height: 5% !important;
                }
            } 
            @media screen and (max-width: 410px) {
                .resfive { display:none !important;}
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
                            <h4 class="page-title"><?php echo _("Manage DNS Domains"); ?></h4>
                        </div>
                    </div>
                    <div class="row resone">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center><?php echo _("DOMAINS"); ?></center>
                                        </div>
                                        <div class="panel-body">
                                            <center><h2><?php print_r($admindata['U_DNS_DOMAINS']); ?></h2></center>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center><?php echo _("RECORDS"); ?></center>
                                        </div>
                                        <div class="panel-body">
                                            <center><h2 id="recordcount"><?php print_r($admindata['U_DNS_RECORDS']); ?></h2></center>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="panel">
                                <div class="sk-chat-widgets">
                                    <div class="panel panel-themecolor">
                                        <div class="panel-heading">
                                            <center><?php echo _("SUSPENDED"); ?></center>
                                        </div>
                                        <div class="panel-body">
                                            <center><h2><?php print_r($admindata['SUSPENDED_DNS']); ?></h2></center>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box"> <ul class="side-icon-text pull-right">
                                <li><a href="../add/dns.php"><span class="circle circle-sm bg-success di"><i class="ti-plus"></i></span><span class="resfour"><wrapper class="resthree"><?php echo _("Add "); ?></wrapper><?php echo _("Domain"); ?></span></a></li>
                                </ul>
                                <h3 class="box-title m-b-0"><?php echo _("DNS Domains"); ?></h3><br>

                                <table class="table footable m-b-0" data-sorting="true">
                                    <thead>
                                        <tr>
                                            <th data-toggle="true"> <?php echo _("Domain Name"); ?> </th>
                                            <th class="resthree" data-type="number"> <?php echo _("Records"); ?> </th>
                                            <th class="restwo"> <?php echo _("Status"); ?> </th>
                                            <th class="resone" data-type="date" data-format-string="YYYY-MM-DD" data-sorted="true" data-direction="DESC"> <?php echo _("Created"); ?> </th>
                                            <th data-sortable="false"> <?php echo _("Action"); ?> </th>
                                            <th data-breakpoints="all"> <?php echo _("IP"); ?> </th>
                                            <th data-breakpoints="all"> <?php echo _("SOA (Start of Authority)"); ?> </th>
                                            <th data-breakpoints="all"> <?php echo _("TTL (Time-To-Live)"); ?> </th>
                                            <th data-breakpoints="all"> <?php echo _("DNS Template"); ?> </th>
                                            <th data-breakpoints="all"> <?php echo _("Expiration"); ?> </th>
                                            <th data-breakpoints="all"> <?php echo _("Serial"); ?> </th>
                                            <?php if (CLOUDFLARE_EMAIL != '' && CLOUDFLARE_API_KEY != '') { echo '<th data-breakpoints="all">' . _("Cloudflare") . '</th>'; } ?>
                                            <?php if (CLOUDFLARE_EMAIL != '' && CLOUDFLARE_API_KEY != '') { echo '<th data-breakpoints="all">' . _("Cloudflare Level") . '</th>'; } ?>
                                            <?php if (CLOUDFLARE_EMAIL != '' && CLOUDFLARE_API_KEY != '') { echo '<th data-breakpoints="all">' . _("Cloudflare SSL") . '</th>'; } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        if($dnsname[0] != '') {
                                            $x1 = 0; 

                                            do {
                                                if(count(explode('.', $dnsname[$x1])) > 2) { 
                                                    ${'sub' . $dnsname[$x1]} = 'no';
                                                } else{ 
                                                    ${'sub' . $dnsname[$x1]} = 'yes'; 
                                                } 
                                                if (${'sub' . $dnsname[$x1]} == 'yes') {          
                                                    if (CLOUDFLARE_EMAIL != '' && CLOUDFLARE_API_KEY != ''){
                                                        $cfenabled = curl_init();

                                                        curl_setopt($cfenabled, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones?name=" . $dnsname[$x1]);
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
                                                        $cfsoa = $cfdata[0][0]['name_servers'][0];
                                                        if ($cfname != '' && isset($cfname) && $cfname == $dnsname[$x1]){

                                                            $cfns = curl_init();
                                                            curl_setopt($cfns, CURLOPT_URL, $vst_url);
                                                            curl_setopt($cfns, CURLOPT_RETURNTRANSFER,true);
                                                            curl_setopt($cfns, CURLOPT_SSL_VERIFYPEER, false);
                                                            curl_setopt($cfns, CURLOPT_SSL_VERIFYHOST, false);
                                                            curl_setopt($cfns, CURLOPT_POST, true);
                                                            curl_setopt($cfns, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-dns-records','arg1' => $username,'arg2' => $dnsname[$x1], 'arg3' => 'json')));

                                                            $cfdata = array_values(json_decode(curl_exec($cfns), true));

                                                            $cfnumber = array_keys(json_decode(curl_exec($cfns), true));
                                                            $requestArr = array_column(json_decode(curl_exec($cfns), true), 'TYPE');
                                                            $requestrecord = array_search('NS', $requestArr);

                                                            $nsvalue = $cfdata[$requestrecord]['VALUE'];
                                                            if( strpos( $nsvalue, '.ns.cloudflare.com' ) !== false ) {
                                                                $cfrecords = curl_init();

                                                                curl_setopt($cfrecords, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/" . $cfid . "/dns_records");
                                                                curl_setopt($cfrecords, CURLOPT_RETURNTRANSFER,true);
                                                                curl_setopt($cfrecords, CURLOPT_SSL_VERIFYPEER, false);
                                                                curl_setopt($cfrecords, CURLOPT_SSL_VERIFYHOST, false);
                                                                curl_setopt($cfrecords, CURLOPT_CUSTOMREQUEST, "GET");
                                                                curl_setopt($cfrecords, CURLOPT_HTTPHEADER, array(
                                                                    "X-Auth-Email: " . CLOUDFLARE_EMAIL,
                                                                    "X-Auth-Key: " . CLOUDFLARE_API_KEY));

                                                                $cfsettings = curl_init();

                                                                curl_setopt($cfsettings, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/" . $cfid . "/settings");
                                                                curl_setopt($cfsettings, CURLOPT_RETURNTRANSFER,true);
                                                                curl_setopt($cfsettings, CURLOPT_SSL_VERIFYPEER, false);
                                                                curl_setopt($cfsettings, CURLOPT_SSL_VERIFYHOST, false);
                                                                curl_setopt($cfsettings, CURLOPT_CUSTOMREQUEST, "GET");
                                                                curl_setopt($cfsettings, CURLOPT_HTTPHEADER, array(
                                                                    "X-Auth-Email: " . CLOUDFLARE_EMAIL,
                                                                    "X-Auth-Key: " . CLOUDFLARE_API_KEY));

                                                                $cfdata2 = array_values(json_decode(curl_exec($cfrecords), true));
                                                                $cfdata3 = array_values(json_decode(curl_exec($cfsettings), true));
                                                                $cfcount = $cfdata2[1]['count'];
                                                                $cflevel = ucwords(str_replace("_", " ", $cfdata3[0][30]['value']));
                                                                $cfssl = ucwords($cfdata3[0][34]['value']);
                                                                ${'cfenabled' . $dnsname[$x1]} = 'true'; }

                                                            else { ${'cfenabled' . $dnsname[$x1]} = 'false'; }}

                                                        else { ${'cfenabled' . $dnsname[$x1]} = 'false'; }}
                                                    else { ${'cfenabled' . $dnsname[$x1]} = 'off'; }  
                                                }
                                                echo '<tr'; if($dnsdata[$x1]['SUSPENDED'] != 'no') { echo ' style="background: #efefef"'; } echo '>
                                                                        <td>' . $dnsname[$x1] . '</td>';

                                                if (${'cfenabled' . $dnsname[$x1]} == 'true') { echo '<td data-sort-value="' . $cfcount . '">' . $cfcount . '</td>'; } 
                                                else { echo '<td class="resthree" data-sort-value="' . $dnsdata[$x1]['RECORDS'] . '">' . $dnsdata[$x1]['RECORDS'] . '</td>'; }
                                                if (${'cfenabled' . $dnsname[$x1]} == 'true') { $recordcount = $recordcount + $cfcount; } 
                                                else { $recordcount = $recordcount + $dnsdata[$x1]['RECORDS']; }
                                                echo '<td class="restwo">';                                                                   
                                                if($dnsdata[$x1]['SUSPENDED'] == "no"){ 
                                                    echo '<span class="label label-table label-success">' . _("Active") . '</span>';} 
                                                else{ 
                                                    echo '<span class="label label-table label-danger">' . _("Suspended") . '</span>';} 
                                                echo '</td>
                                                      <td class="resone" data-sort-value="' . $dnsdata[$x1]['DATE'] . '">' . $dnsdata[$x1]['DATE'] . '</td><td>';
                                                            if (${'cfenabled' . $dnsname[$x1]} == 'true' && CLOUDFLARE_EMAIL != '' && CLOUDFLARE_API_KEY != '') { echo '<button onclick="window.location=\'../add/cfrecord.php?domain=' . $dnsname[$x1] . '\';" type="button" data-toggle="tooltip" data-original-title="' . _("Add Record") . '" class="resfour btn color-button btn-outline btn-circle btn-md m-r-5"><i class="fa fa-plus"></i></button>'; } 


                                                            if (${'cfenabled' . $dnsname[$x1]} != 'true' || CLOUDFLARE_EMAIL == '' || CLOUDFLARE_API_KEY == '') { echo '<button onclick="window.location=\'../add/dnsrecord.php?domain=' . $dnsname[$x1] . '\';" type="button" data-toggle="tooltip" data-original-title="' . _("Add Record") . '" class="resfour btn color-button btn-outline btn-circle btn-md m-r-5"><i class="fa fa-plus"></i></button>'; }


                                                            if (${'cfenabled' . $dnsname[$x1]} == 'true' && CLOUDFLARE_EMAIL != '' && CLOUDFLARE_API_KEY != '') { echo '<button onclick="window.location=\'cfdomain.php?domain=' . $dnsname[$x1] . '\';" type="button" data-toggle="tooltip" data-original-title="' . _("List Records") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-menu-alt"></i></button>'; } 
                                                            else { echo '<button onclick="window.location=\'dnsdomain.php?domain=' . $dnsname[$x1] . '\';" type="button" data-toggle="tooltip" data-original-title="' . _("List Records") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-menu-alt"></i></button>'; }

                                                            if ($initialusername == "admin" && $dnsdata[$x1]['SUSPENDED'] == 'no') { echo '<button type="button" onclick="confirmSuspend(\'' . $dnsname[$x1] . '\')" data-toggle="tooltip" data-original-title="' . _("Suspend") . '" class="resthree btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-lock"></i></button>'; }
                                                            elseif ($initialusername == "admin" && $dnsdata[$x1]['SUSPENDED'] == 'yes') { echo '<button type="button" onclick="confirmUnsuspend(\'' . $dnsname[$x1] . '\')" data-toggle="tooltip" data-original-title="' . _("Unsuspend") . '" class="resthree btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-unlock"></i></button>'; }                 

                                                            echo '<span class="reseight" style="display:none">
                                                                <p>&nbsp</p>
                                                            </span><button type="button" onclick="window.location=\'../edit/dns.php?domain=' . $dnsname[$x1] . '\';" data-toggle="tooltip" data-original-title="' . _("Edit") . '" class="btn color-button btn-outline btn-circle btn-md m-r-5"><i class="ti-pencil-alt"></i></button><span class="reseight resfive" style="display:none">
                                                                <p>&nbsp</p>
                                                            </span><button onclick="confirmDelete(\'' . $dnsname[$x1] . '\')" type="button" data-toggle="tooltip" data-original-title="' . _("Delete") . '" class="resfive btn color-button btn-outline btn-circle btn-md m-r-5"><i class="icon-trash"></i></button>'; 
                                                            if (${'sub' . $dnsname[$x1]} == 'yes') {                                                                   
                                                                if (${'cfenabled' . $dnsname[$x1]} == 'true' && CLOUDFLARE_EMAIL != '' && CLOUDFLARE_API_KEY != '') { echo '<button type="button" onclick="processLoader();window.location=\'../delete/cloudflare.php?domain=' . $dnsname[$x1] . '\';" data-toggle="tooltip" data-original-title="' . _("Disable Cloudflare") . '" class="resfour btn btn-outline btn-circle btn-md m-r-5 color-button"><i class="icon-cloudflare">&#xe800;</i></button>'; } 
                                                                if (${'cfenabled' . $dnsname[$x1]} == 'false' && CLOUDFLARE_EMAIL != '' && CLOUDFLARE_API_KEY != '') { echo '<button type="button" onclick="processLoader();window.location=\'../create/cloudflare.php?domain=' . $dnsname[$x1] . '\';" data-toggle="tooltip" data-original-title="' . _("Enable Cloudflare") . '" class="resfour btn btn-outline btn-circle btn-md m-r-5 color-button"><i class="icon-cloudflare">&#xe800;</i></button>'; } }


                                                echo '</td>
                                                        <td>' . $dnsdata[$x1]['IP'] . '</td>
                                                        <td>'; if (${'sub' . $dnsname[$x1]} == 'yes') { if (${'cfenabled' . $dnsname[$x1]} == "true") { print_r($cfsoa); } else { print_r($dnsdata[$x1]['SOA']); } } else { print_r($dnsdata[$x1]['SOA']); } echo '</td>
                                                        <td>'; if (${'sub' . $dnsname[$x1]} == 'yes') { if (${'cfenabled' . $dnsname[$x1]} == "true") { print_r("3600"); } else { print_r($dnsdata[$x1]['TTL']); } } else { print_r($dnsdata[$x1]['TTL']); } echo '</td>
                                                        <td>' . ucfirst($dnsdata[$x1]['TPL']) . '</td>
                                                        <td>' . $dnsdata[$x1]['EXP'] . '</td>
                                                        <td>' . $dnsdata[$x1]['SERIAL'] . '</td>
                                                        <td>';  if (${'sub' . $dnsname[$x1]} == 'yes') { if (${'cfenabled' . $dnsname[$x1]} == 'true' && CLOUDFLARE_EMAIL != '' && CLOUDFLARE_API_KEY != '') { echo '<span class="label label-table label-success">' . _("Enabled") . '</span>'; } 
                                                        if (${'cfenabled' . $dnsname[$x1]} == 'false' && CLOUDFLARE_EMAIL != '' && CLOUDFLARE_API_KEY != '') { echo '<span class="label label-table label-danger">' . _("Disabled") . '</span>'; } } else { echo '<span class="label label-table label-danger">' . _("Unavailable") . '</span>'; }

                                                echo '</td>
                                                    <td>'; if (${'sub' . $dnsname[$x1]} == 'yes') { if (${'cfenabled' . $dnsname[$x1]} == "true") { print_r($cflevel); } if (${'cfenabled' . $dnsname[$x1]} == "false") { echo '<span class="label label-table label-danger">' . _("Cloudflare Disabled") . '</span>'; } } else { echo '<span class="label label-table label-danger">' . _("Cloudflare Unavailable") . '</span>'; } echo '</td>
                                                    <td>'; if (${'sub' . $dnsname[$x1]} == 'yes') { if (${'cfenabled' . $dnsname[$x1]} == "true") { print_r($cfssl); } if (${'cfenabled' . $dnsname[$x1]} == "false") { echo '<span class="label label-table label-danger">' . _("Cloudflare Disabled") . '</span>'; } } else { echo '<span class="label label-table label-danger">' . _("Cloudflare Unavailable") . '</span>'; } echo '</td>
                                                        </tr>';
                                                $x1++;
                                            } while ($dnsname[$x1] != ''); }
                                        ?>
                                    </tbody>
                                </table>
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
            function processLoader(){
                swal({
                    title: '<?php echo _("Processing"); ?>',
                    text: '',
                    onOpen: function () {
                        swal.showLoading()
                    }
                })};
            function confirmDelete(e){
                e1 = String(e)
                swal({
                    title: '<?php echo _("Delete DNS Domain"); ?>:<br> ' + e1 +' ?',
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
                    window.location.replace("../delete/dns.php?domain=" + e1);
                })}
            function confirmSuspend(f){
                f1 = String(f)
                swal({
                    title: '<?php echo _("Suspend DNS Domain"); ?>:<br> ' + f1 +' ?',
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
                    window.location.replace("../admin/suspend/dns.php?user=<?php echo $username; ?>&resource=" + f1);
                })}
            function confirmUnsuspend(f2){
                f2 = String(f2)
                swal({
                    title: '<?php echo _("Unsuspend DNS Domain"); ?>:<br> ' + f2 +' ?',
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
                    window.location.replace("../admin/unsuspend/dns.php?user=<?php echo $username; ?>&resource=" + f2);
                })}
            document.getElementById("recordcount").innerHTML = "<?php if ($recordcount == "") { echo "0";} else { echo $recordcount; } ?>";
            <?php
            
            includeScript();
            
            if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "swal({title:'" . $errorcode[1] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            } 
            if(isset($_GET['cf']) && $_GET['cf'] == "0") {
                echo "swal({title:'" . _("Cloudflare Enabled!") . "', type:'success'});";
            } 
            if(isset($_GET['delcf']) && $_GET['delcf'] == "0") {
                echo "swal({title:'" . _("Cloudflare Disabled!") . "', type:'success'});";
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

            if(isset($_POST['u1']) && $_POST['u1'] == 0) {
                echo "swal({title:'" . _("Successfully Updated!") . "', type:'success'});";
            } 
            if(isset($_POST['u1']) && $_POST['u1'] != 0) {
                echo "swal({title:'" . _("Error Updating DNS Domain") . "<br>" . "(E: " . $_POST['u1'] . ")" . _("Please try again or contact support.") . "<br><br>', type:'error'});";
            }

            ?>
        </script>
    </body>
</html>