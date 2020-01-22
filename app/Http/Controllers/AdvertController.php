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
        
        if (Auth::check()) {
	        return view("newad")
                        ->with( "title", "Подать объявление" )
                        ->with( "description", "Подать новое объявление на сайте ".config('app.name'))
                        ->with( "keywords", "новое объявление, объявление, подать, разместить, разместить на сайте")
                        ->with( "categories", Categories::all() )
                        ->with( "regions", Regions::all() )
                        ->with( "dealtypes", DealType::all()->toJson() )
                        ->with( "country", "kz" )
                        ->with( "lang", $request->lang );
                        //->with( "auth", Auth::check() );
                }
                else 
                return redirect('/login');
        }                
     
        // детали объявления
        public function getDetails(Request $request, $id) {

                \Debugbar::info("mykey: ".\Cache::get('mykey'));

                if ( $id < 0 ) 
                        return view("errors/404");
            
                // region_id, city_id
                $advert = Adverts::select( 
                        "id", 
                        "title", 
                        "text", 
                        "price", 
                        "phone", 
                        "coord_lat", 
                        "coord_lon", 
                        DB::raw("kz_region.name AS region_name, kz_city.name AS city_name") )
                        ->join("kz_region", "adverts.region_id" , "=" , "kz_region.region_id" )                
                        ->join("kz_city", "adverts.city_id" , "=" , "kz_city.city_id" )                
                        ->where( "id", $id )
                        ->limit(1)->get();

                \Debugbar::info("advert count: ".count($advert));

                if (count($advert)==0)
                        return view("errors/404");
                        
                $images = Images::select(DB::raw( "concat('".$this->getImagePath()."', name) AS name" ))->where("advert_id", $id)->where("type", 1)->get();

                \Debugbar::info($advert);
                \Debugbar::info($images);
        
                return view("details")
                ->with( "title", "Подать объявление" )
                ->with( "description", "Подать новое объявление на сайте ".config('app.name'))
                ->with( "keywords", "новое объявление, объявление, подать, разместить, разместить на сайте")                
                ->with( "advert", $advert[0])
                ->with( "images", $images);
        }    
    
}