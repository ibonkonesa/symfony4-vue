FROM centos:7
EXPOSE 9000
WORKDIR /var/www/web

RUN \
    yum -y update wget yum-utils&& \
	yum -y install deltarpm && \
	yum -y install epel-release && \
	rpm --import http://rpms.famillecollet.com/RPM-GPG-KEY-remi && \
    rpm -ivh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm && \
    curl https://packages.microsoft.com/config/rhel/7/prod.repo > /etc/yum.repos.d/mssql-release.repo

RUN yum-config-manager --enable extras && \
	yum-config-manager --enable epel && \
	yum-config-manager --enable remi && \
	yum-config-manager --disable remi-php55 && \
	yum-config-manager --disable remi-php56 && \
	yum-config-manager --disable remi-php70 && \
    yum-config-manager --disable remi-php71 && \
    yum-config-manager --enable  remi-php72 && \
	yum -y install \
           openldap-clients \
           php72-php-fpm \
           php72-php-json \
           php72-php-xml \
           php72-php-mysqli \
           php72-php-mbstring \
           php72-php-mysqlnd \
           php72-php-gd \
           php72-php-ldap \
           php72-php-mcrypt \
           php72-php-pecl-zip \
           php72-php-soap \
           php72-php-intl \
           php72-php


RUN ln -s /usr/bin/php72 /usr/bin/php

# for last version info : https://packages.microsoft.com/rhel/7/prod/

RUN ACCEPT_EULA=Y yum install -y msodbcsql17-17.2.0.1-1 mssql-tools-17.2.0.1-1 unixODBC-devel
RUN echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile && \
    echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc  && \
    source ~/.bashrc

RUN ACCEPT_EULA=Y yum -y install php72-php-pdo \
                    php72-php-sqlsrv

RUN yum reinstall -y ca-certificates
RUN yum clean all
RUN mkdir -p /var/log/php-fpm
RUN ln -s /opt/remi/php72/root/sbin/php-fpm /usr/sbin/php-fpm
RUN sed -i '/^listen =/c listen = 9000' /etc/opt/remi/php72/php-fpm.d/www.conf
RUN sed -i '/^listen.allowed_clients/c;listen.allowed_clients ='  /etc/opt/remi/php72/php-fpm.d/www.conf
RUN sed -i '/^php_admin_value\[error_log\]/c php_admin_value[error_log] = /var/log/php-fpm/www-error.log' /etc/opt/remi/php72/php-fpm.d/www.conf
RUN ln -sf /dev/stderr /var/log/php-fpm/error.log
CMD ["php-fpm", "-F"]






