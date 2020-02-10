<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Common;
use App\Helpers\Petrovich;
use App\Adverts;
use App\Categories;
use App\SubCats;
use App\CarMark;
use App\Regions;
use App\Places;

class ResultsController extends Controller {
        
    // получить данные категории    
    private function getCategoryData(Request $request, $category) {  
        $table = new Categories();         
        return $table::select("id", "title", "description", "keywords")->where("url", $category)->get();
    }
    
    // получить данные подкатегории
    private function getSubCategoryData(Request $request, $subcategory) {  
        $table = new SubCats();         
        return $table::select("id", "title", "description", "keywords")->where("url", $subcategory)->get();
    }
    
    // получить данные региона
    private function getRegionData($region) {                
        $regionId = Regions::select("region_id", "name")->where("url", $region)->get();        
        \Debugbar::info("ID региона: ".$regionId[0]->region_id);
        return $regionId[0];
    }
    
    // получить данные города / села
    private function getCityData($city) {                
        $cityId = Places::select("city_id", "name")->where("url", $city)->get();        
        \Debugbar::info("ID города/села: ".$cityId[0]->city_id);
        return $cityId[0];
    }
    
    // получить расположение
    private function getLocationName() {                        
        return "Казахстане";
    }
    
    // результаты по стране
    public function getCountryCategoryResults(Request $request, $category) {        

        \Debugbar::info("start_price: ".$request->start_price);
        \Debugbar::info("end_price: ".$request->end_price);        
                        
        $startPrice = $request->start_price;
        $endPrice = $request->end_price;

        $priceBetweenSql="";

        if ($startPrice && $endPrice) 
            $priceBetweenSql = " AND price BETWEEN ".$startPrice." AND ".$endPrice;

        $categories = $this->getCategoryData($request, $category); 
                                                
        $items = DB::table("adverts as adv")->select(
            "adv.id", 
            "adv.title", 
            "adv.price", 
            DB::raw("concat('".\Common::getImagePath()."', (SELECT name FROM images WHERE images.advert_id=adv.id AND images.type=0 LIMIT 1)) as imageName"
        ))
        ->where("category_id", $categories[0]->id )
        ->paginate(10)
        ->onEachSide(1);

        \Debugbar::info($items);
        
        $locationName = $this->getLocationName();        
                
        return view("results")    
        ->with("title", str_replace("@place", $locationName, $categories[0]->title ))         
        ->with("description", str_replace("@place", $locationName, $categories[0]->description ))         
        ->with("keywords", str_replace("@place", $locationName, $categories[0]->keywords ))         
         ->with("items", $items)
         ->with("categoryId", $categories[0]->id)
         ->with("subcategoryId", null)         
         ->with("region", null)
         ->with("city", null)
         ->with("category", $category)
         ->with("subcategory", null)
         ->with("country", $request->country)
         ->with("lang", $request->lang)
         ->with("page", $request->page?$request->page:0)
         ->with("start_price", $request->start_price)
         ->with("end_price", $request->end_price);
    }

    // -------------------------------------------------------------
    // результаты по стране
    // -------------------------------------------------------------    
    public function getCountrySubCategoryResults(Request $request, $category, $subcategory) {        
        
        \Debugbar::info("start_price: ".$request->start_price);
        \Debugbar::info("end_price: ".$request->end_price);        
                        
        $startPrice = $request->start_price;
        $endPrice = $request->end_price;

        $priceBetweenSql="";

        if ($startPrice && $endPrice) 
            $priceBetweenSql = " AND price BETWEEN ".$startPrice." AND ".$endPrice;
                       
        $categories = $this->getCategoryData($request, $category);                         
        $subcategories = $this->getSubCategoryData($request, $subcategory);            
                 
        $items = DB::table("adverts as adv")->select(
            "adv.id", 
            "adv.title", 
            "adv.price", 
            DB::raw("concat('".\Common::getImagePath()."', (SELECT name FROM images WHERE images.advert_id=adv.id AND images.type=0 LIMIT 1)) as imageName"
        ))
        ->where("subcategory_id", $subcategories[0]->id.$priceBetweenSql)
        ->paginate(10)
        ->onEachSide(1);        

        \Debugbar::info("субкатегория: ".$subcategory);       
        \Debugbar::info("id субкатегории: ".$subcategories);      
        \Debugbar::info($items);

        $locationName = $this->getLocationName();
                
        return view("results")    
         ->with("title", str_replace("@place", $locationName, $subcategories[0]->title ))         
         ->with("description", str_replace("@place", $locationName, $subcategories[0]->description ))         
         ->with("keywords", str_replace("@place", $locationName, $subcategories[0]->keywords ))         
         ->with("items", $items)
         ->with("categoryId", $categories[0]->id)
         ->with("subcategoryId", $subcategories[0]->id)         
         ->with("region", null)
         ->with("city", null)
         ->with("category", $category)
         ->with("subcategory", $subcategory)
         ->with("country", $request->country)
         ->with("lang", $request->lang)
         ->with("page", $request->page?$request->page:0)
         ->with("start_price", $request->start_price)
         ->with("end_price", $request->end_price);
    }

