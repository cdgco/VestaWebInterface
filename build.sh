#!/bin/bash
printf "Vesta Web Interface Release Builder\n\n"
printf "Enter the desired release version (WITHOUT LEADING 'V'): "
read VERSION

git checkout -b v$VERSION 

if [ -f includes/version.php ] ; then
    rm includes/version.php
fi

echo "<?php \$currentversion = 'v$VERSION'; \$ghv2 = 'QXV0aG9yaXphdGlvbjogdG9rZW4gNDgzODAzOWVhYmIwYjNhNTlkMzA1NGNiYzk2YjI4YTcyZDA1MTRmYw==';" > includes/version.php

if [ -f docs/README.md ] ; then
    rm docs/README.md
fi

echo "# Vesta Web Interface v$VERSION
<hr>

## About

Vesta Web Interface is a PHP Control Panel and Web Interface that integrates with the VestaCP API to provide a beautiful user friendly experience. VWI features the ability to rebrand the control panel, change the theme, install it wherever you want, restrict access to users, easily edit options and offers integrations to services such as Google Analytics, Cloudflare, Interakt and many more coming soon. 

## Features

- Seamless integration with VestaCP
- Dynamic design with mobile support
- Multiple themes including dark theme
- Integrations with Auth0, Cloudflare, Interakt, Net2FTP, Softaculous and Google Analytics
- Plugin system with webmail (Rainloop), FTP (MonstaFTP) and billing plugins
- Web based installation and configuration within admin panel

## Demo

Check out the [Demo](https://cdgtech.one/vwi/demo.php) to test out VWI before you download.

## Donate

If you like VWI, please consider [donating](http://paypal.me/CJREvents) to show your support and help me focus more time on it. I'm a full time student and have many other side jobs and projects, thanks for the support!

## License

GNU General Public License v3.0" > docs/README.md

sed -i "s#Vesta Web Interface.*>#Vesta Web Interface v$VERSION\n>#g" docs/_coverpage.md
sed -i "s#archive/.*.zip#archive/v$VERSION.zip#g" docs/manual-install.md
sed -i "s#archive/.*.zip#archive/v$VERSION.zip#g" docs/manual-upgrade.md
sed -i "s#archive/.*.zip#archive/v$VERSION.zip#g" docs/select-install.md
sed -i "s#archive/.*.zip#archive/v$VERSION.zip#g" docs/select-upgrade.md
sed -i "s#VestaWebInterface@.*/css/style.css#VestaWebInterface@$VERSION/css/style.css#g" install/vesta/web/download/backup/vwi.php
sed -i "s#VestaWebInterface@.*/plugins/images/favicon.png#VestaWebInterface@$VERSION/plugins/images/favicon.png#g" install/vesta/web/templates/r_1.php
sed -i "s#VestaWebInterface@.*/css/style.css#VestaWebInterface@$VERSION/css/style.css#g" install/vesta/web/templates/r_1.php
sed -i "s#VestaWebInterface@.*/css/colors/default.css#VestaWebInterface@$VERSION/css/colors/default.css#g" install/vesta/web/templates/r_1.php
sed -i "s#VestaWebInterface@.*/js/main.js#VestaWebInterface@$VERSION/js/main.js#g" install/vesta/web/templates/r_1.php
sed -i "s#VestaWebInterface@.*/plugins/images/favicon.png#VestaWebInterface@$VERSION/plugins/images/favicon.png#g" install/vesta/web/templates/r_2.php
sed -i "s#VestaWebInterface@.*/css/style.css#VestaWebInterface@$VERSION/css/style.css#g" install/vesta/web/templates/r_2.php
sed -i "s#VestaWebInterface@.*/css/colors/default.css#VestaWebInterface@$VERSION/css/colors/default.css#g" install/vesta/web/templates/r_2.php
sed -i "s#VestaWebInterface@.*/js/main.js#VestaWebInterface@$VERSION/js/main.js#g" install/vesta/web/templates/r_2.php
sed -i "s#VestaWebInterface@.*/plugins/images/favicon.png#VestaWebInterface@$VERSION/plugins/images/favicon.png#g" install/vesta/web/templates/r_3.php
sed -i "s#VestaWebInterface@.*/css/style.css#VestaWebInterface@$VERSION/css/style.css#g" install/vesta/web/templates/r_3.php
sed -i "s#VestaWebInterface@.*/css/colors/default.css#VestaWebInterface@$VERSION/css/colors/default.css#g" install/vesta/web/templates/r_3.php
sed -i "s#VestaWebInterface@.*/js/main.js#VestaWebInterface@$VERSION/js/main.js#g" install/vesta/web/templates/r_3.php
sed -i "s#VestaWebInterface@.*/css/colors/blue.css#VestaWebInterface@$VERSION/css/style.css\" rel=\"stylesheet\"><link href=\"https://cdn.jsdelivr.net/gh/cdgco/VestaWebInterface@$VERSION/css/colors/blue.css#g" .htaccess

printf "Enter the changelog in HTML (<br>) format: "
read CHANGELOG

sed -i "s/## Changelog.*###/## Changelog\n\n### v$VERSION\n$CHANGELOG\n\n###/g" docs/changelog.md

if [ -f install/vesta.tar.gz ] ; then
    rm install/vesta.tar.gz
fi

tar -cvzf install/vesta.tar.gz -C install vesta

git commit -a -m "v$VERSION"
git push origin v$VERSION
git checkout master

printf "Build complete. New branch on Github named v$VERSION.\n\n"
read -p "Press [Enter] key to close ..."
exit 1

fi
