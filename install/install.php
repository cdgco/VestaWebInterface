***REMOVED***

if($_POST['VESTA_SSL_ENABLED'] == 'on'){ $sslenabled = 'true'; ***REMOVED***
else { $sslenabled = 'false'; ***REMOVED***
if($_POST['ENABLE_WEB'] == 'on'){ $webenabled = 'true'; ***REMOVED***
else { $webenabled = 'false'; ***REMOVED***
if($_POST['ENABLE_DNS'] == 'on'){ $dnsenabled = 'true'; ***REMOVED***
else { $dnsenabled = 'false'; ***REMOVED***
if($_POST['ENABLE_MAIL'] == 'on'){ $mailenabled = 'true'; ***REMOVED***
else { $mailenabled = 'false'; ***REMOVED***
if($_POST['ENABLE_DB'] == 'on'){ $dbenabled = 'true'; ***REMOVED***
else { $dbenabled = 'false'; ***REMOVED***
if($_POST['ENABLE_OLDCPURL'] == 'on'){ $oldcplink = 'true'; ***REMOVED***
else { $oldcplink = 'false'; ***REMOVED***

$writestr = "***REMOVED***

***REMOVED***
***REMOVED***
***REMOVED***

***REMOVED***
date_default_timezone_set('".$_POST['TIMEZONE']."'); // Server Time Zone - See http://php.net/manual/en/timezones.php for syntax.
DEFINE('SITE_NAME', '".$_POST['SITENAME']."'); // Site name for use in page titles. Ex: 'My Host Company'.
DEFINE('THEME', '".$_POST['THEME']."'); // Accepted options are 'default', 'blue', 'purple' and 'orange'

***REMOVED***
DEFINE('VESTA_HOST_ADDRESS', '".$_POST['VESTA_HOST_ADDRESS']."'); // URL or IP Address of VestaCP. Ex: 'myhost.com' or '12.34.56.78'.
DEFINE('VESTA_SSL_ENABLED', '".$sslenabled."'); // If ssl is enabled on VestaCP - Ex: 'true' or 'false'.
DEFINE('VESTA_PORT', '".$_POST['VESTA_PORT']."'); // VestaCP port. Ex: '8083'.
DEFINE('VESTA_ADMIN_UNAME', '".$_POST['VESTA_ADMIN_UNAME']."'); // Username of VestaCP Admin account. Ex: 'admin'.
DEFINE('VESTA_ADMIN_PW', '".$_POST['VESTA_ADMIN_PW']."'); // Password for VestaCP Admin account. Ex: 'MyPassword1'.

***REMOVED***
DEFINE('FTP_URL', '".$_POST['FTP_URL']."'); // URL for Web FTP. Leave blank if you do not have a Web FTP Interface. Set as 'disabled' to remove the Web FTP option.
DEFINE('WEBMAIL_URL', '".$_POST['WEBMAIL_URL']."'); // Webmail URL. Leave blank for VestaCP default. Set as 'disabled' to remove the webmail option.
DEFINE('PHPMYADMIN_URL', '".$_POST['PHPMYADMIN_URL']."'); // phpMyAdmin URL. Leave blank for VestaCP default. Set as 'disabled; to remove phpMyAdmin option.
DEFINE('PHPPGADMIN_URL', '".$_POST['PHPPGADMIN_URL']."'); // phpPgAdmin URL. Leave blank for VestaCP default. Set as 'disabled; to remove phpPgAdmin option.
DEFINE('SUPPORT_URL', '".$_POST['SUPPORT_URL']."'); // Support URL. Leave blank or set to 'disabled' to disable.

***REMOVED***
DEFINE('WEB_ENABLED', '".$webenabled."'); // Enable or disable web section. Ex: 'true' or 'false'.
DEFINE('DNS_ENABLED', '".$dnsenabled."'); // Enable or disable dns section. Ex: 'true' or 'false'.
DEFINE('MAIL_ENABLED', '".$mailenabled."'); // Enable or disable mail section. Ex: 'true' or 'false'.
DEFINE('DB_ENABLED', '".$dbenabled."'); // Enable or disable database section. Ex: 'true' or 'false'.
DEFINE('OLD_CP_LINK', '".$oldcplink."'); // Enable or disable link to old cpanel. Ex: 'true' or 'false'.

***REMOVED***
DEFINE('GOOGLE_ANALYTICS_ID', '".$_POST['GOOGLE_ANALYTICS_ID']."'); // Enable Google Analytics Tracking. Enter Tracking ID.
DEFINE('INTERAKT_APP_ID', '".$_POST['INTERAKT_APP_ID']."'); // Enable Interakt Support / Tools. Enter Interakt App ID.
DEFINE('INTERAKT_API_KEY', '".$_POST['INTERAKT_API_KEY']."'); // Enable Interakt User Management. Interakt Account number must be set first. Enter Interakt API Key.

***REMOVED***/////////////
***REMOVED***
***REMOVED***/////////////

***REMOVED***
 \$vst_ssl = 'http://';
***REMOVED***
***REMOVED***
 \$vst_ssl = 'https://';
***REMOVED***

***REMOVED***
 \$vesta_port = '8083';
***REMOVED***
***REMOVED***
 \$vesta_port = VESTA_PORT;
***REMOVED***

***REMOVED***
 \$ftpurl = 'http://net2ftp.com/';
***REMOVED***
***REMOVED***
 \$ftpurl = '';
***REMOVED***
***REMOVED***
 \$ftpurl = FTP_URL;
***REMOVED***

***REMOVED***
 \$webenabled = '';
***REMOVED***
***REMOVED***
 \$webenabled = WEB_ENABLED;
***REMOVED***
***REMOVED***
 \$dnsenabled = '';
***REMOVED***
***REMOVED***
 \$dnsenabled = DNS_ENABLED;
***REMOVED***
***REMOVED***
 \$mailenabled = '';
***REMOVED***
***REMOVED***
 \$mailenabled = MAIL_ENABLED;
***REMOVED***
***REMOVED***
 \$dbenabled = '';
***REMOVED***
***REMOVED***
 \$dbenabled = DB_ENABLED;
***REMOVED***

\$vst_url = \$vst_ssl . VESTA_HOST_ADDRESS . ':' . \$vesta_port . '/api/';
\$url8083 = \$vst_ssl . VESTA_HOST_ADDRESS . ':' . \$vesta_port;
\***REMOVED***
\***REMOVED***
\***REMOVED***
\$uname = base64_decode(\$_COOKIE['username']);
\$loggedin = base64_decode(\$_COOKIE['loggedin']);
\$username = \$uname;
\***REMOVED***

***REMOVED***
 \$webmailurl = \$vst_ssl . VESTA_HOST_ADDRESS . '/webmail';
***REMOVED***
***REMOVED***
 \$webmailurl = '';
***REMOVED***
***REMOVED***
 \$webmailurl = WEBMAIL_URL;
***REMOVED***

***REMOVED***
 \$phpmyadmin = \$vst_ssl . VESTA_HOST_ADDRESS . '/phpmyadmin';
***REMOVED***
***REMOVED***
 \$phpmyadmin = '';
***REMOVED***
***REMOVED***
 \$phpmyadmin = PHPMYADMIN_URL;
***REMOVED***

***REMOVED***
 \$phppgadmin = \$vst_ssl . VESTA_HOST_ADDRESS . '/phppgadmin';
***REMOVED***
***REMOVED***
 \$phppgadmin = '';
***REMOVED***
***REMOVED***
 \$phppgadmin = PHPPGADMIN_URL;
***REMOVED***

***REMOVED***
 \$supporturl = '';
***REMOVED***
***REMOVED***
 \$supporturl = '';
***REMOVED***
***REMOVED***
 \$supporturl = SUPPORT_URL;
***REMOVED***

***REMOVED***
 \$oldcpurl = '';
***REMOVED***
***REMOVED***
 \$oldcpurl = \$url8083;
***REMOVED***

include 'functions.php'
***REMOVED***";

file_put_contents('../includes/config.php', $writestr);
***REMOVED***
<html>
    <head>
<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  font-weight: 300;
***REMOVED***
body {
  font-family: 'Source Sans Pro', sans-serif;
  color: white;
  font-weight: 300;
***REMOVED***
.wrapper {
  background: #50a3a2;
  background: linear-gradient(to left, #141E30, #243B55);
  position: absolute;
  left: 0;
  width: 100%;
  height: 100%;
  bottom: 0;
  overflow: hidden;
***REMOVED***
.container {
  max-width: 600px;
  margin: 0 auto;
  padding: 80px 0;
  height: 400px;
  text-align: center;
***REMOVED***
.container h1 {
  font-size: 40px;
  transition-duration: 1s;
  transition-timing-function: ease-in-put;
  font-weight: 200;
***REMOVED***
.bg-bubbles {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
***REMOVED***
.bg-bubbles li {
  position: absolute;
  list-style: none;
  display: block;
  width: 40px;
  height: 40px;
  background-color: rgba(255, 255, 255, 0.15);
  bottom: -160px;
  -webkit-animation: square 25s infinite;
  animation: square 25s infinite;
  -webkit-transition-timing-function: linear;
  transition-timing-function: linear;
***REMOVED***
.bg-bubbles li:nth-child(1) {
  left: 10%;
***REMOVED***
.bg-bubbles li:nth-child(2) {
  left: 20%;
  width: 80px;
  height: 80px;
  animation-delay: 2s;
  animation-duration: 17s;
***REMOVED***
.bg-bubbles li:nth-child(3) {
  left: 25%;
  animation-delay: 4s;
***REMOVED***
.bg-bubbles li:nth-child(4) {
  left: 40%;
  width: 60px;
  height: 60px;
  animation-duration: 22s;
  background-color: rgba(255, 255, 255, 0.25);
***REMOVED***
.bg-bubbles li:nth-child(5) {
  left: 70%;
***REMOVED***
.bg-bubbles li:nth-child(6) {
  left: 80%;
  width: 120px;
  height: 120px;
  animation-delay: 3s;
  background-color: rgba(255, 255, 255, 0.2);
***REMOVED***
.bg-bubbles li:nth-child(7) {
  left: 32%;
  width: 160px;
  height: 160px;
  animation-delay: 7s;
***REMOVED***
.bg-bubbles li:nth-child(8) {
  left: 55%;
  width: 20px;
  height: 20px;
  animation-delay: 15s;
  animation-duration: 40s;
***REMOVED***
.bg-bubbles li:nth-child(9) {
  left: 25%;
  width: 10px;
  height: 10px;
  animation-delay: 2s;
  animation-duration: 40s;
  background-color: rgba(255, 255, 255, 0.3);
***REMOVED***
.bg-bubbles li:nth-child(10) {
  left: 90%;
  width: 160px;
  height: 160px;
  animation-delay: 11s;
***REMOVED***
@-webkit-keyframes square {
  0% {
    transform: translateY(0);
  ***REMOVED***
  100% {
    transform: translateY(-700px) rotate(600deg);
  ***REMOVED***
***REMOVED***
@keyframes square {
  0% {
    transform: translateY(0);
  ***REMOVED***
  100% {
    transform: translateY(-700px) rotate(600deg);
  ***REMOVED***
***REMOVED***
p {
  background: linear-gradient(to left, #141E30, #243B55);
  font-size: 21px;
  padding: 15px;
  border-radius: 5px;
  margin: 10px;
***REMOVED***
</style>
    </head>
    <body>
<div class="wrapper">
	<div class="container"> 
<div> 		<h1>Configuration Complete</h1>
    <p> Please delete the 'install' directory to prevent any security issues. <br><br>If you have not already installed the VWI Backend, run the command "bash <(curl -s -L https://git.io/vbjOd)" on your vesta server or follow the instructions on the <a href="https://github.com/cdgco/VestaWebInterface">GitHub Repo</a><br> <br>    <a href="../index.php">Launch Control Panel</a></p>
   </div>
	<ul class="bg-bubbles">
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</div>
        </div></body></html>