FROM php:8.2-apache

# Install ekstensi mysqli untuk koneksi ke MySQL
RUN docker-php-ext-install mysqli

# Aktifkan mod_rewrite (jika pakai .htaccess)
RUN a2enmod rewrite

# Salin semua file project ke folder public Apache
COPY . /var/www/html/

# Ubah hak akses (opsional)
RUN chown -R www-data:www-data /var/www/html

# Set ServerName agar tidak muncul warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose port untuk Railway
EXPOSE 80
