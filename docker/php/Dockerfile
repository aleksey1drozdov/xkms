FROM php:fpm
#PHP
RUN apt-get update && apt-get install -y \
                        git \
                        libsodium-dev \
                        libzip-dev \
                        supervisor
RUN  docker-php-ext-install opcache \
    bcmath \
    opcache \
    pcntl \
    sockets \
    pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && ln -s $(composer config --global home) /root/composer

RUN unlink /etc/localtime \
    && ln -s /usr/share/zoneinfo/Europe/Moscow /etc/localtime
WORKDIR /src

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]


