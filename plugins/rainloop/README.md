Installation Instructions:

1. Upload the rainloop folder to the plugins folder of VWI.
2. Edit the VWI config file (includes/config.php) and add "rainloop" to the plugins section below "Integrations".
3. Create a Cron Job to autoupdate the domain settings and new domains. This is done by querying the sync.php file with curl or php. For example, "*/5 * * * * curl https://VWI-INSTALLATION/plugins/rainloop/sync.php >> /dev/null 2>&1" or ""*/5 * * * * php https://VWI-INSTALLATION/plugins/rainloop/sync.php >> /dev/null 2>&1". Alternatively, you could manually visit the sync.php file every time you wish to update the domain list / configurations.
4. Login to the admin panel by visiting https://VWI-INSTALLATION/plugins/rainloop/?admin and login with username: "admin" and password: "12345" to finish configuration.