<template>
<form class="form-inline" @submit="onSubmit">  	
	<div class="form-group mx-1">
		Цена:
	</div>
	<div class="form-group mx-1">
		<label for="startPrice" class="sr-only">От</label>
		<input type="text" id="startPrice" v-model="start_price" class="form-control form-control-sm" style="width:100px" placeholder="от" required/>
	</div>
	 <div class="form-group mx-1">
		 <label for="endPrice" class="sr-only">До</label>
		<input type="text" id="endPrice" v-model="end_price" class="form-control form-control-sm" style="width:100px" placeholder="до" required/>
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
	"start_price", 
	"end_price"
],

data () { return {


	
} },
  
created() {

	console.log("region: "+this.region);
    console.log("city: "+this.city);
	console.log("category: "+this.category);
    console.log("subcategory: "+this.subcategory);
    console.log("country: "+this.country);
    console.log("lang: "+this.lang);
	console.log("page:" +this.page);
	console.log("start_price: "+this.startprice);
	console.log("end_price: "+this.endprice);

},
  
methods: {
	
	onSubmit(evt) {
		
		evt.preventDefault();
		
		window.location=
		"/category/"+this.category+
		"/"+this.subcategory+
		"?country="+
		this.country+
		"&lang="+this.lang+
		"&page=1&start_price="+
		this.start_price+
		"&end_price="+
		this.end_price;

  	}

}

}
</script>