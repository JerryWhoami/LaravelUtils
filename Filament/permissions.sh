#!/bin/bash

echo "Run this in the project directory as root"
read -p "Continue [y/n]?" ans
echo $ans
if [ "$ans" != "y" ]; then
  exit
fi
sudo chown -R sysadmin:www-data .
sudo setfacl -Rdm u:www-data:rwx,u:sysadmin:rwx storage
sudo setfacl -Rm u:www-data:rwX,u:sysadmin:rwX storage
sudo setfacl -Rdm u:www-data:rwx,u:sysadmin:rwx bootstrap/cache
sudo setfacl -Rm u:www-data:rwX,u:sysadmin:rwX bootstrap/cache
