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
------------------------------------------------------------------------------------------------------------------------

ПОДАЧА ОБЪЯВЛЕНИЯ 
ЧПУ: http://wd5.ru/tools/seo-url/

------------------------------------------------------------------------------------------------------------------------*/
// --------------------------------------------------------------------------------------------------------
// Размещение по местоположению. 
// Роуты имеют приоритеты
// --------------------------------------------------------------------------------------------------------
Route::get("/podat-obyavlenie-besplatno-{place}", "AdvertController@podat_obyavlenie_besplatno_in_place");
Route::get("/podat-obyavlenie-{place}", "AdvertController@podat_obyavlenie_in_place");
Route::get("/razmestit-obyavlenie-besplatno-{place}", "AdvertController@razmestit_obyavlenie_besplatno_in_place");
Route::get("/razmestit-obyavlenie-{place}", "AdvertController@razmestit_obyavlenie_in_place");

// Подать объявление
Route::get("/podat-objavlenie", "AdvertController@new_advert");
// Подать бесплатно объявление о работе в кз
Route::get("/podat-besplatno-objavlenye-o-rabote-v-kz", "AdvertController@podat_besplatno_obyavlenie_o_rabote_v_kz");
// Подать бесплатное объявление в усть каменогорске
Route::get("/podat-besplatnoe-objavlenye-v-ust-kamenogorske", "AdvertController@podat_besplatnoe_obyavlenie_v_ust_kamenogorske");
// Подать бесплатное объявление продажа гаража
Route::get("/podat-besplatnoe-obyavlenie-prodazha-garazha", "AdvertController@podat_besplatnoe_obyavlenie_prodazha_garazha");
// Подать бесплатные объявления аренда квартир
Route::get("/podat-besplatnye-obyavleniya-arenda-kvartir", "AdvertController@podat_besplatnye_obyavleniya_arenda_kvartir");
// Подать детское объявление
Route::get("/podat-detskoe-obyavlenie", "AdvertController@podat_detskoe_obyavlenie");
// Подать объявление авто пробегом
Route::get("/podat-obyavlenie-avto-probegom", "AdvertController@podat_obyavlenie_avto_probegom");
// Подать объявление аренда
Route::get("/podat-obyavlenie-arenda", "AdvertController@podat_obyavlenie_arenda");
// Подать объявление бесплатно в области
Route::get("/podat-obyavlenie-besplatno-v-oblasti", "AdvertController@podat_obyavlenie_besplatno_v_oblasti");
// Подать объявление в газету работа
Route::get("/podat-obyavlenie-v-gazetu-rabota", "AdvertController@podat_obyavlenie_v_gazetu_rabota");
// Подать объявление в рубрике
Route::get("/podat-obyavlenie-v-rubrike", "AdvertController@podat_obyavlenie_v_rubrike");
// Подать объявление в усть каменогорске
Route::get("/podat-obyavlenie-v-ust-kamenogorske", "AdvertController@podat_obyavlenie_v_ust_kamenogorske");
// Подать объявление инфо
Route::get("/podat-obyavlenie-info", "AdvertController@podat_obyavlenie_info");
// Подать объявление мясо
Route::get("/podat-obyavlenie-myaso", "AdvertController@podat_obyavlenie_myaso");
// Подать объявление на продавца
Route::get("/podat-obyavlenie-na-prodavca", "AdvertController@podat_obyavlenie_na_prodavca");
// Подать объявление на продажу дома бесплатно
Route::get("/podat-obyavlenie-na-prodazhu-doma-besplatno", "AdvertController@podat_obyavlenie_na_prodazhu_doma_besplatno");
// Подать объявление найти работу
Route::get("/podat-obyavlenie-nayti-rabotu", "AdvertController@podat_obyavlenie_nayti_rabotu");
// Подать объявление насчет работы
Route::get("/podat-obyavlenie-naschet-raboty", "AdvertController@podat_obyavlenie_naschet_raboty");
// Подать объявление о наборе сотрудников
Route::get("/podat-obyavlenie-o-nabore-sotrudnikov", "AdvertController@podat_obyavlenie_o_nabore_sotrudnikov");
// Подать объявление о наборе сотрудников бесплатно
Route::get("/podat-obyavlenie-o-nabore-sotrudnikov-besplatno", "AdvertController@podat_obyavlenie_o_nabore_sotrudnikov_besplatno");
// Подать объявление о продаже авто бесплатно
Route::get("/podat-obyavlenie-o-prodazhe-avto-besplatno", "AdvertController@podat_obyavlenie_o_prodazhe_avto_besplatno");
// Подать объявление о продаже автомобиля бесплатно
Route::get("/podat-obyavlenie-o-prodazhe-avtomobilya-besplatno", "AdvertController@podat_obyavlenie_o_prodazhe_avtomobilya_besplatno");
// Подать объявление о продаже б у
Route::get("/podat-obyavlenie-o-prodazhe-b-u", "AdvertController@podat_obyavlenie_o_prodazhe_b_u");
// Подать объявление о продаже дачи
Route::get("/podat-obyavlenie-o-prodazhe-dachi", "AdvertController@podat_obyavlenie_o_prodazhe_dachi");
// Подать объявление о продаже машины
Route::get("/podat-obyavlenie-o-prodazhe-mashiny", "AdvertController@podat_obyavlenie_o_prodazhe_mashiny");
// Подать объявление о продаже недвижимости
Route::get("/podat-obyavlenie-o-prodazhe-nedvizhimosti", "AdvertController@podat_obyavlenie_o_prodazhe_nedvizhimosti");
// Подать объявление о продаже шин
Route::get("/podat-obyavlenie-o-prodazhe-shin", "AdvertController@podat_obyavlenie_o_prodazhe_shin");
// Подать объявление о пропаже документов
Route::get("/podat-obyavlenie-o-propazhe-dokumentov", "AdvertController@podat_obyavlenie_o_propazhe_dokumentov");
// Подать объявление бесплатно в караганде
Route::get("/podat-obyavlenie-besplatno-v-karagande", "AdvertController@podat_obyavlenie_besplatno_v_karagande");
// Подать объявление о сдаче квартиры в аренду
Route::get("/podat-obyavlenie-o-sdache-kvartiry-v-arendu", "AdvertController@podat_obyavlenie_o_sdache_kvartiry_v_arendu");
// Подать объявление об аренде квартиры
Route::get("/podat-obyavlenie-ob-arende-kvartiry", "AdvertController@podat_obyavlenie_ob_arende_kvartiry");
// Подать объявление куплю
Route::get("/podat-obyavlenie-kuplyu", "AdvertController@podat_obyavlenie_kuplyu");
// Подать объявление о работе бесплатно
Route::get("/podat-obyavlenie-o-rabote-besplatno", "AdvertController@podat_obyavlenie_o_rabote_besplatno");
// Подать объявление об услугах бесплатно
Route::get("/podat-obyavlenie-ob-uslugah-besplatno", "AdvertController@podat_obyavlenie_ob_uslugah_besplatno");
// Подать объявление онлайн
Route::get("/podat-obyavlenie-onlayn", "AdvertController@podat_obyavlenie_onlayn");
// Подать объявление по английскому
Route::get("/podat-obyavlenie-po-angliyskomu", "AdvertController@podat_obyavlenie_po_angliyskomu");
// Подать объявление продажа телефона
Route::get("/podat-obyavlenie-prodazha-telefona", "AdvertController@podat_obyavlenie_prodazha_telefona");
// Подать объявление продажа техника
Route::get("/podat-obyavlenie-prodazha-tehnika", "AdvertController@podat_obyavlenie_prodazha_tehnika");
// Подать объявление продажа щенков
Route::get("/podat-obyavlenie-prodazha-shchenkov", "AdvertController@podat_obyavlenie_prodazha_shchenkov");
// Подать объявление продать авто
Route::get("/podat-obyavlenie-prodat-avto", "AdvertController@podat_obyavlenie_prodat_avto");
// Подать объявление ремонт квартиры
Route::get("/podat-obyavlenie-remont-kvartiry", "AdvertController@podat_obyavlenie_remont_kvartiry");
// Подать объявление сантехник
Route::get("/podat-obyavlenie-santehnik", "AdvertController@podat_obyavlenie_santehnik");
// Подать объявление сантехника
Route::get("/podat-obyavlenie-santehnika", "AdvertController@podat_obyavlenie_santehnika");
// Подать объявление строительные
Route::get("/podat-obyavlenie-stroitelnye", "AdvertController@podat_obyavlenie_stroitelnye");
// Подать объявление услуги электрика
Route::get("/podat-obyavlenie-uslugi-elektrika", "AdvertController@podat_obyavlenie_uslugi_elektrika");
// Подать объявления бытовой техники
Route::get("/podat-obyavleniya-bytovoy-tehniki", "AdvertController@podat_obyavleniya_bytovoy_tehniki");
// Подать объявления доска бесплатных объявлений
Route::get("/podat-obyavleniya-doska-besplatnyh-obyavleniy", "AdvertController@podat_obyavleniya_doska_besplatnyh_obyavleniy");
// Подать объявления строительных работ
Route::get("/podat-obyavleniya-stroitelnyh-rabot", "AdvertController@podat_obyavleniya_stroitelnyh_rabot");
// Подать объявления электрика
Route::get("/podat-obyavleniya-elektrika", "AdvertController@podat_obyavleniya_elektrika");
// Подать платное объявление
Route::get("/podat-platnoe-obyavlenie", "AdvertController@podat_platnoe_obyavlenie");
// сервис разместить объявление
Route::get("/servis-razmestit-obyavlenie", "AdvertController@servis_razmestit_obyavlenie");
// сиделка Подать объявление
Route::get("/sidelka-podat-obyavlenie", "AdvertController@sidelka_podat_obyavlenie");
// Стройка подать объявление
Route::get("/stroyka-podat-obyavlenie", "AdvertController@stroyka_podat_obyavlenie");
// Хочу купить подать объявление
Route::get("/hochu-kupit-podat-obyavlenie", "AdvertController@hochu_kupit_podat_obyavlenie");
// Юридические услуги подать объявление
Route::get("/yuridicheskie-uslugi-podat-obyavlenie", "AdvertController@yuridicheskie_uslugi_podat_obyavlenie");
// Акжайык подать объявление
Route::get("/akzhayyk-podat-obyavlenie", "AdvertController@akzhayyk_podat_obyavlenie");
// Газета срочно подать объявление
Route::get("/gazeta-srochno-podat-obyavlenie", "AdvertController@gazeta_srochno_podat_obyavlenie");
// Газеты области подать объявления
Route::get("/gazety-oblasti-podat-obyavleniya", "AdvertController@gazety_oblasti_podat_obyavleniya");
// Нурсултан подать объявление на продажу автомобиля
Route::get("/nursultan-podat-obyavlenie-na-prodazhu-avtomobilya", "AdvertController@nursultan_podat_obyavlenie_na_prodazhu_avtomobilya");
// Работа в интернете разместить объявление
Route::get("/rabota-v-internete-razmestit-obyavlenie", "AdvertController@rabota_v_internete_razmestit_obyavlenie");
// Работа частные объявления подать
Route::get("/rabota-chastnye-obyavleniya-podat", "AdvertController@rabota_chastnye_obyavleniya_podat");
// Разместить объявление бесплатно и без регистрации
Route::get("/razmestit-obyavlenie-besplatno-i-bez-registracii", "AdvertController@razmestit_obyavlenie_besplatno_i_bez_registracii");
// Разместить объявление о продаже
Route::get("/razmestit-obyavlenie-o-prodazhe", "AdvertController@razmestit_obyavlenie_o_prodazhe");
// Разместить объявление о работе
Route::get("/razmestit-obyavlenie-o-rabote", "AdvertController@razmestit_obyavlenie_o_rabote");
// Разместить объявление о работе бесплатно
Route::get("/razmestit-obyavlenie-o-rabote-besplatno", "AdvertController@razmestit_obyavlenie_o_rabote_besplatno");

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