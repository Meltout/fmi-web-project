# Use the official PHP image as the base image
FROM php:latest

# Set a working directory inside the container
WORKDIR /var/www/html/public

# Copy your PHP application files into the container
COPY . /var/www/html

# Expose port 80 (or any other port your PHP application uses)
EXPOSE 80

# Start the PHP built-in server when the container starts
CMD ["php", "-S", "0.0.0.0:80"]
