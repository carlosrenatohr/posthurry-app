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
    mix.sass('app.scss');
    mix.styles([
       './node_modules/select2/dist/css/select2.css',
       './node_modules/select2-bootstrap-css/select2-bootstrap.css'
    ]);
    mix.scripts([
        './node_modules/jquery/dist/jquery.js',
        './node_modules/select2/dist/js/select2.js',
        './node_modules/highcharts/highcharts.js',
        './node_modules/highcharts/modules/exporting.js',
        'main.js'
        ])
        .scripts(['fbinit.js'], './public/js/access.js');
});
