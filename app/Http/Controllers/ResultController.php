<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Adverts;
use App\Categories;

class ResultController extends Controller {

    public function getResultsByCategory(Request $request) {

    	// получаю имя на русском
    	$record = Categories::select('name')->where('url',  $request->path() )->get();

    	// получаю объявления
    	$items 	= Adverts::all()->toJson();

     	return view('results')->with("items", $items)->with("category_name", $record[0]->name." в Казахстане");
    }
}
