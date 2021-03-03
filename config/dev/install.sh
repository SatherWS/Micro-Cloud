#!/bin/sh

# Script Description: Install necessary software for a LAMP stack
# Install apache2, php, php mysqli
sudo apt-get install php php-mysqli
sudo apt-get install apache2
sudo systemctl apache2 start

# Get the repo RPM and install MYSQL version 8.
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

