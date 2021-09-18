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
  <meta name="yandex-verification" content="56091dbfb213e164" />
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
  <link rel="stylesheet" type="text/css" href="{{ mix('css/index.css') }}" />
</head>
<body>
<div id="app">
  <div id="navbar_menu">
    <nav class="navbar navbar-expand-lg navbar-light">

    <a class="navbar-brand" href="/">
      <h2 id="navbrand-title">{{ config('app.name', 'Laravel') }}</h2><h2 id="navbrand-description">Продажа авто в г.Казань</h2>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">        
        <li class="nav-item active">	    
          <a class="nav-link" href="/podat-objavlenie">Подать объявлениe <span class="sr-only">(current)</span></a>
        </li>
        @if ($auth===1)
        <li class="nav-item">
          <a class="nav-link" href="/home">Мои объявления</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/logout">Выход</a>
        </li>      
	      @else        
        <li class="nav-item">
          <a class="nav-link" href="/login">Вход</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/register">Регистрация</a>
        </li>      
        @endif        
      </ul>
    </div>
  </nav>
  </div>

  <div class="modal fade" id="locationModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" style="word-wrap: break-word">
        <div class="modal-header"><button type="button" class="close closeLocationWindow" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
          <div class="modal-body">   
            <input type="text" class="form-control mb-2" placeholder="Введите местоположение поиска, например Нур-Султан" id="placeFilter"></input>
              
              <div id="placeData">
                <div id="regions">                
                  <div style="text-align:center"><a href="/" class="grey link" style="background:yellow;margin:auto">Искать по Казахстану</a></div>               	                
                    <div class="mt-2">
                      @foreach($regions as $region)
                        <a href=/{{ $region["url"] }} class="grey link text-center region_link" id={{ $region["region_id"] }}><div class="mt-1">{{ $region["name"] }} обл.</div></a>
                      @endforeach                    
                      <div class="text-center">
                        <button class='btn btn-sm btn-success m-3 closeLocationWindow'>Отмена</button>
                      </div>                    
                    </div>
                  </div>
                  <div id="loaderForSearchPlace">
                    <div class="d-flex justify-content-center">
                      <button class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>        
                      </button>
                    </div>
                  </div>
                <div id="places" class="text-center hide"></div>
              </div>
              <div id="placeSearchResults"></div>
          </div>
        </div>
      </div>
    </div>
  </div>


<!--<div style="float:left" class="index-side-advert ml-4 mt-2">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <ins class="adsbygoogle"
     style="display:inline;width:150px;height:600px"
     data-ad-client="ca-pub-8074944108437227"
     data-ad-slot="2249357572"></ins>
    <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <ins class="adsbygoogle"
     style="display:block;width:150px;height:600px"
     data-ad-client="ca-pub-8074944108437227"
     data-ad-slot="2249357572"></ins>
    <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <ins class="adsbygoogle"
     style="display:block;width:150px;height:600px"
     data-ad-client="ca-pub-8074944108437227"
     data-ad-slot="2249357572"></ins>
    <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

  </div>  

  <div style="float:right" class="index-side-advert mr-4 mt-2">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <ins class="adsbygoogle"
     style="display:block;width:150px;height:600px"
     data-ad-client="ca-pub-8074944108437227"
     data-ad-slot="2249357572"></ins>
    <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <ins class="adsbygoogle"
     style="display:block;width:150px;height:600px"
     data-ad-client="ca-pub-8074944108437227"
     data-ad-slot="2249357572"></ins>
    <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  <ins class="adsbygoogle"
     style="display:block;width:150px;height:600px"
     data-ad-client="ca-pub-8074944108437227"
     data-ad-slot="2249357572"></ins>
    <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
    </script>    
  </div>-->
  
  <div class="container-fluid container1 mt-2" id="index_page">
  
  <!--
  @if (config('app.debug'))
   <p style="position:fixed;top:3px;left:3px;font-size:13px;background:yellow;width:105px;padding:5px;border:1px solid grey;border-radius:3px">режим отладки</p>
  @endif-->

    <div class="row">    
      <div class="margin-auto" id="login_register_col">
        @if ($auth===0)
          <a href="/login"><div class="button" id="button_login" style="margin-left:17px">Вход</div></a>
          <a href="/register"><div class="button" id="button_reg">Регистрация</div></a>          
        @else
     	    <a href="/home"><div class="button">мои объявления</div></a>      
        @endif
      </div>
    </div>

    <div class="row" id="mobile_new_advert_link">
      <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 center">  
        <a href="/podat-objavlenie" style="font-size:16px;letter-spacing:2px;color:green">подать объявление</a>	
      </div>
    </div>

    <div class="row mt-2">
      <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 center">
        <div id="logo_block">
          <a href="/">
            <div id="logo_block_text">{{ config('app.name') }}</div>
              <h1 id="logo_block_description">Продажа авто в г.Казань</h1>
            </div>
          </a>
        </div>

    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-6 center">    
        
      <!-- компонент поиска по сайту -->
      <form action="/search" method="get">
        <input type="text" id="search_string" placeholder="поиск по объявлениям" name="searchString" required/>
        <input type="text" name="region" value="{{ $urlRegion }}" hidden/>
        <input type="text" name="place" value="{{ $urlPlace }}" hidden/>
        <button id="button_search" type="submit" title="Найти что требуется">найти</button>
      </form>

      <!-- кнопки выбора региона и т.п.-->
