<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\File;
use DB;

use App\Helpers\Petrovich;
use App\Categories;
use App\Regions;
use App\Places;
use App\SubCats;

class IndexController extends Controller {
		    
    // Базовая функция для главной страницы
    private function ShowIndexPage($region, $place) {
						
			if ($region===null && $place===null) {
				$title = "Доска объявлений Дамеля, все объявления Казахстана";
				$description = "Описание";
			}

			if ($region!=null && $place===null) {

				$region = Regions::select("name")->where("url", $region)->get();	
				
				if ($region->count()>0) {
					$petrovich = new Petrovich(Petrovich::GENDER_MALE);
					$title = "Доска объявлений Дамеля, все объявления ".$petrovich->firstname($region[0]->name, Petrovich::CASE_PREPOSITIONAL);
					$description = "Описание";
				}
				else 
					return view("errors/404");
			}

			if ($region!=null && $place!=null) {				
				
				$place = Places::select("name")->where("url", $place)->get();
				
				if ($place->count()>0) {
					$petrovich = new Petrovich(Petrovich::GENDER_MALE);
					$title = "Доска объявлений Дамеля, все объявления в ".$petrovich->firstname($place[0]->name, Petrovich::CASE_PREPOSITIONAL);;
					$description = "Описание";
				}
				else 
					return view("errors/404");
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