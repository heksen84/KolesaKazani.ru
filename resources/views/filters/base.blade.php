@if ($region && !$city)
	<form id="filters-form" action="/{{$region}}/c/{{$category}}/{{$subcategory}}">
@elseif ($region && $city)
	<form id="filters-form" action="/{{$region}}/{{$city}}/c/{{$category}}/{{$subcategory}}">
@else
	<form id="filters-form" action="/c/{{$category}}/{{$subcategory}}">
@endif		
	
	<div class="m-2 form-row">
		<label for="price_ot" class="m-1">Цена:</label>
		<input type="number" placeholder="от" id="price_ot" class="form-control form-control-sm col-3 col-md-1 ml-1" name="price_ot" value="{{$price_ot}}" required/>	
		<input type="number" placeholder="до" id="price_do" class="form-control form-control-sm col-3 col-md-1 ml-1" name="price_do" value="{{$price_do}}" required/>	
		<button type="submit" class="btn btn-sm btn-success ml-1">применить</button>						 
	</div>

</form>