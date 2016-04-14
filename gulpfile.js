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

    mix
        .copy(
            'node_modules/magnific-popup/dist/jquery.magnific-popup.min.js',
            'public/libs/magnific-popup/js/jquery.magnific-popup.min.js'
        )
        .copy(
            'node_modules/dropzone/dist/min/dropzone.min.js',
            'public/libs/dropzone/js/dropzone.min.js'
        )
        .copy(
            'node_modules/angular/angular.min.js',
            'public/libs/angular/js/angular.min.js'
        )
        .copy(
            'node_modules/underscore/underscore-min.js',
            'public/libs/underscore/js/underscore.min.js'
        )
        .copy(
            'node_modules/fullcalendar/dist/fullcalendar.min.css',
            'public/libs/fullcalendar/css/fullcalendar.min.css'
        )
        .copy(
            'node_modules/fullcalendar/dist/fullcalendar.min.js',
            'public/libs/fullcalendar/js/fullcalendar.min.js'
        )
        .copy(
            'node_modules/fullcalendar/node_modules/moment/min/moment.min.js',
            'public/libs/moment/js/moment.min.js'
        )
        .copy(
            'node_modules/fullcalendar/node_modules/moment/locale/ru.js',
            'public/libs/moment/js/ru.js'
        );

    mix.scripts([
        'jquery/js/jquery.min.js',
        'semantic-ui/js/semantic.min.js',
        'magnific-popup/js/jquery.magnific-popup.min.js',
        'public/libs/dropzone/js/dropzone.min.js',
        'angular/js/angular.min.js',
        'underscore/js/underscore.min.js',
        'public/libs/moment/js/moment.min.js',
        'public/libs/moment/js/ru.js',
        '../../resources/assets/js/common.js'
    ], 'public/js', 'public/libs');

    mix.combine([
        'resources/assets/js/controllers/blog.js',
        'resources/assets/js/controllers/polls.js'
    ], 'public/js/controllers.js');

});
