FROM php:8.1-cli

ARG USER_ID
ARG GROUP_ID

ENV USER_ID=$USER_ID
ENV GROUP_ID=$GROUP_ID

RUN apt-get -y update
RUN apt-get -y install git zip unzip

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN addgroup --gid ${GROUP_ID} phpers
RUN adduser --disabled-password --gecos '' --uid ${USER_ID} --gid ${GROUP_ID} phpers

RUN chown -R phpers:phpers /var/www/html

USER phpers

