<?php

session_start();

    if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); }  else { header( 'Location: ../install' );};
    if(base64_decode($_SESSION['loggedin']) == 'true') {}
    else { header('Location: ../login.php'); }

    $v_rid = $_POST['v_id'];
    $v_zid = $_POST['v_zid'];
    $v_domain = $_POST['v_domain'];
    $v_record = $_POST['v_record'];
    $v_type = $_POST['v_type'];
    $v_value = $_POST['v_value'];
    $v_ttl = $_POST['v_ttl'];
    if (!empty($_POST['v_cf'])) {
        $v_cf = 'true';
    } else {
        $v_cf = 'false';
    }

    if ((!isset($_POST['v_domain'])) || ($_POST['v_domain'] == '')) { header('Location: ../list/dns.php?error=1');}
    elseif ((!isset($_POST['v_record'])) || ($_POST['v_record'] == '')) { header('Location: ../edit/cfrecord.php?error=1&domain=' . $v_domain);}
    elseif ((!isset($_POST['v_value'])) || ($_POST['v_value'] == '')) { header('Location: ../edit/cfrecord.php?error=1&domain=' . $v_domain);}

    if ($v_ttl == '') { $postvar1 = "1";} else { $postvar1 = $v_ttl; }
    if ($v_cf != '') { $postvar2 = ',"proxied":' . $v_cf; }
    $curlpost = '{"type":"' . $v_type .'","name":"' . $v_record .'","content":"' . $v_value .'","ttl":' . $postvar1 . $postvar2 . '}';

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/" . $v_zid . "/dns_records/" . $v_rid,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS => $curlpost,
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "X-Auth-Email: " . CLOUDFLARE_EMAIL,
        "X-Auth-Key: " . CLOUDFLARE_API_KEY
      )));

$response = array_values(json_decode(curl_exec($curl), true))[1];
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
        
<form id="form" action="../edit/cfrecord.php?domain=<?php echo $v_zid; ?>&record=<?php echo $v_rid; ?>" method="post">
<?php 
    echo '<input type="hidden" name="addcode" value="'.$response.'">';
?>
</form>
<script type="text/javascript">
    document.getElementById('form').submit();
</script>
                    </body>
        <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
</html>