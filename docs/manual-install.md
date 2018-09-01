## Manual Install
To selectively install VWI or to install the web interface on a non-VestaCP server, follow these steps:

#### Step 1:
[Download the latest release](https://github.com/cdgco/VestaWebInterface/archive/v0.5.2-Beta.zip) of VWI from GitHub.

#### Step 2:
Extract Vesta Web Interface to a blank domain directory.

#### Step 3:
Copy the contents of the 'install/vesta' folder in the release to the '/usr/local/vesta' directory of your vesta server.

#### Step 4:
Edit the /usr/local/vesta/web/vwi/config.php file and enter the URL where Vesta Web Interface will be accessed from, including the "http(s)://" and the following "/".

#### Step 5:
Install the optional language packs on your frontend server (required for translation support).
```shell
bash <(curl -s https://cdgco.github.io/lang)
```

#### Step 6:
Configure Vesta Web Interface through the web based configurator or manual configuration.

* Web Based Configuration:
    
 - chmod 'includes' folder, 'tmp' foler and 'plugins/images/uploads' folder to 777.
    ```shell
    chmod 777 includes tmp plugins/images/uploads
    ```
  
 - Visit the URL of your installation in your browser, ensure all requirements are met.

 - Create a new MySQL / MariaDB database and user or use an existing MySQL / MariaDB database and user and enter the details into the installer. The specified user must have basic read and write access to the database.

   - 'root' users and users without passwords are accepted but are not recommended for added security. 

   - localhost / 127.0.0.1, web addresses and IP addresses are acceptable hosts. 

   - Ensure that your selected database does not have an existing table named vwi_config (or a table with your specified prefix). If there is a table under the same name, change the prefix to a unique name.

  - Continue the installation and configure VWI to your liking, entering the desired settings in the web based configurator. For help, visit the [configuration documentation](web-config).

  - chmod 'includes' folder to 755.
    ```shell
    chmod 755 includes
    ```
* Manual Configuration

 - Create a new MySQL / MariaDB database and user or use an existing MySQL / MariaDB database and user and enter the details into the installer. The specified user must have basic read and write access to the database.

   - 'root' users and users without passwords are accepted but are not recommended for added security. 

   - localhost / 127.0.0.1, web addresses and IP addresses are acceptable hosts. 

   - Ensure that your selected database does not have an existing table named vwi_config (or a table with your specified prefix). If there is a table under the same name, change the prefix to a unique name.

 - Edit the 'includes/config-example.php' file and enter the connection details to your MySQL server.
 
 - Rename the 'includes/config-example.php' file to 'config.php'
 
 - Use the vwi_config.sql file to initialize your the vwi_config table in your database.
 
 - Edit the settings within the vwi_config table following the instructions from the [manual config](manual-config) page.


Installation is now complete. Visit your URL to start using Vesta Web Interface.