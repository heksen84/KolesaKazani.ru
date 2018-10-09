<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

use App\Categories;
use App\Regions;
use App\Places;


class WelcomeController extends Controller {

		public function getCategoryCountById(Request $request) {
			return 0;
		}

		public function getCategoryCounts(Request $request) {
			return 0;
		}

		public function getRegions(Request $request) {
			return Regions::orderBy('name', 'asc')->get();
		}

		public function getPlaces(Request $request) {
			return Places::where('region_id',  $request->region_id )->orderBy('name', 'asc')->get();
		}
		
		/*
		-------------------------------------
		 получить категории
		-------------------------------------*/

        public function getCategories(Request $request) {
						
			$redis = Redis::connection();

			try {								

				$redis->ping();	// проверяю включен-ли redis
				$categories = $redis->get("categories"); // получаю массив категорий

				if (!$categories) // если массив пуст,
					$redis->set("categories", Categories::all()); // .. делаю выборку в новую переменную
					
			}
			catch(\Exception $e) {
				\Debugbar::error($e->getMessage());
				$categories = Categories::all();
			}
					
        	return view('welcome')->with("items", $categories)->with("count", Categories::count())->with("auth", Auth::user()?1:0);
    	}
}
