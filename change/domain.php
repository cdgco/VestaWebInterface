<?php

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2019 Carter Roeser <carter@cdgtech.one>
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

// Remove www. from domain and lowercase
$v_domain = $_POST['v_domain'];

// Define proxy extensions
$v_proxy_ext = $_POST['v_prxext'];
if ($v_proxy_ext == ''){ $v_proxy_ext = 'jpeg, jpg, png, gif, bmp, ico, svg, tif, tiff, css, js, htm, html, ttf, otf, webp, woff, txt, csv, rtf, doc, docx, xls, xlsx, ppt, pptx, odf, odp, ods, odt, pdf, psd, ai, eot, eps, ps, zip, tar, tgz, gz, rar, bz2, 7z, aac, m4a, mp3, mp4, ogg, wav, wma, 3gp, avi, flv, m4v, mkv, mov, mp4, mpeg, mpg, wmv, exe, iso, dmg, swf';}
$proxy_ext = preg_replace("/\n/", ",", $v_proxy_ext);
$proxy_ext = preg_replace("/\r/", ",", $proxy_ext);
$proxy_ext = preg_replace("/\t/", ",", $proxy_ext);
$proxy_ext = preg_replace("/ /", ",", $proxy_ext);
$proxy_ext_arr = explode(",", $proxy_ext);
$proxy_ext_arr = array_unique($proxy_ext_arr);
$proxy_ext_arr = array_filter($proxy_ext_arr);
$prxext = implode(",",$proxy_ext_arr);

