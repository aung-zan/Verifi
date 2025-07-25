# Use Ubuntu as a base image
FROM ubuntu:latest

# Set label for the image
LABEL maintainer="Aung Min Zan"
LABEL version="1.0"
LABEL description="Apache 2.0, PHP-8.3, PostgreSQL and MySQL"

# Install apache and PHP
RUN apt-get update \
    && apt-get -y upgrade \
    && apt-get install -y --no-install-recommends bash vim curl apache2 ssl-cert ca-certificates php \
    php-cli php-mbstring php-xml php-bcmath php-curl php-intl php-tokenizer php-mysql php-pgsql unzip git \
    && rm -rf /var/lib/apt/lists/*

# Copy apache config file override to the default config file.
COPY ./docker/apache/default-ssl.conf /etc/apache2/sites-available/default-ssl.conf

# Enable mod_rewrite for Apache.
RUN a2enmod rewrite \
    # Enable ssl for Apache.
    && a2enmod ssl \
    # Enable ssl-conf.
    && a2ensite default-ssl.conf \
    # Disable default.conf.
    && a2dissite 000-default.conf

# Install Composer.
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN alias composer='php /usr/bin/composer'

# Set the work directory.
WORKDIR /var/www/html

# Expose the host's port:guest's port.
EXPOSE 443

# Start Apache2 in the foreground
CMD [ "apache2ctl", "-D", "FOREGROUND"]