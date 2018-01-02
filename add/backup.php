<?php

require '../includes/vars.php';
if(base64_decode($_COOKIE['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

$postvars = array('user' => $vst_username,'password' => $vst_password,'returncode' => $vst_returncode,'cmd' => 'v-schedule-user-backup','arg1' => $username);

$curl0 = curl_init();

if($_GET['verified'] == 'yes'){
    curl_setopt($curl0, CURLOPT_URL, $vst_url);
    curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl0, CURLOPT_POST, true);
    curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars));

    $r1 = curl_exec($curl0);
    header('Location: ../list/backups.php?addcode=0');

}

?>