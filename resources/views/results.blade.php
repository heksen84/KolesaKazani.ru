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
        <div style="color:rgb(50,50,50)">Найдено: ({{ $itemsCount }}) [категория: {{ $categoryId }}, подкатегория: {{ $subcategoryId }}]</div>	        
            <div class="row">

            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
              <div class="d-flex justify-content-center">
                <div class="spinner-border text-success" role="status" id="spinner">
                  <span class="sr-only">загрузка фильтров...</span>
                </div>
              </div>              
            </div>              

              @if ($itemsCount>0)

                @if ($categoryId===1)
                  <transportFilter></transportFilter>
                @endif

                @if ($categoryId===2)
                  <realEstateFilter></realEstateFilter>
                @endif

                @foreach($items as $item)
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                    <div class="card text-left" style="height:270px;margin:2px">
                      <img class="card-img-top" src="{{ $item->imageName }}" alt="{{ $item->title }}">
                        <div class="card-body">                                                        
                          <h5 class="card-title">{{ $item->title }}</h5>                                                  
                          <p class="card-text">{{ $item->price }} тнг.</p>
                        </div>              
                      </div>
                    </div>
                @endforeach
            @endif
          </div>   
      
      @if ($itemsCount>5)  
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
<script type="text/javascript" src="{{ mix('js/results.js') }}"></script>
</body>
</html>