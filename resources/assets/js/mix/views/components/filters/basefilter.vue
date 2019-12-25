<template>
  <div style="margin:10px">
	От: <input type="text" placeholder="0"/>
	До: <input type="text" placeholder="0"/>
	<button class="btn btn-sm" @click="helloWorld">применить</button>
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