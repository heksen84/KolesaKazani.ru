<?php
Auth::routes();

// api вызовы
Route::post("api/createAdvert", "AdvertController@createAdvert");
Route::get("api/getSubCategoryNamesById", "JournalController@getSubCategoryNamesById" );
Route::get("api/getPlaces", "JournalController@GetPlaces");
Route::get("api/getCarsMarks", "JournalController@getCarsMarks" );
Route::get("api/getCarsModels", "JournalController@getCarsModels" );


// По стране
Route::get("/", "IndexController@ShowCountryIndexPage");
Route::get("{lang}/", "IndexController@ShowCountryIndexPage");

// Новое объявление
Route::get("{lang}/podat-obyavlenie", "AdvertController@NewAd");

// По всему региону
Route::get("{lang}/{region}", "IndexController@ShowRegionIndexPage");
// По городу или селу
Route::get("{lang}/{region}/{place}", "IndexController@ShowPlaceIndexPage");


// Результаты по категориям по стране
Route::get("{lang}/category/{category}/{subcategory}", "ResultsController@getCountrySubCategoryResults");
// Результаты по категориям по региону
Route::get("{lang}/{region}/category/{category}/{subcategory}", "ResultsController@getRegionSubCategoryResults");
// Результаты по категориям по местности
Route::get("{lang}/{region}/{city}/category/{category}/{subcategory}", "ResultsController@getCitySubCategoryResults");

// Сервисы
Route::get("/util/str2url", "UtilsController@str2url");

