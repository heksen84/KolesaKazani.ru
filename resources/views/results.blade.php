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
  <link rel="stylesheet" type="text/css" href="{{ asset('css/results.css') }}">
</head>
<body>

<div id="app">

  <div class="container-fluid text-center">

  <h1 style="color:grey;margin:20px">{{ $title }}</h1>
  <h1 style="color:grey;margin:20px">Найдено: {{ $itemsCount }}</h1>


  @foreach($items as $item)
  <div class="row">
    <div class="col col-sm-12 col-md-5 col-lg-5 col-xl-5" style="margin:auto">
      <div class="card text-left">
        <div class="card-body">
        Размещено {{ $item->created_at }}
          <h5 class="card-title">{{ $item->deal_name_2 }} {{  $item->name }} {{  $item->name_rus }}</h5>
          <a href="#" class="btn btn-primary btn-sm">Подробнее</a>
        </div>
      </div>

    </div>
   </div>
  @endforeach
  </div>

</div>

</body>
</html>