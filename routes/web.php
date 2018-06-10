<?php
use Illuminate\Support\Facades\Auth;
use App\Categories;
use App\Adverts;

Auth::routes();
Route::get('/', 'WelcomeController@getCategories');
Route::get('/getUser', 'UserController@getUser');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/{advert_id}', 'HomeController@index')->name('home');
Route::get('/newtrip', function () { return view('newtrip'); });
Route::get('/categories', 'CategoriesController@index');
Route::get('/search', function () { return view('search')->with("items", "123");});


// перекинуть в контроллер
Route::get('/create', function () { 
	return Auth::user()? view('create')->with("items", Categories::all()) : view('auth\login'); 
});

Route::post('/create', 'AdvertsController@createAdvert');
Route::get('/category/{id}', function () { return view('category')->with("items", Adverts::all()); });
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
