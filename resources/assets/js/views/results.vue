<template>
	<b-container fluid class="mycontainer">		
		<b-row>
			<b-col cols="12" sm="12" md="10" lg="10" xl="10" class="result_info_col">
				<div class="close_button shadow_text" id="results_close_button" title="Закрыть страницу" @click="closeAndReturn" >X</div>
				<!--<h1 style="color:black;font-size:20px">{{ title }}</h1>-->
				<div class="shadow_text title_text">Найдено {{ count  }} {{ count_string }}</div>
			</b-col>
		</b-row>
	<br>
	
<!--	<b-row v-if="count>3">
			<b-col cols="12" sm="12" md="12" lg="12" xl="12" style="text-align:center">
				<b-button variant="success" style="margin:5px" size="sm" @click="showFilter">{{ filter_text }}</b-button>
			</b-col>
	</b-row>-->

	<!------------------------------------
	  общие фильтры
	 -------------------------------------->
	<!--<b-row v-if="count>1 && filter">				
		<b-col cols="12" sm="12" md="3" lg="3" xl="3"></b-col>
		<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select v-model="filters.price" :options="options_price" class="mb-1"/>
		</b-col>
		<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select v-model="filters.deal" :options="options_deal" class="mb-1"/>
		</b-col>
		<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		 	<b-form-select v-model="filters.actual" :options="options_actual" class="mb-1"/>			
		</b-col>		
	</b-row>-->

	<b-row>
		<b-col cols="12" sm="12" md="3" lg="3" xl="3"></b-col>
		<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select v-model="filters.deal" :options="options_deal" class="mb-2" size="sm"/>
		</b-col>
		<b-col cols="12" sm="12" md="1" lg="1" xl="1">			
		  <span class="shadow_text" style="font-weight:600">Цена:</span>
		</b-col>		
		<b-col cols="4" sm="4" md="2" lg="2" xl="1">			
		  <b-form-input v-model="filters.price_min" class="mb-1" placeholder="От" type="number" size="sm"/>			
		</b-col>		
		<b-col cols="4" sm="4" md="2" lg="2" xl="1">			
		  <b-form-input v-model="filters.price_max" class="mb-1" placeholder="До" type="number" size="sm"/>			
		</b-col>
		<b-col cols="2" sm="2" md="12" lg="2" xl="2" style="text-align:center">
				<b-button variant="warning" size="sm" class="mb-4" @click="updateData">Применить</b-button>
		</b-col>
	</b-row>

	<!-- Фильтр тачек -->
<!--	<b-row v-if="category==1 && count>1 && filter">
		<b-col cols="12" sm="12" md="3" lg="3" xl="3"></b-col>
				
		<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select :options="options_price" class="mb-1"/>
		</b-col>		
		
		<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select :options="options_price" class="mb-1"/>
		</b-col>		

		<b-col cols="12" sm="12" md="2" lg="2" xl="2">
		  <b-form-select :options="options_price" class="mb-1"/>
		</b-col>		
	</b-row>-->

	<!-- VIP BLOCK -->
	<div class="vip_block">
		<h3 v-for="(i, index) in results" :key="index" style="font-size:14px;height:340px;border:1px solid white;text-align:center">рекламка</h3>
	</div>

	<div class="text-center" style="margin-top:3px">
		<b-row>
			<b-col cols="12" sm="12" md="2" lg="2" xl="2">
				VIP
			</b-col>
			<b-col cols="12" sm="12" md="8" lg="8" xl="8">

				<!-------- КОМПОНЕНТ ITEM -------->				
				<item v-for="(item,index) in resultsClone" 													
					:created_at="item.created_at"
					:id="item.advert_id"					
					:category_id="item.category_id"					
					:image="item.image"
					:title="item.title" 				
					:price="item.price"					
					:deal="item.deal"
					:full="item.full"
					:vip="item.vip"
					:key="index">
				</item>
				<!------------------------------->
				
			</b-col>
			<!--<b-col cols="12" sm="12" md="2" lg="2" xl="2">VIP567</b-col>-->	
		</b-row>

		<!--<b-row v-if="count>loadMoreCountShow">
			<b-col cols="12" sm="12" md="12" lg="12" xl="12" style="text-align:center">
				<b-button variant="primary" style="margin:10px" @click="loadMore">загрузить ещё</b-button>
			</b-col>
		</b-row>-->
	</div>

	<div class="mt-3">
		<b-pagination v-model="currentPage" :total-rows="rows" align="center" @change="changePage"/>
	</div>

</b-container>


</template>
<script>

// -----------------------------------------------
// функция склонений слов
// -----------------------------------------------
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

	// Входящие данные
	props: ["category", "category_name", "subcat", "region", "place", "data", "results", "title"],

	components: { item },

	data () {		
	return 	{

		resultsClone: this.results,
		start_page: 0,
		rows: 100,
    currentPage: 1,
		loadMoreCountShow: 3,			
    items: this.data,
    count: 0,
    count_string: "",
   	slide: 0,
    sliding: null,
		filter: true,
		filter_text: "Скрыть фильтр",

		filters: {
			deal: null,
			price_min: null,
			price_max: null,
    },
    
		options_price: [
      { value: null, text: '-- Цена --' },
      { value: '0', text: 'Цена по возрастанию' },
      { value: '1', text: 'Цена по убыванию' },
    ],

    options_deal: [
      { value: null, text: '-- Вcе сделки --' },
      { value: '0', text: 'Покупка' },
      { value: '1', text: 'Продажа' },
      { value: '2', text: 'Обмен' },      
      { value: '3', text: 'Отдам даром' },
      { value: '4', text: 'Сдача в аренду' }
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

	// компонент создан
	created() {
		console.log(this.results)
		this.updateResults();
	},
				
	// -------------------------
	// Методы компонента
	// -------------------------
	methods: {

		updateResults() {
  		this.count = Object.keys(this.resultsClone).length;
			this.count_string = num2str(this.count, ["объявление", "объявления", "объявлений"]);
		},
			
		// показать / скрыть фильтр
		showFilter() {
				if (this.filter) {					
					this.filter=false
					this.filter_text="Фильтр";
				}
				else {
					this.filter=true;
					this.filter_text="Скрыть фильтр";
				}				
			},
			  
			// Обновить данные
  		updateData() {

			var url = "";
			var ready=false;
			
			console.log("Категория: "+this.category_name)
			console.log("Подкатегория: "+this.subcat)

			// если только категория
			if (this.category_name && !this.subcat && !this.region && !this.place) {
				url="/getResultsByCategoryForFront?category_name="+this.category_name+
				"&start_page="+this.start_page+
				"&category_id="+this.category+
				"&deal="+this.filters.deal+
				"&price_min="+this.filters.price_min+
				"&price_max="+this.filters.price_max;
				ready=true;
			}

			if (this.category_name && this.subcat) {
				alert("подкатегория!")
				ready=true;
			}
			
			// запрос
			if (ready) {
  			get(url).then((res) => {

					console.log("------------------------");
					console.log(res);
					console.log("------------------------");
					
					this.resultsClone=JSON.parse(res.data.results);
					this.updateResults();

					}).catch((err) => {	
						console.log(err)
				});
			}
		},
			
		// закрыть экран
		closeAndReturn() {
			window.history.back()
		},
			  									
		// загрузить ещё
		loadMore() {
    	this.updateData();
    },

		// навигация
		changePage(page) {
			this.start_page = page;
			this.updateData();
		}
	}
}
</script>
<style></style>
