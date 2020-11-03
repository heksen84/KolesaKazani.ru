<div class="row">

 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
  <p>Тип строения: <span class="text">{{ $advert->type_of_building }}</span></p>
 </div>
  
 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
   <p>Кол-во комнат: <span class="text">{{ $advert->rooms }}</span></p>
 </div>
 
 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
   <p>Площадь: <span class="text">{{ $advert->area }}м²</span></p>
 </div>

 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
   <p>Право собственности: <span class="text">{{ $advert->ownership }}</span></p>
 </div>

 <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
  <p>Вид объекта: <span class="text">{{ $advert->kind_of_object }}</span></p>
 </div>

</div>