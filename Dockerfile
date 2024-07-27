FROM php:7.4-apache

# Atualizar pacotes e instalar dependências necessárias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libmariadb-dev-compat \
    libmariadb-dev \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

# Habilitar o módulo mod_rewrite do Apache
RUN a2enmod rewrite

# Clonar o repositório no diretório correto
RUN git clone https://github.com/DaviHirata/AgendaPHP.git /var/www/html

# Configurar o diretório de trabalho
WORKDIR /var/www/html

# Configurar o Apache para rodar na porta 8080
RUN sed -i 's/80/8080/g' /etc/apache2/ports.conf \
    && sed -i 's/80/8080/g' /etc/apache2/sites-available/000-default.conf

# Expor a porta 8080
EXPOSE 8080

# Iniciar o Apache no primeiro plano
CMD ["apache2-foreground"]
