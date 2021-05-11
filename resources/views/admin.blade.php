<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="keywords" content="О сайте" />
  <meta name="description" content="О сайте" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>О сайте</title>
  <link rel="icon" href="{{ asset('public/shop.ico') }}" />
</head>
<body>
<center>
  <input type="text" placeholder="olx-refresh-token"></input>
   <button>Установить</button>
   <br><br>
   <button>Парсить OLX</button>
</center>
</body>
</html>