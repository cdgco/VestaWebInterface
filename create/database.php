<?php

/** 
*
* Vesta Web Interface v0.5.2-Beta
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
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

if(isset($dbenabled) && $dbenabled != 'true'){ header("Location: ../error-pages/403.html"); }
require '../plugins/components/phpmailer/src/PHPMailer.php';
require '../plugins/components/phpmailer/src/SMTP.php';
require '../plugins/components/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

$v_1 = $_POST['v_database'];
$v_2 = $_POST['v_dbuser'];
$v_3 = $_POST['password'];
$v_4 = $_POST['v_type'];
$v_5 = $_POST['v_host'];
$v_6 = $_POST['v_charset'];

if ((!isset($_POST['v_database'])) || ($_POST['v_database'] == '')) { header('Location: ../add/db.php?error=1');}
elseif ((!isset($_POST['v_dbuser'])) || ($_POST['v_dbuser'] == '')) { header('Location: ../add/db.php?error=1');}
elseif ((!isset($_POST['password'])) || ($_POST['password'] == '')) { header('Location: ../add/db.php?error=1');}
elseif ((!isset($_POST['v_type'])) || ($_POST['v_type'] == '')) { header('Location: ../add/db.php?error=1');}
elseif ((!isset($_POST['v_host'])) || ($_POST['v_host'] == '')) { header('Location: ../add/db.php?error=1');}
elseif ((!isset($_POST['v_charset'])) || ($_POST['v_charset'] == '')) { header('Location: ../add/db.php?error=1');}

$postvars = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-database','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_2, 'arg4' => $v_3, 'arg5' => $v_4, 'arg6' => $v_5, 'arg7' => $v_6);

$curl0 = curl_init();
curl_setopt($curl0, CURLOPT_URL, $vst_url);
curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl0, CURLOPT_POST, true);
curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars));
$r1 = curl_exec($curl0);

if($phpmailenabled == "true" && isset($_POST['v_sendemail']) && $_POST['v_sendemail'] != '') {
    
    $phpadmin = '';
    if($v_4 == 'pgsql'){ $phpadmin = $phppgadmin; }
    if($v_4 == 'mysql'){ $phpadmin = $phpmyadmin; }
    
    $mail = new PHPMailer;
    $mail->setFrom($mailfrom, $mailname);
    $mail->addAddress($_POST['v_sendemail']);
    $mail->Subject = 'Database Credentials';
    $mail->Body = 'Database has been created successfully.<br><br>Database: ' . $username . '_' . $_POST['v_database'] . '<br>User: ' . $username . '_' . $_POST['v_dbuser'] . '<br>Password: ' . $_POST['password'] . '<br>' . addslashes($phpadmin); 
    $mail->AltBody = 'Database has been created successfully.\n\n>Database: ' . $username . '_' . $_POST['v_database'] . '\nUser: ' . $username . '_' . $_POST['v_dbuser'] . '\nPassword: ' . $_POST['password'] . '\n' . addslashes($phpadmin); 

    if($smtpenabled == "true" && $smtphost != '' && $smtpport != '') {
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = $smtphost;
        $mail->Port = $smtpport;
        if($smtpauth == "true") {
            $mail->SMTPAuth = true;
            $mail->Username = $smtpuname;
            $mail->Password = $smtppw;
        }
        if($smtpenc == 'tls') {
         $mail->SMTPSecure = 'tls';  
        }
        elseif($smtpenc == 'ssl') {
         $mail->SMTPSecure = 'ssl';  
        }
    }
    $mail->send();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="../css/style.css" rel="stylesheet">
    </head>
    <body class="fix-header">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
            </svg>
        </div>

        <form id="form" action="../list/db.php" method="post">
            <?php 
            echo '<input type="hidden" name="addcode" value="'.$r1.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../plugins/components/jquery/jquery.min.js"></script>
</html>