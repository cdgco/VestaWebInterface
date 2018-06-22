<?php
session_start();

if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

if(isset($webenabled) && $webenabled != 'true'){ header("Location: ../error-pages/403.html"); }

$v_domain = $_POST['domain'];
if ($_POST['type'] == 'access') $type = 'access';
if ($_POST['type'] == 'error') $type = 'error';

$postvars = array(
    array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-web-domain-' . $type . 'log', 'arg1' => $username, 'arg2' => $v_domain, 'arg3' => '10000000000000000000'));

$curl0 = curl_init();
$curlstart = 0; 

while($curlstart <= 0) {
    curl_setopt(${'curl' . $curlstart}, CURLOPT_URL, $vst_url);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_RETURNTRANSFER,true);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_POST, true);
    curl_setopt(${'curl' . $curlstart}, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
    $curlstart++;
} 

$log = curl_exec($curl0);

$handle = fopen("../tmp/" . $_POST['domain'].".".$type."-log.txt", "w");
fwrite($handle, $log);
fclose($handle);

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename='.basename($_POST['domain'].".".$type."-log.txt"));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize("../tmp/" . $_POST['domain'].".".$type."-log.txt"));
readfile("../tmp/" . $_POST['domain'].".".$type."-log.txt");
unlink("../tmp/" . $_POST['domain'].".".$type."-log.txt");
exit;
?>