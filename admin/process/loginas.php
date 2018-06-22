<?php

session_start();

if (file_exists( '../../includes/config.php' )) { require( '../../includes/includes.php'); }  else { header( 'Location: ../../install' );};
if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../../login.php'); }
if($username != 'admin') { header("Location: ../../"); }

$v_user = $_GET['user'];

if ((!isset($_GET['user'])) || ($_GET['user'] == '')) { header('Location: ../list/users.php?error=1');}


$_SESSION['proxied'] = base64_encode($_GET["user"]);  

header("Location: ../../index.php");

?>