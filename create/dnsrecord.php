***REMOVED***

    require '../includes/vars.php';
    if(base64_decode($_COOKIE['loggedin']) == 'true') {***REMOVED***
    else { header('Location: ../login.php'); ***REMOVED***

    $v_domain = $_POST['v_domain'];
    $v_record = $_POST['v_record'];
    $v_type = $_POST['v_type'];
    $v_value = $_POST['v_value'];
    $v_priority = $_POST['v_priority'];

    if ((!isset($_POST['v_domain'])) || ($_POST['v_domain'] == '')) { header('Location: ../list/dns.php?returncode=1');***REMOVED***
    elseif ((!isset($_POST['v_record'])) || ($_POST['v_record'] == '')) { header('Location: ../list/dnsdomain.php?returncode=1&domain=' . $v_domain);***REMOVED***
    elseif ((!isset($_POST['v_type'])) || ($_POST['v_type'] == '')) { header('Location: ../list/dnsdomain.php?returncode=1&domain=' . $v_domain);***REMOVED***
    elseif ((!isset($_POST['v_value'])) || ($_POST['v_value'] == '')) { header('Location: ../list/dnsdomain.php?returncode=1&domain=' . $v_domain);***REMOVED***

    $postvars = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-dns-record','arg1' => $username,'arg2' => $v_domain, 'arg3' => $v_record, 'arg4' => $v_type, 'arg5' => $v_value, 'arg6' => $v_priority);

    $curl0 = curl_init();
    curl_setopt($curl0, CURLOPT_URL, $vst_url);
    curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl0, CURLOPT_POST, true);
    curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars));
    $r1 = curl_exec($curl0);

    header('Location: ../list/dnsdomain.php?returncode=' . $r1 . '&domain=' . $v_domain);

***REMOVED***