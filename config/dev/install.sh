#!/bin/sh

# Description: Set up MySQL Community Release 8.16

# Get the repo RPM and install it.
cd /tmp
wget https://dev.mysql.com/get/mysql-apt-config_0.8.16-1_all.deb
sudo apt-get install ./mysql-apt-config_0.8.16-1_all.deb

# Install the server and start it
sudo apt-get install mysql-server
systemctl start mysqld

# Get the temporary password
temp_password=$(grep password /var/log/mysqld.log | awk '{print $NF}')

# Set up a batch file with the SQL commands
echo "ALTER USER 'root'@'localhost' IDENTIFIED BY '$1'; flush privileges;" > reset_pass.sql

# Log in to the server with the temporary password, and pass the SQL file to it.
mysql -u root --password="$temp_password" --connect-expired-password < reset_pass.sql


