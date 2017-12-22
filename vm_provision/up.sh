#! /usr/bin/env bash

echo -e "Starting sass --watch"
pkill sass
rm /vagrant/sass.log
sass --watch --poll /vagrant/resources/www/scss:/vagrant/www/css > /vagrant/sass.log 2>&1 &
