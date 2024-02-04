FROM php:8.2-apache

# Installez les extensions PHP nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Copiez les fichiers de l'application dans le conteneur
COPY . /var/www/html

# Activez le module rewrite pour Apache
RUN a2enmod rewrite

# Redémarrez Apache pour appliquer les modifications
RUN service apache2 restart