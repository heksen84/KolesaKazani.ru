<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Adverts;
use App\CarMark;
use App\Categories;
use App\Transport;
use App\RealEstate;
use App\DealType;
use App\Regions;
use App\Urls;
use App\Helpers\Petrovich;
use App\Helpers\Helper;
use App\Helpers\Sitemap;
use Validator;
use DB;

class AdvertController extends Controller {


    public function getAdverts() {
     return Adverts::all()->toJson();
    }

    /*
    -----------------------------------
    Новое объявление
    -----------------------------------*/
 	public function newAdvert() {
        return Auth::user()? view("create")
        ->with( "items", Categories::all() )
        ->with( "regions", Regions::all() )
        ->with( "dealtypes", DealType::all()->toJson() ) : view("auth\login");
 	}

    /*
    -----------------------------------------------
    Создать объявление
    -----------------------------------------------*/
    public function createAdvert(Request $request) {                

        $data = $request->all();
    
        \Debugbar::info("--------------------------");
        \Debugbar::info($data);
        \Debugbar::info("--------------------------");

        // ---------------------------
        // правила валидации
        // ---------------------------
        $rules = [
            //"adv_deal"      => "required",
            "adv_category"  => "required", 
            "adv_price"     => "required|numeric",
            "adv_phone1"    => "required|numeric",
            "images.*"      => "image|mimes:jpeg,png,jpg",
            "region_id"     => "required|numeric",
            "city_id"       => "required|numeric"
        ]; 

        // ---------------------------
        // сообщения валидации
        // ---------------------------
        $messages = [
            "adv_deal.required"        => "Укажите вид сделки", 
            "adv_category.required"    => "Укажите категорию товара или услуги",
            "adv_price.required"       => "Укажите цену",
            "adv_price.numeric"        => "Введите числовое значение для цены",
            "adv_phone1.required"      => "Укажите телефон",
            "adv_phone1.numeric"       => "Введите числовое значение для номера телефона 1",                        
            "adv_phone2.numeric"       => "Введите числовое значение для номера телефона 2",            
            "adv_phone3.numeric"       => "Введите числовое значение для номера телефона 3",            
            "images.*.image"           => "Только изображения!",
            "region_id.required"       => "Укажите регион",
            "region_id.numeric"        => "Введите числовое значение для региона",
            "city_id.required"         => "Укажите расположение",
            "city_id.numeric"          => "Введите числовое значение для расположения"
        ];

        
        // проверка
        $validator = Validator::make( $data, $rules, $messages );

        if ( $validator->fails() )  
            return response()->json( ["result"=>"usr.error", "msg" => $validator->errors()->first()] );                    

        $category   = $data["adv_category"];
        $deal       = $data["adv_deal"]; // Вид сделки
        $text       = $data["adv_info"];
        $price      = $data["adv_price"];
        $phone1     = $data["adv_phone1"];

        if (isset($data["adv_phone2"])) $phone2 = $data["adv_phone2"];
        if (isset($data["adv_phone3"])) $phone3 = $data["adv_phone3"];

        $region_id = $data["region_id"];
        $city_id = $data["city_id"];
                
     	try {
     			
            $advert = new Adverts();

     		$advert->user_id = Auth::id();
        	$advert->text  	 = $text;
            $advert->phone1  = $phone1; 

            if (isset($data["adv_phone2"])) $advert->phone2 = $phone2; 
            if (isset($data["adv_phone3"])) $advert->phone3 = $phone3; 

        	$advert->price  		 = $price;
            $advert->category_id  	 = $category;
            $advert->deal  	         = $deal;            
            $advert->region_id       = $region_id;
            $advert->city_id         = $city_id;
            $advert->lang            = "ru";
            $advert->adv_category_id = 0;            
            $advert->vip             = false;
            $advert->full            = false;

            switch($category) {

                // FIXME: Обозвать переменные одинаковыми именами steering_position, engine_type и т.д.

                // --------------------------------
                // транспорт
                // --------------------------------
                case 1: {                    

                    $transport = new Transport();                    
                    
                    $transport->type                 = $data["transport_type"];   // тип транспорта: легковой / грузовой и т.д.
                    $transport->mark                 = null;
                    $transport->model                = null;
                    $transport->year                 = null;
                    $transport->steering_position    = null;
                    $transport->mileage              = null;
                    $transport->engine_type          = null;
                    $transport->customs              = null;
                    
                    // легковушки
                    if ($data["transport_type"]==0) {
                        $transport->mark                = $data["mark_id"];            // id марки авто
                        $transport->model               = $data["model_id"];           // id модели авто                        
                        $transport->year                = $data["release_date"];       // год выпуска
                        $transport->steering_position   = $data["rule_position"];      // положение руля
                        $transport->mileage             = $data["mileage"];            // пробег
                        $transport->engine_type         = $data["fuel_type"];          // тип движка
                        $transport->customs             = $data["customs"];            // растаможка
                        
                        $advert->full = true; // полное объявление с моделями (в item будет указан вид сделки)
                    }

                    // грузовой
                    if ($data["transport_type"]==1) {
                        $transport->year                = $data["release_date"];       // год выпуска
                        $transport->steering_position   = $data["rule_position"];      // положение руля
                        $transport->mileage             = $data["mileage"];            // пробег
                        $transport->engine_type         = $data["fuel_type"];          // тип движка
                        $transport->customs             = $data["customs"];            // растаможка
                    }

                    // мото
                    if ($data["transport_type"]==2) {
                        $transport->year                = $data["release_date"];       // год выпуска
                        $transport->mileage             = $data["mileage"];            // пробег
                        $transport->engine_type         = $data["fuel_type"];          // тип движка
                        $transport->customs             = $data["customs"];            // растаможка
                    }

                    // спецтехника
                    if ($data["transport_type"]==3) {                    
                    }

                    // ретро-авто
                    if ($data["transport_type"]==4) {
                        $transport->year                = $data["release_date"];       // год выпуска
                        $transport->steering_position   = $data["rule_position"];      // положение руля
                        $transport->mileage             = $data["mileage"];            // пробег
                        $transport->engine_type         = $data["fuel_type"];          // тип движка
                        $transport->customs             = $data["customs"];            // растаможка
                    }

                    // водный транспорт
                    if ($data["transport_type"]==5) {                    
                    }

                    // велосипед
                    if ($data["transport_type"]==6) {                    
                    }

                    // воздушный транспорт
                    if ($data["transport_type"]==7) {                    
                    }
                                        
                    $transport->save();

                    // записываю id подкатегории
                    $advert->adv_category_id = $transport->id;  // указываем id' шник

                    break;
                }

                // --------------------------------
                // недвижимость
                // --------------------------------
                case 2: {

                    $realestate = new RealEstate();
                    $realestate->property_type  = $data["property_type"];
                    $realestate->floor          = $data["floor_num"];
                    $realestate->floors_house   = $data["number_of_floors"];
                    $realestate->rooms          = $data["number_of_rooms"];
                    $realestate->area           = $data["area_num"];
                    $realestate->ownership      = $data["property_num"];
                    $realestate->kind_of_object = $data["object_type"];

                    // Дом, Дача, Коттедж
                    if (isset($data["type_of_building"]))
                        $realestate->type_of_building = $data["type_of_building"];

                    // квартира
                    /*if ( $data["property_type"]==0 ) {
                        $advert->full = true; // полное объявление с хар-ками (в item будет указан вид сделки)
                    }*/
                    
                    $advert->full = true; // детальное объявление

                    $realestate->save();

                    // записываю id подкатегории
                    $advert->adv_category_id = $realestate->id;                    
                    break;
                }

                // электроника
                case 3: {
                    //$appliances= new Appliances();
                    break;
                }

                case 4: {
                    break;
                }

                case 5: {
                    break;
                }

                case 6: {
                    break;
                }

                case 7: {
                    break;
                }

                case 8: {
                    break;
                }

                case 9: {
                    break;
                }

                case 10: {
                    break;
                }

            }
            
            // ------------------------------
            // координаты
            // ------------------------------
            if (isset($data["adv_coords"])) {
                $coords = explode(",", $data["adv_coords"]);
                $advert->coord_lat = $coords[0];
                $advert->coord_lon = $coords[1];
                \Debugbar::info($coords);
            }
            else {
                $advert->coord_lat = 0;
                $advert->coord_lon = 0;
            }

            \Debugbar::info("id подкатегории :".$advert->adv_category_id);            
            
            $advert->public = true; // публикую объявление сходу
                        
            $advert->save();  // СОХРАНЕНИЕ ОБЪЯВЛЕНИЯ
            
            // Закидываю данные в таблицу urls для SEO
            $urls = new Urls();
            
            $urls->url = substr($advert->id."-".Helper::str2url($text), 0, 100);
            $urls->advert_id = $advert->id;
            $urls->save();
                         
            // Сохраняю картинки        
            \App\Jobs\loadImages::dispatch($request, $advert->id);
            
            Sitemap::addUrl($urls->url);

            return $advert->id;
		}		
        catch(\Exception $e) {
               return response()->json( ["result"=>"db.error", "msg"=>$e->getMessage()] );  
    	}
     	
     	return $data;
    }

