<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Categories;

class CategoriesController extends Controller{

    public function getCategories() {
       return Categories::all()->toJson();       
       //$results = DB::select("SELECT * FROM `categories`");
       //return json_encode($results);
    }

}
