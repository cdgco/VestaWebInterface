<?php
if(strpos($_SERVER[HTTP_REFERER], 'process/softaculous.php')) {

    define('NO_AUTH_REQUIRED',true);

    include($_SERVER['DOCUMENT_ROOT']."/inc/main.php");

    if (isset($_POST['user']) && isset($_POST['password'])) {
        $v_user = escapeshellarg($_POST['user']);
        $v_ip = escapeshellarg($_SERVER['REMOTE_ADDR']);
        $v_pass = escapeshellarg($_POST['password']);

        exec(VESTA_CMD . "v-check-user-password ".$v_user." ".$v_pass." ".$v_ip." json", $output, $return_var);

        if($return_var == "0") {
            $output = ''; $return_var = '';
            if ($_POST['user'] == 'root') $v_user = 'admin';

            exec (VESTA_CMD . "v-list-user ".$v_user." json", $output, $return_var);
            $data = json_decode(implode('', $output), true);

            $_SESSION['user'] = key($data);
            $v_user = $_SESSION['user'];

            get_favourites();

            $output = '';
            exec (VESTA_CMD."v-list-sys-languages json", $output, $return_var);
            $languages = json_decode(implode('', $output), true);
            if (in_array($data[$v_user]['LANGUAGE'], $languages)){
                $_SESSION['language'] = $data[$v_user]['LANGUAGE'];
            } else {
                $_SESSION['language'] = 'en';
            }

            exec (VESTA_CMD . "v-list-sys-config json", $output, $return_var);
            $data = json_decode(implode('', $output), true);
            $sys_arr = $data['config'];
            foreach ($sys_arr as $key => $value) {
                $_SESSION[$key] = $value;
            }

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
        $_SESSION['token'] = md5(uniqid(mt_rand(), true));
        }
        else { header("Location: ".strtok($_SERVER['HTTP_REFERER'],'?')."?login-error=true"); }
    }
    else {
        header("Location: ".strtok($_SERVER['HTTP_REFERER'],'?')."?login-error=true");
    }
}
else {
    echo 'Access Denied';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@2.2.0/css/style.css" rel="stylesheet">
</head>
<body class="fix-header">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
                </body>
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script>
    setTimeout(function(){window.location="../softaculous";}, 500)
    </script>
</html>
