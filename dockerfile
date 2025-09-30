# Imagem base: PHP com Apache
FROM php:8.2-apache

# Instalar extensões necessárias
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Ativar mod_rewrite do Apache
RUN a2enmod rewrite

# Configurar diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto para o container
COPY . /var/www/html/

# Expor a porta 80
EXPOSE 80
