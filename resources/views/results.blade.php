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
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>

<div id="app">
  <div class="container-fluid">
  @foreach($items as $item)
  <div class="row">
    <div class="col col-sm-12 col-md-6 col-lg-6 col-xl-6 item" style="margin:auto">
    {{  $item->deal_name_2 }}, {{  $item->category_id }}, {{  $item->price }}  
    </div>
   </div>
  @endforeach
  </div>

</div>

</body>
</html>