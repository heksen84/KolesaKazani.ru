<!DOCTYPE html>
<html lang="ru">
<head>
  <title>Доска объявлений Дамеля - все объявления Казахстана.</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
</head>
<body>
<div id="app">
  <div id="navbar_menu">
    <nav class="navbar navbar-dark bg-primary">
    <a class="navbar-brand" href="#"><h1 style="font-size:30px;font-weight:600">Дамеля</h1><h2 style="font-size:16px;margin-top:-5px;font-weight:500">все объявления Казахстана</h2></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="/podat-obyavlenie">Подать объявления <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/home">Мои объявления</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/login">Вход</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/register">Регистрация</a>
        </li>      
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
          <b class="link" @click="searchInCountry">Весь Казахстан</b><br><hr>
            @foreach($regions as $region)
              <a href="/{{ $region["url"]}}" class="black link" @click="showPlacesByRegion($event,{{ $region['region_id'] }})">{{$region["name"]}}</a><br>
            @endforeach
          </div>
          <div v-if="places">
            <b class="link" @click="searchInRegion">Искать в регионе</b><br><hr>
              <a v-for="(item, index) in placesList" :key="index" :href="item.url" class="black link block" @click="selectPlace($event, item.name, item.url)">${item.name}</a>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary margin-auto" @click="closeLocationWindow">Закрыть</button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div style="margin:auto" id="login_register_col">
      <a href="/login"><div class="button" id="button_login" style="margin-left:17px">Вход</div></a>
      <a href="/register"><div class="button" id="button_reg">Регистрация</div></a>          
    </div>     
  </div>

  <div class="row" style="margin-top:2px">
    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 center">      
      <div id="logo_block">
        <div id="logo_block_text">Дамеля</div>
        <div style="font-size:16px;color:yellow;margin-top:-13px;letter-spacing:1px;">все объявления Казахстана</div>
      </div>
  </div>

  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6 center">

    <form>
      <input type="text" id="search_string" placeholder="поиск по объявлениям" required/>
      <button id="button_search" type="submit" title="Найти что требуется">найти</button>
    </form>

    <!-- кнопки выбора региона и т.п.-->
    <div class="index_select_region_and_other_button_block">
      <button class="search_options_button btn btn-light btn-sm hide" data-toggle="modal" id="locationButton" @click="showLocationWindow">Расположение ${locationName}</button>
    </div>
  </div>

    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 center" title="Подать новое объявление" id="new_advert_col">
      <a href="/podat-obyavlenie"><div id="new_advert_block">Подать объявление</div></a>    
    </div>
  </div>  

  <div id="categories_line">
    <div class="center">    
      <div id="categories_title" class="shadow_text" style="margin-bottom:18px">категории</div>    
	      <div class="form-inline" v-show="categories">
       	  @foreach($categories as $category)
        	  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 col_item" @click="showSubcategories($event,{{ $category['id'] }})">          	   
		          <a href="/{{ $category['url'] }}" class="url" data-default-url="/{{ $category['url'] }}"><div class="category_item">{{ $category["name"] }}</div></a>
        	  </div>
        	  @endforeach
	      </div>
        
        <div v-show="subCategories">
         <button style="border:1px solid white;font-size:14px" id="close_subcats_btn" class="btn-sm btn-primary hide" @click="returnToCategories">&#8634; Назад</button>
          <div id="subcategories" class="form-inline center">                                      
            @foreach($subcategories as $subcategory)
              @foreach($categories as $category)
                @if ($subcategory['category_id'] === $category['id'])                
                  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3">
                    <a href="/{{ $subcategory['url'] }}" class="url hide" data-category-id="{{ $subcategory['category_id'] }}" data-default-url="/{{ $category['url'] }}/{{ $subcategory['url'] }}"><div class="category_item subcategory">{{ $subcategory["name"] }}</div></a>
                  </div>
                @else
                <!--///-->
                @endif            
              @endforeach
            @endforeach
          </div>
        </div>
      </div>
    </div>
  
  <div class="row" style="margin-top:20px">
    <h5 style="margin:auto">Google Advert</h5>
  </div>
  
  <div class="row" style="margin-top:40px">
    <div id="footer"><a href="/advertisers" class="underline_link">Реклама</a> | <a href="/rules" class="underline_link">Правила сайта</a> | <a href="/about" class="underline_link">О сайте</a></div>
  </div>

  </div>
</div>
  <script type="text/javascript" src="{{ mix('js/index.js') }}"></script>
</body>
</html>