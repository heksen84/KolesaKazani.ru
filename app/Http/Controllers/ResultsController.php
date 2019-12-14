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
    public function getCountrySubCategoryResults(Request $request, $country, $language, $category, $subcategory) {  
       
         // --- коды языков ---
         // русский = 570
         // казахский = 255

         // страна/язык
         // kz/570

         $inLocation=null;

         switch($country) {
            case "kz": $inLocation = "в Казахстане"; break;
            case "ru": $inLocation = "в России"; break;
         }
       
        $table = new SubCats();

        // получаю id подкатегории по названию в url
        $subcategories = $table::select("id", "title", "description", "keywords")->where("url", $subcategory)->get();                                    
                        
	     $imagePath = \Storage::disk('local')->url('app/images/preview/');

        $items = DB::select
        (
         "SELECT 
         adv.id, 
         adv.title,
         adv.price,
         concat('".$imagePath."', (SELECT name FROM images WHERE images.advert_id=adv.id AND images.type=0 LIMIT 1)) AS imageName
         FROM `adverts` AS adv WHERE subcategory_id = ".$subcategories[0]->id
         );            
   
         \Debugbar::info("субкатегория: ".$subcategory);       
         \Debugbar::info("id субкатегории: ".$subcategories);      
         \Debugbar::info($items);
                
         return view("results")
         ->with("title", $subcategories[0]->title." ".$inLocation)
         ->with("description", $subcategories[0]->description)
         ->with("keywords", $subcategories[0]->keywords)
         ->with("items", $items)
         ->with("itemsCount", count($items));	
       	                        
    }
}
