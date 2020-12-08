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

// Блог
Route::get('/blog', "BlogController@showArticles");
Route::get('/blog/{articleId}', "BlogController@showArticle");

// Статьи
Route::get("/articles", "ArticlesController@showArticles");
Route::get("/articles/show/", "ArticlesController@showArticle");
Route::get("/articles/delete/", "ArticlesController@deleteArticle");

Route::get('/logout', "\App\Http\Controllers\Auth\LoginController@logout");
Route::get('/search', "IndexController@getResultsBySearchString");

// Сервисы (было внизу)
Route::get("/moderator", "ModeratorController@showHomePage");

// детали объявления
Route::get("/objavlenie/show/{title}", "DetailsController@getDetails");
Route::get("/objavlenie/posted/{url}", "AdvertController@posted");

/* 
----------------------------------------------------------------------------------------------------------------------------------------------
ПОДАЧА ОБЪЯВЛЕНИЯ
----------------------------------------------------------------------------------------------------------------------------------------------*/

// SEO URL генератор/транслятор в ЧПУ (человеко понятный урл)
// http://wd5.ru/tools/seo-url/


// razmeshenye.xml <-- sitemap

// --поиск--
// поиск работы подать объявление бесплатное
// поиск людей подать объявление
// поиск новых объявлений

// --найти--
// подать объявление найти работу
// новые объявления найти работу


//--новые объявления--
//новые объявления квартир
//новые объявления купить

// подать объявление
Route::get("/podat-objavlenie", "AdvertController@new_advert");
// подать бесплатно объявление о работе в кз
Route::get("/podat-besplatno-objavlenye-o-rabote-v-kz", "AdvertController@podat_besplatno_obyavlenie_o_rabote_v_kz");
// подать бесплатное объявление в усть каменогорске
Route::get("/podat-besplatnoe-objavlenye-v-ust-kamenogorske", "AdvertController@podat_besplatnoe_obyavlenie_v_ust_kamenogorske");

// подать бесплатное объявление продажа гаража
Route::get("/podat-besplatnoe-obyavlenie-prodazha-garazha", "AdvertController@podat_besplatnoe_obyavlenie_prodazha_garazha");
// подать бесплатные объявления аренда квартир
Route::get("/podat-besplatnye-obyavleniya-arenda-kvartir", "AdvertController@podat_besplatnye_obyavleniya_arenda_kvartir");
// подать детское объявление
Route::get("/podat-detskoe-obyavlenie", "AdvertController@podat_detskoe_obyavlenie");
// подать объявление авто пробегом
Route::get("/podat-obyavlenie-avto-probegom", "AdvertController@podat_obyavlenie_avto_probegom");
// подать объявление аренда
Route::get("/podat-obyavlenie-arenda", "AdvertController@podat_obyavlenie_arenda");
// подать объявление бесплатно в области
Route::get("/podat-obyavlenie-besplatno-v-oblasti", "AdvertController@podat_obyavlenie_besplatno_v_oblasti");
// подать объявление в газету работа
Route::get("/podat-obyavlenie-v-gazetu-rabota", "AdvertController@podat_obyavlenie_v_gazetu_rabota");
// подать объявление в рубрике
Route::get("/podat-obyavlenie-v-rubrike", "AdvertController@podat_obyavlenie_v_rubrike");
// подать объявление в усть каменогорске
Route::get("/podat-obyavlenie-v-ust-kamenogorske", "AdvertController@podat_obyavlenie_v_ust_kamenogorske");

// подать объявление инфо
// подать объявление мясо
// подать объявление на продавца
// подать объявление на продажу дома бесплатно
// подать объявление найти работу
// подать объявление насчет работы
// подать объявление о наборе сотрудников
// подать объявление о наборе сотрудников бесплатно
// подать объявление о продаже авто бесплатно
// подать объявление о продаже автомобиля бесплатно
// подать объявление о продаже б у
// подать объявление о продаже дачи
// подать объявление о продаже машины
// подать объявление о продаже недвижимости
// подать объявление о продаже шин
// подать объявление о пропаже документов
// подать объявление бесплатно в караганде
// подать объявление о сдаче квартиры в аренду
// подать объявление об аренде квартиры
// подать объявление куплю
// подать объявление о работе бесплатно
// подать объявление об услугах бесплатно
// подать объявление онлайн
// подать объявление по английскому
// подать объявление продажа телефона
// подать объявление продажа техника
// подать объявление продажа щенков
// подать объявление продать авто
// подать объявление ремонт квартиры
// подать объявление сантехник
// подать объявление сантехника
// подать объявление строительные
// подать объявление услуги электрика
// подать объявления бытовой техники
// подать объявления доска бесплатных объявлений
// подать объявления строительных работ
// подать объявления электрика
// подать платное объявление
// сервис разместить объявление
// сиделка подать объявление
// стройка подать объявление
// хочу купить подать объявление
// юридические услуги подать объявление
// акжайык подать объявление
// газета срочно подать объявление
// газеты области подать объявления
// нурсултан подать объявление на продажу автомобиля
// работа в интернете разместить объявление
// работа частные объявления подать
// разместить объявление бесплатно и без регистрации
// разместить объявление о продаже
// разместить объявление о работе
// разместить объявление о работе бесплатно
// ...

// api вызовы
Route::post("/api/createUser", "ApiController@createUser");
Route::post("/api/createAdvert", "ApiController@createAdvert");

// удалить объявление
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
