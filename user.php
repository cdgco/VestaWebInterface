<?php
require 'config.php';

$vst_command = 'v-list-user-backups';

// Account
$username = 'admin';
$format = 'json';

// Prepare POST query
$postvars = array(
    'user' => $vst_username,
    'password' => $vst_password,
    'cmd' => $vst_command,
    'arg1' => $username,
    'arg2' => $format
);
$postdata = http_build_query($postvars);

// Send POST query via cURL
$postdata = http_build_query($postvars);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $vst_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
$answer = curl_exec($curl);

// Parse JSON output
$data = json_decode($answer, true);

// Print result
print_r($data);

?>
