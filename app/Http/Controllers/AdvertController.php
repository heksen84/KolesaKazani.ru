<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\Common;
use App\Categories;
use App\Regions;
use App\DealType;
use App\Adverts;
use App\Images;


class AdvertController extends Controller {      
                
        // --------------------------------------------------
        // новое объявление
        // --------------------------------------------------
        public function newAdvert(Request $request) {

                \Debugbar::info("Язык: ".$request->lang); 
        
                if (Auth::check()) {
	                return view("newad")
                        ->with( "title", "Подать объявление" )
                        ->with( "description", "Подать новое объявление на сайте ".config('app.name'))
                        ->with( "keywords", "новое объявление, объявление, подать, разместить, разместить на сайте")
                        ->with( "categories", Categories::all() )
                        ->with( "regions", Regions::all() )
                        ->with( "dealtypes", DealType::all()->toJson() )
                        ->with( "country", "kz" )
                        ->with( "lang", $request->lang );                        
                }
                else 
                return redirect('/login');
        }                
     
        // --------------------------------------------------
        // детали объявления
        // --------------------------------------------------
        public function getDetails(Request $request, $id) {

                \Debugbar::info("mykey: ".\Cache::get('mykey'));

                if ( $id < 0 ) 
                        return view("errors/404");

                // 1. определить id категории
                // 2. сделать выборку из необходимой таблицы                
                $advertData = Adverts::select("category_id","subcategory_id")->where( "id", $id )->limit(1)->get();

                \Debugbar::info("-------------------");
                \Debugbar::info($advertData);
                \Debugbar::info("-------------------");

                /*
                ---------------------------------------
                транспорт
                ---------------------------------------*/
                
                // легковое авто
                if ($advertData[0]->category_id === 1 && $advertData[0]->subcategory_id === 1) {                        

                        $advert = DB::table("adverts as adv")->select(                                 
                                "adv.category_id",
                                "adv.subcategory_id",
                                "adv.id", 
                                "adv.title", 
                                "adv.text", 
                                "adv.price", 
                                "adv.phone", 
                                "adv.coord_lat", 
                                "adv.coord_lon", 
                                "transport.type", 
                                "car_mark.name as car_name", 
                                "car_model.name as car_model", 
                                "transport.year", 
                                DB::raw("CASE WHEN transport.steering_position=0 THEN 'слева' ELSE 'справа' END as steering_position"),
                                "transport.mileage",
                                DB::raw("CASE 
                                WHEN transport.engine_type=0 THEN 'бензин' 
                                WHEN transport.engine_type=1 THEN 'дизель' 
                                WHEN transport.engine_type=2 THEN 'газ-бензин'
                                WHEN transport.engine_type=3 THEN 'газ'
                                WHEN transport.engine_type=4 THEN 'гибрид'
                                WHEN transport.engine_type=5 THEN 'электричество'
                                ELSE '-' END as engine_type"),
                                DB::raw("CASE WHEN transport.customs=1 THEN 'да' ELSE 'нет' END as customs"),                                
                                DB::raw("`kz_region`.`name` AS region_name, `kz_city`.`name` AS city_name") )
                                ->join("kz_region", "adv.region_id" , "=" , "kz_region.region_id" )                
                                ->join("kz_city", "adv.city_id" , "=" , "kz_city.city_id" )                
                                ->join("sub_transport as transport", "adv.inner_id" , "=" , "transport.id" )                
                                ->join("car_mark", "car_mark.id_car_mark" , "=" , "transport.mark" )                
                                ->join("car_model", "car_mark.id_car_mark" , "=" , "car_model.id_car_mark" )                
                                ->where( "adv.id", $id )                                
                                ->limit(1)
                                ->get();                                
                }

                // грузовое авто
                if ($advertData[0]->category_id === 1 && $advertData[0]->subcategory_id === 2) {

                        $advert = DB::table("adverts as adv")->select(                                 
                                "adv.category_id",
                                "adv.subcategory_id",
                                "adv.id", 
                                "adv.title", 
                                "adv.text", 
                                "adv.price", 
                                "adv.phone", 
                                "adv.coord_lat", 
                                "adv.coord_lon", 
                                "transport.type",                                
                                "transport.year", 
                                DB::raw("CASE WHEN transport.steering_position=0 THEN 'слева' ELSE 'справа' END as steering_position"),
                                "transport.mileage",
                                DB::raw("CASE 
                                WHEN transport.engine_type=0 THEN 'бензин' 
                                WHEN transport.engine_type=1 THEN 'дизель' 
                                WHEN transport.engine_type=2 THEN 'газ-бензин'
                                WHEN transport.engine_type=3 THEN 'газ'
                                WHEN transport.engine_type=4 THEN 'гибрид'
                                WHEN transport.engine_type=5 THEN 'электричество'
                                ELSE '-' END as engine_type"),
                                DB::raw("CASE WHEN transport.customs=1 THEN 'да' ELSE 'нет' END as customs"),                                
                                DB::raw("`kz_region`.`name` AS region_name, `kz_city`.`name` AS city_name") )
                                ->join("kz_region", "adv.region_id" , "=" , "kz_region.region_id" )                
                                ->join("kz_city", "adv.city_id" , "=" , "kz_city.city_id" )                
                                ->join("sub_transport as transport", "adv.inner_id" , "=" , "transport.id" )                
                                ->where( "adv.id", $id )                                
                                ->limit(1)
                                ->get();                                
                }

                // мототехника
                if ($advertData[0]->category_id === 1 && $advertData[0]->subcategory_id === 3) {

                        $advert = Adverts::select(                                
                                "id", 
                                "title", 
                                "text", 
                                "price", 
                                "phone", 
                                "coord_lat", 
                                "coord_lon", 
                                DB::raw("kz_region.name AS region_name, kz_city.name AS city_name") )
                                ->join("kz_region", "adverts.region_id" , "=" , "kz_region.region_id" )                
                                ->join("kz_city", "adverts.city_id" , "=" , "kz_city.city_id" )                
                                ->where( "id", $id )
                                ->limit(1)
                                ->get();
                }

                // спецтехника
                if ($advertData[0]->category_id === 1 && $advertData[0]->subcategory_id === 4) {

                        $advert = Adverts::select(                                
                                "id", 
                                "title", 
                                "text", 
                                "price", 
                                "phone", 
                                "coord_lat", 
                                "coord_lon", 
                                DB::raw("kz_region.name AS region_name, kz_city.name AS city_name") )
                                ->join("kz_region", "adverts.region_id" , "=" , "kz_region.region_id" )                
                                ->join("kz_city", "adverts.city_id" , "=" , "kz_city.city_id" )                
                                ->where( "id", $id )
                                ->limit(1)
                                ->get();
                }

                // ретро авто
                if ($advertData[0]->category_id === 1 && $advertData[0]->subcategory_id === 5) {

                        $advert = DB::table("adverts as adv")->select(                                 
                                "adv.category_id",
                                "adv.subcategory_id",
                                "adv.id", 
                                "adv.title", 
                                "adv.text", 
                                "adv.price", 
                                "adv.phone", 
                                "adv.coord_lat", 
                                "adv.coord_lon", 
                                "transport.type",                                
                                "transport.year", 
                                DB::raw("CASE WHEN transport.steering_position=0 THEN 'слева' ELSE 'справа' END as steering_position"),
                                "transport.mileage",
                                DB::raw("CASE 
                                WHEN transport.engine_type=0 THEN 'бензин' 
                                WHEN transport.engine_type=1 THEN 'дизель' 
                                WHEN transport.engine_type=2 THEN 'газ-бензин'
                                WHEN transport.engine_type=3 THEN 'газ'
                                WHEN transport.engine_type=4 THEN 'гибрид'
                                WHEN transport.engine_type=5 THEN 'электричество'
                                ELSE '-' END as engine_type"),
                                DB::raw("CASE WHEN transport.customs=1 THEN 'да' ELSE 'нет' END as customs"),                                
                                DB::raw("`kz_region`.`name` AS region_name, `kz_city`.`name` AS city_name") )
                                ->join("kz_region", "adv.region_id" , "=" , "kz_region.region_id" )                
                                ->join("kz_city", "adv.city_id" , "=" , "kz_city.city_id" )                
                                ->join("sub_transport as transport", "adv.inner_id" , "=" , "transport.id" )                
                                ->where( "adv.id", $id )                                
                                ->limit(1)
                                ->get();                                
                }
                
                // выборка для остального траспорта
                if ($advertData[0]->category_id === 1 && $advertData[0]->subcategory_id > 5) {                        
                        $advert = Adverts::select(                                 
                        "id", 
                        "title", 
                        "text", 
                        "price", 
                        "phone", 
                        "coord_lat", 
                        "coord_lon", 
                        DB::raw("kz_region.name AS region_name, kz_city.name AS city_name") )
                        ->join("kz_region", "adverts.region_id" , "=" , "kz_region.region_id" )                
                        ->join("kz_city", "adverts.city_id" , "=" , "kz_city.city_id" )                
                        ->where( "id", $id )
                        ->limit(1)
                        ->get();
                }

                /*
                ---------------------------------------
                недвижимость
                ---------------------------------------*/
                
                // квартира
                if ($advertData[0]->category_id === 2 && $advertData[0]->subcategory_id === 9) {
                        $advert = DB::table("adverts as adv")->select(                                 
                        "adv.category_id",
                        "adv.subcategory_id",
                        "adv.id", 
                        "adv.title", 
                        "adv.text", 
                        "adv.price", 
                        "adv.phone", 
                        "adv.coord_lat", 
                        "adv.coord_lon",
                        "realestate.property_type",
                        "realestate.floor",
                        "realestate.floors_house",
                        "realestate.rooms",
                        "realestate.area",
                        "realestate.ownership",
                        "realestate.kind_of_object",
                        "realestate.type_of_building",
                        DB::raw("`kz_region`.`name` AS region_name, `kz_city`.`name` AS city_name") )
                        ->join("kz_region", "adv.region_id" , "=" , "kz_region.region_id" )                
                        ->join("kz_city", "adv.city_id" , "=" , "kz_city.city_id" )                                
                        ->join("sub_realestate as realestate", "adv.inner_id" , "=" , "realestate.id" )                                
                        ->where( "adv.id", $id )                                
                        ->limit(1)
                        ->get();                                                        
                }

                \DebugBar::info($advert); 
                \Debugbar::info("advert count: ".count($advert));

                if (count($advert)==0)
                        return view("errors/404");
                        
                $images = Images::select(DB::raw( "concat('".\Common::getImagePath()."', name) AS name" ))->where("advert_id", $id)->where("type", 1)->get();

                \Debugbar::info($advert);
                \Debugbar::info($images);
        
                return view("details")
                ->with( "title", "Подать объявление" )
                ->with( "description", "Подать новое объявление на сайте ".config('app.name'))
                ->with( "keywords", "новое объявление, объявление, подать, разместить, разместить на сайте")                
                ->with( "advert", $advert[0])                
                ->with( "images", $images);
        }    
    
}