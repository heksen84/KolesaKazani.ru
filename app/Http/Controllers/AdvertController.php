<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Redis;
//use App\Helpers\Petrovich;
use App\Helpers\Helper;
use App\Helpers\Sitemap;
use App\Adverts;
use App\CarMark;
use App\Categories;
use App\Transport;
use App\RealEstate;
use App\DealType;
use App\Regions;
use App\SubCats;
use App\Urls;
use Validator;
use DB;

class AdvertController extends Controller {

    // js "null" в php null
    private function to_php_null($value) {
        return ($value==="null")?null:$value;
    }
    
    // Новое объявление
    public function NewAd() {
        return Auth::user()? view("newad")
        ->with( "title", "Новое объявление - Объявление на сайте ".config('app.name') )
        ->with( "description", "подать новое объявление")
        ->with( "keywords", "новое объявление")
        ->with( "categories", Categories::all() )
        ->with( "regions", Regions::all() )
        ->with( "dealtypes", DealType::all()->toJson() ) : redirect("login");
    }

    /*
    ----------------------------------
    Выбор марок авто
    ----------------------------------*/
     public function getCarsMarks() {

/*        $redis = Redis::connection();

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
*/
          $car_marks = CarMark::all("id_car_mark", "name");
	  return $car_marks;
    }

    /*
    ----------------------------------------------------
    Выбор моделей авто
    ----------------------------------------------------*/
    public function getCarsModels(Request $request) {
     	return DB::table("car_model")->where("id_car_mark", $request->mark_id )->get();
    }

    public function getSubcategoryDataById(Request $request) {
        \Debugbar::info("CATEGORY ID: ".$request->id);
        return SubCats::select( "id", "name" )->where("category_id", $request->id)->get();
    }

