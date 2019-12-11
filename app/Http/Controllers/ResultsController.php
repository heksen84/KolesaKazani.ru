<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Adverts;
use App\SubCats;
use App\CarMark;

class ResultsController extends Controller {

    // $filter = new TransportFilter($request);
    // $filter->getStartPage();
    // $filter->getStartPrice();
    // $filter->getEndPrice();        

    // -------------------------------------------------------------
    // Результаты по стране для вьюхи (results.blade.php)
    // -------------------------------------------------------------    
    public function getCountrySubCategoryResults(Request $request, $category, $subcategory) {              
       
        // получаю id подкатегории по названию в url
        $subcategoryId = SubCats::select("id")->where("url_ru", $subcategory)->get();                                    
        
         // делаю выборку объявлений
         //$items = Adverts::select("id", "title", "price", "created_at")->where("subcategory_id", $subcategoryId[0]->id)->get();

         // выбрать титульное изображение
         // выбрать данные сео 

	$imagePath = \Storage::disk('local')->url('app/images/preview/');

        $items = DB::select(
           "SELECT 
           adv.id, 
           adv.title,
           adv.price,
           concat('".$imagePath."', (SELECT name FROM images WHERE images.advert_id=adv.id AND images.type=0 LIMIT 1)) AS imageName
           FROM `adverts` AS adv WHERE subcategory_id = ".$subcategoryId[0]->id);            
   
         \Debugbar::info("субкатегория: ".$subcategory);       
         \Debugbar::info("id субкатегории: ".$subcategoryId);      
         \Debugbar::info($items);        
        
        // RU
       switch($subcategoryId[0]->id) {
        
        // ЛЕГКОВОЕ АВТО
        case 1: {

            $title="Легковое авто";
            $description = "Покупка, продажа, обмен и сдача в аренду легкового авто в Казахстане";
            $keywords = "";            

	        break;
         }

         // ГРУЗОВОЕ АВТО
         case 2: {            

            $title="Грузовое авто";
            $description = "Покупка, продажа, обмен и сдача в аренду грузового авто в Казахстане";
            $keywords = "";            

	        break;
         }

         case 3: {

            $title="Мототехника";
            $description = "Покупка, продажа, обмен и сдача в аренду мототехники в Казахстане";
            $keywords = "";            

	        break;
         }         

         case 4: {

            $title="Покупка, продажа, обмен и сдача в аренду спецехники в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
         }         

         case 5: {

            $title="Покупка, продажа, обмен и сдача в аренду ретро авто в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
         }         

         case 6: {
            
            $title="Покупка, продажа, обмен и сдача в аренду водного транспорта в Казахстане";
            $description = "";
            $keywords = "";            
            
            break;
         }         

         case 7: {

            $title="Покупка, продажа, обмен и сдача в аренду велосипедов в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
         }         

         case 8: {

            $title="Покупка, продажа, обмен и сдача в аренду воздушного транспорта в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
         }         

	      case 9:  {

            $title="Покупка, продажа, обмен и сдача в аренду квартир в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
	      }

	      case 10:  {

            $title="Покупка, продажа, обмен и сдача в аренду комнат в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
	      }

	      case 11:  {

            $title="Покупка, продажа, обмен и сдача в аренду дома, дачи, коттеджа в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
	      }

	      case 12:  {

            $title="Покупка, продажа, обмен и сдача в аренду дома, дачи, коттеджа в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
	      }

	      case 13:  {

            $title="Покупка, продажа, обмен и сдача в аренду дома, дачи, коттеджа в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
	      }

	      case 14:  {

            $title="Покупка, продажа, обмен и сдача в аренду дома, дачи, коттеджа в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
	      }

	      case 15:  {

            $title="Покупка, продажа, обмен и сдача в аренду дома, дачи, коттеджа в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
	      }

       }        

       return view("results")
       ->with("title", $title)
       ->with("description", $description)
       ->with("keywords", $keywords)
       ->with("items", $items)
       ->with("itemsCount", count($items));	
       	                        
    }
}
