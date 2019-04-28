const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/employee-edit.js', 'public/js')
   .js('resources/js/indicators.js', 'public/js')

   .sass('resources/sass/app.scss', 'public/css');

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
});


if (mix.config.production) {
    mix.version();
    mix.disableNotifications();
} else {
    mix.browserSync('togas.lc');
}
