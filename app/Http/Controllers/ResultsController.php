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

		// получаю объявления
		$sub_ids = Adverts::select("adv_category_id")->where('category_id',  $category->id )->pluck("adv_category_id")->all();
		$items 	 = Adverts::where('category_id',  $category->id )->get();

		\Debugbar::info($items);

		$craz = null;

		// --------------------------------------------------------
		// Выдергиваю данные по конкретной категории
		// --------------------------------------------------------
		switch($category->id) {
			
			// транспорт
			case 1: {

				/*
				SELECT DISTINCT text,price,car_mark.name FROM `adverts` JOIN 
				(adv_transport, car_mark, car_model) ON (car_mark.id_car_mark=adv_transport.mark)
				*/

				$craz = DB::table('adv_transport')
				->join('car_type', 'type', '=', 'id_car_type')
				->join('car_mark', 'mark', '=', 'id_car_mark')
				->select('car_type.name', 'car_mark.name', 'car_mark.name_rus')
				->whereIn('id', $sub_ids)
				->get();

				\Debugbar::info("Вот оно что:".$craz);

				/*
				-----------------------------------
				 На выходе:
				-----------------------
я				 Ауди 100, 1999г
				 Павлодар
				 Цена

				 SELECT * FROM adverts INNER JOIN adv_transport ON adverts_sub_id = transport_id INNER JOIN car_type ... INNER JOIN car_mark
				-----------------------------------*/

				break;
			}
		}

		// получаю картинки
		$images = Images::all();
		
		// передаю во вьюху
     	return view('results')->with("title", $category->name." в Казахстане")->with("items", $items)->with("images", $images)->with("craz", $craz);
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
