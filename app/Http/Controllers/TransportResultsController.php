<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransportResultsController extends Controller
{

    public function getTransportResultsByCountry(Request $request) {

    }

    // -------------------------------------------------------------
    // Результаты по стране для вьюхи (results.blade.php)
    // -------------------------------------------------------------
    public function getTransportResultsByCountryForView(Request $request, $type) {

       \Debugbar::info($type);       

       switch($type) {

        // --- ru ---        
        case "legkovoy-avtomobil": {

/*
                    $this->total = DB::select(
                    "SELECT COUNT(*) as count FROM `adverts` as adv INNER JOIN (adv_transport, car_mark, car_model) ON (
                    adv_transport.mark=car_mark.id_car_mark AND 
                    adv.adv_category_id=adv_transport.id AND 
                    adv_transport.model = car_model.id_car_model
                    ) WHERE adv_transport.type=0 AND adv.category_id=1".$region_string.$place_string.$this->filter_string); 

                    $results = DB::select(
                        "SELECT
			            adv.region_id,
			            adv.city_id,
                        concat($this->dealRuString, car_mark.name, ' ', car_model.name, ' ', year, ' г.') AS title,
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
                        ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit);                    */


//            $count = DB::table("adverts")->join("dealtype", "adverts.deal", "=", "dealtype.id")->count();

            $ormRequest = DB::table("adverts")
			->select
			 (
			   "adverts.id", 
			   "dealtype.deal_name_2", 
			   "car_mark.name", 
			   "car_model.name_rus", 
			   "adverts.price", 
			   DB::raw("DATE_FORMAT(adverts.created_at, '%d/%m/%Y в %H:%m') AS created_at"),
			   "images.image"
                         )
			->join("sub_transport", "adverts.sub_category_id", "=", "sub_transport.id")
		        ->join("dealtype", "adverts.deal", "=", "dealtype.id")
		        ->join("car_mark", "car_mark.id_car_mark", "=", "sub_transport.mark")
		        ->join("car_model", "car_model.id_car_model", "=", "sub_transport.model")
		        ->join("images", "images.advert_id", "=", "adverts.id")
			->where("adverts.category_id", "=", 1) // 1 = транспорт
			->where("sub_transport.type", "=", 0); // 0 = легковой
//			->where("images.advert_id", "=", "adverts.id");


            $count = $ormRequest->count(); // кол-во записей
	    $items = $ormRequest->get();   // json массив записей

//	    $images = DB::table("images")->select("image")
	    

            \Debugbar::info("Число легковых тачек: ".$count);
            \Debugbar::info($items);
            
	    break;
         }

         case "gruzovoy-avtomobil": {
	        break;
         }

         case "mototehnika": {
	        break;
         }         

         case "spectehnika": {
	        break;
         }         

         case "retro-avtomobil": {
	        break;
         }         

         case "vodnyy-transport": {
	        break;
         }         

         case "velosiped": {
	        break;
         }         

         case "vozdushnyy-transport": {
	        break;
         }         

	    // --- kz ---

       }
		
/*	$category = request()->segment(1); // вырезаю категорию из url
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
        ->with("searchString", "null");*/

        $title="Покупка, продажа, обмен, сдача в аренду легковых автомобилей в Казахстане";
        $description = "";
        $keywords = "";

        return view("results")->with("title", $title)->with("description", $description)->with("keywords", $keywords)->with("items", $items);


    }


}
