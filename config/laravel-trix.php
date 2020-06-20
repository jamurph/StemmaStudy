<?php

return [
    'storage_disk' => env('LARAVEL_TRIX_STORAGE_DISK', 'public'),

    'store_attachment_action' => App\Http\Controllers\CardController::class.'@store_attachment',

    'destroy_attachment_action' => App\Http\Controllers\CardController::class.'@destroy_attachment',
];
