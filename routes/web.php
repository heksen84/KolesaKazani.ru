<?php
use Illuminate\Support\Facades\DB;

Auth::routes();

Route::get('test',  function () { return view('test'); });
Route::post('checkPhotos',  'TestController@checkPhotos');


Route::get('getCategoryCountById', 'WelcomeController@getCategoryCountById');
Route::get('getCategoryCounts', 'WelcomeController@getCategoryCounts');

// сервисы
Route::get('/util/str2url', 'UtilsController@str2url');

// категории по всему Казахстану
Route::get('transport', 				'ResultsController@getResultsByCategory');
Route::get('nedvizhimost', 				'ResultsController@getResultsByCategory');
Route::get('bytovaya-tehnika', 			'ResultsController@getResultsByCategory');
Route::get('rabota-i-biznes', 			'ResultsController@getResultsByCategory');
Route::get('dlya-doma-i-dachi',			'ResultsController@getResultsByCategory');
Route::get('lichnye-veschi', 			'ResultsController@getResultsByCategory');
Route::get('zhivotnye', 				'ResultsController@getResultsByCategory');
Route::get('hobbi-i-otdyh', 			'ResultsController@getResultsByCategory');
Route::get('uslugi', 					'ResultsController@getResultsByCategory');
Route::get('drugoe', 					'ResultsController@getResultsByCategory');

// категории по региону
Route::get('{region}/{category}', 'ResultsController@getResultsByRegion');

// категории по региону и местности
Route::get('{region}/{place}/{category}', 'ResultsController@getResultsByPlace');

// базовые контроллеры
Route::post('create', 			 'AdvertController@createAdvert');
Route::get('podat-obyavlenie', 	 'AdvertController@newAdvert');
Route::get('/', 				 'IndexController@getCategories');
Route::get('getRegions', 		 'IndexController@getRegions');
Route::get('getPlaces', 		 'IndexController@getPlaces');
Route::get('getUser', 			 'UserController@getUser');
Route::get('home',	 		 	 'CabinetController@index');
Route::get('home/{advert_id}',	 'CabinetController@index');
Route::get('categories', 		 'CategoriesController@index');

// авто
Route::get('getCarsMarks',  'AdvertController@getCarsMarks' );
Route::get('getCarsModels', 'AdvertController@getCarsModels' );

Route::get('search',  function () { return view('search')->with("items", "123"); });

// перенести в контроллер Categories
Route::get('/category/{id}', function ($id) { 
	$categories = DB::table('categories')->where('id', $id)->get();
	$items = DB::table('adverts')->where('category_id', $id)->get();
	return view('results')->with("items", $items )->with("category_id", $id )->with("category_name", 
		mb_strtolower($categories[0]->name));
});

Route::get('getSearchData', 'SearchController@getSearchData');
//Route::get('details/{id}', array('as' => 'id', 'uses' => 'AdvertController@getFullInfo'));

Route::get('details/{id}', ['uses' => 'AdvertController@getFullInfo']);
Route::get('location/{country}/{region}/{place}', ['uses' => 'AdvertController@getFullInfo']);
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

/*
------------------------------------------------
АДМИН
------------------------------------------------*/

Route::get('admin', 'AdminController@login');