<!-- Ilya Bobkov Aksu 2018(R) -->
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="объявления, бесплатные объявления, Казахстан, покупка, продажа, обмен, аренда" />
  <meta name="description" content="Дамеля - сайт объявлений">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Доска объявлений Дамеля - бесплатные объявления о покупке и продаже в Казахстане.</title>
  <link rel="icon" href="{{ asset('public/shop.ico') }}">
</head>
<body>
<div id="app">
  {{$ssr}}
</div>
</body>
</html>
<script type="text/javascript" src="{{ mix('js/index-client.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
