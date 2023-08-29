FROM php:8.1-fpm

RUN apt-get update \
&& docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www

# Install PHP extensions required by Laravel
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the Laravel application files into the container
COPY . .


# Expose the port used by your Laravel application (e.g., 8000)
EXPOSE 8000

# Set the command to start the PHP built-in server
CMD php artisan serve --host=0.0.0.0 --port=8000