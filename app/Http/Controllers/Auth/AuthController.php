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
            'password' => 'required|confirmed|min:6',
        ]);
    }

    protected function create(array $data){
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function redirectToVk() {
        return Socialite::driver('vkontakte')->redirect();
    }

    public function handleVkCallback() {

/*        try {
            $user = Socialite::driver('vk')->user();
            $create['name'] = $user->name;
            $create['email'] = $user->email;
            $create['facebook_id'] = $user->id;                        
            $userModel = new User;
            $createdUser = $userModel->addNew($create);
            Auth::loginUsingId($createdUser->id);
            return redirect()->route('home');

        } catch (Exception $e) {
            return redirect('auth/vk');
        }*/
    }

    public function redirectToOk() {
        return Socialite::driver('odnoklassniki')->redirect();
    }

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
            
            auth()->login($user);
            
		return redirect ('/');		
    }

}