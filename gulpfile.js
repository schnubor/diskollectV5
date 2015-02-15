var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
  mix.sass('app.scss');               // compile sass
  mix.coffee();                       // compile coffeescript

  // copy all bower files
  mix.copy('bower_components/normalize.css/normalize.css', 'public/css/vendor/normalize.css');
  mix.copy('bower_components/bootstrap/dist/css/bootstrap.css', 'public/css/vendor/bootstrap.css');
  mix.copy('bower_components/jquery/dist/jquery.js', 'public/js/vendor/jquery.js');
  mix.copy('bower_components/bootstrap/dist/js/bootstrap.js', 'public/js/vendor/bootstrap.js');
  mix.copy('bower_components/fontawesome/fonts', 'public/css/fonts');
  mix.copy('bower_components/fontawesome/css/font-awesome.min.css', 'public/css/vendor/font-awesome.min.css');

  mix.styles([                        // concat styles
    'vendor/normalize.css',
    'vendor/bootstrap.css',
    'app.css'
  ], null, 'public/css');

  mix.scripts([                       // concat scripts
    'vendor/jquery.js',
    'vendor/bootstrap.js',
    'app.js'
  ], null, 'public/js');

  mix.version('public/css/all.css');  // versioning
});
