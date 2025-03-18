# Utiliser une image PHP avec Apache
FROM php:8.2-apache

# Installer les extensions MySQL PDO
RUN docker-php-ext-install pdo pdo_mysql

# Activer le module mod_rewrite pour Apache
RUN a2enmod rewrite

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier tous les fichiers du projet dans le conteneur
COPY . .

# Exposer le port 80 pour le serveur Apache
EXPOSE 80

# Lancer Apache au démarrage du conteneur
CMD ["apache2-foreground"]
