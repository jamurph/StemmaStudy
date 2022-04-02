const mix = require('laravel-mix');



mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/setNetwork.js', 'public/js')
    .js('resources/js/assessmentNetwork.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css')
    ;
