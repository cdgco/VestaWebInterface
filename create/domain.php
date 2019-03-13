<?php

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2018 Carter Roeser <carter@cdgtech.one>
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

session_start();
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' ); exit();};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); exit(); }

if(isset($webenabled) && $webenabled != 'true'){ header("Location: ../error-pages/403.html"); exit(); }

require '../plugins/components/phpmailer/src/PHPMailer.php';
require '../plugins/components/phpmailer/src/SMTP.php';
require '../plugins/components/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

// Remove www. from domain and lowercase
$v_domain = preg_replace("/^www\./i", "", $_POST['v_domain']);
$v_domain = strtolower($v_domain);

// Define domain aliases
$v_aliases = $_POST['v_alias'];
$aliases = preg_replace("/\n/", ",", $v_aliases);
$aliases = preg_replace("/\r/", ",", $aliases);
$aliases = preg_replace("/\t/", ",", $aliases);
$aliases = preg_replace("/ /", ",", $aliases);
$aliases_arr = explode(",", $aliases);
$aliases_arr = array_unique($aliases_arr);
$aliases_arr = array_filter($aliases_arr);
$alias = implode(",",$aliases_arr);
if (empty($_POST['v_alias'])) $alias = 'none';

// Define proxy extensions
if(isset($_POST['v_prxext']) && $_POST['v_prxext'] != '') {
$v_proxy_ext = $_POST['v_prxext'];
$proxy_ext = preg_replace("/\n/", ",", $v_proxy_ext);
$proxy_ext = preg_replace("/\r/", ",", $proxy_ext);
$proxy_ext = preg_replace("/\t/", ",", $proxy_ext);
$proxy_ext = preg_replace("/ /", ",", $proxy_ext);
$proxy_ext_arr = explode(",", $proxy_ext);
$proxy_ext_arr = array_unique($proxy_ext_arr);
$proxy_ext_arr = array_filter($proxy_ext_arr);
$prxext = implode(",",$proxy_ext_arr); }
else { $prxext = ''; }

// Check DNS option
if (!empty($_POST['v_dnsenabled'])) {
    $v_dnsx = 'yes';
} else {
    $v_dnsx = 'no';
}
// Check Mail option
if (!empty($_POST['v_mailenabled'])) {
    $v_mailx = 'yes';
} else {
    $v_mailx = 'no';
}
// Check Proxy option
if (isset($_POST['v_pryxyenabled']) && !empty($_POST['v_pryxyenabled'])) {
    $v_prxx = 'yes';
} else {
    $v_prxx = 'no';
}
// Check SSL option
if (!empty($_POST['v_sslenabled'])) {
    $v_sslx = 'yes';
} else {
    $v_sslx = 'no';
}
// Check Let's Encrypt option
if (!empty($_POST['v_leenabled'])) {
    $v_lex = 'yes';
} else {
    $v_lex = 'no';
}
// Check FTP option
if (!empty($_POST['v_additionalftpenabled'])) {
    $v_ftpx = 'yes';
} else {
    $v_ftpx = 'no';
}

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