    /*
    -------------------------------------------
    Получить полную информацию об объявлении
    по url
    -------------------------------------------*/
    public function getFullInfoByUrl($url) {    
        
        //$urls = Urls::select("advert_id")->where("url",  $url )->first();
        //return $this->getFullInfo($urls->advert_id);

        $results = DB::select("SELECT advert_id FROM urls WHERE MATCH(url) AGAINST('".$url."')"); // fulltext search
        return $this->getFullInfo($results[0]->advert_id);
    }
    

    private function getStrPrice($results) {
        if ( $results[0]->price >0 && in_array($results[0]->deal, [0,1,4]) ) {
            $str_price = " за ".$results[0]->price." тенге";
            return $str_price;
        }    
    }

    /*
    -------------------------------------------
    Получить полную информацию об объявлении
    по id
    -------------------------------------------*/
    public function getFullInfo($id) {
                
        $results    = []; 
        $images     = [];        
        $title      = "";
        $str_price  = "";

        $adv_full_info = false;

        $petrovich = new Petrovich(Petrovich::GENDER_MALE);		
        
        // выбираю все поля по нужному айдишнику
        $item = DB::table("adverts")->where("id", $id)->get()->first();                                                                

        // -----------------------------------------
        // транспорт (развёрнутая информация)
        // -----------------------------------------
        if ($item->category_id==1) {

            $transport = DB::table("adv_transport")->where("id", $item->adv_category_id)->get()->first();                
                
                switch($transport->type) {
                    
                    // легковушки
                    case 0: {

                        $adv_full_info = true; // развёрнутое объявление

                        $results = DB::select(
					        "SELECT                    
                            DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at, 
                            deal_name_2,					        
					        adv.id as advert_id,                            
                            adv.category_id as category_id,
                            adv.deal,
					        adv.price,
                            adv.phone1,
                            adv.phone2,
                            adv.phone3,
					        adv.text,
                            adv.coord_lat,
                            adv.coord_lon,
                            adv_transport.id,
                            car_mark.name as mark, 
					        car_model.name as model,
					        year,  
					        mileage,
                            steering_position,
                            engine_type,
                            customs,
                            kz_region.name as region_name,
                            kz_city.name as city_name
					    FROM `adverts` as adv
					    INNER JOIN (adv_transport, car_mark, car_model, categories, dealtype, kz_city, kz_region) ON (
						    adv.adv_category_id = adv_transport.id AND
                            adv_transport.mark = car_mark.id_car_mark AND 
						    adv_transport.model = car_model.id_car_model AND                        				
                            adv.deal=dealtype.id AND
                            categories.id=adv.category_id AND                            
                            kz_city.city_id=adv.city_id AND
                            kz_region.region_id=adv.region_id
					    ) WHERE adv.id=".$id." LIMIT 1"
                    );
                     
                    $keywords = "";
                    $description = "";
                    $title = $results[0]->deal_name_2." ".$results[0]->mark." ".$results[0]->model." ".$results[0]->year
                    ." года в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)
                    .$this->getStrPrice($results);
                    
                    break;
            }

            // грузовое авто   
            case 1: {
                        
                        $results = DB::select(
					        "SELECT                    
                            DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                            deal_name_2,					        
                            adv.id as advert_id, 
                            adv.category_id as category_id,
                            adv.deal,
					        adv.price,
                            adv.phone1,
                            adv.phone2,
                            adv.phone3,
					        adv.text,
                            adv.coord_lat,
                            adv.coord_lon,
                            adv_transport.id,
					        year,  
					        mileage,
                            steering_position,
                            engine_type,
                            customs,
                            kz_region.name as region_name,
                            kz_city.name as city_name
					    FROM `adverts` as adv
					    INNER JOIN (adv_transport, categories, dealtype, kz_city, kz_region) ON (						
						    categories.id=adv.category_id AND
                            adv.deal=dealtype.id AND
                            adv.adv_category_id = adv_transport.id AND
                            kz_city.city_id=adv.city_id AND
                            kz_region.region_id=adv.region_id
					    ) WHERE adv.id=".$id." LIMIT 1");

                        \Debugbar::info($results);

                        $keywords = "";
                        $description = "";
                        $title = $results[0]->text." в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)
                        ." ".$results[0]->year." г.в."
                        .$this->getStrPrice($results);

                        break;
                }                    
            
            // мототехника
            case 2: {
                        
                    $results = DB::select(
                        "SELECT
                         DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                         deal_name_2,
                         adv.id as advert_id, 
                         adv.category_id,
                         adv.deal,
                         adv.price,
                         adv.phone1,
                         adv.phone2,
                         adv.phone3,
                         adv.text,
                         adv.coord_lat,
                         adv.coord_lon,
                         adv_transport.id,
                         year,  
                         mileage,                            
                         engine_type,
                         customs,
                         kz_region.name as region_name,
                         kz_city.name as city_name
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport, categories, dealtype, kz_city, kz_region) ON (						
                            categories.id=adv.category_id AND
                            adv.deal=dealtype.id AND
                            adv.adv_category_id = adv_transport.id AND
                            kz_city.city_id=adv.city_id AND
                            kz_region.region_id=adv.region_id
                        ) WHERE adv.id=".$id." LIMIT 1");

                        $keywords = "";
                        $description = "";
                        $title = $results[0]->text." в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)." ".$results[0]->year." г.в."
                        .$this->getStrPrice($results);
                        
                        break;
            }

            // спецтехника
            case 3: {
                        
                $results = DB::select(
                    "SELECT
                    DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,                    
                    deal_name_2,
                    adv.id as advert_id, 
                    adv.category_id,
                    adv.deal,
                    adv.price,
                    adv.phone1,
                    adv.phone2,
                    adv.phone3,
                    adv.text,
                    adv.coord_lat,
                    adv.coord_lon,
                    adv_transport.id,                    
                    kz_region.name as region_name,
                    kz_city.name as city_name
                FROM `adverts` as adv
                INNER JOIN (adv_transport, categories, dealtype, kz_city, kz_region) ON (						
                    categories.id=adv.category_id AND
                    adv.deal=dealtype.id AND
                    adv.adv_category_id = adv_transport.id AND                    
                    kz_city.city_id=adv.city_id AND
                    kz_region.region_id=adv.region_id
                ) WHERE adv.id=".$id." LIMIT 1");

                $keywords = "";
                $description = "";
                $title = $results[0]->text." в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)." ".$this->getStrPrice($results);

                break;
            }

            // ретро авто   
            case 4: {
                        
                $results = DB::select(
                    "SELECT
                    DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                    deal_name_2,
                    adv.id as advert_id, 
                    adv.category_id as category_id,
                    adv.deal,
                    adv.price,
                    adv.phone1,
                    adv.phone2,
                    adv.phone3,
                    adv.text,
                    adv.coord_lat,
                    adv.coord_lon,
                    adv_transport.id,
                    year,  
                    mileage,
                    steering_position,
                    engine_type,
                    customs,
                    kz_region.name as region_name,
                    kz_city.name as city_name
                FROM `adverts` as adv
                INNER JOIN (adv_transport, categories, dealtype, kz_city, kz_region) ON (						
                    categories.id=adv.category_id AND
                    adv.deal=dealtype.id AND
                    adv.adv_category_id = adv_transport.id AND
                    kz_city.city_id=adv.city_id AND
                    kz_region.region_id=adv.region_id
                ) WHERE adv.id=".$id." LIMIT 1");

                $keywords = "";
                $description = "";    
                $title = $results[0]->text." в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)." ".$results[0]->year." г.в."
                .$this->getStrPrice($results);

                break;
            }
        
            // водный
            case 5: {
                        
                $results = DB::select(
                    "SELECT
                    DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                    deal_name_2,
                    adv.id as advert_id, 
                    adv.category_id as category_id,
                    adv.deal,
                    adv.price,
                    adv.phone1,
                    adv.phone2,
                    adv.phone3,                    
                    adv.text,
                    adv.coord_lat,
                    adv.coord_lon,
                    adv_transport.id,
                    kz_region.name as region_name,
                    kz_city.name as city_name
                FROM `adverts` as adv
                INNER JOIN (adv_transport, categories, dealtype, kz_city, kz_region) ON (						
                    categories.id=adv.category_id AND
                    adv.adv_category_id = adv_transport.id AND
                    adv.deal=dealtype.id AND                    
                    kz_city.city_id=adv.city_id AND
                    kz_region.region_id=adv.region_id
                ) WHERE adv.id=".$id." LIMIT 1");

                $keywords = "";
                $description = "";    
                $title = $results[0]->text." в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)
                .$this->getStrPrice($results);

                break;
            }
        
            // велосипед
            case 6: {                        
                $results = DB::select(
                    "SELECT
                    DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                    deal_name_2,
                    adv.id as advert_id, 
                    adv.category_id as category_id,
                    adv.deal,
                    adv.price,
                    adv.phone1,
                    adv.phone2,
                    adv.phone3,
                    adv.text,
                    adv.coord_lat,
                    adv.coord_lon,
                    adv_transport.id,
                    kz_region.name as region_name,
                    kz_city.name as city_name
                FROM `adverts` as adv
                INNER JOIN (adv_transport, categories, dealtype, kz_city, kz_region) ON (						
                    categories.id=adv.category_id AND
                    adv.adv_category_id = adv_transport.id AND
                    adv.deal=dealtype.id AND                    
                    kz_city.city_id=adv.city_id AND
                    kz_region.region_id=adv.region_id
                ) WHERE adv.id=".$id." LIMIT 1");
                
                $keywords = "";
                $description = "";
                $title = $results[0]->text." в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)." ".$this->getStrPrice($results);

                break;
            }
        
            // воздушный
            case 7: {
                        
                $results = DB::select(
                    "SELECT
                    DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                    deal_name_2,
                    adv.id as advert_id, 
                    adv.category_id as category_id,
                    adv.deal,
                    adv.price,
                    adv.phone1,
                    adv.phone2,
                    adv.phone3,
                    adv.text,
                    adv.coord_lat,
                    adv.coord_lon,
                    adv_transport.id,
                    kz_region.name as region_name,
                    kz_city.name as city_name
                FROM `adverts` as adv
                INNER JOIN (adv_transport, categories, dealtype, kz_city, kz_region) ON (						
                    categories.id=adv.category_id AND
                    adv.deal=dealtype.id AND
                    adv.adv_category_id = adv_transport.id AND                    
                    kz_city.city_id=adv.city_id AND
                    kz_region.region_id=adv.region_id
                ) WHERE adv.id=".$id." LIMIT 1");

                $keywords = "";
                $description = "";
                $title = $results[0]->text." в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)." ".$this->getStrPrice($results);
                
                break;
            }                    
                    
        }  // end transport                                                                      
                        

         }

        // -----------------------------------------
        // НЕДВИЖИМОСТЬ (развёрнутая информация)
        // -----------------------------------------
        if ($item->category_id==2) {

                $realestate = DB::table("adv_realestate")->where("id", $item->adv_category_id)->get()->first();

                switch($realestate->property_type) {

                    // квартиры
                    case 0: {
                        
                        $results = DB::select(
                        "SELECT
                            DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                            deal_name_2,
                            adv.id as advert_id, 
                            adv.category_id,
                            adv_realestate.id,
                            adv_realestate.property_type,
                            adv_realestate.rooms, 
                            adv_realestate.floor,
                            adv_realestate.floors_house,
                            adv_realestate.area,                    
                            adv.deal,
                            adv.full,
                            adv.phone1,
                            adv.phone2,
                            adv.phone3,
                            adv.text,                    
                            adv.price,                    
                            kz_region.name as region_name,
                            kz_city.name as city_name                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate, dealtype, kz_city, kz_region) ON ( 
                            adv.adv_category_id=adv_realestate.id AND
                            adv.deal=dealtype.id AND
                            kz_city.city_id=adv.city_id AND
                            kz_region.region_id=adv.region_id
                        ) WHERE adv.id=".$id." LIMIT 1");
                
                        $keywords = "";
                        $description = "";
                        $title = $results[0]->deal_name_2." ".$results[0]->rooms." комнатную квартиру ".$results[0]->floor."/".$results[0]->floors_house." этаж в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)." "
                        .$this->getStrPrice($results);

                        break;
                    }

                    // комната
                    case 1: {
                        
                        $results = DB::select(
                        "SELECT
                            DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                            deal_name_2,
                            adv.id as advert_id, 
                            adv.category_id,
                            adv_realestate.id,
                            adv_realestate.property_type,
                            /*adv_realestate.rooms,*/
                            adv_realestate.floor,
                            adv_realestate.floors_house,
                            adv_realestate.area,                    
                            adv.deal,
                            adv.full,
                            adv.phone1,
                            adv.phone2,
                            adv.phone3,
                            adv.text,                    
                            adv.price,                    
                            kz_region.name as region_name,
                            kz_city.name as city_name                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate, dealtype, kz_city, kz_region) ON ( 
                            adv.adv_category_id=adv_realestate.id AND
                            adv.deal=dealtype.id AND
                            kz_city.city_id=adv.city_id AND
                            kz_region.region_id=adv.region_id
                        ) WHERE adv.id=".$id." LIMIT 1");

                        $keywords = "";
                        $description = "";
                        $title = $results[0]->deal_name_2." комнату, ".$results[0]->floor."/".$results[0]->floors_house." этаж в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)." "
                        .$this->getStrPrice($results);

                        break;
                    }

                    // Дом, дача, коттедж
                    case 2: {
                        
                        $results = DB::select(
                        "SELECT
                            DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                            deal_name_2,                    
                            adv.id as advert_id, 
                            adv.category_id,
                            adv_realestate.id,
                            adv_realestate.property_type,
                            adv_realestate.rooms, 
                            adv_realestate.floor,
                            adv_realestate.floors_house,
                            adv_realestate.area,
                            adv_realestate.type_of_building,
                            adv.deal,
                            adv.full,
                            adv.phone1,
                            adv.phone2,
                            adv.phone3,
                            adv.text,                    
                            adv.price,                    
                            kz_region.name as region_name,
                            kz_city.name as city_name                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate, dealtype, kz_city, kz_region) ON ( 
                            adv.adv_category_id=adv_realestate.id AND
                            adv.deal=dealtype.id AND
                            kz_city.city_id=adv.city_id AND
                            kz_region.region_id=adv.region_id
                        ) WHERE adv.id=".$id." LIMIT 1");                            

                        $type_of_building = "";

                        switch($results[0]->type_of_building) {
                            case 0: $type_of_building = "дом"; break;
                            case 1: $type_of_building = "дачу"; break;
                            case 2: $type_of_building = "коттедж"; break;
                        }


                        $keywords = "";
                        $description = "";
                        $title = $results[0]->deal_name_2." ".$type_of_building." ".$results[0]->floor."/".$results[0]->floors_house." этаж в ".
                        $petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)." ".$this->getStrPrice($results);
                        
                        break;
                    }

                    // Земельный участок
                    case 3: {
                        
                        $results = DB::select(
                        "SELECT
                            DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                            deal_name_2,                    
                            adv.id as advert_id, 
                            adv.category_id,
                            adv_realestate.id,
                            adv_realestate.property_type,
                            adv_realestate.rooms, 
                            adv_realestate.floor,
                            adv_realestate.floors_house,
                            adv_realestate.area,                    
                            adv.deal,
                            adv.full,
                            adv.phone1,
                            adv.phone2,
                            adv.phone3,
                            adv.text,                    
                            adv.price,                    
                            kz_region.name as region_name,
                            kz_city.name as city_name                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate, dealtype, kz_city, kz_region) ON ( 
                            adv.adv_category_id=adv_realestate.id AND
                            adv.deal=dealtype.id AND
                            kz_city.city_id=adv.city_id AND
                            kz_region.region_id=adv.region_id
                        ) WHERE adv.id=".$id." LIMIT 1");
                        
                        $keywords = "";
                        $description = "";
                        $title = $results[0]->deal_name_2." земельный участок в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)." "
                        .$this->getStrPrice($results);
                        
                        break;
                    }

                    // Гараж иил машиноместо
                    case 3: {
                        
                        $results = DB::select(
                        "SELECT
                            DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                            deal_name_2,                    
                            adv.id as advert_id, 
                            adv.category_id,
                            adv_realestate.id,
                            adv_realestate.property_type,
                            adv_realestate.rooms, 
                            adv_realestate.floor,
                            adv_realestate.floors_house,
                            adv_realestate.area,                    
                            adv.deal,
                            adv.full,
                            adv.phone1,
                            adv.phone2,
                            adv.phone3,
                            adv.text,                    
                            adv.price,                    
                            kz_region.name as region_name,
                            kz_city.name as city_name                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate, dealtype, kz_city, kz_region) ON ( 
                            adv.adv_category_id=adv_realestate.id AND
                            adv.deal=dealtype.id AND
                            kz_city.city_id=adv.city_id AND
                            kz_region.region_id=adv.region_id
                        ) WHERE adv.id=".$id." LIMIT 1");
                            
                        $keywords = "";
                        $description = "";
                        $title = $results[0]->deal_name_2." комнату, ".$results[0]->floor."/".$results[0]->floors_house." этаж в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)." "
                        .$this->getStrPrice($results);

                        break;
                    }

                    // Гараж или машиноместо
                    case 4: {
                        
                        $results = DB::select(
                        "SELECT
                            DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                            deal_name_2,                    
                            adv.id as advert_id, 
                            adv.category_id,
                            adv_realestate.property_type,
                            adv_realestate.id,
                            adv_realestate.rooms, 
                            adv_realestate.floor,
                            adv_realestate.floors_house,
                            adv_realestate.area,                    
                            adv.deal,
                            adv.full,
                            adv.phone1,
                            adv.phone2,
                            adv.phone3,
                            adv.text,                    
                            adv.price,                    
                            kz_region.name as region_name,
                            kz_city.name as city_name                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate, dealtype, kz_city, kz_region) ON ( 
                            adv.adv_category_id=adv_realestate.id AND
                            adv.deal=dealtype.id AND
                            kz_city.city_id=adv.city_id AND
                            kz_region.region_id=adv.region_id
                        ) WHERE adv.id=".$id." LIMIT 1");
                            
                        $keywords = "";
                        $description = "";
                        $title = $results[0]->deal_name_2." комнату, ".$results[0]->floor."/".$results[0]->floors_house." этаж в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)." "
                        .$this->getStrPrice($results);
                        
                        break;
                    }

                    // Коммерческая недвижимость
                    case 5: {
                        
                        $results = DB::select(
                        "SELECT
                            DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                            deal_name_2,                    
                            adv.id as advert_id, 
                            adv.category_id,
                            adv_realestate.id,
                            adv_realestate.property_type,
                            adv_realestate.rooms, 
                            adv_realestate.floor,
                            adv_realestate.floors_house,
                            adv_realestate.area,                    
                            adv.deal,
                            adv.full,
                            adv.phone1,
                            adv.phone2,
                            adv.phone3,
                            adv.text,                    
                            adv.price,                    
                            kz_region.name as region_name,
                            kz_city.name as city_name                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate, dealtype, kz_city, kz_region) ON ( 
                            adv.adv_category_id=adv_realestate.id AND
                            adv.deal=dealtype.id AND
                            kz_city.city_id=adv.city_id AND
                            kz_region.region_id=adv.region_id
                        ) WHERE adv.id=".$id." LIMIT 1");

                        $keywords = "";
                        $description = "";
                        $title = $results[0]->deal_name_2." комнату, ".$results[0]->floor."/".$results[0]->floors_house." этаж в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)." "
                        .$this->getStrPrice($results);
                        
                        break;
                    }

                    // Недвижимость за рубежом
                    case 6: {
                        
                        $results = DB::select(
                        "SELECT
                            DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                            deal_name_2,                    
                            adv.id as advert_id, 
                            adv.category_id,
                            adv_realestate.id,
                            adv_realestate.property_type,
                            adv_realestate.rooms, 
                            adv_realestate.floor,
                            adv_realestate.floors_house,
                            adv_realestate.area,                    
                            adv.deal,
                            adv.full,
                            adv.phone1,
                            adv.phone2,
                            adv.phone3,
                            adv.text,                    
                            adv.price,                    
                            kz_region.name as region_name,
                            kz_city.name as city_name                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate, dealtype, kz_city, kz_region) ON ( 
                            adv.adv_category_id=adv_realestate.id AND
                            adv.deal=dealtype.id AND
                            kz_city.city_id=adv.city_id AND
                            kz_region.region_id=adv.region_id
                        ) WHERE adv.id=".$id." LIMIT 1");

                        $keywords = "";
                        $description = "";
                        $title = $results[0]->deal_name_2." комнату, ".$results[0]->floor."/".$results[0]->floors_house." этаж в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL)." "
                        .$this->getStrPrice($results);
                        
                        break;
                    }
                }
            }

            // ----------------------------------------
            // категории без развёрнутой информации
            // описание пользователя
            // ----------------------------------------
            if ( $item->category_id==3 || 
                 $item->category_id==4 || 
                 $item->category_id==5 || 
                 $item->category_id==6 || 
                 $item->category_id==7 || 
                 $item->category_id==8 || 
                 $item->category_id==9 || 
                 $item->category_id==10) {                      
            
                $results = DB::select(
                    "SELECT
                    DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
                    /*deal_name_2,*/
                    adv.category_id,
                    adv.id as advert_id,
                    /*adv.deal,*/
                    adv.price,
                    adv.phone1,
                    adv.phone2,
                    adv.phone3,
                    adv.text,
                    adv.coord_lat,
                    adv.coord_lon,
                    kz_region.name as region_name,
                    kz_city.name as city_name              
                    /*FROM `adverts` as adv INNER JOIN (dealtype, kz_city, kz_region) ON (*/
                    FROM `adverts` as adv INNER JOIN (kz_city, kz_region) ON (
                        /*adv.deal=dealtype.id AND*/
                        kz_city.city_id=adv.city_id AND
                        kz_region.region_id=adv.region_id
                    ) WHERE adv.id=".$id." LIMIT 1"
                );

                if ( $results[0]->price >0 )
                    $str_price = " за ".$results[0]->price." тенге";
                 
                $keywords = "";
                $description = "";    
                //$title = $results[0]->text." в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL).$this->getStrPrice($results);
                $title = $results[0]->text." в ".$petrovich->firstname($results[0]->city_name, Petrovich::CASE_PREPOSITIONAL).$str_price;
            }

            // выбираю изображения
            $images = DB::select("SELECT image FROM images WHERE advert_id=".$id);

            // передаю данные во вьюху
            return view("detailed")
            ->with("keywords", $keywords)
            ->with("description", $description)
            ->with("title", $title)
            ->with("item", json_encode($results) )
            ->with("images", json_encode($images))
            ->with("full", json_encode($adv_full_info));
    }

    /*
    ----------------------------------
    Выбор марок авто
    ----------------------------------*/
     public function getCarsMarks() {

        $redis = Redis::connection();

        try {								
            $redis->ping();
            $car_marks = $redis->get("car_marks");
            if (!$car_marks) {
                $redis->set("car_marks", CarMark::all("id_car_mark", "name"));
                $car_marks = $redis->get("car_marks");
            }
        }
        catch(\Exception $e) {
            \Debugbar::warning($e->getMessage());
            $car_marks = CarMark::all("id_car_mark", "name");
        }

	    return $car_marks;
    }

    /*
    ----------------------------------
    Выбор моделей авто
    ----------------------------------*/
    public function getCarsModels(Request $request) {
     	return DB::table("car_model")->where("id_car_mark", $request->mark_id )->get();
    }
}