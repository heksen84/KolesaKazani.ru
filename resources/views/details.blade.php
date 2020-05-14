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
  <link rel="stylesheet" type="text/css" href="{{ mix('css/details.css') }}">
</head>
<body>
<div class="container-fluid mycontainer">

  <!-- кнопка закрытия -->
  <!--<div class="close_button mr-1" title="Закрыть страницу" @click="closeAndReturn">X</div>-->
    
    <div class="row"> 
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">                  
          <div class="return-link mb-4" title="Вернуться на предыдущую страницу">< назад</div>        
            <div id="posted"><span style="background:rgb(200,250,200);color:black;letter-spacing:1px">{{ date("Размещено d.m.Y в H:i", strtotime($advert->created_at)) }}</span></div>
              <div id="location">{{ $advert->region_name }}, {{ $advert->city_name }}</div>

              @if ($advert->title!="null") 
                <h1>{{ $advert->title }}</h1>
                <hr>
              @endif

              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-action text-center">
                <button class="btn btn-outline-success btn-sm m-1" id="makeVip">поднять в топ [VIP]</button>  
                <button class="btn btn-outline-primary btn-sm m-1" id="makeTorg">срочно, торг</button>
                <button class="btn btn-outline-success btn-sm m-1" id="makeExtend">продлить</button>                            
                <button class="btn btn-outline-secondary btn-sm m-1" id="makePaint">покрасить</button>                
              </div>

              <div id="carousel" class="carousel slide mt-2" data-ride="carousel">

                  @if (count($images)>1)
                    <ol class="carousel-indicators">                    
                      @foreach($images as $index => $image)
                        @if ($index==0)
                          <li data-target="#carousel" data-slide-to="0" class="active"></li>
                        @else
                          <li data-target="#carousel" data-slide-to="{{ $index }}"></li>
                        @endif
                      @endforeach
                    </ol>
                  @endif

                  <div class="carousel-inner">
                    @foreach($images as $index => $image)
                      @if ($index==0)
                        <div class="carousel-item active">
                          <img class="d-block w-100" src="{{ $image->name }}" alt="{{ $image->name }}" width="800" height="600">
                        </div>
                      @else
                        <div class="carousel-item">
                          <img class="d-block w-100" src="{{ $image->name }}" alt="{{ $image->name }}" width="800" height="600">
                        </div>
                      @endif
                    @endforeach
                  </div>

                  <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  
                  <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
          </div>
            
            <br>
              
              <!----------------------------------------------------------------
                подключаю характеристики по категориям
               ----------------------------------------------------------------->	       
              <!-- транспорт -->
              @if ($advert->category_id===1 && $advert->subcategory_id===1) 
                @include('results/transport/legkovoy')
              @elseif ($advert->category_id===1 && $advert->subcategory_id===2)
                @include('results/transport/common')          
              @elseif ($advert->category_id===1 && $advert->subcategory_id===5)
                @include('results/transport/common')
              @endif

              <!-- недвижимость -->
              @if ($advert->category_id===2 && $advert->subcategory_id===9) 
                @include('results/nedvizhimost/kvartira')
              @elseif ($advert->category_id===2 && $advert->subcategory_id===10)
                @include('results/nedvizhimost/komnata')          
              @elseif ($advert->category_id===2 && $advert->subcategory_id===11)
                @include('results/nedvizhimost/dom_dacha_kottedzh')
              @elseif ($advert->category_id===2 && $advert->subcategory_id===12)
                @include('results/nedvizhimost/zemelnyu_uchastok')
              @elseif ($advert->category_id===2 && $advert->subcategory_id===13)
                @include('results/nedvizhimost/garazh_ili_mashinomesto')  
              @elseif ($advert->category_id===2 && $advert->subcategory_id===14)
                @include('results/nedvizhimost/komm_nedvizhimost')  
              @elseif ($advert->category_id===2 && $advert->subcategory_id===15)
                @include('results/nedvizhimost/nedvizhimost_za_rubezhom')  
              @endif
                            
              @if ($advert->text!="null")              
                <b>Описание:</b>
                <div id="text">{{ $advert->text }}</div>
              @endif
                      
              <!-- убираю цену в категориях работа и бизнес (category_id!=4) -->
              @if ($advert->price!="null" && $advert->category_id!=4)
              <br>                           
                <div id="price">{{ $advert->price }} тнг.</div>
              @endif
              <br>
              
              <div class="text-center m-3">
                <button type="button" class="btn btn-outline-success" id="numberButton">Показать телефон</button>            
              </div>  

              <div id="phone-number"></div>
              <div id="map"></div> 
      </div>

  <!-- РЕКЛАМА -->
  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <!-- Главная страница (рекоменд.) -->
  <ins class="adsbygoogle"
     style="display:inline-block;width:100%;height:100px"
     data-ad-client="ca-pub-8074944108437227"
     data-ad-slot="2249357572"></ins>
    <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>
</div>

<script>
  window.advert_id = {{$advert->id}};
  window.coord_lat = {{$advert->coord_lat}}; 
  window.coord_lon = {{$advert->coord_lon}};
</script>

<script src="https://api-maps.yandex.ru/2.0-stable/?apikey=123&load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript" src="{{ mix('js/common.js') }}"></script>  
<script type="text/javascript" src="{{ mix('js/details.js') }}"></script>

</body>
</html>