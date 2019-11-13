<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// ВНИМАНИЕ!: Присутсвует приоритет роутов

Auth::routes(); // Стандартные роуты

Route::get("/getSubCategoryDataById", "AdvertController@getSubCategoryDataById" );

Route::post("createAdvert",  "AdvertController@createAdvert");


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
Route::get("transport/{type}", 	  	"TransportResultsController@getTransportResultsByCountryForView");
Route::get("nedvizhimost/{type}", 	"RealestateResultsController@getRealestateResultsByCountryForView");
Route::get("elektronika/{type}", 	"ElektronikaResultsController@getTransportResultsByCountryForView");
Route::get("rabota-i-biznes/{type}", 	"Rabota-i-biznesResultsController@getTransportResultsByCountryForView");
Route::get("dlya-doma-i-dachi/{type}",	"Dlya-doma-i-dachiResultsController@getTransportResultsByCountryForView");
Route::get("lichnye-veschi/{type}", 	"Lichnye-veschiResultsController@getTransportResultsByCountryForView");
Route::get("zhivotnye/{type}", 		"ZhivotnyeResultsController@getTransportResultsByCountryForView");
Route::get("hobbi-i-otdyh/{type}", 	"Hobbi-i-otdyhResultsController@getTransportResultsByCountryForView");
Route::get("uslugi/{type}", 		"UslugiResultsController@getTransportResultsByCountryForView");
Route::get("drugoe/{type}", 		"DrugoeResultsController@getTransportResultsByCountryForView");

// ---------------------------------------------------------------
// Авто (FIX: перенести в справочник)
// ---------------------------------------------------------------
Route::get("/getCarsMarks", "AdvertController@getCarsMarks" );
Route::get("/getCarsModels", "AdvertController@getCarsModels" );

// Новое объявление
Route::get("/podat-obyavlenie", "AdvertController@NewAd");

// Сервисы
Route::get("/util/str2url", "UtilsController@str2url");
Route::get("/getPlaces", "IndexController@GetPlaces");

// По стране
Route::get("/", "IndexController@ShowCountryIndexPage");
Route::get("/kazakhstan", "IndexController@ShowCountryIndexPage");
Route::get("/qazaqstan", "IndexController@ShowCountryIndexPage");

// По всему региону
Route::get("/{region}", "IndexController@ShowRegionIndexPage");

// По городу или селу
Route::get("/{region}/{place}", "IndexController@ShowPlaceIndexPage");




