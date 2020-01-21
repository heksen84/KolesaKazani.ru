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
  <div id="app"></div>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a href="/">на главную</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="/">Подать объявление <span class="sr-only">(current)</span></a>
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

<div class="container-fluid mycontainer">
  <div class="row">    
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th scope="col" style="width:1%">№</th>
          <th scope="col">Заголовок</th>
          <th scope="col" style="width:14%">Статус</th>
          <th scope="col" style="width:15%">Действие</th>      
        </tr>
      </thead>
    <tbody>
    @foreach($results as $key => $item)
      <tr>
        <th scope="row">{{ $key+1 }}</th>
          <td>{{ $item["title"] }}</td>
          <td class="text-center">На модерации</td>
          <td class="text-center">
            <button class="btn btn-outline-primary btn-sm m-1 full-width">срочно, торг</button>
            <button class="btn btn-outline-success btn-sm m-1 full-width">продлить</button>            
            <button class="btn btn-outline-success btn-sm m-1 full-width">поднять в топ</button>
            <button class="btn btn-outline-secondary btn-sm m-1 full-width">покрасить</button>
          </td>
      </tr>
      @endforeach    
    </tbody>
  </table>
</div>
</div>

<script type="text/javascript" src="{{ mix('js/home.js') }}"></script>
</body>
</html>