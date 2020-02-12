<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Helpers\Petrovich;
use App\Categories;
use App\Regions;
use App\Adverts;
use App\Places;
use DB;

class HomeController extends Controller {
		    
    public function ShowHomePage() {

    if (Auth::check()) {
                
        // status
        $items = DB::table("adverts as adv")->select("adv.id", "adv.title", "adv.public")
        ->where("user_id", Auth::id())
        ->paginate(10)
        ->onEachSide(1);                

        $userName = Auth::user()->name;

        return view("home")
        ->with("items", $items)
        ->with("title", "Личный кабинет ".$userName)
        ->with("description", "Личный кабинет пользователя ".$userName)
        ->with("keywords", "Личный кабинет, ".$userName);    
        }                    
        else 
            return redirect('/login');
    }					
}