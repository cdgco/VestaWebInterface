***REMOVED***

session_destroy();

define('NO_AUTH_REQUIRED',true);
$_SESSION['token'] = uniqid(mt_rand(), true);

// Main include
include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

// Basic auth
if (isset($_POST['user']) && isset($_POST['password'])) {
        $v_user = escapeshellarg($_POST['user']);

        // Send password via tmp file
        $v_password = exec('mktemp -p /tmp');
        $fp = fopen($v_password, "w");
        fwrite($fp, $_POST['password']."\n");
        fclose($fp);

        // Check user & password
        exec(VESTA_CMD ."v-check-user-password ".$v_user." ".$v_password." ".escapeshellarg($_SERVER['REMOTE_ADDR']),  $output, $return_var);
        unset($output);

        // Remove tmp file
        unlink($v_password);

        // Check API answer
        if ( $return_var == 0 ) {
            // Make root admin user
            if ($_POST['user'] == 'root') $v_user = 'admin';

            // Get user speciefic parameters
            exec (VESTA_CMD . "v-list-user ".$v_user." json", $output, $return_var);
            $data = json_decode(implode('', $output), true);

            // Define session user
            $_SESSION['user'] = key($data);
            $v_user = $_SESSION['user'];

            // Get user favorites
            get_favourites();

            // Define language
            $output = '';
            exec (VESTA_CMD."v-list-sys-languages json", $output, $return_var);
            $languages = json_decode(implode('', $output), true);
            if(in_array($data[$v_user]['LANGUAGE'], $languages)){
                $_SESSION['language'] = $data[$v_user]['LANGUAGE'];
            ***REMOVED***
            else {
                $_SESSION['language'] = 'en';
            ***REMOVED***
            // Regenerate session id to prevent session fixation
            session_regenerate_id();

            // Continue Download
            header("Location /download/backup/index.php?backup=" . $_GET['backup']);

        ***REMOVED***
    ***REMOVED***
// Check system configuration
exec (VESTA_CMD . "v-list-sys-config json", $output, $return_var);
$data = json_decode(implode('', $output), true);
$sys_arr = $data['config'];
foreach ($sys_arr as $key => $value) {
    $_SESSION[$key] = $value;
***REMOVED***

// Detect language
if (empty($_SESSION['language'])) {
    $output = '';
    exec (VESTA_CMD."v-list-sys-config json", $output, $return_var);
    $config = json_decode(implode('', $output), true);
    $lang = $config['config']['LANGUAGE'];

    $output = '';
    exec (VESTA_CMD."v-list-sys-languages json", $output, $return_var);
    $languages = json_decode(implode('', $output), true);
    if(in_array($lang, $languages)){
        $_SESSION['language'] = $lang;
    ***REMOVED***
    else {
        $_SESSION['language'] = 'en';
    ***REMOVED***
***REMOVED***
***REMOVED***
<html>
<head>
<style>
html {
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
  font-family: "Lato, sans-serif";
***REMOVED***

*,
*:before,
*:after {
  -webkit-box-sizing: inherit;
          box-sizing: inherit;
***REMOVED***

html {
  width: 100%;
  height: 100%;
  font-size: 62.5%;
  font-family: 'Lato', sans-serif;
  color: #4d4d4d;
***REMOVED***

body {
  width: 100%;
  height: 100%;
  font-size: 1.6em;
***REMOVED***

.wrapper {
  font-size: 1.6rem;
  background: #dad8d2;
  width: 100%;
  height: 100%;
  overflow: hidden;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
***REMOVED***

.visuallyhidden {
  border: 0;
  clip: rect(0 0 0 0);
  height: 1px;
  margin: -1px;
  overflow: hidden;
  padding: 0;
  position: absolute;
  width: 1px;
***REMOVED***

.clearfix:before,
.clearfix:after {
  content: ' ';
  display: table;
***REMOVED***

.clearfix:after {
  clear: both;
***REMOVED***

.clearfix {
  zoom: 1;
***REMOVED***

html, body {
  width: 100%;
  background: #dad8d2;
    overflow-x: hidden; 
    overflow-y: hidden;
***REMOVED***


.hourglass {
  display: block;
  background: #dad8d2;
  margin: 3em auto;
  width: 2em;
  height: 4em;
  -webkit-box-shadow: inset #dad8d2 0 0 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 0 4em 0;
          box-shadow: inset #dad8d2 0 0 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 0 4em 0;
  -webkit-animation: hourglass 1s linear infinite;
          animation: hourglass 1s linear infinite;
***REMOVED***

.outer {
  fill: #00b7c6;
***REMOVED***

.middle {
  fill: #dad8d2;
***REMOVED***

@-webkit-keyframes hourglass {
  0% {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
    -webkit-box-shadow: inset #dad8d2 0 0 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 4em 0 0, inset #00b7c6 0 4em 0 0;
            box-shadow: inset #dad8d2 0 0 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 4em 0 0, inset #00b7c6 0 4em 0 0;
  ***REMOVED***
  80% {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
    -webkit-box-shadow: inset #dad8d2 0 2em 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 2em 0 0, inset #00b7c6 0 4em 0 0;
            box-shadow: inset #dad8d2 0 2em 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 2em 0 0, inset #00b7c6 0 4em 0 0;
  ***REMOVED***
  100% {
    -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
    -webkit-box-shadow: inset #dad8d2 0 2em 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 2em 0 0, inset #00b7c6 0 4em 0 0;
            box-shadow: inset #dad8d2 0 2em 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 2em 0 0, inset #00b7c6 0 4em 0 0;
  ***REMOVED***
***REMOVED***

@keyframes hourglass {
  0% {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
    -webkit-box-shadow: inset #dad8d2 0 0 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 4em 0 0, inset #00b7c6 0 4em 0 0;
            box-shadow: inset #dad8d2 0 0 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 4em 0 0, inset #00b7c6 0 4em 0 0;
  ***REMOVED***
  80% {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
    -webkit-box-shadow: inset #dad8d2 0 2em 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 2em 0 0, inset #00b7c6 0 4em 0 0;
            box-shadow: inset #dad8d2 0 2em 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 2em 0 0, inset #00b7c6 0 4em 0 0;
  ***REMOVED***
  100% {
    -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
    -webkit-box-shadow: inset #dad8d2 0 2em 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 2em 0 0, inset #00b7c6 0 4em 0 0;
            box-shadow: inset #dad8d2 0 2em 0 0, inset #00b7c6 0 2em 0 0, inset #dad8d2 0 2em 0 0, inset #00b7c6 0 4em 0 0;
  ***REMOVED***
***REMOVED***
 
</style>
<title>Downloading</title>
<link href='//fonts.googleapis.com/css?family=Lato:900,400' rel='stylesheet' type='text/css'>
</head>
<body>
<div class="wrapper">
    <svg class="hourglass" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 206" preserveAspectRatio="none">
        <path class="middle" d="M120 0H0v206h120V0zM77.1 133.2C87.5 140.9 92 145 92 152.6V178H28v-25.4c0-7.6 4.5-11.7 14.9-19.4 6-4.5 13-9.6 17.1-17 4.1 7.4 11.1 12.6 17.1 17zM60 89.7c-4.1-7.3-11.1-12.5-17.1-17C32.5 65.1 28 61 28 53.4V28h64v25.4c0 7.6-4.5 11.7-14.9 19.4-6 4.4-13 9.6-17.1 16.9z"/>
        <path class="outer" d="M93.7 95.3c10.5-7.7 26.3-19.4 26.3-41.9V0H0v53.4c0 22.5 15.8 34.2 26.3 41.9 3 2.2 7.9 5.8 9 7.7-1.1 1.9-6 5.5-9 7.7C15.8 118.4 0 130.1 0 152.6V206h120v-53.4c0-22.5-15.8-34.2-26.3-41.9-3-2.2-7.9-5.8-9-7.7 1.1-2 6-5.5 9-7.7zM70.6 103c0 18 35.4 21.8 35.4 49.6V192H14v-39.4c0-27.9 35.4-31.6 35.4-49.6S14 81.2 14 53.4V14h92v39.4C106 81.2 70.6 85 70.6 103z"/>
    </svg>
<center style="position: relative;top: -15%;"><h3>Downloading</h3></center>
</div>
<meta http-equiv="refresh" content="0;url=***REMOVED*** echo "/download/backup/index.php?backup=" . $_GET['backup']; ***REMOVED***" />
</body>
</html>