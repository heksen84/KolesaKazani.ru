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
        <div id="location">{{ $advert->region_name }}, {{ $advert->city_name }}</div>
    
              @if ($advert->title!="null") 
                <h1>{{ $advert->title }}</h1>
                <hr>
              @endif      

              @if ($advert->category_id===1 && $advert->subcategory_id===1) 
                @include('results/transport/legkovoy')
              @elseif ($advert->category_id===1 && $advert->subcategory_id===2)
                @include('results/transport/gruzovoy')
              @endif
              @elseif ($advert->category_id===1 && $advert->subcategory_id===5)
                @include('results/transport/retro')
              @endif
        
              @if ($advert->text!="null")        
                <div id="text">{{ $advert->text }}</div>
              @endif
        
              @if ($advert->price!="null")
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