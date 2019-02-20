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
    private $start_record  = 0;    
    private $records_limit = 1000; // максимальное число записей при выборке

    public function getResultsByCategory(Request $request, $category, $subcat) {

        // -------------------------
        // получаю имя на русском
        // -------------------------
		$categories = SubCats::select('id', 'name')->where('url',  $subcat )->first();
        $items = Adverts::where('category_id',  $categories->id )->get();
        $title = "";
        
        switch($category) {

            case "transport": {                

                // Легковой транспорт
                if ($subcat=="legkovoy-avtomobil") {
                                    
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
                        ) WHERE adv_transport.type=0 ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Легковой автомобиль";

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
                        ) WHERE adv_transport.type=1 ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Грузовой транспорт";

                    \Debugbar::info($results);

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
                        ) WHERE adv_transport.type=2 ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Мототехника";

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
                        ) WHERE adv_transport.type=3 ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Спецтехника";

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
                        ) WHERE adv_transport.type=4 ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Спецтехника";

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
                        ) WHERE adv_transport.type=5 ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Водный транспорт";

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
                        ) WHERE adv_transport.type=6 ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Велосипед";

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
                        ) WHERE adv_transport.type=7 ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Воздушный транспорт";

                    break;
                }
            }

            /*
            ------------------------------------------------------------

            НЕДВИЖИМОСТЬ

            ------------------------------------------------------------*/

            case "nedvizhimost": {
                
                // adv_realestate
                // id, property_type, floor, floors_house, rooms, area, ownership, kind_of_object

                // квартира
                if ($subcat=="kvartira") {

                    $results = DB::select
                    (
                        "SELECT
                        concat(adv_realestate.rooms, ' комнатная квартира, ', adv_realestate.floor, '/', adv_realestate.floors_house, ' этаж, ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        text,                        
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=0
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Квартира";

                    break;
                }

                // комната
                if ($subcat=="komnata") {

                    $results = DB::select
                    (
                        "SELECT
                        concat('Комната ', adv_realestate.floor, '/', adv_realestate.floors_house, ' этаж, ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        text,                        
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=1
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Комната";

                    break;
                }

                // дом, дача, коттедж
                if ($subcat=="dom-dacha-kottedzh") {

                    $results = DB::select
                    (
                        "SELECT
                        concat(adv_realestate.rooms, ' комнат, ', adv_realestate.floors_house, ' этажей, ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        text,                        
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=2
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);
                    
                    
                    $title="Дом, дача, коттедж";
                    
                    break;
                }

                // земельный участок
                if ($subcat=="zemel-nyy-uchastok") {

                    $results = DB::select
                    (
                        "SELECT
                        concat('Земельный участок ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        text,                        
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=3
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    break;
                }
                
                // гараж или машиноместо
                if ($subcat=="garazh-ili-mashinomesto") {

                    $results = DB::select
                    (
                        "SELECT
                        concat('Гараж или машиноместо' ) AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        text,                        
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=4
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    break;
                }

                // коммерческая недвижимость
                if ($subcat=="kommercheskaya-nedvizhimost") {

                    $results = DB::select
                    (
                        "SELECT
                        concat('Недвижимость ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        text,                        
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=5
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    break;
                }
                
                // недвижимость за рубежом
                if ($subcat=="nedvizhimost-za-rubezhom") {

                    $results = DB::select
                    (
                        "SELECT
                        concat('Недвижимость ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        text,                        
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=6
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    break;
                }                                
            }
        }        


     	return view('results')->with("title", $title." в Казахстане")->with("items", $items)->with("results", json_encode($results))->with("category", $categories);
    }

}