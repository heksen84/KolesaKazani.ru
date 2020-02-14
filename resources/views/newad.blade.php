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
  <link rel="stylesheet" type="text/css" href="{{ asset('css/newad.css') }}">
</head>
<body>  

  <div id="loader">
    <div class="d-flex justify-content-center">
      <button class="btn btn-primary m-2" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Подготовка нового объявления<br>Пожалуйста подождите.
      </button>
    </div>
  </div>

  <div id="app">    
    <newad :categories="{{ $categories }}" :regions="{{ $regions }}"></newad>
  </div>
<script src="https://api-maps.yandex.ru/2.0-stable/?apikey=123&load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript" src="{{ mix('js/newad.js') }}"></script>
</body>
</html>