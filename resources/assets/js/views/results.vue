<template>
	<b-container fluid>
		<b-row>
			<b-col cols="12" sm="12" md="9" lg="3" xl="3" style="text-align:center;margin:auto;margin-top:40px;color:grey">
				<h1 style="color:white">результаты</h1>
			</b-col>
		</b-row>

	<b-row style="margin-top:20px">
		<b-col cols="12" sm="12" md="7" lg="7" xl="7" style="margin:auto;margin-top:2px;color:grey" v-for="item in items" :key="item.id">
			<div style="height:200px;color:grey;background:white;margin-bottom:3px;border-radius:3px" :id="item.id">
				<!--<h3>{{ item.name }}</h3>-->
				<!--<h6>{{ item.text }}</h6>
				<button @click="details">подробнее</button>
				<h5><b>{{ item.price }}</b></h5>-->
			</div>
		</b-col>
	</b-row>
	
</b-container>
</template>
<script>
export default {
	props: ["items"],
	data () {
    return 	{
   	  slide: 0,
      sliding: null
    }
	},
	created() {
	},
	components: { },
  		methods: {
    		details(event) {
    			console.log(event);
    			 window.location='/details/'+event.target.parentNode.id;
    			 
    		}
	}
}
</script>
