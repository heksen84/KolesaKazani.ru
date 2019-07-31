<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\File;
use DB;

use App\Categories;
use App\Regions;
use App\Places;
use App\SubCats;

class IndexController extends Controller {
		
	/*
	--------------------------------------------------
	 Получить категории с подкатегориями
	--------------------------------------------------*/
    public function showIndexPage(Request $request) {
		
		$subcats = DB::table("subcats")
		->join('categories', 'categories.id', '=', 'subcats.category_id')
            	->select('subcats.*', 'categories.url as category_url')
		->get();

		return view("index")->with("categories", Categories::all())->with("subcategories", json_decode($subcats, true))->with("regions", Regions::all())->with("auth", Auth::user()?1:0);
	}		
	
	/*
	---------------------------------------------
	 Получить расположение
	---------------------------------------------*/
	public function getPlaces(Request $request) {
		return Places::where('region_id',  $request->region_id )->orderBy('name', 'asc')->get();
	}				
}