// Check Proxy option
if (isset($_POST['v_prxenabled']) && !empty($_POST['v_prxenabled'])) {
    $v_prxx = 'yes';
} else {
    $v_prxx = 'no';
}
if (isset($_POST['v_prxenabled-x'])) {
    $v_prxx_x = $_POST['v_prxenabled-x'];
}
// Check SSL option
if (isset($_POST['v_sslenabled']) && !empty($_POST['v_sslenabled'])) {
    $v_sslx = 'yes';
} else {
    $v_sslx = 'no';
}
// Check Let's Encrypt option
if (isset($_POST['v_leenabled']) && !empty($_POST['v_leenabled'])) {
    $v_lex = 'yes';
} else {
    $v_lex = 'no';
}
// Check Stats Auth option
if (isset($_POST['v_statsuserenabled']) && !empty($_POST['v_statsuserenabled'])) {
    $v_statsuserenabled = 'yes';
} else {
    $v_statsuserenabled = 'no';
}
// Check FTP option
if (isset($_POST['v_additionalftpenabled']) && !empty($_POST['v_additionalftpenabled'])) {
    $v_ftpx = 'yes';
} else {
    $v_ftpx = 'no';
}
if (isset($_POST['v_additionalftpenabled-x'])) {
    $v_ftpx_x = $_POST['v_additionalftpenabled-x'];
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

if ((!isset($v_domain)) || ($v_domain == '')) { header('Location: ../list/web.php?error=1');}
else {
    if ($_POST['v_ip-x'] != $_POST['v_ip']){
        $postvars0 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-ip','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_ip']);

        $curl0 = curl_init();
        curl_setopt($curl0, CURLOPT_URL, $vst_url);
        curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl0, CURLOPT_POST, true);
        curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars0));
        $r0 = curl_exec($curl0);
    } else { $r0 = '0'; }
    // Change account aliases
    $valiases = explode(",", $_POST['v_alias-x']);
    $waliases = preg_replace("/\n/", " ", $_POST['v_alias']);
    $waliases = preg_replace("/,/", " ", $waliases);
    $waliases = preg_replace('/\s+/', ' ',$waliases);
    $waliases = trim($waliases);
    $aliases = explode(" ", $waliases);
    $v_aliases = str_replace(' ', "\n", $waliases);
    $result = array_diff($valiases, $aliases);
    $r1 = '0';
    foreach ($result as $alias) {
        if (!empty($alias)) {
            $postvars1 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-alias','arg1' => $username,'arg2' => $v_domain, 'arg3' => $alias, 'arg4' => 'no');

            $curl1 = curl_init();
            curl_setopt($curl1, CURLOPT_URL, $vst_url);
            curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl1, CURLOPT_POST, true);
            curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars1));
            $r1 = curl_exec($curl1);
        }
    }
    $result = array_diff($aliases, $valiases);
    foreach ($result as $alias) {
        if (!empty($alias)) {
            $postvars1 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-alias','arg1' => $username,'arg2' => $v_domain, 'arg3' => $alias, 'arg4' => 'no');

            $curl1 = curl_init();
            curl_setopt($curl1, CURLOPT_URL, $vst_url);
            curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl1, CURLOPT_POST, true);
            curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars1));
            $r1 = curl_exec($curl1);
        }
    }
    if ($_POST['v_tpl-x'] != $_POST['v_tpl']){
        $postvars2 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-tpl','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_tpl']);

        $curl2 = curl_init();
        curl_setopt($curl2, CURLOPT_URL, $vst_url);
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl2, CURLOPT_POST, true);
        curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query($postvars2));
        $r2 = curl_exec($curl2);
    }
    else { $r2 = '0'; }
    if (isset($_POST['v_prxenabled']) && $v_prxx != $v_prxx_x && $v_prxx == 'yes' && $v_prxx_x == 'no'){
        $postvars3 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-proxy','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_prxtpl'], 'arg4' => $prxext, 'arg5' => 'no');

        $curl3 = curl_init();
        curl_setopt($curl3, CURLOPT_URL, $vst_url);
        curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl3, CURLOPT_POST, true);
        curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars3));
        $r3 = curl_exec($curl3);
    } else { $r3 = '0'; }
    if (isset($_POST['v_prxenabled']) && $v_prxx != $v_prxx_x && $v_prxx == 'no' && $v_prxx_x == 'yes'){
        $postvars3 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-proxy','arg1' => $username,'arg2' => $v_domain);

        $curl3 = curl_init();
        curl_setopt($curl3, CURLOPT_URL, $vst_url);
        curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl3, CURLOPT_POST, true);
        curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query($postvars3));
        $r3 = curl_exec($curl3);
        if ($r3 == '3') { $r3 = '0';}
    } else { $r3 = '0'; }
    if (isset($_POST['v_prxenabled']) && $v_prxx == 'yes' && $_POST['v_prxtpl-x'] != $_POST['v_prxtpl'] || (isset($_POST['v_prxext-x']) && $_POST['v_prxext-x'] != '' && $_POST['v_prxext-x'] != $prxext) ){
        $postvars4 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-proxy-tpl','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_prxtpl'], 'arg4' => $prxext, 'arg5' => 'no');

        $curl4 = curl_init();
        curl_setopt($curl4, CURLOPT_URL, $vst_url);
        curl_setopt($curl4, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl4, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl4, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl4, CURLOPT_POST, true);
        curl_setopt($curl4, CURLOPT_POSTFIELDS, http_build_query($postvars4));
        $r4 = curl_exec($curl4);
        if ($r4 == '3') { $r4 = '0';}
    } else { $r4 = '0'; }
    if (($_POST['v_webstats'] != 'none')  && ($_POST['v_webstats-x'] == 'none')){
        $postvars5 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-stats','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_webstats']);

        $curl5 = curl_init();
        curl_setopt($curl5, CURLOPT_URL, $vst_url);
        curl_setopt($curl5, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl5, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl5, CURLOPT_POST, true);
        curl_setopt($curl5, CURLOPT_POSTFIELDS, http_build_query($postvars5));
        $r5 = curl_exec($curl5);
    }
    elseif (($_POST['v_webstats'] == 'none') && ($_POST['v_webstats'] != $_POST['v_webstats-x'])){
        $postvars5 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-stats','arg1' => $username,'arg2' => $v_domain);

        $curl5 = curl_init();
        curl_setopt($curl5, CURLOPT_URL, $vst_url);
        curl_setopt($curl5, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl5, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl5, CURLOPT_POST, true);
        curl_setopt($curl5, CURLOPT_POSTFIELDS, http_build_query($postvars5));
        $r5 = curl_exec($curl5);
    }
    elseif (($_POST['v_webstats'] != 'none') && ($_POST['v_webstats-x'] != 'none')){
        $postvars5 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-stats','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_webstats']);

        $curl5 = curl_init();
        curl_setopt($curl5, CURLOPT_URL, $vst_url);
        curl_setopt($curl5, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl5, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl5, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl5, CURLOPT_POST, true);
        curl_setopt($curl5, CURLOPT_POSTFIELDS, http_build_query($postvars5));
        $r5 = curl_exec($curl5);
    } else { $r5 = '0'; }

    if ($_POST['v_statsuserenabled'] != '' && $_POST['v_statsuserenabled'] != $_POST['v_statsuserenabled-x'] && !empty($_POST['v_statsuname']) && !empty($_POST['v_statspassword'])) {
        $postvars6 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-stats-user','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_statsuname'], 'arg4' => $_POST['v_statspassword']);

        $curl6 = curl_init();
        curl_setopt($curl6, CURLOPT_URL, $vst_url);
        curl_setopt($curl6, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl6, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl6, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl6, CURLOPT_POST, true);
        curl_setopt($curl6, CURLOPT_POSTFIELDS, http_build_query($postvars6));
        $r6 = curl_exec($curl6);
    } 
    elseif ($_POST['v_statsuserenabled'] == '' && $_POST['v_statsuserenabled'] != $_POST['v_statsuserenabled-x'] || $_POST['v_statuname'] == '' && $_POST['v_statsuname'] != $_POST['v_statsuname-x'] || $_POST['v_webstats'] == 'none' && $_POST['v_webstats'] != $_POST['v_webstats-x']) {
        $postvars6 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-stats-user','arg1' => $username,'arg2' => $v_domain, 'arg3' => $_POST['v_statsuname'], 'arg4' => $_POST['v_statspassword']);

        $curl6 = curl_init();
        curl_setopt($curl6, CURLOPT_URL, $vst_url);
        curl_setopt($curl6, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl6, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl6, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl6, CURLOPT_POST, true);
        curl_setopt($curl6, CURLOPT_POSTFIELDS, http_build_query($postvars6));
        $r6 = curl_exec($curl6);
    } else { $r6 = '0'; }
    if ($v_lex == 'yes' && $v_lex != $_POST['v_leenabled-x']) {
        $postvars7 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-schedule-letsencrypt-domain','arg1' => $username,'arg2' => $v_domain);

        $curl7 = curl_init();
        curl_setopt($curl7, CURLOPT_URL, $vst_url);
        curl_setopt($curl7, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl7, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl7, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl7, CURLOPT_POST, true);
        curl_setopt($curl7, CURLOPT_POSTFIELDS, http_build_query($postvars7));
        $r7 = curl_exec($curl7);
        if ($r7 == 'OK') { $r4 = '0';}   
    } 
    elseif ($v_lex == 'no' && $v_lex != $_POST['v_leenabled-x']) {
        $postvars7 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-letsencrypt-domain','arg1' => $username,'arg2' => $v_domain, 'arg3' => 'no');

        $curl7 = curl_init();
        curl_setopt($curl7, CURLOPT_URL, $vst_url);
        curl_setopt($curl7, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl7, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl7, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl7, CURLOPT_POST, true);
        curl_setopt($curl7, CURLOPT_POSTFIELDS, http_build_query($postvars7));
        $r7 = curl_exec($curl7);
        if ($r7 == 'OK') { $r4 = '0';} 
    } else { $r7= '0'; }
    if(checkService('vsftpd') !== false || checkService('proftpd') !== false) {
        if ($v_sslx == 'no' && $v_sslx != $_POST['v_sslenabled-x']) {
            $postvars8 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-ssl','arg1' => $username,'arg2' => $v_domain, 'arg3' => 'no');

            $curl8 = curl_init();
            curl_setopt($curl8, CURLOPT_URL, $vst_url);
            curl_setopt($curl8, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl8, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl8, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl8, CURLOPT_POST, true);
            curl_setopt($curl8, CURLOPT_POSTFIELDS, http_build_query($postvars8));
            $r8 = curl_exec($curl8); 
        } 
        elseif ($v_sslx == 'yes' && $v_sslx == $_POST['v_sslenabled-x'] && ( $_POST['v_sslcrt'] != $_POST['v_sslcrt-x'] || $_POST['v_sslkey'] != $_POST['v_sslkey-x'] || $_POST['v_sslca'] != $_POST['v_sslca-x']) && $apienabled != 'true') {

            $writestr1 = str_replace("\r\n", "\n",  $_POST['v_sslcrt']);
            $writestr2 = str_replace("\r\n", "\n",  $_POST['v_sslkey']);
            ftp_file_put_contents($v_domain . '.crt', $writestr1);
            ftp_file_put_contents($v_domain . '.key', $writestr2);

            if(isset($_POST['v_sslca'])) {
                $writestr3 = str_replace("\r\n", "\n",  $_POST['v_sslca']);
                ftp_file_put_contents($v_domain . '.ca', $writestr);
            }

            $postvars8 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-sslcert','arg1' => $username, 'arg2' => $v_domain, 'arg3'=> "/home/admin/");

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

            if(isset($_POST['v_sslca']) && $_POST['v_sslca'] != '') {
                ftp_delete($ftp_conn, $v_domain . '.ca');
            }   

            if($_POST['v_ssldir'] != $_POST['v_ssldir-x']) {

                $postvars9 = array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-sslhome','arg1' => $username, 'arg2' => $v_domain, 'arg3'=> $_POST['v_ssldir']);

                $curl9 = curl_init();
                curl_setopt($curl9, CURLOPT_URL, $vst_url);
                curl_setopt($curl9, CURLOPT_RETURNTRANSFER,true);
                curl_setopt($curl9, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($curl9, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($curl9, CURLOPT_POST, true);
                curl_setopt($curl9, CURLOPT_POSTFIELDS, http_build_query($postvars9));
                curl_exec($curl9);

            }
        } 
        elseif ($v_sslx == 'yes' && $v_sslx != $_POST['v_sslenabled-x'] && $apienabled != 'true') {

            $writestr1 = str_replace("\r\n", "\n",  $_POST['v_sslcrt']);
            $writestr2 = str_replace("\r\n", "\n",  $_POST['v_sslkey']);
            ftp_file_put_contents($v_domain . '.crt', $writestr1);
            ftp_file_put_contents($v_domain . '.key', $writestr2);

            if(isset($_POST['v_sslca']) && $_POST['v_sslca'] != '') {
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
            $r8 = curl_exec($curl8);

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


        } else { $r8= '0'; }
    } else { $r8= '0'; }
    
    
    // CREAETE: If Additional FTP was disabled and is now enabled, add all Additional FTP Users.
    if($v_ftpx == 'yes' && $v_ftpx_x == 'no') {
        $r9 = 0;
        // Check if FTP user #1 is present, if so continue.
        if (isset($_POST['v_ftpuname1']) && $_POST['v_ftpuname1'] != '')  {
            $ftpstart = 1;
            // For each FTP User present, add account and send email (if specified).
            do {
                if($_POST['v_ftpuname' . $ftpstart] != '' && $_POST['v_ftppw' . $ftpstart] != '' && !isset($_POST['v_ftpuname-x' . $ftpstart])) {
                    ${'curlftp' . $ftpstart} = curl_init();
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_URL, $vst_url);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_RETURNTRANSFER,true);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_POST, true);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-ftp','arg1' => $username,'arg2' => $v_domain,'arg3' => $_POST['v_ftpuname'.$ftpstart],'arg4' => $_POST['v_ftppw'.$ftpstart],'arg5' => $_POST['v_ftpdir'.$ftpstart])));
                    $r9 = $r9 + curl_exec(${'curlftp' . $ftpstart});
                    // If PHPMailer system is enabled and user requests email, continue.
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
    } else { $r9 = 0; }
    // DELETE: If Additional FTP was enabled and is now disabled, delete all Additional FTP Users.
    if($v_ftpx == 'no' && $v_ftpx_x == 'yes') {
        $r10 = 0;
        if (isset($_POST['v_ftpuname-x1']) && $_POST['v_ftpuname-x1'] != '')  {
            $ftpstart = 1;
            do {
                if(isset($_POST['v_ftpuname-x' . $ftpstart]) && $_POST['v_ftpuname-x' . $ftpstart] != '') {
                    ${'curlftp' . $ftpstart} = curl_init();
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_URL, $vst_url);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_RETURNTRANSFER,true);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_POST, true);
                    curl_setopt(${'curlftp' . $ftpstart}, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-ftp','arg1' => $username,'arg2' => $v_domain,'arg3' => $username.'_'.$_POST['v_ftpuname-x'.$ftpstart])));
                    $r10 = curl_exec(${'curlftp' . $ftpstart});

                }
                $ftpstart++;
            }
            while (isset($_POST['v_ftpuname-x' . $ftpstart]));
        }
    } else { $r10 = 0; }
    // CHANGE: If Additional FTP was enabled and is still enabled, check all form values for changes.
    if($v_ftpx == 'yes' && $v_ftpx_x == 'yes') {  
        $r11 = 0;
        $ftpstart = 1;
        $SafeUsernameList = [];
        // For each FTP User sent, evaulate the following 5 logic statements.
        do {
            // L1 (Change Password): If FTP Username is the same and password is set, continue.
            if(isset($_POST['v_ftpuname' . $ftpstart]) && $_POST['v_ftpuname' . $ftpstart] != '' && isset($_POST['v_ftpuname-x' . $ftpstart]) && $_POST['v_ftpuname-x' . $ftpstart] != '' && $_POST['v_ftpuname' . $ftpstart] == $_POST['v_ftpuname-x' . $ftpstart] && isset($_POST['v_ftppw' . $ftpstart]) && $_POST['v_ftppw' . $ftpstart] != '') {
                ${'curlftpa' . $ftpstart} = curl_init();
                curl_setopt(${'curlftpa' . $ftpstart}, CURLOPT_URL, $vst_url);
                curl_setopt(${'curlftpa' . $ftpstart}, CURLOPT_RETURNTRANSFER,true);
                curl_setopt(${'curlftpa' . $ftpstart}, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt(${'curlftpa' . $ftpstart}, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt(${'curlftpa' . $ftpstart}, CURLOPT_POST, true);
                curl_setopt(${'curlftpa' . $ftpstart}, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-ftp-password','arg1' => $username,'arg2' => $v_domain,'arg3' => $username.'_'.$_POST['v_ftpuname'.$ftpstart],'arg4' => $_POST['v_ftppw'.$ftpstart])));
                $r11 = $r11 + curl_exec(${'curlftpa' . $ftpstart});
            }
            // L2 (Change Directory): If FTP Username is the same and FTP Directory has changed, continue.
            if(isset($_POST['v_ftpuname' . $ftpstart]) && $_POST['v_ftpuname' . $ftpstart] != '' && isset($_POST['v_ftpuname-x' . $ftpstart]) && $_POST['v_ftpuname-x' . $ftpstart] != '' && $_POST['v_ftpuname' . $ftpstart] == $_POST['v_ftpuname-x' . $ftpstart] && isset($_POST['v_ftpdir' . $ftpstart]) && $_POST['v_ftpdir' . $ftpstart] != ''  && isset($_POST['v_ftpdir-x' . $ftpstart]) && $_POST['v_ftpdir-x' . $ftpstart] != '' && $_POST['v_ftpdir' . $ftpstart] != $_POST['v_ftpdir-x' . $ftpstart]) {
                ${'curlftpb' . $ftpstart} = curl_init();
                curl_setopt(${'curlftpb' . $ftpstart}, CURLOPT_URL, $vst_url);
                curl_setopt(${'curlftpb' . $ftpstart}, CURLOPT_RETURNTRANSFER,true);
                curl_setopt(${'curlftpb' . $ftpstart}, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt(${'curlftpb' . $ftpstart}, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt(${'curlftpb' . $ftpstart}, CURLOPT_POST, true);
                curl_setopt(${'curlftpb' . $ftpstart}, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-ftp-path','arg1' => $username,'arg2' => $v_domain,'arg3' => $username.'_'.$_POST['v_ftpuname'.$ftpstart],'arg4' => $_POST['v_ftpdir'.$ftpstart])));
                $r11 = $r11 + curl_exec(${'curlftpb' . $ftpstart});
            }
            // L3 (Change Account): If Username is different and password is set, continue.
            if(isset($_POST['v_ftpuname' . $ftpstart]) && $_POST['v_ftpuname' . $ftpstart] != '' && isset($_POST['v_ftpuname-x' . $ftpstart]) && $_POST['v_ftpuname-x' . $ftpstart] != '' && $_POST['v_ftpuname-x' . $ftpstart] != $_POST['v_ftpuname' . $ftpstart] && isset($_POST['v_ftppw' . $ftpstart]) && $_POST['v_ftppw' . $ftpstart] != '') {
                ${'curlftpc' . $ftpstart} = curl_init();
                curl_setopt(${'curlftpc' . $ftpstart}, CURLOPT_URL, $vst_url);
                curl_setopt(${'curlftpc' . $ftpstart}, CURLOPT_RETURNTRANSFER,true);
                curl_setopt(${'curlftpc' . $ftpstart}, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt(${'curlftpc' . $ftpstart}, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt(${'curlftpc' . $ftpstart}, CURLOPT_POST, true);
                curl_setopt(${'curlftpc' . $ftpstart}, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-ftp','arg1' => $username,'arg2' => $v_domain,'arg3' => $username.'_'.$_POST['v_ftpuname-x'.$ftpstart])));
                $r11 = $r11 + curl_exec(${'curlftpc' . $ftpstart});
                
                array_push($SafeUsernameList, $_POST['v_ftpuname'.$ftpstart]);
                ${'curlftpd' . $ftpstart} = curl_init();
                curl_setopt(${'curlftpd' . $ftpstart}, CURLOPT_URL, $vst_url);
                curl_setopt(${'curlftpd' . $ftpstart}, CURLOPT_RETURNTRANSFER,true);
                curl_setopt(${'curlftpd' . $ftpstart}, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt(${'curlftpd' . $ftpstart}, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt(${'curlftpd' . $ftpstart}, CURLOPT_POST, true);
                curl_setopt(${'curlftpd' . $ftpstart}, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-ftp','arg1' => $username,'arg2' => $v_domain,'arg3' => $_POST['v_ftpuname'.$ftpstart],'arg4' => $_POST['v_ftppw'.$ftpstart],'arg5' => $_POST['v_ftpdir'.$ftpstart])));
                
                $r11p1 = curl_exec(${'curlftpd' . $ftpstart});
                if($r11p1 == '4') {
                    ${'curlftpg' . $ftpstart} = curl_init();
                    curl_setopt(${'curlftpg' . $ftpstart}, CURLOPT_URL, $vst_url);
                    curl_setopt(${'curlftpg' . $ftpstart}, CURLOPT_RETURNTRANSFER,true);
                    curl_setopt(${'curlftpg' . $ftpstart}, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt(${'curlftpg' . $ftpstart}, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt(${'curlftpg' . $ftpstart}, CURLOPT_POST, true);
                    curl_setopt(${'curlftpg' . $ftpstart}, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-ftp-password','arg1' => $username,'arg2' => $v_domain,'arg3' => $username.'_'.$_POST['v_ftpuname'.$ftpstart],'arg4' => $_POST['v_ftppw'.$ftpstart])));
                    $r11p2 = curl_exec(${'curlftpg' . $ftpstart});
                    
                    ${'curlftph' . $ftpstart} = curl_init();
                    curl_setopt(${'curlftph' . $ftpstart}, CURLOPT_URL, $vst_url);
                    curl_setopt(${'curlftph' . $ftpstart}, CURLOPT_RETURNTRANSFER,true);
                    curl_setopt(${'curlftph' . $ftpstart}, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt(${'curlftph' . $ftpstart}, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt(${'curlftph' . $ftpstart}, CURLOPT_POST, true);
                    curl_setopt(${'curlftph' . $ftpstart}, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-web-domain-ftp-path','arg1' => $username,'arg2' => $v_domain,'arg3' => $username.'_'.$_POST['v_ftpuname'.$ftpstart],'arg4' => $_POST['v_ftpdir'.$ftpstart])));
                    $r11p3 = curl_exec(${'curlftph' . $ftpstart});
                    
                    $r11 = $r11 + $r11p2 + $r11p3;
                }
                else { $r11 = $r11 + $r11p1; }
                
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
            // L4 (Create Account): If account is set and did not previously exist, continue.
            if((isset($_POST['v_ftpuname' . $ftpstart]) && $_POST['v_ftpuname' . $ftpstart] != '') && (!isset($_POST['v_ftpuname-x' . $ftpstart]) || $_POST['v_ftpuname-x' . $ftpstart] == '') && isset($_POST['v_ftppw' . $ftpstart]) && $_POST['v_ftppw' . $ftpstart] != '') {
                array_push($SafeUsernameList, $_POST['v_ftpuname'.$ftpstart]);
                ${'curlftpe' . $ftpstart} = curl_init();
                curl_setopt(${'curlftpe' . $ftpstart}, CURLOPT_URL, $vst_url);
                curl_setopt(${'curlftpe' . $ftpstart}, CURLOPT_RETURNTRANSFER,true);
                curl_setopt(${'curlftpe' . $ftpstart}, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt(${'curlftpe' . $ftpstart}, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt(${'curlftpe' . $ftpstart}, CURLOPT_POST, true);
                curl_setopt(${'curlftpe' . $ftpstart}, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-web-domain-ftp','arg1' => $username,'arg2' => $v_domain,'arg3' => $_POST['v_ftpuname'.$ftpstart],'arg4' => $_POST['v_ftppw'.$ftpstart],'arg5' => $_POST['v_ftpdir'.$ftpstart])));
                $r11 = $r11 + curl_exec(${'curlftpe' . $ftpstart});

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
            // L5 (Delete Account): If account was present but is no longer, continue.
            if(isset($_POST['v_ftpuname-x' . $ftpstart]) && $_POST['v_ftpuname-x' . $ftpstart] != '' && (!isset($_POST['v_ftpuname' . $ftpstart]) || $_POST['v_ftpuname' . $ftpstart] == '') && $SafeUsernameList['v_ftpuname' . $ftpstart] === false) {
                ${'curlftpf' . $ftpstart} = curl_init();
                curl_setopt(${'curlftpf' . $ftpstart}, CURLOPT_URL, $vst_url);
                curl_setopt(${'curlftpf' . $ftpstart}, CURLOPT_RETURNTRANSFER,true);
                curl_setopt(${'curlftpf' . $ftpstart}, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt(${'curlftpf' . $ftpstart}, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt(${'curlftpf' . $ftpstart}, CURLOPT_POST, true);
                curl_setopt(${'curlftpf' . $ftpstart}, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-web-domain-ftp','arg1' => $username,'arg2' => $v_domain,'arg3' => $username.'_'.$_POST['v_ftpuname-x'.$ftpstart])));
                $r11 = $r11 + curl_exec(${'curlftpf' . $ftpstart});
            }            $ftpstart++;
        }
        while (isset($_POST['v_ftpuname' . $ftpstart]) || isset($_POST['v_ftpuname-x' . $ftpstart]));
    } else { $r11 = 0; }
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
        <form id="form" action="../edit/domain.php?domain=<?php echo $v_domain; ?>" method="post">
            <?php 
            echo '<input type="hidden" name="r1" value="'.$r0.'">';
            echo '<input type="hidden" name="r2" value="'.$r1.'">';
            echo '<input type="hidden" name="r3" value="'.$r2.'">';
            echo '<input type="hidden" name="r4" value="'.$r3.'">';
            echo '<input type="hidden" name="r5" value="'.$r4.'">';
            echo '<input type="hidden" name="r6" value="'.$r5.'">';
            echo '<input type="hidden" name="r7" value="'.$r8.'">';
            echo '<input type="hidden" name="r8" value="'.$r7.'">';
            echo '<input type="hidden" name="r9" value="'.$r6.'">';
            echo '<input type="hidden" name="r10" value="'.$r9.'">';
            echo '<input type="hidden" name="r11" value="'.$r10.'">';
            echo '<input type="hidden" name="r12" value="'.$r11.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../plugins/components/jquery/jquery.min.js"></script>
</html>