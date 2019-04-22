<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Adverts;
use DB;

class SearchController extends Controller {

    public function search(Request $request) {      

      \Debugbar::info($request->input("str"));	

	    $arr = explode(" ", $request->input("str"));
	    \Debugbar::info($arr);

      return view("search")->with("items", "123"); 
  
    }
}
