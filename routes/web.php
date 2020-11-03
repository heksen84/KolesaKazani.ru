<?php

Auth::routes();

Route::get('auth/vk', 'Auth\AuthController@redirectToVk');
Route::get('auth/vk/callback', 'Auth\AuthController@handleVkCallback');
Route::get('auth/ok', 'Auth\AuthController@redirectToOk');
Route::get('auth/ok/callback', 'Auth\AuthController@handleOkCallback');
Route::get('auth/insta', 'Auth\AuthController@redirectToInsta');
Route::get('auth/insta/callback', 'Auth\AuthController@handleInstaCallback');

// подвал
Route::get('/advert', function() { return view('advert'); });
Route::get('/rules', function() { return view('rules'); });
Route::get('/about', function() { return view('about'); });
Route::get('/blog', "BlogController@showArticles");
Route::get('/blog/{articleId}', "BlogController@showArticle");

Route::get('/logout', "\App\Http\Controllers\Auth\LoginController@logout");
Route::get('/search', "IndexController@getResultsBySearchString");

// Сервисы (было внизу)
Route::get("/moderator", "ModeratorController@showHomePage");

// детали объявления
Route::get("/objavlenie/show/{title}", "DetailsController@getDetails");
Route::get("/objavlenie/posted/{url}", "AdvertController@posted");

// Новое объявление
Route::get("/podat-objavlenie", "AdvertController@newAdvert");

// api вызовы
Route::post("/api/createAdvert", "ApiController@createAdvert");

// удалить объявление
Route::post("/objavlenie/delete/{id}", "AdvertController@deleteAdvert");
Route::get("/objavlenie/delete/{id}", "AdvertController@deleteAdvert");

Route::post("/objavlenie/makeExtend/{advert_id}/{adv_type}", "AdvertController@makeExtend");
Route::post("/objavlenie/makeComplaint/{advert_id}", "AdvertController@makeComplaint");

Route::get("/api/getSubCategoryNamesById", "ApiController@getSubCategoryNamesById" );
Route::get("/api/getRegions", "ApiController@GetRegions");
Route::get("/api/getPlaces", "ApiController@GetPlaces");
Route::get("/api/getCarsMarks", "ApiController@getCarsMarks" );
Route::get("/api/getCarsModels", "ApiController@getCarsModels" );
Route::get("/api/getPhoneNumber", "ApiController@getPhoneNumber" );
Route::get("/api/searchPlaceByString", "ApiController@searchPlaceByString" );
Route::post("/api/loadImage", "ApiController@loadImage" );
Route::post("/api/deleteImage/{storage_id}", "ApiController@deleteImage" );


/*Route::get("/c/auto/{mark}", "AutoResultsController@getCountryCategoryResults");
Route::get("{region}/c/auto/{mark}", "AutoResultsController@getCountryCategoryResults");
Route::get("{region}/{city}/c/auto/{mark}", "AutoResultsController@getCityCategoryResults");

Route::get("/c/auto/{mark}{model}", "AutoResultsController@getCountryCategoryResults");
Route::get("{region}/c/auto/{mark}{model}", "AutoResultsController@getCountryCategoryResults");
Route::get("{region}/{city}/c/auto/{mark}{model}", "AutoResultsController@getCityCategoryResults");*/


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
