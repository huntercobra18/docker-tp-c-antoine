FROM php:8.2-cli AS base
WORKDIR /app
RUN apt-get update && apt-get install -y libmariadb-dev && docker-php-ext-install pdo_mysql && apt-get clean
RUN useradd -m -s /bin/bash appuser
COPY . /app
EXPOSE 9000

FROM base AS dev
USER root
RUN apt-get update && apt-get install -y msmtp && apt-get clean
RUN echo "sendmail_path = /usr/bin/msmtp -t" >> /usr/local/etc/php/conf.d/mailhog.ini
RUN echo "account default" > /etc/msmtprc \
    && echo "host mailhog" >> /etc/msmtprc \
    && echo "port 1025" >> /etc/msmtprc \
    && echo "auto_from on" >> /etc/msmtprc \
    && echo "from dev@example.com" >> /etc/msmtprc \
    && chmod 600 /etc/msmtprc \
    && chown appuser:appuser /etc/msmtprc
USER appuser
CMD ["php", "-S", "0.0.0.0:9000", "-t", "/app"]

FROM base AS prod
RUN echo "error_log = /app/logs/error.log" >> /usr/local/etc/php/conf.d/logging.ini
USER appuser
CMD ["php", "-S", "0.0.0.0:9000", "-t", "/app"]
