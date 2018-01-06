#!/bin/bash

if [ "x$(id -u)" != 'x0' ]; then
	echo 'Error: this script can only be executed by root'
	exit 1
elif [ -f /etc/os-release ]; then
    . /etc/os-release
    OS=$NAME
elif type lsb_release >/dev/null 2>&1; then
    OS=$(lsb_release -si)
elif [ -f /etc/lsb-release ]; then
    . /etc/lsb-release
    OS=$DISTRIB_ID
elif [ -f /etc/debian_version ]; then
    OS=Debian
elif [ -f /etc/redhat-release ]; then
    OS=RHEL
else
    OS=$(uname -s)
fi

if [ "$OS" == "Ubuntu" ] || [ "$OS" == "Debian" ]; then 
	printf "Checking for required packages ...\n"
	if [ $(dpkg-query -W -f='${Status***REMOVED***' wget 2>/dev/null | grep -c "wget found") -eq 1 ]; then
		echo "wget not found. Instaling ..."
                apt-get install wget
	elif [ $(dpkg-query -W -f='${Status***REMOVED***' tar 2>/dev/null | grep -c "tar found") -eq 1 ]; then
		echo "tar not found. Installing ..."
		apt-get install tar
	fi
	printf "Installing Vesta Web Interface backend ...\n"
	sleep .5
	wget -q https://raw.githubusercontent.com/cdgco/VestaWebInterface/master/install/web.tar.gz
	if [ -f web.tar.gz ] ; then
		tar -xzf web.tar.gz -C /usr/local/vesta/web
		rm web.tar.gz
	fi
	printf "\nInstallation Complete! Please visit your website online to finish configuration.\n"
elif [ "$OS" == "CentOS Linux" ] || [ "$OS" == "RHEL" ]; then
	printf "Checking for required packages ...\n"
        if rpm -q wget > /dev/null
	then
		echo "wget found"
	else
		echo "wget not found. Installing ..."
		yum -y install wget
	fi
	if rpm -q tar > /dev/null
	then
		echo "tar found"
	else
		echo "tar not found. Installing ..."
		yum -y install tar
	fi	
	printf "Installing Vesta Web Interface backend ...\n"	
	sleep .5
	wget -q https://raw.githubusercontent.com/cdgco/VestaWebInterface/master/install/web.tar.gz
	if [ -f web.tar.gz ] ; then
		tar -xzf web.tar.gz -C /usr/local/vesta/web
		rm web.tar.gz
	fi
	printf "\nInstallation Complete! Please visit your website online to finish configuration.\n"
else
	echo 'Error: VWI can only be installed on Debian, Ubuntu, CentOS, or RHEL. Exiting ...'
	exit 1
fi
