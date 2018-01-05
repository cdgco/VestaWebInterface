![VWI Banner](https://raw.githubusercontent.com/cdgco/VestaWebInterface/master/VWI%20Banner.png)

Preview Available for CDG Host Users (https://host.cdgtech.one)

Live Preview: https://ide.cdgtech.one/dev


[![Codacy Badge](https://api.codacy.com/project/badge/Grade/7e9666795d6b4aa1a7838f7af599b720)](https://www.codacy.com/app/carter/VestaWebInterface?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=cdgco/VestaWebInterface&amp;utm_campaign=Badge_Grade)

## Requirements
* Server with root access and VestaCP installed.
* Web server with php and php-curl installed (Does not have to be powered by VestaCP)

(Tested on Ubuntu Server 14.04 & 16.04, VestaCP 0.9.8-17 & 0.9.8-18, PHP 5.4, 5.5, 5.6 & 7.0)

## Install

#### Method 1

1. Run the command `bash <(curl -s -L https://git.io/vbjO7)` while inside of the desired web directory on the VestaCP machine.
2. Visit the url of the web directory to complete configuration.
3. Chmod 'includes' folder to 755 (`chmod 755 includes`) after configuration is complete.

#### Method 2

1. Download and extract the latest release to a web server (Does not have to be running VestaCP).
2. Chmod 'includes' folder to 777 (`chmod 777 includes`).
3. Run the command `bash <(curl -s -L https://git.io/vbjOd)` on your vesta server to install the backend files.
4. Visit the url of the web directory to complete configuration.
5. Chmod 'includes' folder to 755 (`chmod 755 includes`) after configuration is complete.

Note: If you cannot chmod files, manually configure the includes/config-example.php file as in step 3 of method 3.


#### Method 3

1. Download and extract the latest release to a web server (Does not have to be running VestaCP).
2. Copy the contents of the 'install/web' folder in the release to the '/usr/local/vesta/web' directory of your vesta server.
3. Edit the 'includes/config-example.php' file and rename it to config.php.

## What method should I use?

* Method 1 is used to install VWI automatically if the frontend is on the same server as VestaCP.
* Method 2 is used to intsall the VWI frontend manually and the backend automatically if the frontend is not hosted by a VestaCP server. 
* Method 3 is used to install VWI manually in case of any errors or other circumstances with other installation methods.

## To-Do

#### Basic Functions:
- [ ] Addition FTP Support
- [ ] Multiple Additional FTP Support (Possible Backend Integration)
- [ ] Custom SSL Support (Needs Backend Integration)
- [ ] Process Backup Exclusions (Needs Backend Integration)
- [ ] Email Notifications (Possible Backend Integration)

#### Added Functionality / Bug Fixes / Code Cleanup:
- [ ] Add Delete Buttons to 'edit' Pages
- [ ] Process Loaders & Response Code Notifications
- [ ] Format, Unify, Minify and Fix Compiling Issues
- [ ] Fix PHP Errors

#### Long Term Plans:
- [ ] Better Download & PW Reset Systems
- [ ] Finish Dark Theme
- [ ] Create Theme Switcher
- [ ] Admin Panel
- [ ] Integrations
- [ ] Feature Additions
- [ ] Multi Server Support

## Support

For support regarding Vesta Web Interface, you can email me at support [at] cdgtech.one, visit the support portal online at http://support.cdgtech.one, or click the buttons in the bottom left and right hand corners of the live demo to chat or leave feedback.
