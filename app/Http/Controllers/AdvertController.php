<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Intervention\Image\ImageManagerStatic as Image;
use Validator;
use App\Images;
use App\Adverts;
use App\CarMark;
use App\CarModel;
use App\Categories;
use App\Transport;
use App\RealEstate;
use App\Appliances;
use DB;

//use \SitemapController;

class AdvertController extends Controller {

    public function getAdverts() {
	     return Adverts::all()->toJson();
    }

    /*
    -----------------------------------
    Новое объявление
    -----------------------------------*/
 	public function newAdvert() {
 		return Auth::user()? view('create')->with( "items", Categories::all() ) : view('auth\login');
 	}

    /*
    -----------------------------------------------
    Создать объявление
    -----------------------------------------------*/
    public function createAdvert(Request $request) {                

        $data = $request->all();
    
        \Debugbar::info($data);

        // правила валидации      
        $rules = 
        [
            "adv_deal"      => "required",
            "adv_category"  => "required", 
            "adv_price"     => "required|numeric",
            "images.*"      => "image|mimes:jpeg,png,jpg",
            "region_id"     => "required|numeric",
            "city_id"       => "required|numeric"
        ]; 

        // сообщения валидации
        $messages = 
        [
            "adv_deal.required"        => "Укажите вид сделки", 
            "adv_category.required"    => "Укажите категорию товара или услуги",
            "adv_price.required"       => "Укажите цену",
            "adv_price.numeric"        => "Введите числовое значение для цены",
            "images.*.image"           => "Только изображения!",
            "region_id.required"       => "Укажите регион",
            "region_id.numeric"        => "Введите числовое значение для региона",
            "city_id.required"         => "Укажите расположение",
            "city_id.numeric"          => "Введите числовое значение для расположения"
        ]; 

        // проверяем
        $validator = Validator::make( $data, $rules, $messages );

        if ( $validator->fails() )  
            return response()->json(["result"=>"usr.error", "msg"=>$validator->errors()->first()]);                    

        $category   = $data["adv_category"];
        $text       = $data["adv_info"];
        $price      = $data["adv_price"];
        $region_id  = $data["region_id"];
        $city_id    = $data["city_id"];
        
     	try {
     			
            $advert = new Adverts();
     		$advert->user_id   		 = Auth::id();
        	$advert->text  			 = $text;
        	$advert->contacts  		 = null; 
        	$advert->price  		 = $price;
        	$advert->category_id  	 = $category;
            $advert->adv_category_id = 0;
            $advert->region_id       = $region_id;
            $advert->city_id         = $city_id;

            switch($category) {


                // FIXME: Обозвать переменные одинаковыми именами steering_position, engine_type и т.д.

                // --------------------------------
                // транспорт
                // --------------------------------
                case 1: {

                    $transport = new Transport();
                    $transport->type                = $data["transport_type"];     // тип транспорта: легковой / грузовой и т.д.
                    $transport->mark                = $data["mark_id"];            // id марки авто
                    $transport->model               = $data["model_id"];           // id марки авто
                    $transport->year                = $data["release_date"];       // год выпуска
                    $transport->steering_position   = $data["rule_position"];      // положение руля
                    $transport->mileage             = $data["mileage"];            // пробег
                    $transport->engine_type         = $data["fuel_type"];        // тип движка
                    $transport->customs             = 0;
                    $transport->save();

                    // указываем id' шник
                    $advert->adv_category_id = $transport->id;
                    break;
                }

                // --------------------------------
                // недвижимость
                // --------------------------------
                case 2: {
                    
                    $realestate = new RealEstate();
                    $realestate->property_type = 0;
                    $realestate->floor = 0;
                    $realestate->floors_house = 0;
                    $realestate->rooms = 0;
                    $realestate->area = 0;
                    $realestate->ownership = 0;
                    $realestate->kind_of_object = 0;
                    $realestate->save();
                    $realestate->adv_category_id = $realestate->id;
                    break;
                }

                // бытовая техника
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
            else 
            {
                $advert->coord_lat = 0;
                $advert->coord_lon = 0;
            }


            // FIXME: сделать проверку на сохранение и если что грохнуть сохраненную подкатегорию
            // и разобраться, что там с сохранением суммы
            
            $advert->save(); // сохраняю основную информацию 
            
    

            /*
            ------------------------------------------
            Сохраняю картинки
            ------------------------------------------*/
            
            if ($request->images)
            foreach($request->file("images") as $img) {

                $filename = str_random(32).".".$img->getClientOriginalExtension();
                $image_resize = Image::make($img->getRealPath());
                
                // изменяю размер с соотношением пропорций              
                $image_resize->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                });

                // пишу текст в картинку
                $image_resize->text(env("APP_URL"), 8,25, function($font) {
                    $font->file(public_path()."/fonts/Brushie.ttf");
                    $font->color(array(255,255,255,1));
                    $font->size(26);
                });

                // ... и сохраняю в хранилище
                $image_resize->save(storage_path().'/app/images/' .$filename);
                $image = new Images();
                $image->advert_id = $advert->id;
                $image->image = $filename;                
                $image->save();
            }

            /*SitemapController::addUrl("Моя url");
            SitemapController::removeUrl("Моя url");*/

            return $advert->id;
		}
		
        catch(\Exception $e) {
               return response()->json(["result"=>"db.error", "msg"=>$e->getMessage()]);  
    	}
     	
     	return $data;
    }

    /*
    -------------------------------------------
    Получить полную информацию об объявлении
    ПЕРЕТАЩИТЬ В РЕЗУЛЬТАТЫ
    -------------------------------------------*/
    public function getFullInfo($id) {
        
        // выбираю все поля по нужному айдишнику
        $item = DB::table("adverts")->where("id", $id)->get()->first();
        
        // подкатегория
        $subcategory = $item->adv_category_id;
        
        $string = "";
        // ----------------------------------------------------------------
        // определить категорию объявления и вернуть необходимый результат
        // ----------------------------------------------------------------
        switch($item->category_id) {
            
            // транспорт
            case 1: {

                $results = DB::select(
					"SELECT					
					car_mark.name as mark, 
					car_model.name as model,
					adv.id as advert_id, 
					adv_transport.id,
					adv.price,  
					year,  
					mileage,
					text 
					FROM `adverts` as adv
					INNER JOIN (adv_transport, car_mark, car_model) ON (
						adv_transport.mark=car_mark.id_car_mark AND 
						adv.adv_category_id=adv_transport.id AND 
						adv_transport.model = car_model.id_car_model
					) WHERE adv.id=".$id
                );

                \Debugbar::info($results);

                $string = $results[0]->mark." ".$results[0]->model." ".$results[0]->price." тенге ".$results[0]->year." год ".$results[0]->mileage;
                \Debugbar::info($string);

                break;
            }

            // недвижимость
            case 2: { 
                break;
            }

            case 3: break;
            case 4: break;
            case 5: break;
            case 6: break;
            case 7: break;
            case 8: break;
            case 9: break;
            case 10: break;
        }

        return view("fullinfo")->with("item", json_encode($results) )->with("description", "123");
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
     	return DB::table('car_model')->where('id_car_mark', $request->mark_id )->get();
    }
}