    /*
    -----------------------------------------------
    Создать объявление
    -----------------------------------------------*/
    public function createAdvert(Request $request) {                

        $data = $request->all();
    
        \Debugbar::info("----[ Входящие данные ]----");
        \Debugbar::info($data);
        \Debugbar::info("---------------------------");

        // ---------------------------
        // правила валидации
        // ---------------------------
        $rules = [            
            "adv_category"  => "required", 
            "adv_phone"     => "required",
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
            "adv_phone.required"       => "Укажите телефон",            
            "images.*.image"           => "Только изображения!",
            "region_id.required"       => "Укажите регион",
            "region_id.numeric"        => "Введите числовое значение для региона",
            "city_id.required"         => "Укажите расположение",
            "city_id.numeric"          => "Введите числовое значение для расположения"
        ];

        
        // проверка
        $validator = Validator::make( $data, $rules, $messages );

        // если проверка не прошла
        if ( $validator->fails() )  
            return response()->json( ["result"=>"usr.error", "msg" => $validator->errors()->first()] );                    

        $category       = $data["adv_category"];
        $subcategory    = $data["adv_subcategory"];
        $deal           = $data["adv_deal"]; // Вид сделки
        $text           = $data["adv_info"];        
        $phone          = $data["adv_phone"];

        $price = $this->to_php_null($data["adv_price"]);
        
        $region_id = $data["region_id"];
        $city_id = $data["city_id"];
                
     	try {
     			
            $advert = new Adverts();

     		$advert->user_id         = Auth::id();
        	$advert->text  	         = $text;
            $advert->phone           = $phone; 
        	$advert->price  		 = $price;
            $advert->category_id  	 = $category;
            $advert->sub_category_id = $subcategory;
            $advert->deal  	         = $deal;            
            $advert->region_id       = $region_id;
            $advert->city_id         = $city_id;
            $advert->lang            = "ru";
            $advert->sub_category_id = 0;            
            $advert->vip             = false;
            $advert->full            = false;


            \Debugbar::info("advert->sub_category_id = ".$subcategory);

            $url_text = ""; // строка url в sitemap

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


                    \Debugbar::info("NULL PHP: ".$transport->year);
                    
                    // легковушки
                    if ($data["transport_type"]==0) {
                        $transport->mark                = $data["mark_id"];            // id марки авто
                        $transport->model               = $data["model_id"];           // id модели авто                        
                        $transport->year                = $data["release_date"];       // год выпуска
                        $transport->steering_position   = $data["rule_position"];      // положение руля
                        $transport->mileage             = $data["mileage"];            // пробег
                        $transport->engine_type         = $data["fuel_type"];          // тип движка
                        $transport->customs             = $data["customs"];            // растаможка

                        // значение записи url в sitemap.xml
                        $url_text = "Транспорт легковое авто";
                        
                        $advert->full = true; // полное объявление с моделями (в item будет указан вид сделки)
                    }                    
                    
                    // грузовой
                    if ($data["transport_type"]==1) {

                        \Debugbar::info("NULL JS: ".$data["release_date"]);

                        $transport->year                = $data["release_date"];       // год выпуска
                        $transport->steering_position   = $data["rule_position"];      // положение руля
                        $transport->mileage             = $data["mileage"];            // пробег
                        $transport->engine_type         = $data["fuel_type"];          // тип движка
                        $transport->customs             = $data["customs"];            // растаможка

                        // значение записи url в sitemap.xml
                        $url_text = "Транспорт грузовое авто";
                    }

                    // мото
                    if ($data["transport_type"]==2) {

                        $transport->year            = $this->to_php_null($data["release_date"]);       // год выпуска
                        $transport->mileage         = $this->to_php_null($data["mileage"]);            // пробег
                        $transport->engine_type     = $this->to_php_null($data["fuel_type"]);          // тип движка
                        $transport->customs         = $this->to_php_null($data["customs"]);            // растаможка

                        // значение записи url в sitemap.xml
                        $url_text = "Транспорт мото";
                    }

                    // спецтехника
                    if ($data["transport_type"]==3) {                        

                        $transport->year            = $this->to_php_null($data["release_date"]);       // год выпуска
                        $transport->mileage         = $this->to_php_null($data["mileage"]);            // пробег
                        $transport->engine_type     = $this->to_php_null($data["fuel_type"]);          // тип движка
                        $transport->customs         = $this->to_php_null($data["customs"]);            // растаможка

                        // значение записи url в sitemap.xml
                        $url_text = "Транспорт спецтехника";
                    }

                    // ретро-авто
                    if ($data["transport_type"]==4) {

                        $transport->year                = $data["release_date"];       // год выпуска
                        $transport->steering_position   = $data["rule_position"];      // положение руля
                        $transport->mileage             = $data["mileage"];            // пробег
                        $transport->engine_type         = $data["fuel_type"];          // тип движка
                        $transport->customs             = $data["customs"];            // растаможка

                        // значение записи url в sitemap.xml
                        $url_text = "Транспорт спецтехника";
                    }

                    // водный транспорт
                    if ($data["transport_type"]==5) {

                        $transport->year            = $this->to_php_null($data["release_date"]);       // год выпуска
                        $transport->mileage         = $this->to_php_null($data["mileage"]);            // пробег
                        $transport->engine_type     = $this->to_php_null($data["fuel_type"]);          // тип движка
                        $transport->customs         = $this->to_php_null($data["customs"]);            // растаможка

                        // значение записи url в sitemap.xml
                        $url_text = "Транспорт водный";
                    }

                    // велосипед
                    if ($data["transport_type"]==6) {

                        $transport->year            = $this->to_php_null($data["release_date"]);       // год выпуска
                        $transport->mileage         = $this->to_php_null($data["mileage"]);            // пробег
                        $transport->engine_type     = $this->to_php_null($data["fuel_type"]);          // тип движка
                        $transport->customs         = $this->to_php_null($data["customs"]);            // растаможка


                        // значение записи url в sitemap.xml
                        $url_text = "Транспорт велосипед";
                    }

                    // воздушный транспорт
                    if ($data["transport_type"]==7) {

                        $transport->year            = $this->to_php_null($data["release_date"]);       // год выпуска
                        $transport->mileage         = $this->to_php_null($data["mileage"]);            // пробег
                        $transport->engine_type     = $this->to_php_null($data["fuel_type"]);          // тип движка
                        $transport->customs         = $this->to_php_null($data["customs"]);            // растаможка

                        // значение записи url в sitemap.xml
                        $url_text = "Транспорт воздушный";
                    }
                                        
                    $transport->save();

                    // записываю id подкатегории
                    $advert->sub_category_id = $transport->id;  // указываем id' шник
                    break;
                }

                // --------------------------------
                // недвижимость
                // --------------------------------
                case 2: {

                    $realestate = new RealEstate();
                    $realestate->property_type  = $this->to_php_null($data["property_type"]);
                    $realestate->floor          = $this->to_php_null($data["floor_num"]);
                    $realestate->floors_house   = $this->to_php_null($data["number_of_floors"]);
                    $realestate->rooms          = $this->to_php_null($data["number_of_rooms"]);
                    $realestate->area           = $this->to_php_null($data["area_num"]);
                    $realestate->ownership      = $this->to_php_null($data["property_num"]);
                    $realestate->kind_of_object = $this->to_php_null($data["object_type"]);

                    // Дом, Дача, Коттедж
                    if (isset($data["type_of_building"]))
                        $realestate->type_of_building = $this->to_php_null($data["type_of_building"]);

                    // квартира
                    /*if ( $data["property_type"]==0 ) {
                        $advert->full = true; // полное объявление с хар-ками (в item будет указан вид сделки)
                    }*/
                    
                    $advert->full = true; // детальное объявление

                    $realestate->save();

                    // записываю id подкатегории
                    $advert->sub_category_id = $realestate->id;

                    // значение записи url в sitemap.xml
                    $url_text = "Недвижимость квартира";

                    break;
                }

                // электроника
                case 3: {
                    $advert->sub_category_id = $subcategory;
                    break;
                }

                case 4: {
                    $advert->sub_category_id = $subcategory;
                    break;
                }

                case 5: {
                    $advert->sub_category_id = $subcategory;
                    break;
                }

                case 6: {
                    $advert->sub_category_id = $subcategory;
                    break;
                }

                case 7: {
                    $advert->sub_category_id = $subcategory;
                    break;
                }

                case 8: {
                    $advert->sub_category_id = $subcategory;
                    break;
                }

                case 9: {
                    $advert->sub_category_id = $subcategory;
                    break;
                }

                case 10: {
                    $advert->sub_category_id = $subcategory;
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

            \Debugbar::info("id подкатегории :".$advert->sub_category_id);            
            
            
            $advert->public = true; // публикую объявление сходу                        
            $advert->save();  // СОХРАНЕНИЕ ОБЪЯВЛЕНИЯ
            
            // Закидываю данные в таблицу urls для SEO
            $urls = new Urls();

            // url sitemap
            if (strlen($text) > 5)
                $url_text = $text;
            
            $urls->url = substr($advert->id."-".Helper::str2url($url_text), 0, 100);
            $urls->advert_id = $advert->id;
            $urls->save();
                         
            // Сохраняю картинки        
            //\App\Jobs\loadImages::dispatch($request, $advert->id);
            

	    // --------------------------------------
	    // Определяю теги категории:
	    // Например транспорт
	    // --------------------------------------
	    // tag, advert_id
	    // --------------------------------------
	    // Авто,   134
	    // Тойота, 134
	    // Камри,  134
            
        Sitemap::addUrl($urls->url);

        return $advert->id;        
        }		
        
        catch(\Exception $e) {
            return response()->json([ "result" => "db.error", "msg" => $e->getMessage() ]);  
    	}
     	
     	return $data;
    }

    
    
}