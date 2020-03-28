<?php

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2020 Carter Roeser <carter@cdgtech.one>
* https://cdgco.github.io/VestaWebInterface
*
* Vesta Web Interface is free software: you can redistribute it and/or modify
* it under the terms of version 3 of the GNU General Public License as published 
* by the Free Software Foundation.
*
* Vesta Web Interface is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with Vesta Web Interface.  If not, see
* <https://github.com/cdgco/VestaWebInterface/blob/master/LICENSE>.
*
*/

session_set_cookie_params(['samesite' => 'none']); session_start();
$configlocation = "../../includes/";
if (file_exists( '../../includes/config.php' )) { require( '../../includes/includes.php'); }  else { header( 'Location: ../../install' ); exit();};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../../login.php'); exit(); }
if($username != 'admin') { header("Location: ../../"); exit(); }

if(isset($adminenabled) && $adminenabled != 'true'){ header("Location: ../../error-pages/403.html"); exit(); }
if(isset($apienabled) && $apienabled == 'true'){ header("Location: ../../error-pages/403.html"); exit(); }

if ((!isset($_POST['v_hostname'])) || (!isset($_POST['v_hostname-x'])) || (!isset($_POST['v_timezone'])) || (!isset($_POST['v_timezone-x'])) || (!isset($_POST['v_language'])) || (!isset($_POST['v_language-x']))) { header('Location: ../server/vesta.php?error=1'); exit();}


if($_POST['v_hostname'] != $_POST['v_hostname-x']) {

    $postvars1 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-sys-hostname','arg1' => $_POST['v_hostname']);

    $curl1 = curl_init();
    curl_setopt($curl1, CURLOPT_URL, $vst_url);
    curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl1, CURLOPT_POST, true);
    curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars1));
    $r1 = curl_exec($curl1);
    
} else { $r1 = '0'; }

if($_POST['v_timezone'] != $_POST['v_timezone-x']) {

    $postvars2 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-sys-timezone','arg1' => $_POST['v_timezone']);

    $curl2 = curl_init();
    curl_setopt($curl2, CURLOPT_URL, $vst_url);
    curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl2, CURLOPT_POST, true);
    curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars2));
    $r2 = curl_exec($curl2);
    
} else { $r2 = '0'; }

if($_POST['v_language'] != $_POST['v_language-x']) {

    $postvars3 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-sys-language','arg1' => $_POST['v_language']);

    $curl3 = curl_init();
    curl_setopt($curl3, CURLOPT_URL, $vst_url);
    curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl3, CURLOPT_POST, true);
    curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars3));
    $r3 = curl_exec($curl3);
    
} else { $r3 = '0'; }

if(isset($_POST['v_mysql_root_pw']) && $_POST['v_mysql_root_pw'] != '') {

    $postvars4 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-database-host-password','arg1' => 'mysql', 'arg2' => 'localhost', 'arg3' => 'root', 'arg4' => $_POST['v_mysql_root_pw']);

    $curl4 = curl_init();
    curl_setopt($curl4, CURLOPT_URL, $vst_url);
    curl_setopt($curl4, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl4, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl4, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl4, CURLOPT_POST, true);
    curl_setopt($curl4, CURLOPT_POSTFIELDS, http_build_query($postvars4));
    $r4 = curl_exec($curl4);
    
} else { $r4 = '0'; }

if(isset($_POST['v_pgsql_root_pw']) && $_POST['v_pgsql_root_pw'] != '') {

    $postvars14 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-database-host-password','arg1' => 'pgsql', 'arg2' => 'localhost', 'arg3' => 'root', 'arg4' => $_POST['v_pgsql_root_pw']);

    $curl14 = curl_init();
    curl_setopt($curl14, CURLOPT_URL, $vst_url);
    curl_setopt($curl14, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl14, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl14, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl14, CURLOPT_POST, true);
    curl_setopt($curl14, CURLOPT_POSTFIELDS, http_build_query($postvars14));
    $r14 = curl_exec($curl14);
    
} else { $r14 = '0'; }

if($_POST['v_backupsystem'] == "yes" && $_POST['v_backupsystem-x'] == 'no') {

    $postvars5 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-backup-host','arg1' => 'local');

    $curl5 = curl_init();
    curl_setopt($curl5, CURLOPT_URL, $vst_url);
    curl_setopt($curl5, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl5, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl5, CURLOPT_POST, true);
    curl_setopt($curl5, CURLOPT_POSTFIELDS, http_build_query($postvars5));
    $r5 = curl_exec($curl5);
    
}

elseif($_POST['v_backupsystem'] == "no" && $_POST['v_backupsystem-x'] == 'yes') {

    $postvars5 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-backup-host','arg1' => 'local');

    $curl5 = curl_init();
    curl_setopt($curl5, CURLOPT_URL, $vst_url);
    curl_setopt($curl5, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl5, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl5, CURLOPT_POST, true);
    curl_setopt($curl5, CURLOPT_POSTFIELDS, http_build_query($postvars5));
    $r5 = curl_exec($curl5);
    
} else { $r5 = '0'; }

