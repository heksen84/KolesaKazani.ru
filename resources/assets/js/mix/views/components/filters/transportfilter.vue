<template>
<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">  
	От: <input type="text" placeholder="0"/>
	До: <input type="text" placeholder="0"/>
	<button class="btn btn-primary btn-sm" @click="helloWorld">применить</button>
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
		alert("hello bro!")
	}
}

}
</script>