<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Common;
use App\Helpers\Petrovich;
use App\Categories;
use App\SubCats;
use App\Regions;
use App\Places;

class ResultsController extends Controller {
        
    // получить данные категории    
    private function getCategoryData(Request $request, $category) {  
        
        $table = new Categories();
        $data = $table::select("id", "title", "description", "keywords", "h1")->where("url", $category)->get();

        if (!count($data)) {
            abort(404);             
        }

        return $data;
    }
    
    // получить данные подкатегории
    private function getSubCategoryData(Request $request, $subcategory) {  
        
        $table = new SubCats();
        $data = $table::select("id", "title", "description", "keywords", "h1")->where("url", $subcategory)->get();

        if (!count($data)) {
            abort(404);             
        }

        return $data;
    }
    
    // получить данные региона
    private function getRegionData($region) {                
        
        $regionId = Regions::select("region_id", "name")->where("url", $region)->get();        
        \Debugbar::info("ID региона: ".$regionId[0]->region_id);

        // FIXME: NEED?
        if (!count($regionId)) {
            abort(404);             
        }
        
        return $regionId[0];
    }
    
    // получить данные города / села
    private function getCityData($region, $city) {                
        
        $cityId = Places::select("city_id", "name")->where("region_id", $region)->where("url", $city)->get();        
        \Debugbar::info("ID города/села: ".$cityId[0]->city_id);

        // FIXME: NEED?
        if (!count($cityId)) {
            abort(404);             
        }

        return $cityId[0];
    }
    
    // получить расположение
    private function getLocationName($val, $isRegion) {                        

        if ($val===null) 
            return "Казахстане";
	    else 
            if ($isRegion) {
                $petrovich = new Petrovich(Petrovich::GENDER_FEMALE);											
                return $petrovich->firstname($val, 4). " области";
            }
            else {
                $petrovich = new Petrovich(Petrovich::GENDER_MALE);											
                return $petrovich->firstname($val, 4);
            }	    
    }    
    
    // результаты - общий запрос
    public function getCategoryResults(Request $request, $region, $city, $category) {  
        
        \Debugbar::info("getCategoryResults");        
        \Debugbar::info("start_price: ".$request->start_price);
        \Debugbar::info("end_price: ".$request->end_price);        
                        
        $startPrice = $request->start_price;
        $endPrice = $request->end_price;        
        $priceBetweenSql = "";        
        $regionData = null;
        $cityData = null;

        if ($startPrice && $endPrice) 
            $priceBetweenSql = " AND price BETWEEN ".$startPrice." AND ".$endPrice;

        $categories = $this->getCategoryData($request, $category); 
        
        if (!$region && !$city)
            $whereRaw = "category_id = ".$categories[0]->id." AND NOW() BETWEEN adv.startDate AND adv.finishDate AND adv.public = true";

        if ($region && !$city) {
            $regionData = $this->getRegionData($region);             
           \Debugbar::info($regionData->region_id);
            $whereRaw = "adv.region_id = ".$regionData->region_id." AND adv.category_id = ".$categories[0]->id." AND NOW() BETWEEN adv.startDate AND adv.finishDate AND adv.public = true";            
        }

        if ($region && $city) {            
            $regionData = $this->getRegionData($region); 
            $cityData = $this->getCityData($regionData->region_id, $city);
            $whereRaw = "adv.region_id = ".$regionData->region_id." AND adv.city_id = ".$cityData->city_id." AND adv.category_id = ".$categories[0]->id." AND NOW() BETWEEN adv.startDate AND adv.finishDate AND adv.public = true";
        }
                                                
        $items = DB::table("adverts as adv")->select(
            "urls.url",
            "adv.id", 
            "adv.title", 
            "adv.price",
            "adv.startDate",            
            "kz_region.name as region_name",
            "kz_city.name as city_name",
            DB::raw("(SELECT COUNT(*) FROM adex_color WHERE NOW() BETWEEN adex_color.startDate AND adex_color.finishDate AND adex_color.advert_id=adv.id) as color"),                        
            DB::raw("(SELECT COUNT(*) FROM adex_srochno WHERE NOW() BETWEEN adex_srochno.startDate AND adex_srochno.finishDate AND adex_srochno.advert_id=adv.id) as srochno"),
            DB::raw(Common::getImage("small", "adv.id")))
            ->leftJoin("adex_color", "adv.id", "=", "adex_color.advert_id" )
            ->leftJoin("adex_srochno", "adv.id", "=", "adex_srochno.advert_id" )			                    
            ->join("urls", "adv.id", "=", "urls.advert_id" )
            ->join("kz_region", "adv.region_id", "=", "kz_region.region_id" )
            ->join("kz_city", "adv.city_id", "=", "kz_city.city_id" )                
            ->whereRaw($whereRaw)            
            ->paginate(10)
            ->onEachSide(1);

        \Debugbar::info($items);

        if ($regionData) {                        
            $locationName = $this->getLocationName($regionData->name, true);
        }        
        if ($cityData) {
            $locationName = $this->getLocationName($cityData->name, false);
        }
        if (!$regionData && !$cityData) {
            $locationName = $this->getLocationName(null, null);
        }
                                        
        return view("results")    
        ->with("title", str_replace("@place", $locationName, $categories[0]->title ))         
        ->with("description", str_replace("@place", $locationName, $categories[0]->description ))         
        ->with("keywords", str_replace("@place", $locationName, $categories[0]->keywords ))         
        ->with("h1", str_replace("@place", $locationName, $categories[0]->h1 ))
        ->with("items", $items)
        ->with("categoryId", $categories[0]->id)
        ->with("subcategoryId", null)         
        ->with("region", null)
        ->with("city", null)
        ->with("category", $category)
        ->with("subcategory", null)         
        ->with("page", $request->page?$request->page:0)
        ->with("start_price", $request->start_price)
        ->with("end_price", $request->end_price)
        ->with("filters", null)
        ->with("moderation", Cache::get("moderation"));
    }

