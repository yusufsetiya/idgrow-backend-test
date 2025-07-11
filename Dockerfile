FROM php:8.2-fpm

# Install system packages
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Copy .env.example to .env 
RUN cp .env.example .env

# Install dependencies
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Laravel permission fix
RUN chown -R www-data:www-data /var/www \
 && chmod -R 755 /var/www/storage /var/www/bootstrap/cache

# Generate Laravel app key
RUN php artisan key:generate

# Expose port
EXPOSE 8000

# Start: migrate & run Laravel serve
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]
