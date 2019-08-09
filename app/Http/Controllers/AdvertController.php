<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use App\Helpers\Petrovich;
use App\Helpers\Helper;
use App\Helpers\Sitemap;
use App\Adverts;
use App\CarMark;
use App\Categories;
use App\Transport;
use App\RealEstate;
use App\DealType;
use App\Regions;
use App\Urls;
use Validator;
use DB;

class AdvertController extends Controller {
    
    // Новое объявление
    public function NewAd() {
        return Auth::user()? view("newad")
        ->with( "title", "Подать новое объявление на сайте flix" )
        ->with( "categories", Categories::all() )
        ->with( "regions", Regions::all() )
        ->with( "dealtypes", DealType::all()->toJson() ) : redirect("login");
    }
    
}