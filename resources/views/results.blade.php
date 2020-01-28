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
<!--<div style="position:fixed;top:140px;left:50px">реклама</div>
<div style="position:fixed;top:140px;right:50px">реклама</div>-->

  <!--<div class="container-fluid container1">-->
  <div class="container-fluid mycontainer">  

    <!-- кнопка закрытия -->
    <div class="close_button mt-2" title="Закрыть страницу">X</div>

      <h1 class="grey">{{ $title }}</h1>
        <!--<div class="grey">Найдено: ({{ $items->count() }} из {{ $items->total() }} ) [ категория: {{ $categoryId }} подкатегория: {{ $subcategoryId }} ]</div>-->	        
          <div class="row" style="margin-top:35px">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-bottom:10px">
              
                <!-- ФИЛЬТРЫ -->
                @if ($categoryId===1 && $subcategoryId===1)  
                  @include('filters/transport/legkovoy')
                @else
                  @include('filters/base')
                @endif
             
              </div>              

                @foreach($items as $item)
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">                  
                    <a href="/objavlenie/{{ $item->id }}">
                      <div class="card text-left" style="height:270px;margin:3px">
                        <img class="card-img-top" src="{{ $item->imageName }}" alt="{{ $item->title }}">
                          <div class="card-body">                                                                                 
                            {{ $item->title }}
                            <p class="card-text">{{ $item->price }} тнг.</p>
                          </div>              
                      </div>
                    </a>
                  </div>
                @endforeach

                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">                
                <hr>
                  <div class="pagination justify-content-center pagination-sm">
                  <!--<div class="pagination justify-content-center">-->
                    {{ $items->links() }}                         
                  </div>
                </div>
          </div>                                  	                
  </div>
  <script type="text/javascript" src="{{ mix('js/common.js') }}"></script>  
  <script type="text/javascript" src="{{ mix('js/results.js') }}"></script> 
</body>
</html>