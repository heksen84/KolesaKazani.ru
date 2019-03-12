<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Adverts;
use App\SubCats;
use App\Categories;
use App\RealEstate;
use App\Helpers\Petrovich;

class SubCatsController extends Controller
{
    private $start_record  = 0;    
    private $records_limit = 1000; // максимальное число записей при выборке

    public function getResultsByCategory(Request $request, $category, $subcat) {

        $petrovich = new Petrovich(Petrovich::GENDER_MALE);

        // ---------------------------------------------------------------------------
        // получаю имя на русском
        // ---------------------------------------------------------------------------
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
                        adv.deal,
                        adv.full,                                                
                        adv.price,
                        adv.category_id,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport, car_mark, car_model) ON (
                            adv_transport.mark=car_mark.id_car_mark AND 
                            adv.adv_category_id=adv_transport.id AND 
                            adv_transport.model = car_model.id_car_model
                        ) WHERE adv_transport.type=0 AND adv.category_id=1
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Покупка, продажа, обмен, сдача в аренду легковых автомобилей";

                    \Debugbar::info($results);

                    break;
                }
                                
                // Грузовой транспорт
                if ($subcat=="gruzovoy-avtomobil") {
                    

                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id, 
                        adv.deal,
                        adv.full,                                                
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=1 AND adv.category_id=1 
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Покупка, продажа, обмен, сдача в аренду грузового транспорта";

                    \Debugbar::info($results);

                    break;
                }

                // Мототехника
                if ($subcat=="mototehnika") {                                        
                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id,
                        adv.deal,
                        adv.full,                                                
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=2 AND adv.category_id=1
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info("moto");                    
                    \Debugbar::info($results);
                    
                    $title="Покупка, продажа, обмен, сдача в аренду мототехники";

                    break;
                }                

                // Спецтехника
                if ($subcat=="spectehnika") {                    
                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=3 AND adv.category_id=1 
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду спецтехники";

                    break;
                }   

                // Ретроавтомобиль
                if ($subcat=="retro-avtomobil") {                     
                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=4 AND adv.category_id=1 
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Покупка, продажа, обмен, сдача в аренду ретро автомобилей";

                    break;
                }                               

                // Водный транспорт
                if ($subcat=="vodnyy-transport") {                    
                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=5  AND adv.category_id=1 
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Покупка, продажа, обмен, сдача в аренду водного транспорта";

                    break;
                }                               

                // Велосипед
                if ($subcat=="velosiped") {                    
                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id, 
                        adv.deal,
                        adv.full,                                                
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=6  AND adv.category_id=1 
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Покупка, продажа, обмен, сдача в аренду велосипеда";

                    break;
                }                               

                // Воздушный транспорт
                if ($subcat=="vozdushnyy-transport") {                    
                    $results = DB::select(
                        "SELECT
                        adv.id as advert_id,
                        adv.deal,
                        adv.full,                                     
                        adv.price,
                        adv.category_id,
                        text AS title,
                        mileage,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
                        FROM `adverts` as adv
                        INNER JOIN (adv_transport) ON (
                            adv.adv_category_id=adv_transport.id
                        ) WHERE adv_transport.type=7 AND adv.category_id=1
                         ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    $title="Покупка, продажа, обмен, сдача в аренду воздушного транспорта";

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

                    $results = DB::select(
                        "SELECT
                        concat(adv_realestate.rooms, ' комнатную квартиру, ', adv_realestate.floor, '/', adv_realestate.floors_house, ' этаж, ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id, 
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=0 AND adv.category_id=2
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду квартиры";

                    break;
                }

                // комната
                if ($subcat=="komnata") {

                    $results = DB::select(
                        "SELECT
                        concat('Комната ', adv_realestate.floor, '/', adv_realestate.floors_house, ' этаж, ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=1 AND adv.category_id=2
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду комнаты";

                    break;
                }

                // дом, дача, коттедж
                if ($subcat=="dom-dacha-kottedzh") {

                    $results = DB::select(
                        "SELECT
                        concat(adv_realestate.rooms, ' комнат, ', adv_realestate.floors_house, ' этажей, ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,                 
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=2 AND adv.category_id=2
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);
                                        
                    $title="Покупка, продажа, обмен, сдача в аренду дома, дачи, коттеджа";

                    break;
                }

                // земельный участок
                if ($subcat=="zemel-nyy-uchastok") {

                    $results = DB::select(
                        "SELECT
                        concat('Земельный участок ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id,
                        adv.deal,
                        adv.full,                                      
                        adv.price,
                        adv.category_id,
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=3 AND adv.category_id=2
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду земельного участка";

                    break;
                }
                
                // гараж или машиноместо
                if ($subcat=="garazh-ili-mashinomesto") {

                    $results = DB::select(
                        "SELECT
                        concat('Гараж или машиноместо' ) AS title,
                        adv.id as advert_id,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,             
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=4 AND adv.category_id=2
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду гаража или машиноместа";

                    break;
                }

                // коммерческая недвижимость
                if ($subcat=="kommercheskaya-nedvizhimost") {

                    $results = DB::select(
                        "SELECT
                        concat('Недвижимость ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id,
                        adv.deal,
                        adv.full,                         
                        adv.price,
                        adv.category_id,                 
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=5 AND adv.category_id=2
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );
                
                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду коммерческой недвижимости";

                    break;
                }
                
                // недвижимость за рубежом
                if ($subcat=="nedvizhimost-za-rubezhom") {

                    $results = DB::select(
                        "SELECT
                        concat('Недвижимость ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id,
                        adv.deal,
                        adv.full,
                        adv.price,
                        adv.category_id,                   
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
                        WHERE adv_realestate.property_type=6 AND adv.category_id=2
                        ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title="Покупка, продажа, обмен, сдача в аренду недвижимости за рубежом";

                    break;
                }                                
            }
        }        

     	return view('results')->with("title", $title." в Казахстане")->with("items", $items)->with("results", json_encode($results))->with("category", $categories);
    }

}