<?php
use Illuminate\Support\Facades\DB;

Auth::routes();

Route::get('/', 'WelcomeController@getCategories');
Route::get('/getUser', 'UserController@getUser');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/{advert_id}', 'HomeController@index')->name('home');
Route::get('/newtrip', function () { return view('newtrip'); });
Route::get('/categories', 'CategoriesController@index');
Route::get('/search', function () { return view('search')->with("items", "123");});
Route::get('/new', 'AdvertController@newAdvert');
Route::post('/create', 'AdvertController@createAdvert');
Route::get('/getCarsMarks',  'AdvertController@getCarsMarks' );
Route::get('/getCarsModels', 'AdvertController@getCarsModels' );

// перенести в контроллер Categories
Route::get('/category/{id}', function ($id) { 
	$items = DB::table('adverts')->where('category_id', $id)->get();
	return view('results')->with("items", $items )->with("category_id", $id ); 
});

Route::get('getSearchData', 'SearchController@getSearchData');
Route::get('/details/{id}', array('as' => 'id', 'uses' => 'AdvertController@getFullInfo'));
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
