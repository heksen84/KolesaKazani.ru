<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="{{ $keywords }}" />
  <meta name="description" content="{{ $description }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title }}</title>
  <link rel="icon" href="{{ asset('public/shop.ico') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/results.css') }}">
</head>
<body>
<div id="app">

<!--<div style="position:fixed;top:140px;left:50px">реклама</div>
<div style="position:fixed;top:140px;right:50px">реклама</div>-->

  <!--<div class="container-fluid container1">-->
  <div class="container-fluid mycontainer">  

    <!-- кнопка закрытия -->
    <div class="close_button mt-2" title="Закрыть страницу" @click="closeAndReturn">X</div>     
      <h1 class="grey">{{ $title }}</h1>
        <div class="grey">Найдено: ({{ $itemsCount }} из {{ $totalCount }} ) [категория: {{ $categoryId }}, подкатегория: {{ $subcategoryId }}]</div>	        
          <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin:20px">
              
              @if ($categoryId===1 && $subcategoryId===1)  
                @include('filters/legkovoy')
              @else
                @include('filters/base')
              @endif

              <!--
                @if ($categoryId===1 && $subcategoryId===1)
                
                <legkovoyfilter
                  region="{{$region}}"
                  city="{{$city}}"
                  category="{{$category}}"
                  subcategory="{{$subcategory}}"
                  country="{{$country}}"
                  lang="{{$lang}}"
	                page="{{$page}}"
	                start_price="{{$start_price}}"
	                end_price="{{$end_price}}">                                    
                </legkovoyfilter>
              
              @else

                <basefilter
                  region="{{$region}}"
                  city="{{$city}}"
                  category="{{$category}}"
                  subcategory="{{$subcategory}}"
                  country="{{$country}}"
                  lang="{{$lang}}"
	                page="{{$page}}"
	                start_price="{{$start_price}}"
	                end_price="{{$end_price}}">                                    
                </basefilter>

              @endif

              -->
                

              </div>              

                @foreach($items as $item)
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                    <div class="card text-left" style="height:270px;margin:2px">
                      <img class="card-img-top" src="{{ $item->imageName }}" alt="{{ $item->title }}">
                        <div class="card-body">                                                        
                          <h5 class="card-title">{{ $item->title }}</h5>                                                  
                          <p class="card-text">{{ $item->price }} тнг.</p>
                        </div>              
                      </div>
                    </div>
                @endforeach
            
          </div>   
      
        <br>
          <!-- totalCount / 50 = кол-во кнопок на странице -->
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">            
            <ul class="pagination justify-content-center">
              
              <li class="page-item">
                <span class="page-link">Назад</span>
              </li>

                @for( $i=1; $i<$totalCount/5; $i++ ) 
                  <li class="page-item">
                    <a class="page-link" href="/category/{{ $category }}/{{ $subcategory }}/?country={{ $country }}&lang={{ $lang }}&page={{ $i }}">{{ $i }}</a>
                  </li>              
                @endfor

              <li class="page-item">
                <a class="page-link" href="">Вперёд</a>
              </li>

            </ul>
          </div>        
  </div>  
</div>
  <script type="text/javascript" src="{{ mix('js/common.js') }}"></script>  
  <script type="text/javascript" src="{{ mix('js/results.js') }}"></script> 
</body>
</html>