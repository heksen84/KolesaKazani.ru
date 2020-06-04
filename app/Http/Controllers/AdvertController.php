<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\Common;
use App\Categories;
use App\AdExtend;
use App\Regions;
use App\DealType;
use App\Adverts;
use App\Images;


class AdvertController extends Controller {
                
        // новое объявление
        public function newAdvert(Request $request) {

                \Debugbar::info("Язык: ".$request->lang); 
        
                if (Auth::check()) {
	                return view("newad")
                        ->with( "title", "Подать объявление бесплатно" )
                        ->with( "description", "Подать объявление бесплатно в Казахстане на сайте ".config('app.name'))
                        ->with( "keywords", "новое объявление, объявление, подать, разместить, разместить на сайте, казахстан")
                        ->with( "categories", Categories::all() )
                        ->with( "regions", Regions::all() )
                        ->with( "dealtypes", DealType::all()->toJson() )
                        ->with( "country", "kz" )
                        ->with( "lang", $request->lang );                        
                }
                else 
                        return redirect('/login');
        }                

        
        private $raw_engine_type = "CASE 
                WHEN transport.engine_type=0 THEN 'бензин' 
                WHEN transport.engine_type=1 THEN 'дизель' 
                WHEN transport.engine_type=2 THEN 'газ-бензин'
                WHEN transport.engine_type=3 THEN 'газ'
                WHEN transport.engine_type=4 THEN 'гибрид'
                WHEN transport.engine_type=5 THEN 'электричество'
                ELSE '-' 
                END as engine_type";
        
