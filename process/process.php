<?php
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};

$vst_returncode = 'yes';
$vst_command = 'v-add-user';
$username1 = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email']; 
$package = $_POST['plan'];
$firstname = $_POST['fname']; 
$name = $_POST['lname']; 
$fullname = $firstname . ' ' . $name;
$currenttime = time();

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

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $vst_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postvars));
$answer = curl_exec($curl);

if (INTERAKT_APP_ID != '' && INTERAKT_API_KEY != ''){

    $postvars1 = array(
        'uname' => $username1,
        'email' => $email,
        'package' => $package,
        'name' => $fullname,
        'created_at' => $currenttime
    );
    $curl0 = curl_init();

    curl_setopt($curl0, CURLOPT_URL, 'https://app.interakt.co/api/v1/members');
    curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl0, CURLOPT_USERPWD, INTERAKT_APP_ID . ':' . INTERAKT_API_KEY);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl0, CURLOPT_POST, true);
    curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars1));
    $r1 = curl_exec($curl0);
}

header('Location: ../error-pages/403.html');

if(isset($answer)) {
    header("Location: ../login.php?code=".$answer);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="../css/style.css" rel="stylesheet">
    </head>
    <body class="fix-header">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
            </svg>
        </div>
    </body>
    <script src="../plugins/components/jquery/dist/jquery.min.js"></script>
</html>