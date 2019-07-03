<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="{{ $keywords }}" />
        <meta name="description" content="{{ $description }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $title }}</title>
	    <link rel="icon" href="{{ asset('public/shop.ico') }}">
    </head>
    <body>
    <div id="app">
        <detailed :item="{{ $item }}" :images="{{ $images }}" :full="{{ $full }}"></detailed>
    </div>
</body>
</html>
<link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
<script src="https://api-maps.yandex.ru/2.0-stable/?apikey=123&load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript" src="{{ mix('js/app.js') }}"></script>
