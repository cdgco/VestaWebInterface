<?php

session_start();
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

if(isset($dnsenabled) && $dnsenabled != 'true'){ header("Location: ../error-pages/403.html"); }

$v_1 = $_GET['domain'];

$curl4 = curl_init();
curl_setopt($curl4, CURLOPT_URL, $vst_url);
curl_setopt($curl4, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl4, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl4, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl4, CURLOPT_POST, true);
curl_setopt($curl4, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password, 'cmd' => 'vwi-chmod-file-640','arg1' => $username,'arg2' => $v_1)));
curl_exec($curl4);

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
                content: "PROCESSING ...";
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
        <script src="../plugins/components/jquery/dist/jquery.min.js"></script>
    </body>
</html>
<?php header("Location: ../list/dns.php"); ?>