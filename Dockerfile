# Use a imagem oficial do PHP com Apache na versão 8.2
FROM php:8.2-apache

# Instale dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Instale extensões PHP necessárias
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instale o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Copie os arquivos do projeto
COPY . .

# Configure o Apache
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

# Rode o Composer para instalar as dependências
RUN composer install --no-scripts

# Exponha a porta 80 para o Apache
EXPOSE 80

# Inicie o Apache
CMD ["apache2-foreground"]
