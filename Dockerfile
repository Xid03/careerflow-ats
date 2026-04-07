FROM node:22-bookworm-slim AS node

FROM php:8.3-cli-bookworm

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        curl \
        libzip-dev \
        libpq-dev \
        libsqlite3-dev \
    && docker-php-ext-install pdo_pgsql pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY --from=node /usr/local/bin/node /usr/local/bin/node
COPY --from=node /usr/local/lib/node_modules /usr/local/lib/node_modules
RUN ln -s /usr/local/lib/node_modules/npm/bin/npm-cli.js /usr/local/bin/npm \
    && ln -s /usr/local/lib/node_modules/npm/bin/npx-cli.js /usr/local/bin/npx

WORKDIR /var/www/html

COPY package.json package-lock.json ./
RUN npm ci

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction \
    && npm run build \
    && php artisan config:clear

EXPOSE 10000

CMD ["sh", "-c", "php artisan migrate --force && php -S 0.0.0.0:${PORT:-10000} -t public"]
