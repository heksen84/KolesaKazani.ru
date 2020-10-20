<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManagerStatic as Image;
use App\Helpers\Common;
use App\Jobs\LoadImages;
use App\Jobs\DeleteTempImages;
use App\Jobs\DeleteImagesFromCloud;
use App\Urls;
use App\SubCats;
use App\CarMark;
use App\Regions;
use App\Places;
use App\Transport;
use App\RealEstate;
use App\Images;
use App\Adverts;
use App\Helpers\ObsceneCensorRus;
use App\Helpers\Sitemap;
use Carbon\Carbon;
use Validator;

class ApiController extends Controller {

    private $region_id;
    private $img_loaded = false;
        
    // --------------------------------------
    // загрузка изображения на лету
    // --------------------------------------
    public function loadImage(Request $request) {

        \Debugbar::info("UID: ".$request->uid);        

        if ($request->file("image")) {            

            $this->img_loaded = false;

            $img = $request->file("image");
            \Debugbar::info($img);

            // получаю имя изображения
            $imageOriginalName = $img->getClientOriginalName();
            
            // ищу изображения без привязки к объявлению т.е. advert_id = null
            $imagesCount = Images::where("originalName", $imageOriginalName)->where("advert_id", null)->get()->count();            

            if ( $imagesCount === 0 ) {

                $imagesArray = [];
                
                \Debugbar::info("Свободного места на диске: ".Common::getFreeDiskSpace(".")." гб.");

                        // узнаю реальный путь к файлу
                        $imgLib = Image::make($img->getRealPath())->orientate();
                        
                        // формирую рандомное имя
                        $newFilename = str_random(16).".".$img->getClientOriginalExtension();
                                                                        
                        // меняю размер и сохраняю изображение (800x600)
                        if ($imgLib->fit(800, 600)->save(Common::NORMAL_IMAGES_LOCAL_STORAGE_PATH.$newFilename)) {

                            // поменять путь исходя из оставшегося места на диске
                            $arrayRecord = array("path" => Common::NORMAL_IMAGES_LOCAL_STORAGE_PATH, "name" => $newFilename, "type" => "normal");
                            array_push($imagesArray, $arrayRecord);          
                            $this->img_loaded = true;                                  
                        }                                                                                                        

                        // меняю размер и сохраняю изображение (250x250)
                        if ($imgLib->fit(250, 250)->save(Common::SMALL_IMAGES_LOCAL_STORAGE_PATH.$newFilename) && $this->img_loaded === true) {

                            // поменять путь исходя из оставшегося места на диске
                            $arrayRecord = array("path" => Common::SMALL_IMAGES_LOCAL_STORAGE_PATH, "name" => $newFilename, "type" => "small");
                            array_push($imagesArray, $arrayRecord);          
                            $this->img_loaded = true;
                        } 

                        if ($this->img_loaded) {

                            \Debugbar::info("Пишу в таблицу");

                            // записать в таблицу
                            $imgRecord = new Images();
                            $imgRecord->advert_id = null;
                            $imgRecord->name = $newFilename;
                            $imgRecord->originalName = $imageOriginalName;
                            $imgRecord->storage_id = 0;
                            $imgRecord->uid = $request->uid;
                            $imgRecord->save();
                        }
                        else
                            return response()->json([ "error" => "error", "msg" => "невозможно загрузить изображение" ]);

                        // Если свободного места осталось мало, то сохраняю в облако и удаляю временные изображения
                        if (Common::getFreeDiskSpace(".") < Common::MIN_FREE_DISK_SPACE_IN_GB) {
                                
                            \Debugbar::info("Сохраняю изображения в облако...");                                

                            // отправляю в очередь
                            LoadImages::dispatch($imagesArray);
                            DeleteTempImages::dispatch($imagesArray);
                            
                            // сразу добавить запись в бд
                            return response()->json([ "result" => "success", "msg" => $imageOriginalName." загружен" ]);
                        }                                                
            }
        }

        return response()->json([ "result" => "success", "msg" => $imageOriginalName." пропущен" ]);
    }

