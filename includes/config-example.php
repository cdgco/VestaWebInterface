
***REMOVED***

***REMOVED***
***REMOVED***
***REMOVED***

***REMOVED***
***REMOVED***
DEFINE('SITE_NAME', 'My Host'); // Site name for use in page titles. Ex: 'My Host Company'.
***REMOVED***

***REMOVED***
DEFINE('VESTA_HOST_ADDRESS', ''); // URL or IP Address of VestaCP. Ex: 'myhost.com' or '12.34.56.78'.
***REMOVED***
***REMOVED***
***REMOVED***
DEFINE('VESTA_ADMIN_PW', ''); // Password for VestaCP Admin account. Ex: 'MyPassword1'.

***REMOVED***
***REMOVED***
***REMOVED***
***REMOVED***
DEFINE('PHPPGADMIN_URL', 'disabled'); // phpPgAdmin URL. Leave blank for VestaCP default. Set as 'disabled; to remove phpPgAdmin option.
DEFINE('SUPPORT_URL', 'disabled'); // Support URL. Leave blank or set to 'disabled' to disable.

***REMOVED***
***REMOVED***
***REMOVED***
***REMOVED***
***REMOVED***
***REMOVED***

***REMOVED***
***REMOVED***
***REMOVED***
***REMOVED***

***REMOVED***/////////////
***REMOVED***
***REMOVED***/////////////

***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***

***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***

***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***

***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***

***REMOVED***
***REMOVED***
***REMOVED***
***REMOVED***
***REMOVED***
***REMOVED***
***REMOVED***
***REMOVED***
***REMOVED***
***REMOVED***

***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***

***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***

***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***

***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***

***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
   ***REMOVED***
***REMOVED***
***REMOVED***
require('tracker.php');
$woopra = new WoopraTracker(array("domain" => 'vwi-install.tracker'));
$woopra->set_woopra_cookie();
$woopra->identify(array(
"sitename" => $sitename,
"url" => $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI]));

***REMOVED***
