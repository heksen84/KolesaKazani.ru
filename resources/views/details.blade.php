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

<!--
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a href="/">< На главную</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
    <ul class="navbar-nav">      
      <li class="nav-item">
        <a class="nav-link" href="/logout">Выход</a>
      </li>
    </ul>
  </div>
</nav>
-->

<div class="container-fluid mycontainer" style="margin-top:10px">

  <!-- кнопка закрытия -->
  <div class="close_button mt-2" title="Закрыть страницу" @click="closeAndReturn">X</div>  

    <div class="row">
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    
        @if ($advert->title!="null") 
          <h1>{{ $advert->title }}</h1>
        @endif      
        
        @if ($advert->text!="null")
        <hr>
          <h2>{{ $advert->text }}</h2>
        @endif

        <hr>
        @if ($advert->price!="null")
          <h3>{{ $advert->price }} тнг.</h3>
        @endif

        @foreach($images as $image)
          <img src='{{ $image->name }}' alt='{{ $image->name }}'></img>
        @endforeach


        <div id="map">карта</div>
        
    </div>
  </div>
</div>

<script src="https://api-maps.yandex.ru/2.0-stable/?apikey=123&load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript" src="{{ mix('js/common.js') }}"></script>  
<script type="text/javascript" src="{{ mix('js/details.js') }}"></script>

</body>
</html>