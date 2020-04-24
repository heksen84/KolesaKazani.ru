#!/bin/bash
cd ..
php artisan vendor:publish --tag=laravel-notifications
php artisan vendor:publish --tag=laravel-mail