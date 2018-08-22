<?php
use Illuminate\Support\Facades\DB;

Auth::routes();

// сервисы
Route::get('/util/str2url', 'WelcomeController@getCategories');

// категории
Route::get('/transport', 					'ResultController@getResultsByCategory');
Route::get('/nedvizhimost', 				'ResultController@getResultsByCategory');
Route::get('/bytovaya-tehnika', 			'ResultController@getResultsByCategory');
Route::get('/rabota-i-biznes', 				'ResultController@getResultsByCategory');
Route::get('/dlya-doma-i-dachi',			'ResultController@getResultsByCategory');
Route::get('/lichnye-veschi', 				'ResultController@getResultsByCategory');
Route::get('/zhivotnye', 					'ResultController@getResultsByCategory');
Route::get('/hobbi-i-otdyh', 				'ResultController@getResultsByCategory');
Route::get('/uslugi', 						'ResultController@getResultsByCategory');
Route::get('/drugoe', 						'ResultController@getResultsByCategory');

// resultsController@getResultsByCategory(0)
// resultsController@getResultsByCategory(1)

// категории по региону
Route::get('{region}/transport', 			'SearchController@getSearchData');
Route::get('{region}/nedvizhimost', 		'SearchController@getSearchData');
Route::get('{region}/bytovaya-tehnika', 	'SearchController@getSearchData');
Route::get('{region}/rabota-i-biznes', 		'SearchController@getSearchData');
Route::get('{region}/dlya-doma-i-dachi',	'SearchController@getSearchData');
Route::get('{region}/lichnye-veschi', 		'SearchController@getSearchData');
Route::get('{region}/zhivotnye', 			'SearchController@getSearchData');
Route::get('{region}/hobbi-i-otdyh', 		'SearchController@getSearchData');
Route::get('{region}/uslugi', 				'SearchController@getSearchData');
Route::get('{region}/drugoe', 				'SearchController@getSearchData');

// resultsController@getResultsByRegion(region_name)

// категории по региону и местности
Route::get('{region}/{place}/transport', 		'SearchController@getSearchData');
Route::get('{region}/{place}/nedvizhimost', 	'SearchController@getSearchData');
Route::get('{region}/{place}/bytovaya-tehnika', 'SearchController@getSearchData');
Route::get('{region}/{place}/rabota-i-biznes', 	'SearchController@getSearchData');
Route::get('{region}/{place}/dlya-doma-i-dachi','SearchController@getSearchData');
Route::get('{region}/{place}/lichnye-veschi', 	'SearchController@getSearchData');
Route::get('{region}/{place}/zhivotnye', 		'SearchController@getSearchData');
Route::get('{region}/{place}/hobbi-i-otdyh', 	'SearchController@getSearchData');
Route::get('{region}/{place}/uslugi', 			'SearchController@getSearchData');
Route::get('{region}/{place}/drugoe', 			'SearchController@getSearchData');

// resultsController@getResultsByPlace(place_name)

// базовые контроллеры
Route::get('/', 'WelcomeController@getCategories');
Route::get('/getRegions', 'WelcomeController@getRegions');
Route::get('/getPlaces', 'WelcomeController@getPlaces');
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
