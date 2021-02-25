<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Helpers\Common;
use Carbon\Carbon;
use App\Categories;
use App\Places;
use App\adex_color;
use App\adex_srochno;
use App\adex_top;
use App\Regions;
use App\DealType;
use App\Adverts;
use App\Images;
use App\Complaints;

class AdvertController extends AdvertBase {        
        
        // новое объявление
        public function new_advert(Request $request) {                        
        return $this->new_advert_common("Подать объявление бесплатно", $request);
        }

        // Подать бесплатно объявление о работе в кз
        public function podat_besplatno_obyavlenie_o_rabote_v_kz(Request $request) {                
        return $this->new_advert_common("Подать бесплатно объявление о работе в кз", $request);
        }

        // Подать бесплатное объявление в усть каменогорске
        public function podat_besplatnoe_obyavlenie_v_ust_kamenogorske(Request $request) {                           
        return $this->new_advert_common("Подать бесплатное объявление в усть каменогорске", $request);
        }

        // Подать бесплатное объявление продажа гаража
        public function podat_besplatnoe_obyavlenie_prodazha_garazha(Request $request) {                           
        return $this->new_advert_common("Подать бесплатное объявление продажа гаража", $request);
        }

        // Подать бесплатные объявления аренда квартир
        public function podat_besplatnye_obyavleniya_arenda_kvartir(Request $request) {                           
        return $this->new_advert_common("Подать бесплатные объявления аренда квартир", $request);
        }

        // Подать детское объявление
        public function podat_detskoe_obyavlenie(Request $request) {                           
        return $this->new_advert_common("Подать детское объявление", $request);
        }

        // Подать объявление авто пробегом
        public function podat_obyavlenie_avto_probegom(Request $request) {                           
        return $this->new_advert_common("Подать объявление авто пробегом", $request);
        }

        // Подать объявление аренда
        public function podat_obyavlenie_arenda(Request $request) {                           
        return $this->new_advert_common("Подать объявление аренда", $request);
        }

        // Подать объявление бесплатно в области
        public function podat_obyavlenie_besplatno_v_oblasti(Request $request) {                           
        return $this->new_advert_common("Подать объявление бесплатно в области", $request);
        }

        // Подать объявление в газету работа
        public function podat_obyavlenie_v_gazetu_rabota(Request $request) {                           
        return $this->new_advert_common("Подать объявление в газету работа", $request);
        }                

        // Подать объявление в рубрике
        public function podat_obyavlenie_v_rubrike(Request $request) {                           
        return $this->new_advert_common("Подать объявление в рубрике", $request);
        }                

        // Подать объявление в усть каменогорске
        public function podat_obyavlenie_v_ust_kamenogorske(Request $request) {                           
        return $this->new_advert_common("Подать объявление в усть каменогорске", $request);
        }

        // Подать объявление инфо
        public function podat_obyavlenie_info(Request $request) {                           
        return $this->new_advert_common("Подать объявление инфо", $request);
        }

        // Подать объявление мясо
        public function podat_obyavlenie_myaso(Request $request) {                           
        return $this->new_advert_common("Подать объявление мясо", $request);
        }
                
        // Подать объявление на продавца
        public function podat_obyavlenie_na_prodavca(Request $request) {                           
        return $this->new_advert_common("Подать объявление на продавца", $request);
        }
        
        // Подать объявление на продажу дома бесплатно
        public function podat_obyavlenie_na_prodazhu_doma_besplatno(Request $request) {                           
        return $this->new_advert_common("Подать объявление на продажу дома бесплатно", $request);
        }
        
        // Подать объявление найти работу
        public function podat_obyavlenie_nayti_rabotu(Request $request) {                           
        return $this->new_advert_common("Подать объявление найти работу", $request);
        }
        
        // Подать объявление насчет работы
        public function podat_obyavlenie_naschet_raboty(Request $request) {                           
        return $this->new_advert_common("Подать объявление насчет работы", $request);
        }

        // Подать объявление о наборе сотрудников
        public function podat_obyavlenie_o_nabore_sotrudnikov(Request $request) {                           
        return $this->new_advert_common("Подать объявление о наборе сотрудников", $request);
        }
        
