<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SubCats;

class JournalController extends Controller {

    public function getSubCategoryNamesById(Request $request) {
        \Debugbar::info("CATEGORY ID: ".$request->id);
        return SubCats::select( "id", "name_ru" )->where("category_id", $request->id)->get();
    }
    
}
