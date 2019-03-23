<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Helpers\Petrovich;
use App\Http\Controllers\Controller;
use App\SubCats;
use App\Transport;
use App\Adverts;
use App\Categories;
use App\Regions;
use App\Places;
use App\Images;

class ResultsController extends Controller {
	
	// частные переменные
	private $start_record  = 0;
    private $records_limit = 1000; // максимальное число записей при выборке
    
    // Получить данные по категории
    public function getResultsByCategory(Request $request) {

		$results = [];
        $title = "";

        // получаю имя на русском
		$category = Categories::select("id", "name")->where("url",  $request->path() )->first();
		$items = Adverts::where("category_id",  $category->id )->get();
        
        // для фильтра
		//$data = $request->all();
        //\Debugbar::info($data);                

		// --------------------------------------------------------
		// Беру данные по конкретной категории
		// --------------------------------------------------------
		switch($category->id) {

			// Вся автотранспорт Казахстана (damelya.kz/transport)
			case 1: {

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
					) WHERE adv.category_id=1
					ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit
				);

				\Debugbar::info($results);

				$title = "Объявления о покупке, продаже, обмене или сдаче транспорта в аренду в Казахстане";
				break;				                          				
			}
			
			// Вся недвижимость Казахстана (damelya.kz/nedvizhimost)
			case 2: {

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
					WHERE adv.category_id=2
					ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit
                );

                \Debugbar::info($results);

