FROM banian/php

# https://github.com/banianhost/images/blob/master/php/Dockerfile.onbuild

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_NO_INTERACTION=1

COPY composer.* /var/www/src/

RUN cd /var/www/src && \
            composer install \ 
                --prefer-dist \
                --ignore-platform-reqs \
                --no-scripts \
                --no-autoloader \
                --no-progress \
                --no-suggest \
                --no-dev \
                --profile \
                --no-ansi

COPY . /var/www/src

RUN cd /var/www/src && \
            composer dump-autoload \
                     --no-ansi \
                     --optimize \
                     --no-dev 