    // -------------------------------------------------------------
    // результаты по области
    // -------------------------------------------------------------
    public function getRegionSubCategoryResults(Request $request, $region, $category, $subcategory) {    

         \Debugbar::info("start_price: ".$request->start_price);
         \Debugbar::info("end_price: ".$request->end_price);        
                         
         $startPrice = $request->start_price;
         $endPrice = $request->end_price;
 
         $priceBetweenSql="";
 
         if ($startPrice && $endPrice) 
             $priceBetweenSql = " AND price BETWEEN ".$startPrice." AND ".$endPrice;
                        
            $categories = $this->getCategoryData($request, $category);
            $subcategories = $this->getSubCategoryData($request, $subcategory);
            $regionData = $this->getRegionData($region);           
         
 
         $items = DB::table("adverts as adv")->select(
             "adv.id", 
             "adv.title", 
             "adv.price", 
             DB::raw("concat('".\Common::getImagePath()."', (SELECT name FROM images WHERE images.advert_id=adv.id AND images.type=0 LIMIT 1)) as imageName"
         ))
         ->where("subcategory_id", $subcategories[0]->id.$priceBetweenSql)
         ->where("region_id", $regionData->region_id)
         ->paginate(10)
         ->onEachSide(1);                 
 
         \Debugbar::info("субкатегория: ".$subcategory);       
         \Debugbar::info("id субкатегории: ".$subcategories);      
         \Debugbar::info($items);
 
         $locationName = $this->getLocationName();
                 
         return view("results")    
          ->with("title", str_replace("@place", $locationName, $subcategories[0]->title ))         
          ->with("description", str_replace("@place", $locationName, $subcategories[0]->description ))         
          ->with("keywords", str_replace("@place", $locationName, $subcategories[0]->keywords ))         
          ->with("items", $items)
          ->with("categoryId", $categories[0]->id)
          ->with("subcategoryId", $subcategories[0]->id)          
          ->with("region", $region)
          ->with("city", null)
          ->with("category", $category)
          ->with("subcategory", $subcategory)
          ->with("country", $request->country)
          ->with("lang", $request->lang)
          ->with("page", $request->page?$request->page:0)
          ->with("start_price", $request->start_price)
          ->with("end_price", $request->end_price);
    }

    // -------------------------------------------------------------
    // результаты по городу либо селу
    // -------------------------------------------------------------
    public function getCitySubCategoryResults(Request $request, $region, $city, $category, $subcategory) {       

         \Debugbar::info("start_price: ".$request->start_price);
         \Debugbar::info("end_price: ".$request->end_price);        
                         
         $startPrice = $request->start_price;
         $endPrice = $request->end_price;
 
         $priceBetweenSql="";
 
         if ($startPrice && $endPrice) 
             $priceBetweenSql = " AND price BETWEEN ".$startPrice." AND ".$endPrice;
                        
            $categories = $this->getCategoryData($request, $category);
            $subcategories = $this->getSubCategoryData($request, $subcategory);
            $regionData = $this->getRegionData($region); 
            $cityData = $this->getCityData($city);                   
 
         $items = DB::table("adverts as adv")->select(
             "adv.id", 
             "adv.title", 
             "adv.price", 
             DB::raw("concat('".\Common::getImagePath()."', (SELECT name FROM images WHERE images.advert_id=adv.id AND images.type=0 LIMIT 1)) as imageName"
         ))
         ->where("subcategory_id", $subcategories[0]->id.$priceBetweenSql)
         ->where("region_id", $regionData->region_id)
         ->where("city_id", $cityData->city_id)
         ->paginate(10)
         ->onEachSide(1);
  
         \Debugbar::info("субкатегория: ".$subcategory);       
         \Debugbar::info("id субкатегории: ".$subcategories);      
         \Debugbar::info($items);
 
         $locationName = $this->getLocationName();
                 
         return view("results")    
          ->with("title", str_replace("@place", $locationName, $subcategories[0]->title ))         
          ->with("description", str_replace("@place", $locationName, $subcategories[0]->description ))         
          ->with("keywords", str_replace("@place", $locationName, $subcategories[0]->keywords ))         
          ->with("items", $items)
          ->with("categoryId", $categories[0]->id)
          ->with("subcategoryId", $subcategories[0]->id)     
          ->with("region", $region)
          ->with("city", $city)
          ->with("category", $category)
          ->with("subcategory", $subcategory)
          ->with("country", $request->country)
          ->with("lang", $request->lang)
          ->with("page", $request->page?$request->page:0)
          ->with("start_price", $request->start_price)
          ->with("end_price", $request->end_price);
    }    
}
