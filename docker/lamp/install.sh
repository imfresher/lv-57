#!/bin/bash

# Set timezone to Japan
sed -i -e "s/ZONE=\"UTC\"/ZONE=\"Japan\"/g" /etc/sysconfig/clock
ln -sf /usr/share/zoneinfo/Japan /etc/localtime

# Update and install packages
yum update -y && yum install -y \
sudo \
git \
wget \
nano \
vim \
telnet \
htop \
&& yum clean all

# Install nodejs
curl -sL https://rpm.nodesource.com/setup_12.x | sudo -E bash -
yum install -y nodejs
npm install yarn -g

# Pre install
yum remove -y httpd
yum remove -y httpd-tools

# Update and install packages
yum update -y && yum install -y \
httpd24 \
php73 \
php73-pdo \
php73-mbstring \
php73-xml \
php73-json \
php73-bcmath \
php73-mysqlnd \
&& yum clean all

# Install composer
cd ~
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
ln -s /usr/local/bin/composer /usr/bin/composer
