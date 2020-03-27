@if ($region && !$city)
	<form id="filters-form" action="/{{$region}}/c/{{$category}}/{{$subcategory}}">
@elseif ($region && $city)
	<form id="filters-form" action="/{{$region}}/{{$city}}/c/{{$category}}/{{$subcategory}}">
@else
	<form id="filters-form" action="/c/{{$category}}/{{$subcategory}}">
@endif
		<div class="row p-2">

		<div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2">
			<div class="form-group mx-1">
		 		<label for="price_ot">Цена</label>
				<input type="number" placeholder="от" id="price_ot" class="form-control form-control-sm" name="price_ot" value="{{$price_ot}}" />
			</div>
		</div>

		<div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2">
			<div class="form-group mx-1">
		 		<label for="price_do">&nbsp;</label>
				<input type="number" placeholder="до" id="price_do" class="form-control form-control-sm" name="price_do" value="{{$price_do}}" />
			</div>
		</div>

		<!--<div class="col-12 col-sm-12 col-md-2 col-lg-2 col-xl-2 text-center">
			<div class="form-group mx-1">
				<button type="submit" class="btn btn-sm btn-success">применить</button>
			</div>
		</div>-->

		<div class="col-4 col-sm-4 col-md-4 col-lg-2 col-xl-2">
			<div class="form-group mx-1">
		 		<label>&nbsp;</label>
				<button type="submit" class="btn btn-sm btn-success form-control form-control-sm">применить</button>
			</div>
		</div>

	

	</div>
</form>