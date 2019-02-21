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
	
	// частные переменные
	private $start_record  = 0;
	private $records_limit = 1000; // максимальное число записей при выборке
	private $order_fileds  = [];   // поля сортировки

	// ---------------------------------------------------
    // результаты по всей стране
    // ---------------------------------------------------
    public function getResultsByCategory(Request $request) {

    	// получаю имя на русском
		$category = Categories::select("id", "name")->where("url",  $request->path() )->first();
		$items = Adverts::where("category_id",  $category->id )->get();
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
					adv.deal,					
					(SELECT CASE adv_transport.type 
					WHEN 0 THEN concat(car_mark.name, ' ', car_model.name, ' ', year, ' г.')						
					ELSE adv.text
					END FROM adv_transport 
					WHERE adv_transport.id IN (SELECT adv.adv_category_id FROM adverts)) AS title, 
					adv.id as advert_id, 
					adv.price,
					adv.category_id,
					mileage,
					text,
					(SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image 
					FROM `adverts` as adv
					LEFT OUTER JOIN (adv_transport, car_mark, car_model) ON (
					adv.adv_category_id = adv_transport.id AND 
					adv_transport.mark = car_mark.id_car_mark AND 						
					adv_transport.model = car_model.id_car_model
					) WHERE adv.category_id=1 
					ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit
				);

				\Debugbar::info($results);

				$title = "Объявления о покупке, продаже, обмене или сдаче транспорта в аренду в Казахстане";
				break;				                          				
			}
			
			// Вся недвижимость Казахстана (damelya.kz/nedvizhimost)
			case 2: {

				$results = DB::select(					
					"SELECT
					adv.deal,
					concat(adv_realestate.rooms, ' комнатную квартиру, ', adv_realestate.floor, '/', adv_realestate.floors_house, ' этаже, ', adv_realestate.area, ' кв. м.' ) AS title,
                    adv.id as advert_id, 
                    adv.price,
                    adv.category_id,
                    text,                        
                    (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image,
                    adv_realestate.id
                    FROM `adverts` as adv
                    INNER JOIN (adv_realestate) ON ( adv.adv_category_id=adv_realestate.id ) 
					WHERE adv.category_id=2 
					ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit
                );

                    \Debugbar::info($results);

					// seo title
					$title = "Объявления о покупке, продаже, обмене или сдаче недвижимости в аренду в Казахстане";
					break;
			}
			
			// Всё остальное
			default: {

				/* --------------------------------
				    Заголовки title для SEO
				   --------------------------------*/

				// электроника
				if ($category->id==3) $title = "Объявления о покупке, продаже, обмене или сдаче электроники В Казахстане";
				// работа и бизнес
				if ($category->id==4) $title = "Обяъвления о работе и бизнесе в Казахстане";
				// для дома и дачи
				if ($category->id==5) $title = "Объявления категории для дома и дачи в Казахстанe";
				// личные вещи
				if ($category->id==6) $title = "Объявления о покупке, продаже, обмене или сдаче";
				// животные
				if ($category->id==7) $title = "Объявления о покупке, продаже, обмене или сдаче";
				// хобби и отдых
				if ($category->id==8) $title = "Объявления категории хобби и отдых в Казахстанe";
				// услуги
				if ($category->id==9) $title = "Объявления категории услуги в Казахстанe";
				// другое
				if ($category->id==10) $title = "Различные предложения в Казахстане";

				// общий select
				$results = DB::select(					
					"SELECT
					adv.deal, 
					id as advert_id, 
					text as title, 
					price, 
					category_id,					
					(SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image
					FROM `adverts` AS adv WHERE category_id=".$category->id." ORDER BY price ASC LIMIT ".$this->start_record.",".$this->records_limit
				);

				\Debugbar::info($results);
			}
		}
		
		 // --------------------------------------
		 // передаю во вьюху
		 // --------------------------------------
		 return view("results")
		 ->with("title", $title)
		 ->with("items", $items)
		 ->with("results", json_encode($results))
		 ->with("category", $category->id)
		 ->with("start_record", $this->start_record);
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
		
		// получаю имя и id на русском
    	$category = Categories::select('id', 'name')->where('url',  $_category )->first();
    	
    	// получаю объявления
    	$items = Adverts::where('category_id',  $region->id)->get();

    	// передаю во вьюху
		return view('results')->with("items", $items)->with("title", $category->name." в ".$region->name)->with("images", "123");
    }
}
