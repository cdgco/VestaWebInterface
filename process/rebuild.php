***REMOVED***

require '../includes/config.php';

if(base64_decode($_COOKIE['loggedin']) == 'true') {***REMOVED***
  else { header('Location: ../login.php'); ***REMOVED***

$postuser = $_POST['user'];
$postaction = $_POST['action'];
$vst_command = 'v-' . $postaction;

// Prepare POST query
$postvars = array(
    'user' => $vst_username,
    'password' => $vst_password,
    'cmd' => $vst_command,
    'arg1' => $postuser
);

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

header('Location: ../index.php?rebuild=true');
***REMOVED***