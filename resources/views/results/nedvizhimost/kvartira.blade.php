<div class="row">

<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
  <p>Этаж: <b>{{ $advert->floor }}</b></p>
 </div>
 
 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
  <p>Кол-во этажей в доме: <b>{{ $advert->floors_house }}</b></p>
 </div>
 
 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
   <p>Кол-во комнат: <b>{{ $advert->rooms }}</b></p>
 </div>
 
 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
   <p>Площадь: <b>{{ $advert->area }}</b></p>
 </div>

 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
   <p>Право собственности: <b>{{ $advert->ownership }}</b></p>
 </div>

 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
  <p>Вид объекта: <b>{{ $advert->kind_of_object }}</b></p>
 </div>

</div>