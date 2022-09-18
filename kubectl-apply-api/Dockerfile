# syntax=docker/dockerfile:1

ARG KUBECTL_VERSION=1.25.1
ARG PHP_VERSION=8.1
ARG COMPOSER_VERSION=2.4

FROM php:8.1-apache-buster AS production

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

RUN <<EOT
apt-get update
apt-get install -y --no-install-recommends curl unzip
apt-get clean
rm -rf /var/lib/apt/lists/*
apt-get remove gcc g++ make -y
apt-get autoremove -y
EOT

RUN curl -LO "https://dl.k8s.io/release/v1.25.1/bin/linux/amd64/kubectl" && \
    chmod +x kubectl && \
    mv ./kubectl /usr/local/bin/kubectl

RUN a2enmod rewrite

COPY .docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY .docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY composer.json composer.lock symfony.lock /var/www/html/

RUN composer install --no-dev --no-scripts --no-progress --no-autoloader

WORKDIR /var/www/html/

COPY bin bin/
COPY config config/
COPY public public/
COPY src src/

EXPOSE 80

FROM production AS development

RUN composer install --no-scripts --no-progress
