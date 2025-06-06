# api/Dockerfile
FROM bitnami/laravel:latest

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader \
  && php artisan config:cache \
  && php artisan route:cache \
  && php artisan view:cache
