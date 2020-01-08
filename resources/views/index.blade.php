<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <title>{{ $title }}</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="{{ $description }}">
  <meta name="keywords" content="{{ $keywords }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
</head>

<body>
<div id="app">
  <div id="navbar_menu">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><h2 id="navbrand-title">{{config('app.name')}}</h2><h2 id="navbrand-description">объявления {{ $sklonResult }}</h2></a>    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">        
        @if ($auth===1)
        <li class="nav-item">
          <a class="nav-link" href="/home">Мои объявления</a>
        </li>
	      @else        
        <li class="nav-item">
          <a class="nav-link" href="/login">Вход</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/register">Регистрация</a>
        </li>      
        @endif
        <li class="nav-item active">	    
          <a class="nav-link" href="/podat-obyavlenie?country={{$country}}&lang={{$language}}">Подать объявлениe <span class="sr-only">(current)</span></a>
        </li>
      </ul>
    </div>
  </nav>
  </div>
  
  <div class="container-fluid container1" id="index_page" style="margin-top:10px">

    <!-- компонент выбора расположения -->
      <location></location>
    <!----------------------------------->

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

    <div class="row" style="margin-top:2px">
      <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 center">
        <div id="logo_block">
          <div id="logo_block_text">{{config('app.name')}}</div>        
            <h1 style="font-size:14px;color:grey;margin-top:-15px;letter-spacing:3px;">Объявления {{ $sklonResult }}</h1>
          </div>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6 center">
        
      <!-- компонент поиска по сайту -->
      <form @submit="search">
        <input type="text" id="search_string" v-model="searchString" placeholder="поиск по объявлениям {{ $sklonResult }}" required/>
        <button id="button_search" type="submit" title="Найти что требуется">найти</button>
      </form>
      <!-- кнопки выбора региона и т.п.-->
      <div class="index_select_region_and_other_button_block">    
        <button class="btn btn-link" data-toggle="modal" id="locationButton" style="margin-top:-10px" @click="showLocationWindow">расположение {{ $locationName }}</button>
        </div>
      </div>

    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 center" title="Подать новое объявление на сайте" id="new_advert_col">
      <a href="/podat-obyavlenie?country={{$country}}&lang={{$language}}"><div id="new_advert_block">подать объявление</div></a>	
    </div>

  </div>  
  <br>
  <div id="categories_line">
    <div class="center">        
      <div id="categories_title" class="shadow_text" style="margin-bottom:80px"></div>    
	      <div class="form-inline" v-show="categories">
          @foreach($categories as $category)
        	  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 col_item" @click="showSubcategories($event,{{ $category['id'] }})">          	   
              @if ($location==="/")
                <a href="/category/{{ $category['url'] }}?country={{$country}}&lang={{$language}}" class="url"><div class="category_item">{{ $category["name"] }}</div></a>
              @else
                <a href="/{{ $location }}/category/{{ $category['url'] }}?country={{$country}}&lang={{$language}}" class="url"><div class="category_item">{{ $category["name"] }}</div></a>
              @endif
        	  </div>
          @endforeach
	      </div>

        <div v-show="subCategories" id="subcats">
         <button type="button" style="font-size:15px;color:rgb(80,80,80);font-weight:bold" id="close_subcats_btn" class="btn btn-link hide" @click="returnToCategories">&#8634; назад</button>         
          <div id="subcategories" class="form-inline center">
            @foreach($subcategories as $subcategory)
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 hide" data-category-id="{{ $subcategory['category_id'] }}">
              @if ($location==="/")
                <a href="/category/{{ $subcategory['category_url']}}/{{ $subcategory['url'] }}?country={{$country}}&lang={{$language}}" class="url"><div class="category_item subcategory">{{ $subcategory["name"] }}</div></a>
              @else
                <a href="/{{ $location }}/category/{{ $subcategory['category_url'] }}/{{ $subcategory['url'] }}?country={{$country}}&lang={{$language}}" class="url"><div class="category_item subcategory">{{ $subcategory["name"] }}</div></a>
              @endif
              </div>
            @endforeach
          </div>
        </div>        
      </div>
    </div>
  
  <div class="row" style="margin-top:30px">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
      <h3>Новые объявления</h3>  
      <br>
    </div>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3" v-for="i in {{ $newAdverts }}">
      <div class="card" style="width: 18rem;margin:auto">
        <!--<img src="..." class="card-img-top" alt="...">-->
        <div class="card-body">
        <h6 class="card-title">${ i.title }</h6>
        <p class="card-text">Цена ${ i.price } тнг.</p>        
      </div>
    </div>
  </div>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
      <br>
      <h3>Adscence</h3>
    </div>
  </div>   

  <div class="row" style="margin-top:40px">
     <a href="http://flix:90/aktyubinskaya-obl/aktyubinsk" class="hide">Актюбинск</a>
     <a href="http://flix:90/pavlodarskaya-obl" class="hide">Павлодарская обл.</a>
    <div id="footer"><a href="/advertisers" class="underline_link">Реклама</a> | <a href="/rules" class="underline_link">Правила сайта</a> | <a href="/about" class="underline_link">О сайте</a></div>
  </div>  

 </div>
</div>  
  <script>
    window.country = "{{ $country }}"; 
    window.lang = "{{ $language }}";
  </script>
  <script type="text/javascript" src="{{ mix('js/index.js') }}"></script>  
</body>
</html>