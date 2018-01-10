***REMOVED***

session_start();

if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); ***REMOVED***  else { header( 'Location: ../install' );***REMOVED***;
if(base64_decode($_SESSION['loggedin']) == 'true') {***REMOVED***
else { header('Location: ../login.php'); ***REMOVED***


// Setup variables for API call
$language = $_POST['language'];
$vst_returncode = 'yes';
$password = $_POST['password'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$ns1 = $_POST['ns1'];
$ns2 = $_POST['ns2'];
$ns3 = $_POST['ns3'];
$ns4 = $_POST['ns4'];
$ns5 = $_POST['ns5'];
$ns6 = $_POST['ns6'];
$ns7 = $_POST['ns7'];
$ns8 = $_POST['ns8'];
$cookie = $_POST['cookie'];

$postvars = array(
  array('user' => $vst_username,'password' => $vst_password,'returncode' => $vst_returncode,'cmd' => 'v-change-user-password','arg1' => $username,'arg2' => $password),
  array('user' => $vst_username,'password' => $vst_password,'returncode' => $vst_returncode,'cmd' => 'v-change-user-contact','arg1' => $username,'arg2' => $email),
  array('user' => $vst_username,'password' => $vst_password,'returncode' => $vst_returncode,'cmd' => 'v-change-user-language','arg1' => $username,'arg2' => $language),
  array('user' => $vst_username,'password' => $vst_password,'returncode' => $vst_returncode,'cmd' => 'v-change-user-name','arg1' => $username,'arg2' => $fname,'arg3' => $lname),
  array('user' => $vst_username,'password' => $vst_password,'returncode' => $vst_returncode,'cmd' => 'v-change-user-ns','arg1' => $username,'arg2' => $ns1,'arg3' => $ns2,'arg4' => $ns3,'arg5' => $ns4,'arg6' => $ns5,'arg7' => $ns6,'arg8' => $ns7,'arg9' => $ns8)
  );

$curl0 = curl_init();
$curl1 = curl_init();
$curl2 = curl_init();
$curl3 = curl_init();
$curl4 = curl_init();

if($password != ''){
        curl_setopt($curl0, CURLOPT_URL, $vst_url);
        curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl0, CURLOPT_POST, true);
        curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars[0]));
***REMOVED***


if($email != ''){
        curl_setopt($curl1, CURLOPT_URL, $vst_url);
        curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl1, CURLOPT_POST, true);
        curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars[1]));
***REMOVED***

if($language != ''){
        curl_setopt($curl2, CURLOPT_URL, $vst_url);
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl2, CURLOPT_POST, true);
        curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars[2]));
***REMOVED***

if($fname != '' || $lname != ''){
        curl_setopt($curl3, CURLOPT_URL, $vst_url);
        curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl3, CURLOPT_POST, true);
        curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars[3]));
***REMOVED***

if($ns1 != '' && $ns1 != ''){
        curl_setopt($curl4, CURLOPT_URL, $vst_url);
        curl_setopt($curl4, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl4, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl4, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl4, CURLOPT_POST, true);
        curl_setopt($curl4, CURLOPT_POSTFIELDS, http_build_query($postvars[4]));

***REMOVED***
if(isset($cookie)){
    setcookie("theme", base64_encode($_POST["cookie"] . ".css"), time() + (10 * 365 * 24 * 60 * 60), '/');
***REMOVED***

$r1 = curl_exec($curl0);
$r2 = curl_exec($curl1);
$r3 = curl_exec($curl2);
$r4 = curl_exec($curl3);
$r5 = curl_exec($curl4);


if($r1 == ''){$r1 = "0";***REMOVED***; 
if($r2 == ''){$r2 = "0";***REMOVED***;
if($r3 == ''){$r3 = "0";***REMOVED***;
if($r4 == ''){$r4 = "0";***REMOVED***;
if($r5 == ''){$r5 = "0";***REMOVED***;
header('Location: ../profile.php?settings=open&password=' . $r1 . '&email=' . $r2 . '&lang=' . $r3 . '&name=' . $r4 . '&ns=' . $r5);
***REMOVED***