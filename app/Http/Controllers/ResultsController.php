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

    	// получаю имя на русском
    	$record = Categories::select('id', 'name')->where('url',  $request->path() )->first();
    	// получаю объявления
    	$items 	= Adverts::where('category_id',  $record->id )->get();

		// передаю во вьюху
     	return view('results')->with("items", $items)->with("title", $record->name." в Казахстане");
    }

    // ---------------------------------------------------
	// результаты по всему региону
	// ---------------------------------------------------
    public function getResultsByRegion($_region, $_category) {

    	// получаю имена на русском
    	$region 	= Regions::select('name')->where('url',  $_region )->first();
    	$category 	= Categories::select('id', 'name')->where('url',  $_category )->first();
    	
    	// получаю объявления
    	$items 	= Adverts::where('category_id',  $region->id)->get();

    	// передаю во вьюху
		return view('results')->with("items", $items)->with("title", $category->name." в ".$region->name);
    }

	// ---------------------------------------------------
    // результаты по городу, деревне
    // ---------------------------------------------------
    public function getResultsByPlace($_region, $place, $_category) {

    	// получаю имя на русском
    	//$record = Categories::select('id', 'name')->where('url',  $request->path() )->get();

    	// получаю объявления
    	$items 	= Adverts::where('category_id',  0)->get();

		return view('results')->with("items", $items)->with("title", " в Казахстане");
    }
}
