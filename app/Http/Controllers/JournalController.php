<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCats;
use App\CarMark;
use App\Places;
use DB;

class JournalController extends Controller {

   // Получить имена подкатегорий
    public function getSubCategoryNamesById(Request $request, $lang) {
        \Debugbar::info("язык: ".$lang);
        return SubCats::select( "id", "name" )->where("category_id", $request->id)->where("lang", 0)->get();
    }

    // Выбор марок авто
    public function getCarsMarks($lang) {
        \Debugbar::info("язык: ".$lang);
        $car_marks = CarMark::all("id_car_mark", "name");
        return $car_marks;
    }
        
    // Выбор моделей авто
    public function getCarsModels(Request $request, $lang) {
        \Debugbar::info("язык: ".$lang);
        return DB::table("car_model")->where("id_car_mark", $request->mark_id )->get();
    }

    // Получить расположение
    public function GetPlaces(Request $request, $lang) {
        \Debugbar::info("язык: ".$lang);
        return Places::where("region_id",  $request->region_id )->orderBy("name", "asc")->get();
   }
    
}
