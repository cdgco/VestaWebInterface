--
-- Table structure for table `vwi_config`
--

CREATE TABLE `vwi_config` (
  `VARIABLE` varchar(64) NOT NULL,
  `VALUE` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `vwi_config` (`VARIABLE`, `VALUE`) VALUES
('TIMEZONE', 'America/Los_Angeles'),
('SITE_NAME', ''),
('THEME', 'default'),
('LANGUAGE', 'en_US.utf8'),
('DEFAULT_TO_ADMIN', 'true'),
('VESTA_HOST_ADDRESS', ''),
('VESTA_SSL_ENABLED', 'true'),
('VESTA_PORT', '8083'),
('VESTA_METHOD', 'credentials'),
('VESTA_API_KEY', ''),
('VESTA_ADMIN_UNAME', 'admin'),
('VESTA_ADMIN_PW', ''),
('KEY1', 'INSERT-KEY-HERE'),
('KEY2', 'INSERT-KEY-HERE'),
('WARNINGS_ENABLED', 'admin'),
('ICON', 'admin-logo.png'),
('LOGO', 'admin-text.png'),
('FAVICON', 'favicon.ico'),
('WEB_ENABLED', 'true'),
('DNS_ENABLED', 'true'),
('MAIL_ENABLED', 'true'),
('DB_ENABLED', 'true'),
('ADMIN_ENABLED', 'true'),
('PROFILE_ENABLED', 'true'),
('CRON_ENABLED', 'true'),
('BACKUPS_ENABLED', 'true'),
('REGISTRATIONS_ENABLED', 'false'),
('SOFTACULOUS_URL', 'false'),
('OLD_CP_LINK', 'false'),
('PHPMAIL_ENABLED', 'false'),
('MAIL_FROM', ''),
('MAIL_NAME', ''),
('SMTP_ENABLED', 'true'),
('SMTP_PORT', '587'),
('SMTP_HOST', ''),
('SMTP_AUTH', 'true'),
('SMTP_UNAME', ''),
('SMTP_PW', ''),
('SMTP_ENC', 'tls'),
('FTP_URL', 'disabled'),
('WEBMAIL_URL', 'disabled'),
('PHPMYADMIN_URL', ''),
('PHPPGADMIN_URL', ''),
('SUPPORT_URL', ''),
('PLUGINS', ''),
('GOOGLE_ANALYTICS_ID', ''),
('INTERAKT_APP_ID', ''),
('INTERAKT_API_KEY', ''),
('CLOUDFLARE_API_KEY', ''),
('CLOUDFLARE_EMAIL', '');

ALTER TABLE `vwi_config`
  ADD PRIMARY KEY (`VARIABLE`);
COMMIT;