<?php

session_start();
$configlocation = "../../includes/";
if (file_exists( '../../includes/config.php' )) { require( '../../includes/includes.php'); }  else { header( 'Location: ../../install' );};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../../login.php'); }
if($initialusername != 'admin') { header("Location: ../../"); }

if(isset($cronenabled) && $cronenabled != 'true'){ header("Location: ../../error-pages/403.html"); }

$v_resource = $_GET['resource'];
$v_user = $_GET['user'];

if ((!isset($_GET['resource'])) || ($_GET['resource'] == '')) { header('Location: ../../list/cron.php?error=1');}
if ((!isset($_GET['user'])) || ($_GET['user'] == '')) { header('Location: ../../list/cron.php?error=1');}

$postvars = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-suspend-cron-job','arg1' => $v_user, 'arg2' => $v_resource);

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

        <form id="form" action="../../list/cron.php" method="post">
            <?php 
            echo '<input type="hidden" name="u1" value="'.$r1.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../../plugins/components/jquery/dist/jquery.min.js"></script>
</html>