    // --------------------------------------
    // удаление изображения на лету
    // рекурсивная функция
    // --------------------------------------
    public function deleteImage(Request $request, $storage_id) {

        \Debugbar::info("storage_id: ".$storage_id);
        \Debugbar::info("image name: ".$request->image);
        \Debugbar::info("uid: ".$request->uid);
        
        $images = Images::select("name")->where("uid", $request->uid)->where("originalName", $request->image)->where("storage_id", $storage_id)->get();

        if (count($images) > 0) {            

            $imagesArray = [];
            
            foreach($images as $img) {            

                $arrayRecord = array("path" => Common::NORMAL_IMAGES_LOCAL_STORAGE_PATH, "name" => $img->name, "type" => "normal");
                array_push($imagesArray, $arrayRecord);                                
                
                $arrayRecord = array("path" => Common::SMALL_IMAGES_LOCAL_STORAGE_PATH, "name" => $img->name, "type" => "small");
                array_push($imagesArray, $arrayRecord);                                
            }

            \Debugbar::info($imagesArray);                                    
                        
            if ( $storage_id == 0 ) {                
                DeleteTempImages::dispatch($imagesArray);                                                    
                return response()->json([ "result" => "success", "Файлы на удаление на очереди" ]);  
            }
            
            if ( $storage_id == 1 ) {
                DeleteImagesFromCloud::dispatch($imagesArray);
                return response()->json([ "result" => "success", "Файлы на удаление облака на очереди" ]);  
            }
        }
        else
            $this->deleteImage($request, 1);     
    }

    // --------------------------------------
    // js "null" в php null
    // --------------------------------------
    private function to_php_null($value) {
        return ( $value === "null" ) ? null : $value;
    }

   // --------------------------------------
    // Получить имена подкатегорий
    // --------------------------------------
    public function getSubCategoryNamesById(Request $request) {
        return SubCats::select( "id", "name" )->where("category_id", $request->id)->get();
    }

    // --------------------------------------
    // Выбор марок авто
    // --------------------------------------
    public function getCarsMarks() {
        $car_marks = CarMark::all("id_car_mark", "name");
        return $car_marks;
    }
        
    // --------------------------------------
    // Выбор моделей авто
    // --------------------------------------
    public function getCarsModels(Request $request) {
        return DB::table("car_model")->where("id_car_mark", $request->mark_id )->get();
    }

    // --------------------------------------
    // Получить расположение
    // --------------------------------------
    public function GetRegions() {
        return Regions::all();
    }

    // --------------------------------------
    // Получить расположение
    // --------------------------------------
    public function GetPlaces(Request $request) {
        
//        Cache::flush();

        $this->region_id = $request->region_id;

        $values = Cache::get("ilbo:places_".$this->region_id, function () {                        
            \Debugbar::info("Значения из базы");
            $places = Places::where("region_id", $this->region_id  )->orderBy("name", "asc")->get();                                    
            Cache::put("ilbo:places_".$this->region_id, $places);
            return $places;
        });

        \Debugbar::info("Значения из кэша");

        return $values;
    }

    // --------------------------------------
    // Получить расположение
    // --------------------------------------
    public function getPhoneNumber(Request $request) {
        return Adverts::select("phone")->where("id",  $request->id )->get();
    }

    public function searchPlaceByString(Request $request) {        
        
        $items = DB::table("kz_city as city")
        ->select("city.name as city_name", "region.name as region_name", DB::raw('CONCAT(region.url,"/",city.url) as url'))                
        ->join("kz_region as region", "city.region_id", "=", "region.region_id" )        
        ->whereRaw("MATCH (city.name) AGAINST('".$request->searchString."' IN BOOLEAN MODE)")->get();
        
        return $items;
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
            "adv_title"     => "required|string|min:5|max:100", 
            "adv_category"  => "required|numeric|min:0", 
            "adv_phone"     => "required|string|max:14",            
            "region_id"     => "required|numeric|min:0",
            "city_id"       => "required|numeric|min:0",
            "images.*"      => "image|mimes:jpeg,png,jpg|max:8128",
            "adv_info"      => "string"
        ]; 

