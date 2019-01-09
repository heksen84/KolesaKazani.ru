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

		\Debugbar::info($request);

		// ---------------------------------------------------------------------------
		// 1. Нужно определить категорию объявления
		// 2. Вернуть название категории например: Audi 100, 1999г. 1000000 тенге.
		// ---------------------------------------------------------------------------

    	// получаю имя на русском
		$category = Categories::select('id', 'name')->where('url',  $request->path() )->first();

		\Debugbar::info("category_id :".$category->id);
		$items = Adverts::where('category_id',  $category->id )->get();

		\Debugbar::info($items);

		// --------------------------------------------------------
		// Выдергиваю данные по конкретной категории
		// --------------------------------------------------------
		switch($category->id) {

			/*
			-------------------------------------------
			*** Должно быть так: ***
			Заголовок (например: audi 100) - title
			Цена (5000) - price			
			-------------------------------------------*/

			// ------------------------------
			// СДЕЛАТЬ ТЭГИ К ОБЪЯВЛЕНИЮ
			// ------------------------------
			
			// id, tag, advert_id
			// 0, audi 100, 5
			// 1, куплю, 	5
			// 2, 190000, 	5
			// 3, авто, 	5
			
			// ------------------------
			// транспорт
			// ------------------------
			case 1: {

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

				break;
			}
			
			// ------------------------
			// недвижимость
			// ------------------------
			/*case 2: {			
				break;
			}

			// ------------------------
			// бытовая техника
			// ------------------------
			case 3: {
				$results = DB::select(
					"SELECT 
					id, 
					text as title, 
					price, 
					category_id,					
					(SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image
					FROM `adverts` AS adv WHERE category_id=".$category->id." ORDER BY price ASC LIMIT 0,1000");
					break;
			}

			// ------------------------
			// работа и бизнес
			// ------------------------
			case 4: {
				$results = DB::select("SELECT * FROM `adverts` WHERE category_id=".$category->id." ORDER BY price ASC LIMIT 0,1000");
				break;
			}

			// ------------------------
			// для дома и дачи
			// ------------------------
			case 5: {
				$results = DB::select("SELECT * FROM `adverts` WHERE category_id=".$category->id." ORDER BY price ASC LIMIT 0,1000");
				break;
			}

			// ------------------------
			// личные вещи
			// ------------------------
			case 6: {
				$results = DB::select("SELECT * FROM `adverts` WHERE category_id=".$category->id." ORDER BY price ASC LIMIT 0,1000");
				break;
			}

			// ------------------------
			// животные
			// ------------------------
			case 7: {
				$results = DB::select("SELECT * FROM `adverts` WHERE category_id=".$category->id." ORDER BY price ASC LIMIT 0,1000");
				break;
			}

			// ------------------------
			// хобби и отдых
			// ------------------------
			case 8: {
				$results = DB::select("SELECT * FROM `adverts` WHERE category_id=".$category->id." ORDER BY price ASC LIMIT 0,1000");
				break;
			}

			// ------------------------
			// услуги
			// ------------------------
			case 9: {
				$results = DB::select("SELECT * FROM `adverts` WHERE category_id=".$category->id." ORDER BY price ASC LIMIT 0,1000");
				break;
			}

			// ------------------------
			// другое
			// ------------------------
			case 10: {
				$results = DB::select("SELECT * FROM `adverts` WHERE category_id=".$category->id." ORDER BY price ASC LIMIT 0,1000");
				break;
			}*/

			default: 
			{
				$results = DB::select
				(
					"SELECT 
					id, 
					text as title, 
					price, 
					category_id,					
					(SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image
					FROM `adverts` AS adv WHERE category_id=".$category->id." ORDER BY price ASC LIMIT 0,1000"
				);
			}
		}
		
		// передаю во вьюху
     	return view('results')->with("title", $category->name." в Казахстане")->with("items", $items)->with("results", json_encode($results));
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
