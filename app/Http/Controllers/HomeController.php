<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Petrovich;
use App\Categories;
use App\Regions;
use App\Places;
use DB;

class HomeController extends Controller {
		    
    public function ShowHomePage() {
        return view("home")
        ->with("title", "Личный кабинет")
        ->with("description", "Личный кабинет")
        ->with("keywords", "Личный кабинет");    
    
    }		
					
}