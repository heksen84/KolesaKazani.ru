<!-- переименовать в details.vue -->
<template>
	<b-container fluid class="mycontainer">
	<b-row>
	  <b-col cols="12" sm="12" md="12" lg="10" xl="10" class="create_advert_col">
		  <div class="close_button" title="Закрыть страницу" style="font-size:20px" @click="closeAndReturn">X</div>     
			<br>

			<b>{{ item[0].region_name }}, {{ item[0].city_name }}</b>			
			<hr v-if="!full">
			<!-- ТРАНСПОРТ --->
			<div v-if="item[0].category_id==1">
				<h1 v-if="full" style="font-size:190%">
					<b>{{ item[0].mark }} {{ item[0].model }}, {{ item[0].year}} года</b>
				</h1>
				<hr>
				<h5 v-if="!full && item[0].text!=null"><b>{{ item[0].text }}</b></h5>
				<h5 v-if="item[0].year!=null">Год выпуска: <b>{{ item[0].year }}</b> г.</h5>
				<h5 v-if="item[0].engine_type!=null">Вид топлива:
					<b v-if="item[0].engine_type==0">бензин</b>
					<b v-if="item[0].engine_type==1">дизель</b>
					<b v-if="item[0].engine_type==2">газ-бензин</b>
					<b v-if="item[0].engine_type==3">газ</b>
					<b v-if="item[0].engine_type==4">гибрид</b>
					<b v-if="item[0].engine_type==5">электричество</b>
				</h5>
				<h5 v-if="item[0].mileage!=null">Пробег: <b>{{ item[0].mileage }}</b> км.</h5>
				<h5 v-if="item[0].steering_position!=null">Положение руля: 
					<b v-if="item[0].steering_position==0">слева</b>
					<b v-else>справа</b>
				</h5>
				<h5 v-if="item[0].customs!=null">Растоможен: 
					<b v-if="item[0].customs==1">да</b>
					<b v-else>нет</b>
				</h5>
				<h5 v-if="full && item[0].text!=null">Описание: <b>{{ item[0].text }}</b></h5>
			</div>

			<!-- Всё остальное -->
			<h5 v-else>
					<b>{{ item[0].text }}</b>
				<br>
				<br>
				<hr>
			</h5>		
	
		<!-------------------------------------------------
			ОБЩАЯ ИНФОРМАЦИЯ
		  ------------------------------------------------->
		<h5 v-if="item[0].category_id!=4 && item[0].price!=null">Цена: <b>{{ item[0].price }}</b> тенге</h5>
		<h5>Контакты:
			<b v-if="item[0].phone1!=null">{{ item[0].phone1 }}</b><span v-if="item[0].phone2!=null">,</span>
			<b v-if="item[0].phone2!=null">{{ item[0].phone2 }}</b><span v-if="item[0].phone3!=null">,</span>
			<b v-if="item[0].phone3!=null">{{ item[0].phone3 }}</b>			
		</h5>
		
		<div v-if="images.length<=0" style="text-align:center">
			<h5>Без фото</h5>
		</div>
		<div style="text-align:center" v-if="images.length>0">			
			<b-img :src="'../storage/app/images/'+images[image_index].image" fluid style="margin-bottom:5px"/>
			<div>
				<b-img v-for="(i,index) in images" :key="index" :src="'../storage/app/images/'+i.image" style="margin:1px;margin-bottom:8px" width="80" height="80" @click="selectImage(index)"/>					
			</div>
		</div>
		<div style="text-align:center;margin-bottom:20px">
		<hr>
			<b><ins>{{ item[0].region_name }}, {{ item[0].city_name }}</ins></b>				
			<!-- КАРТА -->
			<div id="map" style="margin-top:10px; width: 100%; height: 400px" v-if="item[0].coord_lat!=0 && item[0].coord_lon!=0"></div>
			<hr>
				<b-button variant="primary" @click="closeAndReturn">закрыть</b-button>
			</div>			
		</b-col>
	</b-row>
</b-container>
</template>
<script>

var mapCoords=[];
var myPlacemark;
var bigmap;

function initMap() {
    bigmap = new ymaps.Map ("map", { center: mapCoords, zoom: 13 });			
}

export default {

	props: ["item", "images", "full"], // входящие данные
	
	components: {},

	data() {
    return {
			image_index: 0
		}
	},

	created() {

	console.log(this.item[0]);
		
	// не инициализировать карту, если координаты 0,0
	if (this.item[0].coord_lat!=0 && this.item[0].coord_lon!=0) {
		mapCoords=[this.item[0].coord_lat, this.item[0].coord_lon];
		ymaps.ready(initMap);
	}	  
},
 methods: {
	selectImage(index) {
     this.image_index=index;
  },
  closeAndReturn() {
    window.history.back();
  }
}
}
</script>