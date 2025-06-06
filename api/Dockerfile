# api/Dockerfile
FROM bitnami/laravel:latest

WORKDIR /app

# Install nano
USER root
RUN apt-get update && apt-get install -y nano && apt-get clean

COPY . .

RUN composer install --no-dev --optimize-autoloader \
  && php artisan config:cache \
  && php artisan route:cache \
  && php artisan view:cache
