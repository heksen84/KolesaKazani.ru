<!--@if ($region && !$city)
	<form id="filters-form" action="/{{$region}}/c/{{$category}}/{{$subcategory}}">
@elseif ($region && $city)
	<form id="filters-form" action="/{{$region}}/{{$city}}/c/{{$category}}/{{$subcategory}}">
@else
	<form id="filters-form" action="/c/{{$category}}/{{$subcategory}}">
@endif	
	<div class="form-row m-1 mt-2">
		<div class="form-group col-4 col-sm-3 col-md-2 col-xl-2">
      		<label>Цена:</label>
			<input type="number" placeholder="от" id="price_ot" class="form-control form-control-sm" name="price_ot" value="{{$filters['price_ot']}}" required/>			
		</div>

		<div class="form-group col-4 col-sm-3 col-md-2 col-xl-2">
			<label>&nbsp;</label>
			<input type="number" placeholder="до" id="price_do" class="form-control form-control-sm" name="price_do" value="{{$filters['price_do']}}" required/>	
		</div>

		<div class="form-group col-7 col-sm-5 col-md-3 col-xl-3">
			<label>Сортировка</label>
			<select class="form-control form-control-sm">
				<option>по возрастанию</option>
				<option>по убыванию</option>
			</select>			
		</div>																
	</div>	

	<div class="form-row">
		<div class="form-group col-12 text-center">
			<button type="submit" class="btn btn-sm btn-primary" title="Применить фильтр">применить</button>
		</div>												
	</div>														
</form>-->