***REMOVED***

    require '../includes/config.php';
    if(base64_decode($_COOKIE['loggedin']) == 'true') {***REMOVED***
    else { header('Location: ../login.php'); ***REMOVED***

    $v_min = $_POST['v_min'];
    $v_hour = $_POST['v_hour'];
    $v_day = $_POST['v_day'];
    $v_month = $_POST['v_month'];
    $v_wday = $_POST['v_wday'];
    $v_cmd = $_POST['v_cmd'];
    $v_job = $_POST['v_job'];

    if ((!isset($_POST['v_min'])) || ($_POST['v_min'] == '')) { header('Location: ../edit/cron.php?returncode=1&job=' . $v_job);***REMOVED***
    elseif ((!isset($_POST['v_hour'])) || ($_POST['v_hour'] == '')) { header('Location: ../edit/cron.php?returncode=1&job=' . $v_job);***REMOVED***
    elseif ((!isset($_POST['v_day'])) || ($_POST['v_day'] == '')) { header('Location: ../edit/cron.php?returncode=1&job=' . $v_job);***REMOVED***
    elseif ((!isset($_POST['v_month'])) || ($_POST['v_month'] == '')) { header('Location: ../edit/cron.php?returncode=1&job=' . $v_job);***REMOVED***
    elseif ((!isset($_POST['v_wday'])) || ($_POST['v_wday'] == '')) { header('Location: ../edit/cron.php?returncode=1&job=' . $v_job);***REMOVED***
    elseif ((!isset($_POST['v_cmd'])) || ($_POST['v_cmd'] == '')) { header('Location: ../edit/cron.php?returncode=1&job=' . $v_job);***REMOVED***
    elseif ((!isset($_POST['v_job'])) || ($_POST['v_job'] == '')) { header('Location: ../list/cron.php?returncode=1');***REMOVED***

    $postvars = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-cron-job','arg1' => $username,'arg2' => $v_job, 'arg3' => $v_min, 'arg4' => $v_hour, 'arg5' => $v_day, 'arg6' => $v_month, 'arg7' => $v_wday, 'arg8' => $v_cmd);

    $curl0 = curl_init();

    curl_setopt($curl0, CURLOPT_URL, $vst_url);
    curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl0, CURLOPT_POST, true);
    curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars));
    $r1 = curl_exec($curl0);

    header('Location: ../edit/cron.php?returncode=' . $r1 . '&job=' . $v_job);

***REMOVED***