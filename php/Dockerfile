# php/Dockerfile
FROM php:fpm-alpine

# Installer des extensions PHP nécessaires à Doctrine
RUN apk add --no-cache $PHPIZE_DEPS \
    && apk add --no-cache git zip unzip \
    && docker-php-ext-install pdo pdo_mysql

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installer Node.js et npm
RUN apk add --no-cache nodejs npm

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installer les dépendances avec npm (inclure jQuery)
COPY ../www/package.json /var/www/html/
RUN npm install

# Copier le reste des fichiers de l'application
COPY . /var/www/html/


