@if ($region && !$city)
	<form id="filters-form" action="/{{$region}}/c/{{$category}}/{{$subcategory}}">
@elseif ($region && $city)
	<form id="filters-form" action="/{{$region}}/{{$city}}/c/{{$category}}/{{$subcategory}}">
@else
	<form id="filters-form" action="/c/{{$category}}/{{$subcategory}}">
@endif	
	<div class="form-row m-1 mt-2">
		<div class="form-group col-4 col-sm-3 col-md-2 col-xl-2">
      		<label>Цена:</label>
			<input type="number" placeholder="от" id="price_ot" class="form-control form-control-sm" name="price_ot" value="{{ $filters['price_ot'] }}" required/>			
		</div>													
</form>