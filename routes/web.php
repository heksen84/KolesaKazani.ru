<?php
Auth::routes();

// api вызовы
Route::post("{lang}/api/createAdvert", "AdvertController@createAdvert");
Route::get("{lang}/api/getSubCategoryNamesById", "JournalController@getSubCategoryNamesById" );
Route::get("{lang}/api/getPlaces", "JournalController@GetPlaces");
Route::get("{lang}/api/getCarsMarks", "JournalController@getCarsMarks" );
Route::get("{lang}/api/getCarsModels", "JournalController@getCarsModels" );


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

