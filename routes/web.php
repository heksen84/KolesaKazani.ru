<?php

use Illuminate\Http\Request;
use App\Helpers\Common;
//use App\SE_UserQueries;

// Роуты имеют приоритеты
Auth::routes();

Route::get('auth/vk', 'Auth\AuthController@redirectToVk');
Route::get('auth/vk/callback', 'Auth\AuthController@handleVkCallback');
Route::get('auth/ok', 'Auth\AuthController@redirectToOk');
Route::get('auth/ok/callback', 'Auth\AuthController@handleOkCallback');
Route::get('auth/insta', 'Auth\AuthController@redirectToInsta');
Route::get('auth/insta/callback', 'Auth\AuthController@handleInstaCallback');

// подвал
Route::get("/advert", function() { return view("advert"); });
Route::get("/rules", function() { return view("rules"); });
Route::get("/about", function() { return view("about"); });

// Блог
Route::get("/blog", "BlogController@showArticles");
Route::get("/blog/{articleId}", "BlogController@showArticle");

// Статьи
Route::get("/articles", "ArticlesController@showArticles");
Route::get("/articles/show/", "ArticlesController@showArticle");
Route::get("/articles/delete/", "ArticlesController@deleteArticle");
Route::get("/logout", "\App\Http\Controllers\Auth\LoginController@logout");
Route::get("/search", "IndexController@getResultsBySearchString");
Route::get("/moderator", "ModeratorController@showHomePage");

// детали объявления
Route::get("/objavlenie/show/{title}", "DetailsController@getDetails");
Route::get("/objavlenie/posted/{url}", "AdvertController@posted");
Route::get("/sitemap/test.xml", "SitemapController@getUrls");

/* 
------------------------------------------------------------------------------------------------------------------------
ПОДАЧА ОБЪЯВЛЕНИЯ ЧПУ: http://wd5.ru/tools/seo-url/
------------------------------------------------------------------------------------------------------------------------*/
// Подать объявление
Route::get("/podat-objavlenie", "AdvertController@new_advert");




Route::get("/adminPanel", "AdminController@login");
Route::get("/adminPanel/parseOlx", "AdminController@parseOlx");

// ----------------------------------------------
// Подать объявление бесплатно астана (45)
// Подать объявления алматы (207)
// Подать объявление павлодар (73)
// Подать объявление актобе(18)
// ----------------------------------------------
Route::get("/podat-obyavlenie-besplatno-astana", "AdvertController@podat_obyavlenie_besplatno_astana");
Route::get("/podat-obyavleniya-almaty", "AdvertController@podat_obyavleniya_almaty");
Route::get("/podat-obyavlenie-pavlodar", "AdvertController@podat_obyavlenie_pavlodar");
Route::get("/podat-obyavlenie-aktobe", "AdvertController@podat_obyavlenie_aktobe");

// Размещение по местоположению. Не двигать (ПРИОРИТЕТ!)
Route::get("/podat-obyavlenie-besplatno-{place}", "AdvertController@podat_obyavlenie_besplatno_in_place");
Route::get("/podat-obyavlenie-{place}", "AdvertController@podat_obyavlenie_in_place");
Route::get("/razmestit-obyavlenie-besplatno-{place}", "AdvertController@razmestit_obyavlenie_besplatno_in_place");
Route::get("/razmestit-obyavlenie-{place}", "AdvertController@razmestit_obyavlenie_in_place");

// ---------------------------------------------------------------
// AJAX API вызовы
// ---------------------------------------------------------------
Route::post("/api/createUser", "ApiController@createUser");
Route::post("/api/createAdvert", "ApiController@createAdvertFromFrontendRequest");
Route::post("/objavlenie/delete/{id}", "AdvertController@deleteAdvert"); // post
Route::get("/objavlenie/delete/{id}", "AdvertController@deleteAdvert"); // get
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

// Главная страница
Route::get("/", "IndexController@ShowIndexPage");
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