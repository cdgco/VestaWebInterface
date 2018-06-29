<?php

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

		$backup = basename($_GET['backup']);

		// Check if the backup exists
		if (!file_exists('/backup/'.$backup)) {
		    exit(0);
		}

		// Data
		if ($_POST['user'] == 'admin') {
		    header('Content-type: application/gzip');
		    header("Content-Disposition: attachment; filename=\"".$backup."\";" ); 
		    header("X-Accel-Redirect: /backup/" . $backup);
		}

		if ((!empty($_POST['user'])) && ($_POST['user'] != 'admin')) {
		    if (strpos($backup, $user.'.') === 0) {
 		       header('Content-type: application/gzip');
		        header("Content-Disposition: attachment; filename=\"".$backup."\";" ); 
 		       header("X-Accel-Redirect: /backup/" . $backup);
 		    }
		}
	}
	else { header("Location: /"); }
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.0-Beta/css/style.css" rel="stylesheet">
    </head>
    <body class="fix-header">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>
                    </body>
        <script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v0.5.0-Beta/plugins/bower_components/jquery/dist/jquery.min.js"></script>
</html>