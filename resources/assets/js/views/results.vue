<template>
	<b-container fluid>
		<b-row>
			<b-col cols="12" sm="12" md="9" lg="3" xl="3" style="text-align:center;margin:auto;margin-top:40px;color:grey">
			<h3 class="shadow_text">найдено: {{ count  }}</h3>
			</b-col>
		</b-row>
	<br>
	<b-row v-if="count>0">

	<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select v-model="selected" :options="options" class="mb-3" size="sm" />
			<!--Сортировка: все, покупка, продажа, обмен. Цена: по возрастанию, убыванию-->
	</b-col>

	<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select v-model="selected" :options="options" class="mb-3" size="sm" />
			<!--Сортировка: все, покупка, продажа, обмен. Цена: по возрастанию, убыванию-->
	</b-col>


	</b-row>
	<b-row style="margin-top:5px" v-for="item in items" :key="item">
		
		<b-col cols="12" sm="12" md="2" lg="2" xl="2">
			<!--<item :id="item.id" :name="item.name"></item>-->


			<carousel :perPage=1 :paginationEnabled="false">
  			<slide>
     			<!--<b-img src="https://picsum.photos/250/250/?image=54" :height="200" :width="200"/>-->
     			img
  			</slide>
			</carousel>

		</b-col>

		<b-col cols="12" sm="12" md="8" lg="8" xl="8">
			<item :id="item.id" :title="item.title" :text="item.text" :price="item.price"></item>
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
    	count: 0,
   	  	slide: 0,
      	sliding: null,
      	selected: null,
      options: [
        { value: null, text: '-- Цена --' },
        { value: 'a', text: 'Цена по возрастанию' },
        { value: 'b', text: 'Цена по убыванию' },
      ]
    }
	},
	created() {
		this.count = Object.keys(this.items).length;
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
