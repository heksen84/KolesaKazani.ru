<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Adverts;
use App\SubCats;
use App\Categories;
use App\RealEstate;

class SubCatsController extends Controller
{
    // максимальное число записей при выборке
    private $records_limit = 1000;

    public function getResultsByCategory(Request $request, $category, $subcat) {

        // -------------------------
        // получаю имя на русском
        // -------------------------
		$categories = SubCats::select('id', 'name')->where('url',  $subcat )->first();
        $items = Adverts::where('category_id',  $categories->id )->get();
        
        switch($category) {

            case "transport": {

                // Легковой транспорт
                if ($subcat=="legkovoy-avtomobil") {
                    
                    $adv_transport_type=1;

                    $results = DB::select(
                        "SELECT
                        concat(car_mark.name, ' ', car_model.name, ' ', year, ' г.') AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        mileage,
                        text,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport, car_mark, car_model) ON 
                        (
                            adv_transport.mark=car_mark.id_car_mark AND 
                            adv.adv_category_id=adv_transport.id AND 
                            adv_transport.model = car_model.id_car_model
                        ) WHERE adv_transport.type=1 ORDER BY price ASC LIMIT 0,".$this->records_limit                    
                    );

                    break;
                }
                                
                // Грузовой транспорт
                if ($subcat=="gruzovoy-avtomobil") {

                    $results = DB::select(
                        "SELECT
                        text AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        mileage,
                        text,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON 
                        (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=2 ORDER BY price ASC LIMIT 0,".$this->records_limit                    
                    );

                    break;
                }

                // Мототехника
                if ($subcat=="mototehnika") {                                        
                    $results = DB::select(
                        "SELECT
                        text AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        mileage,
                        text,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON 
                        (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=3 ORDER BY price ASC LIMIT 0,".$this->records_limit                    
                    );
                    break;
                }                

                // Спецтехника
                if ($subcat=="spectehnika") {                    
                    $results = DB::select(
                        "SELECT
                        text AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        mileage,
                        text,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON 
                        (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=4 ORDER BY price ASC LIMIT 0,".$this->records_limit                    
                    );
                    break;
                }   

                // Ретроавтомобиль
                if ($subcat=="retro-avtomobil") {                     
                    $results = DB::select(
                        "SELECT
                        text AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        mileage,
                        text,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON 
                        (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=5 ORDER BY price ASC LIMIT 0,".$this->records_limit                    
                    );
                    break;
                }                               

                // Водный транспорт
                if ($subcat=="vodnyy-transport") {                    
                    $results = DB::select(
                        "SELECT
                        text AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        mileage,
                        text,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON 
                        (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=6 ORDER BY price ASC LIMIT 0,".$this->records_limit                    
                    );
                    break;
                }                               

                // Велосипед
                if ($subcat=="velosiped") {                    
                    $results = DB::select(
                        "SELECT
                        text AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        mileage,
                        text,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON 
                        (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=7 ORDER BY price ASC LIMIT 0,".$this->records_limit                    
                    );
                    break;
                }                               

                // Воздушный транспорт
                if ($subcat=="vozdushnyy-transport") {                    
                    $results = DB::select(
                        "SELECT
                        text AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        mileage,
                        text,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON 
                        (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=8 ORDER BY price ASC LIMIT 0,".$this->records_limit                    
                    );
                    break;
                }
            }

            /*
            ------------------------------------------------------------

            НЕДВИЖИМОСТЬ

            ------------------------------------------------------------*/

            case "nedvizhimost": {

                // квартира
                // adv_realestate
                // id, property_type, floor, floors_house, rooms, area, ownership, kind_of_object

                if ($subcat=="kvartira") {

                    $results = DB::select
                    (
                        "SELECT
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        text,                        
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id,
                        concat(adv_realestate.rooms, ' комнат ', adv_realestate.floor, ' этаж') AS title
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) ORDER BY price ASC LIMIT 0,".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    break;
                }
            }
        }        


     	return view('results')->with("title", "подкатегории")->with("items", $items)->with("results", json_encode($results))->with("category", $categories);
    }

}