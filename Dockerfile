# Use the official PHP image as the base image
FROM php:latest

# Set a working directory inside the container
WORKDIR /var/www/html

# Install SQLite3, and necessary command line tools
RUN apt-get update && apt-get install -y \
    libsqlite3-dev sqlite3 \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_sqlite 

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
COPY composer.json ./
RUN composer install --no-dev --no-interaction --no-autoloader --no-scripts

# Copy your PHP application files into the container
COPY . ./

RUN composer dump-autoload --optimize

# Expose port 8000 for the php app
EXPOSE 8000

# Run the database initialization script
RUN sqlite3 mydatabase.sqlite < init.sql

RUN chmod +x ./setup.sh
CMD ./setup.sh
