<?php

session_start();

if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

$v_1 = $_POST['v_database'];
$v_2 = $_POST['v_dbuser'];
$v_3 = $_POST['password'];

if ((!isset($_POST['v_database'])) || ($_POST['v_database'] == '')) { header('Location: ../list/db.php?error=1');}
elseif ((!isset($_POST['v_dbuser'])) || ($_POST['v_dbuser'] == '')) { header('Location: ../edit/db.php?error=1&domain=' . $v_1);}

$postvars = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-database-user','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_2, 'arg4' => $v_3);

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


        <form id="form" action="../edit/db.php?domain=<?php echo $v_1; ?>" method="post">
            <?php 
            echo '<input type="hidden" name="returncode" value="'.$r1.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
</html>