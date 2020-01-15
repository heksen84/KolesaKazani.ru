<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Petrovich;
use App\Categories;
use App\Regions;
use App\Adverts;
use App\Places;
use DB;

class HomeController extends Controller {
		    
    public function ShowHomePage() {
        
        $results = Adverts::all()->where("user_id", Auth::id() );

        return view("home")
        ->with("results", $results)
        ->with("title", "Личный кабинет ".Auth::id())
        ->with("description", "Личный кабинет")
        ->with("keywords", "Личный кабинет");    
    
    }		
					
}