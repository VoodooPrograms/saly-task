FROM webdevops/php-nginx:8.0-alpine

# Install Symfony CLI globally
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

WORKDIR /app