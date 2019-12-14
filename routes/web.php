<?php
Auth::routes();

// api вызовы
Route::post("{country}/api/createAdvert", "AdvertController@createAdvert");
Route::get("{country}/api/getSubCategoryNamesById", "JournalController@getSubCategoryNamesById" );
Route::get("{country}/api/getRegions", "JournalController@GetRegions");
Route::get("{country}/api/getPlaces", "JournalController@GetPlaces");
Route::get("{country}/api/getCarsMarks", "JournalController@getCarsMarks" );
Route::get("{country}/api/getCarsModels", "JournalController@getCarsModels" );


// По стране
Route::get("/", "IndexController@ShowCountryIndexPage");

Route::get("{country}/", "IndexController@ShowCountryIndexPage");

// Новое объявление
Route::get("{country}/{language}/podat-obyavlenie", "AdvertController@NewAd");

// По всему региону
Route::get("{country}/{region}", "IndexController@ShowRegionIndexPage");
// По городу или селу
Route::get("{country}/{region}/{place}", "IndexController@ShowPlaceIndexPage");


// Результаты по категориям по стране
Route::get("{country}/{language}/category/{category}/{subcategory}", "ResultsController@getCountrySubCategoryResults");
// Результаты по категориям по региону
Route::get("{country}/{language}/{region}/category/{category}/{subcategory}", "ResultsController@getRegionSubCategoryResults");
// Результаты по категориям по местности
Route::get("{country}/{language}/{region}/{city}/category/{category}/{subcategory}", "ResultsController@getCitySubCategoryResults");

// Сервисы
Route::get("/util/str2url", "UtilsController@str2url");