        // -----------------------------------
        // сообщения валидации        
        // resources/lang/ru/validation.php
        // -----------------------------------
        $messages = [            
            "adv_title.required"       => "Не указан заголовок объявления",            
            "adv_title.min"            => "Заголовок объявления должен быть не менее :min символов",            
            "adv_category.required"    => "Укажите категорию товара или услуги",            
            "adv_phone.required"       => "Укажите телефон",            
            "images.*.image"           => "Только изображения!",
            "images.*.max"             => "Максимальный размер изображения :max мб.",
            "region_id.required"       => "Укажите регион",
            "region_id.numeric"        => "Введите числовое значение для региона",
            "city_id.required"         => "Укажите расположение",
            "city_id.numeric"          => "Введите числовое значение для расположения"
        ];        

        // проверка
        $validator = Validator::make( $data, $rules, $messages );

        // если проверка не прошла
        if ( $validator->fails() ) { 
            return response()->json( ["result" => "error", "title" => "Внимание!", "msg" => $validator->errors()->first()] );                    
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
            return response()->json( ["result" => "error", "title" => "Объявление отклонено", "msg" => "нецензурная лексика"] );
        }

        // поля которым требуется приведение к типу null
        $subcategory = $this->to_php_null($data["adv_subcategory"]);        
        $price = $this->to_php_null($data["adv_price"]);
        
                
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
                    if ( $data["transport_type"] == 1 ) {
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
                    if ( $data["transport_type"] == 2 ) {

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
                    if ( $data["transport_type"] == 3 ) {

                        $transport->year            = $this->to_php_null($data["release_date"]);       // год выпуска
                        $transport->mileage         = $this->to_php_null($data["mileage"]);            // пробег
                        $transport->engine_type     = $this->to_php_null($data["fuel_type"]);          // тип движка
                        $transport->customs         = $this->to_php_null($data["customs"]);            // растаможка

                        // значение записи url в sitemap.xml
                        $url_text = "Транспорт мото";
                    }

                    // спецтехника
                    if ( $data["transport_type"] == 4 ) {                        

                        $transport->year            = $this->to_php_null($data["release_date"]);       // год выпуска
                        $transport->mileage         = $this->to_php_null($data["mileage"]);            // пробег
                        $transport->engine_type     = $this->to_php_null($data["fuel_type"]);          // тип движка
                        $transport->customs         = $this->to_php_null($data["customs"]);            // растаможка

                        // значение записи url в sitemap.xml
                        $url_text = "Транспорт спецтехника";
                    }

                    // ретро-авто
                    if ( $data["transport_type"] == 5 ) {

                        $transport->year                = $data["release_date"];       // год выпуска
                        $transport->steering_position   = $data["rule_position"];      // положение руля
                        $transport->mileage             = $data["mileage"];            // пробег
                        $transport->engine_type         = $data["fuel_type"];          // тип движка
                        $transport->customs             = $data["customs"];            // растаможка

                        // значение записи url в sitemap.xml
                        $url_text = "Транспорт спецтехника";
                    }

                    // водный транспорт
                    if ( $data["transport_type"] == 6 ) {

                        $transport->year            = $this->to_php_null($data["release_date"]);       // год выпуска
                        $transport->mileage         = $this->to_php_null($data["mileage"]);            // пробег
                        $transport->engine_type     = $this->to_php_null($data["fuel_type"]);          // тип движка
                        $transport->customs         = $this->to_php_null($data["customs"]);            // растаможка

                        // значение записи url в sitemap.xml
                        $url_text = "Транспорт водный";
                    }

                    // велосипед
                    if ( $data["transport_type"] == 7 ) {

                        $transport->year            = $this->to_php_null($data["release_date"]);       // год выпуска
                        $transport->mileage         = $this->to_php_null($data["mileage"]);            // пробег
                        $transport->engine_type     = $this->to_php_null($data["fuel_type"]);          // тип движка
                        $transport->customs         = $this->to_php_null($data["customs"]);            // растаможка

                        // значение записи url в sitemap.xml
                        $url_text = "Транспорт велосипед";
                    }

                    // воздушный транспорт
                    if ( $data["transport_type"] == 8 ) {

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
            if (isset($data["adv_coords"])) 
            {
                $coords = explode(",", $data["adv_coords"]);
                $advert->coord_lat = $coords[0];
                $advert->coord_lon = $coords[1];
                \Debugbar::info($coords);
            }
            else {
                $advert->coord_lat = 0;
                $advert->coord_lon = 0;
            }                                    
 
            // Публикую объявление сходу, без модерации
            $advert->public = true;
	        $advert->startDate = Carbon::now()->toDateTimeString();
            $advert->finishDate = Carbon::now()->add(30, 'day')->toDateTimeString(); // добавляю 30 дней
            
            // Сохраняю объявление
            $advert->save();
            
            // Закидываю данные в таблицу urls для SEO
            $urls = new Urls();
                    
            // url sitemap
            if ( strlen($title) > 5 ) $url_text = $title;
            
            $urls->url = substr($advert->id."-".\Helper::str2url($url_text), 0, 100);            
            $urls->advert_id = $advert->id;
            $urls->save();                            
                                      
            // проверяем есть-ли входящие картинки вообще
           if ($request->file("images")) {                

                // сбрасываю статус загрузки изображений
                $this->img_loaded = false;
                
                // массив данных об изображениях
                $imagesArray = [];

                // обновляю идентификатор объявления
                Images::where("uid", $request->uid)->update(array("advert_id" => $advert->id)); 
                
                // цикл по изображениям
                foreach($request->file("images") as $img) {                                                        

                    // если такого ещё нет в базе то заливаем снова
                    $imageRequest = Images::select("name")->where("uid", $request->uid)->where("originalName", $img->getClientOriginalName())->get();
                    
                    // если нет изображений в базе
                    if ( count($imageRequest) === 0 ) {
                        
                        \Debugbar::info("Свободного места на диске: ".Common::getFreeDiskSpace(".")." гб.");

                        // узнаю реальный путь к файлу
                        $imgLib = Image::make($img->getRealPath())->orientate();
                        
                        // формирую рандомное имя
                        $newFilename = str_random(16).".".$img->getClientOriginalExtension();
                                                                        
                        // меняю размер и сохраняю изображение (800x600)
                        if ($imgLib->fit(800, 600)->save(Common::NORMAL_IMAGES_LOCAL_STORAGE_PATH.$newFilename)) {

                            // поменять путь исходя из оставшегося места на диске
                            $arrayRecord = array("path" => Common::NORMAL_IMAGES_LOCAL_STORAGE_PATH, "name" => $newFilename, "type" => "normal");
                            array_push($imagesArray, $arrayRecord);          
                            $this->img_loaded = true;                                  
                        }                                                                                                        

                        // меняю размер и сохраняю изображение (250x250)
                        if ($imgLib->fit(250, 250)->save(Common::SMALL_IMAGES_LOCAL_STORAGE_PATH.$newFilename) && $this->img_loaded === true) {

                            // поменять путь исходя из оставшегося места на диске
                            $arrayRecord = array("path" => Common::SMALL_IMAGES_LOCAL_STORAGE_PATH, "name" => $newFilename, "type" => "small");
                            array_push($imagesArray, $arrayRecord);          
                            $this->img_loaded = true;
                        } 

                        if ($this->img_loaded) {

                            // записываю в таблицу
                            $imgRecord = new Images();
                            $imgRecord->advert_id = $advert->id;
                            $imgRecord->name = $newFilename;
                            $imgRecord->originalName = $img->getClientOriginalName();
                            $imgRecord->storage_id = 0;
                            $imgRecord->uid = $request->uid;
                            $imgRecord->save();                            

                        }
                        else 
                            return response()->json([ "error" => "error", "msg" => "невозможно загрузить изображение" ]);
                    }                                           

                } // end foreach

                // Если свободного места осталось мало, то сохраняю в облако и удаляю временные изображения
                if (Common::getFreeDiskSpace(".") < Common::MIN_FREE_DISK_SPACE_IN_GB) {
                                
                    \Debugbar::info("Сохраняю изображения в облако...");                                

                    // отправляю в очередь
                    LoadImages::dispatch($imagesArray);
                    DeleteTempImages::dispatch($imagesArray);                                
                }

            }                            
            
            Sitemap::addUrl($urls->url);

            return response()->json([ "result" => "success", "url" => $urls->url ]);
        }		
        
        catch(\Exception $e) {
            return response()->json([ "result" => "error", "title" => "Ошибка", "msg" => $e->getMessage() ]);  
    	}
     	
     	return $data;
    }    
}