<?php

/*
---------------------------------------
TaskList:
1.Сделать правильные склонения title
---------------------------------------*/

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\File;

use App\Helpers\Petrovich;
use App\Categories;
use App\Regions;
use App\Places;
use App\SubCats;
use DB;

class IndexController extends Controller {
		    
	// ------------------------------------------------
	// Базовая функция для главной страницы	
	// ------------------------------------------------
    private function ShowIndexPage($region, $place) {			
						
		// Страна
		if ($region===null && $place===null) {				
			$location = "/";				
			$title = "Доска объявлений Дамеля, все объявления Казахстана";
			$description = "Описание";
			$locationName = "Казахстан";
		}

		// Регион
		if ($region!=null && $place===null) {

			$location = $region;
			$locationName = Regions::select("name")->where("url", $region)->get();
			$locationName = $locationName[0]->name;
			$regionArr = Regions::select("name")->where("url", $region)->get();	

			if ($regionArr->count()>0) {
				$petrovich = new Petrovich(Petrovich::GENDER_MALE);
					
				//$regionName = $region[0]->name;
				//$regionName = trim(str_replace("обл.", "", $region[0]->name));
				//$title = "Доска объявлений Дамеля, все объявления ".$petrovich->firstname($regionName, Petrovich::CASE_PREPOSITIONAL);

				$title = "Доска объявлений Дамеля, объявления ".$regionArr[0]->name;
				$description = "Описание";
			}
				else return view("errors/404"); // редирект
		}

		// Город, село
		if ($region!=null && $place!=null) {				
				
			$location = $region."/".$place;
			$locationName = Places::select("name")->where("url", $place)->get();
			$locationName = $locationName[0]->name;

			$placeArr = Places::select("name")->where("url", $place)->get();
				
			if ($placeArr->count()>0) {
				$petrovich = new Petrovich(Petrovich::GENDER_MALE);
				$title = "Доска объявлений Дамеля, объявления ".$petrovich->firstname($placeArr[0]->name, Petrovich::CASE_GENITIVE);
				$description = "Описание";
			}
			else return view("errors/404"); // редирект
		}
		
		$subcats = DB::table("subcats")
		->join("categories", "categories.id", "=", "subcats.category_id")
		->select("subcats.*", "categories.url as category_url")
		->get();

		\Debugbar::info("location: ".$locationName);
		\Debugbar::info("REGION: ".$region);
		\Debugbar::info("PLACE: ".$place);
											
		return view("index")
		->with("locationName", $locationName)
		->with("location", $location)
		->with("categories", Categories::all())
		->with("subcategories", json_decode($subcats, true))
		->with("regions", Regions::all())
		->with("auth", Auth::user()?1:0)
		->with("title", $title)
		->with("description", $description);
    }

    // Cтрана
    public function ShowCountryIndexPage() {
	    return $this->ShowIndexPage(null, null);
    }		

    // Регион
    public function ShowRegionIndexPage($region) {
	    return $this->ShowIndexPage($region, null);
    }		

    // Город или село
    public function ShowPlaceIndexPage($region, $place) {
	    return $this->ShowIndexPage($region, $place);
    }		
	
	/*
	---------------------------------------------
	 Получить расположение
	---------------------------------------------*/
	public function GetPlaces(Request $request) {
   	  return Places::where("region_id",  $request->region_id )->orderBy("name", "asc")->get();
	}				
}