        // --------------------------------------------------
        // детали объявления
        // --------------------------------------------------
        public function getDetails(Request $request, $id) {

                \Debugbar::info("mykey: ".\Cache::get('mykey'));
                                
                $advertData = Adverts::select("category_id","subcategory_id")->where( "id", $id )->limit(1)->get();
                
                if (count($advertData)==0)
                        return view("errors/404");

                \Debugbar::info("-------------------");
                \Debugbar::info($advertData);
                \Debugbar::info("-------------------");

                // легковое авто
                if ($advertData[0]->category_id === 1 && $advertData[0]->subcategory_id === 1) {                        

                        $advert = DB::table("adverts as adv")->select(                                 
                                "adv.category_id",
                                "adv.subcategory_id",
                                "adv.startDate",
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
                                DB::raw($this->raw_engine_type),
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
                                "adv.startDate",
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
                                DB::raw($this->raw_engine_type),
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
                                "category_id",
                                "subcategory_id",
                                "startDate",                                
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
                                "category_id",
                                "subcategory_id",                            
                                "startDate",                                    
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
                                "adv.startDate",
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
                                DB::raw($this->raw_engine_type),
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
                        "category_id",
                        "subcategory_id",        
                        "startDate",                         
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
               
                // квартира
                if ($advertData[0]->category_id === 2 && $advertData[0]->subcategory_id === 9) {
                        $advert = DB::table("adverts as adv")->select(                                 
                        "adv.category_id",
                        "adv.subcategory_id",
                        "adv.startDate",
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
                        DB::raw("CASE WHEN realestate.ownership=0 THEN 'собственник' ELSE 'посредник' END as ownership"),
                        DB::raw("CASE WHEN realestate.kind_of_object=0 THEN 'вторичка' ELSE 'новостройка' END as kind_of_object"),                        
                        DB::raw("`kz_region`.`name` AS region_name, `kz_city`.`name` AS city_name") )
                        ->join("kz_region", "adv.region_id" , "=" , "kz_region.region_id" )                
                        ->join("kz_city", "adv.city_id" , "=" , "kz_city.city_id" )                                
                        ->join("sub_realestate as realestate", "adv.inner_id" , "=" , "realestate.id" )                                
                        ->where( "adv.id", $id )                                
                        ->limit(1)
                        ->get();                                                        
                }
                // комната
                if ($advertData[0]->category_id === 2 && $advertData[0]->subcategory_id === 10) {
                        $advert = DB::table("adverts as adv")->select(                                 
                        "adv.category_id",
                        "adv.subcategory_id",
                        "adv.startDate",
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
                        "realestate.area",
                        DB::raw("CASE WHEN realestate.ownership=0 THEN 'собственник' ELSE 'посредник' END as ownership"),                        
                        DB::raw("`kz_region`.`name` AS region_name, `kz_city`.`name` AS city_name") )
                        ->join("kz_region", "adv.region_id" , "=" , "kz_region.region_id" )                
                        ->join("kz_city", "adv.city_id" , "=" , "kz_city.city_id" )                                
                        ->join("sub_realestate as realestate", "adv.inner_id" , "=" , "realestate.id" )                                
                        ->where( "adv.id", $id )                                
                        ->limit(1)
                        ->get();                                                        
                }
                // дом, дача, коттедж
                if ($advertData[0]->category_id === 2 && $advertData[0]->subcategory_id === 11) {
                        $advert = DB::table("adverts as adv")->select(                                 
                        "adv.category_id",
                        "adv.subcategory_id",
                        "adv.startDate",
                        "adv.id", 
                        "adv.title", 
                        "adv.text", 
                        "adv.price", 
                        "adv.phone", 
                        "adv.coord_lat", 
                        "adv.coord_lon",
                        "realestate.property_type",                        
                        "realestate.rooms",
                        "realestate.area",                        
                        DB::raw("CASE WHEN realestate.ownership=0 THEN 'собственник' ELSE 'посредник' END as ownership"),
                        DB::raw("CASE WHEN realestate.kind_of_object=0 THEN 'вторичка' ELSE 'новостройка' END as kind_of_object"),
                        DB::raw("CASE 
                        WHEN realestate.type_of_building=0 THEN 'дом' 
                        WHEN realestate.type_of_building=1 THEN 'дача' 
                        WHEN realestate.type_of_building=2 THEN 'коттедж' 
                        ELSE '-' 
                        END as type_of_building"),                        
                        DB::raw("`kz_region`.`name` AS region_name, `kz_city`.`name` AS city_name") )
                        ->join("kz_region", "adv.region_id" , "=" , "kz_region.region_id" )                
                        ->join("kz_city", "adv.city_id" , "=" , "kz_city.city_id" )                                
                        ->join("sub_realestate as realestate", "adv.inner_id" , "=" , "realestate.id" )                                
                        ->where( "adv.id", $id )                                
                        ->limit(1)
                        ->get();                                                        
                }
                // земельный участок
                if ($advertData[0]->category_id === 2 && $advertData[0]->subcategory_id === 12) {
                        $advert = DB::table("adverts as adv")->select(                                 
                        "adv.category_id",
                        "adv.subcategory_id",
                        "adv.startDate",
                        "adv.id", 
                        "adv.title", 
                        "adv.text", 
                        "adv.price", 
                        "adv.phone", 
                        "adv.coord_lat", 
                        "adv.coord_lon",
                        "realestate.area",                        
                        DB::raw("CASE WHEN realestate.ownership=0 THEN 'собственник' ELSE 'посредник' END as ownership"),                        
                        DB::raw("`kz_region`.`name` AS region_name, `kz_city`.`name` AS city_name") )
                        ->join("kz_region", "adv.region_id" , "=" , "kz_region.region_id" )                
                        ->join("kz_city", "adv.city_id" , "=" , "kz_city.city_id" )                                
                        ->join("sub_realestate as realestate", "adv.inner_id" , "=" , "realestate.id" )                                
                        ->where( "adv.id", $id )                                
                        ->limit(1)
                        ->get();                                                        
                }
                // гараж или машиноместо
                if ($advertData[0]->category_id === 2 && $advertData[0]->subcategory_id === 13) {
                        $advert = DB::table("adverts as adv")->select(                                 
                        "adv.category_id",
                        "adv.subcategory_id",
                        "adv.startDate",
                        "adv.id", 
                        "adv.title", 
                        "adv.text", 
                        "adv.price", 
                        "adv.phone", 
                        "adv.coord_lat", 
                        "adv.coord_lon",                        
                        "realestate.area",                        
                        DB::raw("CASE WHEN realestate.ownership=0 THEN 'собственник' ELSE 'посредник' END as ownership"),                        
                        DB::raw("`kz_region`.`name` AS region_name, `kz_city`.`name` AS city_name") )
                        ->join("kz_region", "adv.region_id" , "=" , "kz_region.region_id" )                
                        ->join("kz_city", "adv.city_id" , "=" , "kz_city.city_id" )                                
                        ->join("sub_realestate as realestate", "adv.inner_id" , "=" , "realestate.id" )                                
                        ->where( "adv.id", $id )                                
                        ->limit(1)
                        ->get();                                                        
                }
                // коммерческая недвижимость
                if ($advertData[0]->category_id === 2 && $advertData[0]->subcategory_id === 14) {
                        $advert = DB::table("adverts as adv")->select(                                 
                        "adv.category_id",
                        "adv.subcategory_id",
                        "adv.startDate",
                        "adv.id", 
                        "adv.title", 
                        "adv.text", 
                        "adv.price", 
                        "adv.phone", 
                        "adv.coord_lat", 
                        "adv.coord_lon",
                        "realestate.property_type",                        
                        "realestate.rooms",
                        "realestate.area",                        
                        DB::raw("CASE WHEN realestate.ownership=0 THEN 'собственник' ELSE 'посредник' END as ownership"),
                        DB::raw("CASE WHEN realestate.kind_of_object=0 THEN 'вторичка' ELSE 'новостройка' END as kind_of_object"),
                        DB::raw("CASE 
                        WHEN realestate.type_of_building=0 THEN 'дом' 
                        WHEN realestate.type_of_building=1 THEN 'дача' 
                        WHEN realestate.type_of_building=2 THEN 'коттедж' 
                        ELSE '-' 
                        END as type_of_building"),                        
                        DB::raw("`kz_region`.`name` AS region_name, `kz_city`.`name` AS city_name") )
                        ->join("kz_region", "adv.region_id" , "=" , "kz_region.region_id" )                
                        ->join("kz_city", "adv.city_id" , "=" , "kz_city.city_id" )                                
                        ->join("sub_realestate as realestate", "adv.inner_id" , "=" , "realestate.id" )                                
                        ->where( "adv.id", $id )                                
                        ->limit(1)
                        ->get();                                                        
                }
                // недвижимость за рубежом
                if ($advertData[0]->category_id === 2 && $advertData[0]->subcategory_id === 15) {
                        $advert = DB::table("adverts as adv")->select(                                 
                        "adv.category_id",
                        "adv.subcategory_id",
                        "adv.startDate",
                        "adv.id", 
                        "adv.title", 
                        "adv.text", 
                        "adv.price", 
                        "adv.phone", 
                        "adv.coord_lat", 
                        "adv.coord_lon",
                        "realestate.property_type",                        
                        "realestate.rooms",
                        "realestate.area",                        
                        DB::raw("CASE WHEN realestate.ownership=0 THEN 'собственник' ELSE 'посредник' END as ownership"),
                        DB::raw("CASE WHEN realestate.kind_of_object=0 THEN 'вторичка' ELSE 'новостройка' END as kind_of_object"),
                        DB::raw("CASE 
                        WHEN realestate.type_of_building=0 THEN 'дом' 
                        WHEN realestate.type_of_building=1 THEN 'дача' 
                        WHEN realestate.type_of_building=2 THEN 'коттедж' 
                        ELSE '-' 
                        END as type_of_building"),                        
                        DB::raw("`kz_region`.`name` AS region_name, `kz_city`.`name` AS city_name") )
                        ->join("kz_region", "adv.region_id" , "=" , "kz_region.region_id" )                
                        ->join("kz_city", "adv.city_id" , "=" , "kz_city.city_id" )                                
                        ->join("sub_realestate as realestate", "adv.inner_id" , "=" , "realestate.id" )                                
                        ->where( "adv.id", $id )                                
                        ->limit(1)
                        ->get();                                                        
                }
                
                // выборка для всего остального
                if ($advertData[0]->category_id > 2 && $advertData[0]->subcategory_id > 0 || $advertData[0]->category_id>0 && !$advertData[0]->subcategory_id) {                        
                        $advert = Adverts::select(                        
                        "startDate",
                        "category_id",
                        "subcategory_id",                        
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

                \DebugBar::info($advert); 
                \Debugbar::info("advert count: ".count($advert));

                if (count($advert)==0) {
                  return view("errors/404");
                }
                        
                //$images = Images::select(DB::raw( "concat('".\Common::getImagesPath()."/normal/', name) AS name" ))->where("advert_id", $id)->get();
                $images = Images::select(DB::raw( "concat('".\Common::getImagesPath()."/normal/', name) AS name" ))->where("advert_id", $id)->get();

                //\Storage::disk('s3')->url($name)

                \Debugbar::info($advert);
                \Debugbar::info($images);
        
                // проработать СЕО -->
                return view("details")
                ->with( "title", $advert[0]->title )
                ->with( "description", $advert[0]->title )
                ->with( "keywords", $advert[0]->title)                
                ->with( "advert", $advert[0])                
                ->with( "images", $images);
        }            

        // удалить объявление
        public function deleteAdvert($id) {

                // ПРИ УДАЛЕНИИ ПРОВЕРЯТЬ USER_ID с текущим      
                $user_id = Auth::id();
                \Debugbar::info("user_id ".$user_id);

                $advertRequest = Adverts::select( "category_id", "subcategory_id", "inner_id")->where( "id", $id )->where("user_id", $user_id)->limit(1);                

                $adverts = $advertRequest->get();
                \Debugbar::info($adverts);

                if (count($adverts)==0) {
                        \Debugbar::info("нет прав на удаление");
                        return response()->json([ "result" => "error", "msg" => "Access denied for this operation" ]);  
                }
                                
                // ---- Удаляю картинки объявления ----
                $imagesRequest = Images::select(DB::raw("name"))->where("advert_id", $id);                
                $images = $imagesRequest->get(); // получаю массив

                if (count($images)>0) {
                        
                        foreach($images as $image) {
                                \Debugbar::info($image->name);
                                
                                $small_image = \Common::getImagesPath()."/small/".$image->name;                        
                                if (file_exists($small_image))
                                        unlink($small_image);                                

                                $normal_image = \Common::getImagesPath()."/normal/".$image->name;                        
                                if (file_exists($normal_image))
                                        unlink($normal_image);
                        }
                        
                        $imagesRequest->delete();
                }                                

            return response()->json([ "result" => "deleted", "msg" => "объявление удалено" ]);  
        }

        // -----------------------------------------------------------
        // сделать vip, покрасить, срочно, и т.п.
        // -----------------------------------------------------------
        public function makeExtend($advert_id, $adv_type) {                                

                switch($adv_type) {
                        case "makeVip": {
                        
                        break;
                        }
                        case "srochno_torg": {

                                $adex = AdExtend::select("id")->where("advert_id", "=", $advert_id)->limit(1)->get();
                                \Debugbar::info("count: ".$adex->count());

                                if ($adex->count()>0) {
                                        AdExtend::find($adex[0]->id)->update(['srochno_torg' => true]);
                                        Adverts::where("id", '=', $advert_id)->update(['finishDate' => \Carbon\Carbon::now()->add(7, 'day')->toDateTimeString()]); // обновляю finishDate в adverts
                                }
                                else {                                      
                                        $adex = new AdExtend();
                                        $adex->advert_id = $advert_id;
                                        $adex->srochno_torg = true;
                                        $adex->v_top = false;
                                        $adex->color = false;
                                        $adex->price = 500; // default                                
                                        $adex->startDate = \Carbon\Carbon::now()->toDateTimeString();
                                        $adex->finishDate = \Carbon\Carbon::now()->add(7, 'day')->toDateTimeString();                                                          
                                        $adex->save();

                                        // обновляю finishDate в adverts
                                        Adverts::where("id", '=', $advert_id)->update(['finishDate' => \Carbon\Carbon::now()->add(7, 'day')->toDateTimeString()]);
                                }
                        
                        break;
                        }
                        case "prodlit": {
                        
                        break;
                        }
                        case "makePaint": {

                                $adex = AdExtend::select("id")->where("advert_id", "=", $advert_id)->limit(1)->get();
                                \Debugbar::info("count: ".$adex->count());

                                if ($adex->count()>0) {
                                        AdExtend::find($adex[0]->id)->update(['color' => true]);                                        
                                        Adverts::where("id", '=', $advert_id)->update(['finishDate' => \Carbon\Carbon::now()->add(7, 'day')->toDateTimeString()]); // обновляю finishDate в adverts
                                }
                                else {                                      
                                        $adex = new AdExtend();
                                        $adex->advert_id = $advert_id;
                                        $adex->srochno_torg = false;
                                        $adex->v_top = false;
                                        $adex->color = true;
                                        $adex->price = 500; // default                                
                                        $adex->startDate = \Carbon\Carbon::now()->toDateTimeString();
                                        $adex->finishDate = \Carbon\Carbon::now()->add(7, 'day')->toDateTimeString();                                                          
                                        $adex->save();
                                        
                                        // обновляю finishDate в adverts
                                        Adverts::where("id", '=', $advert_id)->update(['finishDate' => \Carbon\Carbon::now()->add(7, 'day')->toDateTimeString()]);
                                }
                        
                        break;
                        }
                }

                \Debugbar::info($adv_type);
                                
                return response()->json([ "result" => "success", "msg" => "готово" ]);  
        }
        
    
}