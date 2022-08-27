FROM php:8.0-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
        zip \
        unzip \
        git \
        libpq-dev \
        libfreetype6-dev \
        libpng-dev \
        libjpeg-dev \
        libwebp-dev \
    && docker-php-ext-configure gd \
        --with-jpeg=/usr/include/ \
        --with-freetype=/usr/include/ \
        --with-webp=/usr/include/ \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        gd \
        -j$(nproc) \
    && apt-get clean && rm -rf /var/lib/apt/lists/*




# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

USER $user
