<?php 

session_start();

if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); }  else { header( 'Location: ../install' );};

if(base64_decode($_SESSION['loggedin']) == 'true') {}
else { header('Location: ../login.php'); }


if($initialusername == "admin" && isset($_SESSION['proxied']) && base64_decode($_SESSION['proxied']) != '')   {
    $_SESSION['proxied'] = '';
    unset($_SESSION['proxied']);
    header("Location: ../admin/list/users.php");
}  
else {
    session_start();
    session_destroy();

    header('Location: ../login.php'); 
    exit;
}

?>