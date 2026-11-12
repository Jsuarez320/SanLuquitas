FROM php:8.3-fpm

ARG UID=1000
ARG GID=1000

# Extensiones PHP para Laravel + PostgreSQL
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN install-php-extensions pdo_pgsql pgsql intl zip gd opcache bcmath pcntl

# Composer (gestor de dependencias de PHP)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# www-data con el mismo UID/GID del usuario del servidor
RUN groupmod -o -g ${GID} www-data && usermod -o -u ${UID} -g ${GID} www-data

ENV COMPOSER_HOME=/tmp/composer
WORKDIR /var/www/html
