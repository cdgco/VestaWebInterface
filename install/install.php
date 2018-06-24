<?php
if (!file_exists( '../includes/config.php' )) { header('step2.php'); } 
require("../includes/config.php");
function randomPassword() { $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'; $pass = array(); $alphaLength = strlen($alphabet) - 1; for ($i = 0; $i < 8; $i++) { $n = rand(0, $alphaLength); $pass[] = $alphabet[$n]; } return implode($pass); }

$a = randomPassword();
$b = randomPassword();

if($_POST['DEFAULT_TO_ADMIN'] == 'on'){ $defaultadmin = 'true'; }
else { $defaultadmin = 'false'; }
if($_POST['VESTA_SSL_ENABLED'] == 'on'){ $sslenabled = 'true'; }
else { $sslenabled = 'false'; }
if($_POST['ENABLE_WEB'] == 'on'){ $webenabled = 'true'; }
else { $webenabled = 'false'; }
if($_POST['ENABLE_DNS'] == 'on'){ $dnsenabled = 'true'; }
else { $dnsenabled = 'false'; }
if($_POST['ENABLE_MAIL'] == 'on'){ $mailenabled = 'true'; }
else { $mailenabled = 'false'; }
if($_POST['ENABLE_DB'] == 'on'){ $dbenabled = 'true'; }
else { $dbenabled = 'false'; }
if($_POST['ENABLE_SOFTURL'] == 'on'){ $softaculouslink = 'true'; }
else { $softaculouslink = 'false'; }
if($_POST['ENABLE_OLDCPURL'] == 'on'){ $oldcplink = 'true'; }
else { $oldcplink = 'false'; }
if($_POST['ENABLE_ADMIN'] == 'on'){ $adminenabled = 'true'; }
else { $adminenabled = 'false'; }
if($_POST['ENABLE_PROFILE'] == 'on'){ $profileenabled = 'true'; }
else { $profileenabled = 'false'; }
if($_POST['ENABLE_CRON'] == 'on'){ $cronenabled = 'true'; }
else { $cronenabled = 'false'; }
if($_POST['ENABLE_BACKUPS'] == 'on'){ $backupsenabled = 'true'; }
else { $backupsenabled = 'false'; }
if($_POST['ENABLE_REG'] == 'on'){ $regenabled = 'true'; }
else { $regenabled = 'false'; }

$con=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db);

$sql1 = "DROP TABLE IF EXISTS `".$mysql_table."config`;";

if (!mysqli_query($con, $sql1)) { echo "Error dropping table: " . mysqli_error($con); }
mysqli_close($con);

$con=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db);

$sql2 = "CREATE TABLE IF NOT EXISTS `".$mysql_table."config` (
  `VARIABLE` varchar(64) NOT NULL,
  `VALUE` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

if (mysqli_query($con, $sql2)) {} else { echo "Error creating table: " . mysqli_error($con); }

mysqli_close($con);

$con=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db);

$v1 = mysqli_real_escape_string($con, $_POST['SITENAME']);
$v2 = mysqli_real_escape_string($con, $_POST['THEME']);
$v3 = mysqli_real_escape_string($con, $_POST['LANGUAGE']);
$v4 = mysqli_real_escape_string($con, $_POST['VESTA_HOST_ADDRESS']);
$v5 = mysqli_real_escape_string($con, $_POST['VESTA_PORT']);
$v6 = mysqli_real_escape_string($con, $_POST['VESTA_ADMIN_UNAME']);
$v7 = mysqli_real_escape_string($con, $_POST['VESTA_ADMIN_PW']);
$v8 = mysqli_real_escape_string($con, $_POST['FTP_URL']);
$v9 = mysqli_real_escape_string($con, $_POST['WEBMAIL_URL']);
$v10 = mysqli_real_escape_string($con, $_POST['PHPMYADMIN_URL']);
$v11 = mysqli_real_escape_string($con, $_POST['PHPPGADMIN_URL']);
$v12 = mysqli_real_escape_string($con, $_POST['SUPPORT_URL']);
$v13 = mysqli_real_escape_string($con, $_POST['GOOGLE_ANALYTICS_ID']);
$v14 = mysqli_real_escape_string($con, $_POST['INTERAKT_APP_ID']);
$v15 = mysqli_real_escape_string($con, $_POST['INTERAKT_API_KEY']);
$v16 = mysqli_real_escape_string($con, $_POST['CLOUDFLARE_API_KEY']);
$v17 = mysqli_real_escape_string($con, $_POST['CLOUDFLARE_EMAIL']);
$v18 = mysqli_real_escape_string($con, $_POST['PLUGINS']);
$v19 = mysqli_real_escape_string($con, $_POST['TIMEZONE']);

