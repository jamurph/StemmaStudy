<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {

    if(Auth::check()){
        return redirect()->route('user_sets');
    }

    return view('index');
})->name('home');


Route::get('/learn', function () {
    return view('learning.learning');
})->name('learn');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/tutorial', function () {
    return view('tutorial');
})->name('tutorial');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

/*
    Set
*/
Route::get('/my-sets', 'SetController@index')->middleware('verified')->name('user_sets');
Route::post('/my-sets', 'SetController@store')->middleware('verified')->name('set_store');
Route::get('/my-sets/new', 'SetController@create')->middleware('verified')->name('set_create');
Route::get('/my-sets/{set}/edit', 'SetController@edit')->middleware('verified')->name('set_edit');
Route::get('/my-sets/{set}', 'SetController@show')->middleware('verified')->name('cards_in_set');
Route::put('/my-sets/{set}', 'SetController@update')->middleware('verified')->name('set_update');
Route::delete('/my-sets/{set}', 'SetController@destroy')->middleware('verified')->name('set_destroy');

/* 
    Network
*/
Route::get('/network/{set}', 'SetController@network')->middleware('verified')->name('set_network');
Route::put('/network/{set}/update', 'SetController@update_network')->middleware('verified')->name('update_network');

/* 
    Cards
*/
Route::get('/my-sets/{set}/card/{card}', 'CardController@show')->middleware('verified')->name('user_card');
Route::post('/my-sets/{set}/card', 'CardController@store')->middleware('verified')->name('card_store');
Route::get('/my-sets/{set}/new-card', 'CardController@create')->middleware('verified')->name('card_create');
Route::get('/my-sets/{set}/card/{card}/edit', 'CardController@edit')->middleware('verified')->name('card_edit');
Route::put('/my-sets/{set}/card/{card}', 'CardController@update')->middleware('verified')->name('card_update');
Route::delete('/my-sets/{set}/card/{card}', 'CardController@destroy')->middleware('verified')->name('card_destroy');

Route::get('/images/{trixattachment:attachment}', 'CardController@get_attachment')->middleware('verified')->name('get_attachment')->where('trixattachment', '.*');

/*
    Connections
*/
Route::put('/my-sets/{set}/connection/{connection}', 'ConnectionController@update')->middleware('verified')->name('connection_update');
Route::post('/my-sets/{set}/connection/', 'ConnectionController@store')->middleware('verified')->name('connection_store');
Route::delete('/my-sets/{set}/card/{card}/connection/{connection}', 'ConnectionController@destroy')->middleware('verified')->name('connection_destroy');
Route::delete('/my-sets/{set}/connection/{connection}', 'ConnectionController@destroy_async')->middleware('verified')->name('connection_destroy_async');

/* 
    Review
*/
Route::get('/my-sets/{set}/review', 'ReviewController@review')->middleware('verified')->name('set_review');
Route::get('/my-sets/{set}/review/maintenance', 'ReviewController@maintenance')->middleware('verified')->name('set_maintenance');
Route::put('/my-sets/{set}/review/maintenance', 'ReviewController@maintenance_put')->middleware('verified')->name('set_maintenance_put');
Route::get('/my-sets/{set}/assessment/new', 'ReviewController@new_assessment')->middleware('verified')->name('new_assessment');
Route::get('/my-sets/{set}/assessment/{assessment}/', 'AssessmentController@show')->middleware('verified')->name('assessment_complete');
Route::delete('/my-sets/{set}/assessment/{assessment}/', 'AssessmentController@destroy')->middleware('verified')->name('assessment_destroy');
Route::get('/my-sets/{set}/assessment/{assessment}/quiz', 'ReviewController@assessment_card')->middleware('verified')->name('assessment_card');
Route::post('/my-sets/{set}/assessment/{assessment}/quiz', 'ReviewController@assessment_card_store')->middleware('verified')->name('assessment_card_store');
Route::get('/my-sets/{set}/assessment/{assessment}/detail', 'AssessmentController@network')->middleware('verified')->name('assessment_network');


/* Contact Form */
Route::get('/contact', 'ContactFormController@create')->name('contact_create');
Route::post('/contact', 'ContactFormController@store')->name('contact_store');
Route::get('/contact/submitted', 'ContactFormController@thanks')->name('contact_thanks');


/* Settings */
Route::get('/settings', 'SettingsController@show')->middleware('verified')->name('settings');
Route::post('/settings', 'SettingsController@updateName')->middleware('verified')->name('update_name');
Route::get('/settings/portal', 'SettingsController@portal')->middleware('verified')->name('billing_portal');
Route::get('/settings/subscribe', 'SettingsController@subscribe')->middleware('verified')->name('subscribe');
Route::post('/settings/subscribe', 'SettingsController@subscribe_store')->middleware('verified')->name('subscribe_store');
Route::post('/settings/emails/subscribe', 'SettingsController@email_subscribe')->middleware('verified')->name('email_subscribe');
Route::post('/settings/emails/unsubscribe', 'SettingsController@email_unsubscribe')->middleware('verified')->name('email_unsubscribe');
Route::post('/settings/notifications/subscribe', 'SettingsController@notification_subscribe')->middleware('verified')->name('notification_subscribe');
Route::post('/settings/notifications/unsubscribe', 'SettingsController@notification_unsubscribe')->middleware('verified')->name('notification_unsubscribe');


Auth::routes(['verify' => true]);
/*
    Minor Logout get request fix. (user middle mouse clicks "Logout")
*/
Route::get('/logout', function(){
    Auth::logout();
    return redirect('/');
});