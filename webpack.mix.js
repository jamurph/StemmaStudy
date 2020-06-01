const mix = require('laravel-mix');



mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/sampleNetwork.js', 'public/js')
    .js('resources/js/setNetwork.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    ;
