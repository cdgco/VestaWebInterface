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
$configlocation = "../../includes/";
if (file_exists( '../../includes/config.php' )) { require( '../../includes/includes.php'); }  else { header( 'Location: ../../install' ); exit();};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../../login.php'); exit(); }
if($username != 'admin') { header("Location: ../../"); exit(); }

if(isset($adminenabled) && $adminenabled != 'true'){ header("Location: ../../error-pages/403.html"); exit(); }
if(checkService('iptables') === false){ header("Location: ../../error-pages/403.html"); exit(); }
$v_type = $_POST['v_type'];
$v_protocol = $_POST['v_protocol'];
$v_port = $_POST['v_port'];
$v_ip = $_POST['v_ip'];
$v_comment = $_POST['v_comment'];
$v_rule = $_POST['rule'];

if ((!isset($_POST['rule'])) || ($_POST['rule'] == '')) { header('Location: ../list/firewall.php?error=1'); exit();}
elseif ((!isset($_POST['v_type'])) || ($_POST['v_type'] == '')) { header('Location: ../edit/firewall.php?error=1&rule=' . $v_rule); exit();}
elseif ((!isset($_POST['v_ip'])) || ($_POST['v_ip'] == '')) { header('Location: ../edit/firewall.php?error=1&rule=' . $v_rule); exit();}
elseif ((!isset($_POST['v_port'])) || ($_POST['v_port'] == '')) { header('Location: ../edit/firewall.php?error=1&rule=' . $v_rule); exit();}

$postvars = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-firewall-rule','arg1' => $v_rule,'arg2' => $v_type, 'arg3' => $v_ip, 'arg4' => $v_port, 'arg5' => $v_protocol, 'arg6' => $v_comment);

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
        <link href="../../css/style.css" rel="stylesheet">
    </head>
    <body class="fix-header">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
            </svg>
        </div>

        <form id="form" action="../edit/firewall.php?rule=<?php echo $v_rule ?>" method="post">
            <?php 
    echo '<input type="hidden" name="r1" value="'.$r1.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../../plugins/components/jquery/jquery.min.js"></script>
</html>