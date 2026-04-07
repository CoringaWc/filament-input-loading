FROM php:8.1-cli-bookworm

ARG WWWUSER=1000
ARG WWWGROUP=1000

# Node.js 18 LTS — for Tailwind CSS compilation (compatible with Filament v2)
ARG NODE_VERSION=18.20.4

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        libicu-dev \
        libzip-dev \
        unzip \
        xz-utils \
        zip \
    && docker-php-ext-install -j"$(nproc)" \
        intl \
        pcntl \
        zip \
    && curl -fsSL "https://nodejs.org/dist/v${NODE_VERSION}/node-v${NODE_VERSION}-linux-x64.tar.xz" \
        -o /tmp/node.tar.xz \
    && tar -xJf /tmp/node.tar.xz -C /usr/local --strip-components=1 \
    && rm /tmp/node.tar.xz \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN groupadd -g "${WWWGROUP}" workbench \
    && useradd --no-log-init -u "${WWWUSER}" -g "${WWWGROUP}" -m workbench

USER workbench

RUN mkdir -p /tmp/composer/cache /tmp/.npm /tmp/.cache

WORKDIR /var/www/html

COPY --chmod=755 entrypoint.sh /usr/local/bin/plugin-workbench-entrypoint

ENTRYPOINT ["plugin-workbench-entrypoint"]
