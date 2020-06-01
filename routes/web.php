<?php

use App\Set;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/sampleNetwork', function () {
    return view('sampleNetwork');
});

Route::get('/sets', 'SetController@index')->middleware('auth')->name('user_sets');
Route::get('/sets/{set}', 'SetController@show')->middleware('auth')->name('cards_in_set');
Route::get('/network/{set}', 'SetController@network')->middleware('auth')->name('set_network');
Route::get('/card/{card}', 'CardController@show')->middleware('auth')->name('user_card');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
