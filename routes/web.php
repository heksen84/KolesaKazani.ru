<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () { return view('welcome'); });
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/newtrip', function () { return view('newtrip'); });

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

//Route::get('/{number}', function () { return view('details'); });
//Route::get('/search/', function () { return view('details'); });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
