<<?php

session_start();

$cookie1 = base64_encode($_GET['theme'] . '.css');
setcookie('theme', $cookie1, time() + (86400 * 30), "/");

?>