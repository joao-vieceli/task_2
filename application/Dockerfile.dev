FROM php:8.2-apache

WORKDIR /var/www/html

COPY . .

RUN apt-get update && apt-get install -y gpg
RUN curl -fsSL https://packages.sury.org/php/README.txt | bash -x

RUN apt-get update --allow-unauthenticated && apt-get install --allow-unauthenticated -y \
    libpq-dev \
    curl \
    unzip \
    nodejs \
    npm \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# RUN pecl install xdebug \
#     && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

CMD ["/var/www/html/afterbuild-dev.sh"]
