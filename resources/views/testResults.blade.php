<!-- Ilya Bobkov Aksu 2018(R) -->
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
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
<div id="app">
  <div class="container-fluid mycontainer" style="margin-top:10px">	
  <h1>{{ $title }}</h1>
  @foreach ( json_decode($results, true) as $item)
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">      
        <div class="card">
            <div class="card-body">              
              <h5 class="card-title">{{ $item["title"] }}</h5>
                <p class="card-text">Описание</p>
              <a href="#" class="btn btn-primary">Подробнее</a>
            </div>
        </div>
      </div>
    </div>
  @endforeach
  </div>  
</div>
</body>
</html>
<script type="text/javascript" src="{{ mix('js/results.js') }}"></script>
