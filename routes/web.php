<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// Стандартные роуты
Auth::routes();

// Сервисы
Route::get("/util/str2url", "UtilsController@str2url");
Route::get("isUserAuth", "UserController@isUserAuth");

// index page
Route::get("/", "IndexController@showIndexPage");
Route::get("/kazakhstan", "IndexController@showIndexPage");
Route::get("/qazaqstan", "IndexController@showIndexPage");
