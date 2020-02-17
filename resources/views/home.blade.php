<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <title>{{ $title }}</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="{{ $description }}">
  <meta name="keywords" content="{{ $keywords }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}">
</head>
<body>  


<div class="modal" tabindex="-1" role="dialog" id="payment_window">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>Цена <span id="price"></span> тнг.</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Оплатить</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Не хочу</button>
      </div>
    </div>
  </div>
</div>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a href="/">На главную</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="/podat-obyavlenie">Подать объявление <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Счёт: 4000 тнг. [ пополнить ]</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/logout"><b>Выход</b></a>
      </li>      
    </ul>
  </div>
</nav>

<div class="container-fluid mycontainer text-center">
  @if (count($items)>0)
    @foreach($items as $key => $item)
      <div class="row text-left">
        <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8 col-title">
        <span id="title">{{ $item->title }}</span>
        <!--<b><div>Просмотров(?)|Сообщений(?)</div></b>-->
        </div>
        <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 col-status text-center"><span id="status"><ins>cтатус</ins><br>на модерации</span></div>
        <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 col-action text-center actions">
          <button class="btn btn-outline-primary btn-sm m-1">срочно, торг</button>
          <button class="btn btn-outline-success btn-sm m-1">продлить</button>            
          <button class="btn btn-outline-success btn-sm m-1">поднять в топ</button>
          <button class="btn btn-outline-secondary btn-sm m-1">покрасить</button>
        </div>
      </div>
  @endforeach 
@else  
  <h3 class="mt-3">нет объявлений</h3>  
  <a href="/podat-obyavlenie" class="btn btn-success mt-2" role="button" style="width:210px">Подать объявление</a>
@endif

<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin-top:15px">  
    <div class="pagination justify-content-center pagination-sm">
      <!--<div class="pagination justify-content-center">-->
      {{ $items->links() }}                         
    </div>
</div>
  
</div>
<script type="text/javascript" src="{{ mix('js/home.js') }}"></script>
</body>
</html>