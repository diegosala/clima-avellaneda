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

Route::get('/', 'LiveController@ShowLive');

Route::get('/archivo/diario', 'DailyController@Main');
Route::get('/archivo/{year}/{month}/{date}', 'DailyController@Daily');

Route::get('/archivo/mensual', 'MonthlyController@Main');
Route::get('/archivo/{year}/{month}', 'MonthlyController@Monthly');

Route::get('/archivo/anual', 'YearlyController@Main');
Route::get('/archivo/{year}', 'YearlyController@Yearly');

Route::get('/graficos', 'LiveController@LiveData');
Route::get('/ultimos/datos', 'LiveController@LastData');
