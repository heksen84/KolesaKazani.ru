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

  // Общий метод поиска  
  private function search(Request $request) {
      
      // Получаю входящие данные и удаляю не нужные символы.
      // FIXME: Пофиксить. Вылетает с ошибкой
      // $requestString = preg_replace("/[a-zA-Z]/", "", $request->input("str"));
      
      $requestString = $request->input("str");

      $arr = explode(" ", $requestString);
      
      \Debugbar::info($requestString);	
      \Debugbar::info($arr);

      // Строка запроса для полнотекстового поиска
      $querySearchStr = "MATCH (text) AGAINST ('".$requestString."*' IN BOOLEAN MODE)";
        
      // Получаю общее кол-во
      $total = DB::select("SELECT COUNT(*) as count FROM `adverts` AS adv WHERE ".$querySearchStr);
     
      \Debugbar::info("TOTAL :".$total[0]->count);
            
      // Получаю выборку
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
        FROM `adverts` AS adv WHERE ".$querySearchStr." ORDER BY vip DESC, price, created_at DESC LIMIT ".$this->start_record.",".$this->records_limit
      );
      
      \Debugbar::info($results);

      $keywords = $requestString;
      $description = $requestString;
      $title = "Поиск по запросу: ".$requestString;

      // Формирую массив
      return array (
        "keywords"=>$keywords,
        "description"=>$description,
        "title"=>$title,
        "results"=>json_encode($results),        
        "category_name"=>json_encode($request->path()), 
        "start_record"=>0,
        "total_records"=>$total[0]->count,
        "searchString"=>$requestString
      );     
  }

  // Поиск для вьюхи
  public function searchForView(Request $request) {

    $result = $this->search($request);

    return view("results")
    ->with("keywords", $result["keywords"])
    ->with("description", $result["description"])
    ->with("title", $result["title"])    
    ->with("results", $result["results"])    
    ->with("start_record", $result["start_record"])
    ->with("total_records", $result["total_records"])
    ->with("category", "null")
    ->with("category_name", "null")
    ->with("subcat", "null")
    ->with("region", "null")
    ->with("place", "null")
    ->with("searchString", $result["searchString"]);      
  }

  // Поиск для морды
  public function searchForFront(Request $request) {
    return $this->search($request);       
  }

}