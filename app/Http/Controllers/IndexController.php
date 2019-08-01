<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\File;
use DB;

use App\Categories;
use App\Regions;
use App\Places;
use App\SubCats;

class IndexController extends Controller {
		    
    // Базовая функция для главной страницы
    private function ShowIndexPage($region, $place) {

			\Debugbar::info("REGION: ".$region);	
			\Debugbar::info("PLACE: ".$place);
			
			$title = ""; 
			$description = "";	    
			
			if ($region===null && $place===null) {
				$title = "Доска объявлений Дамеля - все объявления Казахстана";
				$description = "Описание";
			}

			if ($region!=null && $place===null) {
				$title = "Регион";
				$description = "Описание";
			}

			if ($region!=null && $place!=null) {
				$title = "Город";
				$description = "Описание";
			}
		
			$subcats = DB::table("subcats")->join("categories", "categories.id", "=", "subcats.category_id")->select("subcats.*", "categories.url as category_url")->get();
		
			return view("index")
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