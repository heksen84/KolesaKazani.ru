<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Adverts;
use App\SubCats;
use App\CarMark;

class TransportResultsController extends Controller
{

    public function getTransportResultsByCountry(Request $request) {}

    // -------------------------------------------------------------
    // Результаты по стране для вьюхи (results.blade.php)
    // -------------------------------------------------------------    
    public function getTransportResultsByCountryForView(Request $request, $subcategory) {

        // $filter = new TransportFilter($request);
        // $filter->getStartPage();
        // $filter->getStartPrice();
        // $filter->getEndPrice();        
       

       $subcategoryId = SubCats::select("id")->where("url_ru", $subcategory)->get();
       
       \Debugbar::info("субкатегория: ".$subcategory);       
       \Debugbar::info("id субкатегории: ".$subcategoryId);      
              
        $items = DB::select("SELECT adv.id, adv.price, adv.text FROM `adverts` AS adv");

        // adverts: categoryId, subCategoryId, subCategoryInnerId,
        // where subCategoryId = ...
        
        
        // RU
       switch($subcategory) {
        
        // ЛЕГКОВОЕ АВТО
        case "legkovoy-avtomobil": {

            $title="Покупка, продажа, обмен, сдача в аренду легковых автомобилей в Казахстане";
            $description = "";
            $keywords = "";            

	        break;
         }

         // ГРУЗОВОЕ АВТО
         case "gruzovoy-avtomobil": {            
	        break;
         }

         case "mototehnika": {
	        break;
         }         

         case "spectehnika": {
	        break;
         }         

         case "retro-avtomobil": {
	        break;
         }         

         case "vodnyy-transport": {
	        break;
         }         

         case "velosiped": {
	        break;
         }         

         case "vozdushnyy-transport": {
	        break;
         }         

       }        

       return view("results")->with("title", $title)->with("description", $description)->with("keywords", $keywords)->with("items", [])->with("itemsCount", 0);
		                        
    }

}
