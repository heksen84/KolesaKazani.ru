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
    public function getCountrySubCategoryResults(Request $request, $category, $subcategory) {              
       
        $table = new SubCats();

        // получаю id подкатегории по названию в url
        $subcategories = $table::select("id", "title_ru", "description_ru", "keywords_ru")->where("url_ru", $subcategory)->get();                                    
                        
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
         ->with("title", $subcategories[0]->title_ru)
         ->with("description", $subcategories[0]->description_ru)
         ->with("keywords", $subcategories[0]->keywords_ru)
         ->with("items", $items)
         ->with("itemsCount", count($items));	
       	                        
    }
}
