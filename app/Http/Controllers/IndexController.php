<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Petrovich;
use App\Adverts;
use App\Categories;
use App\Regions;
use App\Places;
use DB;

class IndexController extends Controller {

	// ------------------------------------------
	// получить данные региона
	// ------------------------------------------
    private function getRegionData($region) {                
		
		if (!$region)
			return false;

        $regionId = Regions::select("region_id")->where("url", $region)->get();        
		\Debugbar::info("ID региона: ".$regionId[0]->region_id);
		
        return $regionId[0];
    }
    
	// ------------------------------------------
	// получить данные города / села
	// ------------------------------------------
    private function getPlaceData($place) {                

		if (!$place)
			return false;

        $placeId = Places::select("city_id")->where("url", $place)->get();        
		\Debugbar::info("ID города/села: ".$placeId[0]->city_id);
		
        return $placeId[0];
    }

	// ------------------------------------------
	// найти по строке
	// ------------------------------------------
    private function search($str, $region, $place) {
		
		$regionData = $this->getRegionData($region); 
		$placeData = $this->getPlaceData($place);
		
		if (!$regionData && !$placeData)
			$whereStr = "MATCH (title) AGAINST('".$str."' IN BOOLEAN MODE)";

		if ($regionData && !$placeData)
			$whereStr = "MATCH (title) AGAINST('".$str."' IN BOOLEAN MODE) AND adv.region_id=".$regionData->region_id;		

		if ($regionData && $placeData)
			$whereStr = "MATCH (title) AGAINST('".$str."' IN BOOLEAN MODE) AND adv.region_id=".$regionData->region_id." AND adv.city_id=".$placeData->city_id;		
        
        $items = DB::table("adverts as adv")->select(
            "adv.id", 
            "adv.title", 
			"adv.price",
			"adv.created_at",
			"kz_region.name as region_name",
            "kz_city.name as city_name",
            DB::raw("concat('".\Common::getImagesPath()."/small/', (SELECT name FROM images WHERE images.advert_id=adv.id LIMIT 1)) as imageName"
		))
		->join("kz_region", "adv.region_id", "=", "kz_region.region_id" )
        ->join("kz_city", "adv.city_id", "=", "kz_city.city_id" )
		->whereRaw($whereStr)
		->paginate(10)
		->onEachSide(1);                  
        
		\Debugbar::info($items);		    
		
		$str = "Результаты по запросу '".$str."'";
            
        return view("results")         
            ->with("title", $str)         
            ->with("description", "Результаты поиска по запросу: ".$str)         
            ->with("keywords", "поиск, результат, запрос")
            ->with("items", $items)             
            ->with("categoryId", null)
            ->with("subcategoryId", null)
            ->with("region", $region)
         	->with("city", $place)
            ->with("category", null)
            ->with("subcategory", null)            
            ->with("page", 0)
            ->with("startPage", 0)
            ->with("start_price", 0)
			->with("end_price", 0)
			->with("filters", null);
    }
		    	
