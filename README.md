![VWI Banner](https://raw.githubusercontent.com/cdgco/VestaWebInterface/master/VWI%20Banner.png)

Preview Available for CDG Host Users (https://host.cdgtech.one)

Live Preview: https://ide.cdgtech.one/dev

## Install

#### Method 1

1. Run the command `bash <(curl -s -L https://git.io/vbjO7)` while inside of the desired website directory on the machine with VestaCP installed.
2. Visit the url of the web directory (or follow step 3 of method 3) to complete configuration.
3. Chmod 'includes' folder to 755 (`chmod 755 includes`) after configuration is complete.

#### Method 2

1. Download and extract (or clone) the latest release to a web server (Does not have to be running VestaCP).
2. Run the command `bash <(curl -s -L https://git.io/vbjOd)` on your vesta server to install the backend files.
3. Visit the url of the web directory (or follow step 3 of method 3) to complete configuration.


#### Method 3

1. Download and extract (or clone) the latest release to a web server (Does not have to be running VestaCP).
2. Copy the contents of the 'install/web' folder in the release to the '/usr/local/vesta/web' directory of your vesta server.
3. Edit the 'includes/config-example.php' file and rename it to config.php.

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
