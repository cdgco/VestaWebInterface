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
$configlocation = "../../includes/";
if (file_exists( '../../includes/config.php' )) { require( '../../includes/includes.php'); }  else { header( 'Location: ../../install' ); exit();};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../../login.php'); exit(); }
if($username != 'admin') { header("Location: ../../"); exit(); }

//if(isset($adminenabled) && $adminenabled != 'true'){ header("Location: ../../error-pages/403.html"); exit(); }

$pluginsnew = $plugins;
if(in_array($_GET['plugin'], $pluginsnew)) {
    if(($key = array_search($_GET['plugin'], $pluginsnew)) !== false) {
        unset($pluginsnew[$key]);
        $pluginstring = implode(',', $pluginsnew);

        $conn=mysqli_connect($mysql_server,$mysql_uname,$mysql_pw,$mysql_db);
        $v = mysqli_real_escape_string($conn, $pluginstring);
        $sql = "UPDATE ".$mysql_table."config SET `VALUE` = '".$v."' WHERE `VARIABLE` = 'PLUGINS';";
        if (mysqli_query($conn, $sql)) { $r1 = 0; } else { header("Location: ../list/plugins.php?merr=" . mysqli_errno($con)); }
        mysqli_close($conn);

    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="../../css/style.css" rel="stylesheet">
    </head>
    <body class="fix-header">
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> 
            </svg>
        </div>

        <form id="form" action="../list/plugins.php" method="post">
            <?php 
            echo '<input type="hidden" name="delcode" value="'.$r1.'">';
            ?>
        </form>
        <script type="text/javascript">
            document.getElementById('form').submit();
        </script>
    </body>
    <script src="../../plugins/components/jquery/jquery.min.js"></script>
</html>