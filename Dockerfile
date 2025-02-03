FROM php:8.3-fpm-alpine3.21

RUN apk --update add wget \
  curl \
  git \
  grep \
  build-base \
  libmemcached-dev \
  libmcrypt-dev \
  libxml2-dev \
  imagemagick \
  imagemagick-dev \
  pcre-dev \
  libtool \
  make \
  autoconf \
  g++ \
  cyrus-sasl-dev \
  libgsasl-dev \
  supervisor

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN docker-php-ext-install mysqli pdo pdo_mysql xml
RUN git clone https://github.com/Imagick/imagick.git --depth 1 /tmp/imagick && \
    cd /tmp/imagick && \
    phpize && \
    ./configure && \
    make && \
    make install && \
    docker-php-ext-enable imagick && \
    apk del git gcc g++ make autoconf pkgconfig imagemagick-dev && \
    rm -rf /var/cache/apk/* /tmp/imagick

RUN apk add --no-cache \
    unzip \
    $PHPIZE_DEPS \
    && pecl channel-update pecl.php.net \
    && pecl install memcached \
    # && pecl install imagick \
    && docker-php-ext-enable memcached
    # && docker-php-ext-enable imagick

# I recommend being explicit with node version here...
# but we'll see if livewire complains
RUN apk add nodejs --update-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/main --allow-untrusted \ 
    && apk add --update 

RUN rm /var/cache/apk/* && \
    mkdir -p /var/www

COPY ./dev/docker-compose/php/supervisord-app.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]