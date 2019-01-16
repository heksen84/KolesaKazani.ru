<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCats;
//use DB;

class SubCatsController extends Controller
{
    public function getSubCats(Request $request) {
        return SubCats::all()->toJson();
    }
}
