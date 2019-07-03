<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Categories;
use App\SubCats;
use App\Regions;

class TestController extends Controller {
    public function checkPhotos(Request $request) {

        $this->validate($request, [
            'filename' => 'required',
            'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        \Debugbar::info($request->all());
        return $request;
    }

    public function testSSR(Request $request) {	
            // Выбрать категории + поле parentUrl        
	    //$subcats = DB::select("SELECT * FROM `SubCats`");                
	    return view("testSSR")->with("categories", Categories::all())->with("subcategories", SubCats::All())->with("regions", Regions::all())->with("auth", Auth::user()?1:0);
    }
}
