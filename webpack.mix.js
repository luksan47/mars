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

mix.js('resources/js/materialize_custom.js', 'public/js/materialize.js') // We use our custom materialize JS
   .js('resources/js/cookieconsent-initialize.js', 'public/js/')
   .scripts(['resources/js/site.js'], 'public/js/site.js')
   // We have to copy already minimized JS
   .copy('resources/js/cookieconsent.min.js', 'public/js/') // TODO: see #223
   .copy([
      'node_modules/moment/min/moment.min.js',
      'node_modules/jquery/dist/jquery.min.js',
      'node_modules/tabulator-tables/dist/js/tabulator.min.js'
   ], 'public/js/')
   // Compile SASS
   .sass('resources/sass/materialize.scss', 'public/css/')
   // Add common styles here
   .styles([
      'resources/css/tabulator_materialize.min.css', // This might cause problems if it gets ouf of sync with the JS
      'resources/css/cookieconsent.min.css'
   ], 'public/css/app.css')
   // Add page specific files one by one
   .styles('resources/css/welcome_page.css', 'public/css/welcome_page.css')
   .js('resources/js/page_based/localizations.js', 'public/js/page_based/localizations.js');

if (mix.inProduction()) {
   mix.version(); // For cache bumping
}
