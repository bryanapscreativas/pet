FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Obtener Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www

# Copiar permisos de usuario existente
COPY . /var/www

# Cambiar el propietario del directorio de trabajo
RUN chown -R www-data:www-data /var/www

# Establecer permisos
RUN chown -R www-data:www-data /var/www && \
    chmod -R 775 /var/www

# Cambiar al usuario no-root
USER www-data

# Exponer puerto 9000
EXPOSE 9000

# Iniciar php-fpm
CMD ["php-fpm"]
