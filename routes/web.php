<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {

    if(Auth::check()){
        return redirect()->route('user_sets');
    }

    return view('index');
});

/*
    Set
*/
Route::get('/my-sets', 'SetController@index')->middleware('auth')->name('user_sets');
Route::post('/my-sets', 'SetController@store')->middleware('auth')->name('set_store');
Route::get('/my-sets/new', 'SetController@create')->middleware('auth')->name('set_create');
Route::get('/my-sets/{set}/edit', 'SetController@edit')->middleware('auth')->name('set_edit');
Route::get('/my-sets/{set}', 'SetController@show')->middleware('auth')->name('cards_in_set');
Route::put('/my-sets/{set}', 'SetController@update')->middleware('auth')->name('set_update');
Route::delete('/my-sets/{set}', 'SetController@destroy')->middleware('auth')->name('set_destroy');

/* 
    Network
*/
Route::get('/network/{set}', 'SetController@network')->middleware('auth')->name('set_network');

/* 
    Cards
*/
Route::get('/my-sets/{set}/card/{card}', 'CardController@show')->middleware('auth')->name('user_card');
Route::post('/my-sets/{set}/card', 'CardController@store')->middleware('auth')->name('card_store');
Route::get('/my-sets/{set}/new-card', 'CardController@create')->middleware('auth')->name('card_create');
Route::get('/my-sets/{set}/card/{card}/edit', 'CardController@edit')->middleware('auth')->name('card_edit');
Route::put('/my-sets/{set}/card/{card}', 'CardController@update')->middleware('auth')->name('card_update');
Route::delete('/my-sets/{set}/card/{card}', 'CardController@destroy')->middleware('auth')->name('card_destroy');


/*
    Connections
*/
Route::put('/my-sets/{set}/connection/{connection}', 'ConnectionController@update')->middleware('auth')->name('connection_update');
Route::post('/my-sets/{set}/connection/', 'ConnectionController@store')->middleware('auth')->name('connection_store');
Route::delete('/my-sets/{set}/card/{card}/connection/{connection}', 'ConnectionController@destroy')->middleware('auth')->name('connection_destroy');

/* 
    Review
*/
Route::get('/my-sets/{set}/review', 'ReviewController@review')->middleware('auth')->name('set_review');
Route::get('/my-sets/{set}/review/maintenance', 'ReviewController@maintenance')->middleware('auth')->name('set_maintenance');
Route::put('/my-sets/{set}/review/maintenance', 'ReviewController@maintenance_put')->middleware('auth')->name('set_maintenance_put');
Route::get('/my-sets/{set}/assessment/new', 'ReviewController@new_assessment')->middleware('auth')->name('new_assessment');
Route::get('/my-sets/{set}/assessment/{assessment}/', 'AssessmentController@show')->middleware('auth')->name('assessment_complete');
Route::delete('/my-sets/{set}/assessment/{assessment}/', 'AssessmentController@destroy')->middleware('auth')->name('assessment_destroy');
Route::get('/my-sets/{set}/assessment/{assessment}/quiz', 'ReviewController@assessment_card')->middleware('auth')->name('assessment_card');
Route::post('/my-sets/{set}/assessment/{assessment}/quiz', 'ReviewController@assessment_card_store')->middleware('auth')->name('assessment_card_store');
Route::get('/my-sets/{set}/assessment/{assessment}/detail', 'AssessmentController@network')->middleware('auth')->name('assessment_network');


/* Contact Form */
Route::get('/contact', 'ContactFormController@create')->name('contact_create');
Route::post('/contact', 'ContactFormController@store')->name('contact_store');
Route::get('/contact/submitted', 'ContactFormController@thanks')->name('contact_thanks');


Auth::routes();
/*
    Minor Logout get request fix. (user middle mouse clicks "Logout")
*/
Route::get('/logout', function(){
    Auth::logout();
    return redirect('/');
});
