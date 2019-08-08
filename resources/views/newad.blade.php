<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <title>{{ $title }}</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
  <div id="app">
   <div class="container-fluid mycontainer_adv">
    <div class="row">
     <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 create_advert_col">
	    <div class="close_button" title="Закрыть страницу" style="font-weight:bold" @click="closeAndReturn">X</div>
	      <h1 class="title_text" style="margin-top:12px">подать объявление</h1>
	      <hr>

        <div class="spinner-grow text-primary" role="status">
          <span class="sr-only">Ожидайте...</span>
        </div>

        <div class="form-group hide" style="width:260px">
          <label for="categories">Категория товара или услуги:</label>
            <select class="form-control">            
              <option selected>-- Выберите категорию --</option>
              <option v-for="item in {{ $categories }}">${item.name}</option>
              </select>
          </label>
        </div>

        <div class="form-group hide" style="width:260px" v-if="true">
          <label for="default_group" style="width:270px">Вид сделки:</label>
            <div v-for="(i,index) in {{ $dealtypes }}" :key="index">${i.deal_name_1}</div>
          </label>
        </div>

      </div>
    </div>
   </div>
  </div>
<script src="https://api-maps.yandex.ru/2.0-stable/?apikey=123&load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript" src="{{ mix('js/newad.js') }}"></script>
</body>
</html>