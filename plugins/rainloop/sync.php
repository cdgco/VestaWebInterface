<?php 

require( '../../includes/config.php');
$rainloopdir = 'data/_data_/_default_/domains/';

// Build array to create http query
$uservars = array(
		    'user' => $vst_username,
		    'password' => $vst_password,
		    'cmd' => 'v-list-users',
		    'arg1' => 'json'
	);
// Build query based on array
$userdata = http_build_query($uservars);
// Build curl query and execute
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://' . VESTA_HOST_ADDRESS . ':8083/api/');
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $userdata);
$users = curl_exec($curl);
// Parse JSON output to array
$userout = json_decode($users, true);
// Loop through array of usernames to pull out domain names
foreach ($userout as $key => $value){
	// Build array to create http query
	$postvars = array(
		'user' => $vst_username,
		'password' => $vst_password,
		'cmd' => 'v-list-web-domains',
		'arg1' => $key,
		'arg3' => 'json'
		);
	// Build query based on array
	$postdata = http_build_query($postvars);
	// Build curl query and execute
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, 'https://' . VESTA_HOST_ADDRESS . ':8083/api/');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
	$answer = curl_exec($curl);
	// Parse JSON output
	$data = json_decode($answer, true);
	//Loop through array to create configuration files
		foreach (array_keys($data) as $domain){
	// Define file contents
$configout = 'imap_host = "mail.'.$domain.'"
imap_port = 993
imap_secure = "SSL"
imap_short_login = Off
sieve_use = Off
sieve_allow_raw = Off
sieve_host = ""
sieve_port = 4190
sieve_secure = "None"
smtp_host = "mail.'.$domain.'"
smtp_port = 587
smtp_secure = "TLS"
smtp_short_login = Off
smtp_auth = On
smtp_php_mail = Off
white_list = ""';
	// Check for existing files
if (!file_exists($rainloopdir.$domain.".ini")){
	// If no file found, write configuration file to Rainloop domain configuration directory
file_put_contents($rainloopdir.$domain.".ini", $configout);
	// Place entry in synclog.log  
file_put_contents("synclog.log", date("Y/m/d")." ".date("h:i:sa")." ".$domain.".ini created\r\n", FILE_APPEND);
} else {
	// If file found, do not write configuration file and place entry in synclog.log
	file_put_contents("synclog.log", date("Y/m/d")." ".date("h:i:sa")." ".$domain.".ini exists, skipped\r\n", FILE_APPEND);
}
		}
}
?>