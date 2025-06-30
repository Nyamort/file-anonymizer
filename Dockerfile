FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y git unzip && rm -rf /var/lib/apt/lists/*

# Set workdir
WORKDIR /app

# Copy composer and install dependencies
COPY composer.json composer.lock* ./
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php \
    && composer install --no-interaction --no-scripts --no-autoloader

# Copy the rest of the app
COPY . .
RUN composer dump-autoload --optimize

# Default command
ENTRYPOINT ["php", "src/anonymizer.php"]
CMD ["config.yaml", "output/"]
