
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

if [ $OS == "Ubuntu" ] || [ $OS == "Debian" ]; then 
	if [ ! -z "$(ls -A ./)" ]; then
		printf "Error: Directory not empty.\nVWI must be installed in clean directory. Exiting ...\n"
		exit 1
	elif [ $(dpkg-query -W -f='${Status}' wget 2>/dev/null | grep -c "tar found") -eq 1 ]; then
		apt-get install wget;
	elif [ $(dpkg-query -W -f='${Status}' tar 2>/dev/null | grep -c "tar found") -eq 1 ]; then
		apt-get install tar;
	elif [ $(dpkg-query -W -f='${Status}' git 2>/dev/null | grep -c "git found") -eq 1 ]; then
		apt-get install git;
	fi
	
printf "Installing Vesta Web Interface backend ...\n"
	
sleep .5

	wget -q https://raw.githubusercontent.com/cdgco/VestaWebInterface/master/install/web.tar.gz
	if [ -f web.tar.gz ] ; then
		tar -xzf web.tar.gz -C /usr/local/vesta/web

		rm web.tar.gz
	fi
	printf "\nInstallation Complete! Please visit your website online to finish configuration.\n"

elif [ $OS == "CentOS Linux" ] || [ $OS == "RHEL" ]; then
	if [ ! -z "$(ls -A ./)" ]; then
		printf "Error: Directory not empty.\nVWI must be installed in clean directory. Exiting ...\n"
		exit 1
	elif [ ! yum list installed wget >/dev/null 2>&1 ]; then
		yum -y install wget
	elif [ ! yum list installed tar >/dev/null 2>&1 ]; then
		yum -y install tar
	elif [ ! yum list installed git >/dev/null 2>&1 ]; then
		yum -y install git
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
