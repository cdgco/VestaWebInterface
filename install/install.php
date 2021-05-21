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

if (!file_exists( '../includes/config.php' )) { header('step2.php'); exit(); } 
$configlocation = "../includes/";
require("../includes/config.php");

$returncode = 0;
function randomPassword() { $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'; $pass = array(); $alphaLength = strlen($alphabet) - 1; for ($i = 0; $i < 8; $i++) { $n = rand(0, $alphaLength); $pass[] = $alphabet[$n]; } return implode($pass); }

function vwicryptx($cs,$ca='e') { 
    $op = false; $ecm ="AES-256-CBC"; $key=hash('sha256',$KEY3); $iv=substr(hash('sha256',$KEY4),0,16); 
    if($ca=='e'){
        $op=base64_encode(openssl_encrypt($cs,$ecm,$key,0,$iv));
    } 
    elseif($ca=='d'){
        $op=openssl_decrypt(base64_decode($cs),$ecm,$key,0,$iv);
    }
    return $op;
}

$a = randomPassword();
$b = randomPassword();

if($_POST['VESTA_SSL_ENABLED'] == 'on'){ $sslenabled = 'true'; }
else { $sslenabled = 'false'; }

$con=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db);

$sql1 = "DROP TABLE IF EXISTS `".$mysql_table."config`;";

if (!mysqli_query($con, $sql1)) { echo "Error dropping table: " . mysqli_error($con) . "\n"; $returncode = $returncode + 1; }
mysqli_close($con);

$con=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db);

$sql2 = "CREATE TABLE IF NOT EXISTS `".$mysql_table."config` (
  `VARIABLE` varchar(64) NOT NULL,
  `VALUE` varchar(1024) NOT NULL,
  PRIMARY KEY (`VARIABLE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

if (mysqli_query($con, $sql2)) {} else { echo "Error creating table: " . mysqli_error($con) . "\n"; $returncode = $returncode + 1; }

mysqli_close($con);

$con=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db);

$encpassword = vwicryptx($_POST['VESTA_ADMIN_PW']);

$v1 = mysqli_real_escape_string($con, $_POST['SITENAME']);
$v2 = mysqli_real_escape_string($con, $_POST['THEME']);
$v3 = mysqli_real_escape_string($con, $_POST['LANGUAGE']);
$v4 = mysqli_real_escape_string($con, $_POST['VESTA_HOST_ADDRESS']);
$v5 = mysqli_real_escape_string($con, $_POST['TIMEZONE']);

$sql3 = "INSERT INTO `".$mysql_table."config` (`VARIABLE`, `VALUE`) VALUES
('TIMEZONE', '".$v5."'),
('SITE_NAME', '".$v1."'),
('THEME', '".$v2."'),
('LANGUAGE', '".$v3."'),
('DEFAULT_TO_ADMIN', 'true'),
('KEY1', '".$a."'),
('KEY2', '".$b."'),
('WARNINGS_ENABLED', 'admin'),
('ICON', 'admin-logo.png'),
('LOGO', 'admin-text.png'),
('FAVICON', 'favicon.ico'),
('WEB_ENABLED', 'true'),
('DNS_ENABLED', 'true'),
('MAIL_ENABLED', 'true'),
('DB_ENABLED', 'true'),
('ADMIN_ENABLED', 'true'),
('PROFILE_ENABLED', 'true'),
('CRON_ENABLED', 'true'),
('BACKUPS_ENABLED', 'true'),
('NOTIFICATIONS_ENABLED', 'false'),
('REGISTRATIONS_ENABLED', 'false'),
('SOFTACULOUS_URL', 'false'),
('OLD_CP_LINK', 'false'),
('VWI_BRANDING', 'true'),
('CUSTOM_FOOTER', 'false'),
('FOOTER', ''),
('PHPMAIL_ENABLED', 'false'),
('MAIL_FROM', 'hello@".$v4."'),
('MAIL_NAME', '".$v1."'),
('SMTP_ENABLED', 'false'),
('SMTP_PORT', '587'),
('SMTP_HOST', ''),
('SMTP_AUTH', 'true'),
('SMTP_UNAME', ''),
('SMTP_PW', ''),
('SMTP_ENC', 'tls'),
('FTP_URL', ''),
('WEBMAIL_URL', ''),
('PHPMYADMIN_URL', ''),
('PHPPGADMIN_URL', ''),
('SUPPORT_URL', ''),
('PLUGINS', ''),
('GOOGLE_ANALYTICS_ID', ''),
('INTERAKT_APP_ID', ''),
('INTERAKT_API_KEY', ''),
('CLOUDFLARE_API_KEY', ''),
('CLOUDFLARE_EMAIL', ''),
('AUTH0_DOMAIN', ''),
('AUTH0_CLIENT_ID', ''),
('AUTH0_CLIENT_SECRET', ''),
('CUSTOM_THEME_PRIMARY', ''),
('CUSTOM_THEME_SECONDARY', ''),
('HEADER_AD', ''),
('FOOTER_AD', ''),
('ADMIN_ADS', 'true'),
('EXT_SCRIPT', '');";

if (mysqli_query($con, $sql3)) {} else { echo "Error populating table: " . mysqli_error($con) . "\n"; $returncode = $returncode + 1; }

mysqli_close($con);

$con=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db);

$sql4 = "DROP TABLE IF EXISTS `".$mysql_table."servers`;";

if (mysqli_query($con, $sql4)) {} else { echo "Error dropping table: " . mysqli_error($con) . "\n"; $returncode = $returncode + 1; }

mysqli_close($con);

$con=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db);

$sql5 = "CREATE TABLE IF NOT EXISTS `".$mysql_table."servers` (
    `NAME` varchar(255) NOT NULL,
    `HOST_ADDRESS` varchar(1024) NOT NULL,
    `PORT` varchar(10) NOT NULL,
    `SSL_ENABLED` varchar(10) NOT NULL,
    `METHOD` varchar(15) NOT NULL,
    `API_KEY` varchar(1024) NOT NULL,
    `UNAME` varchar(1024) NOT NULL,
    `PASSWORD` varchar(1024) NOT NULL,
    `DEFAULT` varchar(5) NOT NULL DEFAULT 'false',
    PRIMARY KEY (`NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

if (mysqli_query($con, $sql5)) {} else { echo "Error creating table: " . mysqli_error($con) . "\n"; $returncode = $returncode + 1; }

mysqli_close($con);

$con=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db);

