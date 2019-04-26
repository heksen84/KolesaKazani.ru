<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Auth::routes(); // Стандартные роуты

// -------------------------------------------------------------------------------
// Результаты по категориям по всему Казахстану
// -------------------------------------------------------------------------------
Route::get("transport", 		"ResultsController@getResultsByCategoryForView");
Route::get("nedvizhimost", 		"ResultsController@getResultsByCategoryForView");
Route::get("elektronika", 		"ResultsController@getResultsByCategoryForView");
Route::get("rabota-i-biznes", 	"ResultsController@getResultsByCategoryForView");
Route::get("dlya-doma-i-dachi",	"ResultsController@getResultsByCategoryForView");
Route::get("lichnye-veschi", 	"ResultsController@getResultsByCategoryForView");
Route::get("zhivotnye", 		"ResultsController@getResultsByCategoryForView");
Route::get("hobbi-i-otdyh", 	"ResultsController@getResultsByCategoryForView");
Route::get("uslugi", 			"ResultsController@getResultsByCategoryForView");
Route::get("drugoe", 			"ResultsController@getResultsByCategoryForView");

// Результаты категории по региону
Route::get("{region}/elektronika",  	 "ResultsController@getResultsByRegionForView");
Route::get("{region}/rabota-i-biznes",   "ResultsController@getResultsByRegionForView");
Route::get("{region}/dlya-doma-i-dachi", "ResultsController@getResultsByRegionForView");
Route::get("{region}/lichnye-veschi",  	 "ResultsController@getResultsByRegionForView");
Route::get("{region}/zhivotnye",  	 	 "ResultsController@getResultsByRegionForView");
Route::get("{region}/hobbi-i-otdyh",  	 "ResultsController@getResultsByRegionForView");
Route::get("{region}/uslugi",  	 	 	 "ResultsController@getResultsByRegionForView");
Route::get("{region}/drugoe",  	 	 	 "ResultsController@getResultsByRegionForView");

Route::get("/getResultsByRegionForFront", "ResultsController@getResultsByRegionForFront");

// Результаты по региону с подкатегориями
Route::get("{region}/transport/{subcat}", 		"ResultsController@getResultsByRegionWithSubCategoryForView");
Route::get("{region}/nedvizhimost/{subcat}",	"ResultsController@getResultsByRegionWithSubCategoryForView");

// Категории по местности
Route::get("{region}/{place}/transport",  		 "ResultsController@getResultsByPlaceForView");
Route::get("{region}/{place}/elektronika",  	 "ResultsController@getResultsByPlaceForView");
Route::get("{region}/{place}/rabota-i-biznes",   "ResultsController@getResultsByPlaceForView");
Route::get("{region}/{place}/dlya-doma-i-dachi", "ResultsController@getResultsByPlaceForView");
Route::get("{region}/{place}/lichnye-veschi",  	 "ResultsController@getResultsByPlaceForView");
Route::get("{region}/{place}/zhivotnye",  	 	 "ResultsController@getResultsByPlaceForView");
Route::get("{region}/{place}/hobbi-i-otdyh",  	 "ResultsController@getResultsByPlaceForView");
Route::get("{region}/{place}/uslugi",  	 	 	 "ResultsController@getResultsByPlaceForView");
Route::get("{region}/{place}/drugoe",  	 	 	 "ResultsController@getResultsByPlaceForView");

// Категории по местности c подкатегориями
Route::get("{region}/{place}/transport/{subcat}", 	  	"ResultsController@getResultsByPlaceForWithSubCategoryForView");
Route::get("{region}/{place}/nedvizhimost/{subcat}",  	"ResultsController@getResultsByPlaceForWithSubCategoryForView");
Route::get("/getResultsByPlaceWithSubCategoryForFront", "ResultsController@getResultsByPlaceWithSubCategoryForFront");

// ------------------------------------------------------------------------
// Детали объявления
// ------------------------------------------------------------------------
Route::get("obyavlenie/{url}", "AdvertController@getFullInfoByUrl"); // для СЕО
Route::get("podrobno/{id}", "AdvertController@getFullInfo");

// ------------------------------------------------------------------------------------------------------------
// Подкатегории
// ------------------------------------------------------------------------------------------------------------
Route::get("{category}/{subcat}", "ResultsController@getResultsForSubCategoryForView");
Route::get("/getResultsByCategoryForFront", "ResultsController@getResultsByCategoryForFront");
Route::get("/getResultsBySubCategory/{category}/{subcat}", "ResultsController@getResultsForSubCategoryForView");
Route::get("/getResultsBySubCategoryForFront", "ResultsController@getResultsForSubCategoryForFront");
Route::get("/getResultsByPlaceForFront", "ResultsController@getResultsByPlaceForFront");

// ---------------------------------------------------------------
// Базовые контроллеры
// ---------------------------------------------------------------
Route::get("/", 				"IndexController@init");
Route::post("create", 			"AdvertController@createAdvert");
Route::get("home",	 		 	"CabinetController@index");
Route::get("home/{advert_id}",	"CabinetController@index");
Route::get("podat-obyavlenie", 	"AdvertController@newAdvert");
Route::get("getRegions", 		"IndexController@getRegions");
Route::get("getPlaces", 		"IndexController@getPlaces");
Route::get("getUser", 			"UserController@getUser");
Route::get("categories", 		"CategoriesController@index");
Route::get("getSubCats",  		"SubCatsController@getSubCats" );

// ---------------------------------------------------------------
// Авто
// ---------------------------------------------------------------
Route::get("getCarsMarks", "AdvertController@getCarsMarks" );
Route::get("getCarsModels", "AdvertController@getCarsModels" );

// Поиск
Route::get("search", "ResultsController@searchForView" );
Route::get("getSearchResults", "ResultsController@searchForFront" );

// --------------------------------------------------------------------
// Перенести в контроллер Categories
// --------------------------------------------------------------------
Route::get("/category/{id}", function ($id) {
	$categories = DB::table("categories")->where("id", $id)->get();
	$items = DB::table("adverts")->where("category_id", $id)->get();
	return view("results")->with("items", $items )->with("category_id", $id )->with("category_name", mb_strtolower($categories[0]->name));
});

Route::get("getResults", "ResultsController@getResultsByCategory");
Route::get("location/{country}/{region}/{place}", "AdvertController@getFullInfo");
Route::get("logout", "\App\Http\Controllers\Auth\LoginController@logout");

// ------------------------------------------------------------------------
// Категории по региону и местности
// ------------------------------------------------------------------------
Route::get("{region}/{place}/{category}", "ResultsController@getResultsByPlace");

// ------------------------------------------------------------------------
// Футер
// ------------------------------------------------------------------------
Route::get("advertisers", function () { return view("advertisers"); }); // Реклама
Route::get("about", function () { return view("about"); }); // О сайте...

// Вспомогательные методы
Route::get("getCategoryCountById", "WelcomeController@getCategoryCountById");
Route::get("getCategoryCounts", "WelcomeController@getCategoryCounts");

/*
------------------------------------------------------------------------------------------------
 Панель администратора
------------------------------------------------------------------------------------------------*/
Route::get("panels/admin", "AdminController@login");
Route::get("moderation",  function () { return view("moderation"); });
Route::get("moderation/{advert_id}",  function () { return view("moderation_advert"); });

// -----------------------------------------------------------
// Сервисы
// -----------------------------------------------------------
Route::get("test",  function () { return view("test"); });
Route::post("checkPhotos", "TestController@checkPhotos");
Route::get("/util/str2url", "UtilsController@str2url");