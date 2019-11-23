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
  <h4 style="color:rgb(50,50,50)">{{ $title }}</h4>
  <h4 style="color:rgb(50,50,50)">Найдено: {{ $itemsCount }}</h4>
  <hr>

  <div class="row">
  @foreach($items as $item)
    <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3">
      <div class="card text-left">
        <!--<img src="..." class="card-img-top" alt="картинка">-->
        <div class="card-body">          
          <h5 class="card-title">{{ $item->deal_name_2 }} {{  $item->name }} {{  $item->name_rus }}</h5>
          <div style="font-size:12px;color:grey">Размещено {{ $item->created_at }}</div>
          <p class="card-text">Детали</p>
          <a href="#" class="btn btn-secondary btn-sm">Подробнее</a>
        </div>
      </div>
    </div>
  @endforeach
   </div>
  </div>

</div>

</body>
</html>