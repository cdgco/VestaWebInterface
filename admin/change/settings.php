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

function check_file_uploaded_name ($filename) { return (bool) ((preg_match("`^[-0-9A-Z_\.]+$`i",$filename)) ? true : false); }
function check_file_uploaded_length ($filename) { return (bool) ((mb_strlen($filename,"UTF-8") > 225) ? true : false); }

$conn=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db); $r1 = 0;

// Individually Update Settings
if(isset($_POST['resetdefault']) && $_POST['resetdefault'] != 'yes') { 
    $query = '';
    
    /*
    * Server Configuration Section
    */
    
    if(isset($_POST['TIMEZONE']) && $config["TIMEZONE"] != $_POST['TIMEZONE']) { 
        $_timezone = mysqli_real_escape_string($conn, $_POST['TIMEZONE']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_timezone."' WHERE `VARIABLE` = 'TIMEZONE';";
    } 
    if(isset($_POST['SITENAME']) && $sitetitle != $_POST['SITENAME']) {
        $_sitename = mysqli_real_escape_string($conn, $_POST['SITENAME']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_sitename."' WHERE `VARIABLE` = 'SITE_NAME';";
    } 
    if(isset($_POST['THEME']) && $config["THEME"] != $_POST['THEME']) { 
        $_theme = mysqli_real_escape_string($conn, $_POST['THEME']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_theme."' WHERE `VARIABLE` = 'THEME';";
    } 
    if(isset($_POST['color1']) && $config["CUSTOM_THEME_PRIMARY"] != $_POST['color1']) { 
        $_color1 = mysqli_real_escape_string($conn, $_POST['color1']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_color1."' WHERE `VARIABLE` = 'CUSTOM_THEME_PRIMARY';";
    } 
    if(isset($_POST['color2']) && $config["CUSTOM_THEME_SECONDARY"] != $_POST['color2']) { 
        $_color2 = mysqli_real_escape_string($conn, $_POST['color2']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_color2."' WHERE `VARIABLE` = 'CUSTOM_THEME_SECONDARY';";
    } 
    if(isset($_POST['CUSTOM_FOOTER']) && $config["CUSTOM_FOOTER"] != $_POST['CUSTOM_FOOTER']) {
        $_custom_footer = mysqli_real_escape_string($conn, $_POST['CUSTOM_FOOTER']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_custom_footer."' WHERE `VARIABLE` = 'CUSTOM_FOOTER';";
    } 
    if(isset($_POST['FOOTER']) && $config["FOOTER"] != $_POST['FOOTER']) {
        $_footer = mysqli_real_escape_string($conn, $_POST['FOOTER']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_footer."' WHERE `VARIABLE` = 'FOOTER';";
    } 
    if(isset($_POST['VWI_BRANDING']) && $config["VWI_BRANDING"] != $_POST['VWI_BRANDING']) {
        $_branding = mysqli_real_escape_string($conn, $_POST['VWI_BRANDING']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_branding."' WHERE `VARIABLE` = 'VWI_BRANDING';";
    } 
    if(isset($_POST['LANGUAGE']) && $locale != $_POST['LANGUAGE']) { 
        $_language = mysqli_real_escape_string($conn, $_POST['LANGUAGE']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_language."' WHERE `VARIABLE` = 'LANGUAGE';";
    } 
    if(isset($_POST['DEFAULT_TO_ADMIN']) && $config["DEFAULT_TO_ADMIN"] != $_POST['DEFAULT_TO_ADMIN']) {
        $_default_to_admin = mysqli_real_escape_string($conn, $_POST['DEFAULT_TO_ADMIN']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_default_to_admin."' WHERE `VARIABLE` = 'DEFAULT_TO_ADMIN';";
    } 
    if(isset($_POST['VESTA_HOST_ADDRESS']) && $config["VESTA_HOST_ADDRESS"] != $_POST['VESTA_HOST_ADDRESS']) {
        $_host_address = mysqli_real_escape_string($conn, $_POST['VESTA_HOST_ADDRESS']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_host_address."' WHERE `VARIABLE` = 'VESTA_HOST_ADDRESS';";
    } 
    if(isset($_POST['VESTA_SSL_ENABLED']) && $config["VESTA_SSL_ENABLED"] != $_POST['VESTA_SSL_ENABLED']) { 
        $_ssl_enabled = mysqli_real_escape_string($conn, $_POST['VESTA_SSL_ENABLED']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_ssl_enabled."' WHERE `VARIABLE` = 'VESTA_SSL_ENABLED';";
    } 
    if(isset($_POST['VESTA_PORT']) && $config["VESTA_PORT"] != $_POST['VESTA_PORT']) { 
        $_port = mysqli_real_escape_string($conn, $_POST['VESTA_PORT']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_port."' WHERE `VARIABLE` = 'VESTA_PORT';";
    } 
    if(isset($_POST['VESTA_METHOD']) && $config["VESTA_METHOD"] != $_POST['VESTA_METHOD']) { 
        $_method = mysqli_real_escape_string($conn, $_POST['VESTA_METHOD']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_method."' WHERE `VARIABLE` = 'VESTA_METHOD';";
    } 
    if(isset($_POST['VESTA_API_KEY']) && $vst_apikey != $_POST['VESTA_API_KEY']) { 
        $enckey = vwicryptx($_POST['VESTA_API_KEY']);
        $_apikey = mysqli_real_escape_string($conn, $enckey);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_apikey."' WHERE `VARIABLE` = 'VESTA_API_KEY';";
    } 
    if(isset($_POST['VESTA_ADMIN_UNAME']) && $vst_username != $_POST['VESTA_ADMIN_UNAME']) { 
        $_admin_uname = mysqli_real_escape_string($conn, $_POST['VESTA_ADMIN_UNAME']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_admin_uname."' WHERE `VARIABLE` = 'VESTA_ADMIN_UNAME';";
    } 
    if(isset($_POST['VESTA_ADMIN_PW']) && $vst_password != $_POST['VESTA_ADMIN_PW']) { 
        $encpassword = vwicryptx($_POST['VESTA_ADMIN_PW']);
        $_admin_pw = mysqli_real_escape_string($conn, $encpassword);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_admin_pw."' WHERE `VARIABLE` = 'VESTA_ADMIN_PW';";
    }
    if(isset($_POST['KEY1']) && $key2 != $_POST['KEY1']) { 
        $_key1 = mysqli_real_escape_string($conn, $_POST['KEY1']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_key1."' WHERE `VARIABLE` = 'KEY1';";
    } 
    if(isset($_POST['KEY2']) && $key2 != $_POST['KEY2']) { 
        $_key2 = mysqli_real_escape_string($conn, $_POST['KEY2']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_key2."' WHERE `VARIABLE` = 'KEY2';";
    }
    if(isset($_FILES['FAVICON'])  && $_FILES['FAVICON']['name'] != ''){
        if($_FILES['FAVICON']['error'] > 0 && check_file_uploaded_name($_FILES['FAVICON']['name']) && check_file_uploaded_length($_FILES['FAVICON']['name']) && strpos(mime_content_type($_FILES['FAVICON']['tmp_name']), 'image') && strpos(mime_content_type($_FILES['FAVICON']['tmp_name']), 'ico')) { $r1++; }
        if (in_array(strtolower(substr(strrchr($_FILES['FAVICON']['name'], '.'), 1)), array('ico'))) { 
            $result3 = move_uploaded_file($_FILES['FAVICON']['tmp_name'], "../../plugins/images/uploads/{$_FILES['FAVICON']['name']}");
            if($result3){
                $_favicon = mysqli_real_escape_string($conn, "uploads/" . $_FILES['FAVICON']['name']);
                $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_favicon."' WHERE `VARIABLE` = 'FAVICON';";
            } else { $r1++; }
        } else { $r1++; }
    }
    if(isset($_FILES['ICON']) && $_FILES['ICON']['name'] != ''){
        if($_FILES['ICON']['error'] > 0 && check_file_uploaded_name($_FILES['ICON']['name']) && check_file_uploaded_length($_FILES['ICON']['name']) && strpos(mime_content_type($_FILES['ICON']['tmp_name']), 'image')) { $r1++; }
        if (in_array(strtolower(substr(strrchr($_FILES['ICON']['name'], '.'), 1)), array('jpg', 'jpeg', 'png', 'gif'))) { 
            $result1 = move_uploaded_file($_FILES['ICON']['tmp_name'], "../../plugins/images/uploads/{$_FILES['ICON']['name']}");
            if($result1){
                $_icon = mysqli_real_escape_string($conn, "uploads/" . $_FILES['ICON']['name']);
                $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_icon."' WHERE `VARIABLE` = 'ICON';";
            } else { $r1++; }
        } else { $r1++; }
    }
    if(isset($_FILES['LOGO'])  && $_FILES['LOGO']['name'] != ''){
        if($_FILES['LOGO']['error'] > 0 && check_file_uploaded_name($_FILES['LOGO']['name']) && check_file_uploaded_length($_FILES['LOGO']['name']) && strpos(mime_content_type($_FILES['LOGO']['tmp_name']), 'image')) { $r1++; }
        if (in_array(strtolower(substr(strrchr($_FILES['LOGO']['name'], '.'), 1)), array('jpg', 'jpeg', 'png', 'gif'))) { 
            $result2 = move_uploaded_file($_FILES['LOGO']['tmp_name'], "../../plugins/images/uploads/{$_FILES['LOGO']['name']}");
            if($result2){
                $_logo = mysqli_real_escape_string($conn, "uploads/" . $_FILES['LOGO']['name']);
                $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_logo."' WHERE `VARIABLE` = 'LOGO';";
            } else { $r1++; }
        } else { $r1++; }
    }
    if(isset($_POST['HEADER_AD']) && $config["HEADER_AD"] != $_POST['HEADER_AD']) { 
        $_header_ad = mysqli_real_escape_string($conn, $_POST['HEADER_AD']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_header_ad."' WHERE `VARIABLE` = 'HEADER_AD';";
    }
    if(isset($_POST['FOOTER_AD']) && $config["FOOTER_AD"] != $_POST['FOOTER_AD']) { 
        $_footer_ad = mysqli_real_escape_string($conn, $_POST['FOOTER_AD']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_footer_ad."' WHERE `VARIABLE` = 'FOOTER_AD';";
    }
    if(isset($_POST['ADMIN_ADS']) && $config["ADMIN_ADS"] != $_POST['ADMIN_ADS']) { 
        $_admin_ads = mysqli_real_escape_string($conn, $_POST['ADMIN_ADS']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_admin_ads."' WHERE `VARIABLE` = 'ADMIN_ADS';";
    }
    if(isset($_POST['EXT_SCRIPT']) && $key2 != $_POST['EXT_SCRIPT']) { 
        $_ext_script = mysqli_real_escape_string($conn, $_POST['EXT_SCRIPT']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_ext_script."' WHERE `VARIABLE` = 'EXT_SCRIPT';";
    }
    
    /*
    * Enable / Disable Section
    */
    
    if(isset($_POST['ENABLE_WEB']) && $config["WEB_ENABLED"] != $_POST['ENABLE_WEB']) {
        $_e_web = mysqli_real_escape_string($conn, $_POST['ENABLE_WEB']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_web."' WHERE `VARIABLE` = 'WEB_ENABLED';";
    } 
    if(isset($_POST['ENABLE_DNS']) && $config["DNS_ENABLED"] != $_POST['ENABLE_DNS']) { 
        $_e_dns = mysqli_real_escape_string($conn, $_POST['ENABLE_DNS']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_dns."' WHERE `VARIABLE` = 'DNS_ENABLED';";
    } 
    if(isset($_POST['ENABLE_MAIL']) && $config["MAIL_ENABLED"] != $_POST['ENABLE_MAIL']) { 
        $_e_mail = mysqli_real_escape_string($conn, $_POST['ENABLE_MAIL']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_mail."' WHERE `VARIABLE` = 'MAIL_ENABLED';";
    } 
    if(isset($_POST['ENABLE_DB']) && $config["DB_ENABLED"] != $_POST['ENABLE_DB']) {  
        $_e_db = mysqli_real_escape_string($conn, $_POST['ENABLE_DB']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_db."' WHERE `VARIABLE` = 'DB_ENABLED';";
    } 
    if(isset($_POST['ENABLE_ADMIN']) && $config["ADMIN_ENABLED"] != $_POST['ENABLE_ADMIN']) { 
        $_e_admin = mysqli_real_escape_string($conn, $_POST['ENABLE_ADMIN']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_admin."' WHERE `VARIABLE` = 'ADMIN_ENABLED';";
    } 
    if(isset($_POST['ENABLE_PROFILE']) && $config["PROFILE_ENABLED"] != $_POST['ENABLE_PROFILE']) { 
        $_e_profile = mysqli_real_escape_string($conn, $_POST['ENABLE_PROFILE']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_profile."' WHERE `VARIABLE` = 'PROFILE_ENABLED';";
    } 
    if(isset($_POST['ENABLE_CRON']) && $config["CRON_ENABLED"] != $_POST['ENABLE_CRON']) { 
        $_e_cron = mysqli_real_escape_string($conn, $_POST['ENABLE_CRON']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_cron."' WHERE `VARIABLE` = 'CRON_ENABLED';";
    } 
    if(isset($_POST['ENABLE_BACKUPS']) && $config["BACKUPS_ENABLED"] != $_POST['ENABLE_BACKUPS']) { 
        $_e_backup = mysqli_real_escape_string($conn, $_POST['ENABLE_BACKUPS']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_backup."' WHERE `VARIABLE` = 'BACKUPS_ENABLED';";
    } 
    if(isset($_POST['ENABLE_NOTIF']) && $config["NOTIFICATIONS_ENABLED"]  != $_POST['ENABLE_NOTIF']) { 
        $_e_notif = mysqli_real_escape_string($conn, $_POST['ENABLE_NOTIF']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_notif."' WHERE `VARIABLE` = 'NOTIFICATIONS_ENABLED';";
    } 
    if(isset($_POST['ENABLE_REG']) && $config["REGISTRATIONS_ENABLED"]  != $_POST['ENABLE_REG']) { 
        $_e_reg = mysqli_real_escape_string($conn, $_POST['ENABLE_REG']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_reg."' WHERE `VARIABLE` = 'REGISTRATIONS_ENABLED';";
    } 
    if(isset($_POST['ENABLE_SOFTURL']) && $config["SOFTACULOUS_URL"] != $_POST['ENABLE_SOFTURL']) {
        $_e_soft = mysqli_real_escape_string($conn, $_POST['ENABLE_SOFTURL']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_soft."' WHERE `VARIABLE` = 'SOFTACULOUS_URL';";
    } 
    if(isset($_POST['ENABLE_OLDCPURL']) && $config["OLD_CP_LINK"] != $_POST['ENABLE_OLDCPURL']) { 
        $_e_cpurl = mysqli_real_escape_string($conn, $_POST['ENABLE_OLDCPURL']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_cpurl."' WHERE `VARIABLE` = 'OLD_CP_LINK';";
    } 
    if(isset($_POST['PHPMAIL_ENABLED']) && $phpmailenabled != $_POST['PHPMAIL_ENABLED']) {
        $_e_phpmail = mysqli_real_escape_string($conn, $_POST['PHPMAIL_ENABLED']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_phpmail."' WHERE `VARIABLE` = 'PHPMAIL_ENABLED';";
    } 
    if(isset($_POST['MAIL_FROM']) && $config["MAIL_FROM"] != $_POST['MAIL_FROM']) {
        $_mail_from = mysqli_real_escape_string($conn, $_POST['MAIL_FROM']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_mail_from."' WHERE `VARIABLE` = 'MAIL_FROM';";
    } 
    if(isset($_POST['MAIL_NAME']) && $config["MAIL_NAME"] != $_POST['MAIL_NAME']) {
        $_mail_name = mysqli_real_escape_string($conn, $_POST['MAIL_NAME']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_mail_name."' WHERE `VARIABLE` = 'MAIL_NAME';";
    } 
    if(isset($_POST['SMTP_ENABLED']) && $smtpenabled != $_POST['SMTP_ENABLED']) {
        $_e_smtp = mysqli_real_escape_string($conn, $_POST['SMTP_ENABLED']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_e_smtp."' WHERE `VARIABLE` = 'SMTP_ENABLED';";
    } 
    if(isset($_POST['SMTP_HOST']) && $config["SMTP_HOST"] != $_POST['SMTP_HOST']) {
        $_smtp_host = mysqli_real_escape_string($conn, $_POST['SMTP_HOST']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_smtp_host."' WHERE `VARIABLE` = 'SMTP_HOST';";
    } 
    if(isset($_POST['SMTP_PORT']) && $config["SMTP_PORT"] != $_POST['SMTP_PORT']) {
        $_smtp_port = mysqli_real_escape_string($conn, $_POST['SMTP_PORT']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_smtp_port."' WHERE `VARIABLE` = 'SMTP_PORT';";
    } 
    if(isset($_POST['SMTP_ENC']) && $smtpenc != $_POST['SMTP_ENC']) {
        $_smtp_enc = mysqli_real_escape_string($conn, $_POST['SMTP_ENC']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_smtp_enc."' WHERE `VARIABLE` = 'SMTP_ENC';";
    } 
    if(isset($_POST['SMTP_AUTH']) && $smtpauth != $_POST['SMTP_AUTH']) {
        $_smtp_auth = mysqli_real_escape_string($conn, $_POST['SMTP_AUTH']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_smtp_auth."' WHERE `VARIABLE` = 'SMTP_AUTH';";
    } 
    if(isset($_POST['SMTP_UNAME']) && $config["SMTP_UNAME"] != $_POST['SMTP_UNAME']) {
        $_smtp_uname = mysqli_real_escape_string($conn, $_POST['SMTP_UNAME']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_smtp_uname."' WHERE `VARIABLE` = 'SMTP_UNAME';";
    } 
    if(isset($_POST['SMTP_PW']) && $config["SMTP_PW"] != $_POST['SMTP_PW']) {
        $_smtp_pw = mysqli_real_escape_string($conn, $_POST['SMTP_PW']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_smtp_pw."' WHERE `VARIABLE` = 'SMTP_PW';";
    } 
    
    /*
    * Optional Links Section
    */
    
    if(isset($_POST['FTP_URL']) && $config["FTP_URL"] != $_POST['FTP_URL']) { 
        $_ftp_url = mysqli_real_escape_string($conn, $_POST['FTP_URL']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_ftp_url."' WHERE `VARIABLE` = 'FTP_URL';";
    } 
    if(isset($_POST['WEBMAIL_URL']) && $config["WEBMAIL_URL"] != $_POST['WEBMAIL_URL']) { 
        $_webmail_url = mysqli_real_escape_string($conn, $_POST['WEBMAIL_URL']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_webmail_url."' WHERE `VARIABLE` = 'WEBMAIL_URL';";
    } 
    if(isset($_POST['PHPMYADMIN_URL']) && $config["PHPMYADMIN_URL"] != $_POST['PHPMYADMIN_URL']) {
        $_phpmy_url = mysqli_real_escape_string($conn, $_POST['PHPMYADMIN_URL']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_phpmy_url."' WHERE `VARIABLE` = 'PHPMYADMIN_URL';";
    } 
    if(isset($_POST['PHPPGADMIN_URL']) && $config["PHPPGADMIN_URL"] != $_POST['PHPPGADMIN_URL']) {  
        $_phppg_url = mysqli_real_escape_string($conn, $_POST['PHPPGADMIN_URL']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_phppg_url."' WHERE `VARIABLE` = 'PHPPGADMIN_URL';";
    } 
    if(isset($_POST['SUPPORT_URL']) && $config["SUPPORT_URL"] != $_POST['SUPPORT_URL']) { 
        $_support_url = mysqli_real_escape_string($conn, $_POST['SUPPORT_URL']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_support_url."' WHERE `VARIABLE` = 'SUPPORT_URL';";
    } 
    
    /*
    * Optional Integrations Section
    */
    
    if(isset($_POST['PLUGINS']) && $config["PLUGINS"] != $_POST['PLUGINS']) { 
        $_plugins = mysqli_real_escape_string($conn, $_POST['PLUGINS']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_plugins."' WHERE `VARIABLE` = 'PLUGINS';";
    } 
    if(isset($_POST['GOOGLE_ANALYTICS_ID']) && $config["GOOGLE_ANALYTICS_ID"] != $_POST['GOOGLE_ANALYTICS_ID']) { 
        $_ga = mysqli_real_escape_string($conn, $_POST['GOOGLE_ANALYTICS_ID']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_ga."' WHERE `VARIABLE` = 'GOOGLE_ANALYTICS_ID';";
    } 
    if(isset($_POST['INTERAKT_APP_ID']) && $config["INTERAKT_APP_ID"] != $_POST['INTERAKT_APP_ID']) { 
        $_interakt_id = mysqli_real_escape_string($conn, $_POST['INTERAKT_APP_ID']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_interakt_id."' WHERE `VARIABLE` = 'INTERAKT_APP_ID';";
    } 
    if(isset($_POST['INTERAKT_API_KEY']) && $config["INTERAKT_API_KEY"] != $_POST['INTERAKT_API_KEY']) {
        $_interakt_key = mysqli_real_escape_string($conn, $_POST['INTERAKT_API_KEY']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_interakt_key."' WHERE `VARIABLE` = 'INTERAKT_API_KEY';";
    } 
    if(isset($_POST['CLOUDFLARE_API_KEY']) && $config["CLOUDFLARE_API_KEY"] != $_POST['CLOUDFLARE_API_KEY']) { 
        $_cf_key = mysqli_real_escape_string($conn, $_POST['CLOUDFLARE_API_KEY']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_cf_key."' WHERE `VARIABLE` = 'CLOUDFLARE_API_KEY';";
    } 
    if(isset($_POST['CLOUDFLARE_EMAIL']) && $config["CLOUDFLARE_EMAIL"] != $_POST['CLOUDFLARE_EMAIL']) { 
        $_cf_email = mysqli_real_escape_string($conn, $_POST['CLOUDFLARE_EMAIL']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_cf_email."' WHERE `VARIABLE` = 'CLOUDFLARE_EMAIL';";
    } 
    if(isset($_POST['AUTH0_DOMAIN']) && $config["AUTH0_DOMAIN"] != $_POST['AUTH0_DOMAIN']) { 
        $_auth0_domain = mysqli_real_escape_string($conn, $_POST['AUTH0_DOMAIN']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_auth0_domain."' WHERE `VARIABLE` = 'AUTH0_DOMAIN';";
    } 
    if(isset($_POST['AUTH0_CLIENT_ID']) && $config["AUTH0_CLIENT_ID"] != $_POST['AUTH0_CLIENT_ID']) { 
        $_auth0_id = mysqli_real_escape_string($conn, $_POST['AUTH0_CLIENT_ID']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_auth0_id."' WHERE `VARIABLE` = 'AUTH0_CLIENT_ID';";
    } 
    if(isset($_POST['AUTH0_CLIENT_SECRET']) && $config["AUTH0_CLIENT_SECRET"] != $_POST['AUTH0_CLIENT_SECRET']) { 
        $_auth0_secret = mysqli_real_escape_string($conn, $_POST['AUTH0_CLIENT_SECRET']);
        $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '".$_auth0_secret."' WHERE `VARIABLE` = 'AUTH0_CLIENT_SECRET';";
    } 
    
}
// Reset To Default
else {
    $query = "UPDATE `".$mysql_table."config` SET `VALUE` = 'America/Los_Angeles' WHERE `VARIABLE` = 'TIMEZONE';";
    $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = 'default' WHERE `VARIABLE` = 'THEME';";
    $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = 'en_US.utf8' WHERE `VARIABLE` = 'LANGUAGE';";
    $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = 'favicon.ico' WHERE `VARIABLE` = 'FAVICON';";
    $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = 'admin-logo.png' WHERE `VARIABLE` = 'ICON';";
    $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = 'admin-text.png' WHERE `VARIABLE` = 'LOGO';";
    $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '587' WHERE `VARIABLE` = 'SMTP_PORT';";
    $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = 'tls' WHERE `VARIABLE` = 'SMTP_ENC';";
    $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = 'true' WHERE `VARIABLE` IN ('VWI_BRANDING', 'DEFAULT_TO_ADMIN', 'ADMIN_ADS', 'WEB_ENABLED', 'DNS_ENABLED', 'MAIL_ENABLED', 'DB_ENABLED', 'ADMIN_ENABLED', 'PROFILE_ENABLED', 'CRON_ENABLED', 'BACKUPS_ENABLED', 'NOTIFICATIONS_ENABLED', 'SMTP_ENABLED', 'SMTP_AUTH');";
    $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = 'false' WHERE `VARIABLE` IN ('CUSTOM_FOOTER', 'REGISTRATIONS_ENABLED', 'SOFTACULOUS_URL', 'OLD_CP_LINK', 'PHPMAIL_ENABLED');";
    $query .= "UPDATE `".$mysql_table."config` SET `VALUE` = '' WHERE `VARIABLE` IN ('SITE_NAME', 'CUSTOM_THEME_PRIMARY', 'CUSTOM_THEME_SECONDARY', 'FOOTER', 'HEADER_AD', 'FOOTER_AD', 'EXT_SCRIPT', 'MAIL_FROM', 'MAIL_NAME', 'SMTP_HOST', 'SMTP_UNAME', 'SMTP_PW', 'FTP_URL', 'WEBMAIL_URL', 'PHPMYADMIN_URL', 'PHPPGADMIN_URL', 'SUPPORT_URL', 'PLUGINS', 'GOOGLE_ANALYTICS_ID', 'INTERAKT_APP_ID', 'INTERAKT_API_KEY', 'CLOUDFLARE_API_KEY', 'CLOUDFLARE_EMAIL', 'AUTH0_DOMAIN', 'AUTH0_CLIENT_ID', 'AUTH0_CLIENT_SECRET');";
}   

if(mysqli_multi_query($conn, $query)) {
    do {
        if(!mysqli_more_results($conn)) { break; }
        if(!mysqli_next_result($conn)) { $r1++; break; }
    } while(true);
    mysqli_free_result($result);
} else { $r1++; }

mysqli_close($conn);
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

        <form id="form" action="../list/settings.php" method="post">
            <?php 
            echo '<input type="hidden" name="r1" value="'.$r1.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../../plugins/components/jquery/jquery.min.js"></script>
</html>