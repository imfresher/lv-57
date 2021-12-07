#!/bin/bash
sed -i -e 's/#ServerName www.example.com:80/ServerName localhost/g' /etc/httpd/conf/httpd.conf

sed -i -e 's/upload_max_filesize = 2M/upload_max_filesize = 3072M/g' /etc/php.ini
sed -i -e 's/post_max_size = 8M/post_max_size = 3072M/g' /etc/php.ini
sed -i -e 's/memory_limit = 128M/memory_limit = 2048M/g' /etc/php.ini

service httpd start
