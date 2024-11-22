FROM php:8.1-fpm-buster

ENV COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer

# 必要なパッケージをインストール
RUN apt-get update && \
    apt-get -y install --no-install-recommends \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    locales \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# ロケールの設定
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    locale-gen && \
    localedef -f UTF-8 -i en_US en_US.UTF-8

# PHP 拡張モジュールをインストール
RUN docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    bcmath && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd

# Node.js のインストール
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs


COPY ./php.ini /usr/local/etc/php/php.ini

WORKDIR /data
