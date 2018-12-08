<template>
	<b-container fluid class="mycontainer">		
		<b-row>
			<b-col cols="12" sm="12" md="10" lg="10" xl="10" class="result_info_col">
				<div class="close_button shadow_text" title="Закрыть страницу" @click="closeAndReturn" style="color:white;border:1px solid white;padding:5px">X</div>
				<h1 class="shadow_text title_text">{{ count  }} {{ count_string }} </h1>
			</b-col>
		</b-row>
	<br>

	<b-row v-if="count>1">
		<b-col cols="12" sm="12" md="2" lg="2" xl="2"></b-col>

		<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select v-model="filters.price" :options="options_price" class="mb-3" @change="getSearchData"/>
		</b-col>

		<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select v-model="filters.sdelka" :options="options_sdelka" class="mb-3" @change="getSearchData"/>
		</b-col>

		<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  	<b-form-select v-model="filters.location" :options="options_location" class="mb-3" @change="getSearchData"/>
		</b-col>

		<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		 	<b-form-select v-model="filters.actual" :options="options_actual" class="mb-3" @change="getSearchData"/>
		</b-col>
	</b-row>

	<!-- VIP BLOCK -->
	<div class="vip_block">
		<h3 v-for="(i, index) in results" :key="index" style="height:340px;border:1px solid white;text-align:center"></h3>
	</div>

	<div class="text-center">
		<b-row>
			<b-col cols="12" sm="12" md="2" lg="2" xl="2">VIP</b-col>
			<b-col cols="12" sm="12" md="8" lg="8" xl="8">
				<item v-for="(item,index) in results" :key="index" :id="item.advert_id" :title="item.mark" :text="item.model" :price="item.price" :year="item.year" :images="images"></item>
			</b-col>
			<b-col cols="12" sm="12" md="2" lg="2" xl="2">VIP</b-col>	
		</b-row>

		<b-row v-if="count>1">
			<b-col cols="12" sm="12" md="12" lg="12" xl="12" style="text-align:center">
				<b-button variant="primary" style="margin:10px" @click="loadMore">загрузить ещё</b-button>
			</b-col>
		</b-row>
	</div>

</b-container>
</template>
<script>

// ------------------------------
// функция склонений слов
// ------------------------------
function num2str(n, text_forms) {
    n = Math.abs(n) % 100;
    var n1 = n % 10;
    if (n > 10 && n < 20) return text_forms[2];   
    if (n1 > 1 && n1 < 5) return text_forms[1];
    if (n1 == 1) return text_forms[0];
    return text_forms[2];
}

// ------------------------------------
// импорт
// ------------------------------------
import item from "../components/item"
import { get } from "./../helpers/api"

export default {

	props: ["data", "images", "results"],

	data () {
    return 	{
    		items: this.data,
    		count: 0,
    		count_string: "",
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
        { value: '4', text: 'Отдам даром' },
        { value: '5', text: 'Сдача в аренду' }
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
		this.update();

		console.log(this.results)
	},
	components: { item },
  		methods: {
			closeAndReturn() {
 			  window.history.back();
  			},
  			update() {
  				this.count = Object.keys(this.results).length;
				this.count_string = num2str(this.count, ['объявление', 'объявления', 'объявлений']);
  			},
  			getSearchData() {
  				console.log(this.filters);
  				get('/getSearchData', { "data": this.filters } ).then((res) => {
  					console.log(res.data);
						this.items=res.data;
						this.update();
					}).catch((err) => {});
    		},
    		loadMore() {
    			this.getSearchData();
    		}
	}
}
</script>
<style></style>
