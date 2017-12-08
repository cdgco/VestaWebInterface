<?php 

unset($_COOKIE['username']);
setcookie('username', null, -1, '/');
unset($_COOKIE['loggedin']);
setcookie('loggedin', null, -1, '/');

header('Location: ../login.php'); 
exit;
?>