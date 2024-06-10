# Use an official PHP image as the base image
FROM composer/composer

# Set the working directory in the container
WORKDIR .

# Copy the local PHP package files to the container
COPY . .

# Command to run when the container starts
CMD ["composer", "test"]
