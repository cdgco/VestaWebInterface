<?php

session_start();

if (file_exists( '../../includes/config.php' )) { require( '../../includes/config.php'); }  else { header( 'Location: ../../install' );};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../../login.php'); }
if($username != 'admin') { header("Location: ../../"); }

$v_address = $_POST['v_address'];
$v_netmask = $_POST['v_netmask'];
$v_interface = $_POST['v_interface'];
$v_domain = $_POST['v_domain'];
$v_nat = $_POST['v_nat'];
if (!empty($_POST['v_shared'])) {
    $v_shared = 'shared';
    $v_assigned = 'admin';
} else {
    $v_shared = 'dedicated';
    $v_assigned = $_POST['v_assigned'];
}


if ((!isset($_POST['v_address'])) || ($_POST['v_address'] == '')) { header('Location: ../list/ip.php?error=1');}
elseif ((!isset($_POST['v_netmask'])) || ($_POST['v_netmask'] == '')) { header('Location: ../add/ip.php?error=1');}

$postvars = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-sys-ip','arg1' => $v_address,'arg2' => $v_netmask, 'arg3' => $v_interface, 'arg4' => $v_assigned, 'arg5' => $v_shared, 'arg6' => $v_domain, 'arg7' => $v_nat);

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

        <form id="form" action="../list/ip.php" method="post">
            <?php 
            echo '<input type="hidden" name="addcode" value="'.$r1.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../../plugins/bower_components/jquery/dist/jquery.min.js"></script>
</html>