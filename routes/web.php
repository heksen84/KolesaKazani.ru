<?php
use Illuminate\Support\Facades\Auth;
use App\Categories;

Auth::routes();
Route::get('/', 'WelcomeController@getCategories');
Route::get('/getUser', 'UserController@getUser');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/{advert_id}', 'HomeController@index')->name('home');
Route::get('/newtrip', function () { return view('newtrip'); });
Route::get('/categories', 'CategoriesController@index');
Route::get('/search', function () { return view('search'); });


// перекинуть в контроллер
Route::get('/create', function () { 
	return Auth::user()? view('create')->with("items", Categories::all()) : view('auth\login'); 
});

Route::post('/create', function () { return view('home'); });


Route::get('/category/{id}', function () { return view('category'); });
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
