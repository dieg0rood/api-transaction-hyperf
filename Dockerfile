FROM hyperf/hyperf:8.2-alpine-v3.18-swoole-v5.0.3

ARG timezone

ENV TIMEZONE=${timezone:-"America/Sao_Paulo"} \
    SCAN_CACHEABLE=(true)

RUN set -ex \
    && php --ri swoole \
    && cd /etc/php* \
    && { \
        echo "upload_max_filesize=128M"; \
        echo "post_max_size=128M"; \
        echo "memory_limit=1G"; \
        echo "date.timezone=${TIMEZONE}"; \
    } | tee conf.d/99_overrides.ini \
    && ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man


WORKDIR /var/www
COPY . /var/www

RUN composer install --no-dev -o && php bin/hyperf.php

EXPOSE 9501
