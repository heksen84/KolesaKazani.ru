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

            /*$subcats = DB::table("subcats")
			->join("categories", "categories.id", "=", "subcats.category_id")
			->select("subcats.*", "categories.url as category_url")
            ->get();*/

            $items = DB::table("adverts")->select("adverts.id", "dealtype.deal_name_2", "adverts.category_id", "adverts.price")->join("dealtype", "adverts.deal", "=", "dealtype.id")->get();

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
