<?php
use Illuminate\Support\Facades\Auth;
use App\Categories;

Auth::routes();
Route::get('/', 'WelcomeController@getCategories');
Route::get('/getUser', 'UserController@getUser');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/newtrip', function () { return view('newtrip'); });
Route::get('/categories', 'CategoriesController@index');
Route::get('/search', function () { return view('search'); });

// перекинуть в контроллер
Route::get('/create', function () { 
	
	return Auth::user()? view('create')->with("items", Categories::all())->with("auth", Auth::user()?1:0) : view('auth\login'); 
});
Route::get('/category/{id}', function () { return view('category'); });
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
