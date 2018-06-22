<?php

session_start();

if (file_exists( '../../includes/config.php' )) { require( '../../includes/includes.php'); }  else { header( 'Location: ../../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../../login.php'); }
if($username != 'admin') { header("Location: ../../"); }

if(!isset($_GET['ip'])) { header("Location: ../list/ip.php"); }
$postvars = array(
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-user','arg1' => $username,'arg2' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-sys-ip','arg1' => $_GET['ip'],'arg2' => 'json'),
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-users','arg1' => 'json')
);

$curl0 = curl_init();
$curl1 = curl_init();
$curl2 = curl_init();
$curlstart = 0; 


while($curlstart <= 2) {
    curl_setopt(${'curl' . $curlstart}, CURLOPT_URL, $vst_url);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_RETURNTRANSFER,true);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_POST, true);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
    $curlstart++;
} 

$admindata = json_decode(curl_exec($curl0), true)[$username];
$ipname = array_keys(json_decode(curl_exec($curl1), true));
$ipdata = array_values(json_decode(curl_exec($curl1), true));
$uxname = array_keys(json_decode(curl_exec($curl2), true));
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
        <title><?php echo $sitetitle; ?> - <?php echo _("IP"); ?></title>
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
                            <!-- Logo icon image, you can use font-icon also --><b>
                            <!--This is dark logo icon--><img src="../../plugins/images/admin-logo.png" alt="home" class="logo-1 dark-logo" /><!--This is light logo icon--><img src="../../plugins/images/admin-logo-dark.png" alt="home" class="logo-1 light-logo" />
                            </b>
                            <!-- Logo text image you can use text also --><span class="hidden-xs">
                            <!--This is dark logo text--><img src="../../plugins/images/admin-text.png" alt="home" class="hidden-xs dark-logo" /><!--This is light logo text--><img src="../../plugins/images/admin-text-dark.png" alt="home" class="hidden-xs light-logo" />
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
                              adminMenu("../list/", "ip");
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
                            <h4 class="page-title"><?php echo _("Edit IP Address"); ?></h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="white-box">
                                <form class="form-horizontal form-material" autocomplete="off" method="post" action="../change/ip.php">
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("IP Address"); ?></label>
                                        <div class="col-md-12">

                                            <input type="text" disabled value="<?php print_r($ipname[0]); ?>" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;" class="form-control uneditable-input form-control-static"> 
                                            <input type="hidden" name="v_address" value="<?php print_r($ipname[0]); ?>"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Netmask"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" disabled value="<?php print_r($ipdata[0]['NETMASK']); ?>" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;" class="form-control uneditable-input form-control-static"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Interface"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" disabled value="<?php print_r($ipdata[0]['INTERFACE']); ?>" style="background-color: #eee;padding-left: 0.6%;border-radius: 2px;border: 1px solid rgba(120, 130, 140, 0.13);bottom: 19px;background-image: none;" class="form-control uneditable-input form-control-static"> 
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Shared"); ?></label>
                                        <div class="col-md-12">
                                            <div class="checkbox checkbox-info">
                                                <input id="checkbox4" type="checkbox" name="v_shared" onclick="checkDiv();" <?php if($ipdata[0]['STATUS'] == 'shared') {echo 'checked';} ?>>
                                                <label for="checkbox4"><?php echo _("Enabled"); ?></label>
                                                <input type="hidden" name="v_shared-x" value="<?php print_r($ipdata[0]['STATUS']); ?>"> 
                                            </div>
                                        </div>
                                    </div>
                                    <div id="shared-div" style="margin-left: 4%;display:none;">
                                        <div class="form-group">
                                            <label class="col-md-12"><?php echo _("Assigned User"); ?></label>
                                            <div class="col-md-12">
                                                <select class="form-control select2" name="v_assigned" id="typeselect">
                                                    <?php
                                                    if($uxname[0] != '') {
                                                        $x2 = 0; 

                                                        do {
                                                            echo '<option value="' . $uxname[$x2] . '">' . $uxname[$x2] . '</option>';
                                                            $x2++;
                                                        } while ($uxname[$x2] != ''); }

                                                    ?>
                                                </select>
                                                <input type="hidden" name="v_assigned-x" value="<?php print_r($ipdata[0]['OWNER']); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("Assigned Domain"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_domain" value="<?php echo $ipdata[0]['NAME']; ?>" autocomplete="new-password" class="form-control form-control-line"> 
                                            <small class="form-text text-muted"><?php echo _("Optional"); ?></small>
                                            <input type="hidden" name="v_domain-x" value="<?php print_r($ipdata[0]['NAME']); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12"><?php echo _("NAT IP Association"); ?></label>
                                        <div class="col-md-12">
                                            <input type="text" name="v_nat" value="<?php echo $ipdata[0]['NAT']; ?>" autocomplete="new-password" class="form-control form-control-line"> 
                                            <small class="form-text text-muted"><?php echo _("Optional"); ?></small>
                                            <input type="hidden" name="v_nat-x" value="<?php print_r($ipdata[0]['NAT']); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success" onclick="processLoader();"><?php echo _("Update IP"); ?></button> &nbsp;
                                            <a href="../list/ip.php" style="color: inherit;text-decoration: inherit;"><button class="btn btn-muted" type="button"><?php echo _("Back"); ?></button></a>
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
        </script>
        <script type="text/javascript">
            $('.datepicker').datepicker();
            (function () {
                [].slice.call(document.querySelectorAll('.sttabs')).forEach(function (el) {
                    new CBPFWTabs(el);
                });
            })(); 
            function checkDiv(){
                if(document.getElementById("checkbox4").checked) {
                    document.getElementById('shared-div').style.display = 'none';
                }
                else {document.getElementById('shared-div').style.display = 'block';}
            }
            <?php echo 'document.getElementById("typeselect").value = \'' . $ipdata[0]['OWNER'] . '\';'; ?>
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
            if(isset($_GET['error']) && $_GET['error'] == "1") {
                echo "swal({title:'" . $errorcode[1] . "<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            } 
            $returntotal = $_POST['r1'] + $_POST['r2'] + $_POST['r3'] + $_POST['r4'];
            if(isset($_POST['r1']) && $returntotal == 0) {
                echo "swal({title:'" . _("Successfully Updated!") . "', type:'success'});";
            } 
            if(isset($_POST['r1']) && $returntotal != 0) {
                echo "swal({title:'" . _("Error Updating IP Address") . "<br>" . "(E: " . $_POST['r1'] . "." . $_POST['r2'] . "." . $_POST['r3'] . "." . $_POST['r4'] . ")<br><br>" . _("Please try again or contact support.") . "', type:'error'});";
            }
            ?>
        </script>
    </body>
</html>