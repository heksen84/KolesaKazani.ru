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
    // получить данные подкатегории
    // -------------------------------------------------------------
    private function getSubCategory(Request $request, $subcategory) {  
        $table = new SubCats();         
        return $table::select("id", "title", "description", "keywords")->where("url", $subcategory)->get();
    }

    // -------------------------------------------------------------
    // получить расположение
    // -------------------------------------------------------------
    private function getLocation($lang) {  

        $inLocation="";

        switch($lang) {
            case "kz": $inLocation = "в Казахстане"; break;
            case "ru": $inLocation = "в России"; break;
        }
        return $inLocation;
    }

    // -------------------------------------------------------------
    // получить хранилище изображений
    // -------------------------------------------------------------
    private function getImagePath() {      
        return \Storage::disk('local')->url('app/images/preview/');
    }


    // -------------------------------------------------------------
    // результаты по стране
    // -------------------------------------------------------------    
    public function getCountrySubCategoryResults(Request $request, $category, $subcategory) {  
       
        \Debugbar::info("Язык: ".$request->lang);
                       
        $subcategories = $this->getSubCategory($request, $subcategory);                        

        $items = DB::select(
         "SELECT 
         adv.id, 
         adv.title,
         adv.price,
         concat('".$this->getImagePath()."', (SELECT name FROM images WHERE images.advert_id=adv.id AND images.type=0 LIMIT 1)) AS imageName
         FROM `adverts` AS adv WHERE subcategory_id = ".$subcategories[0]->id
         );            
   
         \Debugbar::info("субкатегория: ".$subcategory);       
         \Debugbar::info("id субкатегории: ".$subcategories);      
         \Debugbar::info($items);
                
         return view("results")
         ->with("title", $subcategories[0]->title." ".$this->getLocation($request->lang))
         ->with("description", $subcategories[0]->description)
         ->with("keywords", $subcategories[0]->keywords)
         ->with("items", $items)
         ->with("itemsCount", count($items));       	                        
    }

    // -------------------------------------------------------------
    // результаты по региону
    // -------------------------------------------------------------
    public function getRegionSubCategoryResults(Request $request, $region, $category, $subcategory) {        
        $subcategories = $this->getSubCategory($request, $subcategory);    
    }

    // -------------------------------------------------------------
    // результаты по городу либо селу
    // -------------------------------------------------------------
    public function getCitySubCategoryResults(Request $request, $region, $city, $category, $subcategory) {
        $subcategories = $this->getSubCategory($request, $subcategory);
    }
    
}
