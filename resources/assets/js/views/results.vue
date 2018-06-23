<template>
	<b-container fluid>
		<b-row>
			<b-col cols="12" sm="12" md="10" lg="10" xl="10" style="text-align:left;margin:auto;margin-top:40px;color:grey">
			<h4 class="shadow_text">найдено: {{ count  }}</h4>
			</b-col>
		</b-row>
	<br>
	<b-row v-if="count>1">

	<b-col cols="12" sm="12" md="2" lg="2" xl="2"></b-col>

	<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select v-model="filters.price" :options="options_price" class="mb-3" size="sm" @change="getSearchData"/>
	</b-col>

	<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select v-model="filters.sdelka" :options="options_sdelka" class="mb-3" size="sm" @change="getSearchData"/>
	</b-col>

	<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select v-model="filters.location" :options="options_location" class="mb-3" size="sm" @change="getSearchData"/>
	</b-col>

	<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select v-model="filters.actual" :options="options_actual" class="mb-3" size="sm" @change="getSearchData"/>
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
import { get } from './../helpers/api'
export default {
	props: ["data"],
	data () {
    return 	{
    	items: this.data,
    	count: 0,
   	  	slide: 0,
      	sliding: null,

      	filters: {
      		price: null,
      		sdelka: null,
      		actual: null,
      		location: null
      },

      options_price: [
        { value: null, text: '-- Цена --' },
        { value: '0', text: 'Цена по возрастанию' },
        { value: '1', text: 'Цена по убыванию' },
      ],

       options_sdelka: [
        { value: null, text: '-- Вид сделки --' },
        { value: '0', text: 'Покупка' },
        { value: '1', text: 'Продажа' },
        { value: '2', text: 'Обмен' },
        { value: '3', text: 'Частичный обмен' },
        { value: '4', text: 'Отдам' },
      ],

        options_actual: [
        { value: null, text: '-- Актуальность --' },
        { value: '0', text: 'Сначала новые' },
        { value: '1', text: 'Сначала старые' },
      ],

        options_location: [
        { value: null, text: '-- Расположение --' },
        { value: '0', text: 'Рядом со мной' },
        { value: '1', text: 'Любое расстояние' },
      ]

    }
	},
	created() {
		this.count = Object.keys(this.items).length;
	},
	components: { item },
  		methods: {
  			getSearchData() {
  				get('/getSearchData', { "data": this.filters }).then((res) => {
					this.items=res.data;
				}).catch((err) => {});
    		}
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
