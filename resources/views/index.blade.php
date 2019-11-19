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
  <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css') }}">
</head>
<body>
<div id="app">
  <div id="navbar_menu">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><h2 style="font-size:26px;font-weight:650;letter-spacing:5px;color:grey">{{config('app.name')}}</h2><h2 style="font-size:16px;margin-top:-5px;font-weight:500">Объявления {{ $sklonResult }}</h2></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        @if ($auth===1)
        <li class="nav-item active">	    
          <a class="nav-link" href="/podat-obyavlenie">Подать объявлениe <span class="sr-only">(current)</span></a>
        </li>	
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
  
  <div class="container-fluid mycontainer" id="index_page" style="margin-top:10px">

  <!-- Локация -->
  <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Расположение</h5>
          <button type="button" class="close" aria-label="Close" @click="closeLocationWindow">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body text-center">	
          <div v-if="regions">
          <div class="link" @click="searchInCountry">Весь Казахстан</div><hr>
            @foreach($regions as $region)
            <div style="margin:5px">  
              <a href="/{{ $region["url"]}}" class="grey link" @click="showPlacesByRegion($event,{{ $region['region_id'] }})">{{$region["name"]}}</a><br>
            </div>
            @endforeach
          </div>
          <div v-if="places">
            <div class="link" @click="searchInRegion">Искать в области</div><hr>            
              <a v-for="(item, index) in placesList" :key="index" :href="item.url" class="grey link block" style="margin:5px" @click="selectPlace($event, item.name, item.url)">${item.name}</a>            
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary margin-auto" @click="closeLocationWindow">Закрыть</button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">

    <div class="margin-auto" id="login_register_col">
    @if ($auth===0)
      <a href="/login"><div class="button" id="button_login" style="margin-left:17px">Вход</div></a>
      <a href="/register"><div class="button" id="button_reg">Регистрация</div></a>          
    @else
     	<a href="/home"><div class="button">мои объявления</div></a>


      <!-- Example single danger button -->
      <div class="btn-group">
        <button type="button" class="btn btn-danger btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Action
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <a class="dropdown-item" href="#">Something else here</a>
        <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Separated link</a>
        </div>
      </div>


    @endif
    </div>
  </div>

  <div class="row" style="margin-top:2px">
    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 center">
      <div id="logo_block">
        <div id="logo_block_text">{{config('app.name')}}</div>
        <!--<h1 style="font-size:15px;color:yellow;margin-top:-10px;letter-spacing:1px;">Объявления {{ $sklonResult }}</h1>-->
        <h1 style="font-size:14px;color:grey;margin-top:-15px;letter-spacing:3px;">Объявления {{ $sklonResult }}</h1>
      </div>
  </div>

  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6 center">

    <form>
      <input type="text" id="search_string" placeholder="поиск по объявлениям" required/>
      <button id="button_search" type="submit" title="Найти что требуется">найти</button>
    </form>

    <!-- кнопки выбора региона и т.п.-->
    <div class="index_select_region_and_other_button_block">
    <!--<button class="search_options_button btn btn-light btn-sm" data-toggle="modal" id="locationButton" @click="showLocationWindow">&#10003; Расположение {{ $locationName }}</button>-->
      <!--<button class="search_options_button btn btn-light btn-sm" data-toggle="modal" id="locationButton" @click="showLocationWindow">Расположение {{ $locationName }}</button>-->
      <button class="btn btn-link" data-toggle="modal" id="locationButton" style="margin-top:-10px" @click="showLocationWindow">Расположение {{ $locationName }}</button>
    </div>

  </div>

    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 center" title="Подать новое объявление" id="new_advert_col">
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
                <a href="/{{ $category['url'] }}" class="url"><div class="category_item">{{ $category["name"] }}</div></a>
              @else
                <a href="/{{ $location }}/{{ $category['url'] }}" class="url"><div class="category_item">{{ $category["name"] }}</div></a>
              @endif
        	  </div>
          @endforeach
	      </div>
        
        <div v-show="subCategories" id="subcats">
         <button type="button" style="font-size:16px;color:grey;font-weight:bold" id="close_subcats_btn" class="btn btn-link hide" @click="returnToCategories">&#8634; Назад</button>         
          <div id="subcategories" class="form-inline center">
            @foreach($subcategories as $subcategory)
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 hide" data-category-id="{{ $subcategory['category_id'] }}">
              @if ($location==="/")
                <a href="/{{ $subcategory['category_url']}}/{{ $subcategory['url'] }}" class="url"><div class="category_item subcategory">{{ $subcategory["name"] }}</div></a>
              @else
                <a href="/{{ $location }}/{{ $subcategory['category_url'] }}/{{ $subcategory['url'] }}" class="url"><div class="category_item subcategory">{{ $subcategory["name"] }}</div></a>
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
<div class="col-sm-12 col-md-12 col-lg-12 col-xl-3" v-for="i in 8">
<div class="card" style="width: 18rem;margin:auto">
  <!--<img src="..." class="card-img-top" alt="...">-->
  <div class="card-body">
    <h5 class="card-title">Card title</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-secondary btn-sm">Go somewhere</a>
  </div>
</div>

</div>

    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
	<br>
  	<h3>Adscence</h3>
    </div>

  </div>
  
  <div class="row" style="margin-top:40px">
    <div id="footer"><a href="/advertisers" class="underline_link">Реклама</a> | <a href="/rules" class="underline_link">Правила сайта</a> | <a href="/about" class="underline_link">О сайте</a></div>
  </div>

 </div>
</div>
  <script type="text/javascript" src="{{ mix('js/index.js') }}"></script>
</body>
</html>