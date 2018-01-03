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
printf "Installing Vesta Web Interface Backend ..."
printf "\n"
sleep .5
wget -qO- https://raw.githubusercontent.com/cdgco/VestaWebInterface/master/install/web.tar.gz | tar xz -C /usr/local/vesta/web
printf "\n"
printf "Backend Installation Complete! Please visit your website online to finish configuration."
printf "\n"
