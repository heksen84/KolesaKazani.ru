<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Categories;
use App\Regions;
use App\Places;


class WelcomeController extends Controller {

		public function getRegions(Request $request) 
		{
			return Regions::all();
		}

		public function getPlaces(Request $request) 
		{

			return Places::all();
			//return DB::table('categories')->where('id', $id)->get();
		}

        public function getCategories(Request $request) 
        {
        	return view('welcome')->with("items", Categories::all())->with("count", Categories::count())->with("auth", Auth::user()?1:0);
    	}
}
