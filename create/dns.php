***REMOVED***

    require '../includes/config.php';
    if(base64_decode($_COOKIE['loggedin']) == 'true') {***REMOVED***
    else { header('Location: ../login.php'); ***REMOVED***

    $v_1 = $_POST['v_domain'];
    $v_2 = $_POST['v_ip'];
    $v_3 = $_POST['v_ns1'];
    $v_4 = $_POST['v_ns2'];
    $v_5 = $_POST['v_ns3'];
    $v_6 = $_POST['v_ns4'];
    $v_7 = $_POST['v_ns5'];
    $v_8 = $_POST['v_ns6'];
    $v_9 = $_POST['v_ns7'];
    $v_10 = $_POST['v_ns8'];

    if ((!isset($_POST['v_domain'])) || ($_POST['v_domain'] == '')) { header('Location: ../list/dns.php?returncode=1');***REMOVED***
    elseif ((!isset($_POST['v_ip'])) || ($_POST['v_ip'] == '')) { header('Location: ../list/dns.php?returncode=1');***REMOVED***
    elseif ((!isset($_POST['v_ns1'])) || ($_POST['v_ns1'] == '')) { header('Location: ../list/dns.php?returncode=1');***REMOVED***
    elseif ((!isset($_POST['v_ns2'])) || ($_POST['v_ns2'] == '')) { header('Location: ../list/dns.php?returncode=1');***REMOVED***

    $postvars = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-dns-domain','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_2, 'arg4' => $v_3, 'arg5' => $v_4, 'arg6' => $v_5, 'arg7' => $v_6, 'arg8' => $v_7, 'arg9' => $v_8, 'arg10' => $v_9, 'arg11' => $v_10);

    $curl0 = curl_init();
    curl_setopt($curl0, CURLOPT_URL, $vst_url);
    curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl0, CURLOPT_POST, true);
    curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars));
    $r1 = curl_exec($curl0);

    header('Location: ../list/dns.php?returncode=' . $r1);

***REMOVED***