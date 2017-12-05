***REMOVED***

require 'config.php';

$vst_returncode = 'yes';
$vst_command = 'v-add-user';

// New Account
$username1 = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email']; 
$package = $_POST['plan'];
$firstname = $_POST['fname']; 
$name = $_POST['lname']; 
$fullname = $firstname . ' ' . $name;
$currenttime = time();

// Prepare POST query
$postvars = array(
    'user' => $vst_username,
    'password' => $vst_password,
    'returncode' => $vst_returncode,
    'cmd' => $vst_command,
    'arg1' => $username1,
    'arg2' => $password,
    'arg3' => $email,
    'arg4' => $package,
    'arg5' => $firstname,
    'arg6' => $name
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

// Prepare POST query
/* $postvars1 = array(
    'uname' => $username1,
    'email' => $email,
    'package' => $package,
    'name' => $fullname,
    'created_at' => $currenttime
);
$postdata1 = http_build_query($postvars1);

    $curl0 = curl_init();

        curl_setopt($curl0, CURLOPT_URL, 'https://app.interakt.co/api/v1/members');
        curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl0, CURLOPT_USERPWD, "username:password");
        curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl0, CURLOPT_POST, true);
        curl_setopt($curl0, CURLOPT_POSTFIELDS, $postdata1);

$r1 = curl_exec($curl0);

*/

header('Location: error-pages/403.html');

// Check result
if(isset($answer)) {
header("Location: login.php?code=".$answer);
***REMOVED***

***REMOVED***