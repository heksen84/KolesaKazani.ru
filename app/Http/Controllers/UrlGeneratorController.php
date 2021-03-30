<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Common;
use App\Helpers\Petrovich;
use App\Categories;
use App\SubCats;
use App\Regions;
use App\Places;

class UrlGeneratorController extends IndexController {

    public function convertData(Request $request) {

        $title = $request->route()->getAction()["title"];
        $category_id = $request->route()->getAction()["category_id"];
        $subcategory_id = $request->route()->getAction()["subcategory_id"];
        $optype = $request->route()->getAction()["optype"];
        $region_id = $request->route()->getAction()["region_id"];
        $place_id = $request->route()->getAction()["place_id"];

        \Debugbar::info($title);
        \Debugbar::info($category_id);
        \Debugbar::info($subcategory_id);
        \Debugbar::info($optype);
        \Debugbar::info($region_id);
        \Debugbar::info($place_id);

        //return $this->ShowCountryIndexPage($request, $title, $region_id, $place_id, $category_id, $subcategory_id);
        return $this->ShowCountryIndexPage($request, $title);
        
        
        /*$items = DB::table("adverts as adv")->select(
            "urls.url",
            "adv.id", 
            "adv.title", 
            "adv.price",
            "adv.startDate",            
            "kz_region.name as region_name",
            "kz_city.name as city_name",
            DB::raw("(SELECT COUNT(*) FROM adex_color WHERE NOW() BETWEEN adex_color.startDate AND adex_color.finishDate AND adex_color.advert_id=adv.id) as color"),                        
            DB::raw("(SELECT COUNT(*) FROM adex_srochno WHERE NOW() BETWEEN adex_srochno.startDate AND adex_srochno.finishDate AND adex_srochno.advert_id=adv.id) as srochno"),
            DB::raw(Common::getPreviewImage("adv.id")))
            ->leftJoin("adex_color", "adv.id", "=", "adex_color.advert_id" )
            ->leftJoin("adex_srochno", "adv.id", "=", "adex_srochno.advert_id" )			                    
            ->join("urls", "adv.id", "=", "urls.advert_id" )
            ->join("kz_region", "adv.region_id", "=", "kz_region.region_id" )
            ->join("kz_city", "adv.city_id", "=", "kz_city.city_id" )            
            ->paginate(10)
            ->onEachSide(1);

        return view("results")        
        ->with("title", $title." на сайте объявлений ".config('app.name'))         
        ->with("description", $title)         
        ->with("keywords", $title)         
        ->with("h1", "Результаты по запросу: ".$title)
        ->with("items", $items)
        ->with("categoryId", 0)
        ->with("subcategoryId", 0)         
        ->with("region", 0)
        ->with("city", 0)
        ->with("category", 0)
        ->with("subcategory", 0)         
        ->with("page", $request->page?$request->page:0)
        ->with("start_price", $request->start_price)
        ->with("end_price", $request->end_price)
        ->with("filters", 0)
        ->with("moderation", 0);*/


        
    }

}

