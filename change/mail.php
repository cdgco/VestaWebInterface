<?php

session_start();

if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

if(isset($mailenabled) && $mailenabled != 'true'){ header("Location: ../error-pages/403.html"); }

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


if ((!isset($_POST['v_domain'])) || ($_POST['v_domain'] == '')) { header('Location: ../list/mail.php?error=1');}
elseif ((!isset($_POST['v_antispam'])) || ($_POST['v_antispam'] == '')) { header('Location: ../edit/mail.php?error=1&domain=' . $v_domain);}
elseif ((!isset($_POST['v_antivirus'])) || ($_POST['v_antivirus'] == '')) { header('Location: ../edit/mail.php?error=1&domain=' . $v_domain);}
elseif ((!isset($_POST['v_dkim'])) || ($_POST['v_dkim'] == '')) { header('Location: ../edit/mail.php?error=1&domain=' . $v_domain);}
if ($_POST['v_antispam-x'] != $v_antispam){
    if ($v_antispam == 'yes'){
        $postvars0 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-mail-domain-antispam','arg1' => $username,'arg2' => $_POST['v_domain']);

        $curl0 = curl_init();
        curl_setopt($curl0, CURLOPT_URL, $vst_url);
        curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl0, CURLOPT_POST, true);
        curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars0));
        $r0 = curl_exec($curl0);
    }
    if ($v_antispam == 'no'){
        $postvars0 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-mail-domain-antispam','arg1' => $username,'arg2' => $_POST['v_domain']);

        $curl0 = curl_init();
        curl_setopt($curl0, CURLOPT_URL, $vst_url);
        curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl0, CURLOPT_POST, true);
        curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars0));
        $r0 = curl_exec($curl0);
    }} else { $r0 = '0';}
if ($_POST['v_antivirus-x'] != $v_antivirus){
    if ($v_antivirus == 'yes'){
        $postvars1 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-mail-domain-antivirus','arg1' => $username,'arg2' => $_POST['v_domain']);

        $curl1 = curl_init();
        curl_setopt($curl1, CURLOPT_URL, $vst_url);
        curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl1, CURLOPT_POST, true);
        curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars1));
        $r1 = curl_exec($curl1);
    }
    if ($v_antivirus == 'no'){
        $postvars1 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-mail-domain-antivirus','arg1' => $username,'arg2' => $_POST['v_domain']);

        $curl1 = curl_init();
        curl_setopt($curl1, CURLOPT_URL, $vst_url);
        curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl1, CURLOPT_POST, true);
        curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars1));
        $r1 = curl_exec($curl1);
    }} else { $r1 = '0';}
if ($_POST['v_dkim-x'] != $v_dkim){
    if ($v_dkim== 'yes'){
        $postvars2 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-mail-domain-dkim','arg1' => $username,'arg2' => $_POST['v_domain']);

        $curl2 = curl_init();
        curl_setopt($curl2, CURLOPT_URL, $vst_url);
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl2, CURLOPT_POST, true);
        curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars2));
        $r2 = curl_exec($curl2);
    }
    if ($v_dkim == 'no'){
        $postvars2 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-mail-domain-dkim','arg1' => $username,'arg2' => $_POST['v_domain']);

        $curl2 = curl_init();
        curl_setopt($curl2, CURLOPT_URL, $vst_url);
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl2, CURLOPT_POST, true);
        curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars2));
        $r2 = curl_exec($curl2);
    }}
else { $r2 = '0';}
if (isset($_POST['v_catchall'])){
    $postvars3 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-mail-domain-catchall','arg1' => $username,'arg2' => $_POST['v_domain'], 'arg3' => $_POST['v_catchall']);

    $curl3 = curl_init();
    curl_setopt($curl3, CURLOPT_URL, $vst_url);
    curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl3, CURLOPT_POST, true);
    curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars3));
    $r3 = curl_exec($curl3);
} else { $r3 = '0';}

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

        <form id="form" action="../edit/mail.php?domain=<?php echo $v_domain; ?>" method="post">
            <?php 
            echo '<input type="hidden" name="r0" value="'.$r0.'">';
            echo '<input type="hidden" name="r1" value="'.$r1.'">';
            echo '<input type="hidden" name="r2" value="'.$r2.'">';
            echo '<input type="hidden" name="r3" value="'.$r3.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../plugins/components/jquery/dist/jquery.min.js"></script>
</html>