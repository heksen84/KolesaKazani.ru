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

use DB;

class IndexController extends Controller {

		private $lang=null;

		// SSR
		private function render() {

			$renderer_source = File::get(base_path('node_modules/vue-server-renderer/basic.js'));
			$app_source = File::get(public_path('js/index-server.js'));
			$v8 = new \V8Js();
			ob_start();
	 
			$js= 'var process = { env: { VUE_ENV: "server", NODE_ENV: "production" } }; 
							 this.global = { process: process };';
	

			$v8->executeString($js);
			$v8->executeString($renderer_source);

			// рендерим компонент с данными

/*$react[] = sprintf(
  "React.renderComponentToString(Table({data: %s}), print)",
  json_encode($data));*/
			$v8->executeString($app_source);	
			return ob_get_clean();
		}

		/*
		-------------------------------------
		 Получить категории
		-------------------------------------*/
        public function getCategories(Request $request) {
						
			\Debugbar::info(public_path());
												
			$redis = Redis::connection();

			try {

				$redis->ping();	// проверяю включен-ли redis
				$categories = $redis->get("categories"); // получаю массив категорий
				
				if (!$categories) { 
					$redis->set("categories", Categories::all()); // .. делаю выборку в новую переменную
					$categories = $redis->get("categories"); // получаю данные из редиса
				}
			}
			
			catch(\Exception $e) {
				\Debugbar::warning($e->getMessage());
				$categories = Categories::all();
			}

			// подкатегории
			$subcats = DB::table('categories')
            ->join('subcats', 'subcats.category_id', '=', 'categories.id')
            ->select(DB::raw("subcats.id, subcats.name, subcats.category_id, concat(categories.url,'/',subcats.url) as url"))
			->get();
			
			$ssr = $this->render();

			\Debugbar::info($ssr);

			return view('index', ['ssr' => $ssr]);

			//return view("index")->with("ssr", $ssr)->with("items", $categories)->with("subcats", $subcats )->with("count", Categories::count())->with("auth", Auth::user()?1:0);
		}
		
		// ------------------------------------
		// init
		// ------------------------------------
		public function init(Request $request) {		
			/*\Cache::store('database')->flush();
		 	$lang = \Cache::store('database')->forever('lang', 'ru');*/
		 	$lang = \Cache::store("database")->get("lang");
		 	\Debugbar::info($lang);
		 	return $this->getCategories($request);
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
}