<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

use App\Categories;
use App\Regions;
use App\Places;
use App\SubCats;


class IndexController extends Controller {

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

			try {								
					$redis->ping();
					$regions = $redis->get("regions");
					if (!$regions) {
						$redis->set("regions", Regions::orderBy('name', 'asc')->get());
						$regions = $redis->get("regions");
					}
			}
			catch(\Exception $e) {
					\Debugbar::warning($e->getMessage());
					$regions = Regions::orderBy('name', 'asc')->get()->toJson();
			}

			return $regions;
		}

		/*
		---------------------------------------------
		Города, сёла, деревни
		---------------------------------------------*/
		public function getPlaces(Request $request) {
			return Places::where('region_id',  $request->region_id )->orderBy('name', 'asc')->get();
		}
		
		/*
		-------------------------------------
		 Получить категории
		-------------------------------------*/
        public function getCategories(Request $request) {
						
			$redis = Redis::connection();

			try {								
					$redis->ping();	// проверяю включен-ли redis
					$categories = $redis->get("categories"); // получаю массив категорий
					if (!$categories) { // если массив пуст,
						$redis->set("categories", Categories::all()); // .. делаю выборку в новую переменную
						$categories = $redis->get("categories"); // получаю данные из редиса
					}
			}
			catch(\Exception $e) {
				\Debugbar::warning($e->getMessage());
				$categories = Categories::all();
			}
					
        	return view('index')->with("items", $categories)->with("subcats", SubCats::all()->toJson())->with("count", Categories::count())->with("auth", Auth::user()?1:0);
    	}
}