if ((!isset($v_domain)) || ($v_domain == '')) { header('Location: ../add/domain.php?error=1');}
elseif ((!isset($_POST['v_ip'])) || ($_POST['v_ip'] == '')) { header('Location: ../add/domain.php?error=1');}
else {
    if(checkService('nginx') !== false) {
    $postvars0 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_ip'], 'arg4' => 'no', 'arg5' => $alias, 'arg6' => $prxext);
    }
    else {
        $postvars0 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_ip'], 'arg4' => 'no', 'arg5' => $alias); 
    }
    $curl0 = curl_init();
    curl_setopt($curl0, CURLOPT_URL, $vst_url);
    curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl0, CURLOPT_POST, true);
    curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars0));
    $r0 = curl_exec($curl0);
    
    if(checkService('nginx') !== false) {
        if ($v_prxx == 'no'){
            $postvars1 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-proxy','arg1' => $username,'arg2' => $v_domain, 'arg3' => 'no');

            $curl1 = curl_init();
            curl_setopt($curl1, CURLOPT_URL, $vst_url);
            curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl1, CURLOPT_POST, true);
            curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars1));
            $r1 = curl_exec($curl1);
        } else { $r1 = '0'; }
    } else { $r1 = '0'; }
    if(checkService('exim') !== false) {
        if (isset($_POST['v_mailenabled']) && $v_mailx == 'yes'){
            $postvars2 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-mail-domain','arg1' => $username,'arg2' => $v_domain);

            $curl2 = curl_init();
            curl_setopt($curl2, CURLOPT_URL, $vst_url);
            curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl2, CURLOPT_POST, true);
            curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars2));
            $r2 = curl_exec($curl2);
        } else { $r2 = '0'; } 
    } else { $r2 = '0'; }
    if(checkService('bind9') !== false) {
        if (isset($_POST['v_dnsenabled']) && $v_dnsx == 'yes'){
            $postvars3 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-dns-domain','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_ip'], 'arg4' => '', 'arg5' => '', 'arg6' => '', 'arg7' => '', 'arg8' => '', 'arg9' => '', 'arg10' => '', 'arg11' => '', 'arg12' => 'no');

            $curl3 = curl_init();
            curl_setopt($curl3, CURLOPT_URL, $vst_url);
            curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl3, CURLOPT_POST, true);
            curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars3));
            $r3 = curl_exec($curl3);
            foreach ($aliases_arr as $dnsalias) {
                if ($dnsalias != "www.".$_POST['v_domain']) {
                    $postvars4 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-dns-on-web-alias','arg1' => $username,'arg2' => $dnsalias, 'arg3' => $_POST['v_ip'], 'arg4' => 'no');

                    $curl4 = curl_init();
                    curl_setopt($curl4, CURLOPT_URL, $vst_url);
                    curl_setopt($curl4, CURLOPT_RETURNTRANSFER,true);
                    curl_setopt($curl4, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($curl4, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($curl4, CURLOPT_POST, true);
                    curl_setopt($curl4, CURLOPT_POSTFIELDS, http_build_query($postvars4));
                    $r4 = curl_exec($curl4);
                } else {$r4 = '0';}
            }
        } else { $r3 = '0'; $r4 = '0';}
    } else { $r3 = '0'; $r4 = '0';}
    if ((!empty($_POST['v_webstats'])) && ($_POST['v_webstats'] != 'none' )){
        $postvars5 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-stats','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_webstats']);

        $curl5 = curl_init();
        curl_setopt($curl5, CURLOPT_URL, $vst_url);
        curl_setopt($curl5, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl5, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl5, CURLOPT_POST, true);
        curl_setopt($curl5, CURLOPT_POSTFIELDS, http_build_query($postvars5));
        $r5 = curl_exec($curl5);
    } else { $r5 = '0'; }
    if ((!empty($_POST['v_webstats'])) && ($_POST['v_webstats'] != 'none') && (!empty($_POST['v_statsuname'])) && (!empty($_POST['v_statspassword']))) {
        $postvars6 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-stats-user','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_statsuname'], 'arg4' => $_POST['v_statspassword']);

        $curl6 = curl_init();
        curl_setopt($curl6, CURLOPT_URL, $vst_url);
        curl_setopt($curl6, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl6, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl6, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl6, CURLOPT_POST, true);
        curl_setopt($curl6, CURLOPT_POSTFIELDS, http_build_query($postvars6));
        $r6 = curl_exec($curl6);
    } else { $r6 = '0'; }
    if ($v_lex == 'yes') {
        $postvars7 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-schedule-letsencrypt-domain','arg1' => $username,'arg2' => $v_domain);

        $curl7 = curl_init();
        curl_setopt($curl7, CURLOPT_URL, $vst_url);
        curl_setopt($curl7, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl7, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl7, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl7, CURLOPT_POST, true);
        curl_setopt($curl7, CURLOPT_POSTFIELDS, http_build_query($postvars7));
        $r7 = curl_exec($curl7);

    } 
    elseif ($v_sslx == 'yes'  && isset($_POST['v_ssldir']) && isset($_POST['v_sslcrt']) && isset($_POST['v_sslkey'])  && $apienabled != 'true') {
        if(checkService('vsftpd') !== false || checkService('proftpd') !== false) {
        $writestr1 = str_replace("\r\n", "\n",  $_POST['v_sslcrt']);
        $writestr2 = str_replace("\r\n", "\n",  $_POST['v_sslkey']);
        ftp_file_put_contents($v_domain . '.crt', $writestr1);
        ftp_file_put_contents($v_domain . '.key', $writestr2);
        
        if(isset($_POST['v_sslca'])) {
            $writestr3 = str_replace("\r\n", "\n",  $_POST['v_sslca']);
            ftp_file_put_contents($v_domain . '.ca', $writestr);
        }
        
        $postvars8 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-ssl','arg1' => $username, 'arg2' => $v_domain, 'arg3'=> "/home/admin/", 'arg4' => $_POST['v_ssldir']);
        
        $curl8 = curl_init();
        curl_setopt($curl8, CURLOPT_URL, $vst_url);
        curl_setopt($curl8, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl8, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl8, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl8, CURLOPT_POST, true);
        curl_setopt($curl8, CURLOPT_POSTFIELDS, http_build_query($postvars8));
        $r7 = curl_exec($curl8);
        
        sleep(5); // Give Vesta some time to process files before deleting.

        $ftp_server=VESTA_HOST_ADDRESS; 
        $ftp_user_name=VESTA_ADMIN_UNAME; 
        $ftp_user_pass=VESTA_ADMIN_PW;
        $ftp_conn=ftp_connect($ftp_server); 
        $login_result = ftp_login($ftp_conn, $ftp_user_name, $ftp_user_pass);
        ftp_delete($ftp_conn, $v_domain . '.crt');
        ftp_delete($ftp_conn, $v_domain . '.key');
        
        if(isset($_POST['v_sslca']) && $_POST['v_sslca'] != '') {
            ftp_delete($ftp_conn, $v_domain . '.ca');
        }
        }
        else { $r7 = '0';}
        
    }
    else { $r7 = '0';}
    if ($v_ftpx == 'yes') {
        $r8 = 0;
        if (isset($_POST['v_ftpuname1']) && $_POST['v_ftpuname1'] != '') {
            $ftpstart = 1;
            do {
                if($_POST['v_ftpuname' . $ftpstart] != '' && $_POST['v_ftppw' . $ftpstart] != '') {

                    ${'curlftp' . $ftpstart} = curl_init();
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_URL, $vst_url);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_RETURNTRANSFER,true);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_POST, true);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-add-web-domain-ftp','arg1' => $username,'arg2' => $v_domain,'arg3' => $_POST['v_ftpuname'.$ftpstart],'arg4' => $_POST['v_ftppw'.$ftpstart],'arg5' => $_POST['v_ftpdir'.$ftpstart])));
                    $r8 = $r8 + curl_exec(${'curlftp' . $ftpstart});
                    
                    if($phpmailenabled == "true" && isset($_POST['v_ftpnotif'.$ftpstart]) && $_POST['v_ftpnotif'.$ftpstart] != '') {

                        $mail = new PHPMailer;
                        $mail->setFrom($mailfrom, $mailname);
                        $mail->addAddress($_POST['v_ftpnotif'.$ftpstart]);
                        $mail->Subject = 'FTP Credentials';
                        $mail->Body = 'FTP Account has been created successfully.<br><br>Domain: ' . $v_domain . '<br>Username: ' . $username . '_' . $_POST['v_ftpuname'.$ftpstart] . '<br>Password: ' . $_POST['v_ftppw'.$ftpstart]; 
                        $mail->AltBody = 'FTP Account has been created successfully.\n\n>Domain: ' . $v_domain . '\nUsername: ' . $username . '_' . $_POST['v_ftpuname'.$ftpstart] . '\nPassword: ' . $_POST['v_ftppw'.$ftpstart]; 

                        if($smtpenabled == "true" && $smtphost != '' && $smtpport != '') {
                            $mail->isSMTP();
                            $mail->SMTPDebug = 0;
                            $mail->Host = $smtphost;
                            $mail->Port = $smtpport;
                            if($smtpauth == "true") {
                                $mail->SMTPAuth = true;
                                $mail->Username = $smtpuname;
                                $mail->Password = $smtppw;
                            }
                            if($smtpenc == 'tls') {
                             $mail->SMTPSecure = 'tls';  
                            }
                            elseif($smtpenc == 'ssl') {
                             $mail->SMTPSecure = 'ssl';  
                            }
                        }
                        $mail->send();
                    }
                    
                }
                $ftpstart++;
            }
            while (isset($_POST['v_ftpuname' . $ftpstart]));
        }
    }
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

        <form id="form" action="../list/web.php" method="post">
            <?php 
            echo '<input type="hidden" name="a1" value="'.$r0.'">';
            echo '<input type="hidden" name="a2" value="'.$r1.'">';
            echo '<input type="hidden" name="a3" value="'.$r2.'">';
            echo '<input type="hidden" name="a4" value="'.$r3.'">';
            echo '<input type="hidden" name="a5" value="'.$r4.'">';
            echo '<input type="hidden" name="a6" value="'.$r5.'">';
            echo '<input type="hidden" name="a7" value="'.$r6.'">';
            echo '<input type="hidden" name="a8" value="'.$r7.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../plugins/components/jquery/jquery.min.js"></script>
</html>