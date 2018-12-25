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
else { header('Location: ../../login.php'); }
if($username != 'admin') { header("Location: ../../"); }

if(isset($adminenabled) && $adminenabled != 'true'){ header("Location: ../../error-pages/403.html"); }

$v_1 = $_POST['v_address'];
$v_2 = $_POST['v_domain'];
$v_3 = $_POST['v_nat'];
if (!empty($_POST['v_shared'])) {
    $v_5 = 'shared';
    $v_4 = 'admin';
} else {
    $v_5 = 'dedicated';
    $v_4 = $_POST['v_assigned'];
}

if (isset($_POST['v_address']) && $_POST['v_address'] != '') {
    $postvars = array(
        array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-sys-ip-status','arg1' => $v_1,'arg2' => $v_5),
        array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-sys-ip-owner','arg1' => $v_1,'arg2' => $v_4),
        array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-sys-ip-name','arg1' => $v_1,'arg2' => $v_2),
        array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-sys-ip-nat','arg1' => $v_1,'arg2' => $v_3, 'arg3' => 'no'));

    if ($v_5 != $_POST['v_shared-x']) { 

        $curl0 = curl_init(); 

        curl_setopt($curl0, CURLOPT_URL, $vst_url);
        curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl0, CURLOPT_POST, true);
        curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars[0]));
        $r1 = curl_exec($curl0);
    } else { $r1 = '0'; }
    if ($v_4 != $_POST['v_assigned-x']) { 
        $curl1 = curl_init(); 

        curl_setopt($curl1, CURLOPT_URL, $vst_url);
        curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl1, CURLOPT_POST, true);
        curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars[1]));
        $r2 = curl_exec($curl1);
    } else { $r2 = '0'; }
    if ($v_2 != $_POST['v_domain-x']) { 
        $curl2 = curl_init();

        curl_setopt($curl2, CURLOPT_URL, $vst_url);
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl2, CURLOPT_POST, true);
        curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars[2]));
        $r3 = curl_exec($curl2);
    } else { $r3 = '0'; }
    if ($v_3 != $_POST['v_nat-x']) { 
        $curl3 = curl_init(); 

        curl_setopt($curl3, CURLOPT_URL, $vst_url);
        curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl3, CURLOPT_POST, true);
        curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars[3]));   
        $r4 = curl_exec($curl3);
    } else { $r4 = '0'; }
}
else { header('Location: ../list/ip.php?error=1'); }

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


        <form id="form" action="../edit/ip.php?ip=<?php echo $v_1 ?>" method="post">
            <?php 
    echo '<input type="hidden" name="r1" value="'.$r1.'">';
              echo '<input type="hidden" name="r2" value="'.$r2.'">';
              echo '<input type="hidden" name="r3" value="'.$r3.'">';
              echo '<input type="hidden" name="r4" value="'.$r4.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../plugins/components/jquery/jquery.min.js"></script>
</html>