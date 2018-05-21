<?php
Auth::routes();
Route::get('/', function () { return view('welcome'); });
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/newtrip', function () { return view('newtrip'); });
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/categories', 'CategoriesController@index');
