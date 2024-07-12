FROM php:8.2-fpm
RUN apt-get update && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

# Set the working directory
COPY . /var/www/app/
WORKDIR /var/www/app/

# Modify access
RUN chmod -R 777 /var/www/app/

# Copy configs
COPY ./nginx/default.conf /etc/nginx/conf.d/
COPY ./php-ini/ /etc/php/conf.d/
COPY ./php-ini/ /usr/local/etc/php/

# PHP extensions
ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# install composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# copy composer.json to workdir & install dependencies
COPY composer.json ./
COPY composer.lock ./
#RUN composer install


# Set the default command to run php-fpm
CMD ["php-fpm"]