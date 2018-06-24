<?php

session_start();
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

if(isset($dnsenabled) && $dnsenabled != 'true'){ header("Location: ../error-pages/403.html"); }

$cf = curl_init();

curl_setopt($cf, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones/".$_GET['zid']."/dns_records/".$_GET['id']);
curl_setopt($cf, CURLOPT_RETURNTRANSFER,true);
curl_setopt($cf, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($cf, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($cf, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($cf, CURLOPT_HTTPHEADER, array(
    "X-Auth-Email: " . CLOUDFLARE_EMAIL,
    "X-Auth-Key: " . CLOUDFLARE_API_KEY));

curl_exec($cf);
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

        <form id="form" action="../list/cfdomain.php?domain=<?php echo $_GET['domain']; ?>" method="post">
            <?php 
            echo '<input type="hidden" name="delcode" value="0">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../plugins/components/jquery/dist/jquery.min.js"></script>
</html>