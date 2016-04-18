<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::post('/create_event/', 'EventController@create_event');
Route::post('/delete_event/', 'EventController@delete_event');
Route::post('/edit_event/', 'EventController@edit_event');
Route::post('/register/','AccountController@register');
Route::post('/login/','AccountController@login');

Route::get('/event_list/','EventController@event_list');
Route::get('/get_event/','EventController@get_myEvents');
Route::get('/personal_info/','AccountController@personal_info');
Route::get('/','AccountController@index');
Route::get('/event/','EventController@index');
Route::get('/join/','EventController@join');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);
