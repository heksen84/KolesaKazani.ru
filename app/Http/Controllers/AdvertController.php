<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Adverts;
use DB;

class AdvertController extends Controller
{
     public function getAdverts() {
	     return Adverts::all()->toJson();
    }

     public function createAdvert(Request $request) {
     	 
     	$data = $request->input('data');

     	$title 		= $data["title"];
     	$text  		= $data["text"];
     	$category  	= $data["category"];
     	$price  	= $data["price"];

     	try {
     			$adverts = new Adverts();
     			$adverts->user_id   		= Auth::id();
        		$adverts->title 			= $title;
        		$adverts->text  			= $text;
        		$adverts->contacts  		= "контакты";
        		$adverts->price  			= $price;
        		$adverts->category_id  		= $category;
        		$adverts->ad_category_id  	= 1;
        		$adverts->save();
        		$lastInsertedId = $adverts->id;
		}
		 catch(\Exception $e) {
       		return $e->getMessage();
    	}
     	
     	 return $data;
    }

    public function getFullInfo($id) {
    	$item = DB::table('adverts')->where('id', $id)->get();
        return view('fullinfo')->with("item", $item );
    }
}
