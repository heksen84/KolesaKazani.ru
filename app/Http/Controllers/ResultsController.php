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
use App\Images;


class ResultsController extends Controller {

	// ---------------------------------------------------
    // результаты по всей стране
    // ---------------------------------------------------
    public function getResultsByCategory(Request $request) {

		// ---------------------------------------------------------------------------
		// 1. Нужно определить категорию объявления
		// 2. Вернуть название категории например: Audi 100, 1999г. 1000000 тенге.
		// ---------------------------------------------------------------------------

    	// получаю имя на русском
		$record = Categories::select('id', 'name')->where('url',  $request->path() )->first();

		// получаю объявления
		$items = Adverts::where('category_id',  $record->id )->get();


		/*		
		switch(category_id)  //
		{
			
			case 0: Выдернуть данные из таблицы 1
			case 1: Выдернуть данные из таблицы 2
			case 2: Выдернуть данные из таблицы 3

		}
		*/

		// получаю картинки
		//$images = Images::where('advert_id',  $record->id )->get();
		$images = Images::all();
		
		// передаю во вьюху
     	return view('results')->with("title", $record->name." в Казахстане")->with("items", $items)->with("images", $images);
    }

    // ---------------------------------------------------
	// результаты по всему региону
	// ---------------------------------------------------
    public function getResultsByRegion($_region, $_category) {

    	// получаю имена на русском
    	$region = Regions::select('name')->where('url',  $_region )->first();
    	$category = Categories::select('id', 'name')->where('url',  $_category )->first();
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
    	$region    = Regions::select('name')->where('url',  $_region )->first();
    	$category  = Categories::select('id', 'name')->where('url',  $_category )->first();
    	
    	// получаю объявления
    	$items = Adverts::where('category_id',  $region->id)->get();

    	// передаю во вьюху
		return view('results')->with("items", $items)->with("title", $category->name." в ".$region->name)->with("images", "123");
    }
}
