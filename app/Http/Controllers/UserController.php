<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {
      public function getUser(Request $request) {
      	//if (!Auth::guest()) 
      		return Auth::user();
      	/*$user = Session::get('userData');
		if($user->id) 
			echo 'user is logged-in';
		else 
			echo 'guest only privilegies';*/
    }
}
