<?php

/** 
*
* Vesta Web Interface v0.5.1-Beta
*
* Copyright (C) 2018 Carter Roeser <carter@cdgtech.one>
* https://cdgco.github.io/VestaWebInterface
*
* Vesta Web Interface is free software: you can redistribute it and/or modify
* it under the terms of version 3 of the GNU General Public License as published 
* by the Free Software Foundation.
*
* Vesta Web Interface is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with Vesta Web Interface.  If not, see
* <https://github.com/cdgco/VestaWebInterface/blob/master/LICENSE>.
*
*/

session_start();
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' );};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }

if(isset($dnsenabled) && $dnsenabled != 'true'){ header("Location: ../error-pages/403.html"); }

$v_1 = $_POST['domain'];

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.cloudflare.com/client/v4/zones?name=" . $_POST['domain'],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "X-Auth-Email: " . CLOUDFLARE_EMAIL,
        "X-Auth-Key: " . CLOUDFLARE_API_KEY
    ),
));

$response = curl_exec($curl);
curl_close($curl);

$cfrdata = array_values(json_decode($response, true));
$cfid = $cfrdata[0][0]['id'];
$cfname = $cfrdata[0][0]['name'];
$cfns1 = $cfrdata[0][0]['name_servers'][0];
$cfns2 = $cfrdata[0][0]['name_servers'][1];



$curl0 = curl_init(); 

curl_setopt($curl0, CURLOPT_URL, $vst_url);
curl_setopt($curl0, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl0, CURLOPT_POST, true);
curl_setopt($curl0, CURLOPT_POSTFIELDS, http_build_query( array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-list-dns-records','arg1' => $username,'arg2' => $v_1, 'arg3' => 'json')));

$dnsdata = array_values(json_decode(curl_exec($curl0), true));
$keys = array_keys(array_column(json_decode(curl_exec($curl0), true), 'TYPE'), 'NS');

foreach ($keys as &$value) {
    $value = $dnsdata[$value]['ID'];
}  
$requestArr = array_column(json_decode(curl_exec($curl0), true), 'TYPE');
$requestrecord = array_search('NS', $requestArr);
$requestrecord = $dnsdata[$requestrecord]['ID'];
foreach($keys as $val) {

    ${'curl' . $val} = curl_init(); 

    curl_setopt(${'curl' . $val}, CURLOPT_URL, $vst_url);
    curl_setopt(${'curl' . $val}, CURLOPT_RETURNTRANSFER,true);
    curl_setopt(${'curl' . $val}, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt(${'curl' . $val}, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt(${'curl' . $val}, CURLOPT_POST, true);
    curl_setopt(${'curl' . $val}, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-delete-dns-record','arg1' => $username,'arg2' => $v_1, 'arg3' => $val)));

    curl_exec( ${'curl' . $val});
    curl_close( ${'curl' . $val});
} 

$curl1 = curl_init(); 

curl_setopt($curl1, CURLOPT_URL, $vst_url);
curl_setopt($curl1, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl1, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl1, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl1, CURLOPT_POST, true);
curl_setopt($curl1, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-dns-record','arg1' => $username,'arg2' => $v_1, 'arg3' => '@', 'arg4' => 'NS', 'arg5' => $cfns1)));

curl_exec($curl1);
curl_close($curl1);

$curl2 = curl_init(); 

curl_setopt($curl2, CURLOPT_URL, $vst_url);
curl_setopt($curl2, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl2, CURLOPT_POST, true);
curl_setopt($curl2, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'returncode' => 'yes','cmd' => 'v-add-dns-record','arg1' => $username,'arg2' => $v_1, 'arg3' => '@', 'arg4' => 'NS', 'arg5' => $cfns2)));

curl_exec($curl2);
curl_close($curl2);

$curl3 = curl_init(); 

curl_setopt($curl3, CURLOPT_URL, $vst_url);
curl_setopt($curl3, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl3, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl3, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl3, CURLOPT_POST, true);
curl_setopt($curl3, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password,'cmd' => 'v-delete-dns-record','arg1' => $username,'arg2' => $v_1, 'arg3' => $dnsdata[$requestrecord]['ID'])));

curl_exec($curl3);
curl_close($curl3);

$curl4 = curl_init();
curl_setopt($curl4, CURLOPT_URL, $vst_url);
curl_setopt($curl4, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl4, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl4, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl4, CURLOPT_POST, true);
curl_setopt($curl4, CURLOPT_POSTFIELDS, http_build_query(array('hash' => $vst_apikey, 'user' => $vst_username,'password' => $vst_password, 'cmd' => 'vwi-chmod-file-644','arg1' => $username,'arg2' => $v_1)));
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
        <form id="form" action="<?php echo $url8083 . '/vwi/cloudflare.php?domain='.$v_1; ?>" method="post">
            <?php 
            vwicrypt('testw', 'e');   
            echo '<input type="hidden" name="zoneid" value="'.$cfid.'">';
            echo '<input type="hidden" name="apiemail" value="'.CLOUDFLARE_EMAIL.'">';
            echo '<input type="hidden" name="apikey" value="'.CLOUDFLARE_API_KEY.'">';
            echo '<input type="hidden" name="username" value="'.$username.'">';
            echo '<input type="hidden" name="returnlink" value="'. substr("http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI], 0, -5) . '3.php">';

            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
        <script src="../plugins/components/jquery/dist/jquery.min.js"></script>
        <script>
            setTimeout( function(){ 
                $('.loader').addClass("special"); 
            }  , 4000 );
            setTimeout( function(){ 
                $('.loader').addClass("process"); 
            }  , 10000 );
        </script>
    </body>
</html>