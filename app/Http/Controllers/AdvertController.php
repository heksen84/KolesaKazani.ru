<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\Common;
use App\Categories;
use App\adex_color;
use App\adex_srochno;
use App\adex_top;
use App\Regions;
use App\DealType;
use App\Adverts;
use App\Images;
use App\Complaints;
use Carbon\Carbon;

class AdvertController extends Controller {
                
        // новое объявление
        public function new_advert(Request $request) {

                \Debugbar::info("Язык: ".$request->lang); 
        
                /*if (Auth::check()) {

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
                return 
                        redirect('/login');*/                        

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


        // подать бесплатно объявление о работе в кз
        public function new_advert_podat_besplatno_obyavlenie_o_rabote_v_kz(Request $request) {                
        
                return view("newad")
                ->with( "title", "подать бесплатно объявление о работе в кз" )
                ->with( "description", "подать бесплатно объявление о работе в кз на сайте ".config('app.name'))
                ->with( "keywords", "новое объявление, объявление, подать, разместить, разместить на сайте, казахстан")
                ->with( "categories", Categories::all() )
                ->with( "regions", Regions::all() )
                ->with( "dealtypes", DealType::all()->toJson() )
                ->with( "country", "kz" )
                ->with( "lang", $request->lang );
        }

        // подать бесплатное объявление в усть каменогорске
        public function new_advert_podat_besplatnoe_obyavlenie_v_ust_kamenogorske(Request $request) {           
        
                return view("newad")
                ->with( "title", "подать бесплатное объявление в усть каменогорске" )
                ->with( "description", "подать бесплатное объявление в усть каменогорске на сайте ".config('app.name'))
                ->with( "keywords", "новое объявление, объявление, подать, разместить, разместить на сайте, казахстан")
                ->with( "categories", Categories::all() )
                ->with( "regions", Regions::all() )
                ->with( "dealtypes", DealType::all()->toJson() )
                ->with( "country", "kz" )
                ->with( "lang", $request->lang );
        }        

        // ???
        public function posted($url) {
	        return view("adposted")->with( "url", $url );
        }

        // -----------------------------------------------------------
        // Отправить жалобу
        // -----------------------------------------------------------
        public function makeComplaint(Request $request, $advert_id) {
                
                $user_id = Auth::id()? Auth::id() : null;
                \Debugbar::info("user_id = ".$user_id);

                if (Complaints::where('advert_id', '=', $advert_id)->update(array('user_id' => $user_id, 'text' => $request->complainText))) {
                        return response()->json([ "result" => "success", "msg" => "Ваша жалоба обновлена" ]);        
                }
                else {
                        $complaints = new Complaints;
                        $complaints->advert_id = $advert_id;
                        $complaints->user_id = $user_id;
                        $complaints->text = $request->complainText;
                        $complaints->save();
        
                        return response()->json([ "result" => "success", "msg" => "Ваша жалоба отправлена на рассмотрение" ]);
                }
        }
        
        // -----------------------------------------------------------
        // сделать vip, покрасить, срочно, и т.п.
        // -----------------------------------------------------------
        public function makeExtend($advert_id, $adv_type) {

                switch($adv_type) {

                        // В топ
                        case "goTop": {
                                
                                $plusDate = Carbon::now()->add(7, 'day')->toDateTimeString();
                                $adex = adex_top::select("id")->where("advert_id", "=", $advert_id)->get();
                                \Debugbar::info("count: ".$adex->count());

                                if ($adex->count()>0) {
                                        
                                        \Debugbar::info("обновляю...");                                       
                                        adex_top::where("advert_id", '=', $advert_id)->update(['startDate'=>Carbon::now()->toDateTimeString(), 'finishDate' => $plusDate]);                                        
                                }
                                else {                                      
                                        
                                        \Debugbar::info("создаю запись...");                                        
                                        $adex = new adex_top();
                                        $adex->advert_id = $advert_id;                                        
                                        $adex->startDate = Carbon::now()->toDateTimeString();
                                        $adex->finishDate = $plusDate;
                                        $adex->save();
                                }
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
                                }
                                else {                                      
                                        
                                        \Debugbar::info("создаю запись...");                                        
                                        $adex = new adex_srochno();
                                        $adex->advert_id = $advert_id;                                        
                                        $adex->startDate = Carbon::now()->toDateTimeString();
                                        $adex->finishDate = $plusDate;
                                        $adex->save();
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
                                        //Adverts::where("id", '=', $advert_id)->update(['startDate'=>Carbon::now()->toDateTimeString(), 'finishDate' => $plusDate]); // обновляю finishDate в adverts
                                }
                                else {                                      
                                        
                                        \Debugbar::info("создаю запись...");
                                        $adex = new adex_color();
                                        $adex->advert_id = $advert_id;                                        
                                        $adex->startDate = Carbon::now()->toDateTimeString();
                                        $adex->finishDate = $plusDate;
                                        $adex->save();
                                }                        
                                break;
                        }
                }

                \Debugbar::info($adv_type);
                                
                return response()->json([ "result" => "success", "msg" => "готово" ]);
        }

        // ---------------------------------
        // удалить объявление
        // ---------------------------------
        public function deleteAdvert($id) {

                // ПРИ УДАЛЕНИИ ПРОВЕРЯТЬ USER_ID с текущим      
                $user_id = Auth::id();
                \Debugbar::info("user_id ".$user_id);

                $advertRequest = Adverts::select( "category_id", "subcategory_id", "inner_id")->where( "id", $id )->where("user_id", $user_id)->limit(1);                

                $adverts = $advertRequest->get();
                \Debugbar::info($adverts);

                if (count($adverts) == 0) {
                        \Debugbar::info("нет прав на удаление");
                        return response()->json([ "result" => "error", "msg" => "Access denied for this operation" ]);  
                }
                                
                // ---- Удаляю картинки объявления ----
                $imagesRequest = Images::select(DB::raw("name"))->where("advert_id", $id);                
                $images = $imagesRequest->get(); // получаю массив

                if (count($images)>0) {
                        
                        foreach($images as $image) {
                                \Debugbar::info($image->name);
                                
                                $small_image = Common::getImage()."/small/".$image->name;                        
                                if (file_exists($small_image))
                                        unlink($small_image);                                

                                $normal_image = Common::getImage()."/normal/".$image->name;                        
                                if (file_exists($normal_image))
                                        unlink($normal_image);
                        }
                        
                        $imagesRequest->delete();
                }                                

            return response()->json([ "result" => "deleted", "msg" => "объявление удалено" ]);  
        }
}