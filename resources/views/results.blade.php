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
  <link rel="stylesheet" type="text/css" href="{{ mix('css/common.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ mix('css/results.css') }}">
</head>
<body>

  <div class="container-fluid mycontainer"> 
    
    <!--<button class="btn btn-primary btn-sm mt-1" style="position:fixed;left:50%;width:200px;margin-left:-100px;">фильтр</button>
    -->
       
    <!-- закрыть страницу -->
    @if (!$region && !$city)
      <a href="/" class="close_button">X</a>
    @elseif ($region && !$city)    
      <a href="/{{$region}}" class="close_button">X</a>    
    @elseif ($region && $city)    
      <a href="/{{$region}}/{{$city}}" class="close_button">X</a>    
    @endif
    
      <h1>{{ $title }}</h1>

        <!--<div class="grey">Найдено: ({{ $items->count() }} из {{ $items->total() }} ) [ категория: {{ $categoryId }} подкатегория: {{ $subcategoryId }} ]</div>-->
        <div class="row mt-5">
            
          <!-- ФИЛЬТРЫ -->  
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3" id="filters-row">                
            @if ($categoryId===1 && $subcategoryId===1)  
              @include('filters/transport/legkovoy')
            @else
              @include('filters/base')
            @endif             
          </div>

          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-2">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <!-- Главная страница (рекоменд.) -->
  <ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:100px"
     data-ad-client="ca-pub-8074944108437227"
     data-ad-slot="2249357572"></ins>
    <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>

            @foreach($items as $item)                                
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 item">                  
              <a href="/objavlenie/show/{{ $item->id }}">
                <div class="card">                                      
                    <img class="card-img-top image" src="{{ $item->imageName }}" alt="{{ $item->title }}" onerror="this.onerror=null;this.src='/public/images/_nofoto.jpg';" loading="lazy">                                                            
                      <div class="block-info-area">                                                  
                        <!-- если не категория работа и бизнес то отображаю цену -->
                        @if ($categoryId!=4)
                          <div class="price">{{ $item->price }} ₸</div>
                        @endif                                                                            
                        <div class="card-title">{{ $item->title }}</div>
                          <hr>
                        <div class="location">                        
                          {{ $item->region_name }},{{ $item->city_name }}<br><b style="font-size:11px">{{ date("d.m.Y в H:i", strtotime($item->created_at)) }}</b></div>                      
                        </div>            
                      </div>
                </a>  
            </div>                
            @endforeach

            @if (count($items)>9)
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">                  
                <div class="pagination justify-content-center">
                  {{ $items->links() }}                         
                </div>
              </div>
            @endif

          </div>                                  	                
  </div>
  <script type="text/javascript" src="{{ mix('js/common.js') }}"></script>  
  <script type="text/javascript" src="{{ mix('js/results.js') }}"></script> 
</body>
</html>