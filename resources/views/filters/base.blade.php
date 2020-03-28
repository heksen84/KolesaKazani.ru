@if ($region && !$city)
	<form class="form-inline" id="filters-form" action="/{{$region}}/c/{{$category}}/{{$subcategory}}">
@elseif ($region && $city)
	<form class="form-inline" id="filters-form" action="/{{$region}}/{{$city}}/c/{{$category}}/{{$subcategory}}">
@else
	<form class="form-inline" id="filters-form" action="/c/{{$category}}/{{$subcategory}}">
@endif		
	
	<div class="m-1 form-row">
		<label for="price_ot" class="form-group m-1">Цена</label>
		<input type="number" placeholder="от" id="price_ot" class="form-control form-control-sm form-group col-3 col-md-3 m-1" name="price_ot" value="{{$price_ot}}" />	
		<input type="number" placeholder="до" id="price_do" class="form-control form-control-sm form-group col-3 col-md-3 m-1" name="price_do" value="{{$price_do}}" />	
		<button type="submit" class="btn btn-sm btn-success m-1 mx-1 mb-2">применить</button>						 
	</div>

</form>