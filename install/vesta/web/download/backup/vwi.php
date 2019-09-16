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

session_destroy();

define('NO_AUTH_REQUIRED',true);
$_SESSION['token'] = uniqid(mt_rand(), true);

include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

if (isset($_POST['user']) && isset($_POST['password'])) {
    $v_user = escapeshellarg($_POST['user']);

    $v_password = exec('mktemp -p /tmp');
    $fp = fopen($v_password, "w");
    fwrite($fp, $_POST['password']."\n");
    fclose($fp);

    exec(VESTA_CMD ."v-check-user-password ".$v_user." ".$v_password." ".escapeshellarg($_SERVER['REMOTE_ADDR']),  $output, $return_var);
    unset($output);

    unlink($v_password);

    if ( $return_var == 0 ) {

		$backup = basename($_GET['backup']);

		if (!file_exists('/backup/'.$backup)) {
		    exit(0);
		}

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
        <link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@v1.0.0/css/style.css" rel="stylesheet">
    </head>
    <body class="fix-header">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>
                    </body>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
</html>