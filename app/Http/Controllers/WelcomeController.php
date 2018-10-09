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

		/*
		---------------------------------------------
		Регионы
		---------------------------------------------*/

		public function getRegions(Request $request) {

			$redis = Redis::connection();
			$query = Regions::orderBy('name', 'asc')->get();

			try {								
				$redis->ping();
				$regions = $redis->get("regions");
				if (!$regions) {
					$redis->set("regions", $query);
					$regions = $redis->get("regions");
				}
			}
			catch(\Exception $e) {
				\Debugbar::warning($e->getMessage());
				$regions = $query;
			}

			return $regions;
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
			$query = Categories::all();

			try {								
				$redis->ping();	// проверяю включен-ли redis
				$categories = $redis->get("categories"); // получаю массив категорий
				if (!$categories) { // если массив пуст,
					$redis->set("categories", $query); // .. делаю выборку в новую переменную
					$categories = $redis->get("categories"); // получаю данные из редиса
				}
			}
			catch(\Exception $e) {
				\Debugbar::warning($e->getMessage());
				$categories = $query;
			}
					
        	return view('welcome')->with("items", $categories)->with("count", Categories::count())->with("auth", Auth::user()?1:0);
    	}
}
