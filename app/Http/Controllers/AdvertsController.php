<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Adverts;

class AdvertsController extends Controller
{
     public function getAdverts() {
	     return Adverts::all()->toJson();
    }

     public function createAdvert(Request $request) {
     	 
     	 $data = $request->input('data');
     	 
     	 $title 	= $data["title"];
     	 $desc  	= $data["desc"];
     	 $category  = $data["category"];

     	 return $data;
    }
}
