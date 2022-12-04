#!/usr/bin/bash

codename=`cat /etc/os-release | grep UBUNTU_CODENAME | awk -F '=' '{print $2}'`

# if exists env MIRROR, use it
if [ -n "$MIRROR" ]; then
    sed -i "s#http://archive.ubuntu.com/ubuntu/#$MIRROR#g" /etc/apt/sources.list
    sed -i "s#http://security.ubuntu.com/ubuntu/#$MIRROR#g" /etc/apt/sources.list
    sed -i "s#http://archive.ubuntu.com/ubuntu/#$MIRROR#g" /etc/apt/sources.list.d/*.list
    sed -i "s#http://security.ubuntu.com/ubuntu/#$MIRROR#g" /etc/apt/sources.list.d/*.list
fi
