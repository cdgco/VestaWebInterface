<?php

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2020 Carter Roeser <carter@cdgtech.one>
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

session_set_cookie_params(['samesite' => 'none']); session_start();
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' ); exit(); };
if(isset($_SESSION['loggedin'])) {
    if(base64_decode($_SESSION['loggedin']) == 'true') { header('Location: ../index.php'); exit();  }
}

if(!$auth0) {
    header( 'Location: ../login.php' ); exit();
}

$postvars0 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-sys-info','arg1' => 'json');

$curl0 = curl_init();
curl_setopt($curl0, CURLOPT_URL, $vst_url);
curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl0, CURLOPT_POST, true);
curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars0));
$serverconnection = array_values(json_decode(curl_exec($curl0), true))[0]['OS'];

_setlocale('LC_CTYPE', $locale);
_setlocale('LC_MESSAGES', $locale);
_bindtextdomain('messages', 'locale');
_textdomain('messages');

if($regenabled == 'true' || (in_array('billing', $plugins) && file_exists('../plugins/billing'))){ $registrations = 'true'; }
else { $registrations = 'false'; }

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
        <title><?php echo $sitetitle; ?> - <?php echo __('Login'); ?></title>
        <link href="../plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="../plugins/components/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
        <link href="../plugins/components/sweetalert2/sweetalert2.min.css" rel="stylesheet">
        <link href="../plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link href="../css/style.css" rel="stylesheet">
        <link href="../css/colors/<?php if(isset($_COOKIE['theme']) && $themecolor != 'custom.css') { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <?php if($themecolor == "custom.css") { require( '../css/colors/custom.php'); } ?>
        <style>
            html {
                overflow-y: scroll;
            }
            input:-webkit-autofill,
            input:-webkit-autofill:hover, 
            input:-webkit-autofill:focus
            input:-webkit-autofill, 
            textarea:-webkit-autofill,
            textarea:-webkit-autofill:hover
            textarea:-webkit-autofill:focus,
            select:-webkit-autofill,
            select:-webkit-autofill:hover,
            select:-webkit-autofill:focus {
                border: 1px solid #e4e7ea;
                -webkit-text-fill-color: #565656 !important;
                -webkit-box-shadow: 0 0 0px 1000px #ffffff inset;
                transition: background-color 5000s ease-in-out 0s;
            }
            .color-button {
                color: #fff !important;
            }
        </style>
        <?php if(GOOGLE_ANALYTICS_ID != ''){ echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . GOOGLE_ANALYTICS_ID . "'></script>
        <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '" . GOOGLE_ANALYTICS_ID . "');</script>"; } ?>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>
        <section id="wrapper" class="new-login-register">
            <div class="lg-info-panel bg-theme">
                <div class="inner-panel">
                    <a href="javascript:void(0)" class="p-20 di"><img src="../plugins/images/<?php echo $cpicon; ?>" class="logo-1"></a>
                    <div class="lg-content">
                        <h2><?php echo $sitetitle; ?> <?php echo __('Control Panel'); ?> <br></h2><p><?php require '../includes/versioncheck.php'; ?></p>
                    </div>
                </div>
            </div>

            <div class="new-login-box">
                <div class="white-box">
		    <h4 class="m-b-0"><?php echo __('There is no account with those details.') . '<br><br>' . __('Please log in'); if($registrations == 'true') { echo __(' or create a new account'); }; echo __(' to link your account with '); ?><?php echo $sitetitle; ?></h4>
                    <form class="form-horizontal new-lg-form" method="post" id="loginform" action="process/process.php">
			<input type="hidden" name="auth0" value="link"/>
                        <div class="form-group text-center m-t-20">
			   <div class="col-xs-12">
				<a href="javascript:void(0)" onclick="action1();" style="border: none;" class="btn btn-success btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light">
				    <?php echo __("Log In"); ?>
				    <i class="fa fa-angle-right"></i>
				</a>
			    </div>
			</div>
			<?php if((isset($regenabled) && $regenabled == 'true') && (!in_array('billing', $plugins) || !file_exists('../plugins/billing'))) : ?>
			<div class="form-group text-center m-t-20">
			   <div class="col-xs-12">
				<a href="javascript:void(0)" onclick="action2();" style="border: none;" class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light">
				    <?php echo __("Sign Up"); ?>
				    <i class="fa fa-angle-right"></i>
				</a>
			    </div>
			</div>
			<?php endif; if((isset($regenabled) && $regenabled == 'true') && (in_array('billing', $plugins) && file_exists('../plugins/billing'))) : ?>
			<div class="form-group text-center m-t-20">
			   <div class="col-xs-12">
				<a href="javascript:void(0)" onclick="action3();" style="border: none;" class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light">
				    <?php echo __("Sign Up"); ?>
				    <i class="fa fa-angle-right"></i>
				</a>
			    </div>
			</div>
			<?php endif; ?>
                        <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                <p><a href="logout.php" class="text-danger m-l-5"><b><?php echo __('cancel linking accounts'); ?></b></a></p>
                            </div>
                        </div>
			<br><small><?php echo __('Note: You may only link 1 extenal account at a time. Linking a new account will unlink all other accounts.'); ?></small>
                    </form>
                </div>
            </div>
        </section>
        <script src="../plugins/components/jquery/jquery.min.js"></script>
        <script src="../plugins/components/sweetalert2/sweetalert2.min.js"></script>
        <script src="../plugins/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="../plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="../plugins/components/bootstrap-select/js/bootstrap-select.min.js"></script>
        <script src="../plugins/components/metismenu/dist/metisMenu.min.js"></script>
        <script src="../plugins/components/waves/waves.js"></script>
        <script src="../js/main.js"></script>
        <script type="text/javascript">
            Waves.attach('.button', ['waves-effect']);
            Waves.init();
            const toast1 = Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 3500
            });
          const toast2 = Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false
            });
            function action1(){
		document.getElementById("loginform").action = '../login.php';
		document.getElementById("loginform").submit();
	    }
	    function action2(){
		document.getElementById("loginform").action = '../register.php';
		document.getElementById("loginform").submit();
	    }
	    function action3(){
		document.getElementById("loginform").action = '../plugins/billing/payment/register.php';
		document.getElementById("loginform").submit();
	    }

             <?php 
            if($configstyle == '2'){
                if($warningson == "all"){
                    if(substr(sprintf('%o', fileperms($configlocation)), -4) == '0777') {
                        echo "toast1.fire({ 
                                text: '".__("Includes folder has not been secured")."',
                                icon: 'warning',
                                timerProgressBar: true
                            });";

                    } 
                    if(isset($mysqldown) && $mysqldown == 'yes') {
                        echo "toast2.fire({
                                title: '" . __("Database Error") . "',
                                text: '" . __("MySQL Server Failed To Connect") . "',
                                icon: 'error'
                            });";
                    } 
                }
            }
            else {
                if(substr(sprintf('%o', fileperms($configlocation)), -4) == '0777') {
                    echo "toast1.fire({ 
                            title: '".__("Includes folder has not been secured")."',
                            icon: 'warning',
                            timerProgressBar: true
                        });";

                } 
                if(isset($mysqldown) && $mysqldown == 'yes') {
                    echo "toast2.fire({
                           title: '" . __("Database Error") . "',
                            text: '" . __("MySQL Server Failed To Connect") . "',
                            icon: 'error'
                        });";

                }    
            }
            if(!isset($serverconnection)){
            echo "toast2.fire({
                    title: '" . __("Failed to connect to server. Please check config.") . "',
                    icon: 'error'
            });"; }
            ?>
        </script>
    </body>
</html>