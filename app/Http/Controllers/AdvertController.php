<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Categories;
use App\DealType;
use App\Regions;

class AdvertController extends Controller {
    
    // Новое объявление
    public function NewAd(Request $request) {

        \Debugbar::info("Язык: ".$request->lang);

        return Auth::user()? view("newad")
        ->with( "title", "Подать объявление" )
        ->with( "description", "Подать новое объявление на сайте ".config('app.name'))
        ->with( "keywords", "новое объявление, объявление, подать, разместить, разместить на сайте")
        ->with( "categories", Categories::all() )
        ->with( "regions", Regions::all() )
        ->with( "dealtypes", DealType::all()->toJson() )
        ->with( "country", "kz" )
        ->with( "lang", $request->lang )
        : redirect("login");
    }

    
    
}