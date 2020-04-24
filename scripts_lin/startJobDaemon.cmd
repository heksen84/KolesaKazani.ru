#!/bin/bash
cd ..
php artisan queue:work --daemon
