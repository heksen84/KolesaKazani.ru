<?php

Auth::routes();

/*Route::get('facebook', function () {
    return view('facebookAuth');
});*/

Route::get('auth/vk', 'Auth\AuthController@redirectToVk');
Route::get('auth/vk/callback', 'Auth\AuthController@handleVkCallback');

Route::get('auth/ok', 'Auth\AuthController@redirectToOk');
Route::get('auth/ok/callback', 'Auth\AuthController@handleOkCallback');

// подвал
Route::get('/advert', function() { return view('advert'); });
Route::get('/rules', function() { return view('rules'); });
Route::get('/about', function() { return view('about'); });

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

// Сервисы (было внизу)
Route::get("/moderator", "ModeratorController@showHomePage");
Route::get("/util/str2url", "UtilsController@str2url");

// детали объявления
Route::get("/objavlenie/show/{id}", "AdvertController@getDetails");

// Новое объявление
Route::get("/podat-objavlenie", "AdvertController@newAdvert");

// api вызовы
Route::post("/api/createAdvert", "ApiController@createAdvert");

// удалить объявление
Route::post("/objavlenie/delete/{id}", "AdvertController@deleteAdvert");
Route::get("/objavlenie/delete/{id}", "AdvertController@deleteAdvert");

Route::post("/objavlenie/makeExtend/{advert_id}/{adv_type}", "AdvertController@makeExtend");

Route::get("/api/getSubCategoryNamesById", "ApiController@getSubCategoryNamesById" );
Route::get("/api/getRegions", "ApiController@GetRegions");
Route::get("/api/getPlaces", "ApiController@GetPlaces");
Route::get("/api/getCarsMarks", "ApiController@getCarsMarks" );
Route::get("/api/getCarsModels", "ApiController@getCarsModels" );
Route::get("/api/getPhoneNumber", "ApiController@getPhoneNumber" );
Route::get("/api/searchPlaceByString", "ApiController@searchPlaceByString" );

// По стране
Route::get("/", "IndexController@ShowCountryIndexPage");
// мои объявления
Route::get("/home", "HomeController@ShowHomePage");

// Результаты по категориям по стране
Route::get("/c/{category}", "ResultsController@getCountryCategoryResults");
// Результаты по категориям по региону
Route::get("{region}/c/{category}", "ResultsController@getRegionCategoryResults");

// Результаты по категориям по месту
Route::get("{region}/{place}/c/{category}", "ResultsController@getCityCategoryResults");
// Результаты по подкатегориям по стране
Route::get("/c/{category}/{subcategory}", "ResultsController@getCountrySubCategoryResults");
// Результаты по подкатегориям по региону
Route::get("/{region}/c/{category}/{subcategory}", "ResultsController@getRegionSubCategoryResults");
// Результаты по подкатегориям по местности
Route::get("/{region}/{city}/c/{category}/{subcategory}", "ResultsController@getCitySubCategoryResults");

// По всему региону
Route::get("/{region}", "IndexController@ShowRegionIndexPage");
// По городу или селу
Route::get("/{region}/{place}", "IndexController@ShowPlaceIndexPage");
