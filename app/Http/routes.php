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

Route::post('/create', '\App\Http\Controllers\TaskController@create');
Route::get('/', '\App\Http\Controllers\TaskController@retrieve');
Route::post('/update', '\App\Http\Controllers\TaskController@update');
Route::post('/delete', '\App\Http\Controllers\TaskController@delete');
