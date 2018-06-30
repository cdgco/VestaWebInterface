## Connection Method

VWI offers two methods of connecting to your MySQL database:

* Method 1 (Basic) connects to a MySQL Server directly, which means that if the MySQL server goes down or takes too long to load, the same will happen to VWI.

* Method 2 (Cached) saves the MySQL table to a json file every 30 minutes and recalls this file if there is an error with the MySQL database.

By default, Method 1 is enabled as Method 2 could cause security or reliability risks if configured incorrectly. Again, by default, this json file is saved within the VWI tmp directory which is within the document root but blocked by a .htaccess rule.

For best and most secure results, we recommend you change this if possible.

To enable Method 2, edit the includes/includes.php file and change `$configstyle` from '1' to '2' on line 12 of the file.
To change the location of the json file, edit `$configlocation` on line 27 to your desired location, where the script has access to write.