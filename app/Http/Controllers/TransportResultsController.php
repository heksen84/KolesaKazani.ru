<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransportResultsController extends Controller
{

    public function getTransportResultsByCountry() {

    }

    // -------------------------------------------------------------
    // Результаты по стране для вьюхи (results.blade.php)
    // -------------------------------------------------------------
    public function getTransportResultsByCountryForView(Request $request, $type) {

       \Debugbar::info($type);

       switch($type) {

         case "legkovoy-avtomobil": {
	  break;
         }

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
		
/*	$category = request()->segment(1); // вырезаю категорию из url
        $result = $this->getResultsByCategory($request, null, null, $category);

        if ($result==null)
            return view("errors/404");
    
        return view("results")
        ->with("keywords", $result["keywords"])
        ->with("description", $result["description"])
        ->with("title", $result["title"])        
		->with("results", $result["results"])
        ->with("category", $result["category"])
        ->with("category_name", $result["category_name"])
        ->with("subcat", "null")
        ->with("start_record", $result["start_record"])
        ->with("total_records", $result["total_records"])
        ->with("region", "null")
        ->with("place",  "null")
        ->with("searchString", "null");*/

        return view("results")->with("keywords", "")->with("description", "")->with("title", "");


    }


}
