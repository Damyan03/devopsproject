FROM php:apache

RUN apt-get update \
    && apt-get install -y libzip-dev \
    && docker-php-ext-install zip

#ENV APACHE_DOCUMENT_ROOT /var/www/html/public
#
#RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
#RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

#RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
#RUN a2enmod rewrite
#RUN service apache2 restart

RUN docker-php-ext-install pdo pdo_mysql sockets
RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD composer install && php artisan migrate --force && php artisan db:seed && apache2-foreground && chown www-data:www-data /var/www/html/storage -R &&  php artisan storage:link
