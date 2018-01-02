***REMOVED***

    require '../includes/vars.php';
    if(base64_decode($_COOKIE['loggedin']) == 'true') {***REMOVED***
    else { header('Location: ../login.php'); ***REMOVED***

    $v_1 = $_POST['v_database'];
    $v_2 = $_POST['v_dbuser'];
    $v_3 = $_POST['password'];
    $v_4 = $_POST['v_type'];
    $v_5 = $_POST['v_host'];
    $v_6 = $_POST['v_charset'];

    if ((!isset($_POST['v_database'])) || ($_POST['v_database'] == '')) { header('Location: ../list/db.php?returncode=1');***REMOVED***
    elseif ((!isset($_POST['v_dbuser'])) || ($_POST['v_dbuser'] == '')) { header('Location: ../list/db.php?returncode=1');***REMOVED***
    elseif ((!isset($_POST['password'])) || ($_POST['password'] == '')) { header('Location: ../list/db.php?returncode=1');***REMOVED***
    elseif ((!isset($_POST['v_type'])) || ($_POST['v_type'] == '')) { header('Location: ../list/db.php?returncode=1');***REMOVED***
    elseif ((!isset($_POST['v_host'])) || ($_POST['v_host'] == '')) { header('Location: ../list/db.php?returncode=1');***REMOVED***
    elseif ((!isset($_POST['v_charset'])) || ($_POST['v_charset'] == '')) { header('Location: ../list/db.php?returncode=1');***REMOVED***

    $postvars = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-database','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_2, 'arg4' => $v_3, 'arg5' => $v_4, 'arg6' => $v_5, 'arg7' => $v_6);

    $curl0 = curl_init();
    curl_setopt($curl0, CURLOPT_URL, $vst_url);
    curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl0, CURLOPT_POST, true);
    curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars));
    $r1 = curl_exec($curl0);

    header('Location: ../list/db.php?returncode=' . $r1);

***REMOVED***