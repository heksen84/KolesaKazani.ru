<template>
<form class="form-inline" @submit="onSubmit">  	
	<div class="form-group mx-1">
		Цена:
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
		<button type="submit" class="btn btn-sm btn-warning">применить</button>
	</div>
 </form>
</template>

<script>
export default {  

props: 
[
	"region", 
	"city", 
	"category", 
	"subcategory", 
	"country", 
	"lang", 
	"page", 
	"startPrice", 
	"endPrice"
],

data () {
    return 	{}
  },
  
  created() {},
  
  methods: {
	
	onSubmit(evt) {
		evt.preventDefault();
		window.location="/"
  	}

}

}
</script>