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

echo "

 __   __      _         __      __   _      ___     _            __             
 \ \ / /__ __| |_ __ _  \ \    / /__| |__  |_ _|_ _| |_ ___ _ _ / _|__ _ __ ___ 
  \ V / -_|_-<  _/ _` |  \ \/\/ / -_) '_ \  | || ' \  _/ -_) '_|  _/ _` / _/ -_)
   \_/\___/__/\__\__,_|   \_/\_/\___|_.__/ |___|_||_\__\___|_| |_| \__,_\__\___|
   
   "
sleep .5
printf "Installing VWI Backend ..."
sleep .5
wget -qO- https://raw.githubusercontent.com/cdgco/VestaWebInterface/master/install/web.tar.gz | tar xvz -C /usr/local/vesta/web
printf "\n"
printf "Installation Complete!"
