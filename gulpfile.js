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
  mix.phpUnit();                      // run tests
  mix.sass('app.scss');               // compile sass

  // Common scripts for all pages (app.js)
  mix.coffee([
    'app.coffee',
    'helper.coffee',
    'getStatus.coffee'
  ]);

  // special scripts for certain pages
  mix.coffee('charts.coffee');
  mix.coffee('collection.coffee');
  mix.coffee('createVinyl.coffee');
  mix.coffee('import.coffee');
  mix.coffee('jukebox.coffee');
  mix.coffee('search.coffee');
  mix.coffee('settings.coffee');
  mix.coffee('welcome.coffee');

  // copy all bower files
  mix.copy('bower_components/normalize.css/normalize.css', 'public/css/vendor/normalize.css');
  mix.copy('bower_components/bootstrap/dist/css/bootstrap.css', 'public/css/vendor/bootstrap.css');
  mix.copy('bower_components/jquery/dist/jquery.js', 'public/js/vendor/jquery.js');
  mix.copy('bower_components/vue/dist/vue.js', 'public/js/vendor/vue.js');
  mix.copy('bower_components/vue-resource/dist/vue-resource.min.js', 'public/js/vendor/vue-resource.min.js');
  mix.copy('bower_components/bootstrap/dist/js/bootstrap.js', 'public/js/vendor/bootstrap.js');
  mix.copy('bower_components/fontawesome/fonts', 'public/css/fonts');
  mix.copy('bower_components/fontawesome/css/font-awesome.min.css', 'public/css/vendor/font-awesome.min.css');
  mix.copy('bower_components/lodash/dist/lodash.min.js', 'public/js/vendor/lodash.min.js');
  mix.copy('bower_components/Chart.js/dist/Chart.min.js', 'public/js/vendor/Chart.min.js');
  mix.copy('bower_components/dateformatjs/dateformat.min.js', 'public/js/vendor/dateformat.min.js');
  mix.copy('bower_components/sweetalert/dist/sweetalert.min.js', 'public/js/vendor/sweetalert.min.js');
  mix.copy('bower_components/sweetalert/dist/sweetalert.css', 'public/css/vendor/sweetalert.css');

  mix.styles([                        // concat styles
    'vendor/normalize.css',
    'vendor/bootstrap.css',
    'vendor/sweetalert.css',
    'app.css'
  ], null, 'public/css');

  mix.scripts([                       // concat scripts
    'vendor/jquery.js',
    'vendor/lodash.min.js',
    'vendor/vue.js',
    'vendor/vue-resource.min.js',
    'vendor/vue-filter.min.js',
    'vendor/vue-youtube-embed.js',
    'vendor/bootstrap.js',
    'vendor/Chart.min.js',
    'vendor/dateformat.min.js',
    'vendor/sweetalert.min.js',
    'app.js'
  ], null, 'public/js');

  mix.version('public/css/all.css');  // versioning
});
