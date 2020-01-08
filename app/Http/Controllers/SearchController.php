<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Adverts;
use App\Categories;
use DB;

// Класс поиска по строке
class SearchController extends Controller {

  private $start_record   = 0;
  private $records_limit  = 5; // максимальное число записей при выборке // FIXME: вынести в отдельный модуль
  
  // ----------------------------------------
  // Обработка фильтра
  // ----------------------------------------
  private function getFilterData($request) {    
     
    if (!$request->all())
      return false;
      
  } 


  // ----------------------------------------
  // Поиск
  // ----------------------------------------
  public function search(Request $request) {
    
    $adverts = Adverts::select("id", "title", "price")->whereRaw("title LIKE '%".$request->str."%'")->get();

    \Debugbar::info($adverts);
    
    return view("results")         
         ->with("title", $request->str)         
         ->with("description", "Результаты поиска по запросу: ".$request->str)         
         ->with("keywords", "поиск, результат, запрос")
         ->with("items", $adverts)
         ->with("itemsCount", count($adverts))
         ->with("categoryId", null)
         ->with("subcategoryId", null)
         ->with("region", null)
         ->with("city", null)
         ->with("category", null)
         ->with("subcategory", null)
         ->with("country", null)
         ->with("lang", null)
         ->with("page", 0)
         ->with("start_price", 0)
         ->with("end_price", 0);
  }

}