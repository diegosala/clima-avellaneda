<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::pattern("year", '[0-9]+');
Route::pattern("month", '[0-9]+');
Route::pattern("date", '[0-9]+');

Route::get('/', array('after' => 'cache:1800', 'uses' => 'LiveController@ShowLive'));

Route::get('/archivo/diario', array('after' => 'cache:300', 'uses' => 'DailyController@Main'));
Route::get('/archivo/{year}/{month}/{date}', array('after' => 'cache:300', 'uses' =>'DailyController@Daily'));

Route::get('/archivo/mensual', array('after' => 'cache:300', 'uses' => 'MonthlyController@Main'));
Route::get('/archivo/{year}/{month}', array('after' => 'cache:300', 'uses' =>'MonthlyController@Monthly'));

Route::get('/archivo/anual', array('after' => 'cache:300', 'uses' =>'YearlyController@Main'));
Route::get('/archivo/{year}', array('after' => 'cache:300', 'uses' =>'YearlyController@Yearly'));

Route::get('/graficos/{span?}/{unit?}', array('after' => 'cache:1800', 'uses' =>'LiveController@LiveData'));
Route::get('/ultimos/datos/{amount}', 'LiveController@LastData');

Route::get('/forecast', 'ForecastController@Main');

Route::get('/contacto', 'ContactController@Main');
Route::post('/contacto', 'ContactController@Send');
