***REMOVED***

    require '../includes/config.php';
    if(base64_decode($_COOKIE['loggedin']) == 'true') {***REMOVED***
    else { header('Location: ../login.php'); ***REMOVED***

    $v_1 = $_POST['v_domain'];
    $v_2 = $_POST['v_ip'];
    $v_3 = $_POST['v_tpl'];
    $v_4 = $_POST['v_exp'];
    $v_4 = date("Y-m-d", strtotime($v_4));
    $v_5 = $_POST['v_soa'];
    $v_6 = $_POST['v_ttl'];

    if ((!isset($_POST['v_domain'])) || ($_POST['v_domain'] == '')) { header('Location: ../list/dns.php?returncode=1');***REMOVED***
    elseif ((!isset($_POST['v_ip'])) || ($_POST['v_ip'] == '')) { header('Location: ../edit/dns.php?returncode=1&domain=' . $v_1);***REMOVED***
    elseif ((!isset($_POST['v_tpl'])) || ($_POST['v_tpl'] == '')) { header('Location: ../edit/dns.php?returncode=1&domain=' . $v_1);***REMOVED***
    elseif ((!isset($_POST['v_exp'])) || ($_POST['v_exp'] == '')) { header('Location: ../edit/dns.php?returncode=1&domain=' . $v_1);***REMOVED***
    elseif ((!isset($_POST['v_soa'])) || ($_POST['v_soa'] == '')) { header('Location: ../edit/dns.php?returncode=1&domain=' . $v_1);***REMOVED***
    elseif ((!isset($_POST['v_ttl'])) || ($_POST['v_ttl'] == '')) { header('Location: ../edit/dns.php?returncode=1&domain=' . $v_1);***REMOVED***

    $postvars = array(
        array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-dns-domain-ip','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_2),
        array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-dns-domain-tpl','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_3),
        array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-dns-domain-exp','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_4),
        array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-dns-domain-soa','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_5),
        array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-dns-domain-ttl','arg1' => $username,'arg2' => $v_1, 'arg3' => $v_6));

    $curl0 = curl_init();
    $curl1 = curl_init();
    $curl2 = curl_init();
    $curl3 = curl_init();
    $curl4 = curl_init();
    $curlstart = 0; 

    while($curlstart <= 4) {
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_URL, $vst_url);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_RETURNTRANSFER,true);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_POST, true);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
        $curlstart++;
    ***REMOVED*** 
    $r1 = curl_exec($curl0);
    $r2 = curl_exec($curl1);
    $r3 = curl_exec($curl2);
    $r4 = curl_exec($curl3);
    $r5 = curl_exec($curl4);


    header('Location: ../edit/dns.php?domain=' . $v_1 . '&returncode=' . $r1 . $r2 . $r3 . $r4 . $r5);

***REMOVED***