<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Auth::routes();

// api вызовы
Route::post("api/createAdvert", "AdvertController@createAdvert");
Route::get("api/getSubCategoryNamesById", "JournalController@getSubCategoryNamesById" );
Route::get("api/getPlaces", "JournalController@GetPlaces");
Route::get("api/getCarsMarks", "JournalController@getCarsMarks" );
Route::get("api/getCarsModels", "JournalController@getCarsModels" );


// Результаты по категориям по стране
Route::get("{category}/{subcategory}", "ResultsController@getCountrySubCategoryResults");

// Результаты по категориям по региону
Route::get("{region}/{category}/{subcategory}", "ResultsController@getRegionSubCategoryResults");

// Результаты по категориям по местности
Route::get("{region}/{city}/{category}/{subcategory}", "ResultsController@getCitySubCategoryResults");


// Новое объявление
Route::get("/podat-obyavlenie", "AdvertController@NewAd");
// Сервисы
Route::get("/util/str2url", "UtilsController@str2url");


// По стране
Route::get("/", "IndexController@ShowCountryIndexPage");
// По всему региону
Route::get("/{region}", "IndexController@ShowRegionIndexPage");
// По городу или селу
Route::get("/{region}/{place}", "IndexController@ShowPlaceIndexPage");




