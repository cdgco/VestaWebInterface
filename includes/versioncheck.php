***REMOVED***

require 'currentversion.php';

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/cdgco/VestaWebInterface/tags");
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

$data = curl_exec($ch);
curl_close($ch);

$data2 = json_decode($data, true);
$ghversion = $data2[0]['name'];
if ($ghversion == $currentversion) { echo $currentversion; ***REMOVED*** else {echo '<a href="https://github.com/cdgco/VestaWebInterface/releases" style="text-decoration: underline;" data-toggle="tooltip" title="Update Available!">' . $currentversion . ' (Outdated)</a>';***REMOVED***

***REMOVED***