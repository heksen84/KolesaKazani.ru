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
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a href="/">< На главную</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
    <ul class="navbar-nav">      
      <li class="nav-item">
        <a class="nav-link" href="/logout">Выход</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container-fluid mycontainer">
  <div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
      <h1>{{ $advert[0]->title }}</h1>
      <hr>
      <h2>{{ $advert[0]->text }}</h2>
      <hr>
      <h3>{{ $advert[0]->price }} тнг.</h3>
    </div>
  </div>
</div>

<script type="text/javascript" src="{{ mix('js/home.js') }}"></script>
</body>
</html>