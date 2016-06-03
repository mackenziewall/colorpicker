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
Route::post('ajax/clone', 'SwatchController@cloneSwatch');
Route::post('ajax/lock', 'SwatchController@lock');
Route::post('ajax/update', 'SwatchController@update');
Route::post('ajax/delete', 'SwatchController@delete');

//move to service providers... eventually
App::bind('Pusher', function($app) {
	$options = array(
	    'encrypted' => true
	  );
	$keys = $app['config']->get('services.pusher');
	return new Pusher(getenv('PUSHER_KEY'),getenv('PUSHER_SECRET'),getenv('PUSHER_ID'));
});

// Route::any('test', function() {
//   App::make('Pusher')->trigger('swatch_update_trigger:' . , 'update', ['message' => 'update transmitted']);
//   return 'Done';
// });
