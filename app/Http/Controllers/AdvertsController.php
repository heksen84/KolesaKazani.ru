<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Adverts;

class AdvertsController extends Controller
{
     public function getAdverts() {
	     return Adverts::all()->toJson();
    }

     public function createAdvert(Request $request) {
     	 
     	$data = $request->input('data');

     	$title 		= $data["title"];
     	$text  		= $data["text"];
     	$category  	= $data["category"];

     	try {
     			$adverts = new Adverts();
     			$adverts->user_id   		= Auth::id();
        		$adverts->title 			= $title;
        		$adverts->text  			= $text;
        		$adverts->contacts  		= "sdfsdfsdf";
        		$adverts->price  			= 555;
        		$adverts->category_id  		= $category;
        		$adverts->ad_category_id  	= 1;
        		$adverts->save();
		}
		 catch(\Exception $e) {
       		return $e->getMessage();
    	}
     	 

     	 return $data;
    }
}
