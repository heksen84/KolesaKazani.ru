<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;

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
	
	return view("testSSR")->with("data", Categories::all());
    }
}
