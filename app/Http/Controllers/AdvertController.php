<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Categories;
use App\Regions;
use App\DealType;
use App\Adverts;
use App\Images;


class AdvertController extends Controller {      
        
        // получить хранилище изображений
        private function getImagePath() {      
                return \Storage::disk('local')->url('app/images/preview/');
        }
    
        // новое объявление
        public function NewAd(Request $request) {

        \Debugbar::info("Язык: ".$request->lang);        

	return view("newad")
        ->with( "title", "Подать объявление" )
        ->with( "description", "Подать новое объявление на сайте ".config('app.name'))
        ->with( "keywords", "новое объявление, объявление, подать, разместить, разместить на сайте")
        ->with( "categories", Categories::all() )
        ->with( "regions", Regions::all() )
        ->with( "dealtypes", DealType::all()->toJson() )
        ->with( "country", "kz" )
        ->with( "lang", $request->lang )
        ->with( "auth", Auth::check() );
        
        }                
     
        // детали объявления
        public function getDetails(Request $request, $id) {

                $advert = Adverts::select("id","title","text","price")->where("id", $id)->limit(1)->get();                                
                $images = Images::select(DB::raw( "concat('".$this->getImagePath()."', name) AS name" ))->where("advert_id", $id)->get();

                \Debugbar::info($advert);
        
                return view("details")
                ->with( "title", "Подать объявление" )
                ->with( "description", "Подать новое объявление на сайте ".config('app.name'))
                ->with( "keywords", "новое объявление, объявление, подать, разместить, разместить на сайте")                
                ->with( "advert", $advert[0])
                ->with( "images", $images);

        }    
    
}