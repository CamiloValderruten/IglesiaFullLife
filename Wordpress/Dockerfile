FROM wordpress:latest

RUN apt-get update -y && apt-get install pkg-config libssl-dev -y

RUN pecl install mongodb

RUN echo "extension=mongodb.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"`