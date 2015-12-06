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

Route::get('/', function () {
    return view('welcome');
});

// Route::resource('hex','SwatchController');
// Route::resource('hex.b','BlockController');
// Route::resource('hex.b.v','HexController');


Route::get('hex/create', 'SwatchController@create');
Route::get('hex/{id}', 'SwatchController@show');
Route::get('hex/{id}/status', 'SwatchController@status');



// Route::controller('users', 'UserController');