        // Подать объявление о наборе сотрудников бесплатно
        public function podat_obyavlenie_o_nabore_sotrudnikov_besplatno(Request $request) {                           
        return $this->new_advert_common("Подать объявление о наборе сотрудников бесплатно", $request);
        }
        
        // Подать объявление о продаже авто бесплатно
        public function podat_obyavlenie_o_prodazhe_avto_besplatno(Request $request) {                           
        return $this->new_advert_common("Подать объявление о продаже авто бесплатно", $request);
        }

        // Подать объявление о продаже автомобиля бесплатно
        public function podat_obyavlenie_o_prodazhe_avtomobilya_besplatno(Request $request) {                           
        return $this->new_advert_common("Подать объявление о продаже автомобиля бесплатно", $request);
        }

        // Подать объявление о продаже б у
        public function podat_obyavlenie_o_prodazhe_b_u(Request $request) {                           
        return $this->new_advert_common("Подать объявление о продаже б у", $request);
        }
        
        // Подать объявление о продаже дачи
        public function podat_obyavlenie_o_prodazhe_dachi(Request $request) {                           
        return $this->new_advert_common("Подать объявление о продаже дачи", $request);
        }
        
        // Подать объявление о продаже машины
        public function podat_obyavlenie_o_prodazhe_mashiny(Request $request) {                           
        return $this->new_advert_common("Подать объявление о продаже машины", $request);
        }
        
        // Подать объявление о продаже недвижимости
        public function podat_obyavlenie_o_prodazhe_nedvizhimosti(Request $request) {                           
        return $this->new_advert_common("Подать объявление о продаже недвижимости", $request);
        }
        
        // Подать объявление о продаже шин
        public function podat_obyavlenie_o_prodazhe_shin(Request $request) {                           
        return $this->new_advert_common("Подать объявление о продаже шин", $request);
        }
        
        // Подать объявление о пропаже документов
        public function podat_obyavlenie_o_propazhe_dokumentov(Request $request) {                           
        return $this->new_advert_common("Подать объявление о пропаже документов", $request);
        }

        // Подать объявление бесплатно в караганде
        public function podat_obyavlenie_besplatno_v_karagande(Request $request) {                           
        return $this->new_advert_common("Подать объявление бесплатно в караганде", $request);
        }
        
        // Подать объявление о сдаче квартиры в аренду
        public function podat_obyavlenie_o_sdache_kvartiry_v_arendu(Request $request) {                           
        return $this->new_advert_common("Подать объявление о сдаче квартиры в аренду", $request);
        }
        
        // Подать объявление об аренде квартиры
        public function podat_obyavlenie_ob_arende_kvartiry(Request $request) {                           
        return $this->new_advert_common("Подать объявление об аренде квартиры", $request);
        }
        
        // Подать объявление куплю
        public function podat_obyavlenie_kuplyu(Request $request) {                           
        return $this->new_advert_common("Подать объявление куплю", $request);
        }
        
        // Подать объявление о работе бесплатно
        public function podat_obyavlenie_o_rabote_besplatno(Request $request) {
        return $this->new_advert_common("Подать объявление о работе бесплатно", $request);
        }
        
        // Подать объявление об услугах бесплатно
        public function podat_obyavlenie_ob_uslugah_besplatno(Request $request) {
        return $this->new_advert_common("Подать объявление об услугах бесплатно", $request);
        }
        
        // Подать объявление онлайн
        public function podat_obyavlenie_onlayn(Request $request) {
        return $this->new_advert_common("Подать объявление онлайн", $request);
        }
        
        // Подать объявление по английскому
        public function podat_obyavlenie_po_angliyskomu(Request $request) {
        return $this->new_advert_common("Подать объявление по английскому", $request);
        }
        
        // Подать объявление продажа телефона
        public function podat_obyavlenie_prodazha_telefona(Request $request) {
        return $this->new_advert_common("Подать объявление продажа телефона", $request);
        }
        
        // Подать объявление продажа техника
        public function podat_obyavlenie_prodazha_tehnika(Request $request) {
        return $this->new_advert_common("Подать объявление продажа техника", $request);
        }
        
