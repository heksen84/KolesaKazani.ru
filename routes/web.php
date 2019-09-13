<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// ВНИМАНИЕ: Присутсвует приоритет роутов

// Стандартные роуты
Auth::routes();

// ---------------------------------------------------------------
// Авто
// ---------------------------------------------------------------
Route::get("/getCarsMarks", "AdvertController@getCarsMarks" );
Route::get("/getCarsModels", "AdvertController@getCarsModels" );


// Новое объявление
Route::get("/podat-obyavlenie", "AdvertController@NewAd");

// Сервисы
Route::get("/util/str2url", "UtilsController@str2url");
Route::get("/getPlaces", "IndexController@GetPlaces");

// По стране
Route::get("/", "IndexController@ShowCountryIndexPage");
Route::get("/kazakhstan", "IndexController@ShowCountryIndexPage");
Route::get("/qazaqstan", "IndexController@ShowCountryIndexPage");

// По всему региону
Route::get("/{region}", "IndexController@ShowRegionIndexPage");

// По городу или селу
Route::get("/{region}/{place}", "IndexController@ShowPlaceIndexPage");




