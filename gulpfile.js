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
        '../../../public/libs/semantic-ui/js/semantic.min.js',
        '../../../public/libs/jquery.filtertable/js/jquery.filtertable.js',
        '../../../node_modules/magnific-popup/dist/jquery.magnific-popup.min.js',
        '../../../node_modules/dropzone/dist/min/dropzone.min.js',
        '../../../node_modules/angular/angular.min.js',
        '../../../node_modules/checklist-model/checklist-model.js',
        '../../../public/checklist-model/checklist-model.js',
        '../../../node_modules/underscore/underscore-min.js',
        'common.js'
    ])

    mix.combine([
        'resources/assets/js/controllers/blog.js',
        'resources/assets/js/controllers/polls.js'
    ], 'public/js/controllers.js');

});
