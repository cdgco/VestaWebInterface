<?php

require 'config.php';
    if(base64_decode($_COOKIE['loggedin']) == 'true') {}
      else { header('Location: login.php'); }

$username = $username;
$db = $_POST['db'];
$verified = $_POST['verified'];
$vst_returncode = 'yes';

    $postvars = array(
      array('user' => $vst_username,'password' => $vst_password,'returncode' => $vst_returncode,'cmd' => 'v-delete-database','arg1' => $username,'arg2' => $db));
  
    $curl0 = curl_init();

if($verified == 'yes'){
        curl_setopt($curl0, CURLOPT_URL, $vst_url);
        curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl0, CURLOPT_POST, true);
        curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars[0]));

$r1 = curl_exec($curl0);
print_r($r1);
}
header('Location: error-pages/403.html');
?>