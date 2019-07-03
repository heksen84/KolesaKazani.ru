<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\SubCats;
use App\Adverts;
use App\Categories;
use App\Regions;
use App\Places;

// ------------------------------------------
// Класс возвращает результаты категорий
// ------------------------------------------
class ResultsController extends Controller {
	
    // частные переменные
    private $total          = [];
    private $start_record   = 0;
    private $records_limit  = 20; // максимальное число записей при выборке    
    private $filter_string  = "";   
    private $start_page     = "null";
    private $category_name  = "null";
    private $subcat         = "null";
    private $category_id    = "null";
    private $price_min      = "null";
    private $price_max      = "null";
    private $deal           = "null";
    private $region         = "null";
    private $place          = "null";
    private $searchString   = "null";

    // ---------------------------------------------------
    // Получить строку фильтра по url региона
    // ---------------------------------------------------
    private function getRegionFilterStringByUrl($url) {

        if (isset($url)) {            
            $region = Regions::select("region_id")->where("url", $url )->first();                        
            $region_string = " AND region_id = ".$region->region_id; // формируем строку региона
            \Debugbar::info($region_string);
            return $region_string;
        }
        return false;
    }

    // -----------------------------------------------------------
    // Получить строку фильтра по url места (город / село / аул )
    // -----------------------------------------------------------
    private function getPlaceFilterStringByUrl($url) {

        if (isset($url)) {            
            $place = Places::select("city_id")->where("url", $url )->first();                        
            $place_string = " AND city_id = ".$place->city_id; // формируем строку места
            \Debugbar::info($place_string);
            return $place_string;
        }
        return false;
    }

    // ----------------------------------------
    // Обработка фильтра
    // ----------------------------------------
    private function getFilterData($request) {

	   $data = $request->all();

	    if (!$data)
		    return false;

        if (isset($data["start_page"]))     $this->start_page     = $data["start_page"];
        if (isset($data["category_name"]))  $this->category_name  = $data["category_name"];
        if (isset($data["subcat"]))         $this->subcat         = $data["subcat"];
        if (isset($data["category_id"]))    $this->category_id    = $data["category_id"];
        if (isset($data["deal"]))           $this->deal           = $data["deal"];
        if (isset($data["price_min"]))      $this->price_min      = $data["price_min"];
        if (isset($data["price_max"]))      $this->price_max      = $data["price_max"];
	    if (isset($data["region"]))         $this->region         = $data["region"];
        if (isset($data["place"]))          $this->place          = $data["place"];
        if (isset($data["searchString"]))   $this->searchString   = $data["searchString"];
                    
        \Debugbar::info("Фильтр - категория id:".$this->category_id);
        \Debugbar::info("Фильтр - категория:".$this->category_name);
        \Debugbar::info("Фильтр - Подкатегория:".$this->subcat);
        \Debugbar::info("Фильтр - start_page :".$this->start_page);
        \Debugbar::info("Фильтр - id сделки :".$this->deal);
        \Debugbar::info("Фильтр - Цена от :".$this->price_min);
        \Debugbar::info("Фильтр - Цена до :".$this->price_max);
        \Debugbar::info("Фильтр - Регион :".$this->region);
        \Debugbar::info("Фильтр - Место :".$this->place);
        \Debugbar::info("Фильтр - Строка поиска :".$this->searchString);

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
        
        \Debugbar::info("FILTERS :".$this->filter_string);

	return true;

    }

    // -------------------------------------------------------
    //
    // Общий метод поиска по заспросу
    //
    // -------------------------------------------------------
    private function search(Request $request) {

        // Проверяю наличие фильтров
        $filterData = $this->getFilterData($request);        
    
        // Получаю входящие данные и удаляю не нужные символы.
        // FIXME: Пофиксить. Вылетает с ошибкой
        // $requestString = preg_replace("/[a-zA-Z]/", "", $request->input("str"));
    
        $requestString = $request->input("str");

        //$arr = explode(" ", $requestString);
    
        \Debugbar::info("Строка поиска :".$requestString);	

        if ($this->searchString=="null")
            $this->searchString = $requestString;

        // Строка запроса для полнотекстового поиска
        $querySearchStr = "MATCH (text) AGAINST ('".$this->searchString."*' IN BOOLEAN MODE)";
      
        // Получаю общее кол-во
        $total = DB::select("SELECT COUNT(*) as count FROM `adverts` AS adv WHERE ".$querySearchStr.$this->filter_string);
   
        \Debugbar::info("TOTAL :".$total[0]->count);        
          
        // Получаю выборку
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
            FROM `adverts` AS adv WHERE ".$querySearchStr.$this->filter_string." ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit
        );
    
