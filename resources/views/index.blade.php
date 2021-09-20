<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <title>{{ $title }}</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="description" content="{{ $description }}" />
  <meta name="keywords" content="{{ $keywords }}" />
  <meta name="yandex-verification" content="56091dbfb213e164" />
  <!-- OpenGraph -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="{{ $title }}">
  <meta property="og:title" content="{{ $title }}">
  <meta property="og:description" content="{{ $description }}">  
  <meta property="og:url" content="https://ilbo.site/">
  <!-- /OpenGraph -->
  <meta name="news_keywords" content="{{ $title }}"/>
	<meta name="twitter:title" content="{{ $title }}"/>
	<meta property="vk:title" content="{{ $title }}"/>
  <link rel="shortcut icon" href="{{ asset('/public/ico/favicon.svg') }}" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ mix('css/common.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ mix('css/index.css') }}" />
</head>
<body>
<div id="app">
  <div id="navbar_menu">
    <nav class="navbar navbar-expand-lg navbar-light">

    <a class="navbar-brand" href="/">
      <h2 id="navbrand-title">{{ config('app.name', 'Laravel') }}</h2><h2 id="navbrand-description">Продажа авто в г.Казань</h2>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">        
        <li class="nav-item active">	    
          <a class="nav-link" href="/podat-objavlenie">Подать объявлениe <span class="sr-only">(current)</span></a>
        </li>
        @if ($auth===1)
        <li class="nav-item">
          <a class="nav-link" href="/home">Мои объявления</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/logout">Выход</a>
        </li>      
	      @else        
        <li class="nav-item">
          <a class="nav-link" href="/login">Вход</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/register">Регистрация</a>
        </li>      
        @endif        
      </ul>
    </div>
  </nav>
  </div>
  
  <div class="container-fluid container1 mt-2" id="index_page">

    <div class="row">    
      <div class="margin-auto" id="login_register_col">
        @if ($auth===0)
          <a href="/login"><div class="button" id="button_login" style="margin-left:17px">Вход</div></a>
          <a href="/register"><div class="button" id="button_reg">Регистрация</div></a>          
        @else
     	    <a href="/home"><div class="button">мои объявления</div></a>      
        @endif
      </div>
    </div>

    <div class="row" id="mobile_new_advert_link">
      <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 center">  
        <a href="/podat-objavlenie" style="font-size:16px;letter-spacing:2px;color:green">подать объявление</a>	
      </div>
    </div>

    <div class="row mt-2">
      <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 center">
        <div id="logo_block">
          <a href="/">
            <div id="logo_block_text">{{ config('app.name') }}</div>
              <h1 id="logo_block_description">Продажа авто в г.Казань</h1>
            </div>
          </a>
        </div>

    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6 center">    
        
      <!-- компонент поиска по сайту -->
      <form action="/search" method="get">
        <input type="text" id="search_string" placeholder="поиск по объявлениям" name="searchString"/>
        <button id="button_search" type="submit" title="Найти что требуется">найти</button>
      </form>


      </div>

    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 center" title="Подать новое объявление на сайте" id="new_advert_col">
      <a href="/podat-objavlenie"><div id="new_advert_block">продать авто</div></a>	
    </div>
  </div>  
  <br>


    <!--<div class="row">
    <div class="center col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2">    
	<a href="/bmw" class="blue">bmw</a><br>
        <a href="/bmw" class="blue">audi</a><br>
	<a href="/bmw" class="blue">toyota</a>
    </div>

    <div class="center col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2">    
	<a href="/bmw" class="blue">bmw</a><br>
        <a href="/bmw" class="blue">audi</a><br>
	<a href="/bmw" class="blue">toyota</a>
    </div>

    <div class="center col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2">    
	<a href="/bmw" class="blue">bmw</a><br>
        <a href="/bmw" class="blue">audi</a><br>
	<a href="/bmw" class="blue">toyota</a>
    </div>


    <div class="center col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2">    
	<a href="/bmw" class="blue">bmw</a><br>
        <a href="/bmw" class="blue">audi</a><br>
	<a href="/bmw" class="blue">toyota</a>
    </div>


    <div class="center col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2">    
	<a href="/bmw" class="blue">bmw</a><br>
        <a href="/bmw" class="blue">audi</a><br>
	<a href="/bmw" class="blue">toyota</a>
    </div>

    <div class="center col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2">    
	<a href="/bmw" class="blue">bmw</a><br>
        <a href="/bmw" class="blue">audi</a><br>
	<a href="/bmw" class="blue">toyota</a>
    </div>
    </div>
	
    <br>
    Все марки 
    <br>-->
    <div class="row" style="margin: 5px 10px">
      @foreach($car_mark as $car)
      <div class="col-4 col-sm-3 col-md-2 col-lg-2 col-xl-2"> 
      <a href="/" class="blue">{{ $car->name }}</a>
      </div>
      @endforeach
    </div>

  <div class="text-center m-4 ">
    <a href="/podat-objavlenie" class="black" style="font-size:22px;letter-spacing:4px;font-weight:300">продать авто</a>
  </div>

  <div class="row mt-2">          
    <div id="footer">
		  <a href="/rules" class="underline_link">Правила сайта</a> | <a href="/about" class="underline_link">О сайте</a> 	 
	  </div>        
  </div>

	    <script type="text/javascript" src="{{ mix('js/manifest.js') }}"></script>        
	    <script type="text/javascript" src="{{ mix('js/vendor.js') }}"></script>        
      <script type="text/javascript" src="{{ mix('js/index.js') }}"></script>
      </div>
    </div>
  </body>  

</html>