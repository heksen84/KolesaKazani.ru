<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <title>{{ $title }}</title>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="description" content="{{ $description }}" />
  <meta name="keywords" content="{{ $keywords }}" />  
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
  <link rel="stylesheet" type="text/css" href="{{ mix('css/details.css') }}" />
</head>
<body>
<div class="container-fluid mycontainer">

<!-- диалог оплаты -->
<div class="modal" tabindex="-1" role="dialog" id="billingModalDialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p></p>        
        <h5 class="text-right"></h5>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="continueBilling">Продолжить</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>

<!-- диалог подачи жалобы -->
<div class="modal" tabindex="-1" role="dialog" id="complainDialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Подать жалобу</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">        
        <textarea class="form-control" id="complainTextarea" rows="5" maxlength="255" placeholder="Введите текст жалобы"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="sendComplain">Отправить</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>
    
    <div class="row"> 
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <div class="text-right"><a href="" title="подать жалобу в администрацию на размещённое объявление" id="sendComplainLink">пожаловаться</a></div>    
          <div class="close-link" style="margin-bottom:25px" title="Закрыть страницу">закрыть страницу</div>                    
            <div id="posted"><span>{{ date("Размещено d.m.Y в H:i", strtotime($advert->startDate)) }}</span></div>
              <div id="location"><a href="/{{ $advert->region_url }}">{{ $advert->region_name }} обл.,</a> <a href="/{{ $advert->region_url }}/{{ $advert->city_url}}">{{ $advert->city_name }}</a></div>
                @if ($advert->category_name)
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb p-0" style="background:white;font-size:15px;margin-top:5px">                      
                      <li class="breadcrumb-item"><a href="\{{ $advert->region_url }}\{{ $advert->city_url }}\c\{{ $advert->category_url }}">{{ $advert->category_name }}</a></li>
                        @if ($advert->category_id < 10  && $advert->subcat_name)
                          <li class="breadcrumb-item"><a href="\{{ $advert->region_url }}\{{ $advert->city_url }}\c\{{ $advert->category_url }}\{{ $advert->subcat_url }}">{{ $advert->subcat_name }}</a></li>
                        @endif
                    </ol>
                  </nav>
                @endif                

                <!-- индикаторы объявления -->
                <div class="text-right">                            
                  @if ($advert->top)
                    <span class="badge badge-primary" title="В топе с {{ date('d.m.Y', strtotime($advert->topStartDate)) }} по {{ date('d.m.Y', strtotime($advert->topFinishDate)) }}">В топе</span>
                  @endif
                  @if ($advert->srochno)
                    <span class="badge badge-danger" title="Срочное с {{ date('d.m.Y', strtotime($advert->srochnoStartDate)) }} по {{ date('d.m.Y', strtotime($advert->srochnoFinishDate)) }}">Срочное</span>
                  @endif
                  @if ($advert->color)                  
                    <span class="badge badge-success" title="Выделено с {{ date('d.m.Y', strtotime($advert->colorStartDate)) }} по {{ date('d.m.Y', strtotime($advert->colorFinishDate)) }}">Выделено</span>
                  @endif
                </div>
              
                @if ($advert->title!="null") 
                  <h1>{{ $advert->title }}</h1><hr>
                @endif              

              <!--<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-action text-center mb-1" style="margin-top:-14px">                
                @if (!$advert->top)
                  <button class="btn btn-outline-primary btn-sm m-1" id="makeVip">В топ</button>
                @endif
                @if (!$advert->srochno)
                  <button class="btn btn-outline-danger btn-sm m-1" id="makeTorg">Срочно</button>
                @endif
                @if (!$advert->color)
                  <button class="btn btn-outline-success btn-sm m-1" id="makePaint">Выделить</button>
                @endif
              </div>-->

              @if ($advert->text!="null")              
                <p style="margin-top:-12px;letter-spacing:2px">Описание товара или услуги:</p>
                <div id="text">{{ $advert->text }}</div>
              @endif
                      
              <!-- не показываю цену в категориях -->
              @if ($advert->price!="null" && $advert->category_id!=4 && $advert->category_id!=9 && $advert->category_id!=10)
                <br>              
                <div id="price" title="цена: {{ $advert->price }} тенге">цена: {{ $advert->price }} тенге</div>              
              @endif

              <div class="text-center m-3">
                <br><br>
                <button type="button" class="btn btn-outline-success" id="numberButton">Показать телефон</button>            
              </div>  

              <div id="phone-number"></div>              

              @if (count($images) > 0)              
              <div id="carousel" class="carousel slide mt-2" data-ride="carousel">
                  @if (count($images) > 1)
                    <ol class="carousel-indicators">                    
                      @foreach($images as $index => $image)
                        @if ($index===0)
                          <li data-target="#carousel" data-slide-to="0" class="active"></li>
                        @else
                          <li data-target="#carousel" data-slide-to="{{ $index }}"></li>
                        @endif
                      @endforeach
                    </ol>
                  @endif
                  <div class="carousel-inner">
                    @foreach($images as $index => $image)
                      @if ($index===0)
                        <div class="carousel-item active">
                          <img class="d-block w-100" src="{{ $image->imageName }}" onerror="this.onerror=null;this.src=''" loading="lazy">
                        </div>
                      @else
                        <div class="carousel-item">
                          <img class="d-block w-100" src="{{ $image->imageName }}" onerror="this.onerror=null;this.src=''" loading="lazy">
                        </div>
                      @endif
                    @endforeach
                  </div>
                  @if (count($images)>1)
                    <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev">
                      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                      <span class="sr-only">Назад</span>
                    </a>                  
                    <a class="carousel-control-next" href="#carousel" role="button" data-slide="next">
                      <span class="carousel-control-next-icon" aria-hidden="true"></span>
                      <span class="sr-only">Вперёд</span>
                    </a>
                  @endif
              </div>
              @endif

              <!-- № объявления -->
              <div class="text-right m-1">
                <div id="advertNumber"title="номер объявления">№: {{ $advert->id }}</div>
              </div>            
              
              <!----------------------------------------------------------------
                подключаю характеристики по категориям
               ----------------------------------------------------------------->	       
              <!-- транспорт -->
              @if ($advert->category_id==1 && $advert->subcategory_id==1) 
                @include('results/transport/legkovoy')
              @elseif ($advert->category_id==1 && $advert->subcategory_id==2)
                @include('results/transport/common')          
              @elseif ($advert->category_id==1 && $advert->subcategory_id==5)
                @include('results/transport/common')
              @endif

              <!-- недвижимость -->
              @if ($advert->category_id==2 && $advert->subcategory_id==9) 
                @include('results/nedvizhimost/kvartira')
              @elseif ($advert->category_id==2 && $advert->subcategory_id==10)
                @include('results/nedvizhimost/komnata')          
              @elseif ($advert->category_id==2 && $advert->subcategory_id==11)
                @include('results/nedvizhimost/dom_dacha_kottedzh')
              @elseif ($advert->category_id==2 && $advert->subcategory_id==12)
                @include('results/nedvizhimost/zemelnyu_uchastok')
              @elseif ($advert->category_id==2 && $advert->subcategory_id==13)
                @include('results/nedvizhimost/garazh_ili_mashinomesto')  
              @elseif ($advert->category_id==2 && $advert->subcategory_id==14)
                @include('results/nedvizhimost/komm_nedvizhimost')  
              @elseif ($advert->category_id==2 && $advert->subcategory_id==15)
                @include('results/nedvizhimost/nedvizhimost_za_rubezhom')  
              @endif
                    
              <h6 style="letter-spacing:1px;font-weight:300">На карте</h6>
              <div id="map"></div>              
              
              @if ( count( $similarAdverts ) > 0 )
              
              <div class="row mt-4">                
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-left">    
                <h6 style="letter-spacing:1px;font-weight:300">Похожие объявления</h6>
              </div>

              @foreach($similarAdverts as $simAdvert)      
                <div class="col-4 col-sm-4 col-md-3 col-lg-4 col-xl-2 mb-1 text-center">      
                  <a href="/objavlenie/show/{{ $simAdvert->url }}">
                    <div class="card">
                    <img class="card-img-top" src="{{ $simAdvert->imageName }}" onerror="this.onerror=null;this.src='/public/images/_nofoto.jpg';" loading="lazy">
                    <div class="card-title-text" style="font-size:11px">{{ $simAdvert->title }}
                </div>                
                </a>
                    @if ($simAdvert->price)
                      <b class="card-price-value" style="font-size:13px">{{ $simAdvert->price }} ₸</b>
                    @endif
                  </div>      
                </div>
              @endforeach
            @endif
            
            <!--<div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-1 text-left mt-3">    
              <h6 style="letter-spacing:1px;font-weight:300">Топ 5 популярных</h6>
              <table class="table table-bordered" style="word-break: break-all">
                <tr>  
                  <td><a href="/333">222222222222222222222222222222222222222222222222222222222222222</a><br><b>1000 тнг</b></td>                                    
                </tr>  
                <tr>  
                  <td><a href="/333">222222222222222222222222222222222222222222222222222222222222222</a><br><b>2000 тнг</b></td>                                    
                </tr>  
                <tr>  
                  <td><a href="/333">222222222222222222222222222222222222222222222222222222222222222</a><br><b>3000 тнг</b></td>                                    
                </tr>  
              </table>
            </div>      -->

    <!-- РЕКЛАМА -->
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 text-center">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>  
    <ins class="adsbygoogle"
       style="display:inline-block;width:100%;height:100px"
      data-ad-client="ca-pub-8074944108437227"
      data-ad-slot="2249357572"></ins>
      <script>
      (adsbygoogle = window.adsbygoogle || []).push({});
      </script>
    </div>
  </div>  

  @if ($advert->insta_login)
  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-1">
    <a href="https://www.instagram.com/{{ $advert->insta_login }}">
    <img src="/public/images/social/insta.svg" alt="инстаграм" title="Войти через соц. сеть инстаграм" width="40" height="40"></img>
      Объявления {{ $advert->city_name }} в инстаграм
    </a>
  </div>
  @endif

  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
    <hr>
      <div class="close-link mt-2 mb-3" style="text-decoration:none;font-size:18px" title="Закрыть страницу">Закрыть страницу</div>                    
    <hr>
  </div>  

<script>
  window.advert_id = "{{$advert->id}}";
  window.coord_lat = "{{$advert->coord_lat}}"; 
  window.coord_lon = "{{$advert->coord_lon}}";
  window.vip_price = "{{$vip_price}}";
  window.srochno_torg_price = "{{$srochno_torg_price}}";
  window.color_price = "{{$color_price}}";  
</script>

<script src="https://api-maps.yandex.ru/2.0-stable/?apikey=123&load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript" src="{{ mix('js/common.js') }}"></script>  
<script type="text/javascript" src="{{ mix('js/details.js') }}"></script>

</body>
</html>