        \Debugbar::info($results);

        $keywords = $requestString;
        $description = $requestString;
        $title = "Поиск по запросу: ".$requestString;

        // Формирую массив
        return array (
            "keywords"=>$keywords,
            "description"=>$description,
            "title"=>$title,
            "results"=>json_encode($results),        
            "category_name"=>json_encode($request->path()), 
            "start_record"=>0,
            "total_records"=>$total[0]->count,
            "searchString"=>json_encode($requestString)
        );     
    }

    // Поиск для вьюхи
    public function searchForView(Request $request) {

        $result = $this->search($request);

        return view("results")
        ->with("keywords", $result["keywords"])
        ->with("description", $result["description"])
        ->with("title", $result["title"])    
        ->with("results", $result["results"])    
        ->with("start_record", $result["start_record"])
        ->with("total_records", $result["total_records"])
        ->with("category", "null")
        ->with("category_name", "null")
        ->with("subcat", "null")
        ->with("region", "null")
        ->with("place", "null")
        ->with("searchString", $result["searchString"]);      
    }

    // Поиск для морды
    public function searchForFront(Request $request) {
        \Debugbar::info("Поиск с фильтрами");
        return $this->search($request);       
    }

    // ----------------------------------------------------------------------------------
    //
    //
    // Результаты по категории (общая функция)
    //
    //
    // ----------------------------------------------------------------------------------
    public function getResultsByCategory(Request $request, $region, $place, $category) {
        
        $region_string = "";
        $place_string = "";

        if ($category)
            $this->category_name = $category;

        // Проверяю наличие фильтров
        $filterData = $this->getFilterData($request);         
           
	    // регион c фильтрами
        if ($filterData && $this->region!="null") {            
            $region_string = $this->getRegionFilterStringByUrl($this->region);
        }
        
        // регион без фильтров
        if (!$filterData && $region) {            
            $region_string = $this->getRegionFilterStringByUrl($region);
        }

        // место c фильтрами
        if ($filterData && $this->place!="null") {            
            $place_string = $this->getPlaceFilterStringByUrl($this->place);
        }
        
        // место без фильтров
        if (!$filterData && $place) {            
            $place_string = $this->getPlaceFilterStringByUrl($place);
        }

        \Debugbar::info("CATEGORY_NAME :".$this->category_name);
        
        // Получаю имя категории на русском по url
    	$category = Categories::select("id", "name")->where("url", $this->category_name )->first();
        $items = Adverts::where("category_id",  $category->id )->get();        
                       	    
        switch($category->id) {

        // --------------------------------------------------------
        // Вся автотранспорт Казахстана (damelya.kz/transport)
        // --------------------------------------------------------

		case 1: {

                $this->total = DB::select(
                    "SELECT	
                    COUNT(*) as count FROM `adverts` as adv
					LEFT OUTER JOIN (adv_transport, car_mark, car_model) ON 
                    (
					adv.adv_category_id = adv_transport.id AND 
					adv_transport.mark = car_mark.id_car_mark AND 						
					adv_transport.model = car_model.id_car_model
					) WHERE adv.category_id=1".$this->filter_string
                );
                
                \Debugbar::info("TOTAL :".$this->total[0]->count);

				$results = DB::select(
					"SELECT
					adv.region_id,
					adv.city_id,
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
            
            // --------------------------------------------------------
            // Вся недвижимость Казахстана (damelya.kz/nedvizhimost)
            // --------------------------------------------------------
			case 2: {
            
                $this->total = DB::select(
                    "SELECT 
                    COUNT(*) as count FROM `adverts` as adv
                    INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
					WHERE adv.category_id=2".$this->filter_string
                );

                \Debugbar::info("TOTAL :".$this->total[0]->count);

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
            
            // --------------------------------------------------------
            // Остальные категории
            // --------------------------------------------------------
			default: {

			    // --------------------------------
			    // Заголовки title для SEO
	    	    // --------------------------------
				   
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
                
				$this->total = DB::select("SELECT COUNT(*) as count FROM `adverts` AS adv WHERE category_id=".$category->id.$region_string.$place_string.$this->filter_string);

                \Debugbar::info("TOTAL :".$this->total[0]->count);
                
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
                    FROM `adverts` AS adv WHERE category_id=".$category->id.$this->filter_string.$region_string.$place_string.
                    " ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit
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
            "results"=>json_encode($results),
            "category"=>$category->id,  
            "category_name"=>json_encode($request->path()), 
            "start_record"=>$this->start_record,
            "total_records"=>$this->total[0]->count
        );
    }

    // -------------------------------------------------------------
    // Результаты по всей стране для вьюхи
    // -------------------------------------------------------------
    public function getResultsByCategoryForView(Request $request) {
		
	    $category = request()->segment(1); // вырезаю категорию из url
        $result = $this->getResultsByCategory($request, null, null, $category);

        if ($result==null)
            return view("errors/404");
    
        return view("results")
        ->with("keywords", $result["keywords"])
        ->with("description", $result["description"])
        ->with("title", $result["title"])        
		->with("results", $result["results"])
        ->with("category", $result["category"])
        ->with("category_name", $result["category_name"])
        ->with("subcat", "null")
        ->with("start_record", $result["start_record"])
        ->with("total_records", $result["total_records"])
        ->with("region", "null")
        ->with("place",  "null")
        ->with("searchString", "null");
    }
    
    // ---------------------------------------------------------------
    // Результаты по всей стране для морды
    // ---------------------------------------------------------------
    public function getResultsByCategoryForFront(Request $request) {        
        $result = $this->getResultsByCategory($request, null, null, null);
        return $result;
	}

     // -----------------------------------------------------------------------
     // Результаты по региону для вьюшки
     // -----------------------------------------------------------------------
     public function getResultsByRegionForView(Request $request, $region) {

	    $category = request()->segment(2); // вырезаю категорию из url
        $result = $this->getResultsByCategory($request, $region, null, $category);

        if ($result==null)
            return view("errors/404");
    
        return view("results")
        ->with("keywords", $result["keywords"])
        ->with("description", $result["description"])
        ->with("title", $result["title"])        
		->with("results", $result["results"])
        ->with("category", $result["category"])
        ->with("category_name", json_encode($category))
        ->with("subcat", "null")
        ->with("start_record", $result["start_record"])
        ->with("total_records", $result["total_records"])
        ->with("region", json_encode($region))
        ->with("place",  "null")
        ->with("searchString", "null");
     }

     // -----------------------------------------------------------------------
     // Результаты по региону для морды
     // -----------------------------------------------------------------------
     public function getResultsByRegionForFront(Request $request) {                
        $result = $this->getResultsByCategory($request, null, null, null);
        return $result;
     }

     // -----------------------------------------------------------------------
     // Результаты по городу / селу / аулу
     // -----------------------------------------------------------------------
     public function getResultsByPlaceForView(Request $request, $region, $place) {

        $category = request()->segment(3); // вырезаю категорию из url
        
        \Debugbar::info("Регион :".$region);
        \Debugbar::info("Место :".$place);
        \Debugbar::info("Категория:".$category);

        $result = $this->getResultsByCategory($request, $region, $place, $category);

        if ($result==null)
            return view("errors/404");
    
        return view("results")
        ->with("keywords", $result["keywords"])
        ->with("description", $result["description"])
        ->with("title", $result["title"])        
		->with("results", $result["results"])
        ->with("category", $result["category"])
        ->with("category_name", json_encode($category))
        ->with("subcat", "null")
        ->with("start_record", $result["start_record"])
        ->with("total_records", $result["total_records"])
        ->with("region", json_encode($region))
        ->with("place",  json_encode($place))
        ->with("searchString", "null");

     }

     // ----------------------------------------------------------
     // Результаты по городу / селу / аулу для морды
     // ----------------------------------------------------------
     public function getResultsByPlaceForFront(Request $request) {
        \Debugbar::info("getResultsByPlaceForFront: OK");
        $category = request()->segment(2);
        $result = $this->getResultsByCategory($request, null, null, null);
        return $result;
     }

	/*
    -----------------------------------------------------------------------------------------------
    
    Получить результаты для подкатегории
    
	-----------------------------------------------------------------------------------------------*/
	public function getResultsForSubCategory(Request $request, $region, $place, $category, $subcat) {        
    
        \Debugbar::info("REGION :".$region);

        $region_string="";
        $place_string="";        
        
        // проверка на наличие фильтров
        $filterData = $this->getFilterData($request);

        if ($filterData) {            
            \Debugbar::info("С ФИЛЬТРАМИ!");        
        
            $subcat = $this->subcat;
		
    	    // Если указан регион из фильтра, то получаю строку фильтра по региону
	        if ($this->region!="null")
                $region_string = $this->getRegionFilterStringByUrl($this->region);

            if ($this->place!="null")
                $place_string = $this->getPlaceFilterStringByUrl($this->place);                
            }
            else {                       	     

	        if ($region) {
                $region_string = $this->getRegionFilterStringByUrl($region);
                $this->region = $region;
            }

            if ($place) {
                $place_string = $this->getPlaceFilterStringByUrl($place);               
                $this->place = $place;
            }
                
            \Debugbar::info($region_string);

            $this->category_name = $request->path();            
        }            
        
        // получаю имя на русском
	    $categories = SubCats::select("id", "name")->where("url",  $filterData?$this->subcat:$subcat )->first();
        
        if ($categories==null)
            return false;

        $items = Adverts::where("category_id",  $categories->id )->get();
        
        // беру имя категории либо с фильтров либо с переменной в контроллере
        $category = $filterData?$this->category_name:$category;        

        \Debugbar::info("CATEGORY :".$category);
        
        switch($category) {

            case "transport": {                

                // Легковой транспорт
                if ($subcat=="legkovoy-avtomobil") {

                    $this->total = DB::select(
                        "SELECT 
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport, car_mark, car_model) ON (
                            adv_transport.mark=car_mark.id_car_mark AND 
                            adv.adv_category_id=adv_transport.id AND 
                            adv_transport.model = car_model.id_car_model
                        ) WHERE adv_transport.type=0 AND adv.category_id=1".$region_string.$place_string.$this->filter_string); 
                    
                                    
                    $results = DB::select(
                        "SELECT
			            adv.region_id,
			            adv.city_id,
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
                        ) WHERE adv_transport.type=0 AND adv.category_id=1".$this->filter_string.$region_string.$place_string."
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );                    

                    \Debugbar::info($results);

                    $keywords = "123";
                    $description = "123";
                    $title="Покупка, продажа, обмен, сдача в аренду легковых автомобилей";
                    break;
                }
                                
                // Грузовой транспорт
                if ($subcat=="gruzovoy-avtomobil") {

                    $this->total = DB::select(
                        "SELECT 
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=1 AND adv.category_id=1".$region_string.$place_string.$this->filter_string
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
                        ) WHERE adv_transport.type=1 AND adv.category_id=1".$this->filter_string.$region_string.$place_string." 
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
                   
                    $this->total = DB::select(
                        "SELECT
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=2 AND adv.category_id=1".$region_string.$place_string.$this->filter_string
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
                        ) WHERE adv_transport.type=2 AND adv.category_id=1".$this->filter_string.$region_string.$place_string."
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

                    $this->total = DB::select(
                        "SELECT
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=3 AND adv.category_id=1".$region_string.$place_string.$this->filter_string
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
                        ) WHERE adv_transport.type=3 AND adv.category_id=1".$this->filter_string.$region_string.$place_string." 
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
                    
                    $this->total = DB::select(
                        "SELECT 
                        COUNT(*) as count
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=4 AND adv.category_id=1".$region_string.$place_string.$this->filter_string
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
                        ) WHERE adv_transport.type=4 AND adv.category_id=1".$this->filter_string.$region_string.$place_string." 
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду ретро автомобилей";

                    break;
                }                               

                // Водный транспорт
                if ($subcat=="vodnyy-transport") {
                    
                    $this->total = DB::select(
                        "SELECT 
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=5  AND adv.category_id=1".$region_string.$place_string.$this->filter_string
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
                        ) WHERE adv_transport.type=5  AND adv.category_id=1".$this->filter_string.$region_string.$place_string." 
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду водного транспорта";

                    break;
                }                               

                // Велосипед
                if ($subcat=="velosiped") {

                    $this->total = DB::select(
                        "SELECT 
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=6  AND adv.category_id=1".$region_string.$place_string.$this->filter_string
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
                        ) WHERE adv_transport.type=6  AND adv.category_id=1".$this->filter_string.$region_string.$place_string." 
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду велосипеда";

                    break;
                }                               

                // Воздушный транспорт
                if ($subcat=="vozdushnyy-transport") {
                    
                    $this->total = DB::select(
                        "SELECT 
                        COUNT(*) as count 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=7 AND adv.category_id=1".$region_string.$place_string.$this->filter_string
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
                        ) WHERE adv_transport.type=7 AND adv.category_id=1".$this->filter_string.$region_string.$place_string."
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $keywords = "";
                    $description = "";
                    $title="Покупка, продажа, обмен, сдача в аренду воздушного транспорта";

                    break;
                }
            }
            
            //------------------------------------------------------------
            // недвижимость
            //------------------------------------------------------------
            case "nedvizhimost": {
                
                // adv_realestate
                // id, property_type, floor, floors_house, rooms, area, ownership, kind_of_object

                // квартира
                if ($subcat=="kvartira") {

                    $this->total = DB::select(
                        "SELECT
                        COUNT(*) as count                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=0 AND adv.category_id=2".$region_string.$place_string.$this->filter_string
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
                        WHERE adv_realestate.property_type=0 AND adv.category_id=2".$this->filter_string.$region_string.$place_string."
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

                    $this->total = DB::select(
                        "SELECT
                        COUNT(*) as count                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=1 AND adv.category_id=2".$region_string.$place_string.$this->filter_string
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
                        WHERE adv_realestate.property_type=1 AND adv.category_id=2".$this->filter_string.$region_string.$place_string."
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

                    $this->total = DB::select(
                        "SELECT
                        COUNT(*) as count
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=2 AND adv.category_id=2".$region_string.$place_string.$this->filter_string
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
                        WHERE adv_realestate.property_type=2 AND adv.category_id=2".$this->filter_string.$region_string.$place_string."
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

                    $this->total = DB::select(
                        "SELECT
                        COUNT(*) as count                      
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=3 AND adv.category_id=2".$region_string.$place_string.$this->filter_string
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
                        WHERE adv_realestate.property_type=3 AND adv.category_id=2".$this->filter_string.$region_string.$place_string."
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

                    $this->total = DB::select(
                        "SELECT
                        COUNT(*) as count                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=4 AND adv.category_id=2".$region_string.$place_string.$this->filter_string
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
                        WHERE adv_realestate.property_type=4 AND adv.category_id=2".$this->filter_string.$region_string.$place_string."
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

                    $this->total = DB::select(
                        "SELECT
                        COUNT(*) as count                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=5 AND adv.category_id=2".$region_string.$place_string.$this->filter_string
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
                        WHERE adv_realestate.property_type=5 AND adv.category_id=2".$this->filter_string.$region_string.$place_string."
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

                    $this->total = DB::select(
                        "SELECT
                        COUNT(*) as count                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=6 AND adv.category_id=2".$region_string.$place_string.$this->filter_string
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
                        WHERE adv_realestate.property_type=6 AND adv.category_id=2".$this->filter_string.$region_string.$place_string."
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
    return array (
        "category_name"=>json_encode($category),
        "subcat"=>json_encode($subcat),
        "keywords"=>$keywords,
        "description"=>$description,
        "title"=>$title,        
        "results"=>json_encode($results), 
        "category"=>$categories,
        "start_record"=>$this->start_record,
        "total_records"=>$this->total[0]->count,
        "region"=>json_encode($this->region),
        "place"=>json_encode($this->place)
    );         
}

   // --------------------------------------------------------------------------------------
   // Результаты подкатегорий для бэка
   // --------------------------------------------------------------------------------------
   public function getResultsForSubCategoryForView(Request $request, $category, $subcat) {

    $result = $this->getResultsForSubCategory($request, null, null, $category, $subcat);

    if ($result==null)
        return view("errors/404");

    return view("testResults")
    ->with("category_name", $result["category_name"])
    ->with("subcat", $result["subcat"])
    ->with("keywords", $result["keywords"])
    ->with("description", $result["description"])
    ->with("title", $result["title"])    
    ->with("results", $result["results"])
    ->with("category", $result["category"])
    ->with("total_records", $result["total_records"])
    ->with("region", "null")
    ->with("place", "null")
    ->with("searchString", "null");
   }

   // -------------------------------------------------------------------
   // Результаты подкатегорий для морды
   // -------------------------------------------------------------------
    public function getResultsForSubCategoryForFront(Request $request) {
	    $result = $this->getResultsForSubCategory($request, null, null, null, null);
	    return $result;
    }

    // -----------------------------------------------------------------------------------------
    // Результаты по региону с под категориями для вьюшки
    // -----------------------------------------------------------------------------------------
     public function getResultsByRegionWithSubCategoryForView(Request $request, $region, $subcat) {

	    $category = request()->segment(2);	 // вырезаю категори из url
        $result = $this->getResultsForSubCategory($request, $region, null, $category, $subcat);

        if ($result==null)
            return view("errors/404");

	    \Debugbar::info("REGION :".$region);
    
        return view("results")
        ->with("keywords", $result["keywords"])
        ->with("description", $result["description"])
        ->with("title", $result["title"])        
	    ->with("results", $result["results"])
        ->with("category", $result["category"])
	    ->with("category_name", json_encode($category))
        ->with("subcat", json_encode($subcat))
        ->with("start_record", $result["start_record"])
        ->with("total_records", $result["total_records"])
        ->with("region", json_encode($region))
        ->with("place", "null")
        ->with("searchString", "null");
     }

    // ----------------------------------------------------------------------------------------------
    // Результаты по региону с под категориями для морды
    // ----------------------------------------------------------------------------------------------
     public function getResultsByRegionWithSubCategoryForFront(Request $request, $region, $subcat) {

	    $category = request()->segment(2);
        $result = $this->getResultsByCategory($request, $region, null, $category);
    
        return view("results")
        ->with("keywords", $result["keywords"])
        ->with("description", $result["description"])
        ->with("title", $result["title"])        
	    ->with("results", $result["results"])
        ->with("category", $result["category"])
        ->with("category_name", $result["category_name"])
        ->with("subcat", "null")
        ->with("start_record", $result["start_record"])
        ->with("total_records", $result["total_records"])
        ->with("region", "null")
        ->with("searchString", "null");
     }

    // ---------------------------------------------------------------------------------------------------
    // Результаты по месту с под категориями для вьюшки
    // ---------------------------------------------------------------------------------------------------
    public function getResultsByPlaceForWithSubCategoryForView(Request $request, $region, $place, $subcat) {

	    $category = request()->segment(3);	 // вырезаю категори из url
        $result = $this->getResultsForSubCategory($request, $region, $place, $category, $subcat);

        if ($result==null)
            return view("errors/404");

	    \Debugbar::info("REGION :".$region);
    
        return view("results")
        ->with("keywords", $result["keywords"])
        ->with("description", $result["description"])
        ->with("title", $result["title"])        
	    ->with("results", $result["results"])
        ->with("category", $result["category"])
	    ->with("category_name", json_encode($category))
        ->with("subcat", json_encode($subcat))
        ->with("start_record", $result["start_record"])
        ->with("total_records", $result["total_records"])
        ->with("region", json_encode($region))
        ->with("place", json_encode($place))
        ->with("searchString", "null");
     }

    // --------------------------------------------------------------------------
    // Результаты по месту с под категориями для морды
    // --------------------------------------------------------------------------
    public function getResultsByPlaceWithSubCategoryForFront(Request $request) {	    
        $result = $this->getResultsForSubCategory($request, null, null, null, null);    
        return $result;
     }     
}