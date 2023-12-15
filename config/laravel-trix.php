<?php

return [
    'storage_disk' => env('LARAVEL_TRIX_STORAGE_DISK', 'public'),

    'store_attachment_action' => 'CardController@store_attachment',

    'destroy_attachment_action' => 'CardController@destroy_attachment',
];
