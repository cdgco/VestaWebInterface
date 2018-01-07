<?php
$locale = 'de';
if (isSet($_GET["locale"])) $locale = $_GET["locale"];

$domain = 'messages';

$results = putenv("LC_ALL=$locale");
if (!$results) {
    exit ('putenv failed');
}

// http://msdn.microsoft.com/en-us/library/39cwe7zf%28v=vs.100%29.aspx
$results = setlocale(LC_ALL, $locale);
if (!$results) {
    exit ('setlocale failed: locale function is not available on this platform, or the given local does not exist in this environment');
}

$results = bindtextdomain($domain, "./locale");
echo 'new text domain is set: ' . $results. "\n";

$results = textdomain($domain);
echo 'current message domain is set: ' . $results. "\n";

$results = gettext("Username");
if ($results === "Username") {
    echo "original English was returned. Something wrong\n";
}
echo $results . "\n";