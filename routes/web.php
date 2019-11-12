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
Route::get("transport/{type}", 	  	"TransportResultsController@getResultsByCategoryForView");
Route::get("nedvizhimost/{type}", 	"NedvizhimostResultsController@getResultsByCategoryForView");
Route::get("elektronika/{type}", 	"ElektronikaResultsController@getResultsByCategoryForView");
Route::get("rabota-i-biznes/{type}", 	"Rabota-i-biznesResultsController@getResultsByCategoryForView");
Route::get("dlya-doma-i-dachi/{type}",	"Dlya-doma-i-dachiResultsController@getResultsByCategoryForView");
Route::get("lichnye-veschi/{type}", 	"Lichnye-veschiResultsController@getResultsByCategoryForView");
Route::get("zhivotnye/{type}", 		"ZhivotnyeResultsController@getResultsByCategoryForView");
Route::get("hobbi-i-otdyh/{type}", 	"Hobbi-i-otdyhResultsController@getResultsByCategoryForView");
Route::get("uslugi/{type}", 		"UslugiResultsController@getResultsByCategoryForView");
Route::get("drugoe/{type}", 		"DrugoeResultsController@getResultsByCategoryForView");

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




