<?php

session_start();

if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

if(isset($profileenabled) && $profileenabled != 'true'){ header("Location: ../error-pages/403.html"); }

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

if(isset($_POST['password'])){
    curl_setopt($curl0, CURLOPT_URL, $vst_url);
    curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl0, CURLOPT_POST, true);
    curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars[0]));
    $r1 = curl_exec($curl0);
}
else{$r1 = '0';}

if($email != $_POST['email-x']){
    curl_setopt($curl1, CURLOPT_URL, $vst_url);
    curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl1, CURLOPT_POST, true);
    curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars[1]));
    $r2 = curl_exec($curl1);
}
else{$r2 = '0';}
if($language != $_POST['language-x']){
    curl_setopt($curl2, CURLOPT_URL, $vst_url);
    curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl2, CURLOPT_POST, true);
    curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars[2]));
    $r3 = curl_exec($curl2);
}
else{$r3 = '0';}
if($fname != $_POST['fname-x'] || $lname != $_POST['lname-x']){
    curl_setopt($curl3, CURLOPT_URL, $vst_url);
    curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl3, CURLOPT_POST, true);
    curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars[3]));
    $r4 = curl_exec($curl3);
}
else{$r4 = '0';}
if($ns1 != $_POST['ns1-x'] || $ns2 != $_POST['ns2-x'] || $ns3 != $_POST['ns3-x'] || $ns4 != $_POST['ns4-x'] || $ns5 != $_POST['ns5-x'] || $ns6 != $_POST['ns6-x'] || $ns7 != $_POST['ns7-x'] || $ns8 != $_POST['ns8-x']){
    curl_setopt($curl4, CURLOPT_URL, $vst_url);
    curl_setopt($curl4, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl4, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl4, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl4, CURLOPT_POST, true);
    curl_setopt($curl4, CURLOPT_POSTFIELDS, http_build_query($postvars[4]));
    $r5 = curl_exec($curl4);
}
else{$r5 = '0';}
if(isset($cookie)){
    setcookie("theme", base64_encode($_POST["cookie"] . ".css"), time() + (10 * 365 * 24 * 60 * 60), '/');
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

        <form id="form" action="../profile.php?settings=open" method="post">
            <?php 
            echo '<input type="hidden" name="r1" value="'.$r1.'">';
            echo '<input type="hidden" name="r2" value="'.$r2.'">';
            echo '<input type="hidden" name="r3" value="'.$r3.'">';
            echo '<input type="hidden" name="r4" value="'.$r4.'">';
            echo '<input type="hidden" name="r5" value="'.$r5.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
</html>