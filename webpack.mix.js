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
mix.js('resources/assets/js/mix/newad.js', 'public/js').
mix.js('resources/assets/js/mix/results.js', 'public/js').
mix.js('resources/assets/js/mix/home.js', 'public/js').
sass('resources/assets/sass/common.scss', 'public/css').
sass('resources/assets/sass/index.scss', 'public/css').
sass('resources/assets/sass/newad.scss', 'public/css').
sass('resources/assets/sass/results.scss', 'public/css').
sass('resources/assets/sass/home.scss', 'public/css').
version().browserSync({
    proxy: 'flix:90',
    port: 99,
    notify: false
});