<!--     <div class="index_select_region_and_other_button_block">    
        <button class="btn btn-link" data-toggle="modal" id="locationButton" style="margin-top:-8px">Расположение {{ $locationName }} <span title="Выбрать раположения поиска">(изменить)</span></button>
     </div> -->


      </div>

    <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3 center" title="Подать новое объявление на сайте" id="new_advert_col">
      <a href="/podat-objavlenie"><div id="new_advert_block">подать объявление</div></a>	
    </div>
  </div>  
  <br>


    <div class="row">
    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">    
	<a href="/bmw" class="blue">bmw</a><br>
        <a href="/bmw" class="blue">audi</a><br>
	<a href="/bmw" class="blue">toyota</a>
    </div>

    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">    
	<a href="/bmw" class="blue">bmw</a><br>
        <a href="/bmw" class="blue">audi</a><br>
	<a href="/bmw" class="blue">toyota</a>
    </div>

    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">    
	<a href="/bmw" class="blue">bmw</a><br>
        <a href="/bmw" class="blue">audi</a><br>
	<a href="/bmw" class="blue">toyota</a>
    </div>


    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">    
	<a href="/bmw" class="blue">bmw</a><br>
        <a href="/bmw" class="blue">audi</a><br>
	<a href="/bmw" class="blue">toyota</a>
    </div>


    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">    
	<a href="/bmw" class="blue">bmw</a><br>
        <a href="/bmw" class="blue">audi</a><br>
	<a href="/bmw" class="blue">toyota</a>
    </div>

    <div class="col-sm-2 col-md-2 col-lg-2 col-xl-2">    
	<a href="/bmw" class="blue">bmw</a><br>
        <a href="/bmw" class="blue">audi</a><br>
	<a href="/bmw" class="blue">toyota</a>
    </div>
    </div>
	
    <br>
    Все марки
  <!--<div id="categories_line">
    <div class="center">        
      <div id="categories_title" class="shadow_text"></div>    
	      <div class="form-inline" id="categories">
          @foreach($categories as $category)
        	  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 col_item" id="{{ $category['id'] }}">                      	   
              @if ($location==="/")
                <a href="/c/{{ $category['url'] }}" class="url"><div class="category_item">{{ $category["name"] }}</div></a>
              @else
                <a href="/{{ $location }}/c/{{ $category['url'] }}" class="url"><div class="category_item">{{ $category["name"] }}</div></a>
              @endif
        	  </div>
          @endforeach
	      </div>  

        <div id="subcats">
         <button type="button" id="close_subcats_btn" class="btn btn-link">&#8634; назад</button>         
          <div id="subcategories" class="form-inline center">
            @foreach($subcategories as $subcategory)
              <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 hide" data-category-id="{{ $subcategory['category_id'] }}">
              @if ($location==="/")
                <a href="/c/{{ $subcategory['category_url']}}/{{ $subcategory['url'] }}" class="url"><div class="category_item subcategory">{{ $subcategory["name"] }}</div></a>
              @else
                <a href="/{{ $location }}/c/{{ $subcategory['category_url'] }}/{{ $subcategory['url'] }}" class="url"><div class="category_item subcategory">{{ $subcategory["name"] }}</div></a>
              @endif
              </div>
            @endforeach
          </div>
        </div>        
      </div>
    </div>
  <br>

  @if ( count($topAdverts) > 0 )
  <div class="row text-center">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-2">      
      <div class="titleAdverts">ТОП объявления</div>  
    </div>
      @foreach($topAdverts as $advert)      
      <div class="col-sm-12 col-md-3 col-lg-3 col-xl-2 m-3">      
        <a href="/objavlenie/show/{{ $advert->url }}" class="black">
          @if ($advert->color)
            <div class="card index-card green-background">
          @else
            <div class="card index-card">
          @endif
          @if ($advert->srochno)        
            <div class="label-torg">срочно</div>
          @endif
            <img class="card-img-top" src="{{ $advert->imageName }}" onerror="this.onerror=null;this.src='/public/images/_nofoto.jpg';" loading="lazy">          
              <div class="card-title-text">{{ $advert->title }}</div>
              <div class="card-location-text">{{ $advert->region_name }}<br>{{ $advert->city_name }}</div>
              <b class="card-price-value">{{ $advert->price }} ₸</b>
          </div>
        </a>
      </div>      
      @endforeach
  </div>
  @endif
  
  @if ( count( $newAdverts ) > 0 )
  <div class="row text-center">
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-1">      
      <div class="titleAdverts">новые объявления</div>  
    </div>
      @foreach($newAdverts as $advert)      
      <div class="col-sm-12 col-md-3 col-lg-3 col-xl-2 m-3">      
        <a href="/objavlenie/show/{{ $advert->url }}" class="black">
          @if ($advert->color)
            <div class="card index-card green-background">
          @else
            <div class="card index-card">
          @endif
          @if ($advert->srochno)        
            <div class="label-torg">срочно</div>
          @endif
            <img class="card-img-top" src="{{ $advert->imageName }}" onerror="this.onerror=null;this.src='/public/images/_nofoto.jpg';" loading="lazy">          
              <div class="card-title-text">{{ $advert->title }}</div>
              <div class="card-location-text">{{ $advert->region_name }} обл.<br>{{ $advert->city_name }}</div>
              @if ($advert->price)
                <b class="card-price-value">{{ $advert->price }} ₸</b>
              @endif
          </div>
        </a>
      </div>      
      @endforeach
  </div>
  @endif  -->  
  
  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-1 mb-1">
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>  
      <ins class="adsbygoogle"
        style="display:block"
        data-ad-client="ca-pub-8074944108437227"
        data-ad-format="auto"
        data-ad-slot="8746851039"        
        data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>

  <div class="text-center m-4 ">
    <a href="/podat-objavlenie" class="black" style="font-size:22px;letter-spacing:4px;font-weight:300">подать объявление</a>
  </div>

