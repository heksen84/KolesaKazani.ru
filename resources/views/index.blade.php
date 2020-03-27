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
  <link rel="stylesheet" type="text/css" href="{{ mix('css/common.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ mix('css/index.css') }}">
  <script data-ad-client="ca-pub-8074944108437227" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>

<body>
<div id="app">
  <div id="navbar_menu">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
<!--    <a class="navbar-brand" href="#"><h2 id="navbrand-title">{{config('app.name')}}</h2><h2 id="navbrand-description">объявления {{ $sklonResult }}</h2></a>    -->
    
    <a class="navbar-brand" href="/">
      <h2 id="navbrand-title">{{ config('app.name', 'Laravel') }}</h2><h2 id="navbrand-description">объявления {{ $sklonResult }}</h2>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">        
        <li class="nav-item active">	    
          <a class="nav-link" href="/podat-obyavlenie">Подать объявлениe <span class="sr-only">(current)</span></a>
        </li>
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
      </ul>
    </div>
  </nav>
  </div>
  
  <div class="container-fluid container1 mt-2" id="index_page">

    <!-- компонент выбора расположения -->
    <location></location>

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

    <div class="row mt-2">
      <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 center">
        <div id="logo_block">
          <!--<div id="logo_block_text">{{config('app.name')}}</div>        -->
          <a href="/">
          <div id="logo_block_text">{{ config('app.name') }}</div>
            <h1 style="font-size:12px;color:grey;margin-top:-10px;letter-spacing:3px;">Объявления {{ $sklonResult }}</h1>
          </div>
          </a>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6 center">
        
      <!-- компонент поиска по сайту -->
      <form @submit="search">
        <input type="text" id="search_string" v-model="searchString" placeholder="поиск по объявлениям {{ $sklonResult }}" required/>
        <button id="button_search" type="submit" title="Найти что требуется">найти</button>
      </form>

      <!-- кнопки выбора региона и т.п.-->
      <div class="index_select_region_and_other_button_block">    
        <button class="btn btn-link" data-toggle="modal" id="locationButton" style="margin-top:-8px" @click="showLocationWindow">расположение {{ $locationName }}</button>
        </div>
      </div>

    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 center" title="Подать новое объявление на сайте" id="new_advert_col">
      <a href="/podat-obyavlenie"><div id="new_advert_block">подать объявление</div></a>	
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
                <a href="/c/{{ $category['url'] }}" class="url"><div class="category_item">{{ $category["name"] }}</div></a>
              @else
                <a href="/{{ $location }}/c/{{ $category['url'] }}" class="url"><div class="category_item">{{ $category["name"] }}</div></a>
              @endif
        	  </div>
          @endforeach
	      </div>

        <div v-show="subCategories" id="subcats">
         <button type="button" id="close_subcats_btn" class="btn btn-link hide" @click="returnToCategories">&#8634; назад</button>         
          <div id="subcategories" class="form-inline center">
            @foreach($subcategories as $subcategory)
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 hide" data-category-id="{{ $subcategory['category_id'] }}">
              @if ($location==="/")
                <a href="/c/{{ $subcategory['category_url']}}/{{ $subcategory['url'] }}" class="url"><div class="category_item subcategory">{{ $subcategory["name"] }}</div></a>
              @else
                <a href="/{{ $location }}/c/{{ $subcategory['category_url'] }}/{{ $subcategory['url'] }}" class="url"><div class="category_item subcategory">{{ $subcategory["name"] }}</div></a>
              @endif
              </div>
            @endforeach
          </div>
        </div>        
      </div>
    </div>

  <br>
  <!-- РЕКЛАМА -->
  <!--<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <ins class="adsbygoogle"
     style="display:inline-block;width:100%;height:120px"
     data-ad-client="ca-pub-8074944108437227"
     data-ad-slot="2249357572"></ins>
    <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>-->

  @if (count($newAdverts)>0)    
  <div class="row mt-2">    
      <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mb-2">
        <h3>Новые объявления</h3>
      </div>
      <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3" v-for="i in {{ $newAdverts }}">
        <div class="card last-advert-card">    
          <div class="card-body">
          <h6 class="card-title">${ i.title }</h6>
          <p class="card-text">Цена ${ i.price } тнг.</p>        
        </div>
      </div>
    </div>  
  </div>
  @endif 

  <!-- РЕКЛАМА -->
  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-3">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <!-- Главная страница (рекоменд.) -->
  <ins class="adsbygoogle"
     style="display:inline-block;width:100%;height:110px"
     data-ad-client="ca-pub-8074944108437227"
     data-ad-slot="2249357572"></ins>
    <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>

<div class="row mt-2">
  <div id="footer"><a href="/advert" class="underline_link">Реклама</a> | <a href="/rules" class="underline_link">Правила сайта</a> | <a href="/about" class="underline_link">О сайте</a></div>
</div>  

</div>

</div>  
  <script type="text/javascript" src="{{ mix('js/index.js') }}"></script>  
</body>
</html>