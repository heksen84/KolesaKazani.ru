<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Стандартные роуты
Auth::routes();

// Сервисы
Route::get("/util/str2url", "UtilsController@str2url");

// По стране
Route::get("/", "IndexController@ShowIndexPage");
Route::get("/kazakhstan", "IndexController@ShowIndexPage");
Route::get("/qazaqstan", "IndexController@ShowIndexPage");

// По всему региону
Route::get("/{region}", "IndexController@ShowIndexPage");

// По городу или селу
Route::get("/{region}/{place}", "IndexController@ShowIndexPage");
