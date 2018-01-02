<?php

require '../includes/config.php';
if(base64_decode($_COOKIE['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

$postvars = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-database','arg1' => $username,'arg2' => $_POST['db']);

$curl0 = curl_init();

if($_POST['verified'] == 'yes'){
        curl_setopt($curl0, CURLOPT_URL, $vst_url);
        curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl0, CURLOPT_POST, true);
        curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars));

$r1 = curl_exec($curl0);
print_r($r1);
}

// If accessed directly, redirect to 403 error
header('Location: ../error-pages/403.html');
?>