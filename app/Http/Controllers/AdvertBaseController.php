<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Categories;
use App\Regions;
use App\DealType;

class AdvertBaseController extends Controller {        

	// -----------------------------------------------------
        // общая метод для всех размещений
	// -----------------------------------------------------
        public function new_advert_common($title, $request) {

	  $title = $title." на сайте ".config('app.name');

          return view("newad")
          ->with( "title", $title )
          ->with( "description", $title)
          ->with( "keywords", "новое объявление, объявление, подать, разместить, разместить на сайте, казахстан")
          ->with( "categories", Categories::all() )
          ->with( "regions", Regions::all() )
          ->with( "dealtypes", DealType::all()->toJson() )
          ->with( "country", "kz" )
          ->with( "lang", $request->lang );        
        }

        // ----------------------------------------------
	// Получить имя местоположения по чпу
 	// ----------------------------------------------
	private function getPlaceNameByUrl($placeUrl) {

                // Делаю выборку и сходу заменяю слово беслатно на пробел
                $place = Places::select("name")->where("url", str_replace("besplatno-", "", $placeUrl))->get();
       
                if (!count($place))
                   abort(404);          
       
                return $place[0]->name;
        }
}