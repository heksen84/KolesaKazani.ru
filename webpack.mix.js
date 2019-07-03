let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/mix/index.js', 'public/js').
mix.js('resources/assets/js/mix/login.js', 'public/js').
mix.js('resources/assets/js/mix/register.js', 'public/js').
mix.js('resources/assets/js/mix/passwordreset.js', 'public/js').
mix.js('resources/assets/js/mix/sendemail.js', 'public/js').
mix.js('resources/assets/js/mix/create.js', 'public/js').
mix.js('resources/assets/js/mix/app.js', 'public/js').
sass('resources/assets/sass/app.scss', 'public/css').version();