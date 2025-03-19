# Utiliser une image PHP avec Apache
FROM php:8.2-apache

# Installer les extensions MySQL PDO et autres nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Installer les extensions supplémentaires
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    git \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && apt-get clean

RUN docker-php-ext-install bcmath

# Activer le module mod_rewrite pour Apache
RUN a2enmod rewrite

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier tous les fichiers du projet dans le conteneur
COPY . .

# Installer les dépendances avec Composer
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# Exposer le port 80 pour le serveur Apache
EXPOSE 80

# Lancer Apache au démarrage du conteneur
CMD ["apache2-foreground"]
