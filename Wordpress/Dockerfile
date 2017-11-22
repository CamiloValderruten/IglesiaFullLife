FROM php:7.0-apache

RUN apt-get update -y && apt-get install pkg-config libssl-dev unzip curl wget libpng-dev libjpeg-dev -y

RUN pecl install mongodb

RUN docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr; \
    	docker-php-ext-install gd mysqli opcache && docker-php-ext-enable gd mysqli mongodb opcache;

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY configurations.ini /usr/local/etc/php/conf.d/configurations.ini

WORKDIR /var/www/

RUN wget https://github.com/WordPress/WordPress/archive/4.9.zip \
    && unzip 4.9.zip \
    && mv WordPress-4.9/* html/

COPY theme.zip html/wp-content/themes/

RUN unzip /var/www/html/wp-content/themes/theme.zip -d /var/www/html/wp-content/themes/

RUN composer install -d /var/www/html/wp-content/themes/yootheme/

COPY page-* /var/www/html/wp-content/themes/yootheme/

COPY wp-config.php /var/www/html/

COPY htaccess /var/www/html/.htaccess

RUN chown -R www-data:www-data html;