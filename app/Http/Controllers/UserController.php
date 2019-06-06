<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    // Пользователь авторизирован
    public function isUserAuth(Request $request) {
      	return Auth::user()?1:0;
    }
    
}
