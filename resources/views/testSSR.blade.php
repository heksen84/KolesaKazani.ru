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
<div id="navbar_menu">
  <nav class="navbar navbar-dark bg-primary">
  <a class="navbar-brand" href="#"><h1>Дамеля</h1><h2 style="font-size:16px;margin-top:-5px;font-weight:500">все объявления Казахстана</h2></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="#">Подать объявления <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Мои объявления</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Вход</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Регистрация</a>
      </li>      
    </ul>
  </div>
</nav>
</div>
<br>
<div class="container-fluid mycontainer" id="index_page">
  <div class="row">
    <div class="col-md-12">
    <h1 id="logo_block">Дамеля</h1>
      <div id="categories_line">
        @foreach($data as $item)
          <a href="{{ $item['url'] }}"><div class="category_item" @click="showSubcats($event, $item['id'])">{{ $item["name"] }}</div></a>
        @endforeach
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

</body>
</html>