<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="Дать объявление"/>
        <meta name="description" content="Доска объявлений Дамеля">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Доска объявлений Дамеля</title>
	      <link rel="icon" href="{{ asset('public/shop.ico') }}">
    </head>
    <body>
<div id="app">
  <profile></profile>
</div>
</body>
</html>
<link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>