<!-- РЕКЛАМА -->
<!--  <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-5">
  <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>  
  <ins class="adsbygoogle"
     style="display:inline-block;width:100%;height:130px"
     data-full-width-responsive="true"
     data-ad-client="ca-pub-8074944108437227"
     data-ad-slot="2249357572"></ins>
    <script>
     (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
  </div>-->

  <!--<div class="row mt-5">
   <div class="col text-center">
    <div style="letter-spacing:2px">ИЛЬБО в соц. сетях:</div>
     <a href="https://vk.com/ilbo_kz"><img src="/public/images/social/vk.svg"></img></a>
     <a href="https://ok.ru/group/58900893401207"><img src="/public/images/social/ok.svg"></img></a>
     <a href="https://www.instagram.com/ilbo_kz"><img src="/public/images/social/insta.svg" width="56" height="56" style="margin-left:-5px"></img></a>     
    </div>
  </div>-->

        <div class="row mt-2">          
          <div id="footer">
		        <a href="/rules" class="underline_link">Правила сайта</a> | <a href="/about" class="underline_link">О сайте</a> | <a href="https://kojan.kz" class="underline_link">Информационно-развлекательный портал Коян</a>
  	        <br>
		        <a href="https://webmaster.yandex.ru/siteinfo/?site=https://ilbo.site"><img width="88" height="31" alt="" border="0" src="https://yandex.ru/cycounter?https://ilbo.site&theme=light&lang=ru"/></a>
	      </div>
        
        </div>
	<script type="text/javascript" src="{{ mix('js/manifest.js') }}"></script>        
	<script type="text/javascript" src="{{ mix('js/vendor.js') }}"></script>        
        <script type="text/javascript" src="{{ mix('js/index.js') }}"></script>
      </div>
    </div>
  </body>

  <!-- Yandex.Metrika counter -->
  <script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
    m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(68275672, "init", {
          clickmap:true,
          trackLinks:true,
          accurateTrackBounce:true,
          webvisor:true
     });
  </script>
  <noscript><div><img src="https://mc.yandex.ru/watch/68275672" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
  <!-- /Yandex.Metrika counter -->

  <!-- google adscence -->
  <script data-ad-client="ca-pub-8074944108437227" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

  <!-- ZERO.KZ -->
  <script type="text/javascript">
    var _zero_kz_ = _zero_kz_ || [];
    _zero_kz_.push(["id", 72991]);
    // Цвет кнопки
    _zero_kz_.push(["type", 1]);
    // Проверять url каждые 200 мс, при изменении перегружать код счётчика
    // _zero_kz_.push(["url_watcher", 200]);

    (function () {
    var a = document.getElementsByTagName("script")[0],
    s = document.createElement("script");
    s.type = "text/javascript";
    s.async = true;
    s.src = (document.location.protocol == "https:" ? "https:" : "http:")
    + "//c.zero.kz/z.js";
    a.parentNode.insertBefore(s, a);
    })();
  </script>

</html>