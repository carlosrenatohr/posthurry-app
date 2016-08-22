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
    mix.sass(['app.scss', 'responsive.scss']);
    mix.styles([
       //'reset.css',
       'style.css',
       './node_modules/select2/dist/css/select2.css',
       './node_modules/select2-bootstrap-css/select2-bootstrap.css',
       './node_modules/font-awesome/css/font-awesome.min.css',
        './node_modules/datetimepicker/dist/DateTimePicker.min.css',
        './node_modules/alertifyjs/build/css/alertify.css',
        './node_modules/alertifyjs/build/css/themes/default.min.css',
        './node_modules/alertifyjs/build/css/themes/bootstrap.min.css',
    ]);
    mix.scripts([
        './node_modules/jquery/dist/jquery.js',
        'modernizr.js',
        './node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
        './node_modules/select2/dist/js/select2.js',
        './node_modules/highcharts/highcharts.js',
        './node_modules/highcharts/modules/exporting.js',
        './node_modules/datetimepicker/dist/DateTimePicker.js',
        './node_modules/alertifyjs/build/alertify.js',
        'main_design.js',
        'main.js'
        ]);
        //.scripts(['fbinit.js'], './public/js/access.js');
});
