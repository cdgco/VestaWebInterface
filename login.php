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
$configlocation = "includes/";
if (file_exists( 'includes/config.php' )) { require( 'includes/includes.php'); }  else { header( 'Location: install' ); exit(); };
if(isset($_SESSION['loggedin'])) {
    if(base64_decode($_SESSION['loggedin']) == 'true') { header('Location: index.php'); exit(); }
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
if(isset($_POST['username'])){

    if(isset($_POST['password'])){

        $username2 = $_POST['username'];
        $password = $_POST['password'];

        $postvars = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-check-user-password','arg1' => $username2,'arg2' => $password, 'arg3' => $_SERVER['REMOTE_ADDR']);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $vst_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postvars));
        $answer = curl_exec($curl);
    }
}
_setlocale(LC_CTYPE, $locale);
_setlocale(LC_MESSAGES, $locale);
_bindtextdomain('messages', 'locale');
_textdomain('messages');

?>

<!DOCTYPE html>  
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/ico" href="plugins/images/<?php echo $cpfavicon; ?>">
        <title><?php echo $sitetitle . ' - ' . __("Login"); ?></title>
        <link href="plugins/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="plugins/components/sweetalert2/sweetalert2.min.css" rel="stylesheet">
        <link href="plugins/components/animate.css/animate.min.css" rel="stylesheet">
        <link rel="stylesheet" href="plugins/components/sweetalert2/sweetalert2.min.css" />
        <link href="css/style.css" rel="stylesheet">
        <link href="css/colors/<?php if(isset($_COOKIE['theme']) && $themecolor != 'custom.css') { echo base64_decode($_COOKIE['theme']); } else {echo $themecolor; } ?>" id="theme"  rel="stylesheet">
        <?php if($themecolor == "custom.css") { require( 'css/colors/custom.php'); } ?>
        <style>
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
        </style>
        <?php if(GOOGLE_ANALYTICS_ID != ''){ echo "<script async src='https://www.googletagmanager.com/gtag/js?id=" . GOOGLE_ANALYTICS_ID . "'></script>
        <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '" . GOOGLE_ANALYTICS_ID . "');</script>"; } ?>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script src="plugins/components/sweetalert2/sweetalert2.min.js"></script>
    </head>
    <body>
        <?php

        if(isset($_GET['code'])){

            $answer = $_GET['code'];

            echo "<script> Swal.fire({title: '";
            if($answer == 0) {
                echo __("Account has been successfully created!") . "', icon: 'success'})</script>";
            } if($answer == 1) {
                echo __("Please fill out all sections of the form.") . "', icon: 'error'})</script>";
            }
            if($answer == 2) {
                echo __("Invalid data entered in form. Please try again.") . "', icon: 'error'})</script>";
            }
            if($answer == 3) {
                echo __("Server or form error (Code: 3). Please contact support.") . "', icon: 'error'})</script>";
            }
            if($answer == 4) {
                echo __("Account already exists under same username.") . "', icon: 'error'})</script>";
            }
            if($answer == 12) {
                echo __("System Error (Code: 12). Please contact support.") . "', icon: 'error'})</script>";
            }
            if($answer == 13) {
                echo __("Server Error (Code: 13). Please contact support.") . "', icon: 'error'})</script>";
            }
            if($answer == 14) {
                echo __("Server Error (Code: 14). Please contact support.") . "', icon: 'error'})</script>";
            }
            if($answer == 15) {
                echo __("System Error (Code: 15). Please contact support.") . "', icon: 'error'})</script>";
            }
            if($answer == 16) {
                echo __("Server Error (Code: 16). Please contact support.") . "', icon: 'error'})</script>";
            }
            if($answer == 17) {
                echo __("Server Error (Code: 17). Please contact support.") . "', icon: 'error'})</script>";
            }
            if($answer == 18) {
                echo __("Process Error (Code: 18). Please contact support.") . "', icon: 'error'})</script>";
            }
            if($answer == 19) {
                echo __("Process Error (Code: 19). Please contact support.") . "', icon: 'error'})</script>";
            }
            if($answer == 20) {
                echo __("Fatal Error (Code: 20). Please contact support.") . "', icon: 'error'})</script>";
            }}
        ?>
        <div class="preloader">
            <div class="cssload-speeding-wheel"></div>
        </div>
        <section id="wrapper" class="new-login-register">
            <div class="lg-info-panel bg-theme">
                <div class="inner-panel">
                    <a href="javascript:void(0)" class="p-20 di"><img src="plugins/images/<?php echo $cpicon; ?>" class="logo-1"></a>
                    <div class="lg-content">
                        <h2><?php echo $sitetitle . ' ' . __("Control Panel"); ?> <br></h2><p><?php require 'includes/versioncheck.php'; ?></p>
                    </div>
                </div>
            </div>
            <div class="new-login-box">
                <div class="white-box">
                    <form class="form-horizontal new-lg-form" id="loginform" method="post" action="login.php<?php if(isset($_GET['to']) && $_GET['to'] != '') { echo '?to=' . $_GET['to']; } ?>">
                        <h3 class="box-title m-b-0"><?php echo __("Sign In to") . ' ' . $sitetitle . ' ' . __("CP"); ?></h3>
                        <small><?php echo __("Enter your details below"); ?></small>

                        <?php
                        if(isset($_POST['username'])){
                            if(isset($_POST['password'])){
                                if($answer == "OK") {
                                    $_SESSION['loggedin'] = base64_encode ( 'true' );
                                    $_SESSION['username'] = base64_encode ( $username2 );
                                    $userredirect = 'index.php';
                                    if(isset($_GET['to']) && $_GET['to'] != ''){
                                        $userredirect = $_GET['to'];
                                    }
                                    if((!isset($_GET['to']) || $_GET['to'] == '') && $_POST['username'] == "admin" && $defaulttoadmin == "true"){
                                        $userredirect = 'admin/list/users.php';
                                    }

                                    echo '<br><br>
                                        <div style="color: #000;" class="alert alert-success alert-dismissable">
                                            <button type="button" style="color: #000;" class="close text-inverse" aria-hidden="true">
                                                <i class="fa fa-circle-o-notch fa-spin" style="font-size:18px"></i>
                                            </button>
                                            <span style="opacity: 0.7;">' . __("Loading Dashboard") . '...</span>
                                        </div>
                                        <script>setTimeout(function(){ window.location = "' . $userredirect . '";}, 100);</script>';
                                } else {
                                    echo '<br><br><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . __("Error: Incorrect Login.") . '</div>';
                                }}}

                        ?>
                        <div class="form-group m-t-20">
                            <div class="col-xs-12">
                                <label><?php echo __("Username"); ?></label>
                                <input class="form-control" name="username" type="text" required="" placeholder="<?php echo __('Username'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <label><?php echo __("Password"); ?></label>
                                <input class="form-control" name="password" type="password" required="" placeholder="<?php echo __('Password'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">

                                <a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> <?php echo __("Forgot pwd?"); ?></a> </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light bg-theme" style="border: none;" type="submit"><?php echo __("Log in"); ?></button>
                            </div>
                        </div>
                        <?php if($regenabled != '') {
                        echo '<br>
                        <div class="form-group m-b-0">
                            <div class="col-sm-12 text-center">
                                <p>' . __("Don't have an account?") . '<a href="register.php" class="text-primary m-l-5"><b>' . __("Sign Up") . '</b></a></p>
                            </div>
                        </div>'; } ?>
                    </form>
                    <form class="form-horizontal" id="recoverform" method="post" action="<?php echo $url8083; ?>/reset/reset.php">
                        <div class="form-group m-t-20">
                            <div class="col-xs-12">
                                <h3 class="box-title m-b-0"><?php echo __("Recover Password"); ?></h3>
                                <small><?php echo __("Enter your username and instructions will be sent to you."); ?></small>
                            </div>
                        </div>
                        <div class="form-group ">
                            <div class="col-xs-12">
                                <input class="form-control" name="user" type="text" required="" placeholder="<?php echo __('Username'); ?>">
                                <?php echo '<input type="hidden" name="returnlink" value="'. substr("http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI], 0, -9) . '">'; ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <a href="javascript:void(0)" id="to-login" class="text-dark pull-right"><i class="fa fa-sign-in m-r-5"></i> <?php echo __("Login"); ?></a> 
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-12">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light bg-theme" style="border: none;" type="submit"><?php echo __("Reset"); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>            
        </section>
        <script src="plugins/components/jquery/jquery.min.js"></script>
        <script src="plugins/components/sweetalert2/sweetalert2.min.js"></script>
        <script src="plugins/components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <script src="plugins/components/bootstrap/dist/js/bootstrap.min.js"></script>
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