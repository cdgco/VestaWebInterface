#!/bin/sh

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

if ! cd "/usr/local/vesta/web"; then
  echo "ERROR: can't access working directory (/usr/local/vesta/web)" >&2
  exit 1
fi

if ! wget "https://raw.githubusercontent.com/cdgco/VestaWebInterface/master/install/web.tar.gz"; then
  echo "ERROR: can't get archive" >&2
  exit 1
fi

# extract archive
if ! tar xf web.tar.gz -C /usr/local/vesta/web ; then
  echo "ERROR: Archive not found" >&2
  exit 1
fi
