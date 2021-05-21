/** 
*
* Vesta Web Interface
*
* Copyright (C) 2020 Carter Roeser <carter@cdgtech.one>
* https://cdgco.github.io/VestaWebInterface
*
* Vesta Web Interface is free software: you can redistribute it and/or modify
* it under the terms of version 3 of the GNU General Public License as published 
* by the Free Software Foundation.
*
* Vesta Web Interface is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
* 
* You should have received a copy of the GNU General Public License
* along with Vesta Web Interface.  If not, see
* <https://github.com/cdgco/VestaWebInterface/blob/master/LICENSE>.
*
*/

/*
* Table structure for table `vwi_servers`
*/

CREATE TABLE IF NOT EXISTS `vwi_servers` (
  `NAME` varchar(255) NOT NULL,
  `HOST_ADDRESS` varchar(1024) NOT NULL,
  `PORT` varchar(10) NOT NULL,
  `SSL_ENABLED` varchar(10) NOT NULL,
  `METHOD` varchar(15) NOT NULL,
  `API_KEY` varchar(1024) NOT NULL,
  `UNAME` varchar(1024) NOT NULL,
  `PASSWORD` varchar(1024) NOT NULL,
  `DEFAULT` varchar(5) NOT NULL DEFAULT 'false',
  PRIMARY KEY (`NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `vwi_servers` (`NAME`, `HOST_ADDRESS`, `PORT`, `SSL_ENABLED`, `METHOD`, `API_KEY`, `UNAME`, `PASSWORD`, `DEFAULT`) VALUES
('', '', '8083', 'true', 'credentials', '', 'admin', '', 'true');

/*
* Table structure for table `vwi_config`
*/

CREATE TABLE IF NOT EXISTS `vwi_config` (
  `VARIABLE` varchar(64) NOT NULL,
  `VALUE` varchar(1024) NOT NULL,
  PRIMARY KEY (`VARIABLE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `vwi_config` (`VARIABLE`, `VALUE`) VALUES
('TIMEZONE', 'America/Los_Angeles'),
('SITE_NAME', ''),
('THEME', 'default'),
('LANGUAGE', 'en_US.utf8'),
('DEFAULT_TO_ADMIN', 'true'),
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
('NOTIFICATIONS_ENABLED', 'true'),
('REGISTRATIONS_ENABLED', 'false'),
('SOFTACULOUS_URL', 'false'),
('OLD_CP_LINK', 'false'),
('VWI_BRANDING', 'true'),
('CUSTOM_FOOTER', 'false'),
('FOOTER', ''),
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
('CLOUDFLARE_EMAIL', ''),
('AUTH0_DOMAIN', ''),
('AUTH0_CLIENT_ID', ''),
('AUTH0_CLIENT_SECRET', ''),
('CUSTOM_THEME_PRIMARY', ''),
('CUSTOM_THEME_SECONDARY', ''),
('HEADER_AD', ''),
('FOOTER_AD', '')
('ADMIN_ADS', 'true'),
('EXT_SCRIPT', '');

/*
* Table structure for table `vwi_auth0-users`
*/

CREATE TABLE IF NOT EXISTS `vwi_auth0-users` (
  `VWI_USER` varchar(64) NOT NULL,
  `AUTH0_USER` varchar(1024) NOT NULL,
  PRIMARY KEY (`VWI_USER`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
