<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        $title = 'Авторизация';
        $description = 'Авторизация нового пользователя на сайте объявлений';
        $keywords = "Авторизация, Пользователь";
        return view('auth.login', compact('title', 'description', 'keywords'));
   }

    /*
    public function login(Request $request) {
        $request->session()->flash('form_type', 'login');
        return $this->traitLogin($request);
    }*/
}
