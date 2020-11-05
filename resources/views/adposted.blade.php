<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8"/>
  <title>Объявление размещено</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="Объявление размещено" />
  <meta name="description" content="Объявление размещено" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />    
  <link rel="shortcut icon" href="{{ asset('/public/ico/favicon.svg') }}" type="image/x-icon" />
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}" />
</head>
<body>
  <div class="container-fluid">
    <div class="row text-center mt-5">
      <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">    
        <img src="/public/images/success.png"></img>
        <h1 class="mt-3 mb-2">Объявление размещено!</h1>
        <h4><a href="/objavlenie/show/{{ $url }}/?view=1">посмотреть</a></h4>
      </div>
    </div>
  </div>
</body>
</html>