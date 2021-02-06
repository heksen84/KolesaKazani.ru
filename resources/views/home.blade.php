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
  <link rel="shortcut icon" href="{{ asset('/public/ico/favicon.svg') }}" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ mix('css/common.css') }}" />
  <link rel="stylesheet" type="text/css" href="{{ mix('css/home.css') }}" />  
</head>
<body>

<div class="modal" tabindex="-1" role="dialog" id="payment_window">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="payment_window_title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="desc"></p>
        <h6>Цена <span id="price"></span> тнг.</h6>        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-success">Оплатить</button>
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Отмена</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="delete_advert_window">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Удаление объявления</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h6>Вы действительно желаете удалить объявление?</h6>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger" id="delete_advert_button">Да</button>
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Нет</button>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="advert_deleted_window">
  <div class="modal-dialog modal-dialog-centered " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Готово</h5>        
      </div>
      <div class="modal-body">
        <h6>Ваше объявление успешно удалено</h6>
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-outline-primary" id="close_advert_deleted_message_window">закрыть</button>
      </div>
    </div>
  </div>
</div>

  <nav class="navbar navbar-expand-lg navbar-light">
  <a href="/">На главную</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="/podat-objavlenie">Подать объявление <span class="sr-only">(current)</span></a>
      </li>
      <!--<li class="nav-item">
        <a class="nav-link" href="#">Счёт: 4000 тнг. [ пополнить ]</a>
      </li>-->
      <li class="nav-item">
        <a class="nav-link" href="/logout">Выход</a>
      </li>      
    </ul>
  </div>
</nav>

  <div class="container-fluid mycontainer text-center">

    @if (count($items)>0)
      @foreach($items as $key => $item)
        <div class="row text-left">
          <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 col-title pt-1" style="height:140px;border:none"> 
                <div class="statuses">                  
                  @if ($item->top)
                    <span class="badge badge-primary" title="В топе с {{ date('d.m.Y', strtotime($item->topStartDate)) }} по {{ date('d.m.Y', strtotime($item->topFinishDate)) }}">В топе</span>
                  @endif
                  @if ($item->srochno)
                    <span class="badge badge-danger" title="Срочное с {{ date('d.m.Y', strtotime($item->srochnoStartDate)) }} по {{ date('d.m.Y', strtotime($item->srochnoFinishDate)) }}">Срочное</span>
                  @endif
                  @if ($item->color)                  
                    <span class="badge badge-success" title="Выделено с {{ date('d.m.Y', strtotime($item->colorStartDate)) }} по {{ date('d.m.Y', strtotime($item->colorFinishDate)) }}">Выделено</span>
                  @endif                  
                </div>                
            <a href="/objavlenie/show/{{ $item->url }}" id="title" style="color:black;letter-spacing:2px">{{ $item->title }}</a>            
            <a class="btn btn-outline-success btn-sm mt-1" style="width:80px;display:block;padding:2px;color:black" href="/objavlenie/show/{{ $item->url }}?source=owner" role="button">обзор</a>
            
              <!--<div style="color:green;border:1px solid rgb(200,200,200);padding:2px;margin:5px 0px;width:115px;font-size:12px;border-radius:3px;padding-left:7px">на модерации</div>-->
          </div>        
          <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 col-action text-center actions" style="border:none" data-id={{ $item->id }}>          
          @if (!$item->expired)
            <button class="btn btn-outline-primary btn-sm m-1 prodlit" title="Срок размещения объявления истёк. Можно продлить объявление бесплатно ещё на 30 дней"><span style="color:red;letter-spacing:2px">ИСТЕКЛО</span><br>Продлить бесплатно на 30 дн.</button>
          @endif
          <!--@if (!$item->top && $item->expired)
            <button class="btn btn-outline-success btn-sm m-1 top">В топ</button>
          @endif
          @if (!$item->color && $item->expired)
            <button class="btn btn-outline-secondary btn-sm m-1 color">Выделить</button>
          @endif
          @if (!$item->srochno && $item->expired)
            <button class="btn btn-outline-danger btn-sm m-1 srochno">Срочно</button>
          @endif-->
          </div>
        </div>
    @endforeach 
  @else  
    <h3 class="mt-3">нет объявлений</h3>  
    <a href="/podat-objavlenie" class="btn btn-success mt-2 mb-2" role="button" style="width:210px">Подать объявление</a>
    
    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-1 mb-1">
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
  @endif

  <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-4">  
    <div class="pagination justify-content-center pagination">      
      {{ $items->links() }}
    </div>
  </div>
  
  </div>
<script type="text/javascript" src="{{ mix('js/home.js') }}"></script>
</body>
</html>