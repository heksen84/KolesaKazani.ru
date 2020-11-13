<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // ----------------------------------------------
        // сообщения для валидации при регистрации
        // ----------------------------------------------
        $messages = [
            "name.required"         => "Введите имя",             
            "name.string"           => "Имя должно быть указано в виде строки", 
            "name.min"              => "Имя должно быть длиной не менее 3-ёх символов", 
            "name.max"              => "Имя должно быть не более 60 символов", 
            "email.required"        => "Введите почту", 
            "email.string"          => "Почта должна быть указана в виде строки",
            "email.max"             => "Почта должна быть длиной не менее 1-го символа",  
            "email.max"             => "Почта должна быть длиной не более 60 символов",  
            "email.unique"          => "Такая почта уже существует", 
            "password.required"     => "Требуется пароль", 
            "password.string"       => "Пароль должен быть указан в виде строки", 
            "password.min"          => "Пароль должен быть не менее 8 символов", 
            "password.confirmed"    => "Подтвердите пароль", 
        ]; 

        // правила валидации при регистрации
        return Validator::make($data, [
            'name'      => 'required|string|min:3|max:60',
            'email'     => 'required|string|email|min:1|max:60|unique:users',
            'password'  => 'required|string|min:8|confirmed',
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

   public function showRegistrationForm() {
        $title = 'Регистрация';
        $description = 'Регистрация пользователя на сайте';
        $keywords = "Регистрация, Новый пользователь";
        return view('auth.register', compact('title', 'description', 'keywords'));
   }
   
}
