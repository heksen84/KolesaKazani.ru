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
  <link rel="stylesheet" type="text/css" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/results.css') }}">
</head>
<body>
<div id="app">
  <div class="container-fluid container1">
    <hr>
      <h1 style="color:rgb(50,50,50)">{{ $title }}</h1>
        <div style="color:rgb(50,50,50);text-decoration:underline">Найдено: {{ $itemsCount }}</div>
          подкатегория: <b>{{ $subcategory[0]->id }}</b>          
        <form>
        <br>
            <div class="form-group">
              <div class="row">                     
              @if ($itemsCount>0)
                @if ($subcategory[0]->id==1)

              <div class="col-10 col-sm-10 col-md-3 col-lg-3 col-xl-3">                
                  <label>Марка:</label>
                  <select name="select" class="form-control">
                    <option value="null">Выберите марку</option>              
                    @foreach($car_marks as $item)          
                      <option value={{ $item->id_car_mark }}>{{ $item->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-10 col-sm-10 col-md-3 col-lg-3 col-xl-3">
                  <label>Модель:</label>
                    <select name="select" class="form-control">
                      <option value="null">Выберите модель</option> 
                    </select>
                </div> 
              
                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                  <label>Цена</label>
                    <input type="text" size="10" required class="form-control" placeholder="от" v-model="priceFrom"></input> 
                </div>

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                  <label>-</label>
                    <input type="text" size="10" required class="form-control" placeholder="до" v-model="priceTo"></input> 
                </div>                            

                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                  <button type="button" class="btn btn-secondary form-control" @click="filter">применить</button>
                </div>          

              </div> <!-- end row -->                      
                @endif
              @endif
              <div class="row">Рекламка?</div>
            </div>                                            
          </form>          
        <hr>

    <div class="row">
      @if ($itemsCount>0)
        @foreach($items as $item)
          <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-3">
            <div class="card text-left">
              <!--<img src="..." class="card-img-top" alt="картинка">-->
              <div class="card-body">          
              @if ($subcategory[0]->id==1)
                <h5 class="card-title">{{ $item->deal_name_2 }} {{  $item->name }} {{  $item->name_rus }}</h5>
                <div style="font-size:12px;color:grey">Размещено {{ $item->created_at }}</div>
                  <p class="card-text">Детали</p>
                  <a href="#" class="btn btn-secondary btn-sm">Подробнее</a>
                </div>
              @endif
            </div>
          </div>
          @endforeach
        @endif
      </div>   

  <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
    <br>    
    <ul class="pagination justify-content-center">
      <li class="page-item disabled">
        <span class="page-link">Назад</span>
      </li>
      <li class="page-item"><a class="page-link" href="#">1</a></li>
      <li class="page-item active">
        <span class="page-link">
          2
          <span class="sr-only">(current)</span>
        </span>
      </li>
      <li class="page-item"><a class="page-link" href="#">3</a></li>
      <li class="page-item">
        <a class="page-link" href="#">Вперёд</a>
      </li>
    </ul>
  </div>

  </div>  
</div>
<!-- http://flix:90/transport/legkovoy-avtomobil?price_from=0&price_to=999999&car_mark=10&car_model=199&role=-->
<script type="text/javascript" src="{{ mix('js/results.js') }}"></script>
</body>
</html>