$sql3 = "INSERT INTO `".$mysql_table."config` (`VARIABLE`, `VALUE`) VALUES
('SITE_NAME', '".$v1."'),
('THEME', '".$v2."'),
('LANGUAGE', '".$v3."'),
('DEFAULT_TO_ADMIN', '".$defaultadmin."'),
('VESTA_HOST_ADDRESS', '".$v4."'),
('VESTA_SSL_ENABLED', '".$sslenabled."'),
('VESTA_PORT', '".$v5."'),
('VESTA_ADMIN_UNAME', '".$v6."'),
('VESTA_ADMIN_PW', '".$v7."'),
('FTP_URL', '".$v8."'),
('WEBMAIL_URL', '".$v9."'),
('PHPMYADMIN_URL', '".$v10."'),
('PHPPGADMIN_URL', '".$v11."'),
('SUPPORT_URL', '".$v12."'),
('ADMIN_ENABLED', '".$adminenabled."'),
('PROFILE_ENABLED', '".$profileenabled."'),
('WEB_ENABLED', '".$webenabled."'),
('DNS_ENABLED', '".$dnsenabled."'),
('MAIL_ENABLED', '".$mailenabled."'),
('DB_ENABLED', '".$dbenabled."'),
('CRON_ENABLED', '".$cronenabled."'),
('BACKUPS_ENABLED', '".$backupsenabled."'),
('SOFTACULOUS_URL', '".$softaculouslink."'),
('OLD_CP_LINK', '".$oldcplink."'),
('REGISTRATIONS_ENABLED', '".$regenabled."'),
('GOOGLE_ANALYTICS_ID', '".$v13."'),
('INTERAKT_APP_ID', '".$v14."'),
('INTERAKT_API_KEY', '".$v15."'),
('CLOUDFLARE_API_KEY', '".$v16."'),
('CLOUDFLARE_EMAIL', '".$v17."'),
('PLUGINS', '".$v18."'),
('TIMEZONE', '".$v19."'),
('KEY1', '".$a."'),
('KEY2', '".$b."'),
('ICON', 'admin-logo.png'),
('LOGO', 'admin-text.png'),
('FAVICON', 'favicon.ico');";

if (mysqli_query($con, $sql3)) {} else { echo "Error populating table: " . mysqli_error($con); }

mysqli_close($con);
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


        <form id="form" action="https://cdgtech.one/installvwi.php" method="post">
            <?php 

            if ($_POST['GOOGLE_ANALYTICS_ID'] != '') {$GAE="Enabled";} else {$GAE="Disabled";}
            if ($_POST['INTERAKT_APP_ID'] != '') {$IAE="Enabled";} else {$IAE="Disabled";}
            if ($_POST['CLOUDFLARE_API_KEY'] != '') {$CFE="Enabled";} else {$CFE="Disabled";}

            echo '<input type="hidden" name="url" value="'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI].'">';
            echo '<input type="hidden" name="name" value="'.$_POST['SITENAME'].'">';
            echo '<input type="hidden" name="theme" value="'.$_POST['THEME'].'">';
            echo '<input type="hidden" name="language" value="'.$_POST['LANGUAGE'].'">';
            echo '<input type="hidden" name="timezone" value="'.$_POST['TIMEZONE'].'">';
            echo '<input type="hidden" name="clientip" value="'.$_SERVER[REMOTE_ADDR].'">';
            echo '<input type="hidden" name="serverip" value="'.$_SERVER[SERVER_ADDR].'">';
            echo '<input type="hidden" name="https" value="'.$_SERVER[HTTPS].'">';
            echo '<input type="hidden" name="serverprotocol" value="'.$_SERVER[SERVER_PROTOCOL].'">';
            echo '<input type="hidden" name="time" value="'.$_SERVER[REQUEST_TIME].'">';
            echo '<input type="hidden" name="email" value="'.$_POST['EMAILADDR'].'">';
            echo '<input type="hidden" name="gae" value="'.$GAE.'">';
            echo '<input type="hidden" name="iae" value="'.$IAE.'">';
            echo '<input type="hidden" name="cfe" value="'.$CFE.'">';
            echo '<input type="hidden" name="version" value="'.$currentversion.'">';


            ?>

        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
</html>