    public function getCountryCategoryResults(Request $request, $category) {
        return $this->getCategoryResults($request, null, null, $category);
    }

    public function getRegionCategoryResults(Request $request, $region, $category) {
        return $this->getCategoryResults($request, $region, null, $category);
    }

    public function getCityCategoryResults(Request $request, $region, $city, $category) {
        return $this->getCategoryResults($request, $region, $city, $category);
    }

    // -------------------------------------------------------------
    // результаты по стране
    // -------------------------------------------------------------    
    public function getCountrySubCategoryResults(Request $request, $category, $subcategory) {

        $categories = $this->getCategoryData($request, $category);                         
        $subcategories = $this->getSubCategoryData($request, $subcategory);

        $priceBetweenSql = "";

        if ($request->price_ot && $request->price_do) 
            $priceBetweenSql = " AND price BETWEEN ".$request->price_ot." AND ".$request->price_do;
                               

        // ------------------------------------------------------------------
        // легковой автомобиль
        // ------------------------------------------------------------------
        if ($category === "transport" && $subcategory === "legkovoy-avtomobil") {

            \Debugbar::info("Легковой автомобиль");

	        // если у нас авто, то мы должны применить фильры от авто и вернуть входящие параметры во вьюху            
            $filters = array (
		    "price_ot" => $request->price_ot,
		    "price_do" => $request->price_do,
		    "mark" => $request->mark, 
		    "model" => $request->model,
            "year_ot" => $request->year_ot,
            "year_do" => $request->year_do,
            "mileage_ot" => $request->mileage_ot,
            "mileage_do" => $request->mileage_do
            );
            
        }
        else
        // ------------------------------------------------------------------
        // легковой автомобиль
        // ------------------------------------------------------------------
        if ($category === "transport" && $subcategory === "gruzovoy-avtomobil") {

            \Debugbar::info("Грузовой автомобиль");

	        // если у нас авто, то мы должны применить фильры от авто и вернуть входящие параметры во вьюху            
            $filters = array (
                "price_ot" => $request->price_ot,
                "price_do" => $request->price_do,		    
            );            
        }
	    else
		    $filters = array ("price_ot" => $request->price_ot, "price_do" => $request->price_do);                 
            $items = DB::table("adverts as adv")->select(
            "urls.url",
            "adv.id", 
            "adv.title", 
            "adv.price", 
            "adv.startDate",            
            "kz_region.name as region_name",
            "kz_city.name as city_name",
            DB::raw("(SELECT COUNT(*) FROM adex_color WHERE NOW() BETWEEN adex_color.startDate AND adex_color.finishDate AND adex_color.advert_id=adv.id) as color"),                        
            DB::raw("(SELECT COUNT(*) FROM adex_srochno WHERE NOW() BETWEEN adex_srochno.startDate AND adex_srochno.finishDate AND adex_srochno.advert_id=adv.id) as srochno"),
            DB::raw(Common::getImage("small", "adv.id")))
            ->leftJoin("adex_color", "adv.id", "=", "adex_color.advert_id" )
            ->leftJoin("adex_srochno", "adv.id", "=", "adex_srochno.advert_id" )			                    
            ->join("urls", "adv.id", "=", "urls.advert_id" )
            ->join("kz_region", "adv.region_id", "=", "kz_region.region_id" )
            ->join("kz_city", "adv.city_id", "=", "kz_city.city_id" )                
            ->where("subcategory_id", $subcategories[0]->id.$priceBetweenSql)
            ->whereRaw("NOW() BETWEEN adv.startDate AND adv.finishDate AND adv.public = true")
            ->paginate(10)
            ->onEachSide(1);        

            \Debugbar::info("субкатегория: ".$subcategory);       
            \Debugbar::info("id субкатегории: ".$subcategories);      
            \Debugbar::info($items);

            $locationName = $this->getLocationName(null, null);                              
                
            return view("results")    
            ->with("title", str_replace("@place", $locationName, $subcategories[0]->title ))         
            ->with("description", str_replace("@place", $locationName, $subcategories[0]->description ))         
            ->with("keywords", str_replace("@place", $locationName, $subcategories[0]->keywords ))
            ->with("h1", str_replace("@place", $locationName, $subcategories[0]->h1 ))         
            ->with("items", $items)
            ->with("categoryId", $categories[0]->id)
            ->with("subcategoryId", $subcategories[0]->id)         
            ->with("region", null)
            ->with("city", null)
            ->with("category", $category)
            ->with("subcategory", $subcategory)         
            ->with("page", $request->page?$request->page:0)
            ->with("filters", $filters)
            ->with("moderation", Cache::get("moderation"));
    }

