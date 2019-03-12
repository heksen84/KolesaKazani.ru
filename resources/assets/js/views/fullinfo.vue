<!-- переименовать в details.vue -->
<template>
	<b-container fluid class="mycontainer">
	<b-row>
	  
		<!-- проверка на наличие входящих данных -->
		<b-col cols="12" sm="12" md="12" lg="12" xl="12" v-if="item[0]==undefined" style="text-align:center;margin-top:20px" class="shadow_text">
			<div style="font-size:40px">нет данных</div>
			<b><a href="/">Вернуться на главную страницу</a></b>
		</b-col>

		<b-col v-else cols="12" sm="12" md="12" lg="10" xl="10" class="create_advert_col">
		  <div class="close_button" title="Закрыть страницу" style="font-size:20px;font-weight:bold" @click="closeAndReturn">X</div>     
			<br>			

			<!-- Транспорт --->
			<div v-if="item[0].category_id==1">
				
				<!-- Заголовок -->				
				<h1 v-if="full && item[0].deal==0">Куплю {{ item[0].mark }} {{ item[0].model }} {{ item[0].year}} года</h1>
        		<h1 v-if="full && item[0].deal==1">Продам {{ item[0].mark }} {{ item[0].model }} {{ item[0].year}} года</h1>
        		<h1 v-if="full && item[0].deal==2">Обменяю {{ item[0].mark }} {{ item[0].model }} {{ item[0].year}} года</h1>
        		<h1 v-if="full && item[0].deal==3">Отдам даром {{ item[0].mark }} {{ item[0].model }} {{ item[0].year}} года</h1>
        		<h1 v-if="full && item[0].deal==4">Сдам в аренду {{ item[0].mark }} {{ item[0].model }} {{ item[0].year}} года</h1>

				<!-- размещение: регион / город / село -->
				<h2>{{ item[0].region_name }} {{ item[0].city_name }}</h2>
				
				<hr v-if="full">

				<h1 v-if="!full && item[0].text!='null'">{{ item[0].text }}</h1>
				
				<h5 v-if="item[0].year!=null">Год выпуска: {{ item[0].year }} г.</h5>
				
				<h5 v-if="item[0].engine_type!=null">Вид топлива:
					<span v-if="item[0].engine_type==0">бензин</span>
					<span v-if="item[0].engine_type==1">дизель</span>
					<span v-if="item[0].engine_type==2">газ-бензин</span>
					<span v-if="item[0].engine_type==3">газ</span>
					<span v-if="item[0].engine_type==4">гибрид</span>
					<span v-if="item[0].engine_type==5">электричество</span>				
				</h5>
				
				<h5 v-if="item[0].mileage!=null">Пробег: {{ item[0].mileage }} км.</h5>
				<h5 v-if="item[0].steering_position!=null">Положение руля: 
					<span v-if="item[0].steering_position==0">слева</span>
					<span v-else>справа</span>
				</h5>
				<h5 v-if="item[0].customs!=null">Растоможен: 
					<span v-if="item[0].customs==1">да</span>
					<span v-else>нет</span>
				</h5>
				<h5 v-if="full && item[0].text!='null'">Описание: <b>{{ item[0].text }}</b></h5>
			</div>

			<!-- Недвижимость --->
			<div v-if="item[0].category_id==2">

				<!-- Заголовок -->			
				<h1 v-if="item[0].deal==0">Куплю {{ item[0].rooms }} комнатную квартиру {{ item[0].floor }}/{{ item[0].floors_house }} этаж</h1>
        		<h1 v-if="item[0].deal==1">Продам {{ item[0].rooms }} комнатную квартиру {{ item[0].floor }}/{{ item[0].floors_house }} этаж</h1>
        		<h1 v-if="item[0].deal==2">Обменяю {{ item[0].rooms }} комнатную квартиру {{ item[0].floor }}/{{ item[0].floors_house }} этаж</h1>
        		<h1 v-if="item[0].deal==3">Отдам даром {{ item[0].rooms }} комнатную квартиру {{ item[0].floor }}/{{ item[0].floors_house }} этаж</h1>
        		<h1 v-if="item[0].deal==4">Сдам в аренду {{ item[0].rooms }} комнатную квартиру {{ item[0].floor }}/{{ item[0].floors_house }} этаж</h1>

				<!-- размещение: регион / город / село -->
				<h2>{{ item[0].region_name }} {{ item[0].city_name }}</h2>
				
				<hr>

				<h5>Количество комнат: {{ item[0].rooms }}</h5>
				<h5>Этаж: {{ item[0].floor }}</h5>
				<h5>Количество этажей: {{ item[0].floors_house }}</h5>
				<h5>Площадь: {{ item[0].area }} </h5>
				<h5 v-if="full && item[0].text!='null'">Описание: {{ item[0].text }}</h5>
			</div>

			<!-- Всё остальное -->
			<div v-if="item[0].category_id==3 || item[0].category_id==4 || item[0].category_id==5 || item[0].category_id==6 ||item[0].category_id==7 ||
				item[0].category_id==8 ||
				item[0].category_id==9 ||
				item[0].category_id==10 && 
				item[0].text!='null'">				

				<h1>{{ item[0].text }}</h1>

				<!-- размещение: регион / город / село -->
				<h2>{{ item[0].region_name }} {{ item[0].city_name }}</h2>

				<hr>			
			</div>

			<!-------------------------------------------------
				ОБЩАЯ ИНФОРМАЦИЯ
		  	------------------------------------------------->		
			<h5 v-if="item[0].category_id!=4 && item[0].price!=null">Цена: {{ item[0].price }} тенге</h5>		

			<h5>Контакты:
				<span v-if="item[0].phone1!=null">{{ item[0].phone1 }}</span><span v-if="item[0].phone2!=null">,</span>
				<span v-if="item[0].phone2!=null">{{ item[0].phone2 }}</span><span v-if="item[0].phone3!=null">,</span>
				<span v-if="item[0].phone3!=null">{{ item[0].phone3 }}</span>			
			</h5>

		<br>
		
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

			<div v-if="item[0].coord_lat!=0 && item[0].coord_lon!=0">
				Местоположение на карте
				<div id="map" style="margin-top:10px; width: 100%; height: 400px"></div>
					<hr>
					<b-button variant="primary" @click="closeAndReturn">закрыть</b-button>
				</div>
			</div>

		</b-col>
	</b-row>
</b-container>
</template>

<script>
var mapCoords=[];
var placemark;
var map;

/*
---------------------------
Инициализация карты
----------------------------*/
function initMap() {
  map = new ymaps.Map ("map", { center: mapCoords, zoom: 13 });			
	placemark = new ymaps.Placemark(mapCoords);
	map.geoObjects.add(placemark);
}

// ------------------
// компонент
// ------------------
export default {

props: ["item", "images", "full"], // входящие данные
components: {},

data() {
   return {
		image_index: 0
	}
},

// компонент создан
created() {	
	
	if (!this.item[0]) {
		console.log("нет данных")	
		return;
	}

	console.log(this.item[0]);

	// -------------------------------------------------------------
	// не инициализировать карту, если координаты 0,0
	// -------------------------------------------------------------
	if (this.item[0].coord_lat!=0 && this.item[0].coord_lon!=0) {
		mapCoords=[this.item[0].coord_lat, this.item[0].coord_lon];
		ymaps.ready(initMap);		
	}	  
},

// методы компонента
methods: {
selectImage(index) {
  this.image_index=index;
},

// закрыть и вернуться на пред. страницу
closeAndReturn() {
   window.history.back();
  }
}
}
</script>