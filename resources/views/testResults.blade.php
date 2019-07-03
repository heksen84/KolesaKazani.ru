<!-- Ilya Bobkov Aksu 2018(R) -->
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
  <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
</head>
<body>
<div id="app">
	
  @foreach ( json_decode($results, true) as $item)
    <h2>{{ $item["title"] }}</h2>
  @endforeach
  
</div>
</body>
</html>
<script type="text/javascript" src="{{ mix('js/results.js') }}"></script>
