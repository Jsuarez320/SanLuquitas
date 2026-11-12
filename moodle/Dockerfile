FROM php:8.3-fpm

# Instalador de extensiones PHP (resuelve dependencias del sistema automáticamente)
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Extensiones que exige/recomienda Moodle
RUN install-php-extensions mysqli intl zip gd soap opcache exif

# Configuración propia
COPY php/moodle.ini /usr/local/etc/php/conf.d/moodle.ini
COPY php/zz-env.conf /usr/local/etc/php-fpm.d/zz-env.conf

# Carpeta de datos de Moodle, propiedad del usuario que ejecuta PHP
RUN mkdir -p /var/moodledata && chown www-data:www-data /var/moodledata