        // Подать объявление продажа щенков
        public function podat_obyavlenie_prodazha_shchenkov(Request $request) {
        return $this->new_advert_common("Подать объявление продажа щенков", $request);
        }
        
        // Подать объявление продать авто
        public function podat_obyavlenie_prodat_avto(Request $request) {
        return $this->new_advert_common("Подать объявление продать авто", $request);
        }
        
        // Подать объявление ремонт квартиры
        public function podat_obyavlenie_remont_kvartiry(Request $request) {
        return $this->new_advert_common("Подать объявление ремонт квартиры", $request);
        }
        
        // Подать объявление сантехник
        public function podat_obyavlenie_santehnik(Request $request) {
        return $this->new_advert_common("Подать объявление сантехник", $request);
        }
        
        // Подать объявление сантехника
        public function podat_obyavlenie_santehnika(Request $request) {
        return $this->new_advert_common("Подать объявление сантехника", $request);
        }
        
        // Подать объявление строительные
        public function podat_obyavlenie_stroitelnye(Request $request) {
        return $this->new_advert_common("Подать объявление строительные", $request);
        }
        
        // Подать объявление услуги электрика
        public function podat_obyavlenie_uslugi_elektrika(Request $request) {
        return $this->new_advert_common("Подать объявление услуги электрика", $request);
        }
        
        // Подать объявления бытовой техники
        public function podat_obyavleniya_bytovoy_tehniki(Request $request) {
        return $this->new_advert_common("Подать объявления бытовой техники", $request);
        }
        
        // Подать объявления доска бесплатных объявлений
        public function podat_obyavleniya_doska_besplatnyh_obyavleniy(Request $request) {
        return $this->new_advert_common("Подать объявления доска бесплатных объявлений", $request);
        }
        
        // Подать объявления строительных работ
        public function podat_obyavleniya_stroitelnyh_rabot(Request $request) {
        return $this->new_advert_common("Подать объявления строительных работ", $request);
        }
        
        // Подать объявления электрика
        public function podat_obyavleniya_elektrika(Request $request) {
        return $this->new_advert_common("Подать объявления электрика", $request);
        }
        
        // Подать платное объявление
        public function podat_platnoe_obyavlenie(Request $request) {
        return $this->new_advert_common("Подать платное объявление", $request);
        }
        
        // Сервис разместить объявление
        public function servis_razmestit_obyavlenie(Request $request) {
        return $this->new_advert_common("Сервис разместить объявление", $request);
        }
        
        // Сиделка подать объявление
        public function sidelka_podat_obyavlenie(Request $request) {
        return $this->new_advert_common("Сиделка подать объявление", $request);
        }
        
        // Стройка подать объявление
        public function stroyka_podat_obyavlenie(Request $request) {
        return $this->new_advert_common("Стройка подать объявление", $request);
        }
        
        // Хочу купить подать объявление
        public function hochu_kupit_podat_obyavlenie(Request $request) {
        return $this->new_advert_common("Хочу купить подать объявление", $request);
        }
        
        // Юридические услуги подать объявление
        public function yuridicheskie_uslugi_podat_obyavlenie(Request $request) {
        return $this->new_advert_common("Юридические услуги подать объявление", $request);
        }
        
        // Акжайык подать объявление
        public function akzhayyk_podat_obyavlenie(Request $request) {
        return $this->new_advert_common("Акжайык подать объявление", $request);
        }
        
        // Газета срочно подать объявление
        public function gazeta_srochno_podat_obyavlenie(Request $request) {
        return $this->new_advert_common("Газета срочно подать объявление", $request);
        }
        
        // Газеты области подать объявления
        public function gazety_oblasti_podat_obyavleniya(Request $request) {
        return $this->new_advert_common("Газеты области подать объявления", $request);
        }
        
        // Нурсултан подать объявление на продажу автомобиля
        public function nursultan_podat_obyavlenie_na_prodazhu_avtomobilya(Request $request) {
        return $this->new_advert_common("Нурсултан подать объявление на продажу автомобиля", $request);
        }
        
        // Работа в интернете разместить объявление
        public function rabota_v_internete_razmestit_obyavlenie(Request $request) {
        return $this->new_advert_common("Работа в интернете разместить объявление", $request);
        }
        