	// ------------------------------------------
	// Базовая функция для главной страницы		
	// ------------------------------------------
    private function ShowIndexPage(Request $request, $region, $place) {
		
		if ($request->search!="")
			return $this->search($request->search, $region, $place);		
		
			$sklonResult="";
						
		// Страна
		if ($region===null && $place===null) {

			$location = "/";				
			$title = mb_strtoupper(config('app.name'))." - объявления Казахстана";
			$description = "Объявления о покупке, продаже, обмене, а так же сдаче в аренду в Казахстане";
			$keywords = "объявления, частные объявления, доска объявлений, дать объявление, объявления продажа, объявления продаю, сайт объявлений, FLIX, страна, казахстан";
			$locationName = "Казахстан";
		}

		// Регион
		if ($region!=null && $place===null) {

			$location = $region;
			$locationName = Regions::select("name")->where("url", $region)->get();

			if (count($locationName)==0)
				return view("errors/404"); // редирект

			$regionArr = $locationName; // ???
			$locationName = $locationName[0]->name;			

			if ($regionArr->count()>0) {
				
				$petrovich = new Petrovich(Petrovich::GENDER_FEMALE);					
				$regionName = $regionArr[0]->name;
				$regionName = trim(str_replace("обл.", "", $regionName));
				$sklonResult = $petrovich->firstname($regionName, 0);

				// minifix
				switch($sklonResult) {
					case "Алмы-Атинской": $sklonResult="Алма-Атинской"; break;
				}

				$title = mb_strtoupper(config('app.name'))." - объявления ".$sklonResult." области";
				$description = "Объявления о покупке, продаже, обмене, а так же сдаче в аренду в ".$sklonResult." области";
				$keywords = "объявления, частные объявления, доска объявлений, дать объявление, объявления продажа, объявления продаю, сайт объявлений, FLIX, ".$regionName." область";
			}
			else 
				return view("errors/404"); // редирект
		}

		// Город, село
		if ($region!=null && $place!=null) {				
				
			$location = $region."/".$place;
			$locationName = Places::select("name")->where("url", $place)->get();

			if (count($locationName)==0)
				return view("errors/404"); // редирект

			$placeArr = $locationName;
			$locationName = $locationName[0]->name;
				
			if ($placeArr->count() > 0) {
			
				$petrovich = new Petrovich(Petrovich::GENDER_MALE);
				$sklonResult = $petrovich->firstname($placeArr[0]->name, 0);
				$sklonResultForDesc = $petrovich->firstname($placeArr[0]->name, 4);

				$title = mb_strtoupper(config('app.name'))." - объявления ".$sklonResult;
				$description = "Объявления о покупке, продаже, обмене, а так же сдаче в аренду в ".$sklonResultForDesc;
				$keywords = "объявления, частные объявления, доска объявлений, дать объявление, объявления продажа, объявления продаю, сайт объявлений, FLIX, ".$locationName;
			
			}
			else 
				return view("errors/404"); // редирект
		}
				
		$subcats = DB::table("subcats")
			->join("categories", "categories.id", "=", "subcats.category_id")
			->select("subcats.*", "categories.url as category_url")
			->where("lang", "=", 0) // ru - default
			->get();


		\Debugbar::info("location: ".$locationName);
		\Debugbar::info("REGION: ".$region);
		\Debugbar::info("PLACE: ".$place);

		$petrovich = new Petrovich(Petrovich::GENDER_FEMALE);	
		
		// новые объявления или VIP
		$newAdverts = DB::table("adverts as adv")->select(
            "adv.id", 
            "adv.title", 
            "adv.price", 
            "adv.created_at",            
            "kz_region.name as region_name",
            "kz_city.name as city_name",
            DB::raw("concat('".\Common::getImagesPath()."/small/', (SELECT name FROM images WHERE images.advert_id=adv.id LIMIT 1)) as imageName"))
            ->join("kz_region", "adv.region_id", "=", "kz_region.region_id" )
			->join("kz_city", "adv.city_id", "=", "kz_city.city_id" )->orderBy("created_at", "desc")->take(20)->get();			

			\Debugbar::info("NEWADVERTS:");
			\Debugbar::info($newAdverts);
			
		
		// список регионов
		$regions = Regions::all();
		
		\Debugbar::info("-- newAdverts --");
		\Debugbar::info($newAdverts);
											
		return view("index")		
		->with("locationName", $locationName)
		->with("location", $location)
		->with("categories", Categories::all())
		->with("subcategories", json_decode($subcats, true))
		->with("auth", Auth::user()?1:0)
		->with("title", $title)
		->with("sklonResult", $sklonResult)
		->with("description", $description)
		->with("keywords", $keywords)
		->with("regions", $regions)
		->with("newAdverts", $newAdverts);
    }

	// ------------------------------------------
	// Cтрана
	// ------------------------------------------
    public function ShowCountryIndexPage(Request $request) {

		//\Debugbar::info("COUNTRY: ".config('app.country'));		
		//\Cache::put('mykey', '12345');		
		//\Debugbar::info("mykey: ".\Cache::get('mykey'));		

	    return $this->ShowIndexPage($request, null, null);
    }		

	// ------------------------------------------
	// Регион
	// ------------------------------------------
    public function ShowRegionIndexPage(Request $request, $region) {
	    return $this->ShowIndexPage($request, $region, null);
    }		

	// ------------------------------------------
	// Город или село
	// ------------------------------------------
    public function ShowPlaceIndexPage(Request $request, $region, $place) {
	    return $this->ShowIndexPage($request, $region, $place);
    }		
					
}