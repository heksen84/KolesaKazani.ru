<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Adverts;
use DB;

class SearchController extends Controller {
    public function getSearchData(Request $request) {
	     return Adverts::all()->toJson();
    }
}
