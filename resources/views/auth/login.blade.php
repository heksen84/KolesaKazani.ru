@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Авторизация') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf


                        <div class="form-group row mb-4">                            
                            <div class="col-md-12 text-center mb-2">                        
                                <span style="font-size:15px;letter-spacing:2px">войти через социальную сеть</span>
                            </div>
                            <div class="col-md-12 text-center" id="col-links">                                
                                <a href="{{ url('auth/vk') }}">                        
                                    <img src="/public/images/social/vk.svg" alt="ВКонтакте" title="Войти через соц. сеть ВКонтакте" id="auth_vk"></img>
                                </a>
                                <a href="{{ url('auth/ok') }}">                        
                                    <img src="/public/images/social/ok.svg" alt="Одноклассники" title="Войти через соц. сеть Одноклассники" id="auth_ok"></img>
                                </a>
                                <!--<a href="{{ url('auth/insta') }}">                        
                                    <img src="/public/images/social/insta.svg" alt="инстаграмм" title="Войти через соц. сеть Инстаграм" id="auth_instagram" width="56" height="56" style="margin-left:-5px"></img>
                                </a>-->
                            </div>                        
                        </div>                                                
                        <hr>
                        <div class="form-group row">              
                                  
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail адрес') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>                                                                                                

                        <div class="form-group row">
                            <div class="col-md-12 text-center">
                                                    
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Войти') }}
                                </button>
                            
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Забыли пароль?') }}
                                    </a>                                    
                                @endif                                
                                
                                <a href="/register" style="display:block;margin-top:25px;font-weight:500;letter-spacing:2">Регистрация на сайте</a>

                            </div>                                                                                    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script type="text/javascript" src="{{ mix('js/login.js') }}"></script> 
<style> 
#col-links a:hover {
 text-decoration: none;
}
</style> 