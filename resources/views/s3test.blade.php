<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="Правила сайта" />
  <meta name="description" content="Правила сайта">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Amazon S3 test</title>
  <link rel="icon" href="{{ asset('public/shop.ico') }}">
</head>
<body>
  <h1>Amazon S3 test</h1>
  <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
    @csrf
      <input type="file" name="file"><input>
      <input type="submit" name="file"><input>
  </form>
</body>
</html>