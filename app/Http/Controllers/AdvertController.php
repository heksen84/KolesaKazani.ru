<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        // ---------------------------------
        // Обязательно:
        // Вид сделки покупка / продажа 
        // Категория товара или услуги
        // Доп. информация
        // Цена
        // ---------------------------------



        // обязательные поля
        $request->validate([ 
            "data.adv_deal"      => "required", 
            "data.adv_category"  => "required", 
            "data.adv_price"     => "required" 
        ]);


        $data = $request->input('data');

        $category   = $data["adv_category"];
        $text       = $data["adv_info"];
        $price      = $data["adv_price"];

       

     	try {
     			
            $adverts = new Adverts();
     		$adverts->user_id   		= Auth::id();
        	$adverts->text  			= $text;
        	$adverts->contacts  		= "контакты"; 
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

            return  $adverts->id;

		}
		
        catch(\Exception $e) {
       		return $e->getMessage();
    	}
     	
     	return $data;
    }

    public function getFullInfo($id) {
    	$item = DB::table('adverts')->where('id', $id)->get();
        return view('fullinfo')->with("item", $item );
    }

     public function getCarsMarks() {
	     return CarMark::all('id_car_mark','name');
    }

     public function getCarsModels(Request $request) {
     	return DB::table('car_model')->where('id_car_mark', $request->mark_id )->get();
    }
}
