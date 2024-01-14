# docker build . -t my-php-app:1.0.0

FROM php:7.2-fpm

# Thêm include_path vào php.ini
RUN echo "include_path = '.:/usr/local/lib/php:/app/include'" > /usr/local/etc/php/php.ini

# Cài đặt các công cụ zip và unzip
RUN apt-get update \
    && apt-get install -y zip unzip \
    && rm -rf /var/lib/apt/lists/*

RUN mkdir /app
WORKDIR /app
ARG MY_WORKDIR /app

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer.json và composer.lock vào image
COPY composer.json /app

# Chạy composer install để cài đặt dependencies
#RUN cd /app
RUN composer install --ignore-platform-reqs --no-interaction --no-plugins --no-scripts --verbose
RUN mkdir -p include
# RUN composer show && cd /app/test
# RUN composer remove promphp/prometheus_client_php
# RUN mkdir -p src && ls
# RUN cd $MY_WORKDIR/test
# RUN cd $MY_WORKDIR
# RUN rm src && ls

COPY hello.php /app
COPY metrics.php /app
COPY included.php /app/include
RUN ls