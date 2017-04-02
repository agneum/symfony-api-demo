FROM ubuntu:16.04

MAINTAINER Artem Kartasov

RUN apt-get update \
    && apt-get install -y nginx \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && echo "daemon off;" >> /etc/nginx/nginx.conf

ADD default /etc/nginx/sites-available/default

RUN usermod -u 1000 www-data

EXPOSE 80

CMD ["nginx"]