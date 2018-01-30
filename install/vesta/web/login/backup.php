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
            }
            else {
                $_SESSION['language'] = 'en';
            }
            // Regenerate session id to prevent session fixation
            session_regenerate_id();

            // Continue Download
            header("Location /download/backup/index.php?backup=" . $_GET['backup']);

        }
    }
// Check system configuration
exec (VESTA_CMD . "v-list-sys-config json", $output, $return_var);
$data = json_decode(implode('', $output), true);
$sys_arr = $data['config'];
foreach ($sys_arr as $key => $value) {
    $_SESSION[$key] = $value;
}

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
    }
    else {
        $_SESSION['language'] = 'en';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/css/style.css" rel="stylesheet">
    </head>
    <body class="fix-header">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>
<?php header("Location: /download/backup/index.php?backup=" . $_GET['backup']); ?>

                    </body>
        <script src="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@CDN-Test-v0.1/plugins/bower_components/jquery/dist/jquery.min.js"></script>
</html>