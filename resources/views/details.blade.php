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
  <link rel="stylesheet" type="text/css" href="{{ asset('css/details.css') }}">
</head>
<body>

<div class="container-fluid mycontainer">
  <!-- кнопка закрытия -->
  <div class="close_button mt-2" title="Закрыть страницу" @click="closeAndReturn">X</div>
    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
<!--        {{ $advert->category_id }} / {{ $advert->subcategory_id }}-->
        <div id="location">{{ $advert->region_name }}, {{ $advert->city_name }}</div>
        
              @if ($advert->title!="null") 
                <h1>{{ $advert->title }}</h1>
                <hr>
              @endif
              
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
                <br>  
                <ins>Описание:</ins>                
                <div id="text">{{ $advert->text }}</div>
              @endif
                      
              <!-- убираю цену в категориях работа и бизнес (category_id!=4) -->
              @if ($advert->price!="null" && $advert->category_id!=4)
                <div id="price">{{ $advert->price }} тнг.</div>
              @endif

              @foreach($images as $image)
                <img src='{{ $image->name }}' alt='{{ $image->name }}'></img>
              @endforeach

            <button type="button" class="btn btn-primary btn-sm" id="showNumberBtn">показать номер</button>

          <div id="phone-number"></div>
        <div id="map" style="margin-top:20px"></div>        

    </div>
  </div>
</div>

<script>
  window.advert_id = "{{$advert->id}}";
  window.coord_lat = "{{$advert->coord_lat}}"; 
  window.coord_lon = "{{$advert->coord_lon}}";
</script>

<script src="https://api-maps.yandex.ru/2.0-stable/?apikey=123&load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript" src="{{ mix('js/common.js') }}"></script>  
<script type="text/javascript" src="{{ mix('js/details.js') }}"></script>

</body>
</html>