<template>
	<b-container fluid>
		<b-row>
			<b-col cols="12" sm="12" md="9" lg="3" xl="3" style="text-align:center;margin:auto;margin-top:40px;color:grey">
			<h1 class="shadow_text">результаты</h1>
			</b-col>
		</b-row>
	<br>
	<b-row style="margin-top:5px;border:1px solid grey;" v-for="item in items" :key="item">
		
		<b-col cols="12" sm="12" md="2" lg="2" xl="2" :key="item.id">
			<!--<item :id="item.id" :name="item.name"></item>-->


<carousel :perPage=1 :paginationEnabled="false">
  <slide v-for="i in 10" :key="i">
     <b-img src="https://picsum.photos/250/250/?image=54" fluid/>
  </slide>
</carousel>

		</b-col>

		<b-col cols="12" sm="12" md="8" lg="8" xl="8" :key="item.id">
			<item :id="item.id" :name="item.name" :text="item.text" :price="item.price"></item>
		</b-col>

	</b-row>
	
</b-container>
</template>
<script>
import item from "../components/item"
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
	components: { item },
  		methods: {
	}
}
</script>

<style>
.VueCarousel-slide {
  position: relative;
  color: #fff;
  font-family: Arial;
  font-size: 24px;
  text-align: center;
 
}
</style>