        // Работа частные объявления подать
        public function rabota_chastnye_obyavleniya_podat(Request $request) {
        return $this->new_advert_common("Работа частные объявления подать", $request);
        }
        
        // Разместить объявление бесплатно и без регистрации
        public function razmestit_obyavlenie_besplatno_i_bez_registracii(Request $request) {
        return $this->new_advert_common("Разместить объявление бесплатно и без регистрации", $request);
        }
        
        // Разместить объявление о продаже
        public function razmestit_obyavlenie_o_prodazhe(Request $request) {
        return $this->new_advert_common("Разместить объявление о продаже", $request);
        }
        
        // Разместить объявление о работе
        public function razmestit_obyavlenie_o_rabote(Request $request) {
        return $this->new_advert_common("Разместить объявление о работе", $request);
        }
        
        // Разместить объявление о работе бесплатно
        public function razmestit_obyavlenie_o_rabote_besplatno(Request $request) {
        return $this->new_advert_common("Разместить объявление о работе бесплатно", $request);
        }        

	// Подать объявление бесплатно астана (45)
        public function podat_obyavlenie_besplatno_astana(Request $request) {
        return $this->new_advert_common("Подать объявление бесплатно астана", $request);
        }        

	// Подать объявления алматы (207)
        public function podat_obyavleniya_almaty(Request $request) {
        return $this->new_advert_common("Подать объявления алматы", $request);
        }        

	// Подать объявление павлодар (73)
        public function podat_obyavlenie_pavlodar(Request $request) {
        return $this->new_advert_common("Подать объявление павлодар", $request);
        }        

	// Подать объявление актобе(18)
        public function podat_obyavlenie_aktobe(Request $request) {
        return $this->new_advert_common("Подать объявление актобе", $request);
        } 	

	/* 
	-----------------------------------------------------------------------
	 Подача объявления по местоположению
	-----------------------------------------------------------------------*/
	public function podat_obyavlenie_in_place(Request $request, $place) {	
        return $this->new_advert_common("Подать объявление ".$this->getPlaceNameByUrl($place), $request);
        }        
	public function podat_obyavlenie_besplatno_in_place(Request $request, $place) {
        return $this->new_advert_common("Подать объявление бесплатно ".$this->getPlaceNameByUrl($place), $request);
        }
	public function razmestit_obyavlenie_in_place(Request $request, $place) {
        return $this->new_advert_common("Разместить объявление ".$this->getPlaceNameByUrl($place), $request);
        }        
	public function razmestit_obyavlenie_besplatno_in_place(Request $request, $place) {
        return $this->new_advert_common("Разместить объявление бесплатно ".$this->getPlaceNameByUrl($place), $request);
        } 

       /* ---------------------------------------------
        Редирект после того как объявление размещено
        -----------------------------------------------*/
        public function posted($url) {
	 return view("adposted")->with( "url", $url );
        }

       /* -----------------------------------------------------------
        Отправить жалобу
        -------------------------------------------------------------*/
        public function makeComplaint(Request $request, $advert_id) {
                
                $user_id = Auth::id()? Auth::id() : null;
                \Debugbar::info("user_id = ".$user_id);

                if (Complaints::where('advert_id', '=', $advert_id)->update(array('user_id' => $user_id, 'text' => $request->complainText))) {
                        return response()->json([ "result" => "success", "msg" => "Ваша жалоба обновлена" ]);        
                }
                else  {
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

                $user_id = Auth::id();

                \Debugbar::info("user_id ".$user_id);

                $advertRequest = Adverts::select( "category_id", "subcategory_id", "inner_id")->where( "id", $id )->where("user_id", $user_id)->limit(1);                

                $adverts = $advertRequest->get();
                \Debugbar::info($adverts);

                if (count($adverts) == 0) {
                        \Debugbar::info("нет прав на удаление");
                        return response()->json([ "result" => "error", "msg" => "Access denied for this operation" ]);  
                }
                                
                // удаляю картинки объявления
                $imagesRequest = Images::select(DB::raw("name"))->where("advert_id", $id);
		
		// получаю массив
                $images = $imagesRequest->get();

                if ( count($images) > 0 ) {
                        
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