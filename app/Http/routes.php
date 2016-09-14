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

Route::group(['middleware' => ['auth', 'web']], function() {

	Route::get('/', 'HomeController@index');
	Route::get('/dashboard', 'HomeController@dash');

	Route::group(['middleware'=> 'csrf'], function() {

	});



	Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
        Route::get('/todo', 'TodoController@all');
	});
});
Route::auth();
Route::post('logout', 'Auth\AuthController@logout');
