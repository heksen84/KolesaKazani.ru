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
Route::get("/api/getCarsMarks", "ApiController@getCarsMarks" );
Route::get("/api/getCarsModels", "ApiController@getCarsModels" );
Route::get("/api/getPhoneNumber", "ApiController@getPhoneNumber" );
Route::get("/api/searchPlaceByString", "ApiController@searchPlaceByString" );
Route::post("/api/loadImage", "ApiController@loadImage" );
Route::post("/api/deleteImage/{storage_id}", "ApiController@deleteImage" );


// Главная страница
Route::get("/", "IndexController@ShowIndexPage");
// мои объявления
Route::get("/home", "HomeController@ShowHomePage");

// Результаты
Route::get("/cars/{mark}", "ResultsController@getCarsMarks");
Route::get("/cars/{mark}/{model}", "ResultsController@getCarsModels");