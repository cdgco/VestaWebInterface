***REMOVED***

require '../includes/vars.php';

if(base64_decode($_COOKIE['loggedin']) == 'true') {***REMOVED***
else { header('Location: ../login.php'); ***REMOVED***

$backup = $_GET['backup'];

if (isset($backup) && $backup != '') {***REMOVED***
else { header('Location: ../list/backups.php?error=0'); ***REMOVED***

$web = 'no';
$dns = 'no';
$mail = 'no';
$db = 'no';
$cron = 'no';
$udir = 'no';

if ($_GET['type'] == 'web') {$web = $_GET['object'];***REMOVED***
if ($_GET['type'] == 'dns') {$dns = $_GET['object'];***REMOVED***
if ($_GET['type'] == 'mail') {$mail =$_GET['object'];***REMOVED***
if ($_GET['type'] == 'db') {$db = $_GET['object'];***REMOVED***
if ($_GET['type'] == 'cron') {$cron = 'yes';***REMOVED***
if ($_GET['type'] == 'udir') {$udir = $_GET['object'];***REMOVED***

if (!empty($_GET['type'])) {
    $postvars = array(
        array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-schedule-user-restore','arg1' => $username,'arg2' => $backup,'arg3' => $web,'arg4' => $dns,'arg5' => $mail,'arg6' => $db,'arg7' => $cron,'arg8' => $udir));

    $curl0 = curl_init();
    $curlstart = 0; 

    while($curlstart <= 0) {
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_URL, $vst_url);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_RETURNTRANSFER,true);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_POST, true);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
        $curlstart++;
    ***REMOVED*** 
    curl_exec($curl0);
    header("Location: ../list/backups.php?code=0");
***REMOVED*** 
else {
    $postvars = array(
        array('user' => $vst_username,'password' => $vst_password,'cmd' => 'v-schedule-user-restore','arg1' => $username,'arg2' => $backup));

    $curl0 = curl_init();
    $curlstart = 0; 

    while($curlstart <= 0) {
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_URL, $vst_url);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_RETURNTRANSFER,true);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_POST, true);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
        $curlstart++;
    ***REMOVED*** 
    curl_exec($curl0);
    header("Location: ../list/backups.php?code=0");
***REMOVED***

***REMOVED***