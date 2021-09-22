<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <title>{{ $title }}</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="{{ $keywords }}" />
  <meta name="description" content="{{ $description }}" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- OpenGraph -->
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Ильбо">
  <meta property="og:title" content="{{ $title }}">
  <meta property="og:description" content="{{ $description }}">  
  <meta property="og:url" content="https://ilbo.site/">
  <!-- /OpenGraph -->

  <meta name="news_keywords" content="{{ $title }}"/>
	<meta name="twitter:title" content="{{ $title }}"/>
	<meta property="vk:title" content="{{ $title }}"/>
  
  <link rel="shortcut icon" href="{{ asset('/public/ico/favicon.svg') }}" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ mix('css/common.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ mix('css/results.css') }}" />    
</head>
<body>

<!--<div style="float:left" class="index-side-advert ml-4 mt-2">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <ins class="adsbygoogle"
     style="display:inline-block;width:180px;height:600px"
     data-ad-client="ca-pub-8074944108437227"
     data-ad-slot="2249357572"></ins>
    <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div> -->

<!--  <div style="float:right" class="index-side-advert mr-4 mt-2">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <ins class="adsbygoogle"
     style="display:inline-block;width:180px;height:600px"
     data-ad-client="ca-pub-8074944108437227"
     data-ad-slot="2249357572"></ins>
    <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>-->

  <div class="container-fluid mycontainer">        
        
        <!--<h1 id="title" class="mt-3">{{ $h1 }}</h1>-->                


        <div class="form-group row">        
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12" style="border:1px solid rgb(200,200,200);background:yellow;padding:5px">          
            <div class="text-right"><a href="/" class="close-link" style="position:absolute;top:5px;right:10px">X</a></div>

            <label>{{ $h1 }}</label>
            <select>
              @foreach($models as $model)        
                <option>{{ $model->name }}</<option>        
              @endforeach
            </select>

            <button class="btn btn-outline-secondary btn-sm">Фильтр</button>
          </div>
        </div>
        
        <!--@if (count($items) === 0)
          
          <h5>в категории ничего нет</h5>

          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-3 mb-3">
          <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>  
            <ins class="adsbygoogle"
              style="display:block"
              data-ad-format="auto"
              data-ad-client="ca-pub-8074944108437227"
              data-ad-slot="8746851039"        
              data-full-width-responsive="true"></ins>
            <script>
               (adsbygoogle = window.adsbygoogle || []).push({});
          </script>
        </div>

        <div class="text-center mt-2">
          <a href="/podat-objavlenie" class="black" style="font-size:20px;letter-spacing:3px">подать объявление</a>
        </div>

        @endif-->
          <div class="row">                                
<!--            @if (count($items)>5)
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-right">
                <button class="btn btn-outline-primary btn-sm" id="filters_button">отфильтровать</button>
              </div>
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2" id="filters">
                @if ($categoryId===1 && $subcategoryId===1)  
                  @include('filters/transport/legkovoy')
                @else
                  @include('filters/base')
                @endif             
              </div>
            @endif
-->
          <!-- РЕКЛАМА -->
          <!--<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-2">
            <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>            
            <ins class="adsbygoogle"
              style="display:inline-block;width:100%;height:100px"              
              data-ad-client="ca-pub-8074944108437227"
              data-ad-slot="2249357572"></ins>
            <script>
              (adsbygoogle = window.adsbygoogle || []).push({});
            </script>
          </div>-->

            <!-- перебор массива объявлений -->
            <!--@foreach($items as $item)                                
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 item">
                <a href="/objavlenie/show/{{ $item->url }}">
                  @if ($item->color)
                    <div class="card green-background">
                  @else
                    <div class="card">
                  @endif
                  @if ($item->srochno)
                    <div class="label-torg">срочно</div>
                  @endif                  
                    <img class="card-img-top image" src="{{ $item->imageName }}" onerror="this.onerror=null;this.src='/public/images/_nofoto.jpg';" loading="lazy">                      
                      <div class="block-info-area">                                                                                                  
                        @if ($item->price!=null && $categoryId!=4 && $categoryId!=9 && $categoryId!=10)
                          <div class="price">{{ $item->price }} ₸</div>
                        @endif

                        <div class="card-title">{{ $item->title }}</div><hr>

                        <div class="location">                        
                          {{ $item->region_name }} обл., {{ $item->city_name }}<br><b style="font-size:11px">{{ date("d.m.Y в H:i", strtotime($item->startDate)) }}</b></div>                      
                        </div>            
                      </div>
                  </a>  
              </div>                
            @endforeach-->

            <!-- РЕКЛАМА -->
            <!--@if (count($items)>5)
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-1">
              <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>    
              <ins class="adsbygoogle"
                style="display:inline-block;width:100%;height:120px"
                data-full-width-responsive="true"
                data-ad-client="ca-pub-8074944108437227"
                data-ad-slot="2249357572"></ins>
              <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
              </script>
            </div>
            @endif-->

            <!-- навигация -->            
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-3">                  
                <div class="pagination justify-content-center">
                  
                </div>
              </div>            
          </div>                                  	                
  </div>
</body>
</html>