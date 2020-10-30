<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use Socialite;
use Auth;
use Exception;

class AuthController extends Controller {
    
    use AuthenticatesUsers, RegistersUsers {
        AuthenticatesUsers::redirectPath insteadof RegistersUsers;
        AuthenticatesUsers::guard insteadof RegistersUsers;
    }
    
    protected $redirectTo = '/';
    

    public function __construct() {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:8',
        ]);
    }

    protected function create(array $data){
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /*
    --------------------------------------------------------------
    Однкоклассники
    --------------------------------------------------------------*/
    
    // редирект
    public function redirectToVk() {
        return Socialite::driver('vkontakte')->redirect();
    }

    // обратный вызов
    public function handleVkCallback(Request $request) {

        if (!$request->has('code') || $request->has('denied')) {
            return redirect('/');
        }

        $socialUser = Socialite::driver('vkontakte')->user();

        $user = User::where('vk_id', $socialUser->getID())->first();
        
        if(!$user)
            $user = User::create ([             
                'name'    => $socialUser->getName(),
                //'name'    => $socialUser->getNickname(),                
                'email'   => $socialUser->getEmail(), 
	            'vk_id'   => $socialUser->getID(),
           //     'avatar'  => $socialUser->getAvatar()             
            ]);
        
	    $user->update(['last_login_ip' => $request->getClientIp()]);    
            auth()->login($user);
            
		return redirect ('/');
    }

    /*
    --------------------------------------------------------------
    Одноклассники
    --------------------------------------------------------------*/

    // редирект
    public function redirectToOk() {
        return Socialite::driver('odnoklassniki')->redirect();
    }

    // обратный вызов
    public function handleOkCallback(Request $request) {
        
        if (!$request->has('code') || $request->has('denied')) {
            return redirect('/');
        }

        $socialUser = Socialite::driver('odnoklassniki')->user();

        $user = User::where('ok_id', $socialUser->getID())->first();
        
        if(!$user)
            $user = User::create ([             
                'name'    => $socialUser->getName(),
                'email'   => $socialUser->getEmail(), 
	            'ok_id'   => $socialUser->getID(),
           //     'avatar'  => $socialUser->getAvatar()             
            ]);
        
	    $user->update(['last_login_ip' => $request->getClientIp()]);    
            auth()->login($user);

		return redirect ('/');		
    }


     /*
    --------------------------------------------------------------
    Инста
    --------------------------------------------------------------*/

    // редирект
    public function redirectToInsta() {
        return Socialite::driver('instagram')->redirect();
    }

    // обратный вызов
    public function handleInstaCallback(Request $request) {
        
        if (!$request->has('code') || $request->has('denied')) {
            return redirect('/');
        }

        $socialUser = Socialite::driver('instagram')->user();

        $user = User::where('ok_id', $socialUser->getID())->first();
        
        if(!$user)
            $user = User::create ([             
                'name'    => $socialUser->getName(),
                'email'   => $socialUser->getEmail(), 
	            'ok_id'   => $socialUser->getID(),
           //     'avatar'  => $socialUser->getAvatar()             
            ]);
        
	    $user->update(['last_login_ip' => $request->getClientIp()]);    
            auth()->login($user);

		return redirect ('/');		
    }

}