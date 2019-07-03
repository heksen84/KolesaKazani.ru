<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\File;

use App\Categories;
use App\Regions;
use App\Places;
use App\SubCats;

class IndexController extends Controller {
		
	/*
	--------------------------------------------------
		Получить категории
	--------------------------------------------------*/
    public function showIndexPage(Request $request) {						
		
		\Debugbar::info(public_path());											

		return view("index")
		->with("categories", Categories::all())
		->with("subcategories", SubCats::All())
		->with("regions", Regions::all())
		->with("auth", Auth::user()?1:0);
	}		
	
	/*
	---------------------------------------------
		Города, сёла, деревни
	---------------------------------------------*/
	public function getPlaces(Request $request) {
		return Places::where('region_id',  $request->region_id )->orderBy('name', 'asc')->get();
	}				
}