<!DOCTYPE html>
<html lang="ru">
<head>
  <title>TestNoSSR</title>
</head>
<style>
  body { display: none; }
</style>
<body>
  <!-- Верхнее меню -->
  <div id="navbar_menu">12312</div>
  <br>
  <div class="container-fluid mycontainer" id="index_page">
    <div class="row">
      <div class="col-md-12">
      <h1>Дамеля</h1>
      <div id="categories_line">
        @foreach($data as $item)
          <a href="/{{ $item['url'] }}"><div class="category_item" @click="showSubcats($event, $item['id'])">{{ $item["name"] }}</div></a>
        @endforeach
        </div>
      </div>
    </div>
  </div>
</body>
</html>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">