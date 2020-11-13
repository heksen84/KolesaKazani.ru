<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm() {        

        \Debugbar::info("locale: ".\App::getLocale());

        $title = 'Авторизация';
        $description = 'Авторизация пользователя на сайте';
        $keywords = "Авторизация, Пользователь";
        return view('auth.login', compact('title', 'description', 'keywords'));
   }

   function authenticated(Request $request, $user){
     $user->update(['last_login_ip' => $request->getClientIp()]);
   }
   
}
