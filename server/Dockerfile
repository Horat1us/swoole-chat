FROM phpswoole/swoole:4.4.16-php7.4

RUN \
  install-swoole-ext.sh async  4.4.16   && \
  install-swoole-ext.sh postgresql  4.4.16 && \
  docker-php-ext-enable swoole_async swoole_postgresql

COPY composer.json composer.lock /var/www/
RUN composer install --optimize-autoloader --no-scripts --no-suggest --no-dev --prefer-dist
COPY . /var/www/
EXPOSE 9501
