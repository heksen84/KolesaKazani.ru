<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubCatController extends Controller
{
       public function showSubCategory(Request $request) {
        return view('SubCat')->with("title", "hello subcat");
    }
}