				// seo title
				$title = "Объявления о покупке, продаже, обмене или сдаче недвижимости в аренду в Казахстане";
				break;
			}
			
			// Всё остальное
			default: {

				/* --------------------------------
				    Заголовки title для SEO
				   --------------------------------*/
				   
				// электроника
				if ($category->id==3) $title = "Объявления о покупке, продаже, обмене или сдаче электроники В Казахстане";
				// работа и бизнес
				if ($category->id==4) $title = "Обяъвления о работе и бизнесе в Казахстане";
				// для дома и дачи
				if ($category->id==5) $title = "Объявления категории для дома и дачи в Казахстанe";
				// личные вещи
				if ($category->id==6) $title = "Объявления о покупке, продаже, обмене или сдаче";
				// животные
				if ($category->id==7) $title = "Объявления о покупке, продаже, обмене или сдаче";
				// хобби и отдых
				if ($category->id==8) $title = "Объявления категории хобби и отдых в Казахстанe";
				// услуги
				if ($category->id==9) $title = "Объявления категории услуги в Казахстанe";
				// другое
				if ($category->id==10) $title = "Различные предложения в Казахстане";

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
					FROM `adverts` AS adv WHERE category_id=".$category->id." 
					ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit
				);

				\Debugbar::info($results);
			}
        }

        // передать id категории
        \Debugbar::info("Категория: ".$category->id);
        
        return array
        (
            "title"=>$title, 
            "items"=>$items, 
            "results"=>json_encode($results), 
            "category"=>$category->id, 
            "start_record"=>$this->start_record
        );

    }

    // -------------------------------------------------------------
    // результаты по всей стране для вьюхи
    // -------------------------------------------------------------
    public function getResultsByCategoryForView(Request $request) {
		
        $result = $this->getResultsByCategory($request);
    
        return view("results")
        ->with("title", $result["title"])
        ->with("items", $result["items"])
		->with("results", $result["results"])
		->with("category", $result["category"])
		->with("start_record", $result["start_record"]);
    }
    
    // ---------------------------------------------------------------
    // результаты по всей стране для морды
    // ---------------------------------------------------------------
    public function getResultsByCategoryForFront(Request $request) {
        $result = $this->getResultsByCategory($request);    
        return $result;
	}

	/*
    --------------------------------------------------------------------------------
    
    Получить результаты для подкатегории
    
	--------------------------------------------------------------------------------*/
	public function getResultsForSubCategory(Request $request, $category, $subcat) {

		\Debugbar::info("Я тута, я здеся!");

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
                        ) WHERE adv_transport.type=0 AND adv.category_id=1
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );                    

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду легковых автомобилей";
                    break;
                }
                                
                // Грузовой транспорт
                if ($subcat=="gruzovoy-avtomobil") {
                    
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
                        ) WHERE adv_transport.type=1 AND adv.category_id=1 
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду грузового транспорта";
                    break;
                }

                // Мототехника
                if ($subcat=="mototehnika") {                                        
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
                        ) WHERE adv_transport.type=2 AND adv.category_id=1
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);
                    
                    $title="Покупка, продажа, обмен, сдача в аренду мототехники";
                    break;
                }                

                // Спецтехника
                if ($subcat=="spectehnika") {                    
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
                        ) WHERE adv_transport.type=3 AND adv.category_id=1 
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду спецтехники";
                    break;
                }   

                // Ретроавтомобиль
                if ($subcat=="retro-avtomobil") {                     
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
                        ) WHERE adv_transport.type=4 AND adv.category_id=1 
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Покупка, продажа, обмен, сдача в аренду ретро автомобилей";
                    break;
                }                               

                // Водный транспорт
                if ($subcat=="vodnyy-transport") {                    
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
                        ) WHERE adv_transport.type=5  AND adv.category_id=1 
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Покупка, продажа, обмен, сдача в аренду водного транспорта";
                    break;
                }                               

                // Велосипед
                if ($subcat=="velosiped") {                    
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
                        ) WHERE adv_transport.type=6  AND adv.category_id=1 
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Покупка, продажа, обмен, сдача в аренду велосипеда";
                    break;
                }                               

                // Воздушный транспорт
                if ($subcat=="vozdushnyy-transport") {                    
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
                        ) WHERE adv_transport.type=7 AND adv.category_id=1
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

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
                        WHERE adv_realestate.property_type=0 AND adv.category_id=2
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду квартиры";
                    break;
                }

                // комната
                if ($subcat=="komnata") {

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
                        WHERE adv_realestate.property_type=1 AND adv.category_id=2
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду комнаты";
                    break;
                }

                // дом, дача, коттедж
                if ($subcat=="dom-dacha-kottedzh") {

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
                        WHERE adv_realestate.property_type=2 AND adv.category_id=2
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);
                                        
                    $title="Покупка, продажа, обмен, сдача в аренду дома, дачи, коттеджа";
                    break;
                }

                // земельный участок
                if ($subcat=="zemel-nyy-uchastok") {

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
                        WHERE adv_realestate.property_type=3 AND adv.category_id=2
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду земельного участка";
                    break;
                }
                
                // гараж или машиноместо
                if ($subcat=="garazh-ili-mashinomesto") {

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
                        WHERE adv_realestate.property_type=4 AND adv.category_id=2
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду гаража или машиноместа";
                    break;
                }

                // коммерческая недвижимость
                if ($subcat=="kommercheskaya-nedvizhimost") {

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
                        WHERE adv_realestate.property_type=5 AND adv.category_id=2
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );
                
                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду коммерческой недвижимости";
                    break;
                }
                
                // недвижимость за рубежом
                if ($subcat=="nedvizhimost-za-rubezhom") {

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
                        WHERE adv_realestate.property_type=6 AND adv.category_id=2
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду недвижимости за рубежом";
                    break;
                }                                
            }
        }
        
        // если указаны фильтры, то вернуть данные на морду (return results)
        // иначе передать данные во вьюху

     	return view("results")->with("title", $title." в Казахстане")->with("items", $items)->with("results", json_encode($results))->with("category", $categories);
    }

    // -------------------------------------------------------------------
	// результаты по всему региону c детальной информацией
	// -------------------------------------------------------------------
    public function getResultsByRegionWithDetailedInfo(Request $request) {    
		return view("results")->with("title", "123123")
		->with("results", "123")
		->with("category", "123")
		->with("items", "123");
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