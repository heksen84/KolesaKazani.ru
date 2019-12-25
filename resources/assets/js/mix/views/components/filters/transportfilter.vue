<template>
<form class="form-inline">  
	<div class="form-group mx-sm-1 mb-2">		
		<input type="text" class="form-control form-control-sm" placeholder="0" style="width:100px" required/>
	</div>
	 <div class="form-group mx-sm-1 mb-2">
		<input type="text" class="form-control form-control-sm" placeholder="0" style="width:100px" required/>
	</div>
	<div class="form-group mx-sm-1 mb-2">
		<button type="submit" class="btn btn-sm btn-warning">применить</button>
	</div>
 </form>
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