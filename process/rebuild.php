***REMOVED***
if (file_exists( '../includes/config.php' )) { require( '../includes/config.php'); ***REMOVED***  else { header( 'Location: ../install' );***REMOVED***;

    if(base64_decode($_COOKIE['loggedin']) == 'true') {***REMOVED***
      else { header('Location: ../login.php'); ***REMOVED***

$postaction = $_POST['action'];
$vst_command = 'v-' . $postaction;


    $postvars = array(
      array('user' => $vst_username,'password' => $vst_password,'cmd' => $vst_command,'arg1' => $username));

    $curl0 = curl_init();
    $curlstart = 0; 

    while($curlstart <= 0) {
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_URL, $vst_url);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_RETURNTRANSFER,true);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_POST, true);
        curl_setopt(${'curl' . $curlstart***REMOVED***, CURLOPT_POSTFIELDS, http_build_query($postvars[$curlstart]));
        $curlstart++;
    ***REMOVED*** 
 if(curl_exec($curl0)){
header('Location: ../index.php?rebuild=true');
     ***REMOVED***
***REMOVED***