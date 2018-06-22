<?php
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

$1 = mysqli_real_escape_string($con, $_POST['SITENAME']);
$2 = mysqli_real_escape_string($con, $_POST['THEME']);
$3 = mysqli_real_escape_string($con, $_POST['LANGUAGE']);
$4 = mysqli_real_escape_string($con, $_POST['VESTA_HOST_ADDRESS']);
$5 = mysqli_real_escape_string($con, $_POST['VESTA_PORT']);
$6 = mysqli_real_escape_string($con, $_POST['VESTA_ADMIN_UNAME']);
$7 = mysqli_real_escape_string($con, $_POST['VESTA_ADMIN_PW']);
$8 = mysqli_real_escape_string($con, $_POST['FTP_URL']);
$9 = mysqli_real_escape_string($con, $_POST['WEBMAIL_URL']);
$10 = mysqli_real_escape_string($con, $_POST['PHPMYADMIN_URL']);
$11 = mysqli_real_escape_string($con, $_POST['PHPPGADMIN_URL']);
$12 = mysqli_real_escape_string($con, $_POST['SUPPORT_URL']);
$13 = mysqli_real_escape_string($con, $_POST['GOOGLE_ANALYTICS_ID']);
$14 = mysqli_real_escape_string($con, $_POST['INTERAKT_APP_ID']);
$15 = mysqli_real_escape_string($con, $_POST['INTERAKT_API_KEY']);
$16 = mysqli_real_escape_string($con, $_POST['CLOUDFLARE_API_KEY']);
$17 = mysqli_real_escape_string($con, $_POST['CLOUDFLARE_EMAIL']);
$18 = mysqli_real_escape_string($con, $_POST['PLUGINS']);
$19 = mysqli_real_escape_string($con, $_POST['TIMEZONE']);

$sql3 = "INSERT INTO `".$mysql_table."config` (`VARIABLE`, `VALUE`) VALUES
('SITE_NAME', '".$1."'),
('THEME', '".$2."'),
('LANGUAGE', '".$3."'),
('DEFAULT_TO_ADMIN', '".$defaultadmin."'),
('VESTA_HOST_ADDRESS', '".$4."'),
('VESTA_SSL_ENABLED', '".$sslenabled."'),
('VESTA_PORT', '".$5."'),
('VESTA_ADMIN_UNAME', '".$6."'),
('VESTA_ADMIN_PW', '".$7."'),
('FTP_URL', '".$8."'),
('WEBMAIL_URL', '".$9."'),
('PHPMYADMIN_URL', '".$10."'),
('PHPPGADMIN_URL', '".$11."'),
('SUPPORT_URL', '".$12."'),
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
('GOOGLE_ANALYTICS_ID', '".$13."'),
('INTERAKT_APP_ID', '".$14."'),
('INTERAKT_API_KEY', '".$15."'),
('CLOUDFLARE_API_KEY', '".$16."'),
('CLOUDFLARE_EMAIL', '".$17."'),
('PLUGINS', '".$18."'),
('TIMEZONE', '".$19."'),
('KEY1', '".$a."'),
('KEY2', '".$b."');";

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