if($_POST['v_backupgzip'] != $_POST['v_backupgzip-x']) {

    $postvars6 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-sys-config-value','arg1' => 'BACKUP_GZIP','arg2' => $_POST['v_backupgzip']);

    $curl6 = curl_init();
    curl_setopt($curl6, CURLOPT_URL, $vst_url);
    curl_setopt($curl6, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl6, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl6, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl6, CURLOPT_POST, true);
    curl_setopt($curl6, CURLOPT_POSTFIELDS, http_build_query($postvars6));
    $r6 = curl_exec($curl6);
    
} else { $r6 = '0'; }

if($_POST['v_backupdir'] != $_POST['v_backupdir-x']) {

    $postvars7 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-sys-config-value','arg1' => 'BACKUP','arg2' => $_POST['v_backupdir']);

    $curl7 = curl_init();
    curl_setopt($curl7, CURLOPT_URL, $vst_url);
    curl_setopt($curl7, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl7, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl7, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl7, CURLOPT_POST, true);
    curl_setopt($curl7, CURLOPT_POSTFIELDS, http_build_query($postvars7));
    $r7 = curl_exec($curl7);
    
} else { $r7 = '0'; }

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


if ($_POST['v_sslcrt'] != $_POST['v_sslcrt-x'] || $_POST['v_sslkey'] != $_POST['v_sslkey-x']) {
        
        $writestr1 = str_replace("\r\n", "\n",  $_POST['v_sslcrt']);
        $writestr2 = str_replace("\r\n", "\n",  $_POST['v_sslkey']);
        ftp_file_put_contents($v_domain . '.crt', $writestr1);
        ftp_file_put_contents($v_domain . '.key', $writestr2);
        
        $postvars8 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-sys-vesta-ssl','arg1' => "/home/admin/");
        
        $curl8 = curl_init();
        curl_setopt($curl8, CURLOPT_URL, $vst_url);
        curl_setopt($curl8, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl8, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl8, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl8, CURLOPT_POST, true);
        curl_setopt($curl8, CURLOPT_POSTFIELDS, http_build_query($postvars8));
        $r8 = curl_exec($curl8);
    
        sleep(5); // Give Vesta some time to process files before deleting.
        
        $ftp_server=VESTA_HOST_ADDRESS; 
        $ftp_user_name=VESTA_ADMIN_UNAME; 
        $ftp_user_pass=VESTA_ADMIN_PW;
        $ftp_conn=ftp_connect($ftp_server); 
        $login_result = ftp_login($ftp_conn, $ftp_user_name, $ftp_user_pass);
        ftp_delete($ftp_conn, $v_domain . '.crt');
        ftp_delete($ftp_conn, $v_domain . '.key');
    
} else { $r8 = '0'; }

if($_POST['v_quota'] == "yes" && $_POST['v_quota-x'] == 'no') {

    $postvars9 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-sys-quota','arg1' => 'local');

    $curl9 = curl_init();
    curl_setopt($curl9, CURLOPT_URL, $vst_url);
    curl_setopt($curl9, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl9, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl9, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl9, CURLOPT_POST, true);
    curl_setopt($curl9, CURLOPT_POSTFIELDS, http_build_query($postvars9));
    $r9 = curl_exec($curl9);
    
}

elseif($_POST['v_quota'] == "no" && $_POST['v_quota-x'] == 'yes') {

    $postvars9 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-sys-quota','arg1' => 'local');

    $curl9 = curl_init();
    curl_setopt($curl9, CURLOPT_URL, $vst_url);
    curl_setopt($curl9, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl9, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl9, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl9, CURLOPT_POST, true);
    curl_setopt($curl9, CURLOPT_POSTFIELDS, http_build_query($postvars9));
    $r9 = curl_exec($curl9);
    
} else { $r9 = '0'; }

if($_POST['v_firewall'] == "yes" && $_POST['v_firewall-x'] == 'no') {

    $postvars10 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-sys-firewall','arg1' => 'local');

    $curl10 = curl_init();
    curl_setopt($curl10, CURLOPT_URL, $vst_url);
    curl_setopt($curl10, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl10, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl10, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl10, CURLOPT_POST, true);
    curl_setopt($curl10, CURLOPT_POSTFIELDS, http_build_query($postvars10));
    $r10 = curl_exec($curl10);
    
}
elseif($_POST['v_firewall'] == "no" && $_POST['v_firewall-x'] == 'yes') {

    $postvars10 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-sys-firewall','arg1' => 'local');

    $curl10 = curl_init();
    curl_setopt($curl10, CURLOPT_URL, $vst_url);
    curl_setopt($curl10, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl10, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl10, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl10, CURLOPT_POST, true);
    curl_setopt($curl10, CURLOPT_POSTFIELDS, http_build_query($postvars10));
    $r10 = curl_exec($curl10);
    
} else { $r10 = '0'; }

