***REMOVED***

session_start();

$_SESSION["theme"] = base64_encode($_GET["theme"] . ".css");
header("Location: ../index.php");

***REMOVED***
