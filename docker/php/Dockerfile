FROM php:8.2-fpm-alpine

# Instalar dependências do sistema
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    unzip \
    libzip-dev \
    oniguruma-dev \
    mysql-client

# Instalar extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_mysql mysqli zip mbstring exif pcntl bcmath opcache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Criar usuário para aplicação
RUN addgroup -g 1000 -S www \
    && adduser -u 1000 -S www -G www

# Definir diretório de trabalho
WORKDIR /var/www/backend

# Copiar arquivos de configuração do PHP
COPY php.ini /usr/local/etc/php/php.ini

# Alterar proprietário dos arquivos
RUN chown -R www:www /var/www/backend

# Mudar para usuário www
USER www

# Expor porta 9000
EXPOSE 9000

CMD ["php-fpm"]
