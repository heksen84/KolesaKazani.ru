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

     	 /*
			id, name. price, contacts, category, type, user_id, date_reg, views, region, city
     	 */

     	 return $data;
    }
}
