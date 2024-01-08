# Get base image
FROM centos:8

# Author
MAINTAINER "Zerobug Team"

#install nginx
RUN dnf install yum-utils -y

#install and enable EPEL on centos 8
RUN dnf -y install https://dl.fedoraproject.org/pub/epel/epel-release-latest-8.noarch.rpm
#RUN dnf install -y epel-release

#install remi repo php
RUN dnf -y install https://rpms.remirepo.net/enterprise/remi-release-8.rpm
RUN dnf -y update

#install php7.4
RUN dnf module reset php -y
RUN dnf -y module enable php:remi-7.4

#search php-redis5
#yum search php-pecl-redis5

# install php
RUN dnf install -y php-fpm php-cli php-common php-devel php-mbstring php-pdo php-gd php-xml php-mcrypt php-mysql php-zip wget unzip php-pecl-redis5

#install nginx
RUN dnf install nginx -y

#disable default config fpm
RUN mv /etc/php-fpm.d/www.conf  /etc/php-fpm.d/www.conf.bak

#copy config of php-fpm
ADD ./php-fpm/zerobug.conf /etc/php-fpm.d/zerobug.conf

#copy config of nginx
ADD ./nginx/php-fpm.conf /etc/nginx/conf.d/php-fpm.conf
ADD ./nginx/zerobug.conf /etc/nginx/conf.d/zerobug.conf

#enable nginx start when start container
#RUN systemctl start php-fpm
RUN systemctl enable php-fpm

#enable nginx start when start container
#RUN systemctl start nginx
RUN systemctl enable nginx

#install composer php
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#install open-ssh-clients
RUN dnf -y install openssh-clients -y

#install net-tools
RUN dnf -y install net-tools

#install expect for auto gen and copy rsa key
RUN dnf -y install expect

#install telnet tool
RUN dnf -y install telnet

#copy code tu thu muc code vao image
ADD ./code /usr/share/nginx/html

#set doc root
WORKDIR /usr/share/nginx/zerobug

ENTRYPOINT ["/sbin/init"]

EXPOSE 80 443