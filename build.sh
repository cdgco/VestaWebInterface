#!/bin/bash
printf "Vesta Web Interface Release Builder\n\n"
printf "Enter the desired release version: "
read VERSION

git checkout -b $VERSION 

if [ -f includes/version.php ] ; then
    rm includes/version.php
fi

echo "<?php \$currentversion = v'$VERSION';" > includes/version.php

sed -i "s#Vesta Web Interface.*>#Vesta Web Interface $VERSION\n>#g" docs/_coverpage.md
sed -i "s#archive/.*.zip#archive/$VERSION.zip#g" docs/manual-install.md
sed -i "s#archive/.*.zip#archive/$VERSION.zip#g" docs/manual-upgrade.md
sed -i "s#archive/.*.zip#archive/$VERSION.zip#g" docs/select-install.md
sed -i "s#archive/.*.zip#archive/$VERSION.zip#g" docs/select-upgrade.md

if [ -f docs/README.md ] ; then
    rm docs/README.md
fi


if [[ $VERSION = *"Beta"* ]]; then
  echo "# Vesta Web Interface $VERSION
<hr>

!> Beta Pre Release: Vesta Web Interface is still in beta and is available as a pre-release. Therefore there may still be missing features and bugs. If you encounter an error or have suggestions, please tell us either through GitHub Issues or the support section

## About

Vesta Web Interface is a PHP Control Panel and Web Interface that integrates with the VestaCP API to provide a beautiful user friendly experience. VWI features the ability to rebrand the control panel, change the theme, install it wherever you want, restrict access to users, easily edit options and offers integrations to services such as Google Analytics, Cloudflare, Interakt and many more coming soon. 

## Features

- Seamless integration with VestaCP
- Dynamic design with mobile support
- Multiple themes including dark theme
- Integrations with Cloudflare, Interakt and Google Analytics
- Plugin system with webmail and FTP plugins
- Web based installation and configuration within admin panel

## Demo

Check out the [Demo](https://cdgtech.one/vwi/demo.php) to test out VWI before you download.

## Donate

If you like VWI, please consider [donating](http://paypal.me/CJREvents) to show your support and help me focus more time on it.

## License

GNU General Public License v3.0" > docs/README.md
else
echo "# Vesta Web Interface $VERSION
<hr>

## About

Vesta Web Interface is a PHP Control Panel and Web Interface that integrates with the VestaCP API to provide a beautiful user friendly experience. VWI features the ability to rebrand the control panel, change the theme, install it wherever you want, restrict access to users, easily edit options and offers integrations to services such as Google Analytics, Cloudflare, Interakt and many more coming soon. 

## Features

- Seamless integration with VestaCP
- Dynamic design with mobile support
- Multiple themes including dark theme
- Integrations with Cloudflare, Interakt and Google Analytics
- Plugin system with webmail and FTP plugins
- Web based installation and configuration within admin panel

## Demo

Check out the [Demo](https://cdgtech.one/vwi/demo.php) to test out VWI before you download.

## Donate

If you like VWI, please consider [donating](http://paypal.me/CJREvents) to show your support and help me focus more time on it.

## License

GNU General Public License v3.0" > docs/README.md
fi

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

printf "Enter the changelog in string format: "
read CHANGELOG

sed -i "s/## Changelog.*###/## Changelog\n\n### $VERSION\n$CHANGELOG\n\n###/g" docs/changelog.md

if [ -f install/vesta.tar.gz ] ; then
    rm install/vesta.tar.gz
fi

tar -cvzf install/vesta.tar.gz -C install vesta

git commit -a -m "$VERSION"
git push origin $VERSION
git checkout master

printf "Build complete. New branch on Github named $VERSION.\n\n"
read -p "Press [Enter] key to close ..."
exit 1

fi