if($_POST['v_sftpjail'] == "yes" && $_POST['v_sftpjail-key'] != $_POST['v_sftpjail-key-x']) {

    $postvars11 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-activate-vesta-license','arg1' => 'sftpjail','arg1' => $_POST['v_sftpjail-key']);

    $curl11 = curl_init();
    curl_setopt($curl11, CURLOPT_URL, $vst_url);
    curl_setopt($curl11, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl11, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl11, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl11, CURLOPT_POST, true);
    curl_setopt($curl11, CURLOPT_POSTFIELDS, http_build_query($postvars11));
    $r11 = curl_exec($curl11);
    
}
elseif($_POST['v_sftpjail'] == "no" && $_POST['v_sftpjail-x'] == 'yes') {

    $postvars11 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-deactivate-vesta-license','arg1' => 'sftpjail', 'arg2' => '');

    $curl11 = curl_init();
    curl_setopt($curl11, CURLOPT_URL, $vst_url);
    curl_setopt($curl11, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl11, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl11, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl11, CURLOPT_POST, true);
    curl_setopt($curl11, CURLOPT_POSTFIELDS, http_build_query($postvars11));
    $r11 = curl_exec($curl11);
    
} else { $r11 = '0'; }

if($_POST['v_filemanager'] == "yes" && $_POST['v_filemanager-key'] != $_POST['v_filemanager-key-x']) {

    $postvars12 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-activate-vesta-license','arg1' => 'filemanager','arg1' => $_POST['v_filemanager-key']);

    $curl12 = curl_init();
    curl_setopt($curl12, CURLOPT_URL, $vst_url);
    curl_setopt($curl12, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl12, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl12, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl12, CURLOPT_POST, true);
    curl_setopt($curl12, CURLOPT_POSTFIELDS, http_build_query($postvars12));
    $r12 = curl_exec($curl12);
    
}

elseif($_POST['v_filemanager'] == "no" && $_POST['v_filemanager-x'] == 'yes') {

    $postvars12 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-deactivate-vesta-license','arg1' => 'filemanager', 'arg2' => '');

    $curl12 = curl_init();
    curl_setopt($curl12, CURLOPT_URL, $vst_url);
    curl_setopt($curl12, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl12, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl12, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl12, CURLOPT_POST, true);
    curl_setopt($curl12, CURLOPT_POSTFIELDS, http_build_query($postvars12));
    $r12 = curl_exec($curl12);
    
} else { $r12 = '0'; }

if($_POST['v_softaculous'] == "yes" && $_POST['v_softaculous-x'] == 'no') {

    $postvars13 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-vesta-softaculous');

    $curl13 = curl_init();
    curl_setopt($curl13, CURLOPT_URL, $vst_url);
    curl_setopt($curl13, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl13, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl13, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl13, CURLOPT_POST, true);
    curl_setopt($curl13, CURLOPT_POSTFIELDS, http_build_query($postvars13));
    $r13 = curl_exec($curl13);
    
}
elseif($_POST['v_softaculous'] == "no" && $_POST['v_softaculous-x'] == 'yes') {

    $postvars13 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-vesta-softaculous');

    $curl13 = curl_init();
    curl_setopt($curl13, CURLOPT_URL, $vst_url);
    curl_setopt($curl13, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl13, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl13, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl13, CURLOPT_POST, true);
    curl_setopt($curl13, CURLOPT_POSTFIELDS, http_build_query($postvars13));
    $r13 = curl_exec($curl13);
    
} else { $r13 = '0'; }

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="../../css/style.css" rel="stylesheet">
    </head>
    <body class="fix-header">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
            </svg>
        </div>

        <form id="form" action="../server/vesta.php" method="post">
            <?php 
                echo '<input type="hidden" name="r1" value="'.$r1.'">';
                echo '<input type="hidden" name="r2" value="'.$r2.'">';
                echo '<input type="hidden" name="r3" value="'.$r3.'">';
                echo '<input type="hidden" name="r4" value="'.$r4.'">';
                echo '<input type="hidden" name="r5" value="'.$r14.'">';
                echo '<input type="hidden" name="r6" value="'.$r5.'">';
                echo '<input type="hidden" name="r7" value="'.$r6.'">';
                echo '<input type="hidden" name="r8" value="'.$r7.'">';
                echo '<input type="hidden" name="r9" value="'.$r8.'">';
                echo '<input type="hidden" name="r10" value="'.$r9.'">';
                echo '<input type="hidden" name="r11" value="'.$r10.'">';
                echo '<input type="hidden" name="r12" value="'.$r11.'">';
                echo '<input type="hidden" name="r13" value="'.$r12.'">';
                echo '<input type="hidden" name="r14" value="'.$r13.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../../plugins/components/jquery/jquery.min.js"></script>
</html>