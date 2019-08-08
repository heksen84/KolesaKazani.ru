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
	      <h1 class="title_text" style="margin-top:12px">Новое объявление</h1>
	      <hr>
        
        <div id="loading" style="margin-bottom:10px">Подготовка...</div>

        <div class="form-group hide" style="width:260px">
          <label for="categories">Категория товара или услуги:</label>
            <select class="form-control" v-model="category" @change="changeCategory">            
              <option v-bind:value="null">-- Выберите категорию --</option>
              <option v-bind:value="item.id" v-for="item in {{ $categories }}">${item.name}</option>
              </select>
          </label>
        </div>

        <div v-if="category!=null" style="margin-bottom:10px" class="hide">
        <label style="width:270px">Вид сделки:</label>            
        <div class="form-check" style="width:260px">
            <div v-for="(item,index) in {{ $dealtypes }}" :key="index">
              <input class="form-check-input" :id="item.id" type="radio" name="inlineRadioOptions" v-bind:value="item.id" v-model="sdelka" @change="setDeal">
              <label class="form-check-label" :for="item.id">${item.deal_name_1}</label>
            </div>
        </div>
        </div>

        <form id="advertform" @submit="onSubmit">

          <!-- Категории -->
			    <div v-if="root"></div>
        
        </form>

      </div>
    </div>
   </div>
  </div>
<script src="https://api-maps.yandex.ru/2.0-stable/?apikey=123&load=package.standard&lang=ru-RU" type="text/javascript"></script>
<script type="text/javascript" src="{{ mix('js/newad.js') }}"></script>
</body>
</html>