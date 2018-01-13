<?php

require "config.php";

if (strpos($vwipanel,'http://') === false && strpos($vwipanel,'https://') === false){
    $vwipanel = 'http://'.$vwipanel;
}
$vwipanel = rtrim($vwipanel, '/') . '/';
header("Location: " . $vwipanel . "index.php");

?>