## Automatic Install
To automatically install all VWI components on the same server, follow these steps:


#### Step 1:
Enter a blank directory within your domain's document root.

Example:
```shell
cd /home/admin/web/mydomain.com/public_html/
```
#### Step 2:
Run the automatic installer.
```shell
bash <(curl -s https://cdgco.github.io/full)
```
#### Step 3:
Visit the URL of your installation in your browser, ensure all requirements are met, and enter the desired settings in the web based configurator. For help, visit the [configuration documentation](web-config).


#### Step 4:
Secure the installation folder.


chmod the 'includes' folder to 755 after configuration is complete.
Failure to do so will leave your configuration file open to the public to be re-written or broken.

Example:
```shell
chmod 755 includes
```
Installation is now complete. Visit your URL to start using Vesta Web Interface.