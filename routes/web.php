<?php

Auth::routes();

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

// Сервисы (было внизу)
Route::get("/moderator", "ModeratorController@showHomePage");
Route::get("/util/str2url", "UtilsController@str2url");

// детали объявления
Route::get("/objavlenie/{id}", "AdvertController@getDetails");

// Новое объявление
Route::get("/search", "SearchController@search");

// Новое объявление
Route::get("/podat-obyavlenie", "AdvertController@NewAd");

// api вызовы
Route::post("/api/createAdvert", "ApiController@createAdvert");
Route::get("/api/getSubCategoryNamesById", "ApiController@getSubCategoryNamesById" );
Route::get("/api/getRegions", "ApiController@GetRegions");
Route::get("/api/getPlaces", "ApiController@GetPlaces");
Route::get("/api/getCarsMarks", "ApiController@getCarsMarks" );
Route::get("/api/getCarsModels", "ApiController@getCarsModels" );
Route::get("/api/getPhoneNumber", "ApiController@getPhoneNumber" );

// По стране
Route::get("/", "IndexController@ShowCountryIndexPage");

// мои объявления
Route::get("/home", "HomeController@ShowHomePage");

// Результаты по категориям по стране
Route::get("/category/{category}", "ResultsController@getCountryCategoryResults");
// Результаты по подкатегориям по стране
Route::get("/category/{category}/{subcategory}", "ResultsController@getCountrySubCategoryResults");
// Результаты по подкатегориям по региону
Route::get("/{region}/category/{category}/{subcategory}", "ResultsController@getRegionSubCategoryResults");
// Результаты по подкатегориям по местности
Route::get("/{region}/{city}/category/{category}/{subcategory}", "ResultsController@getCitySubCategoryResults");

// По всему региону
Route::get("/{region}", "IndexController@ShowRegionIndexPage");
// По городу или селу
Route::get("/{region}/{place}", "IndexController@ShowPlaceIndexPage");