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
Route::get("transport/{subcategory}",           "TransportResultsController@getTransportResultsByCountryForView");
Route::get("nedvizhimost/{subcategory}", 	    "RealestateResultsController@getRealestateResultsByCountryForView");
Route::get("elektronika/{subcategory}", 	    "ElektronikaResultsController@getTransportResultsByCountryForView");
Route::get("rabota-i-biznes/{subcategory}", 	"Rabota-i-biznesResultsController@getTransportResultsByCountryForView");
Route::get("dlya-doma-i-dachi/{subcategory}",	"Dlya-doma-i-dachiResultsController@getTransportResultsByCountryForView");
Route::get("lichnye-veschi/{subcategory}", 	    "Lichnye-veschiResultsController@getTransportResultsByCountryForView");
Route::get("zhivotnye/{subcategory}", 		    "ZhivotnyeResultsController@getTransportResultsByCountryForView");
Route::get("hobbi-i-otdyh/{subcategory}", 	    "Hobbi-i-otdyhResultsController@getTransportResultsByCountryForView");
Route::get("uslugi/{subcategory}", 		        "UslugiResultsController@getTransportResultsByCountryForView");
Route::get("drugoe/{subcategory}", 		        "DrugoeResultsController@getTransportResultsByCountryForView");


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




