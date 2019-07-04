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
  <div class="container" style="margin-top:10px">	
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 margin-auto">      
        <h1>{{ $title }}</h1>
      </div>
    </div>
  @foreach ( json_decode($results, true) as $item)    
    <div class="row">    
      <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 margin-auto">
        <div class="card mb-1">
            <div class="card-body">              
              <h5 class="card-title">{{ $item["title"] }}</h5>
                <p class="card-text">Цена: {{ $item["price"] }} тнг.</p>
              <a href="#" class="btn btn-success btn-sm">Подробнее</a>
            </div>
        </div>
      </div>
    </div>
  @endforeach

    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 margin-auto">
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item disabled">
              <a class="page-link blue" href="#" tabindex="-1" aria-disabled="true">Назад</a>
            </li>
            <li class="page-item"><a class="page-link black" href="#">1</a></li>
            <li class="page-item"><a class="page-link black" href="#">2</a></li>
            <li class="page-item"><a class="page-link black" href="#">3</a></li>
            <li class="page-item">
            <a class="page-link blue" href="#">Вперёд</a>
          </li>
          </ul>
        </nav>        
      </div>
    </div>
    
  </div>
</div>
</body>
</html>
<script type="text/javascript" src="{{ mix('js/results.js') }}"></script>
