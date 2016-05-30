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
    return view('home');
});

// Route::resource('hex','SwatchController');
// Route::resource('hex.b','BlockController');
// Route::resource('hex.b.v','HexController');


Route::get('hex/create', 'SwatchController@create');
Route::get('hex/get/{id}', 'SwatchController@show');
// Route::post('ajax/hex/{id}', 'SwatchController@show');
// Route::post('ajax/hex/create', 'SwatchController@create');


// Route::get('hex/{id}/{statusid}', 'SwatchController@check');
// Route::get('hex/update/{id}/{statusid}', 'SwatchController@checkin');



// Route::controller('users', 'UserController');