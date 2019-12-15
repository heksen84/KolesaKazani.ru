<?php

Auth::routes();

// api вызовы
Route::post("/api/createAdvert", "ApiController@createAdvert");
Route::get("/api/getSubCategoryNamesById", "ApiController@getSubCategoryNamesById" );
Route::get("/api/getRegions", "ApiController@GetRegions");
Route::get("/api/getPlaces", "ApiController@GetPlaces");
Route::get("/api/getCarsMarks", "ApiController@getCarsMarks" );
Route::get("/api/getCarsModels", "ApiController@getCarsModels" );

// По стране
Route::get("/", "IndexController@ShowCountryIndexPage");

// Новое объявление
Route::get("/podat-obyavlenie", "AdvertController@NewAd");

// По всему региону
Route::get("/{region}", "IndexController@ShowRegionIndexPage");

// По городу или селу
Route::get("/{region}/{place}", "IndexController@ShowPlaceIndexPage");

// Результаты по категориям по стране
Route::get("/category/{category}/{subcategory}", "ResultsController@getCountrySubCategoryResults");
// Результаты по категориям по региону
Route::get("/{region}/category/{category}/{subcategory}", "ResultsController@getRegionSubCategoryResults");
// Результаты по категориям по местности
Route::get("/{region}/{city}/category/{category}/{subcategory}", "ResultsController@getCitySubCategoryResults");

// Сервисы
Route::get("/util/str2url", "UtilsController@str2url");

