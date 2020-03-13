<?php

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2019 Carter Roeser <carter@cdgtech.one>
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
$configlocation = "includes/";
if (file_exists( 'includes/config.php' )) { require( 'includes/includes.php'); }  else { header( 'Location: install' ); exit(); };
if(isset($_SESSION['loggedin'])) {
    if(base64_decode($_SESSION['loggedin']) == 'true') { header('Location: index.php'); exit();  }
}

if(isset($regenabled) && $regenabled != 'true'){ header("Location: error-pages/403.html"); }

if(in_array('billing', $plugins) && file_exists('plugins/billing')) { header( 'Location: plugins/billing/payment/register.php' ); exit(); }

$postvars0 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-sys-info','arg1' => 'json');

$curl0 = curl_init();
curl_setopt($curl0, CURLOPT_URL, $vst_url);
curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl0, CURLOPT_POST, true);
curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars0));
$serverconnection = array_values(json_decode(curl_exec($curl0), true))[0]['OS'];

setlocale(LC_CTYPE, $locale);
setlocale(LC_MESSAGES, $locale);
bindtextdomain('messages', 'locale');
textdomain('messages');

?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">
        <title><?php echo $sitetitle; ?> - <?php echo _('Register'); ?></title>
        <link href="plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="plugins/components/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet">
        <link href="plugins/components/sweetalert2/sweetalert2.min.css" rel="stylesheet">
        <link href="plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/colors/<?php if(isset($_COOKIE['theme']) && $themecolor != 'custom.css') { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme" rel="stylesheet">
        <?php if($themecolor == "custom.css") { require( 'css/colors/custom.php'); } ?>
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
                    <a href="javascript:void(0)" class="p-20 di"><img src="plugins/images/<?php echo $cpicon; ?>" class="logo-1"></a>
                    <div class="lg-content">
                        <h2><?php echo $sitetitle; ?> <?php echo _('Control Panel'); ?> <br></h2><p><?php require 'includes/versioncheck.php'; ?></p>
                    </div>
                </div>
            </div>

            <div class="new-login-box">
                <div class="white-box">
                    <h3 class="box-title m-b-0"><?php echo _('Sign up for'); ?> <?php echo $sitetitle; ?></h3> <small><?php echo _('Enter your details below'); ?></small>
                    <form class="form-horizontal new-lg-form" method="post" id="loginform" action="process/process.php">
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" style="width:49%; float:left;" required="" name="fname" required x-autocompletetype="given-name" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,27}$" placeholder="<?php echo _('First Name'); ?>" title="<?php echo _('2 to 28 Letters Only. Apostrophes and hyphens allowed.'); ?>" autocomplete="on"> 
                                <input class="form-control" type="text" style="width:49%; float:right;" required="" name="lname" required x-autocompletetype="family-name" pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{1,27}$" placeholder="<?php echo _('Last Name'); ?>" title="<?php echo _('2 to 28 Letters Only. Apostrophes and hyphens allowed.'); ?>" autocomplete="on"></div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="email" x-autocompletetype="email" pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,20}$" title="<?php echo _('Invalid Email Address'); ?>" autocomplete="on" required="" placeholder="<?php echo _('Email'); ?>"> </div>
                        </div>   
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" name="username" required autocomplete="on" pattern="^[a-zA-Z][a-zA-Z0-9-_.]{1,27}$" title="<?php echo _('2 to 28 Characters A-Z, 0-9, \'-\' \'.\' and \'_\' Only.'); ?>" placeholder="<?php echo _('Username'); ?>" /> </div>
                        </div>       
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" name="password" title="<?php echo _('Minimum 6 Characters: One uppercade letter, lowercase letter and number reuired.'); ?>" id="pass" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$" autocomplete="new-password" required="" placeholder="<?php echo _('Password'); ?>" style="width:49%; float:left;">

                                <input class="form-control" type="password" id="cpass" autocomplete="new-password" required="" placeholder="<?php echo _('Confirm Pass'); ?>" style="width:49%; float:right;"></div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <select class="selectpicker m-b-20 m-r-10" name="plan" data-style="btn color-button bg-theme" style="border:none;">
                                    <option value="default"><?php echo _('Default'); ?></option>
                                </select>
                            </div></div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn color-button btn-lg btn-block text-uppercase waves-effect waves-light bg-theme" style="border:none;" type="submit"><?php echo _('Sign Up'); ?></button>
                            </div>
                        </div>
                        <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                <p><?php echo _('Already have an account?'); ?> <a href="login.php" class="text-danger m-l-5"><b><?php echo _('Sign in'); ?></b></a></p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <script>
            var password = document.getElementById("pass"),
                confirm_password = document.getElementById("cpass");

            function validatePassword(){
                if(password.value != confirm_password.value) {
                    confirm_password.setCustomValidity("<?php echo _('Passwords do not match'); ?>");
                } else {
                    confirm_password.setCustomValidity('');
                }
            }
            password.onchange = validatePassword;
            confirm_password.onkeyup = validatePassword;
        </script>
        <script src="plugins/components/jquery/jquery.min.js"></script>
        <script src="plugins/components/sweetalert2/sweetalert2.min.js"></script>
        <script src="plugins/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="plugins/components/bootstrap-select/js/bootstrap-select.min.js"></script>
        <script src="plugins/components/metismenu/dist/metisMenu.min.js"></script>
        <script src="plugins/components/waves/waves.js"></script>
        <script src="js/main.js"></script>
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
            
             <?php 
            if($configstyle == '2'){
                if($warningson == "all"){
                    if(substr(sprintf('%o', fileperms($configlocation)), -4) == '0777') {
                        echo "toast1({ 
                                text: '"._("Includes folder has not been secured")."',
                                type: 'warning'
                            });";

                    } 
                    if(isset($mysqldown) && $mysqldown == 'yes') {
                        echo "toast2({
                                title: '" . _("Database Error") . "',
                                text: '" . _("MySQL Server Failed To Connect") . "',
                                type: 'error'
                            });";
                    } 
                }
            }
            else {
                if(substr(sprintf('%o', fileperms($configlocation)), -4) == '0777') {
                    echo "toast1({ 
                            text: '"._("Includes folder has not been secured")."',
                            type: 'warning'
                        });";

                } 
                if(isset($mysqldown) && $mysqldown == 'yes') {
                    echo "toast2({
                           title: '" . _("Database Error") . "',
                            text: '" . _("MySQL Server Failed To Connect") . "',
                            type: 'error'
                        });";

                }    
            }
            if(!isset($serverconnection)){
            echo "toast2({
                    text: '" . _("Failed to connect to server. Please check config.") . "',
                    type: 'error'
            });"; }
            ?>
        </script>
    </body>
</html>