<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Adverts;
use App\CarMark;
use App\CarModel;
use App\Categories;
use App\Transport;
use DB;

class AdvertController extends Controller
{
    public function getAdverts() {
	     return Adverts::all()->toJson();
    }

 	public function newAdvert() {
 		return Auth::user()? view('create')->with( "items", Categories::all() ) : view('auth\login');
 	}

    public function createAdvert(Request $request) {
        //return $request;

        $data = $request->input('data');

        $category   = $data["adv_category"];
        $text       = $data["adv_info"];
        $price      = $data["adv_price"];

      //  $request->validate([ $text  => 'min:6' ]);

     	try {

     			
            $adverts = new Adverts();
     		$adverts->user_id   		= Auth::id();
        	$adverts->text  			= $text;
        	$adverts->contacts  		= "контакты";
        	$adverts->price  			= $price;
        	$adverts->category_id  		= $category;
        	$adverts->adv_category_id  	= 0; 

            switch($category) {

                case 1: {

                    $transport = new Transport();
                    $transport->type = 0;
                    $transport->mark = 0;
                    $transport->year = 1999;
                    $transport->steering_position = 0;
                    $transport->mileage = 0;
                    $transport->engine_type = 0;
                    $transport->customs = 0;
                    $transport->save();

                    $adverts->adv_category_id = $transport->id;
                    $adverts->save();

                    break;
                }

                case 2: {
                    $Transport = new Transport();
                    break;
                }

                case 3: {
                    $Transport = new Transport();
                    break;
                }

                case 4: {
                    $Transport = new Transport();
                    break;
                }

                case 5: {
                    $Transport = new Transport();
                    break;
                }

                case 6: {
                    $Transport = new Transport();
                    break;
                }

                case 7: {
                    $Transport = new Transport();
                    break;
                }

                case 8: {
                    $Transport = new Transport();
                    break;
                }

                case 9: {
                    $Transport = new Transport();
                    break;
                }

                case 10: {
                    $Transport = new Transport();
                    break;
                }

            }

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

     public function getCarsMarks() {
	     return CarMark::all('id_car_mark','name');
    }

     public function getCarsModels(Request $request) {
     	return DB::table('car_model')->where('id_car_mark', $request->mark_id )->get();
    }
}
