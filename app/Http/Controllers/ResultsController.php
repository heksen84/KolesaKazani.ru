<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Transport;
use App\Adverts;
use App\Categories;
use App\Regions;
use App\Places;
use App\Images;


class ResultsController extends Controller {

	// ---------------------------------------------------
    // результаты по всей стране
    // ---------------------------------------------------
    public function getResultsByCategory(Request $request) {

		//\Debugbar::info($request);

    	// получаю имя на русском
		$category = Categories::select('id', 'name')->where('url',  $request->path() )->first();
		$items = Adverts::where('category_id',  $category->id )->get();
		$results = [];
		$title = "";

		// --------------------------------------------------------
		// Беру данные по конкретной категории
		// --------------------------------------------------------
		switch($category->id) {

			// Вся автотранспорт Казахстана (damelya.kz/transport)
			case 1: {

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
					INNER JOIN (adv_transport, car_mark, car_model) ON (
						adv_transport.mark=car_mark.id_car_mark AND 
						adv.adv_category_id=adv_transport.id AND 
						adv_transport.model = car_model.id_car_model
					) ORDER BY price ASC LIMIT 0,1000"
				);

				$title = "Объявления о покупке, продаже, обмене или сдаче ".mb_strtolower($category->name);

				break;
			}
			
			// Вся недвижимость Казахстана (damelya.kz/nedvizhimost)
			case 2: {

				$results = DB::select
                    (				
						"SELECT
						concat(adv_realestate.rooms, ' комнатная квартира, ', adv_realestate.floor, '/', adv_realestate.floors_house, ' этаж, ', adv_realestate.area, ' кв. м.' ) AS title,
                        adv.id as advert_id, 
                        adv.price,
                        adv.category_id,
                        text,                        
                        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                        adv_realestate.id,                        
                        FROM `adverts` as adv
                        INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) ORDER BY price ASC LIMIT 0,".$this->records_limit                    
                    );

                    \Debugbar::info($results);

                    $title = "Объявления о покупке, продаже, обмене или сдаче ".mb_strtolower($category->name);
			}
			
			// Всё остальное
			default: {

				if ($category->id==3) $title = "Объявления о покупке, продаже, обмене или сдаче ".mb_strtolower($category->name);
				if ($category->id==4) $title = "Предложения о ".mb_strtolower($category->name);
				if ($category->id==5) $title = "Всё ".mb_strtolower($category->name);
				if ($category->id==6) $title = "Объявления о покупке, продаже, обмене или сдаче ".mb_strtolower($category->name);
				if ($category->id==7) $title = "Объявления о покупке, продаже, обмене или сдаче ".mb_strtolower($category->name);
				if ($category->id==8) $title = "Всё для ".mb_strtolower($category->name);
				if ($category->id==9) $title = "Услуги ".mb_strtolower($category->name);
				if ($category->id==10) $title = "Различные предложения ".mb_strtolower($category->name);

				$results = DB::select
				(
					"SELECT 
					id as advert_id, 
					text as title, 
					price, 
					category_id,					
					(SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image
					FROM `adverts` AS adv WHERE category_id=".$category->id." ORDER BY price ASC LIMIT 0,1000"
				);

				\Debugbar::info($results);
			}
		}
		
		// передаю во вьюху
     	return view('results')->with("title", $title." в Казахстане")->with("items", $items)->with("results", json_encode($results))->with("category", $category->id);
    }

    // ---------------------------------------------------
	// результаты по всему региону
	// ---------------------------------------------------
    public function getResultsByRegion($_region, $_category) {

    	// получаю имена на русском
    	$region = Regions::select('name')->where('url',  $_region )->first();
    	//$category = Categories::select('id', 'name')->where('url',  $_category )->first();
    	// получаю объявления
    	$items = Adverts::where('category_id',  0)->get();
		//$images = Images::where('advert_id',  $record->id )->get();
        // !!!! НЕТ РЕГИОНА !!! зависит от локации

    	// передаю во вьюху
		//return view('results')->with("items", $items)->with("title", $_category->name." в ".$_region->name)->with("images", "123");
		return;
    }

	// ---------------------------------------------------
    // результаты по городу, деревне
    // ---------------------------------------------------
    public function getResultsByPlace($_region, $place, $_category) {

    	// получаю имена на русском
    	$region = Regions::select('name')->where('url',  $_region )->first();
    	$category = Categories::select('id', 'name')->where('url',  $_category )->first();
    	
    	// получаю объявления
    	$items = Adverts::where('category_id',  $region->id)->get();

    	// передаю во вьюху
		return view('results')->with("items", $items)->with("title", $category->name." в ".$region->name)->with("images", "123");
    }
}
