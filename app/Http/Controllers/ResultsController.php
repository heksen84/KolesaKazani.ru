<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Adverts;
use App\Categories;
use App\Regions;

class ResultsController extends Controller {

	// ---------------------------------------------------
    // результаты по всей стране
    // ---------------------------------------------------
    public function getResultsByCategory(Request $request) {

    	// получаю имя на русском
    	$record = Categories::select('id', 'name')->where('url',  $request->path() )->get();

    	// получаю объявления
    	$items 	= Adverts::where('category_id',  $record[0]->id )->get();

     	return view('results')->with("items", $items)->with("title", $record[0]->name." в Казахстане");
    }

    // ---------------------------------------------------
	// результаты по всему региону
	// ---------------------------------------------------
    public function getResultsByRegion($_region, $_transport) {

    	// получаю имя на русском
    	$category 	= Categories::select('id', 'name')->where('url',  $_transport )->first();
    	$region 	= Regions::select('name')->where('url',  $_region )->first();

    	// получаю объявления
    	$items 	= Adverts::where('category_id',  $region->id)->get();

    	// отобразить
		return view('results')->with("items", $items)->with("title", $category->name." в ".$region->name);

    }

	// ---------------------------------------------------
    // результаты по городу, деревне
    // ---------------------------------------------------
    public function getResultsByPlace(Request $request) {

    	// получаю имя на русском
    	//$record = Categories::select('id', 'name')->where('url',  $request->path() )->get();

    	// получаю объявления
    	$items 	= Adverts::where('category_id',  0)->get();

		return view('results')->with("items", $items)->with("title", " в Казахстане");
    }
}
