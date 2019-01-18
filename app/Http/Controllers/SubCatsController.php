<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCats;
use App\Categories;

class SubCatsController extends Controller
{
    public function getSubCats(Request $request) {

/*
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
            ) ORDER BY price ASC LIMIT 0,1000"
        );
*/

       // $results = DB::select("SELECT concat(categories.url,'/',subcats.url) as url FROM categories INNER JOIN subcats ON (subcats.category_id=categories.id)");


        return /*SubCats::all()->toJson();*/ $results;
    }
}
