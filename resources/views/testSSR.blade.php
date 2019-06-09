<!DOCTYPE html>
<html lang="ru">
<head>
  <title>TestSSR</title>
</head>
<body>

<h1>Дамеля</h1>
@foreach($categories as $item)
 <div class="category_item" @click="test">{{ $item["name"] }}</div>
@endforeach
	    
</body>
</html>

<link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">