<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="get numbers, free numbers" />
  <meta name="description" content="Доска объявлений АксуМаркет">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Доска объявлений АксуМаркет</title>
  <link rel="icon" href="{{ asset('public/shop.ico') }}">
  <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
</head>
<body>
<div id="app">
<welcome></welcome>
</div>
<div class="container">
  <div class="row">
    <div class="col-2">123</div>
    <div class="col-8">
      123
    </div>
    <div class="col-2">123</div>
  </div>
</div>
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
</body>
</html>
