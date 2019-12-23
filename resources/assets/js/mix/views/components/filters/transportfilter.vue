<template>
<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12" style="margin:20px">
<form>  
	<input type="text" class="form-control" placeholder="0" style="width:100px" required/>
	<input type="text" class="form-control" placeholder="0" style="width:100px" required/>
	<button type="submit" class="btn btn-primary btn-sm">применить</button>
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