$encpassword = vwicryptx($_POST['VESTA_ADMIN_PW']);

$v6 = mysqli_real_escape_string($con, $_POST['VESTA_HOST_ADDRESS']);
$v7 = mysqli_real_escape_string($con, $_POST['VESTA_PORT']);
$v8 = mysqli_real_escape_string($con, $_POST['VESTA_ADMIN_UNAME']);
$v9 = mysqli_real_escape_string($con, $encpassword);

$sql6 = "INSERT INTO `".$mysql_table."servers` (`NAME`, `HOST_ADDRESS`, `PORT`, `SSL_ENABLED`, `METHOD`, `API_KEY`, `UNAME`, `PASSWORD`, `DEFAULT`) VALUES
('Default Server', '".$v6."', '".$v7."', '".$sslenabled."', 'credentials', '', '".$v8."', '".$v9."', 'true');";

if (mysqli_query($con, $sql6)) {} else { echo "Error altering table: " . mysqli_error($con) . "\n"; $returncode = $returncode + 1; }

mysqli_close($con);


$con=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db);

$sql7 = "CREATE TABLE IF NOT EXISTS `".$mysql_table."auth0-users` (
  `VWI_USER` varchar(64) NOT NULL,
  `AUTH0_USER` varchar(1024) NOT NULL,
  PRIMARY KEY (`VWI_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

if (mysqli_query($con, $sql7)) {} else { echo "Error altering table: " . mysqli_error($con) . "\n"; $returncode = $returncode + 1; }

mysqli_close($con);


if($returncode == 0) { echo '
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
    <script src="../plugins/components/jquery/jquery.min.js"></script>
    <script>window.location = "complete.html"</script>
</html>'; }
?>
