#!/bin/bash

if [ "x$(id -u)" != 'x0' ]; then
    echo 'Error: this script can only be executed by root'
    exit 1
fi

function InstallVestaWebInterface()
{
	echo "Installing Vesta Web Interface Backend ..."
	
	wget https://raw.githubusercontent.com/cdgco/VestaWebInterface/master/install/web.tar.gz
	
        tar xf web.tar.gz --overwrite -C /usr/local/vesta/web 
	
	fi

	echo "Done!";
***REMOVED***
InstallVestaWebInterface
