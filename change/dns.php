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
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' ); exit();};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); exit(); }

if(isset($dnsenabled) && $dnsenabled != 'true'){ header("Location: ../error-pages/403.html"); exit(); }

$v_1 = $_POST['v_domain'];
$v_2 = $_POST['v_ip'];
$v_3 = $_POST['v_tpl'];
$v_4 = $_POST['v_exp'];
$v_4 = date("Y-m-d", strtotime($v_4));
$v_5 = $_POST['v_soa'];
$v_6 = $_POST['v_ttl'];
if (!empty($_POST['v_cf'])) {
    $v_7 = 'yes';
} else {
    $v_7 = 'no';
}
$v_8 = $_POST['v_cf_level'];
$v_9 = $_POST['v_cf_ssl'];
$v_10 = $_POST['v_cf_id'];

if ($v_7 == "no") {
    $postvars = array(
        array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-dns-domain-ip','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_2),
        array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-dns-domain-tpl','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_3),
        array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-dns-domain-exp','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_4),
        array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-dns-domain-soa','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_5),
        array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-dns-domain-ttl','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_6));

    if ($v_2 != $_POST['v_ip-x']) { 

        $curl0 = curl_init(); 

        curl_setopt($curl0, CURLOPT_URL, $vst_url);
        curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl0, CURLOPT_POST, true);
        curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars[0]));
        $r1 = curl_exec($curl0);
    }
    if ($v_3 != $_POST['v_tpl-x']) { 
        $curl1 = curl_init(); 

        curl_setopt($curl1, CURLOPT_URL, $vst_url);
        curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl1, CURLOPT_POST, true);
        curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars[1]));
        $r2 = curl_exec($curl1);
    }
    if ($_POST['v_exp'] != $_POST['v_exp-x']) { 
        $curl2 = curl_init();

        curl_setopt($curl2, CURLOPT_URL, $vst_url);
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl2, CURLOPT_POST, true);
        curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars[2]));
        $r3 = curl_exec($curl2);
    }
    if ($v_5 != $_POST['v_soa']) { 
        $curl3 = curl_init(); 

        curl_setopt($curl3, CURLOPT_URL, $vst_url);
        curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl3, CURLOPT_POST, true);
        curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars[3]));   
        $r4 = curl_exec($curl3);
    }
    if ($v_6 != $_POST['ttl']) { 
        $curl4 = curl_init(); 

        curl_setopt($curl4, CURLOPT_URL, $vst_url);
        curl_setopt($curl4, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl4, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl4, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl4, CURLOPT_POST, true);
        curl_setopt($curl4, CURLOPT_POSTFIELDS, http_build_query($postvars[4]));
        $r5 = curl_exec($curl4);
    }
}
if ($v_7 == "no" && $v_7 != $_POST['v_cf-x']) {

    header("Location: ../delete/cloudflare.php?domain=" . $v_1);
}
if ($v_7 == "yes") {

    if ($v_7 != $_POST['v_cf-x']) {

        header("Location: ../create/cloudflare.php?domain=" . $v_1 . "&cflevel=" . $v_8 . "&cfssl=" . $v_9);
    }

    if ($v_8 != $_POST['v_cf_level-x']) {
        $cflevel = curl_init();

        curl_setopt_array($cflevel, array(
            CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/" . $v_10 . "/settings/security_level",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "PATCH",
            CURLOPT_POSTFIELDS => '{"value":"' . $v_8 . '"}',
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "X-Auth-Email: " . CLOUDFLARE_EMAIL,
                "X-Auth-Key: " . CLOUDFLARE_API_KEY
            ),
        ));

        $levelresponse = array_values(json_decode(curl_exec($cflevel), true));
    }
    if ($v_8 != $_POST['v_cf_level-x']) {
        $cfssl = curl_init();

        curl_setopt_array($cfssl, array(
            CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/" . $v_10 . "/settings/ssl",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "PATCH",
            CURLOPT_POSTFIELDS => '{"value":"' . $v_9 . '"}',
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "X-Auth-Email: " . CLOUDFLARE_EMAIL,
                "X-Auth-Key: " . CLOUDFLARE_API_KEY
            ),
        ));

        $sslresponse = array_values(json_decode(curl_exec($cfssl), true));
    }
}

if ($r1 == "") { $r1 = '0';}
if ($r2 == "") { $r2 = '0';}
if ($r3 == "") { $r3 = '0';}
if ($r4 == "") { $r4 = '0';}
if ($r5 == "") { $r5 = '0';}

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


        <form id="form" action="../edit/dns.php?domain=<?php echo $v_1 ?>" method="post">
            <?php 
    echo '<input type="hidden" name="r1" value="'.$r1.'">';
              echo '<input type="hidden" name="r2" value="'.$r2.'">';
              echo '<input type="hidden" name="r3" value="'.$r3.'">';
              echo '<input type="hidden" name="r4" value="'.$r4.'">';
              echo '<input type="hidden" name="r5" value="'.$r5.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../plugins/components/jquery/jquery.min.js"></script>
</html>