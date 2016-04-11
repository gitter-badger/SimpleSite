var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less');

    mix.scripts([
        '../../../public/libs/jquery/js/jquery.min.js',
        '../../../public/libs/jquery.filtertable/js/jquery.filtertable.js',
        '../../../node_modules/magnific-popup/dist/jquery.magnific-popup.js',
        '../../../node_modules/dropzone/dist/dropzone.js',
        '../../../node_modules/angular/angular.min.js',
        '../../../node_modules/checklist-model/checklist-model.js',
        'jquery.filtertable.js',
        'common.js'
    ])
});
