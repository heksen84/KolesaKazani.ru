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
  <div class="container-fluid container1">
    <hr>
      <h1 style="color:rgb(50,50,50)">{{ $title }}</h1>
        <div style="color:rgb(50,50,50);text-decoration:underline">Найдено: {{ $itemsCount }}</div>     
	        <br>
          <div class="row">
            @if ($itemsCount>0)
              @foreach($items as $item)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">
                  <div class="card text-left">
                    <img class="card-img-top" src="{{ $item->imageName }}">
                    <div class="card-body">                                                        
                        <h5 class="card-title">{{ $item->title }}</h5>                                                  
                        <p class="card-text">{{ $item->price }} тнг.</p>
                        </div>              
                      </div>
                    </div>
                @endforeach
            @endif
          </div>   

       @if ($itemsCount>10)  
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <br>    
        <ul class="pagination justify-content-center">
        <li class="page-item disabled">
          <span class="page-link">Назад</span>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item active">
          <span class="page-link">
            2
          <span class="sr-only">(current)</span>
        </span>
      </li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#">Вперёд</a>
          </li>
        </ul>
      </div>
      @endif

  </div>  
</div>
<!-- http://flix:90/transport/legkovoy-avtomobil?price_from=0&price_to=999999&car_mark=10&car_model=199&role=-->
<script type="text/javascript" src="{{ mix('js/results.js') }}"></script>
</body>
</html>