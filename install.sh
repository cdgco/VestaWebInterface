#!/bin/bash

if [ "x$(id -u)" != 'x0' ]; then
    echo 'Error: this script can only be executed by root'
    exit 1
fi

function InstallVestaCPFrontEnd()
{
	echo "Installing Vesta Web Interface Backend ..."
	wget https://raw.githubusercontent.com/cdgco/VestaWebInterface/master/install/web.tar.gz
  tar xf web.tar.gz -C /usr/local/vesta/web --overwrite
	fi

	echo "Done!";
***REMOVED***
