<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Urls;
use App\SubCats;
use App\CarMark;
use App\Regions;
use App\Places;
use App\Transport;
use App\RealEstate;
use App\Helpers\ObsceneCensorRus;
use App\Helpers\Helper;
use App\Helpers\Sitemap;
use App\Adverts;
use Validator;
use DB;

class ApiController extends Controller {

    // js "null" в php null
    private function to_php_null($value) {
        return ($value==="null")?null:$value;
    }

   // Получить имена подкатегорий
    public function getSubCategoryNamesById(Request $request) {
        return SubCats::select( "id", "name" )->where("category_id", $request->id)->where("lang", 0)->get();
    }

    // Выбор марок авто
    public function getCarsMarks() {
        $car_marks = CarMark::all("id_car_mark", "name");
        return $car_marks;
    }
        
    // Выбор моделей авто
    public function getCarsModels(Request $request) {
        return DB::table("car_model")->where("id_car_mark", $request->mark_id )->get();
    }

    // Получить расположение
    public function GetRegions() {
        return Regions::all();
   }

    // Получить расположение
    public function GetPlaces(Request $request) {
        return Places::where("region_id",  $request->region_id )->orderBy("name", "asc")->get();
   }

   /*
    -----------------------------------------------
    Создать объявление
    -----------------------------------------------*/
    public function createAdvert(Request $request) {                

        $data = $request->all();
    
        \Debugbar::info("----[ Входящие данные ]----");
        \Debugbar::info($data);        

        // ---------------------------
        // правила валидации
        // ---------------------------
        $rules = [            
            "adv_title"     => "required|string|min:9|max:100", 
            "adv_category"  => "required|numeric|min:0", 
            "adv_phone"     => "required|string|max:14",
            "adv_info"      => "string",
            "images.*"      => "image|mimes:jpeg,png,jpg",
            "region_id"     => "required|numeric|min:0",
            "city_id"       => "required|numeric|min:0"
        ]; 

        // ---------------------------
        // сообщения валидации
        // ---------------------------
        $messages = [            
            "adv_title.required"       => "Не указан заголовок объявления",            
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
        if ( $validator->fails() ) { 
            return response()->json( ["result"=>"usr.error", "msg" => $validator->errors()->first()] );                    
        }

        $title      = $data["adv_title"];
        $category   = $data["adv_category"];        
        $text       = $data["adv_info"];        
        $phone      = $data["adv_phone"];        
        $region_id  = $data["region_id"];
        $city_id    = $data["city_id"];

        //\Debugbar::info(ObsceneCensorRus::isAllowed($title)?"чисто":"обнаружен мат");
		//\Debugbar::info(ObsceneCensorRus::isAllowed($text)?"чисто":"обнаружен мат");

        if (!ObsceneCensorRus::isAllowed($title) || !ObsceneCensorRus::isAllowed($text)) {
            return response()->json( ["result"=>"usr.error", "msg" => "нецензурная лексика"] );
        }

        // поля которым требуется приведение к типу null
        $subcategory = $this->to_php_null($data["adv_subcategory"]);        
        $price       = $this->to_php_null($data["adv_price"]);
                
     	try {     			
            $advert = new Adverts();

     		$advert->user_id         = Auth::id();
            $advert->title  	     = $title;
            $advert->text  	         = $text;
            $advert->phone           = $phone; 
        	$advert->price  		 = $price;
            $advert->category_id  	 = $category;
            $advert->subcategory_id  = $subcategory;            
            $advert->region_id       = $region_id;
            $advert->city_id         = $city_id;
            $advert->lang            = "ru";            
            $advert->vip             = false;            

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
                    $advert->inner_id = $transport->id;  // указываем id' шник

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
                    

                    $realestate->save();

                    // записываю id подкатегории
                    $advert->inner_id = $realestate->id;

                    // значение записи url в sitemap.xml
                    $url_text = "Недвижимость квартира";

                    break;
                }

                // электроника
                case 3: {
                    $advert->inner_id = $subcategory;
                    break;
                }

                case 4: {
                    $advert->inner_id = $subcategory;
                    break;
                }

                case 5: {
                    $advert->inner_id = $subcategory;
                    break;
                }

                case 6: {
                    $advert->inner_id = $subcategory;
                    break;
                }

                case 7: {
                    $advert->inner_id = $subcategory;
                    break;
                }

                case 8: {
                    $advert->inner_id = $subcategory;
                    break;
                }

                case 9: {
                    $advert->inner_id = $subcategory;
                    break;
                }

                case 10: {
                    $advert->inner_id = $subcategory;
                    break;
                }

            }
                        
            // координаты            
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
            
            $advert->public = true; // публикую объявление сходу                        
            $advert->save();  // СОХРАНЕНИЕ ОБЪЯВЛЕНИЯ
            
            $urls = new Urls(); // Закидываю данные в таблицу urls для SEO

            // url sitemap
            if (strlen($text) > 5) 
                $url_text = $text;
            
            $urls->url = substr($advert->id."-".Helper::str2url($url_text), 0, 100);
            $urls->advert_id = $advert->id;
            $urls->save();
                         
            // Сохраняю картинки        
            \App\Jobs\loadImages::dispatch($request, $advert->id);
            
            Sitemap::addUrl($urls->url);
            return $advert->id;
        }		
        
        catch(\Exception $e) {
            return response()->json([ "result" => "db.error", "msg" => $e->getMessage() ]);  
    	}
     	
     	return $data;
    }
    
}