    // -------------------------------------------------------------
    // результаты по области
    // -------------------------------------------------------------
    public function getRegionSubCategoryResults(Request $request, $region, $category, $subcategory) {
        
        // если у нас авто, то мы должны применить фильры от авто и вернуть входящие параметры во вьюху            
        $filters = array (
		    "price_ot" => $request->price_ot,
		    "price_do" => $request->price_do,		    
        );

         \Debugbar::info("start_price: ".$request->start_price);
         \Debugbar::info("end_price: ".$request->end_price);        
                         
         $startPrice = $request->start_price;
         $endPrice = $request->end_price;
 
         $priceBetweenSql = "";
 
         if ($startPrice && $endPrice) 
             $priceBetweenSql = " AND price BETWEEN ".$startPrice." AND ".$endPrice;
                        
            $categories = $this->getCategoryData($request, $category);
            $subcategories = $this->getSubCategoryData($request, $subcategory);
            $regionData = $this->getRegionData($region);           
         
         $items = DB::table("adverts as adv")->select(
            "urls.url",
            "adv.id", 
            "adv.title", 
            "adv.price", 
            "adv.startDate",            
            "kz_region.name as region_name",
            "kz_city.name as city_name",
            DB::raw("(SELECT COUNT(*) FROM adex_color WHERE NOW() BETWEEN adex_color.startDate AND adex_color.finishDate AND adex_color.advert_id=adv.id) as color"),                        
            DB::raw("(SELECT COUNT(*) FROM adex_srochno WHERE NOW() BETWEEN adex_srochno.startDate AND adex_srochno.finishDate AND adex_srochno.advert_id=adv.id) as srochno"),
            DB::raw(Common::getImage("small", "adv.id")))
            ->leftJoin("adex_color", "adv.id", "=", "adex_color.advert_id" )
            ->leftJoin("adex_srochno", "adv.id", "=", "adex_srochno.advert_id" )			                    
            ->join("urls", "adv.id", "=", "urls.advert_id" )
            ->join("kz_region", "adv.region_id", "=", "kz_region.region_id" )
            ->join("kz_city", "adv.city_id", "=", "kz_city.city_id" )                
            ->where("subcategory_id", $subcategories[0]->id.$priceBetweenSql)
            ->where("adv.region_id", $regionData->region_id)
            ->whereRaw("NOW() BETWEEN adv.startDate AND adv.finishDate AND adv.public = true")
            ->paginate(10)
            ->onEachSide(1);                 
 
         \Debugbar::info("субкатегория: ".$subcategory);       
         \Debugbar::info("id субкатегории: ".$subcategories);      
         \Debugbar::info($items);
 
         $locationName = $this->getLocationName($regionData->name, true);
                 
         return view("results")    
         ->with("title", str_replace("@place", $locationName, $subcategories[0]->title))         
         ->with("description", str_replace("@place", $locationName, $subcategories[0]->description))         
         ->with("keywords", str_replace("@place", $locationName, $subcategories[0]->keywords))
         ->with("h1", str_replace("@place", $locationName, $subcategories[0]->h1 ))         
         ->with("items", $items)
         ->with("categoryId", $categories[0]->id)
         ->with("subcategoryId", $subcategories[0]->id)          
         ->with("region", $region)
         ->with("city", null)
         ->with("category", $category)
         ->with("subcategory", $subcategory)          
         ->with("page", $request->page?$request->page:0)
         ->with("start_price", $request->start_price)
         ->with("end_price", $request->end_price)
         ->with("filters", $filters)
         ->with("moderation", Cache::get("moderation"));
    }

