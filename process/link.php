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

session_set_cookie_params(['samesite' => 'none']); session_start();
$configlocation = "../includes/";
if (file_exists( '../includes/config.php' )) { require( '../includes/includes.php'); }  else { header( 'Location: ../install' ); exit(); };
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); exit(); }

if(isset($profileenabled) && $profileenabled != 'true'){ header("Location: ../error-pages/403.html"); exit(); }

if(!$auth0) {
    header('Location: ../index.php');
    exit();
}
else {
    $auth0->logout();
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
    <script src="https://cdn.auth0.com/js/auth0/9.11/auth0.min.js"></script>
    <script type="text/javascript">
        <?php echo 'var webAuth = new auth0.WebAuth({
            domain: "'.AUTH0_DOMAIN.'",
            clientID: "'.AUTH0_CLIENT_ID.'",
            responseMode: "query",
            redirectUri: "'.$auth0location.'",
            responseType: "code"
        });
        webAuth.authorize({ connection: "'.$_GET["auth0"].'" })'; ?>
    </script>
</html>