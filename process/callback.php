<?php

/** 
*
* Vesta Web Interface
*
* Copyright (C) 2020 Carter Roeser <carter@cdgtech.one>
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

if(isset($_GET['state'])) {
    unset($_GET['state']);
}
session_set_cookie_params(['samesite' => 'none']); session_start();
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' ); exit(); };

if(!$auth0) {
    header( 'Location: ../login.php' ); exit();
}

use Auth0\SDK\Exception\CoreException;
use Auth0\SDK\Exception\ApiException;

if (! empty($_GET['error']) || ! empty($_GET['error_description'])) {
    printf( '<h1>Error</h1><p>%s</p>', htmlspecialchars( $_GET['error_description'] ) );
    die();
}



$userInfo = $auth0->getUser();
$auth0id = $userInfo['sub'];
$key = array_search($auth0id, $auth0_users);
if(isset($_SESSION['loggedin'])) {
    if(base64_decode($_SESSION['loggedin']) == 'true') { 
        if(isset($auth0id) && $auth0id != '') {
            $con=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db);
            $v1 = mysqli_real_escape_string($con, $username);
            $v2 = mysqli_real_escape_string($con, $auth0id);
            $insertrow= "INSERT INTO `" . $mysql_table . "auth0-users` (VWI_USER, AUTH0_USER) VALUES ('".$v1."', '".$v2."') ON DUPLICATE KEY UPDATE `AUTH0_USER`='".$v2."';";
            if (mysqli_query($con, $insertrow)) { 
                header('Location: ../profile.php?a=0');
                exit();
            } else { 
                header('Location: ../profile.php?a=' . mysqli_errno($con));
                exit();
            }
            mysqli_close($con);
        }
    }
}
elseif(!isset($_GET['code']) || $_GET['code'] == '') {
    header('Location: ../login.php');
    exit();
}
elseif($key === FALSE) {
    header('Location: noauth.php');
    exit();
}
else {
    $_SESSION['loggedin'] = base64_encode ( 'true' );
    $_SESSION['username'] = base64_encode ( $key );
    $userredirect = '../index.php';
    if($key == "admin" && $defaulttoadmin == "true"){
        $userredirect = '../admin/list/users.php';
    }
    header('Location: ' . $userredirect);
    exit();
}

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
    </body>
    <script src="../plugins/components/jquery/jquery.min.js"></script>
</html>