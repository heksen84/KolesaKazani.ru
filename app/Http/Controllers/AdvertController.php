<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Validator;
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

 	public function newAdvert() {
 		return Auth::user()? view('create')->with( "items", Categories::all() ) : view('auth\login');
 	}

    public function createAdvert(Request $request) {

        \Debugbar::info($request->all()); // отладка мать её

        // правила валидации      
        $rules = 
        [
            "data.adv_deal"      => "required",
            "data.adv_category"  => "required", 
            "data.adv_price"     => "required|numeric"
        ]; 

        // сообщения валидации
        $messages = 
        [
            "data.adv_deal.required"        =>"Укажите вид сделки", 
            "data.adv_category.required"    =>"Укажите категорию товара или услуги",
            "data.adv_price.required"       =>"Укажите цену",
            "data.adv_price.numeric"        =>"Введите числовое значение для цены",
        ]; 

        // проверяем
        $validator = Validator::make( $request->all(), $rules, $messages );

        // если ошибка, возвращаем false и текст ошибки
        if ( $validator->fails() )  
            return response()->json(["result"=>"usr.error", "msg"=>$validator->errors()->first()]);  

        $data = $request->input('data');

        $category   = $data["adv_category"];
        $text       = $data["adv_info"];
        $price      = $data["adv_price"];

     	try {
     			
            $adverts = new Adverts();
     		$adverts->user_id   		= Auth::id();
        	$adverts->text  			= $text;
        	$adverts->contacts  		= null; 
        	$adverts->price  			= $price;
        	$adverts->category_id  		= $category;
        	$adverts->adv_category_id  	= 0;

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
                    $adverts->adv_category_id = $transport->id;
                    break;
                }

                // недвижимость
                case 2: {
                    
                    $realestate= new RealEstate();
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

            $adverts->save(); // сохраняю объявление

            return $adverts->id;
		}
		
        catch(\Exception $e) {
               return response()->json(["result"=>"db.error", "msg"=>$e->getMessage()]);  
    	}
     	
     	return $data;
    }

    public function getFullInfo($id) {
    	$item = DB::table('adverts')->where('id', $id)->get();
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
