
@if ($region && !$city)
	<form style="background:rgb(220,250,220);border:1px solid rgb(150,250,150)" action="/{{$region}}/c/{{$category}}/{{$subcategory}}">
@elseif ($region && $city)
	<form style="background:rgb(220,250,220);border:1px solid rgb(150,250,150)" action="/{{$region}}/{{$city}}/c/{{$category}}/{{$subcategory}}">
@else
	<form style="background:rgb(220,250,220);border:1px solid rgb(150,250,150)" action="/c/{{$category}}/{{$subcategory}}">
@endif

	<div class="row p-3">
		<div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
			<div class="form-group mx-1">
    			<label for="mark">Марка</label>
    				<select class="form-control form-control-sm" id="mark" name="mark">
						  <option>audi</option>
						  <option>bmw</option>
    				</select>
  			</div> 
		</div>

	<div class="col-12 col-sm-12 col-md-6 col-lg-3 col-xl-3">
		<div class="form-group mx-1">
    		<label for="model">Модель</label>
    			<select class="form-control form-control-sm" id="model" name="model">
      				<option>100</option>
    			</select>
  			</div> 
		</div>

		<div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2">
			<div class="form-group mx-1">
		 		<label for="year">Год</label>
				<input type="number" id="year" class="form-control form-control-sm" name="year" value="{{$year}}"/>
			</div>
		</div>
		

		<div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2">
			<div class="form-group mx-1">
		 		<label for="price_ot">Цена от</label>
				<input type="number" id="price_ot" class="form-control form-control-sm" name="price_ot" value="{{$price_ot}}" />
			</div>
		</div>

		<div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2">
			<div class="form-group mx-1">
		 		<label for="price_do">Цена до</label>
				<input type="number" id="price_do" class="form-control form-control-sm" name="price_do" value="{{$price_do}}" />
			</div>
		</div>

		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
			<div class="mx-1">
				<button type="submit" class="btn btn-sm btn-success">применить</button>
			</div>
		</div>
</div>
			
</form>