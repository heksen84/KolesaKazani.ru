<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Petrovich;
use App\Helpers\Common;
use App\Categories;
use App\Regions;
use App\Places;
use DB;

class IndexController extends Controller {

	// ------------------------------------------
	// получить данные региона
	// ------------------------------------------
    private function getRegionData($regionUrl) {                
		
		if (!$regionUrl)
			return false;

        $regionId = Regions::select("region_id")->where("url", $regionUrl)->get();        
		\Debugbar::info("ID региона: ".$regionId[0]->region_id);
		
        return $regionId[0];
    }
    
	// ------------------------------------------
	// получить данные города / села
	// ------------------------------------------
    private function getPlaceData($regionId, $placeUrl) {                		
		
		if (!$regionId && !$placeUrl)		
			return false;		

        $placeId = Places::select("city_id")->where("region_id", $regionId)->where("url", $placeUrl)->get();        
		\Debugbar::info("ID города/села: ".$placeId[0]->city_id);
		
        return $placeId[0];
    }	
		    	
	// ------------------------------------------
	// Базовая функция для главной страницы		
	// ------------------------------------------
    private function ShowIndexPage(Request $request, $usertitle, $region, $place) {

		\Debugbar::info("v=".$request->v);
		\Debugbar::info("SESSION ID: ".\Session::getId());
		
		$cm_title = '"'.config('app.name').'" - Покупка и продажа Авто ';
		$cm_description = "Объявления о покупке, продаже, обмене и сдаче в аренду в ";
		$cm_keywords = "объявления, частные объявления, доска объявлений, дать объявление, объявления продажа, объявления продаю, сайт объявлений, ilbo, ТатарДоска, страна, ";
		
		if ($request->search != "")
			return $this->search($request->search, $region, $place);		
		
			$sklonResult = "Татарстана";
						
		// Страна
		if ($region === null && $place === null) {			
			$location = "/";				
			$title =  $cm_title.$sklonResult;
			$description = $cm_description."Татарстане";
			$keywords = $cm_keywords."Татарстан";
			$locationName = "Татарстан";
			$sklonPlace = "Татарстана";
		}		

		// Регион
		if ($region != null && $place === null) {

			\Debugbar::info("Я здесь!!!");

			$location = $region;
			$locationName = Regions::select("name")->where("url", $region)->get();

			if (count($locationName) === 0)
				abort(404);             			

			$regionArr = $locationName;
			$locationName = $locationName[0]->name." обл.";						

			if ($regionArr->count() > 0) {
				
				$petrovich = new Petrovich(Petrovich::GENDER_FEMALE);
									
				$regionName = $regionArr[0]->name;
				$regionName = trim(str_replace("обл.", "", $regionName));				
				$sklonResult = $petrovich->firstname($regionName, 0)." области";			
				$sklonPlace = $sklonResult;	
				$title = $cm_title.$sklonResult;
				$description = $cm_description.$sklonResult;
				$keywords = $cm_keywords.$regionName." область";
			}
			else abort(404);
		}

		// Город, село
		if ($region != null && $place != null) {				
				
			$location = $region."/".$place;
			$locationName = Places::select("name")->where("url", $place)->get();

			if (count($locationName) === 0)
				abort(404);			

			$placeArr = $locationName;
			$locationName = $locationName[0]->name;
				
			if ($placeArr->count() > 0) {
			
				$petrovich = new Petrovich(Petrovich::GENDER_MALE);
				$sklonPlace = $petrovich->firstname($placeArr[0]->name, 0);
				$sklonResult = $placeArr[0]->name;
				$sklonResultForDesc = $petrovich->firstname($placeArr[0]->name, 4);								
				$title = '"'.config('app.name').'" - бесплатные объявления '.$sklonResult;
				$description = $cm_description.$sklonResultForDesc;
				$keywords = $cm_keywords.$locationName;
			
			}
			else 
				abort(404);
		}
				
		$subcats = DB::table("subcats")->join("categories", "categories.id", "=", "subcats.category_id")->select("subcats.*", "categories.url as category_url")->get();

		\Debugbar::info("location: ".$locationName);
		\Debugbar::info("REGION: ".$region);
		\Debugbar::info("PLACE: ".$place);

		$petrovich = new Petrovich(Petrovich::GENDER_FEMALE);	
							
		// список регионов
		$regions = Regions::all();

		$topAdverts=[];

		// Новые объявления
		/*$topAdverts = DB::table("adverts as adv")->select(			
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
			->join("adex_top", "adex_top.advert_id", "=", "adv.id" ) // связь для топа
			->join("urls", "adv.id", "=", "urls.advert_id" )			
			->join("kz_region", "adv.region_id", "=", "kz_region.region_id" )
			->join("kz_city", "adv.city_id", "=", "kz_city.city_id" )			
			->whereRaw("NOW() BETWEEN adv.startDate AND adv.finishDate AND adv.public = true")			
			->orderBy("startDate", "desc")
			->orderBy("adv.id", "desc")
			->take(10)
			->get();*/
			
			$whereLocationRawStr = "";

			if ($region) {

				$regionData = $this->getRegionData($region);				
				
				if ($regionData)
					$whereLocationRawStr=" AND adv.region_id=".$regionData->region_id;
			}
			
			if ($region && $place) {
				
				$regionData = $this->getRegionData($region);
								
				if ($regionData) {
					$placeData = $this->getPlaceData($regionData->region_id, $place);
					$whereLocationRawStr=" AND adv.region_id=".$regionData->region_id." AND adv.city_id=".$placeData->city_id;					
				}
			}
		
		// --------------------------------------------------
		// Новые объявления
		// --------------------------------------------------
		$newAdverts = DB::table("adverts as adv")->select(			
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
			->whereRaw("NOW() BETWEEN adv.startDate AND adv.finishDate AND adv.public = true".$whereLocationRawStr)
			->orderBy("startDate", "desc")			
			->orderBy("adv.id", "desc")
			->take(5) // взять 5 записей
			->get();			

			\Debugbar::info("NEWADVERTS:");
			\Debugbar::info($newAdverts);			
			
			$title = $usertitle?$usertitle." на сайте объявлений ТатарДоска":$title;
										
		return view("index")
		->with("title", $title)
		->with("locationName", $locationName)
		->with("location", $location)
		->with("urlRegion", $region)
		->with("urlPlace", $place)
		->with("categories", Categories::all())
		->with("subcategories", json_decode($subcats, true))
		->with("auth", Auth::user()?1:0)		
		->with("sklonResult", $sklonResult)
		->with("sklonPlace", $sklonPlace)
		->with("description", $description)
		->with("keywords", $keywords)
		->with("regions", $regions)
		->with("topAdverts", $topAdverts)
		->with("newAdverts", $newAdverts);
    }

	// ------------------------------------------
	// Cтрана
	// ------------------------------------------    
	//public function ShowCountryIndexPage(Request $request, $title=null, $region_id=null, $place_id=null, $category_id=null, $subcategory_id=null) {
	public function ShowCountryIndexPage(Request $request, $title=null) {
	    return $this->ShowIndexPage($request, $title, null, null);
    }		

	// ------------------------------------------
	// Регион
	// ------------------------------------------
	// private function ShowIndexPage(Request $request, $usertitle, $region, $place) {
    public function ShowRegionIndexPage(Request $request, $region) {	
		//return $this->ShowIndexPage($request, "123123123", $region, null);
		//return $this->ShowIndexPage($request, "Объявления Павлодарской области", $region, null);
		return $this->ShowIndexPage($request, null, $region, null);
    }		

	// ------------------------------------------
	// Город или село
	// ------------------------------------------
    public function ShowPlaceIndexPage(Request $request, $region, $place) {
	    return $this->ShowIndexPage($request, null, $region, $place);
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