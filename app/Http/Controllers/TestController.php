<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Categories;
use App\SubCats;
use App\Regions;

class TestController extends Controller {

    // валидация фото при загрузке
    public function checkPhotos(Request $request) {
        $this->validate($request, ['filename' => 'required','filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048']);
        \Debugbar::info($request->all());
        return $request;
    }

    // главная страничка
    public function testSSR(Request $request) {	
	return view("testIndex")->with("categories", Categories::all())->with("subcategories", SubCats::All())->with("regions", Regions::all())->with("auth", Auth::user()?1:0);
    }

    // результаты поиска в категории
    public function getResults(Request $request) {	
	return view("testResults")->with("categories", Categories::all());
    }
}
