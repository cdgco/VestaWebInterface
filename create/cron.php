<?php

/** 
*
* Vesta Web Interface v0.5.1-Beta
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

if(isset($cronenabled) && $cronenabled != 'true'){ header("Location: ../error-pages/403.html"); }

$v_min = $_POST['v_min'];
$v_hour = $_POST['v_hour'];
$v_day = $_POST['v_day'];
$v_month = $_POST['v_month'];
$v_wday = $_POST['v_wday'];
$v_cmd = $_POST['v_cmd'];

if ((!isset($_POST['v_min'])) || ($_POST['v_min'] == '')) { header('Location: ../add/cron.php?error=1');}
elseif ((!isset($_POST['v_hour'])) || ($_POST['v_hour'] == '')) { header('Location: ../add/cron.php?error=1');}
elseif ((!isset($_POST['v_day'])) || ($_POST['v_day'] == '')) { header('Location: ../add/cron.php?error=1');}
elseif ((!isset($_POST['v_month'])) || ($_POST['v_month'] == '')) { header('Location: ../add/cron.php?error=1');}
elseif ((!isset($_POST['v_wday'])) || ($_POST['v_wday'] == '')) { header('Location: ../add/cron.php?error=1');}
elseif ((!isset($_POST['v_cmd'])) || ($_POST['v_cmd'] == '')) { header('Location: ../add/cron.php?error=1');}

$postvars = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-cron-job','arg1' => $username,'arg2' => $v_min, 'arg3' => $v_hour, 'arg4' => $v_day, 'arg5' => $v_month, 'arg6' => $v_wday, 'arg7' => $v_cmd);

$curl0 = curl_init();
curl_setopt($curl0, CURLOPT_URL, $vst_url);
curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl0, CURLOPT_POST, true);
curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars));
$r1 = curl_exec($curl0);

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

        <form id="form" action="../list/cron.php" method="post">
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