# Imagen base de PHP con Apache en Debian Bullseye
FROM php:7.4.33-apache-bullseye

# Instalar dependencias del sistema
RUN apt update && apt install -y \
    zip \
    git \
    curl \
    gnupg \
    unixodbc \
    unixodbc-dev \
    nodejs \
    npm

# Configurar e instalar el soporte ODBC en PHP para SQL Server
RUN docker-php-ext-configure pdo_odbc --with-pdo-odbc=unixODBC,/usr \
    && docker-php-ext-install pdo_odbc

# Agregar el repositorio de Microsoft y el controlador ODBC para SQL Server
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add - && \
    curl https://packages.microsoft.com/config/debian/11/prod.list > /etc/apt/sources.list.d/mssql-release.list && \
    apt-get update && \
    ACCEPT_EULA=Y DEBIAN_FRONTEND=noninteractive apt-get install -y msodbcsql18 mssql-tools && \
    echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bash_profile && \
    echo 'export PATH="$PATH:/opt/mssql-tools/bin"' >> ~/.bashrc && \
    sed -i -E 's/(CipherString\s*=\s*DEFAULT@SECLEVEL=)2/\11/' /etc/ssl/openssl.cnf

# Configuración de Apache para permitir el acceso al directorio de trabajo
WORKDIR /var/www/html
RUN chmod -R 755 /var/www/html

RUN echo "<Directory \"/var/www/html\">\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>" > /etc/apache2/conf-available/custom-permissions.conf && \
    a2enconf custom-permissions && \
    a2enmod rewrite

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copiar los archivos del proyecto al contenedor
COPY . /var/www/html

# Instalar dependencias de Composer y npm
RUN composer install --no-interaction --no-dev --optimize-autoloader && \
    npm install && \
    npm run dev

# Exponer el puerto 80
EXPOSE 80

# Configurar Apache para ejecutarse en primer plano
ENTRYPOINT ["/usr/sbin/apache2ctl"]
CMD ["-D", "FOREGROUND"]
