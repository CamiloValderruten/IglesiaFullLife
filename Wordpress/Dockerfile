FROM wordpress:latest

RUN apt-get update -y && apt-get install pkg-config libssl-dev -y

RUN pecl install mongodb

RUN apt-get install unzip

COPY configurations.ini /usr/local/etc/php/conf.d/configurations.ini