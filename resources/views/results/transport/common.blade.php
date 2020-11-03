<div class="row">
    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"><hr></div>

    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
        <p>Год выпуска: <span class="text">{{ $advert->year }} г.</span></p> 
    </div>

    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
        <p>Положение руля: <span class="text">{{ $advert->steering_position }}</span></p>
    </div>

    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
        <p>Пробег: <span class="text">{{ $advert->mileage }} км.</span></p>
    </div>

    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
        <p>Тип двигателя: <span class="text">{{ $advert->engine_type }}</span></p>
    </div>

    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4">
        <p>Растоможен: <span class="text">{{ $advert->customs }}</span></p>
    </div>

    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12"><hr></div>
</div>