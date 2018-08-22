<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Adverts;
use App\Categories;

class ResultController extends Controller {

    public function getResultsByCategory(Request $request) {
    	$record = Categories::select('name')->where('url',  $request->path() )->get();
     	return view('results')->with("items", "123")->with("category_name", $record[0]->name);
    }
}
