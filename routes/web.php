<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// ВНИМАНИЕ!: Присутсвует приоритет роутов

Auth::routes(); // Стандартные роуты

Route::post("api/createAdvert", "AdvertController@createAdvert");
Route::get("api/getSubCategoryNamesById", "JournalController@getSubCategoryNamesById" );
Route::get("api/getPlaces", "JournalController@GetPlaces");
Route::get("api/getCarsMarks", "JournalController@getCarsMarks" );
Route::get("api/getCarsModels", "JournalController@getCarsModels" );

// -------------------------------------------------------------------------------
// Результаты по категориям по всему Казахстану
// -------------------------------------------------------------------------------
Route::get("transport/{subcategory}",           "ResultsController@getResultsByCountryForView");
Route::get("nedvizhimost/{subcategory}", 	    "ResultsController@getResultsByCountryForView");
Route::get("elektronika/{subcategory}", 	    "ResultsController@getResultsByCountryForView");
Route::get("rabota-i-biznes/{subcategory}", 	"ResultsController@getResultsByCountryForView");
Route::get("dlya-doma-i-dachi/{subcategory}",	"ResultsController@getResultsByCountryForView");
Route::get("lichnye-veschi/{subcategory}", 	    "ResultsController@getResultsByCountryForView");
Route::get("zhivotnye/{subcategory}", 		    "ResultsController@getResultsByCountryForView");
Route::get("hobbi-i-otdyh/{subcategory}", 	    "ResultsController@getResultsByCountryForView");
Route::get("uslugi/{subcategory}", 		        "ResultsController@getResultsByCountryForView");
Route::get("drugoe/{subcategory}", 		        "ResultsController@getResultsByCountryForView");


// Новое объявление
Route::get("/podat-obyavlenie", "AdvertController@NewAd");

// Сервисы
Route::get("/util/str2url", "UtilsController@str2url");

// По стране
Route::get("/", "IndexController@ShowCountryIndexPage");
Route::get("/kazakhstan", "IndexController@ShowCountryIndexPage");
Route::get("/qazaqstan", "IndexController@ShowCountryIndexPage");

// По всему региону
Route::get("/{region}", "IndexController@ShowRegionIndexPage");

// По городу или селу
Route::get("/{region}/{place}", "IndexController@ShowPlaceIndexPage");




