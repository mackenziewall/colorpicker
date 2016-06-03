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

Route::any('test', function() {
	 $options = array(
    'encrypted' => true
  );
  $pusher = new Pusher(
    '0c38ef7d30a8ee3a1055',
    'b796f089af27bca288a9',
    '212946',
    $options
  );

  $data['message'] = 'hello world';
  $pusher->trigger('swatch_update_trigger', 'swatch_update', $data);
});
