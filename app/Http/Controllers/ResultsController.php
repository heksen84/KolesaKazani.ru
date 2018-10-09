<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Adverts;
use App\Categories;
use App\Regions;
use App\Places;


class ResultsController extends Controller {

	// ---------------------------------------------------
    // результаты по всей стране
    // ---------------------------------------------------
    public function getResultsByCategory(Request $request) {

		/*
			$redis = Redis::connection();

			try {								

				$redis->ping();
				$results = $redis->get("results");

				if (!$results) {
					$redis->set("results", Categories::all()); 
					$results = $redis->get("results");
				}
			}
			catch(\Exception $e) {
				\Debugbar::warning($e->getMessage());
				$results = Categories::all();
			}
		*/

    	// получаю имя на русском
    	$record = Categories::select('id', 'name')->where('url',  $request->path() )->first();

    	// получаю объявления
    	$items = Adverts::where('category_id',  $record->id )->get();

		// передаю во вьюху
     	return view('results')->with("items", $items)->with("title", $record->name." в Казахстане");
    }

    // ---------------------------------------------------
	// результаты по всему региону
	// ---------------------------------------------------
    public function getResultsByRegion($_region, $_category) {

    	// получаю имена на русском
    	$region    = Regions::select('name')->where('url',  $_region )->first();

    	$category  = Categories::select('id', 'name')->where('url',  $_category )->first();
    	
    	// получаю объявления
    	$items = Adverts::where('category_id',  0)->get();


        // !!!! НЕТ РЕГИОНА !!! зависит от локации

    	// передаю во вьюху
		return view('results')->with("items", $items)->with("title", $_category->name." в ".$_region->name);
    }

	// ---------------------------------------------------
    // результаты по городу, деревне
    // ---------------------------------------------------
    public function getResultsByPlace($_region, $place, $_category) {

    	// получаю имена на русском
    	$region    = Regions::select('name')->where('url',  $_region )->first();
    	$category  = Categories::select('id', 'name')->where('url',  $_category )->first();
    	
    	// получаю объявления
    	$items = Adverts::where('category_id',  $region->id)->get();

    	// передаю во вьюху
		return view('results')->with("items", $items)->with("title", $category->name." в ".$region->name);
    }
}
