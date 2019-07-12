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
  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
</head>
<body>
<div id="app">
  
  <div class="close_button shadow_text" id="results_close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>

  <div class="container-fluid mycontainer" style="margin-top:40px">

    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 margin-auto text-center">      
        <h1 class="shadow_text" style="font-size:24px">{{ $title }}</h1>
        <h2 class="shadow_text deferred">
          Найдено: 
          <span v-show="!showItems">{{ $total_records }}</span>
          <span v-show="showItems" class="shadow_text" id="totalRecords">${ totalRecords }</span>
        </h2>        
      </div>      
  </div>

  <items :items="data" v-show="showItems"></items>

  <div id="defaultItems">
    @foreach (json_decode($results, true) as $item)
    <div class="row">    
      <div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2"></div>
      <div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-8">      
        <div class="item">                            
        <img src="/storage/app/images/{{ $item['image']}}" width="140" height="140" loading="auto" style="display:inline-block"/>          
          <span style="position:absolute;top:10px;margin-left:5px;vertical-align:top;font-size:20px;width:600px">
            {{ $item["title"] }}
            <div style="font-size:18px">цена: {{ $item["price"] }} тнг.</div>
          </span>          
        </div>
    </div>
    </div>    
    @endforeach
  </div>  

  @if ($total_records>3)
  <br>
  <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 margin-auto">
      <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
          <li class="page-item">          
          <a class="page-link blue" href="#" data-page="prev" @click="changePage($event, {{ $total_records}})">Назад</a>
          </li>            
            <li v-for="(i,index) in Math.round({{ $total_records }}/4)" :key="index" class="page-item">
              <a class="page-link blue pageNum" href="#" :data-page=i @click="changePage($event, {{ $total_records}})">${i}</a>
            </li>          
          <li class="page-item">
            <a class="page-link blue" href="#" data-page="next" @click="changePage($event, {{ $total_records}})">Вперёд</a>
          </li>
        </ul>
      </nav>        
    </div>
  </div>
  @endif
    
  </div>
</div>
</body>
</html>
<script type="text/javascript" src="{{ mix('js/results.js') }}"></script>
