# Use the official PHP image as a base image
FROM php:7.2-apache

# Install the mysqli extension
RUN docker-php-ext-install mysqli

# Enable the mysqli extension
RUN docker-php-ext-enable mysqli

# Copy the current directory contents into the container at /var/www/html
COPY ./src /var/www/html
