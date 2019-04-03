<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Petrovich;
use App\Http\Controllers\Controller;
use App\SubCats;
use App\Adverts;
use App\Categories;
use App\Regions;

class ResultsController extends Controller {
	
    // частные переменные
    private $start_record  = 0;
    private $records_limit = 5; // максимальное число записей при выборке

    private $total          = 0;
    private $filter_string  = "";   
    private $start_page     = "null";
    private $category_name  = "null";
    private $category_id    = "null";
    private $price_min      = "null";
    private $price_max      = "null";
    private $deal           = "null";

    // -------------------------------------------
    // Обработка фильтра
    // -------------------------------------------
    private function getFilterData($request) {

	   $data = $request->all();

	   if (!$data) {
		\Debugbar::info("Фильтр не указан");
		return false;
	   }

        if (isset($data["start_page"]))     $this->start_page     = $data["start_page"];
        if (isset($data["category_name"]))  $this->category_name  = $data["category_name"];
        if (isset($data["category_id"]))    $this->category_id    = $data["category_id"];
        if (isset($data["deal"]))           $this->deal           = $data["deal"];
        if (isset($data["price_min"]))      $this->price_min      = $data["price_min"];
        if (isset($data["price_max"]))      $this->price_max      = $data["price_max"];
            
        // FIX: ПРИМЕНИТЬ ВАЛИДАТОР
        \Debugbar::info("категория id:".$this->category_id);
        \Debugbar::info("категория:".$this->category_name);
        \Debugbar::info("start_page :".$this->start_page);
        \Debugbar::info("Вид сделки :".$this->deal);
        \Debugbar::info("Цена от :".$this->price_min);
        \Debugbar::info("Цена до :".$this->price_max);

        // определяю начиная с какой записи считывать данные
        if ($this->start_page >0)
            $this->start_record = $this->records_limit*($this->start_page-1);

            // фильтра
            $this->price_filter = "";
            $this->deal_filter  = "";

        if ($this->deal!="null")
            $this->deal_filter = " AND adv.deal=".$this->deal;
                
        if ($this->deal=="null" && $this->price_min=="null" && $this->price_max=="null") {
            $this->price_filter = "";
            $this->deal_filter  = "";
        }

        if ($this->price_min!="null" && $this->price_max!="null")
            $this->price_filter = " AND price BETWEEN ".$this->price_min." AND ".$this->price_max;

        if ($this->price_min=="null" && $this->price_max>0)
            $this->price_filter = " AND price BETWEEN 0 AND ".$this->price_max;
                    
        if ($this->price_min>0 && $this->price_max=="null")
            $this->price_filter = " AND price = ".$this->price_min;
                                                                            
        $this->filter_string = $this->price_filter.$this->deal_filter;
        \Debugbar::info("str :".$this->filter_string);

	return true;

    }
    // ------------------------------------------------------------
    // Получить данные по категории
    // ------------------------------------------------------------
    public function getResultsByCategory(Request $request, $region, $place) {

        $filterData = $this->getFilterData($request);

	\Debugbar::info("КАТЕГОРИЯ: ".$this->category_name);
	
	if (!$filterData)
            $this->category_name = $request->path();

	
	// Учитываю местоположение
	if (isset($region)) {
	 // формируем строку для региона
	}

	if (isset($place)) {
	 // формируем строку для города / села
	}
        
    // получаю имя на русском
	$category = Categories::select("id", "name")->where("url", $this->category_name )->first();
    $items = Adverts::where("category_id",  $category->id )->get();        
               
    // --------------------------------------------------------
	// Беру данные по конкретной категории
	// --------------------------------------------------------
	switch($category->id) {

		// Вся автотранспорт Казахстана (damelya.kz/transport)
		case 1: {

                $total = DB::select(
                    "SELECT	
                    COUNT(*) as count FROM `adverts` as adv
					LEFT OUTER JOIN (adv_transport, car_mark, car_model) ON 
                    (
					adv.adv_category_id = adv_transport.id AND 
					adv_transport.mark = car_mark.id_car_mark AND 						
					adv_transport.model = car_model.id_car_model
					) WHERE adv.category_id=1"
                );
                
                \Debugbar::info("TOTAL :".$total[0]->count);

				$results = DB::select(
					"SELECT					
					adv.id as advert_id,
					DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
					adv.price,
					adv.category_id,
					adv.deal,
					adv.full,
					(SELECT CASE adv_transport.type 
					WHEN 0 THEN concat(car_mark.name, ' ', car_model.name, ' ', year, ' г.')						
					ELSE adv.text
					END FROM adv_transport 
					WHERE adv_transport.id IN (SELECT adv.adv_category_id FROM adverts)) AS title, 					
					mileage,
					text,
					(SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
					FROM `adverts` as adv
					LEFT OUTER JOIN (adv_transport, car_mark, car_model) ON (
					adv.adv_category_id = adv_transport.id AND 
					adv_transport.mark = car_mark.id_car_mark AND 						
					adv_transport.model = car_model.id_car_model
					) WHERE adv.category_id=1".$this->filter_string."
					ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit
				);

				\Debugbar::info($results);

                $keywords = "";
                $description = "";
                $title = "Транспорт в Казахстане";

				break;				                          				
			}
			
			// Вся недвижимость Казахстана (damelya.kz/nedvizhimost)
			case 2: {
            
                $total = DB::select(
                    "SELECT 
                    COUNT(*) as count FROM `adverts` as adv
                    INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
					WHERE adv.category_id=2"
                );

                \Debugbar::info("TOTAL :".$total[0]->count);

				$results = DB::select(					
					"SELECT
					concat(adv_realestate.rooms, ' комнатную квартиру, ', adv_realestate.floor, '/', adv_realestate.floors_house, ' этаже, ', adv_realestate.area, ' кв. м.' ) AS title,					
					adv.id as advert_id,
					DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
					adv.deal,
					adv.full,                    
                    adv.price,
                    adv.category_id,
                    text,                        
                    (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                    adv_realestate.id
                    FROM `adverts` as adv
                    INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
					WHERE adv.category_id=2".$this->filter_string."
					ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit
                );

                \Debugbar::info($results);

                $keywords = "123";
                $description = "333";
                $title = "Недвижимость в Казахстане";
                
				break;
			}
			
			// Всё остальное
			default: {

			/* --------------------------------
			    Заголовки title для SEO
	    	   --------------------------------*/
				   
				// электроника
				if ($category->id==3) {
                    $keywords = "";
                    $description = "";
                    $title = "Электроника: Объявления о покупке, продаже, обмене или сдаче электроники В Казахстане";
                }
                    // работа и бизнес
				if ($category->id==4) {
                    $keywords = "";
                    $description = "";
                    $title = "Работа и бизнес: Обяъвления о работе и бизнесе в Казахстане";
                }
                    // для дома и дачи
                if ($category->id==5) {
                    $keywords = "";
                    $description = "";
                    $title = "Для дома и дачи: Объявления категории для дома и дачи в Казахстанe";
                }
                    // личные вещи
                if ($category->id==6) {
                    $keywords = "";
                    $description = "";
                    $title = "Личные вещи: Объявления о покупке, продаже, обмене или сдаче аренду личных вещей";
                }
                    // животные
				if ($category->id==7) {
                    $keywords = "";
                    $description = "";
                    $title = "Животные: Объявления о покупке, продаже, обмене или сдаче в аренду животных в Казахстане";
                }
                    // хобби и отдых
				if ($category->id==8) {
                    $keywords = "";
                    $description = "";
                    $title = "Хобби и отдых: Объявления категории хобби и отдых в Казахстанe";
                }
                // услуги
				if ($category->id==9) {
                    $keywords = "";
                    $description = "";
                    $title = "Услуги: Объявления категории услуги в Казахстанe";
                }
                    // другое
                if ($category->id==10) {
                    $keywords = "";
                    $description = "";
                    $title = "Различные предложения в Казахстане";
                }
                
				$total = DB::select("SELECT COUNT(*) as count FROM `adverts` AS adv WHERE category_id=".$category->id);

                \Debugbar::info("TOTAL :".$total[0]->count);
                
				// общий select
				$results = DB::select(
					"SELECT
					id as advert_id,
					DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
					adv.deal,
					adv.full,
					text as title, 
					price, 
					category_id,					
					(SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image
                    FROM `adverts` AS adv WHERE category_id=".$category->id.$this->filter_string." ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit
				);

				\Debugbar::info($results);
			}
        }

        // передать id категории
        \Debugbar::info("Категория: ".$request->path() );
        
        return array
        (
            "keywords"=>$keywords,
            "description"=>$description,
            "title"=>$title,
            "items"=>$items, 
            "results"=>json_encode($results),
            "category"=>$category->id,  
            "category_name"=>json_encode($request->path()), 
            "start_record"=>$this->start_record,
            "total_records"=>$total[0]->count
        );

    }

    // -------------------------------------------------------------
    // результаты по всей стране для вьюхи
    // -------------------------------------------------------------
    public function getResultsByCategoryForView(Request $request) {
		
        $result = $this->getResultsByCategory($request, null, null);
    
        return view("results")
        ->with("keywords", $result["keywords"])
        ->with("description", $result["description"])
        ->with("title", $result["title"])
        ->with("items", $result["items"])
		->with("results", $result["results"])
        ->with("category", $result["category"])
        ->with("category_name", $result["category_name"])
        ->with("start_record", $result["start_record"])
        ->with("total_records", $result["total_records"]);
    }
    
    // ---------------------------------------------------------------
    // результаты по всей стране для морды
    // ---------------------------------------------------------------
    public function getResultsByCategoryForFront(Request $request) {
        $result = $this->getResultsByCategory($request, null, null);
        return $result;
	}

	/*
    --------------------------------------------------------------------------------
    
    Получить результаты для подкатегории
    
	--------------------------------------------------------------------------------*/
	public function getResultsForSubCategory(Request $request, $category, $subcat) {

        $filterData = $this->getFilterData($request);

	    \Debugbar::info("КАТЕГОРИЯ: ".$this->category_name);
	
	    if (!$filterData)
            $this->category_name = $request->path();

        $petrovich = new Petrovich(Petrovich::GENDER_MALE);

        // ---------------------------------------------------------------------------
        // получаю имя на русском
        // ---------------------------------------------------------------------------
		$categories = SubCats::select("id", "name")->where("url",  $subcat )->first();
        $items = Adverts::where("category_id",  $categories->id )->get();
        $title = "";
        
        switch($category) {

            case "transport": {                

                // Легковой транспорт
                if ($subcat=="legkovoy-avtomobil") {

                    $total = DB::select(
                        "SELECT 
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport, car_mark, car_model) ON (
                            adv_transport.mark=car_mark.id_car_mark AND 
                            adv.adv_category_id=adv_transport.id AND 
                            adv_transport.model = car_model.id_car_model
                        ) WHERE adv_transport.type=0 AND adv.category_id=1"); 
                                    
                    $results = DB::select(
                        "SELECT
                        concat(car_mark.name, ' ', car_model.name, ' ', year, ' г.') AS title,
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,                                                
                        adv.price,
                        adv.category_id,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport, car_mark, car_model) ON (
                            adv_transport.mark=car_mark.id_car_mark AND 
                            adv.adv_category_id=adv_transport.id AND 
                            adv_transport.model = car_model.id_car_model
                        ) WHERE adv_transport.type=0 AND adv.category_id=1".$this->filter_string."
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );                    

                    \Debugbar::info($results);

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду легковых автомобилей";

                    break;
                }
                                
                // Грузовой транспорт
                if ($subcat=="gruzovoy-avtomobil") {

                    $total = DB::select(
                        "SELECT 
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=1 AND adv.category_id=1"                    
                    );
                    
                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,                                                
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=1 AND adv.category_id=1".$this->filter_string." 
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду грузового транспорта";

                    break;
                }

                // Мототехника
                if ($subcat=="mototehnika") {                                        
                   
                    $total = DB::select(
                        "SELECT
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=2 AND adv.category_id=1"                   
                    );
                    
                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,                                                
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=2 AND adv.category_id=1".$this->filter_string."
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);
                    
                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду мототехники";

                    break;
                }                

                // Спецтехника
                if ($subcat=="spectehnika") {

                    $total = DB::select(
                        "SELECT
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=3 AND adv.category_id=1"                    
                    );

                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=3 AND adv.category_id=1".$this->filter_string." 
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду спецтехники";

                    break;
                }   

                // Ретроавтомобиль
                if ($subcat=="retro-avtomobil") {
                    
                    $total = DB::select(
                        "SELECT 
                        COUNT(*) as count
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=4 AND adv.category_id=1"                   
                    );
                    
                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=4 AND adv.category_id=1".$this->filter_string." 
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду ретро автомобилей";

                    break;
                }                               

                // Водный транспорт
                if ($subcat=="vodnyy-transport") {
                    
                    $total = DB::select(
                        "SELECT 
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=5  AND adv.category_id=1"                    
                    );

                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=5  AND adv.category_id=1".$this->filter_string." 
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду водного транспорта";

                    break;
                }                               

                // Велосипед
                if ($subcat=="velosiped") {

                    $total = DB::select(
                        "SELECT 
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=6  AND adv.category_id=1"                    
                    );
                                        
                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,                                                
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=6  AND adv.category_id=1".$this->filter_string." 
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду велосипеда";

                    break;
                }                               

                // Воздушный транспорт
                if ($subcat=="vozdushnyy-transport") {
                    
                    $total = DB::select(
                        "SELECT 
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=7 AND adv.category_id=1"                
                    );

                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,                                     
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=7 AND adv.category_id=1".$this->filter_string."
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду воздушного транспорта";

                    break;
                }
            }

            /*
            ------------------------------------------------------------

            НЕДВИЖИМОСТЬ

            ------------------------------------------------------------*/
            case "nedvizhimost": {
                
                // adv_realestate
                // id, property_type, floor, floors_house, rooms, area, ownership, kind_of_object

                // квартира
                if ($subcat=="kvartira") {

                    $total = DB::select(
                        "SELECT
                        COUNT(*) as count                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=0 AND adv.category_id=2"                    
                    );

                    $results = DB::select(
                        "SELECT
                        concat(adv_realestate.rooms, ' комнатную квартиру, ', adv_realestate.floor, '/', adv_realestate.floors_house, ' этаж, ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=0 AND adv.category_id=2".$this->filter_string."
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду квартиры";

                    break;
                }

                // комната
                if ($subcat=="komnata") {

                    $total = DB::select(
                        "SELECT
                        COUNT(*) as count                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=1 AND adv.category_id=2"                    
                    );

                    $results = DB::select(
                        "SELECT
                        concat('комнату ', adv_realestate.floor, '/', adv_realestate.floors_house, ' этаж, ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=1 AND adv.category_id=2".$this->filter_string."
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду комнаты";

                    break;
                }

                // дом, дача, коттедж
                if ($subcat=="dom-dacha-kottedzh") {

                    $total = DB::select(
                        "SELECT
                        COUNT(*) as count
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=2 AND adv.category_id=2"
                    );

                    $results = DB::select(
                        "SELECT
                        CASE adv_realestate.type_of_building 
                            WHEN 0 THEN concat('дом ', adv_realestate.rooms, ' комн. ', adv_realestate.floors_house, ' этажей, ', adv_realestate.area, ' кв. м.' )
                            WHEN 1 THEN concat('дачу ', adv_realestate.rooms, ' комн. ', adv_realestate.floors_house, ' этажей, ', adv_realestate.area, ' кв. м.' )
                            WHEN 2 THEN concat('коттедж ', adv_realestate.rooms, ' комн. ', adv_realestate.floors_house, ' этажей, ', adv_realestate.area, ' кв. м.' )
                        ELSE '' 
                        END AS title,
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,            
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id/*,
                        adv_realestate.type_of_building*/
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=2 AND adv.category_id=2".$this->filter_string."
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);
                  
                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду дома, дачи, коттеджа";

                    break;
                }

                // земельный участок
                if ($subcat=="zemel-nyy-uchastok") {

                    $total = DB::select(
                        "SELECT
                        COUNT(*) as count                      
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=3 AND adv.category_id=2"
                    );

                    $results = DB::select(
                        "SELECT
                        concat('земельный участок ', adv_realestate.area, ' соток' ) AS title,
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,                                      
                        adv.price,
                        adv.category_id,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=3 AND adv.category_id=2".$this->filter_string."
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду земельного участка";

                    break;
                }
                
                // гараж или машиноместо
                if ($subcat=="garazh-ili-mashinomesto") {

                    $total = DB::select(
                        "SELECT
                        COUNT(*) as count                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=4 AND adv.category_id=2"                    
                    );

                    $results = DB::select(
                        "SELECT
                        concat('гараж или машиноместо' ) AS title,
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,             
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=4 AND adv.category_id=2".$this->filter_string."
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду гаража или машиноместа";

                    break;
                }

                // коммерческая недвижимость
                if ($subcat=="kommercheskaya-nedvizhimost") {

                    $total = DB::select(
                        "SELECT
                        COUNT(*) as count                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=5 AND adv.category_id=2"                    
                    );

                    $results = DB::select(
                        "SELECT
                        concat('недвижимость ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,                         
                        adv.price,
                        adv.category_id,                 
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=5 AND adv.category_id=2".$this->filter_string."
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );
                
                    \Debugbar::info($results);

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду коммерческой недвижимости";

                    break;
                }
                
                // недвижимость за рубежом
                if ($subcat=="nedvizhimost-za-rubezhom") {

                    $total = DB::select(
                        "SELECT
                        COUNT(*) as count                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=6 AND adv.category_id=2"                    
                    );

                    $results = DB::select(
                        "SELECT
                        concat('недвижимость ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id,
                        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,                   
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=6 AND adv.category_id=2".$this->filter_string."
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду недвижимости за рубежом";

                    break;
                }                                
            }
        }
        
	// ---------------------------------------------------------------------
        // если указаны фильтры, то вернуть данные на морду (return results)
        // иначе передать данные во вьюху
	// ---------------------------------------------------------------------
        return array
	(
            "category_name"=>json_encode($category),
            "subcat"=>json_encode($subcat),
            "keywords"=>$keywords,
            "description"=>$description,
            "title"=>$title, 
            "items"=>$items,
            "results"=>json_encode($results), 
            "category"=>$categories,
            "total_records"=>$total[0]->count
        );
         
    }

   // -------------------------------------------------------------------
   // Результаты подкатегорий для бэка
   // -------------------------------------------------------------------
   public function getResultsForSubCategoryForView(Request $request, $category, $subcat) {

	$result = $this->getResultsForSubCategory($request, $category, $subcat);

         return view("results")
         ->with("category_name", $result["category_name"])
         ->with("subcat", $result["subcat"])
         ->with("keywords", $result["keywords"])
         ->with("description", $result["description"])
         ->with("title", $result["title"])
         ->with("items", $result["items"])
         ->with("results", $result["results"])
         ->with("category", $result["category"])
         ->with("total_records", $result["total_records"]);
   }

    // -------------------------------------------------------------------
    // Результаты подкатегорий для морды
    // -------------------------------------------------------------------
    public function getResultsForSubCategoryForFront(Request $request, $category, $subcat) {
	$result = $this->getResultsForSubCategory($request, $category, $subcat);
	return $result;
    }

    // -------------------------------------------------------------------
    // результаты по всему региону c детальной информацией
    // -------------------------------------------------------------------
    public function getResultsByRegionWithDetailedInfo(Request $request) {    
		return view("results")->with("title", "123123")->with("results", "123")->with("category", "123")->with("items", "123");
	}
	// ----------------------------------------------------
	// результаты по всему региону без деталей
	// ----------------------------------------------------
	public function getResultsByRegion($region) {
	}

	// ---------------------------------------------------
    // результаты по городу, деревне
    // ---------------------------------------------------
    public function getResultsByPlace($_region, $place, $_category) {
    	// получаю имена на русском
		$region = Regions::select('name')->where('url',  $_region )->first();		
		// получаю имя и id на русском
    	$category = Categories::select('id', 'name')->where('url',  $_category )->first();    	
    	// получаю объявления
    	$items = Adverts::where('category_id',  $region->id)->get();
    	// передаю во вьюху
		return view('results')->with("items", $items)->with("title", $category->name." в ".$region->name)->with("images", "123");
    }
}