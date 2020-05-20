@if ($region && !$city)
	<form id="filters-form" action="/{{$region}}/c/{{$category}}/{{$subcategory}}">
@elseif ($region && $city)
	<form id="filters-form" action="/{{$region}}/{{$city}}/c/{{$category}}/{{$subcategory}}">
@else
	<form id="filters-form" action="/c/{{$category}}/{{$subcategory}}">
@endif	
	<div class="m-2 form-row mt-3">
		<div class="form-group col-6 col-sm-3 col-md-2 col-xl-2">
      		<label for="validationCustom01">Цена:</label>
			<input type="number" placeholder="от" id="price_ot" class="form-control form-control-sm" name="price_ot" value="{{$filters['price_ot']}}" required/>			
		</div>

		<div class="form-group col-6 col-sm-3 col-md-2 col-xl-2">
			<label for="validationCustom02">&nbsp;</label>
			<input type="number" placeholder="до" id="price_do" class="form-control form-control-sm" name="price_do" value="{{$filters['price_do']}}" required/>	
		</div>

		<div class="form-group col-12 col-sm-5 col-md-3 col-xl-3">
			<label for="validationCustom03">Сортировка</label>
			<select class="form-control form-control-sm">
				<option>по возрастанию</option>
				<option>по убыванию</option>
			</select>			
		</div>																
	</div>	

	<div class="form-row">
		<div class="form-group col-12 text-center">
			<button type="submit" class="btn btn-sm btn-success" id="btn-submit">применить</button>
		</div>												
	</div>												
		
</form>