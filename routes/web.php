<?php
use Illuminate\Support\Facades\DB;

Auth::routes();


Route::get('/location/{country}/{region}/{city}/', array('as' => 'id', 'uses' => 'WelcomeController@getCategories'));

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

	$categories = DB::table('categories')->where('id', $id)->get();
	$items = DB::table('adverts')->where('category_id', $id)->get();

	return view('results')->with("items", $items )->with("category_id", $id )->with("category_name", 
		mb_strtolower($categories[0]->name)); 
});

Route::get('getSearchData', 'SearchController@getSearchData');
Route::get('/details/{id}', array('as' => 'id', 'uses' => 'AdvertController@getFullInfo'));
Route::get('/location/{country}/{region}/{place}', array('as' => 'country', 'uses' => 'AdvertController@getFullInfo'));
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
