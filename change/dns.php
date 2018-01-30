<?php

session_start();

    if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); }  else { header( 'Location: ../install' );};
    if(base64_decode($_SESSION['loggedin']) == 'true') {}
    else { header('Location: ../login.php'); }

    $v_1 = $_POST['v_domain'];
    $v_2 = $_POST['v_ip'];
    $v_3 = $_POST['v_tpl'];
    $v_4 = $_POST['v_exp'];
    $v_4 = date("Y-m-d", strtotime($v_4));
    $v_5 = $_POST['v_soa'];
    $v_6 = $_POST['v_ttl'];

    if ((!isset($_POST['v_domain'])) || ($_POST['v_domain'] == '')) { header('Location: ../list/dns.php?returncode=1');}
    elseif ((!isset($_POST['v_ip'])) || ($_POST['v_ip'] == '')) { header('Location: ../edit/dns.php?returncode=1&domain=' . $v_1);}
    elseif ((!isset($_POST['v_tpl'])) || ($_POST['v_tpl'] == '')) { header('Location: ../edit/dns.php?returncode=1&domain=' . $v_1);}
    elseif ((!isset($_POST['v_exp'])) || ($_POST['v_exp'] == '')) { header('Location: ../edit/dns.php?returncode=1&domain=' . $v_1);}
    elseif ((!isset($_POST['v_soa'])) || ($_POST['v_soa'] == '')) { header('Location: ../edit/dns.php?returncode=1&domain=' . $v_1);}
    elseif ((!isset($_POST['v_ttl'])) || ($_POST['v_ttl'] == '')) { header('Location: ../edit/dns.php?returncode=1&domain=' . $v_1);}

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
        curl_setopt(${'curl' . $curlstart}, CURLOPT_URL, $vst_url);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_RETURNTRANSFER,true);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_POST, true);
        curl_setopt(${'curl' . $curlstart}, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
        $curlstart++;
    } 
    $r1 = curl_exec($curl0);
    $r2 = curl_exec($curl1);
    $r3 = curl_exec($curl2);
    $r4 = curl_exec($curl3);
    $r5 = curl_exec($curl4);

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
        
        
<form id="form" action="../edit/dns.php?domain=<?php echo $v_1; ?>" method="post">
<?php 
    echo '<input type="hidden" name="r1" value="'.$r1.'">';
    echo '<input type="hidden" name="r2" value="'.$r2.'">';
    echo '<input type="hidden" name="r3" value="'.$r3.'">';
    echo '<input type="hidden" name="r4" value="'.$r4.'">';
    echo '<input type="hidden" name="r5" value="'.$r5.'">';
?>
</form>
<script type="text/javascript">
    document.getElementById('form').submit();
</script>
                    </body>
        <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
</html>