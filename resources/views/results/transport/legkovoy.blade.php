<div class="row">
 
<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-4">
  <p>Марка: <b>{{ $advert->car_name }}</b></p>
 </div>
 
 <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-4">
  <p>Модель: <b>{{ $advert->car_model }}</b></p>
 </div>
 
 <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-4">
   <p>Год выпуска: <b>{{ $advert->year }} г.</b></p>
 </div>
 
 <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-4">
   <p>Положение руля: <b>{{ $advert->steering_position }}</b></p>
 </div>

 <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-4">
   <p>Пробег: <b>{{ $advert->mileage }} км.</b></p>
 </div>

 <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-4">
  <p>Тип двигателя: <b>{{ $advert->engine_type }}</b></p>
 </div>

 <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-4">
  <p>Растоможен: <b>{{ $advert->customs }}</b></p>
 </div>
</div>