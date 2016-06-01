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

Route::get('/', 'SwatchController@create');
Route::get('create', 'SwatchController@create');

Route::get('hex/{id}', function () {
    return view('hex');
});

Route::get('ajax/fetch/{id}', 'SwatchController@show');
Route::get('ajax/sass/{id}', 'SwatchController@sassExport');
Route::post('ajax/add', 'SwatchController@addBlock');
Route::post('ajax/fork', 'SwatchController@fork');
Route::post('ajax/lock', 'SwatchController@lock');
Route::post('ajax/update', 'SwatchController@update');
Route::post('ajax/delete', 'SwatchController@delete');


