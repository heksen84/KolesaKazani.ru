<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Helpers\Petrovich;
use App\Helpers\Helper;
use App\Helpers\Sitemap;
use App\Adverts;
use App\CarMark;
use App\Categories;
use App\Transport;
use App\RealEstate;
use App\DealType;
use App\Regions;
use App\Urls;
use Validator;
use DB;

class AdvertController extends Controller {
    
    // Новое объявление
    public function NewAd() {
        return Auth::user()? view("newad")
        ->with( "title", "Новое объявление - Объявление на сайте ".config('app.name') )
        ->with( "description", "подать новое объявление")
        ->with( "keywords", "новое объявление")
        ->with( "categories", Categories::all() )
        ->with( "regions", Regions::all() )
        ->with( "dealtypes", DealType::all()->toJson() ) : redirect("login");
    }

    /*
    ----------------------------------
    Выбор марок авто
    ----------------------------------*/
     public function getCarsMarks() {

/*        $redis = Redis::connection();

        try {								
            $redis->ping();
            $car_marks = $redis->get("car_marks");
            if (!$car_marks) {
                $redis->set("car_marks", CarMark::all("id_car_mark", "name"));
                $car_marks = $redis->get("car_marks");
            }
        }
        catch(\Exception $e) {
            \Debugbar::warning($e->getMessage());
            $car_marks = CarMark::all("id_car_mark", "name");
        }
*/
          $car_marks = CarMark::all("id_car_mark", "name");
	  return $car_marks;
    }

    /*
    ----------------------------------------------------
    Выбор моделей авто
    ----------------------------------------------------*/
    public function getCarsModels(Request $request) {
     	return DB::table("car_model")->where("id_car_mark", $request->mark_id )->get();
    }
    
}