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

  <div class="container-fluid mycontainer">  

    <!-- закрыть страницу -->
    @if (!$region && !$city)
      <a href="/" class="close_button">X</a>
    @elseif ($region && !$city)    
      <a href="/{{$region}}" class="close_button">X</a>    
    @elseif ($region && $city)    
      <a href="/{{$region}}/{{$city}}" class="close_button">X</a>    
    @endif
    
      <h1 class="grey">{{ $title }}</h1>

        <!--<div class="grey">Найдено: ({{ $items->count() }} из {{ $items->total() }} ) [ категория: {{ $categoryId }} подкатегория: {{ $subcategoryId }} ]</div>-->

          <div class="row mt-5">
            
          <!-- ФИЛЬТРЫ -->  
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-3" id="filters">                
                @if ($categoryId===1 && $subcategoryId===1)  
                  @include('filters/transport/legkovoy')
                @else
                  @include('filters/base')
                @endif             
            </div>

            @foreach($items as $item)

              <!--<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-3">                  
                <a href="/objavlenie/show/{{ $item->id }}">
                  <div class="card text-left" style="height:270px;margin:3px">
                    <img class="card-img-top" src="{{ $item->imageName }}" alt="{{ $item->title }}">
                      <div class="card-body">                                                                                             
                        {{ $item->title }}
                        <p class="card-text">{{ $item->price }} тнг.</p>
                      </div>              
                    </div>
                  </a>
                </div>-->                
                
                
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 item">                  
                <a href="/objavlenie/show/{{ $item->id }}"">
                <div class="card" style="display:inline-block">                  
                                      
                    <img class="card-img-top image" style="width:130px;height:130px;display:inline-block;vertical-align:top" src="{{ $item->imageName }}" alt="{{ $item->title }}" onerror="this.onerror=null;this.src='/public/images/_nofoto.jpg';">                                                            
                      <div class="block-info-area">                                        
                        <div class="card-text">{{ $item->price }} тнг.</div>                                                                              
                          <div style="display:inline-block;font-size:13px;">{{ date("Размещено d/m/Y в h:i", strtotime($item->created_at)) }} в {{ $item->city_name }}</div>                    
                            <div class="card-title mt-2">
                            {{ $item->title }}
                            </div>                      
                          </div>            
                        </div>
                      </a>  
                    </div>                

              @endforeach

                @if (count($items)>9)
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">                
                  <div class="pagination justify-content-center pagination-sm">
                  <!--<div class="pagination justify-content-center">-->
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