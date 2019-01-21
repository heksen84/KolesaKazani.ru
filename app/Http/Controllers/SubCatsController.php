<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCats;
use App\Categories;

class SubCatsController extends Controller
{

    public function getResultsByCategory(Request $request) {

        \Debugbar::info($request);


        // в Results получает id категории по одному url

        // 1) Получить из url transport
        // 2) Получить из url gruzovoy-avtomobil
        
        //return view('results')->with("title", $category->name." в Казахстане")->with("items", $items)->with("results", json_encode($results))->with("category", $category->id);
     	return view('results')->with("title", "подкатегории")->with("items", "")->with("results", "")->with("category", "");
    }

}
