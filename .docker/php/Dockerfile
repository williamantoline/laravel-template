FROM ubuntu:22.04 as main

WORKDIR /var/www/html

ENV PHP_VERSION=8.2
ARG DEBIAN_FRONTEND=noninteractive


RUN apt-get update && \
    apt-get install -y software-properties-common

RUN add-apt-repository ppa:ondrej/php

RUN apt-get install -y \
    curl \
    vim \
    git \
    unzip \
    htop

RUN apt-get install -y \
    php${PHP_VERSION} \
    php${PHP_VERSION}-fpm \
    php${PHP_VERSION}-pgsql \
    php${PHP_VERSION}-curl \
    php${PHP_VERSION}-xml \
    php${PHP_VERSION}-redis \
    php${PHP_VERSION}-mbstring

RUN mkdir /run/php

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN sed -i 's/^listen = .*/listen = 0.0.0.0:9000/' /etc/php/8.2/fpm/pool.d/www.conf

CMD ["php-fpm8.2", "-F"]

EXPOSE 9000
