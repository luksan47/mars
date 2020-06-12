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

mix.js('resources/js/cookieconsent-initialize.js', 'public/js/')
   .js('resources/js/materialize_custom.js', 'public/js/materialize.js')
   .js('resources/js/register_helper.js', 'public/js/')
   .js('resources/js/site.js', 'public/js/')
   .js('resources/js/csrf.js', 'public/js/')
   // We have to copy already minimized JS
   .copy('resources/js/cookieconsent.min.js', 'public/js/')
   .copy('resources/js/moment.min.js', 'public/js/')
   .copy('resources/js/popper.min.js', 'public/js/')
   .copy('node_modules/jquery/dist/jquery.min.js', 'public/js/')
   .copy('resources/js/tabulator.min.js', 'public/js/')
   .sass('resources/sass/materialize.scss', 'public/css/')
   // Add common styles here
   .styles([
      'resources/css/tabulator_materialize.min.css',
      'resources/css/cookieconsent.min.css'
   ], 'public/css/app.css')
   // Add site specific files one by one
   .styles('resources/css/welcome_page.css', 'public/css/welcome_page.css');

if (mix.inProduction()) {
   mix.version();
}