<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('index');
});

Route::get('/sampleNetwork', function () {
    return view('sampleNetwork');
});

Route::get('/my-sets', 'SetController@index')->middleware('auth')->name('user_sets');
Route::post('/my-sets', 'SetController@store')->middleware('auth')->name('set_store');
Route::get('/my-sets/new', 'SetController@create')->middleware('auth')->name('set_create');
Route::get('/my-sets/{set}/edit', 'SetController@edit')->middleware('auth')->name('set_edit');
Route::get('/my-sets/{set}', 'SetController@show')->middleware('auth')->name('cards_in_set');
Route::put('/my-sets/{set}', 'SetController@update')->middleware('auth')->name('set_update');
Route::delete('/my-sets/{set}', 'SetController@destroy')->middleware('auth')->name('set_destroy');

Route::get('/network/{set}', 'SetController@network')->middleware('auth')->name('set_network');

Route::get('/my-sets/{set}/card/{card}', 'CardController@show')->middleware('auth')->name('user_card');
Route::post('/my-sets/{set}/card', 'CardController@store')->middleware('auth')->name('card_store');
Route::get('/my-sets/{set}/new-card', 'CardController@create')->middleware('auth')->name('card_create');
Route::get('/my-sets/{set}/card/{card}/edit', 'CardController@edit')->middleware('auth')->name('card_edit');
Route::put('/my-sets/{set}/card/{card}', 'CardController@update')->middleware('auth')->name('card_update');
Route::delete('/my-sets/{set}/card/{card}', 'CardController@destroy')->middleware('auth')->name('card_destroy');

Route::put('/my-sets/{set}/connection/{connection}', 'ConnectionController@update')->middleware('auth')->name('connection_update');
Route::post('/my-sets/{set}/connection/', 'ConnectionController@store')->middleware('auth')->name('connection_store');
Route::delete('/my-sets/{set}/card/{card}/connection/{connection}', 'ConnectionController@destroy')->middleware('auth')->name('connection_destroy');

Auth::routes();

