<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="Объявление размещено" />
  <meta name="description" content="Объявление размещено" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Объявление размещено</title>
  <link rel="icon" href="{{ asset('public/shop.ico') }}" />
</head>
<body>
<center>
  <img src="public/images/success.png"></img>
  <h1>объявление размещено!</h1>
  <a href="/objavlenie/show/{{ $url }}">посмотреть</a>
</center>
</body>
</html>