#イメージのベースを指定
FROM php:7.4-fpm
COPY php.ini /usr/local/etc/php/

#パッケージ管理ツールapt-getの更新と必要パッケージのインストール
RUN apt-get update \
  && apt-get install -y \
  zlib1g-dev mariadb-client \
  cron \
  vim \
  # for GD [png/jpeg対応]
  libzip-dev \
  libpng-dev \
  libjpeg62-turbo-dev \
  && docker-php-ext-configure gd --with-jpeg \
  && docker-php-ext-install -j$(nproc) gd \
  # mysql
  && docker-php-ext-install zip pdo_mysql \
  && apt-get -y install unzip

#Composer install
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER 1

ENV COMPOSER_HOME /composer

ENV PATH $PATH:/composer/vendor/bin

#npmのインストール
COPY --from=node:10.22 /usr/local/bin /usr/local/bin
COPY --from=node:10.22 /usr/local/lib /usr/local/lib

RUN curl -sL https://deb.nodesource.com/setup_11.x | bash -
RUN apt-get install -y nodejs
RUN npm install npm@latest -g

WORKDIR /var/www

RUN composer require jenssegers/agent
RUN composer global require "laravel/installer"