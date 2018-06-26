<?php

$currentversion = 'v0.5.0-Beta';

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, "https://api.github.com/repos/cdgco/VestaWebInterface/tags?access_token=7925793d9426bdd79702dfb6b6de936af7560e74");
curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

$data = curl_exec($ch);
curl_close($ch);

$data2 = json_decode($data, true);
$ghversion = $data2[0]['name'];
if (isset($ghversion) && $ghversion != '') {
    if ($ghversion <= $currentversion) { echo $currentversion; } else {echo '<a href="https://github.com/cdgco/VestaWebInterface/releases" style="text-decoration: underline;" data-toggle="tooltip" title="' . $ghversion . ' Now Available!">' . $currentversion . ' (Outdated)</a>';}
} 
else { echo $currentversion;}
?>
