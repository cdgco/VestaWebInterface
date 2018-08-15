<?php

session_start();
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php?to=add/cfrecord.php'.$urlquery.$_SERVER['QUERY_STRING']); }

if(isset($dnsenabled) && $dnsenabled != 'true'){ header("Location: ../error-pages/403.html"); }

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
        curl_setopt($cfns, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-dns-records','arg1' => $username,'arg2' => $requestdns, 'arg3' => 'json')));

        $cfdata = array_values(json_decode(curl_exec($cfns), true));

        $cfnumber = array_keys(json_decode(curl_exec($cfns), true));
        $requestArr = array_column(json_decode(curl_exec($cfns), true), 'TYPE');
        $requestrecord = array_search('NS', $requestArr);

        $nsvalue = $cfdata[$requestrecord]['VALUE'];
        if( strpos( $nsvalue, '.ns.cloudflare.com' ) !== false ) {}
        else { header('Location: cfrecord.php?domain='.$requestdns); }
    }
    else { header('Location: cfrecord.php?domain='.$requestdns); }
}
else { header('Location: cfrecord.php?domain='.$requestdns); }

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
        <link href="../plugins/components/metismenu/dist/metisMenu.min.css" rel="stylesheet">
        <link href="../plugins/components/footable/compiled/footable.bootstrap.css" rel="stylesheet">
        <link href="../plugins/components/select2/dist/css/select2.min.css" rel="stylesheet">
        <link href="../css/animate.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../plugins/components/jquery-toast-plugin/dist/jquery.toast.min.css" rel="stylesheet">
        <link href="../css/colors/<?php if(isset($_COOKIE['theme'])) { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <link rel="stylesheet" href="../plugins/components/sweetalert2/dist/sweetalert2.min.css" />
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
                              primaryMenu("../list/", "../process/", "dns");
                        ?>
                    </ul>
                </div>
            </div>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row bg-title">
                        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                            <h4 class="page-title"><?php echo _("Add DNS Record"); ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <form class="form-horizontal form-material" autocomplete="off" method="post" id="form" action="../create/cfrecord.php">
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Domain"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" disabled value="<?php print_r($requestdns); ?>" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;" class="form-control uneditable-input form-control-static"> 
                                            <input type="hidden" name="v_domain" value="<?php print_r($requestdns); ?>"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Record"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_record" autocomplete="new-password" class="form-control form-control-line" maxlength="255" required> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Type"); ?></label>
                                        <div class="col-md-12">
                                            <select class="form-control select2" name="v_type" id="typeselect" onclick="checkDiv();">
                                                <option value="A">A</option>
                                                <option value="AAAA">AAAA</option>
                                                <option value="NS">NS</option>
                                                <option value="CNAME">CNAME</option>
                                                <option value="MX">MX</option>
                                                <option value="TXT">TXT</option>
                                                <option value="SRV">SRV</option>
                                                <option value="SPF">SPF</option>
                                                <option value="LOC">LOC</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-md-12"><?php echo _("IP or Value"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_value" autocomplete="new-password" class="form-control form-control-line" required> </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="col-md-12"><?php echo _("TTL (Time-To-Live)"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_ttl" autocomplete="new-password" class="form-control form-control-line"> 
                                            <small class="form-text text-muted"><?php echo _("Optional"); ?></small>
                                        </div>
                                    </div>
                                    <div id="cf-div">
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Cloudflare Proxy"); ?></label>
                                            <div class="col-md-12">
                                                <div class="checkbox checkbox-info">
                                                    <input id="checkbox4" type="checkbox" name="v_cf">
                                                    <label for="checkbox4"><?php echo _("Enabled"); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" type="submit"><?php echo _("Add Record"); ?></button> &nbsp;
                                            <a href="../list/cfdomain.php?domain=<?php echo $requestdns; ?>" style="color: inherit;text-decoration: inherit;"><button onclick="loadLoader();" class="btn btn-muted" type="button"><?php echo _("Back"); ?></button></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <script> 
                    function submitForm() { document.getElementById("form").submit(); };
                    function exitForm() { window.location.href="../list/cfdomain.php?domain=<?php echo $requestdns; ?>"; };
                </script>
                <?php hotkeys($configlocation); ?>
                <footer class="footer text-center">&copy; <?php echo date("Y") . ' ' . $sitetitle; ?>. <?php echo _("Vesta Web Interface"); ?> <?php require '../includes/versioncheck.php'; ?> <?php echo _("by Carter Roeser"); ?>.</footer>
            </div>
        </div>
        <script src="../plugins/components/jquery/dist/jquery.min.js"></script>
        <script src="../plugins/components/jquery-toast-plugin/dist/jquery.toast.min.js"></script>
        <script src="../bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../plugins/components/metismenu/dist/metisMenu.min.js"></script>
        <script src="../js/jquery.slimscroll.js"></script>
        <script src="../js/waves.js"></script>
        <script src="../js/moment.min.js"></script>
        <script src="../plugins/components/footable/compiled/footable.min.js"></script>
        <script src="../plugins/components/select2/dist/js/select2.min.js"></script>
        <script src="../js/footable-init.js"></script>
        <script src="../js/custom.js"></script>
        <script src="../js/cbpFWTabs.js"></script>
        <script src="../plugins/components/sweetalert2/dist/sweetalert2.min.js"></script>
        <script type="text/javascript">
            $('#form').submit(function(ev) {
                ev.preventDefault();
                processLoader();
                this.submit();
            });
            <?php 
            
            includeScript();
            
            $pluginlocation = "../plugins/"; if(isset($pluginnames[0]) && $pluginnames[0] != '') { $currentplugin = 0; do { if (strtolower($pluginhide[$currentplugin]) != 'y' && strtolower($pluginhide[$currentplugin]) != 'yes') { if (strtolower($pluginadminonly[$currentplugin]) != 'y' && strtolower($pluginadminonly[$currentplugin]) != 'yes') { if (strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; } else { $currentstring = "<li><a href='".$pluginlocation.$pluginlinks[$currentplugin]."/'><i class='fa ".$pluginicons[$currentplugin]." fa-fw'></i><span class='hide-menu'>"._($pluginnames[$currentplugin])."</span></a></li>"; }} else { if(strtolower($pluginnewtab[$currentplugin]) == 'y' || strtolower($pluginnewtab[$currentplugin]) == 'yes') { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/' target='_blank'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>";} } else { if($username == 'admin') { $currentstring = "<li><a href='" . $pluginlocation . $pluginlinks[$currentplugin] . "/'><i class='fa " . $pluginicons[$currentplugin] . " fa-fw'></i><span class='hide-menu'>" . _($pluginnames[$currentplugin] ) . "</span></a></li>"; }}} echo "var plugincontainer" . $currentplugin . " = document.getElementById ('append" . $pluginsections[$currentplugin] . "');\n var plugindata" . $currentplugin . " = \"" . $currentstring . "\";\n plugincontainer" . $currentplugin . ".innerHTML += plugindata" . $currentplugin . ";\n"; } $currentplugin++; } while ($pluginnames[$currentplugin] != ''); } ?>

            (function () {
                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                    new CBPFWTabs(el);
                });
            })(); 
            if(document.getElementById("typeselect").value == "A" || document.getElementById("typeselect").value == "AAAA" || document.getElementById("typeselect").value == "CNAME") {
                document.getElementById("cf-div").style.display = "block";
            }
            else { document.getElementById("cf-div").style.display = "none"; }
            function checkDiv(){
                if(document.getElementById("typeselect").value == "A" || document.getElementById("typeselect").value == "AAAA" || document.getElementById("typeselect").value == "CNAME") {
                    document.getElementById("cf-div").style.display = "block";
                }
                else { document.getElementById("cf-div").style.display = "none"; }
            }
            jQuery(function($){
                $('.footable').footable();
            });
            $('.select2').select2();
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
            if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "swal({title:'" . $errorcode[1] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            } 
            ?>
        </script>
    </body>
</html>