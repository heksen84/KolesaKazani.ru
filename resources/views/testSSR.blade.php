<!DOCTYPE html>
<html lang="ru">
<head>
  <title>Доска объявлений Дамеля - все объявления Казахстана.</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">
</head>
<body>

<div id="navbar_menu">
  <nav class="navbar navbar-dark bg-primary">
  <a class="navbar-brand" href="#"><h1 style="font-size:30px;font-weight:600">Дамеля</h1><h2 style="font-size:16px;margin-top:-5px;font-weight:500">все объявления Казахстана</h2></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="/podat-obyavlenie">Подать объявления <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/home">Мои объявления</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/login">Вход</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/register">Регистрация</a>
      </li>      
    </ul>
  </div>
 </nav>
</div>

<div class="container-fluid mycontainer" id="index_page" style="margin-top:10px">

<div class="row">
  <div style="margin:auto" id="login_register_col">
    <a href="/login"><div class="button" id="button_login" style="margin-left:17px">Вход</div></a>
    <a href="/register"><div class="button" id="button_reg">Регистрация</div></a>          
  </div>     
</div>

<div class="row" style="margin-top:2px">
 <div class="col-sm-12 col-md-12 col-lg-3 col-xl-3" style="text-align:center">      
   <div id="logo_block">
     <div id="logo_block_text">Дамеля</div>
     <div style="font-size:16px;color:yellow;margin-top:-13px;letter-spacing:1px;">все объявления Казахстана</div>
   </div>
</div>

<div class="col-sm-12 col-md-12 col-lg-12 col-xl-6" style="text-align:center">
  
<form>
  <input type="text" id="search_string" placeholder="поиск по объявлениям" required/>
  <button id="button_search" type="submit" title="Найти что требуется">найти</button>
</form>

<!-- кнопки выбора региона и т.п.-->
<div class="index_select_region_and_other_button_block" id="select_location_desktop">
   <button class="search_options_button btn btn-light btn-sm">Расположение</button>          
</div>

</div>

<div class="col-sm-12 col-md-12 col-lg-3 col-xl-3" style="text-align:center" title="Подать новое объявление" id="new_advert_col">
  <a href="/podat-obyavlenie"><div id="new_advert_block">Подать объявление</div></a>    
</div>    

</div>  

<div id="categories_line">
  <div style="text-align:center">    
    <div id="categories_title" class="shadow_text" style="margin-bottom:18px">категории</div>
    <button style="border:1px solid white;font-size:14px" id="close_subcats_btn" class="btn-sm btn-primary hide">&#8634; Вернуться к категориям</button>
	    <div id="categories" class="form-inline">
       		 @foreach($categories as $category)
        	 <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 col_item">          	   
		          <a href="/{{ $category['url'] }}"><div class="category_item">{{ $category["name"] }}</div></a>
        	 </div>
        	@endforeach
	    </div>

	    <div id="subcategories" class="form-inline" style="text-align:center">      
      <br>
        @foreach($subcategories as $subcategory)
          <div class="col-sm-12 col-md-12 col-lg-12 col-xl-3 hide" data-id="{{ $subcategory['category_id'] }}">
            <a href="/{{ $subcategory['url'] }}"><div class="category_item" style="width:280px;font-size:17px">{{ $subcategory["name"] }}</div></a>
          </div>
        @endforeach
      </div>
    </div>
  </div> 

<!-- РЕКЛАМА -->
<div class="row" style="margin-top:20px">
  <h5 style="margin:auto">Google Advert</h5>
</div>

<div class="row" style="margin-top:40px">
  <div id="footer"><a href="/advertisers" class="underline_link">Реклама</a> | <a href="/rules" class="underline_link">Правила сайта</a> | <a href="/about" class="underline_link">О сайте</a></div>
</div>

</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ mix('js/index.js') }}"></script>

</body>
</html>