<template>
<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin:20px">
<form class="form-inline">  
	<div class="form-group mx-sm-1 mb-2">		
		<input type="text" class="form-control" placeholder="0" style="width:100px" required/>
	</div>
	 <div class="form-group mx-sm-1 mb-2">
		<input type="text" class="form-control" placeholder="0" style="width:100px" required/>
	</div>
	<div class="form-group mx-sm-1 mb-2">
		<button type="submit" class="btn btn-secondary">применить</button>
	</div>
 </form>
 </div> 
</template>

<script>
export default {  

props: [
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
	helloWorld() {
	//	alert("hello bro!")
	}
}

}
</script>