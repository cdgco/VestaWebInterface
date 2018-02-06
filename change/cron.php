<?php

session_start();

    if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); }  else { header( 'Location: ../install' );};
    if(base64_decode($_SESSION['loggedin']) != 'true') { header('Location: ../login.php'); }

    if (isset($_POST['v_min']) { $v_min = $_POST['v_min']; }
    elseif (isset($_POST['v_hour']) { $v_hour = $_POST['v_hour']; }
    elseif (isset($_POST['v_day']) { $v_month = $_POST['v_month']; }
    elseif (isset($_POST['v_month']) { $v_month = $_POST['v_month']; }
    elseif (isset($_POST['v_wday']) { $v_wday = $_POST['v_wday']; }
    elseif (isset($_POST['v_cmd']) { $v_cmd = $_POST['v_cmd']; }
    elseif (isset($_POST['v_job']) { $v_job = $_POST['v_job']; 
    elseif (!isset($v_min)) { header('Location: ../edit/cron.php?error=1&job=' . $v_job);}
    elseif (!isset($v_hour)) { header('Location: ../edit/cron.php?error=1&job=' . $v_job);}
    elseif (!isset($v_day) { header('Location: ../edit/cron.php?error=1&job=' . $v_job);}
    elseif (!isset($v_month)) { header('Location: ../edit/cron.php?error=1&job=' . $v_job);}
    elseif (!isset($v_wday)) { header('Location: ../edit/cron.php?error=1&job=' . $v_job);}
    elseif (!isset($v_cmd)) { header('Location: ../edit/cron.php?error=1&job=' . $v_job);}
    elseif (!isset($v_job)) { header('Location: ../list/cron.php?error=1');}

    $postvars = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-cron-job','arg1' => $username,'arg2' => $v_job, 'arg3' => $v_min, 'arg4' => $v_hour, 'arg5' => $v_day, 'arg6' => $v_month, 'arg7' => $v_wday, 'arg8' => $v_cmd);

    $curl0 = curl_init();

    curl_setopt($curl0, CURLOPT_URL, $vst_url);
    curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl0, CURLOPT_POST, true);
    curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars));
    $r1 = curl_exec($curl0);

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
        
        
<form id="form" action="../edit/cron.php?job=<?php echo $v_job; ?>" method="post">
<?php 
    echo '<input type="hidden" name="returncode" value="'.$r1.'">';
?>
</form>
<script type="text/javascript">
    document.getElementById('form').submit();
</script>
            </body>
        <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
</html>
