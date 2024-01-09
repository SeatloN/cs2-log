# Use an official PHP image as the base image
FROM php:latest

# Set the working directory in the container
WORKDIR /var/www/html

# Install any additional dependencies your package might need
RUN apt-get update && \
    apt-get install -y \
        # Add your dependencies here, e.g., git, composer
        git \
    && rm -rf /var/lib/apt/lists/*

# Copy the local PHP package files to the container
COPY . .

# Install Composer and project dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

# Expose a port if your package requires a web server (e.g., for testing)
EXPOSE 8000

# Command to run when the container starts
CMD ["php", "-S", "0.0.0.0:8000"]
