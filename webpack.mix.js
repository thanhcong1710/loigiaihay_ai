const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [])
    .copyDirectory('resources/images', 'public/images')
    .copyDirectory('resources/themes/slick/js', 'public/themes/slick/js')
    .copyDirectory('resources/themes/slick/img', 'public/themes/slick/img')
    .copyDirectory('resources/themes/slick/fonts', 'public/themes/slick/fonts')
    .copyDirectory('resources/themes/slick/css', 'public/themes/slick/css');
