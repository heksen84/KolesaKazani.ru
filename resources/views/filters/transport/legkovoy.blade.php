
<form style="background:rgb(200,255,200)">  
			
	
	<!-- сделать на чистом js -->
	<div class="form-group mx-1" style="width:200px">
    <label for="exampleFormControlSelect1">Марка</label>
    <select class="form-control form-control-sm" id="exampleFormControlSelect1">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  	</div>

	<div class="form-group mx-1" style="width:200px">
    <label for="exampleFormControlSelect2">Модель</label>
    <select class="form-control form-control-sm" id="exampleFormControlSelect2">
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <option>4</option>
      <option>5</option>
    </select>
  	</div>

	<div class="form-group mx-1">
		 <label for="year" class="sr-only">Год выпуска</label>
		<input type="text" id="endPrice" class="form-control form-control-sm" style="width:100px" placeholder="Год выпуска" required/>
	</div>
	<div class="form-group mx-1">
		<label for="startPrice" class="sr-only">От</label>
		<input type="text" id="startPrice" class="form-control form-control-sm" style="width:100px" placeholder="от" required/>
	</div>
	 <div class="form-group mx-1">
		 <label for="endPrice" class="sr-only">До</label>
		<input type="text" id="endPrice" class="form-control form-control-sm" style="width:100px" placeholder="до" required/>
	</div>

	<div class="form-group mx-1">
		<button type="submit" class="btn btn-sm btn-primary">применить</button>
	</div>
</form>