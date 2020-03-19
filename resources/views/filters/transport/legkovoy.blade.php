<form style="background:rgb(200,255,200)">

	<div class="row p-2">
		<div class="col-10 col-sm-10 col-md-6 col-lg-3 col-xl-3">
			<div class="form-group mx-1">
    			<label for="mark">Марка</label>
    				<select class="form-control form-control-sm" id="mark">
      					<option>audi</option>
    				</select>
  			</div> 
		</div>

	<div class="col-10 col-sm-10 col-md-6 col-lg-3 col-xl-3">
		<div class="form-group mx-1">
    		<label for="model">Модель</label>
    			<select class="form-control form-control-sm" id="model">
      				<option>100</option>
    			</select>
  			</div> 
		</div>

		<div class="col-5 col-sm-5 col-md-5 col-lg-2 col-xl-2">
			<div class="form-group mx-1">
		 		<label for="year">Год выпуска</label>
				<input type="number" id="year" class="form-control form-control-sm" required/>
			</div>
		</div>
		

		<div class="col-12 col-sm-12 col-md-6 col-lg-2 col-xl-2">
			<div class="form-group mx-1">
		 		<label for="price_ot">Цена от</label>
				<input type="number" id="price_ot" class="form-control form-control-sm" required/>
			</div>
		</div>

		<div class="col-12 col-sm-6 col-md-6 col-lg-2 col-xl-2 mb-2">
			<div class="form-group mx-1">
		 		<label for="price_do">Цена до</label>
				<input type="number" id="price_do" class="form-control form-control-sm" required/>
			</div>
		</div>

		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mb-12 text-center">
			<div class="form-group">
				<button type="submit" class="btn btn-sm btn-primary">применить</button>
			</div>
		</div>
</div>
			
</form>