<?php

session_start();

if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

$v_domain = $_POST['v_domain'];

// Check antispam option
if (!empty($_POST['v_antispam'])) {
    $v_antispam = 'yes';
} else {
    $v_antispam = 'no';
}

// Check antivirus option
if (!empty($_POST['v_antivirus'])) {
    $v_antivirus = 'yes';
} else {
    $v_antivirus = 'no';
}

// Check dkim option
if (!empty($_POST['v_dkim'])) {
    $v_dkim = 'yes';
} else {
    $v_dkim = 'no';
}


if ((!isset($_POST['v_domain'])) || ($_POST['v_domain'] == '')) { header('Location: ../add/mail.php?error=1');}

$postvars = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-mail-domain','arg1' => $username,'arg2' => $v_domain, 'arg3' => $v_antispam, 'arg4' => $v_antivirus, 'arg5' => $v_dkim);

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

        <form id="form" action="../list/mail.php" method="post">
            <?php 
            echo '<input type="hidden" name="addcode" value="'.$r1.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
</html>