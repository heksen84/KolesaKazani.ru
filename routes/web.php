<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// ВНИМАНИЕ!: Присутсвует приоритет роутов

Auth::routes(); // Стандартные роуты

Route::get("api/getSubCategoryNamesById", "JournalController@getSubCategoryNamesById" );
Route::post("api/createAdvert", "AdvertController@createAdvert");
Route::get("api/getPlaces", "IndexController@GetPlaces");


// ------------------------------
// task
// ------------------------------
// транспорт кз
// недвижимость кз
// ...
// транспорт обл.
// недвиж. обл.
// ...
// транспорт города / села
// недвиж. города / села

// -------------------------------------------------------------------------------
// Результаты по категориям по всему Казахстану
// -------------------------------------------------------------------------------
// TransportResultController
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

// ---------------------------------------------------------------
// Авто (FIX: перенести в справочник)
// ---------------------------------------------------------------
Route::get("/getCarsMarks", "AdvertController@getCarsMarks" );
Route::get("/getCarsModels", "AdvertController@getCarsModels" );

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




