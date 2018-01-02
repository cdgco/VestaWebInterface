<?php

    require '../includes/config.php';
    if(base64_decode($_COOKIE['loggedin']) == 'true') {}
    else { header('Location: ../login.php'); }

    $v_1 = $_POST['v_database'];
    $v_2 = $_POST['v_dbuser'];
    $v_3 = $_POST['password'];

    if ((!isset($_POST['v_database'])) || ($_POST['v_database'] == '')) { header('Location: ../list/db.php?returncode=1');}
    elseif ((!isset($_POST['v_dbuser'])) || ($_POST['v_dbuser'] == '')) { header('Location: ../edit/db.php?returncode=1&domain=' . $v_1);}

    $postvars = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-database-user','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_2, 'arg4' => $v_3);

    $curl0 = curl_init();
    curl_setopt($curl0, CURLOPT_URL, $vst_url);
    curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl0, CURLOPT_POST, true);
    curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars));
    $r1 = curl_exec($curl0);

    header('Location: ../edit/db.php?returncode=' . $r1 . '&domain=' . $v_1);

?>