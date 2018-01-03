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
PKG_OK=$(dpkg-query -W --showformat='${Status}\n' git|grep "install ok installed")
echo Checking for GIT: $PKG_OK
if [ "" == "$PKG_OK" ]; then
  echo "Git not found. Setting up Git."
  sudo apt-get --force-yes --yes install git
else
  printf "Git is already installed.\nMoving on ...\n"
fi
printf "\n"
printf "Installing Vesta Web Interface Backend ..."
printf "\n"
git clone https://github.com/cdgco/VestaWebInterface .
rm install1.sh
rm install2.sh
rm README.md
rm 'VWI Banner.png'
chmod 777 includes
printf '\n'
sleep .5
wget -qO- https://raw.githubusercontent.com/cdgco/VestaWebInterface/master/install/web.tar.gz | tar xz -C /usr/local/vesta/web
printf "\n"
printf "Backend Installation Complete! Please visit your website online to finish configuration."
printf "\n"
