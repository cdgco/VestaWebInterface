## Selective Install
To selectively install VWI or to install the web interface on a non-VestaCP server, follow these steps:


#### Step 1:
[Download the latest release](https://github.com/cdgco/VestaWebInterface/archive/v0.4.0-Beta.zip) of VWI from GitHub.

#### Step 2:
Extract Vesta Web Interface to a blank domain directory.

#### Step 3:
Install the Vesta Web Interface backend on your VestaCP server.
```
bash <(curl -s https://cdgco.github.io/backend)
```
#### Step 4:
Install the optional language packs on your frontend server (required for translation support).
```
bash <(curl -s https://cdgco.github.io/lang)
```
#### Step 5:
Configure Vesta Web Interface through the web based configurator or manual configuration.

* Web Based Configuration:
    
 - chmod 'includes' folder, 'tmp' foler and 'plugins/images/uploads' folder to 777.
```
chmod 777 includes tmp plugins/images/uploads
```
Visit the URL of your installation in your browser and enter the desired settings in the web based configurator.
chmod 'includes' folder to 755.
```
chmod 755 includes
```
* Manual Configuration
 - Edit the 'includes/config-example.php' file and enter the connection details to your MySQL server.
 - Rename the 'includes/config-example.php' file to 'config.php'
 - Use the vwi_config.sql file to initialize your the vwi_config table in your database.
 - Edit the settings within the vwi_config table following the instructions from the [manual config](manual-config) page.


Installation is now complete. Visit your URL to start using Vesta Web Interface.