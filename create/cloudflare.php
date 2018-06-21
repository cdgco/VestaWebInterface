<?php

session_start();

if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); }  else { header( 'Location: ../install' );};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

$v_1 = $_GET['domain'];


if (CLOUDFLARE_EMAIL != '' && CLOUDFLARE_API_KEY != ''){
    $cfenabled = curl_init();

    curl_setopt($cfenabled, CURLOPT_URL, "https://api.cloudflare.com/client/v4/zones?name=" . $v_1);
    curl_setopt($cfenabled, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($cfenabled, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($cfenabled, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($cfenabled, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($cfenabled, CURLOPT_HTTPHEADER, array(
        "X-Auth-Email: " . CLOUDFLARE_EMAIL,
        "X-Auth-Key: " . CLOUDFLARE_API_KEY));

    $cfdata = array_values(json_decode(curl_exec($cfenabled), true));
    $cfid = $cfdata[0][0]['id'];
    $cfname = $cfdata[0][0]['name'];

    if ($cfdata[0][0]['name'] != '' && isset($cfdata[0][0]['name']) && $cfdata[0][0]['name'] == $v_1){ 

        $cfdelete = curl_init();

        curl_setopt_array($cfdelete, array(
            CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/" . $cfid,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "DELETE",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "X-Auth-Email: " . CLOUDFLARE_EMAIL,
                "X-Auth-Key: " . CLOUDFLARE_API_KEY
            ),
        ));

        curl_exec($cfdelete);

    }

    $cfcreate = curl_init();

    curl_setopt_array($cfcreate, array(
        CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => '{"name":"' . $v_1 . '"}',
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "X-Auth-Email: " . CLOUDFLARE_EMAIL,
            "X-Auth-Key: " . CLOUDFLARE_API_KEY
        ),
    ));

    curl_exec($cfcreate);

    if (isset($_GET['cflevel']) && $cflevel != '') {
        $cflevel = curl_init();

        curl_setopt_array($cflevel, array(
            CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/" . $cfid . "/settings/security_level",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "PATCH",
            CURLOPT_POSTFIELDS => '{"value":"' . $_GET['cflevel'] . '"}',
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "X-Auth-Email: " . CLOUDFLARE_EMAIL,
                "X-Auth-Key: " . CLOUDFLARE_API_KEY
            ),
        ));

        curl_exec($cflevel);
    }
    if (isset($_GET['cfssl']) && $cfssl != '') {
        $cfssl = curl_init();

        curl_setopt_array($cfssl, array(
            CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones/" . $cfid . "/settings/ssl",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "PATCH",
            CURLOPT_POSTFIELDS => '{"value":"' . $_GET['cfssl'] . '"}',
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "X-Auth-Email: " . CLOUDFLARE_EMAIL,
                "X-Auth-Key: " . CLOUDFLARE_API_KEY
            ),
        ));

        curl_exec($cfssl);
    }
}
?>

<!DOCTYPE html>
<html lang="en" >

    <head>
        <meta charset="UTF-8">
        <style>
            @import url(https://fonts.googleapis.com/css?family=Lato:300);


            body{
                text-align: center;
                background-color: darkorange;
                overflow: hidden;
                height: 100%;
                line-height: 100%;
            }
            .outer {
                display: table;
                position: absolute;
                height: 100%;
                width: 100%;
            }

            .middle {
                display: table-cell;
                vertical-align: middle;
            }
            .box{
                margin-left: auto;
                margin-right: auto; 
                display: inline-block;
                height: 200px;
                position: relative;
                /*margin:0 -4px -5px -2px;*/
                transition: all .2s ease;
            }

            /* MEDIA QUERIES */
            @media (max-width: 700px){
                .box{
                    width: 50%;
                }

                .box:nth-child(2n-1){
                    background-color: inherit;
                }

                .box:nth-child(4n),.box:nth-child(4n-3) {
                    background-color: rgba(0,0,0,0.05);
                }

            }

            @media (max-width: 420px){
                .box{
                    width: 100%;
                }

                .box:nth-child(4n),.box:nth-child(4n-3){
                    background-color: inherit;
                }

                .box:nth-child(2n-1){
                    background-color:rgba(0,0,0,0.05);
                }

            }

            .loader{
                position: relative;
                width: 150px;
                height: 20px;
                top: 45%;
                top: -webkit-calc(50% - 10px);
                top: calc(50% - 10px);
                left: 25%;
                left: -webkit-calc(50% - 75px);
                left: calc(50% - 75px);
            }

            .loader:after{
                content: "CHECKING DOMAIN ...";
                color: #fff;
                font-family:  Lato,"Helvetica Neue" ;
                font-weight: 200;
                font-size: 14px;
                position: absolute;
                width: 100%;
                height: 20px;
                line-height: 20px;
                left: 0;
                top: 0;
                background-color: darkorange;
                z-index: 1;
            }
            .special:after{
                content: "ADDING DOMAIN ...";
            }
            .update:after{
                content: "UPDATING SETTINGS ...";
            }
            .process:after{
                content: "PROCESSING ...";
            }
            .loader:before{
                content: "";
                position: absolute;
                background-color: #fff;
                top: -5px;
                left: 0px;
                height: 30px;
                width: 0px;
                z-index: 0;
                opacity: 1;
                -webkit-transform-origin:  100% 0%;
                transform-origin:  100% 0% ;
                -webkit-animation: loader 10s ease-in-out infinite;
                animation: loader 10s ease-in-out infinite;
            }



            @-webkit-keyframes loader{
                0%{width: 0px;}
                70%{width: 100%; opacity: 1;}
                90%{opacity: 0; width: 100%;}
                100%{opacity: 0;width: 0px;}
            }

            @keyframes loader{
                0%{width: 0px;}
                70%{width: 100%; opacity: 1;}
                90%{opacity: 0; width: 100%;}
                100%{opacity: 0;width: 0px;}
            }
        </style>
    </head>
    <body>
        <div class="outer">
            <div class="middle">
                <div class="box">
                    <div class="loader"></div>
                </div>
            </div>
        </div>
        <form id="form" action="cloudflare2.php" method="post">
            <?php 
            echo '<input type="hidden" name="domain" value="'.$v_1.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
        <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
        <script>
            setTimeout( function(){ 
                $('.loader').addClass("special"); 
            }  , 4000 );
            setTimeout( function(){ 
                $('.loader').addClass("update"); 
            }  , 10000 );
            setTimeout( function(){ 
                $('.loader').addClass("process"); 
            }  , 14000 );
        </script>
    </body>
</html>
