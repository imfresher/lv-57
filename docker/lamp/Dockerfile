FROM amazonlinux:2018.03

MAINTAINER KevinDuy <mr.kevinduy@gmail.com>

# Install packages
COPY docker/lamp/install.sh /install/install.sh

RUN chmod +x /install/*.sh

RUN /bin/bash /install/install.sh

WORKDIR /var/www/app

EXPOSE 80 443 9000
