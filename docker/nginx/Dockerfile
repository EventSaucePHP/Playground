FROM nginx:1.21-alpine

ADD --chown=101:101 ./public/ /var/www/symfony/public
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/nginx.site.conf /etc/nginx/conf.d/default.conf
