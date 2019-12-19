<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Adverts;
use App\SubCats;
use App\CarMark;
use App\Regions;
use App\Places;

class ResultsController extends Controller {

    // $filter = new TransportFilter($request);
    // $filter->getStartPage();
    // $filter->getStartPrice();
    // $filter->getEndPrice();        

    // -------------------------------------------------------------
    // получить данные подкатегории
    // -------------------------------------------------------------
    private function getSubCategoryData(Request $request, $subcategory) {  
        $table = new SubCats();         
        return $table::select("id", "title", "description", "keywords")->where("url", $subcategory)->get();
    }

    // -------------------------------------------------------------
    // получить данные региона
    // -------------------------------------------------------------
    private function getRegionData($region) {                
        $regionId = Regions::select("region_id", "name")->where("url", $region)->get();        
        \Debugbar::info("ID региона: ".$regionId[0]->region_id);
        return $regionId[0];
    }

    // -------------------------------------------------------------
    // получить данные города / села
    // -------------------------------------------------------------
    private function getCityData($city) {                
        $cityId = Places::select("city_id", "name")->where("url", $city)->get();        
        \Debugbar::info("ID города/села: ".$cityId[0]->city_id);
        return $cityId[0];
    }

    // -------------------------------------------------------------
    // получить расположение
    // -------------------------------------------------------------
    private function getLocationName($country) {        
        
        \Debugbar::info("Язык: ".$country);        
        
        switch($country) {
            case "kz": $str = "в Казахстане"; break;
            case "ru": $str = "в России"; break;
        }
        return $str;
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
                       
        $subcategories = $this->getSubCategoryData($request, $subcategory);                        

        $items = DB::select(
         "SELECT 
         adv.id, 
         adv.title,
         adv.price,         
         concat('".$this->getImagePath()."', (SELECT name FROM images WHERE images.advert_id=adv.id AND images.type=0 LIMIT 1)) AS imageName
         FROM `adverts` AS adv WHERE subcategory_id = ".$subcategories[0]->id);            
   
         \Debugbar::info("субкатегория: ".$subcategory);       
         \Debugbar::info("id субкатегории: ".$subcategories);      
         \Debugbar::info($items);
                
         return view("results")
         ->with("title", $subcategories[0]->title." ".$this->getLocationName($request->country))
         ->with("description", $subcategories[0]->description)
         ->with("keywords", $subcategories[0]->keywords)
         ->with("items", $items)
         ->with("itemsCount", count($items));
    }

    // -------------------------------------------------------------
    // результаты по региону
    // -------------------------------------------------------------
    public function getRegionSubCategoryResults(Request $request, $region, $category, $subcategory) {        
        
        $subcategories = $this->getSubCategoryData($request, $subcategory);
        $regionData = $this->getRegionData($region);

        $items = DB::select(
         "SELECT 
         adv.id, 
         adv.title,
         adv.price,
         concat('".$this->getImagePath()."', (SELECT name FROM images WHERE images.advert_id=adv.id AND images.type=0 LIMIT 1)) AS imageName
         FROM `adverts` AS adv WHERE subcategory_id = ".$subcategories[0]->id." AND region_id = ".$regionData->region_id);            
   
         \Debugbar::info("субкатегория: ".$subcategory);       
         \Debugbar::info("id субкатегории: ".$subcategories);      
         \Debugbar::info($items);

         $locationName = " в ".$regionData->name;
                
         return view("results")
         ->with("title", $subcategories[0]->title." ".$locationName)
         ->with("description", $subcategories[0]->description)
         ->with("keywords", $subcategories[0]->keywords)
         ->with("items", $items)
         ->with("itemsCount", count($items));
    }

    // -------------------------------------------------------------
    // результаты по городу либо селу
    // -------------------------------------------------------------
    public function getCitySubCategoryResults(Request $request, $region, $city, $category, $subcategory) {

        $subcategories = $this->getSubCategoryData($request, $subcategory);
        $regionData = $this->getRegionData($region);        
        $cityData = $this->getCityData($city);                        

        $items = DB::select(
         "SELECT 
         adv.id, 
         adv.title,
         adv.price,
         concat('".$this->getImagePath()."', (SELECT name FROM images WHERE images.advert_id=adv.id AND images.type=0 LIMIT 1)) AS imageName
         FROM `adverts` AS adv WHERE subcategory_id = ".$subcategories[0]->id.
         " AND city_id = ".$cityData->city_id." AND region_id = ".$regionData->region_id);
   
         \Debugbar::info("субкатегория: ".$subcategory);       
         \Debugbar::info("id субкатегории: ".$subcategories);      
         \Debugbar::info($items);

         $locationName = " в ".$cityData->name;
                
         return view("results")
         ->with("title", $subcategories[0]->title." ".$locationName)
         ->with("description", $subcategories[0]->description)
         ->with("keywords", $subcategories[0]->keywords)
         ->with("items", $items)
         ->with("itemsCount", count($items));        
    }
    
}
