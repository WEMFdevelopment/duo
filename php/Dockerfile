FROM php:7.4.13-fpm
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
	libicu-dev \
	libzip-dev \
        zip \
        msmtp \
    && docker-php-ext-configure calendar \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure mysqli \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd calendar intl zip mysqli

COPY msmtprc /etc/msmtprc
RUN chown root:msmtp /etc/msmtprc
RUN chmod 640 /etc/msmtprc
COPY php.ini "$PHP_INI_DIR/php.ini"
