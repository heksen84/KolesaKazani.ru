<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Categories;

class WelcomeController extends Controller {
        public function getCategories(Request $request) {
        return view('welcome')->with("items", Categories::all())->with("count", Categories::count())->with("auth", Auth::user()?1:0);
    }
}
