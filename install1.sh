#!/bin/bash

# Linux
wget=/usr/bin/wget
tar=/bin/tar

if [ "x$(id -u)" != 'x0' ]; then
    echo 'Error: this script can only be executed by root'
    exit 1
elif [ ! -x "$wget" ]; then
  echo "ERROR: No wget." >&2
  exit 1
elif [ ! -x "$tar" ]; then
  echo "ERROR: No tar." >&2
  exit 1
fi
printf "\n"
PKG_OK=$(dpkg-query -W --showformat='${Status}\n' git|grep "Found")
echo Checking for GIT: $PKG_OK
if [ "" == "$PKG_OK" ]; then
  echo "Git not found. Setting up Git."
  sudo apt-get --force-yes --yes install git
else
  printf "Git is already installed.\nMoving on ...\n"
fi
printf "Installing Vesta Web Interface frontend ..."
printf "\n"
git clone https://github.com/cdgco/VestaWebInterface .
printf "\n"
printf "Removing unnecessary files ..."
printf "\n"
rm install1.sh
rm install2.sh
rm README.md
rm 'VWI Banner.png'
printf "\n"
printf "CHMODing includes folder to 777 ..."
printf "\n"
chmod 777 includes
printf "Installing Vesta Web Interface backend ..."
printf "\n"
sleep .5
wget -qO- https://raw.githubusercontent.com/cdgco/VestaWebInterface/master/install/web.tar.gz | tar xz -C /usr/local/vesta/web
printf "\n"
printf "Installation Complete! Please visit your website online to finish configuration."
printf "\n"
