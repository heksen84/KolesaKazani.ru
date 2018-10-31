<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Filesystem;
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

class AdvertController extends Controller 
{

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
    
       // \Debugbar::info($data);

        // правила валидации      
        $rules = [
            "adv_deal"      => "required",
            "adv_category"  => "required", 
            "adv_price"     => "required|numeric",
            "images.*"      => "image|mimes:jpeg,png,jpg|max:2048",
        ]; 

        // сообщения валидации
        $messages = [
            "adv_deal.required"        => "Укажите вид сделки", 
            "adv_category.required"    => "Укажите категорию товара или услуги",
            "adv_price.required"       => "Укажите цену",
            "adv_price.numeric"        => "Введите числовое значение для цены",
            "images.*.image"           => "Только изображения!"
        ]; 

        // проверяем
        $validator = Validator::make( $data, $rules, $messages );

        if ( $validator->fails() )  
            return response()->json(["result"=>"usr.error", "msg"=>$validator->errors()->first()]);                    

        $category   = $data["adv_category"];
        $text       = $data["adv_info"];
        $price      = $data["adv_price"];
        
     	try {
     			
            $advert = new Adverts();
     		$advert->user_id   		 = Auth::id();
        	$advert->text  			 = $text;
        	$advert->contacts  		 = null; 
        	$advert->price  		 = $price;
        	$advert->category_id  	 = $category;
        	$advert->adv_category_id = 0;

            switch($category) {

                // транспорт
                case 1: {

                    $transport = new Transport();
                    $transport->type = 0;
                    $transport->mark = 0;
                    $transport->year = 1999;
                    $transport->steering_position = 0;
                    $transport->mileage = 0;
                    $transport->engine_type = 0;
                    $transport->customs = 0;
                    $transport->save();
                    $advert->adv_category_id = $transport->id;
                    break;
                }

                // недвижимость
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
            
            // координаты
            if (isset($data["adv_coords"])) {
                $coords = explode(",", $data["adv_coords"]);
                \Debugbar::info($coords);
                $advert->coord_lat = $coords[0];
                $advert->coord_lon = $coords[1];
            }
            else 
            {
                $advert->coord_lat = 0;
                $advert->coord_lon = 0;
            }

            $advert->save(); // сохраняю основную информацию           

            /*
            ------------------------------------------
            Сохраняю картинки
            ------------------------------------------*/
            //
            if ($request->images)
            foreach($request->file("images") as $img) {
                $filename = str_random(32).".".$img->getClientOriginalExtension();
                $image_resize = Image::make($img->getRealPath());              
                $image_resize->resize(640, 480)->text("FlyMarket24.kz", 10,10, function($font) {
                    //$font->file("file.ttf");
                    $font->color(array(255,255,255,1));
                    $font->size(32);
                });
                $image_resize->save('storage/app/images/' .$filename);
                $image = new Images();
                $image->advert_id = $advert->id;
                $image->image = $filename;                
                $image->save();
            }            

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
    -------------------------------------------*/
    public function getFullInfo($id) {
    	$item = DB::table('adverts')->where("id", $id)->get();
        return view('fullinfo')->with("item", $item );
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