<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Adverts;
use App\SubCats;
use App\CarMark;

class ResultsController extends Controller {

    // $filter = new TransportFilter($request);
    // $filter->getStartPage();
    // $filter->getStartPrice();
    // $filter->getEndPrice();        

    // -------------------------------------------------------------
    // Результаты по стране для вьюхи (results.blade.php)
    // -------------------------------------------------------------    
    public function getResultsByCountryForView(Request $request, $subcategory) {        
       
        $subcategoryId = SubCats::select("id")->where("url_ru", $subcategory)->get();                                    
        $items = Adverts::select("id", "title", "price", "text", "created_at")->where("subcategory_id", $subcategoryId[0]->id)->get();
        
        \Debugbar::info("субкатегория: ".$subcategory);       
        \Debugbar::info("id субкатегории: ".$subcategoryId);      
        \Debugbar::info($items);        
        
        // RU
       switch($subcategory) {
        
        // ЛЕГКОВОЕ АВТО
        case "legkovoy-avtomobil": {

            $title="Покупка, продажа, обмен и сдача в аренду легкового авто в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
         }

         // ГРУЗОВОЕ АВТО
         case "gruzovoy-avtomobil": {            

            $title="Покупка, продажа, обмен и сдача в аренду грузового авто в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
         }

         case "mototehnika": {

            $title="Покупка, продажа, обмен и сдача в аренду мототехники в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
         }         

         case "spectehnika": {

            $title="Покупка, продажа, обмен и сдача в аренду спецехники в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
         }         

         case "retro-avtomobil": {

            $title="Покупка, продажа, обмен и сдача в аренду ретро авто в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
         }         

         case "vodnyy-transport": {
            
            $title="Покупка, продажа, обмен и сдача в аренду водного транспорта в Казахстане";
            $description = "";
            $keywords = "";            
            
            break;
         }         

         case "velosiped": {

            $title="Покупка, продажа, обмен и сдача в аренду велосипедов в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
         }         

         case "vozdushnyy-transport": {

            $title="Покупка, продажа, обмен и сдача в аренду воздушного транспорта в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
         }         

	 case "kvartira":  {

            $title="Покупка, продажа, обмен и сдача в аренду квартир в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
	 }

       }        

       return view("results")
       ->with("title", $title)
       ->with("description", $description)
       ->with("keywords", $keywords)
       ->with("items", $items)
       ->with("itemsCount", count($items));	
       	                        
    }
}
