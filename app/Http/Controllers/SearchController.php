<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Adverts;
use App\SubCats;
use App\Categories;
use App\Regions;
use App\Places;

use DB;



class SearchController extends Controller {

    public function search(Request $request) {      

      \Debugbar::info($request->input("str"));	

	    $arr = explode(" ", $request->input("str"));
      \Debugbar::info($arr);
      
      // общий select
			$results = DB::select(
        "SELECT
        id as advert_id,
        DATE_FORMAT(adv.created_at, '%d/%m/%Y в %H:%m') AS created_at,
        adv.deal,
        adv.full,
        text as title, 
        price, 
        category_id,					
        (SELECT image FROM images WHERE advert_id = adv.id LIMIT 1) as image
        FROM `adverts` AS adv ORDER BY vip DESC, price, created_at DESC LIMIT 0,100"
      );

      // Получаю имя категории на русском по url
    	$category = Categories::select("id", "name")->where("url", "nedvizhimost" )->first();
      $items = Adverts::where("category_id",  $category->id )->get();       
      
      \Debugbar::info($results);

      $keywords = "";
      $description = "";
      $title = "Поиск по запросу: ".$request->input("str");


      $result =  array
      (
          "keywords"=>$keywords,
          "description"=>$description,
          "title"=>$title,
          "items"=>$items, 
          "results"=>json_encode($results),
          "category"=>$category->id,  
          "category_name"=>json_encode($request->path()), 
          "start_record"=>0,
          "total_records"=>100
      );



      return view("results")
        ->with("keywords", $result["keywords"])
        ->with("description", $result["description"])
        ->with("title", $result["title"])
        ->with("items", $result["items"])
		    ->with("results", $result["results"])
        ->with("category", $result["category"])
        ->with("category_name", $result["category_name"])
        ->with("subcat", "null")
        ->with("start_record", $result["start_record"])
        ->with("total_records", $result["total_records"])
        ->with("region", "null")
        ->with("place",  "null");

      
    }

   

}
