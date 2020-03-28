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

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); exit(); }

if(isset($backupsenabled) && $backupsenabled != 'true'){ header("Location: ../error-pages/403.html"); exit(); }

$backup = $_GET['backup'];

if (isset($backup) && $backup != '') {}
else { header('Location: ../list/backups.php?error=1'); exit(); }

$web = 'no';
$dns = 'no';
$mail = 'no';
$db = 'no';
$cron = 'no';
$udir = 'no';

if ($_GET['type'] == 'web') {$web = $_GET['object'];}
if ($_GET['type'] == 'dns') {$dns = $_GET['object'];}
if ($_GET['type'] == 'mail') {$mail =$_GET['object'];}
if ($_GET['type'] == 'db') {$db = $_GET['object'];}
if ($_GET['type'] == 'cron') {$cron = 'yes';}
if ($_GET['type'] == 'udir') {$udir = $_GET['object'];}

if (!empty($_GET['type'])) {
    $postvars = array(
        array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-schedule-user-restore','arg1' => $username,'arg2' => $backup,'arg3' => $web,'arg4' => $dns,'arg5' => $mail,'arg6' => $db,'arg7' => $cron,'arg8' => $udir));

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
    $r1 = curl_exec($curl0);
} 
else {
    $postvars = array(
        array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-schedule-user-restore','arg1' => $username,'arg2' => $backup));

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
    $r1 = curl_exec($curl0);
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

        <form id="form" action="../list/backups.php" method="post">
            <?php echo '<input type="hidden" name="restore" value="'.$r1.'">'; ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../plugins/components/jquery/jquery.min.js"></script>
</html>