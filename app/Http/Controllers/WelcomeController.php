<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categories;

class WelcomeController extends Controller{
        public function getCategories(Request $request) {
        return view('welcome')->with("items", Categories::all());
    }
}
