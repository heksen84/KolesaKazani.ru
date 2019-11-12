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
Route::get("transport/{type}", 	  	"ResultsController@getResultsByCategoryForView123");
Route::get("nedvizhimost/{type}", 	"ResultsController@getResultsByCategoryForView");
Route::get("elektronika/{type}", 	"ResultsController@getResultsByCategoryForView");
Route::get("rabota-i-biznes/{type}", 	"ResultsController@getResultsByCategoryForView");
Route::get("dlya-doma-i-dachi/{type}",	"ResultsController@getResultsByCategoryForView");
Route::get("lichnye-veschi/{type}", 	"ResultsController@getResultsByCategoryForView");
Route::get("zhivotnye/{type}", 		"ResultsController@getResultsByCategoryForView");
Route::get("hobbi-i-otdyh/{type}", 	"ResultsController@getResultsByCategoryForView");
Route::get("uslugi/{type}", 		"ResultsController@getResultsByCategoryForView");
Route::get("drugoe/{type}", 		"ResultsController@getResultsByCategoryForView");

// ---------------------------------------------------------------
// Авто (FIX: перенести в справочник
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




