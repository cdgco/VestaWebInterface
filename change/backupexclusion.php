<?php

session_start();
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};
if(base64_decode($_SESSION['loggedin']) != 'true') { header('Location: ../login.php'); }

if(isset($backupsenabled) && $backupsenabled != 'true'){ header("Location: ../error-pages/403.html"); }
if(isset($apienabled) && $apienabled == 'true'){ header("Location: ../error-pages/403.html"); }
if (!isset($_POST['v_dir'])) { header("Location: ../edit/backupexclusions.php?error=1");  }
elseif (!isset($_POST['v_mail'])) { header("Location: ../edit/backupexclusions.php?error=1");  }
elseif (!isset($_POST['v_db'])) { header("Location: ../edit/backupexclusions.php?error=1");  }
elseif (!isset($_POST['v_userdir'])) { header("Location: ../edit/backupexclusions.php?error=1");  }
        
$v_web = $_POST['v_dir'];
$v_web_tmp = str_replace("\r\n", ",", $_POST['v_dir']);
$v_web_tmp = rtrim($v_web_tmp, ",");
$v_web_tmp = "WEB=" . $v_web_tmp;

$v_mail = $_POST['v_mail'];
$v_mail_tmp = str_replace("\r\n", ",", $_POST['v_mail']);
$v_mail_tmp = rtrim($v_mail_tmp, ",");
$v_mail_tmp = "MAIL=" . $v_mail_tmp;

$v_db = $_POST['v_db'];
$v_db_tmp = str_replace("\r\n", ",", $_POST['v_db']);
$v_db_tmp = rtrim($v_db_tmp, ",");
$v_db_tmp = "DB=" . $v_db_tmp;

$v_userdir = $_POST['v_userdir'];
$v_userdir_tmp = str_replace("\r\n", ",", $_POST['v_userdir']);
$v_userdir_tmp = rtrim($v_userdir_tmp, ",");
$v_userdir_tmp = "USER=" . $v_userdir_tmp;

        
function randomPassword() { $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'; $pass = array(); $alphaLength = strlen($alphabet) - 1; for ($i = 0; $i < 8; $i++) { $n = rand(0, $alphaLength); $pass[] = $alphabet[$n]; } return implode($pass); }

$a = randomPassword();
        
function ftp_file_put_contents($remote_file, $file_string) {

    $ftp_server=VESTA_HOST_ADDRESS; 
    $ftp_user_name=VESTA_ADMIN_UNAME; 
    $ftp_user_pass=VESTA_ADMIN_PW;
    $local_file=fopen('php://temp', 'r+');
    fwrite($local_file, $file_string);
    rewind($local_file);       
    $ftp_conn=ftp_connect($ftp_server); 
    @$login_result=ftp_login($ftp_conn, $ftp_user_name, $ftp_user_pass); 
    if($login_result) ftp_fput($ftp_conn, $remote_file, $local_file, FTP_ASCII);
    ftp_close($ftp_conn);
    fclose($local_file); }

$writestr = $v_web_tmp . "\n" . $v_mail_tmp . "\n" .  $v_db_tmp . "\n" . $v_userdir_tmp . "\n";
$writestr = str_replace("\r\n", "\n",  $writestr);
ftp_file_put_contents('backup-exclusions-' . $username . '-' . $a. '.txt', $writestr);

$postvars = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-update-user-backup-exclusions','arg1' => $username, 'arg2' => "/home/admin/" . 'backup-exclusions-' . $username . '-' . $a. '.txt');

$curl0 = curl_init();
curl_setopt($curl0, CURLOPT_URL, $vst_url);
curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl0, CURLOPT_POST, true);
curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars));
$r1 = curl_exec($curl0);

sleep(3); // Give Vesta some time to process files before deleting.

$ftp_server=VESTA_HOST_ADDRESS; 
$ftp_user_name=VESTA_ADMIN_UNAME; 
$ftp_user_pass=VESTA_ADMIN_PW;
$ftp_conn=ftp_connect($ftp_server); 
$login_result = ftp_login($ftp_conn, $ftp_user_name, $ftp_user_pass);
ftp_delete($ftp_conn, 'backup-exclusions-' . $username . '-' . $a. '.txt');

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


        <form id="form" action="../edit/backupexclusions.php" method="post">
            <?php 
                echo '<input type="hidden" name="returncode" value="'.$r1.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../plugins/components/jquery/dist/jquery.min.js"></script>
</html>