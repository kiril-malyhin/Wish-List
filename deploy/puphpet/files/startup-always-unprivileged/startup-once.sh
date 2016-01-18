#!/usr/bin/env bash

# Run composer update php
cd /var/www/wishlist/backend/
composer install

# Build angular application
cd /var/www/wishlist/frontend
npm update
bower install
gulp build
## Run angular application
forever start /var/www/wishlist/frontend/local.js