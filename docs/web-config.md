## Web Based Configuration

Web based config can be done either upon initial installation from the '/install' directory, or once installed from the 'Settings' section of the admin panel.

#### MySQL Configuration (config.php)

VWI requires a MySQL database to store and serve the control panel configuration.

You may use either a MySQL or MariaDB database and user with read and write access to the corresponding database. This database may either be empty or populated, as long as there is no table by the name of 'vwi\_config' (or a table with your specified prefix).

'root' users and users without passwords are accepted but are not recommended for added security. 

localhost / 127.0.0.1, web addresses and IP addresses are acceptable hosts. 

* MySQL Host: Address to MySQL Server. URL, IP Address or localhost.  
* MySQL Username: Username to MySQL user with access to database.  
* MySQL Password: Password to MySQL user.  
* Database Name: Database Name, accessable by specified user.  
* Table Prefix: Unused table prefix. 'vwi\_' by default. If a table called 'config' starting with the prefix exists, it will be dropped by the installer.  

#### Server Configuration 

* Server Timezone: Select the timezone in order for cron jobs and cached config to function.
* Site Name: Enter the name you would like to be displayed as the site title and CP name.
* Theme: Select the theme color for the control panel.
* Language: Default language for control panel.
* Default to Admin: Choose whether or not the admin should go to the admin panel by default after login.
* Email Address: Email to recieve alerts regarding installation status and security. 
* Vesta Host Address: URL or IP address of VestaCP without 'http://', ':8083', or the following slash. Ex: 'mydomain.com' or '8.8.8.8'.
* Vesta SSL: Leave checked if SSL is enabled for your VestaCP installation. Enabled by default. Leave checked if your VestaCP url (mydomain.com:8083) starts with 'https://'.
* Vesta Port: Port of your VestaCP installation. '8083' by default.
* Vesta Method: Whether to use an API Key or Username and Password for API Authentication.
* Vesta API Key: VestaCP generated API Key.
* Vesta Admin Username: Username of the VestaCP admin account. 'admin' by default.
* Vesta Admin Password: Password for VestaCP admin account.
* Key 1: Encryption Key. Replace with random string.
* Key 2: Encryption Key. Replace with random string.
* Warnings Enabled: Choose who should see warning messages about server connection and security issues.
* Icon: Control Panel Icon. Read [Branding section](branding) for more info.
* Logo: Control Panel Logo. Read [Branding section](branding) for more info.
* Favicon: Control Panel Favicon. Read [Branding section](branding) for more info.


#### Enable / Disable Sections

* Enable Web: If disabled, hides all web domains and control to web domain settings.
* Enable DNS: If disabled, hides all dns domains and control to dns domain settings.
* Enabled Mail: If disabled, hides all mail domains, control to mail domain settings and webmail access.
* Enable Database: If disabled, hides all databases, control to database settings and web based database access.
* Enable Admin: If disabled, hides admin panel, and all admin specific control. Disables web based settings (settings must be configured from MySQL).
* Enable Profile Page: If disabled, hides user profile and user settings page.
* Enable Cron: If disabled, hides all cron jobs and control to cron job settings.
* Enable Backups: If disabled, hides all backups and control to backup settings.
* Enable Registrations: If disabled, hides link to sign up. See [Registrations section](registrations) to learn how to configure.
* Enable Softaculous: If disabled, hides link to Softaculous.
* Enable Link to Old CP: If disabled, hides link to old VestaCP interface.

#### Mail Config (Settings Page Only)
* Enable PHPMail: Allows emailing credentials once database or email account are created.
* Mail From: From address for PHPMail messages.
* Mail Name: From name for PHPMail messages.
* SMTP Enabled: Choose whether to send email through PHP SendMail or SMTP.
* SMTP Port: Port for SMTP Connection. Usually 25 (unencrypted), 465 (SSL) or 587 (TLS).
* SMTP Host: SMTP server address. URL, IP or localhost.
* SMTP Auth: Choose whether to authenticate SMTP with a username and password.
* SMTP Username: Username to SMTP account if auth enabled.
* SMTP Password: Password to SMTP account if auth enabled.
* SMTP Encryption Method: SSL, TLS or None.

#### Optional Links

* FTP Client URL: Link to WebFTP client in menu. Leave blank for default or enter 'disabled' to disable.
* Webmail URL: Link to webmail client in menu. Leave blank for default or enter 'disabled' to disable.
* phpMyAdmin URL: Link to phpMyAdmin in menu. Leave blank for default or enter 'disabled' to disable.
* phpPgAdmin URL: Link to phpPgAdmin in menu. Leave blank for default or enter 'disabled' to disable.
* Support URL: Option link to web based support. Leave blank to disable.

#### Optional Integrations
* Plugins: Comma seperated list of installed plugins. Read the [plugins section](plugins) for more info.
* Google Analytics ID: Create and enter your Google Analytics ID to enable site statistics tracking. Read the [Google Analytics section](ga) for more info.
* Interakt App ID: Create and enter your Interakt App ID to enable customer support on your site. Read the [Interakt section](interakt) for more info.
* Interakt API key: Create and enter your Interakt API Key to enable user management and tracking on your site. Read the [Interakt section](interakt) for more info.
* Cloudflare API Key: Enter your Cloudflare Global API Key to enable Cloudflare DNS integration. Read the [Cloudflare section](cloudflare) for more info.
* Cloudflare Email: Enter your Cloudflare account email address to enable Cloudflare DNS integration. Read the [Cloudflare section](cloudflare) for more info.

After configuration you must chmod the 'includes' folder to 755 to prevent any unwanted alterations to your config.


[Video Tutorial](https://www.youtube.com/watch?v=Hw5eQKEOsYE&list=PL4JkcC_rCsyf9ha5OBrWqDS4xWC3hZgfz)