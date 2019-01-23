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

        \Debugbar::info("!!".$category);
        \Debugbar::info($subcat);


        // получаю имя на русском
		$category_name = SubCats::select('id', 'name')->where('url',  $subcat )->first();
        //$items = Adverts::where('category_id',  $category->id )->get();

        $results = "";
        

        
        
        switch($category) {

            case "transport": {

                \Debugbar::info("hello1");

                if ($subcat=="legkovoy-avtomobil") {

                    \Debugbar::info("hello2");



                    $results = DB::select(
                        "SELECT
                        concat(car_mark.name, ' ', car_model.name, ' ', year, ' г.') AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,  
                        /*year,*/  
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

                    
                    \Debugbar::info($results);

                    break;
                }
                                
                if ($subcat=="gruzovoy-avtomobil") {
                    break;
                }

                if ($subcat=="mototehnika") {                    
                    break;
                }                

                if ($subcat=="spectehnika") {                    
                    break;
                }   

                if ($subcat=="retro-avtomobil") {                    
                    break;
                }                               

                if ($subcat=="vodnyy-transport") {                    
                    break;
                }                               

                if ($subcat=="velosiped") {                    
                    break;
                }                               

                if ($subcat=="velosiped") {                    
                    break;
                }

                if ($subcat=="vozdushnyy-transport") {                    
                    break;
                }                

            }
        }

     	return view('results')->with("title", "подкатегории")->with("items", "items")->with("results", json_encode($results))->with("category", $category_name);
    }

}
