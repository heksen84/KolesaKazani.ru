<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Adverts;
use App\SubCats;
use App\Categories;

class SubCatsController extends Controller
{

    public function getResultsByCategory(Request $request, $category, $subcat) {

        // получаю имя на русском
		$categories = SubCats::select('id', 'name')->where('url',  $subcat )->first();
        $items = Adverts::where('category_id',  $categories->id )->get();
        
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
                        ) WHERE adv_category_id=1 ORDER BY price ASC LIMIT 0,1000"
                    );

                    break;
                }
                                
                // Грузовой транспорт
                if ($subcat=="gruzovoy-avtomobil") {

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
                        ) WHERE adv_category_id=2 ORDER BY price ASC LIMIT 0,1000"
                    );

                    break;
                }

                // Мототехника
                if ($subcat=="mototehnika") {
                    
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
                        ) WHERE adv_category_id=3 ORDER BY price ASC LIMIT 0,1000"
                    );

                    break;
                }                

                // Спецтехника
                if ($subcat=="spectehnika") {
                    
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
                        ) WHERE adv_category_id=4 ORDER BY price ASC LIMIT 0,1000"
                    );

                    break;
                }   

                // Ретроавтомобиль
                if ($subcat=="retro-avtomobil") { 
                    
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
                        ) WHERE adv_category_id=5 ORDER BY price ASC LIMIT 0,1000"
                    );

                    break;
                }                               

                // Водный транспорт
                if ($subcat=="vodnyy-transport") {
                    
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
                        ) WHERE adv_category_id=6 ORDER BY price ASC LIMIT 0,1000"
                    );

                    break;
                }                               

                // Велосипед
                if ($subcat=="velosiped") {
                    
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
                        ) WHERE adv_category_id=7 ORDER BY price ASC LIMIT 0,1000"
                    );

                    break;
                }                               

                // Воздушный транспорт
                if ($subcat=="vozdushnyy-transport") {
                    
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
                        ) WHERE adv_category_id=8 ORDER BY price ASC LIMIT 0,1000"
                    );

                    break;
                }                

            }
        }

     	return view('results')->with("title", "подкатегории")->with("items", $items)->with("results", json_encode($results))->with("category", $categories);
    }

}