    // -------------------------------------------------------------
    // результаты по городу либо селу
    // -------------------------------------------------------------
    public function getCitySubCategoryResults(Request $request, $region, $city, $category, $subcategory) {   
        
        // если у нас авто, то мы должны применить фильры от авто и вернуть входящие параметры во вьюху            
        $filters = array (
		    "price_ot" => $request->price_ot,
		    "price_do" => $request->price_do,		    
        );

        \Debugbar::info("--- getCitySubCategoryResults ---"); 
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
            $cityData = $this->getCityData($regionData->region_id, $city);

            \Debugbar::info("------------------");
            \Debugbar::info($cityData);
            \Debugbar::info("------------------");
 
         $items = DB::table("adverts as adv")->select(
            "urls.url",
            "adv.id", 
            "adv.title", 
            "adv.price",
            "adv.startDate",            
            "kz_region.name as region_name",
            "kz_city.name as city_name",
            DB::raw("(SELECT COUNT(*) FROM adex_color WHERE NOW() BETWEEN adex_color.startDate AND adex_color.finishDate AND adex_color.advert_id=adv.id) as color"),                        
            DB::raw("(SELECT COUNT(*) FROM adex_srochno WHERE NOW() BETWEEN adex_srochno.startDate AND adex_srochno.finishDate AND adex_srochno.advert_id=adv.id) as srochno"),
            DB::raw(Common::getImage("small", "adv.id")))
            ->leftJoin("adex_color", "adv.id", "=", "adex_color.advert_id" )
            ->leftJoin("adex_srochno", "adv.id", "=", "adex_srochno.advert_id" )			                    
            ->join("urls", "adv.id", "=", "urls.advert_id" )
            ->join("kz_region", "adv.region_id", "=", "kz_region.region_id" )
            ->join("kz_city", "adv.city_id", "=", "kz_city.city_id" )                
            ->where("subcategory_id", $subcategories[0]->id.$priceBetweenSql)
            ->where("adv.region_id", $regionData->region_id)
            ->where("adv.city_id", $cityData->city_id)
            ->whereRaw("NOW() BETWEEN adv.startDate AND adv.finishDate AND adv.public = true")
            ->paginate(10)
            ->onEachSide(1);
  
         \Debugbar::info("субкатегория: ".$subcategory);       
         \Debugbar::info("id субкатегории: ".$subcategories);      
         \Debugbar::info($items);

         \DebugBar::info("tuta");
 
         $locationName = $this->getLocationName($cityData->name, false);         
                 
         return view("results")    
         ->with("title", str_replace("@place", $locationName, $subcategories[0]->title ))         
         ->with("description", str_replace("@place", $locationName, $subcategories[0]->description ))         
         ->with("keywords", str_replace("@place", $locationName, $subcategories[0]->keywords ))
         ->with("h1", str_replace("@place", $locationName, $subcategories[0]->h1 ))         
         ->with("items", $items)
         ->with("categoryId", $categories[0]->id)
         ->with("subcategoryId", $subcategories[0]->id)     
         ->with("region", $region)
         ->with("city", $city)
         ->with("category", $category)
         ->with("subcategory", $subcategory)          
         ->with("page", $request->page?$request->page:0)
         ->with("start_price", $request->start_price)
         ->with("end_price", $request->end_price)
         ->with("filters", $filters)
         ->with("moderation", Cache::get("moderation"));
    }    
}
