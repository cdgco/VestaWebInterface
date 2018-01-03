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
printf "Installing Vesta Web Interface Backend ..."
sleep .5
wget -qO- https://raw.githubusercontent.com/cdgco/VestaWebInterface/master/install/web.tar.gz | tar xvz -C /usr/local/vesta/web
printf "\n"
printf "Installation Complete!"
