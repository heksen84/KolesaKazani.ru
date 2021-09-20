<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Common;
use App\CarMark;
use App\Categories;
use DB;

class IndexController extends Controller {
	
		    	
	// ------------------------------------------
	// Базовая функция для главной страницы		
	// ------------------------------------------
    public function ShowIndexPage(Request $request) {												
		return view("index")
		->with("title", "КолёсаКазани - продажа авто в Казани")
		->with("description", "123")
		->with("keywords", "123")
		->with("auth", Auth::user()?1:0)
		->with("car_mark", CarMark::All())
		;
    }
	
	// --------------------------------------------------------------
	// найти по строке
	// --------------------------------------------------------------
	public function getResultsBySearchString(Request $request) {
				
		\Debugbar::info("-----------------------------");
		\Debugbar::info($request->getRequestUri());		
		\Debugbar::info("-----------------------------");
				
		$regionData = $this->getRegionData($request->region);
				
		if ($regionData) 
			$placeData = $this->getPlaceData($regionData->region_id, $request->place);
		else 
			$placeData=false;

		$request->except('page');

		if (!$regionData && !$placeData)
			$whereStr = "MATCH (title) AGAINST('".$request->searchString."' IN BOOLEAN MODE)";

		if ($regionData && !$placeData)
			$whereStr = "MATCH (title) AGAINST('".$request->searchString."' IN BOOLEAN MODE) AND adv.region_id=".$regionData->region_id;		

		if ($regionData && $placeData)
			$whereStr = "MATCH (title) AGAINST('".$request->searchString."' IN BOOLEAN MODE) AND adv.region_id=".$regionData->region_id." AND adv.city_id=".$placeData->city_id;
						        		
			// удаляю &page= из url			
			$path=$request->getRequestUri();
			$pos=strpos($request->getRequestUri(), "&page=");
			
			if ($pos > 0)
				$path = substr($request->getRequestUri(), 0, $pos);

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
			DB::raw(Common::getPreviewImage("adv.id")))
			->leftJoin("adex_color", "adv.id", "=", "adex_color.advert_id" )
			->leftJoin("adex_srochno", "adv.id", "=", "adex_srochno.advert_id" )
			->join("urls", "adv.id", "=", "urls.advert_id" )
			->join("kz_region", "adv.region_id", "=", "kz_region.region_id" )
        	->join("kz_city", "adv.city_id", "=", "kz_city.city_id" )
			->whereRaw($whereStr)
			->whereRaw("NOW() BETWEEN adv.startDate AND adv.finishDate AND adv.public = true")
			->orderBy("adv.startDate", "DESC")
			->paginate(10)
			->onEachSide(1)			
			->withPath($path);						
        
		\Debugbar::info($items);		    
				
		$str = "Результаты по запросу '".$request->searchString;
		
		$filters = array (
		    "price_ot" => $request->price_ot,
		    "price_do" => $request->price_do,		
        );

        return view("results")         
			->with("title", $str)         			
            ->with("description", $str)         
			->with("keywords", "поиск, результат, запрос")
			->with("h1", $str)
            ->with("items", $items)             
            ->with("categoryId", null)
            ->with("subcategoryId", null)
            ->with("region", $request->region)
         	->with("city", $request->place)
            ->with("category", null)
            ->with("subcategory", null)            
            ->with("page", $request->page?$request->page:0)           
            ->with("start_price", 0)
			->with("end_price", 0)
			->with("filters", $filters)
			->with("moderation", Cache::get("moderation"));
    }
}