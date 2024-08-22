# Use a imagem oficial do PHP 8.2 com Apache
FROM php:8.2-apache

# Instala extensões necessárias do PHP
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Habilita o mod_rewrite do Apache
RUN a2enmod rewrite

# Define o diretório de trabalho
WORKDIR /var/www/html

# Copia o arquivo de configuração do Apache
COPY ./apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Instala dependências do Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia o projeto para o container
COPY . /var/www/html

# Executa o Composer para instalar as dependências do Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Ajusta as permissões para permitir acesso a todos
RUN chmod -R 777 .

# Expõe a porta 80
EXPOSE 80

# Comando para iniciar o Apache
CMD ["apache2-foreground"]