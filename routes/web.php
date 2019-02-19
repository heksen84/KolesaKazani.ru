<?php
use Illuminate\Support\Facades\DB;

Auth::routes();

// ------------------------------------
//  Пробный методы
// ------------------------------------
Route::get('test',  function () { return view('test'); });
Route::post('checkPhotos',  'TestController@checkPhotos');

// ------------------------------------
// Модерация
// ------------------------------------
Route::get('moderation',  function () { return view('moderation'); });
Route::get('moderation/{advert_id}',  function () { return view('moderation_advert'); });

//Route::get('details/{id}', array('as' => 'id', 'uses' => 'AdvertController@getFullInfo'));

// ------------------------------------
// Реклама на сайте
// ------------------------------------
Route::get('advertisers',  function () { return view('advertisers'); });

// О сайте...
Route::get('about',  function () { return view('about'); });


Route::get('getCategoryCountById', 'WelcomeController@getCategoryCountById');
Route::get('getCategoryCounts', 'WelcomeController@getCategoryCounts');

// ------------------------------------
// сервисы
// ------------------------------------
Route::get('/util/str2url', 'UtilsController@str2url');

// ------------------------------------
// категории по всему Казахстану
// ------------------------------------
Route::get('transport', 				'ResultsController@getResultsByCategory');
//Route::get('transport', 				'SubCatController@showSubCategory');
Route::get('nedvizhimost', 				'ResultsController@getResultsByCategory');
Route::get('elektronika', 				'ResultsController@getResultsByCategory');
Route::get('rabota-i-biznes', 			'ResultsController@getResultsByCategory');
Route::get('dlya-doma-i-dachi',			'ResultsController@getResultsByCategory');
Route::get('lichnye-veschi', 			'ResultsController@getResultsByCategory');
Route::get('zhivotnye', 				'ResultsController@getResultsByCategory');
Route::get('hobbi-i-otdyh', 			'ResultsController@getResultsByCategory');
Route::get('uslugi', 					'ResultsController@getResultsByCategory');
Route::get('drugoe', 					'ResultsController@getResultsByCategory');

// ------------------------------------
// подкатегории
// ------------------------------------
// транспорт
/*Route::get('transport/gruzovoy-avtomobil', 	  		'SubCatsController@getResultsByCategory');
Route::get('transport/legkovoy-avtomobil', 	  		'SubCatsController@getResultsByCategory');
Route::get('transport/mototehnika', 			  	'SubCatsController@getResultsByCategory');
Route::get('transport/spectehnika', 			  	'SubCatsController@getResultsByCategory');
Route::get('transport/retro-avtomobil', 		  	'SubCatsController@getResultsByCategory');
Route::get('transport/vodnyy-transport', 		  	'SubCatsController@getResultsByCategory');
Route::get('transport/velosiped', 			  		'ResultsController@getResultsByCategory');
Route::get('transport/vozdushnyy-transport',	  	'ResultsController@getResultsByCategory');*/


// Весь КЗ
/*Route::get('transport/{subcat}',					['uses' => 'SubCatsController@getResultsByCategory']);
Route::get('{region}/transport/{subcat}',			['uses' => 'SubCatsController@getResultsByCategory']);
Route::get('{region}/{place}/transport/{subcat}',	['uses' => 'SubCatsController@getResultsByCategory']);*/



// недвижимость
Route::get('kvartira', 				  		'ResultsController@getResultsByCategory');
Route::get('komnata', 				  		'ResultsController@getResultsByCategory');
Route::get('dom-dacha-kottedzh',	  		'ResultsController@getResultsByCategory');
Route::get('zemel-nyy-uchastok',	  		'ResultsController@getResultsByCategory');
Route::get('garazh-ili-mashinomesto', 		'ResultsController@getResultsByCategory');
Route::get('kommercheskaya-nedvizhimost', 	'ResultsController@getResultsByCategory');
Route::get('nedvizhimost-za-rubezhom', 		'ResultsController@getResultsByCategory');

// ------------------------------------
// детали объявления
// ------------------------------------
Route::get('details/{id}', 'AdvertController@getFullInfo');

// подкатегории
Route::get('{category}/{subcat}', 'SubCatsController@getResultsByCategory');

// ------------------------------------
// базовые контроллеры
// ------------------------------------
Route::post('create', 			 'AdvertController@createAdvert');
Route::get('podat-obyavlenie', 	 'AdvertController@newAdvert');
Route::get('/', 				 'IndexController@getCategories');
Route::get('getRegions', 		 'IndexController@getRegions');
Route::get('getPlaces', 		 'IndexController@getPlaces');
Route::get('getUser', 			 'UserController@getUser');
Route::get('home',	 		 	 'CabinetController@index');
Route::get('home/{advert_id}',	 'CabinetController@index');
Route::get('categories', 		 'CategoriesController@index');

Route::get('getSubCats',  'SubCatsController@getSubCats' );

// ------------------------------------
// авто
// ------------------------------------
Route::get('getCarsMarks',  'AdvertController@getCarsMarks' );
Route::get('getCarsModels', 'AdvertController@getCarsModels' );

Route::get('search',  function () { return view('search')->with("items", "123"); });

// ------------------------------------
// перенести в контроллер Categories
// ------------------------------------
Route::get('/category/{id}', function ($id) { 
	$categories = DB::table('categories')->where('id', $id)->get();
	$items = DB::table('adverts')->where('category_id', $id)->get();
	return view('results')->with("items", $items )->with("category_id", $id )->with("category_name", 
		mb_strtolower($categories[0]->name));
});

Route::get('getResults', 'SearchController@getSearchData');
Route::get('location/{country}/{region}/{place}', 'AdvertController@getFullInfo');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

// ------------------------------------
// категории по региону
// ------------------------------------
Route::get('{region}/{category}', 'ResultsController@getResultsByRegion');

// ------------------------------------
// категории по региону и местности
// ------------------------------------
Route::get('{region}/{place}/{category}', 'ResultsController@getResultsByPlace');


/*
------------------------------------------------
 Панель администратора
------------------------------------------------*/
Route::get('admin', 'AdminController@login');