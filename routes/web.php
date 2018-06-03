<?php
use Illuminate\Support\Facades\Auth;

Auth::routes();
Route::get('/', 'WelcomeController@getCategories');
Route::get('/getUser', 'UserController@getUser');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/newtrip', function () { return view('newtrip'); });
Route::get('/categories', 'CategoriesController@index');
Route::get('/search', function () { return view('search'); });
Route::get('/create', function () { return Auth::user()? view('create') : view('auth\login'); });
Route::get('/category/{id}', function () { return view('category'); });
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
