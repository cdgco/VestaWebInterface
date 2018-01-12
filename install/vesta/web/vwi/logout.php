***REMOVED***

require "config.php";

if (strpos($vwipanel,'http://') === false && strpos($vwipanel,'https://') === false){
    $vwipanel = 'http://'.$vwipanel;
***REMOVED***
$vwipanel = rtrim($vwipanel, '/') . '/';
header("Location: " . $vwipanel . "process/logout.php");

***REMOVED***