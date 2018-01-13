<?php

session_start();

if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); }  else { header( 'Location: ../install' );};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

$username = $username;
$verified = $_POST['verified'];

$postvars = array(
array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-add-cron-reports','arg1' => $username)
);
   
    $curl0 = curl_init();
    $curlstart = 0; 

if($verified == "yes"){
    while($curlstart <= 0) {
        curl_setopt(${'curl' . $curlstart}, CURLOPT_URL, $vst_url);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_RETURNTRANSFER,true);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_POST, true);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
        $curlstart++;
    } 

$rs1 = curl_exec($curl0);
print_r($r1);
}

// If accessed directly, redirect to 403 error
header('Location: ../error-pages/403.html');
?>