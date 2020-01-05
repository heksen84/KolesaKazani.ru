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

    $data = $request->all();
 
     if (!$data)
      return false;
  } 


  public function search(Request $request) {
	return view("search");
  }


}