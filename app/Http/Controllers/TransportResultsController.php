<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\CarMark;

class TransportResultsController extends Controller
{

    public function getTransportResultsByCountry(Request $request) {

    }

    // -------------------------------------------------------------
    // Результаты по стране для вьюхи (results.blade.php)
    // -------------------------------------------------------------    
    public function getTransportResultsByCountryForView(Request $request, $type) {

       \Debugbar::info($type);       


        // $filter = new TransportFilter($request);
        // $filter->getStartPage();
        // $filter->getStartPrice();
        // $filter->getEndPrice();


       switch($type) {

        // --- ru ---        
        case "legkovoy-avtomobil": {

            $items = DB::select("SELECT                                    
            adv.id, 
            adv.price,
            dealtype.deal_name_2, 
            car_mark.name, 
            car_model.name_rus,
            (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as imageName,
            DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at
            FROM `adverts` AS adv JOIN (dealtype, sub_transport, car_mark, car_model) 
            ON (
                adv.deal = dealtype.id AND 
                adv.sub_category_id=sub_transport.id AND 
                sub_transport.mark=car_mark.id_car_mark AND 
                sub_transport.model = car_model.id_car_model
                ) 
            WHERE adv.category_id=1 AND sub_transport.type=0"
            );
                                
            $total = count($items);

            \Debugbar::info("Число легковых тачек: ".$total);
            \Debugbar::info($items);


            $car_marks = DB::select("SELECT * FROM `car_mark` ORDER BY name");

            
            \Debugbar::info($car_marks);
            
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

        return view("results")
        ->with("title", $title)
        ->with("description", $description)
        ->with("keywords", $keywords)
        ->with("items", $items)
        ->with("itemsCount", $total)
        ->with("car_marks", $car_marks);

    }


}
