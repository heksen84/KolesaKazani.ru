@if ($region && !$city)
	<form id="filters-form" action="/{{$region}}/c/{{$category}}/{{$subcategory}}">
@elseif ($region && $city)
	<form id="filters-form" action="/{{$region}}/{{$city}}/c/{{$category}}/{{$subcategory}}">
@else
	<form id="filters-form" action="/c/{{$category}}/{{$subcategory}}">
@endif
</form>