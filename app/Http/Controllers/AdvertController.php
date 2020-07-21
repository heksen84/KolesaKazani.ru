<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\Common;
use App\Categories;
use App\AdExtend;
use App\adex_color;
use App\adex_srochno;
use App\adex_top;
use App\Regions;
use App\DealType;
use App\Adverts;
use App\Images;
use Carbon\Carbon;

class AdvertController extends Controller {
                
        // новое объявление
        public function newAdvert(Request $request) {

                \Debugbar::info("Язык: ".$request->lang); 
        
                if (Auth::check()) {
	                return view("newad")
                        ->with( "title", "Подать объявление бесплатно" )
                        ->with( "description", "Подать объявление бесплатно в Казахстане на сайте ".config('app.name'))
                        ->with( "keywords", "новое объявление, объявление, подать, разместить, разместить на сайте, казахстан")
                        ->with( "categories", Categories::all() )
                        ->with( "regions", Regions::all() )
                        ->with( "dealtypes", DealType::all()->toJson() )
                        ->with( "country", "kz" )
                        ->with( "lang", $request->lang );                        
                }
                else 
                        return redirect('/login');
        }              

        // удалить объявление
        public function deleteAdvert($id) {

                // ПРИ УДАЛЕНИИ ПРОВЕРЯТЬ USER_ID с текущим      
                $user_id = Auth::id();
                \Debugbar::info("user_id ".$user_id);

                $advertRequest = Adverts::select( "category_id", "subcategory_id", "inner_id")->where( "id", $id )->where("user_id", $user_id)->limit(1);                

                $adverts = $advertRequest->get();
                \Debugbar::info($adverts);

                if (count($adverts)==0) {
                        \Debugbar::info("нет прав на удаление");
                        return response()->json([ "result" => "error", "msg" => "Access denied for this operation" ]);  
                }
                                
                // ---- Удаляю картинки объявления ----
                $imagesRequest = Images::select(DB::raw("name"))->where("advert_id", $id);                
                $images = $imagesRequest->get(); // получаю массив

                if (count($images)>0) {
                        
                        foreach($images as $image) {
                                \Debugbar::info($image->name);
                                
                                $small_image = Common::getImagesPath()."/small/".$image->name;                        
                                if (file_exists($small_image))
                                        unlink($small_image);                                

                                $normal_image = Common::getImagesPath()."/normal/".$image->name;                        
                                if (file_exists($normal_image))
                                        unlink($normal_image);
                        }
                        
                        $imagesRequest->delete();
                }                                

            return response()->json([ "result" => "deleted", "msg" => "объявление удалено" ]);  
        }

        // -----------------------------------------------------------
        // сделать vip, покрасить, срочно, и т.п.
        // -----------------------------------------------------------
        public function makeExtend($advert_id, $adv_type) {                                

                switch($adv_type) {

                        // В топ
                        case "makeVip": {                        
                                break;
                        }
                        
                        // продление
                        case "prodlit": {                                
                                $plusDate = Carbon::now()->add(30, 'day')->toDateTimeString();
                                Adverts::where("id", '=', $advert_id)->update(['startDate'=>Carbon::now()->toDateTimeString(), 'finishDate' => $plusDate]); // обновляю finishDate в adverts
                                break;
                        }                        

                        case "srochno_torg": {
                       
                                $plusDate = Carbon::now()->add(7, 'day')->toDateTimeString();
                                $adex = adex_srochno::select("id")->where("advert_id", "=", $advert_id)->get();
                                \Debugbar::info("count: ".$adex->count());

                                if ($adex->count()>0) {
                                        
                                        \Debugbar::info("обновляю...");                                       
                                        adex_srochno::where("advert_id", '=', $advert_id)->update(['startDate'=>Carbon::now()->toDateTimeString(), 'finishDate' => $plusDate]);
                                        Adverts::where("id", '=', $advert_id)->update(['startDate'=>Carbon::now()->toDateTimeString(), 'finishDate' => $plusDate]); // обновляю finishDate в adverts
                                }
                                else {                                      
                                        
                                        \Debugbar::info("создаю запись...");                                        
                                        $adex = new adex_srochno();
                                        $adex->advert_id = $advert_id;                                        
                                        $adex->startDate = Carbon::now()->toDateTimeString();
                                        $adex->finishDate = $plusDate;
                                        $adex->save();

                                        // обновляю finishDate в adverts
                                        Adverts::where("id", '=', $advert_id)->update(['startDate'=>Carbon::now()->toDateTimeString(),'finishDate' => $plusDate]);
                                }
                                break;
                        }

                        case "makePaint": {
                                
                                $plusDate = Carbon::now()->add(7, 'day')->toDateTimeString();                  
                                $adex = adex_color::select("id")->where("advert_id", "=", $advert_id)->get();
                                \Debugbar::info("count: ".$adex->count());

                                if ($adex->count()>0) {
                                        \Debugbar::info("обновляю...");                                        
                                        adex_color::where("advert_id", '=', $advert_id)->update(['startDate'=>Carbon::now()->toDateTimeString(), 'finishDate' => $plusDate]);
                                        Adverts::where("id", '=', $advert_id)->update(['startDate'=>Carbon::now()->toDateTimeString(), 'finishDate' => $plusDate]); // обновляю finishDate в adverts
                                }
                                else {                                      
                                        
                                        \Debugbar::info("создаю запись...");
                                        $adex = new adex_color();
                                        $adex->advert_id = $advert_id;                                        
                                        $adex->startDate = Carbon::now()->toDateTimeString();
                                        $adex->finishDate = $plusDate;
                                        $adex->save();

                                        // обновляю finishDate в adverts
                                        Adverts::where("id", '=', $advert_id)->update(['startDate'=>Carbon::now()->toDateTimeString(), 'finishDate' => $plusDate]);
                                }                        
                                break;
                        }
                }

                \Debugbar::info($adv_type);
                                
                return response()->json([ "result" => "success", "msg" => "готово" ]);  
        }           
}