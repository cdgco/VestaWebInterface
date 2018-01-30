<?php

    if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); }  else { header( 'Location: ../install' );};
    if(base64_decode($_SESSION['loggedin']) == 'true') {}
    else { header('Location: ../login.php'); }

    $v_domain = $_POST['v_domain'];
    $v_id = $_POST['v_id'];
    $v_id2 = $_POST['v_id2'];
    $v_value = $_POST['v_value'];
    $v_priority = $_POST['v_priority'];

    if ((!isset($_POST['v_domain'])) || ($_POST['v_domain'] == '')) { header('Location: ../list/dns.php?returncode=1');}
    elseif ((!isset($_POST['v_id'])) || ($_POST['v_id'] == '')) { header('Location: ../list/dnsdomain.php?returncode=1&domain=' . $v_domain);}
    elseif ((!isset($_POST['v_id2'])) || ($_POST['v_id2'] == '')) { header('Location: ../edit/dnsrecord.php?returncode=1&domain=' . $v_domain . '&record=' . $v_id);}
    elseif ((!isset($_POST['v_type'])) || ($_POST['v_type'] == '')) { header('Location: ../edit/dnsrecord.php?returncode=1&domain=' . $v_domain . '&record=' . $v_id);}
    elseif ((!isset($_POST['v_value'])) || ($_POST['v_value'] == '')) { header('Location: ../edit/dnsrecord.php?returncode=1&domain=' . $v_domain . '&record=' . $v_id);}

    $postvars = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-dns-record','arg1' => $username,'arg2' => $v_domain, 'arg3' => $v_id, 'arg4' => $v_value, 'arg5' => $v_priority);

    $curl0 = curl_init();
    curl_setopt($curl0, CURLOPT_URL, $vst_url);
    curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl0, CURLOPT_POST, true);
    curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query($postvars));
    $r1 = curl_exec($curl0);

    if ($v_id != $v_id2) {

        $postvars1 = array('user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-change-dns-record-id','arg1' => $username,'arg2' => $v_domain, 'arg3' => $v_id, 'arg4' => $v_id2);

        $curl1 = curl_init();
        curl_setopt($curl1, CURLOPT_URL, $vst_url);
        curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl1, CURLOPT_POST, true);
        curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query($postvars1));
        $r2 = curl_exec($curl1);

    }
    else { $r2 = 0; s}
    $newid = $v_id;
    if ($v_id != $v_id2 && $r2 == 0) {
        $newid = $v_id2;
    }

    header('Location: ../edit/dnsrecord.php?r1=' . $r1 . '&r2=' . $r2 . '&domain=' . $v_domain . '&record=' . $newid);

?>