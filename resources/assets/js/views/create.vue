<template>
	<b-container fluid class="mycontainer_adv">
    <notifications group="foo" position="top center"/>
		<b-row>

		 <!-- карта -->
          <b-modal size="lg" v-model="setCoordsDialog" style="text-align:center;color:rgb(50,50,50)" hide-footer title="Местоположение">
			  <div id="map" style="width: 100%; height: 400px"></div>
			<br/>
			<b-button variant="primary" @click="setCoords" id="setCoordsBtn">Сохранить</b-button>
          </b-modal> 	

		  <b-col cols="12" sm="12" md="12" lg="10" xl="10" class="create_advert_col">
		  <div class="close_button" title="Закрыть страницу" @click="closeAndReturn">X</div>
		  <h1 class="title_text" style="margin-top:12px">подать объявление</h1>

		  <hr>

			<b-form @submit="onSubmit">

			<b-form-group label="Категория товара или услуги:" label-for="categories" style="width:260px">
			<b-form-select class="mb-3" @change="changeCategory" v-model="category">
				<option :value=null>-- Выберите категорию --</option>
				<option v-for="item in items" :value="item.id" :key="item.name">{{item.name}}</option>
			</b-form-select>
			</b-form-group>

			<b-form-group label="Вид сделки:" label-for="default_group" style="width:270px;margin-top:-5px" v-if="category!=null && category!=4 && category!=9 && category!=10">
				 <b-form-radio-group id="deal_group" stacked name="radioOpenions" @change="setDeal" v-model="sdelka">
				 	<b-form-radio v-for="(i,index) in dealtypes" :value="i.id" :key="index">{{ i.deal_name_1 }}</b-form-radio>
				 </b-form-radio-group>
			</b-form-group>

			<br>			
			
			<!-- Категории -->
			<div v-if="root"></div>

			<!-- транспорт -->
			<transport v-else-if="transport"/>

			<!-- недвижимость -->
			<realestate v-else-if="real_estate"/>

			<!-- бытовая техника -->
			<h1 v-else-if="appliances"></h1>

			<!-- работа и бизнес -->
			<h1 v-else-if="work_and_buisness"></h1>

			<!-- для дома и дачи -->
			<h1 v-else-if="for_home"></h1>

			<!-- для дома и дачи -->
			<h1 v-else-if="personal_effects"></h1>

			<!-- животные -->
			<h1 v-else-if="animals"></h1>

			<!-- хобби и отдых -->
			<h1 v-else-if="hobbies_and_leisure"></h1>

			<!-- услуги -->
			<h1 v-else-if="services"></h1>

			<!-- услуги -->
			<h1 v-else-if="other"></h1>

			<!-- Дополнительные поля -->
			<div v-show="this.$store.state.show_other_fields">

				<b-form-group label="Дополнительная информация:" label-for="addit_info">
			 	<b-form-textarea id="addit_info"
								placeholder="Введите дополнительную информацию"
								:rows="4"
								:max-rows="4" @input="setInfo" v-model="text">
	 		 	</b-form-textarea>
				</b-form-group>			

				<!-- Цена -->
				<b-form-group label-for="price" style="text-align:center">
			 		<b-form-input type="number" id="price" placeholder="Цена" style="width:150px;display:inline;font-weight:bold" :formatter="setPrice" required></b-form-input>
					&nbsp;{{ this.$root.money_full_name }}
				</b-form-group>			

				<!-- Фотографии -->
				<b-form-group label="Фотографии:">
				<div style="text-align:center">
					<b-img v-for="(i, index) in preview_images" :src="i.src" :key="i.name" @click="deletePhoto(index)" class="image" :title="i.name"/>
					<b-form-file multiple accept=".png, .jpg, .jpeg" class="mt-2" @change="loadImage"></b-form-file>
				</div>
				</b-form-group>

				<b-form-group label="Контактный номер:" style="text-align:center">
			 		<b-form-input type="number" id="price" placeholder="+7(XXX)XXXXXXX" style="width:250px;display:inline" :formatter="setPhoneNumber" required></b-form-input>
				</b-form-group>

				<!-- Город, Село и т.д. -->
				<div style="text-align:center;margin-top:50px;margin-bottom:0px">Расположение</div>
				
				<!-- выпадающий список регионов -->
				<b-form-group label="Регион:" style="width:280px;margin:auto" v-if="regions.length>0">
				<b-form-select class="mb-3" @change="changeRegion" v-model="regions_model">
					 <option :value=null>-- Выберите регион --</option>
					 <option v-for="item in regions" :value="item.region_id" :key="item.name">{{item.name}}</option>
				</b-form-select>
				</b-form-group>

				<b-form-group label="Местность:" style="width:280px;margin:auto" v-if="places.length>0">
				<b-form-select class="mb-3" @change="changePlace" v-model="places_model">
					 <option :value=null>-- Выберите местность --</option>
					 <option v-for="item in places" :value="item.city_id" :key="item.name">{{item.name}}</option>
				</b-form-select>
				</b-form-group>

				<!-- Расположение на карте -->
				<b-form-group style="text-align:center">
					<div id="smallmap" style="border:2px solid rgb(180,180,180);margin-bottom:10px;width: 100%; height: 200px" v-show="coordinates_set" @click="showSetCoordsDialog"></div>
					<b-button variant="primary" @click="showSetCoordsDialog">отметить на карте</b-button>
				</b-form-group>

				<hr>

				<!-- Публикация -->
				<b-form-group style="text-align:center;margin:25px">
					<b-button type="onSubmit" variant="outline-primary" title="Опубликовать объявление">ОПУБЛИКОВАТЬ</b-button>
				</b-form-group>

			</div>			
		</b-form>
	</b-col>
	</b-row>
</b-container>
</template>
<script>

// ----------------------------------------------------
// ИМПОРТ
// ----------------------------------------------------
import { post, get } from './../helpers/api'
import transport from '../components/chars/transport';
import realestate from '../components/chars/realestate';

var preview_images_array=[];

var mapCoords=[];
var myPlacemark;
var bigmap, smallmap;

function initBigMap() {

		mapCoords = [51.08, 71.26];
    	bigmap = new ymaps.Map ("map", { center: mapCoords, zoom: 10 });

		//Добавляем элементы управления
		//bigmap.controls.add('zoomControl');
		bigmap.behaviors.enable('scrollZoom');
			
		myPlacemark = new ymaps.Placemark([55.76, 37.64]);
		bigmap.geoObjects.add(myPlacemark);

    	bigmap.events.add('click', function (e) {
        	mapCoords = e.get('coordPosition');
			myPlacemark.geometry.setCoordinates(mapCoords);
		});			
	}				

	function initSmallMap() {			
		smallmap = new ymaps.Map ("smallmap", { center: mapCoords, zoom: 10 });
	}

	// Для заполнения изображений
	function forEach(data, callback) { 
	for(var key in data) { 
		if(data.hasOwnProperty(key)) { 
			callback(key, data[key]); 
		} 
	}
}

// Логика
export default {
	
	props: ["items", "dealtypes"],
	
	data () {
    return 	{
		
			setCoordsDialog:false,
			coordinates_set:false,

			/*
			-----------------------------
			 базовые поля объявления
			-----------------------------*/			
			category: null,
			sdelka:0,
			deal_id: null,
			text: "",
			price: 0,
			number: 0,
			preview_images: [],
			real_images: [],
			root: false,
			regions: [],
			regions_model:null,
			places: [],
			places_model:null,
			
			/*-------------------------
				категории 
			-------------------------*/

			transport:false,			// транспорт
			real_estate:false,			// недвижимость
			appliances:false,			// бытовая техника
			work_and_buisness:false,	// работа и бизнес
			for_home:false,				// для дома и дачи
			personal_effects:false,		// личные вещи
			animals:false,				// животные
			hobbies_and_leisure:false,	// хобби и отдых
			services:false,				// услуги
			other:false					// другое
		}
	},

	// Событие: компонент создан
	created() {
		console.log(this.dealtypes)
		
		this.$root.advert_data.adv_info = null; // добавляю формально поле доп. информация						

		ymaps.ready(initBigMap);
		ymaps.ready(initSmallMap);

		// -----------------------------
		// Получаем регионы
		// -----------------------------
		get('/getRegions').then((res) => {
		  this.regions=res.data;
      	}).catch((err) => {
			console.log("Не возможно загрузить регионы!");
		});

	},

	components: { transport, realestate },
  	methods: {

		// обработка выбора региона
		changeRegion(region_id) {

			this.$root.advert_data.region_id = region_id;

			// Получить города / сёлы
      		get('getPlaces?region_id='+region_id).then((res) => {
				  this.places=res.data;
				  this.places_model=null;
          		console.log(res.data);
			  }).catch((err) => {});
			  
		},

		// обработка выбора местоположения
		changePlace(city_id) {
			console.log(city_id)
			this.$root.advert_data.city_id = city_id;
		},

		// ------------------------------------------------
		//
		// Загрузка изображений
		//
		// ------------------------------------------------
  		loadImage(evt) {
			  
			var root  = this.$root;  
			var files = evt.target.files;			
			var input_images = document.querySelector("input[type=file]");	
			var preview_images = this.preview_images;		
			var real_images = this.real_images;

			if (input_images.files.length + preview_images.length > this.$root.max_loaded_images) 
				return;
		
			for (var i=0; i<files.length; i++) {
				if (i===this.$root.max_loaded_images) break;

				// если уже существует, не обрабатывать изображение
				for (var j=0; j<preview_images.length; j++)
					if (files[i].name==preview_images[j].name)
						return false;

        		var image  = files[i]
				var reader = new FileReader();

  				reader.onload = (function(theFile) {

          		return function(e) {
					if (theFile.type=="image/jpeg" || theFile.type=="image/pjpeg" || theFile.type=="image/png") {					
						preview_images.push({ "name": theFile.name, "src": e.target.result });
						real_images.push(theFile);
					}
					else
					root.$notify({group: 'foo', text: "<h6>Только изображения!</h6>", type: 'error'});				
          		};

		  })(image);
		  
			reader.readAsDataURL(image);			
		}
			input_images.value = "";
		},

		// Удаление фото по щелчку
  		deletePhoto(index) {
			document.querySelector("input[type=file]").value = "";
			this.preview_images.splice(index, 1);
			this.real_images.splice(index, 1);
  		},

		// Вернуться на предыдущую страницу
  		closeAndReturn() {
 			window.history.back();
  		},

  		// Сброс данных при выборе категории
  		resetCategories(data) {
  			 this.root=false;				        // по умолчанию
  			 this.transport=false;			        // транспорт
  			 this.real_estate=false;			    // недвижимость
  			 this.appliances=false;			        // бытовая техника
  			 this.work_and_buisness=false; 	    	// работа и бизнес
  			 this.for_home=false;			        // для дома и дачи
  			 this.personal_effects=false;	      	// личные вещи
			 this.animals=false;				    // животные
			 this.hobbies_and_leisure=false;	  	// хобби и отдых
			 this.services=false;			        // услуги
			 this.other=false;				        // другое 
  		},

  		setInfo(info) {
			this.$root.advert_data.adv_info=info;
  		},

  		setPrice(price) {
			
			if (price < 0) return;
  			this.$root.advert_data.adv_price=price;
        	this.price = price;
        	return price;
		},


		setPhoneNumber(number) {
			
			if (number < 0) return;
  			this.$root.advert_data.adv_phone=number;
        	this.number = number;
        	return number;
		},
		  		  
  		
  		setDeal(deal_id) {
  			this.$root.advert_data.adv_deal=deal_id;
        	this.deal_id=deal_id;
  		},

  		/*
  		--------------------------
  		 Изменения в категориях
  		--------------------------*/
  		changeCategory(data) {

			//console.log(data);
			
			// сбрасываю фотки			
			document.querySelector("input[type=file]").value = "";

			this.preview_images=[];
			// сбрасываю карту
			this.coordinates_set=false;
			// сбрасываю дополнительные поля
			this.$store.commit("ShowOtherFields", false);
			// добавляю категорию
			this.$root.advert_data.adv_category=data;
			// по умолчанию показываю доп. поля			

  			switch(data) {
  				case null: {
  					this.resetCategories(data); 
					  this.root=true; 
					  this.$store.commit("ShowOtherFields", false);
  					break;
  				}
  				case 1: { 
  					this.resetCategories(data); 
					  this.transport=true; 
					  this.$store.commit("ShowOtherFields", false);
  					break; 
  				} 
  				case 2: { 
  					this.resetCategories(data); 
					  this.real_estate=true; 
					  this.$store.commit("ShowOtherFields", true);
  					break; 
  				}
  				case 3: { 
  					this.resetCategories(data); 
					  this.appliances=true; 
					  this.$store.commit("ShowOtherFields", true);
  					break; 
  				}
  				case 4: { 
  					this.resetCategories(data); 
					  this.work_and_buisness=true;
					  this.$store.commit("ShowOtherFields", true); 
  					break; 
  				}
  				case 5: { 
  					this.resetCategories(data); 
					  this.for_home=true; 
					  this.$store.commit("ShowOtherFields", true);
  					break; 
  				}
  				case 6: { 
  					this.resetCategories(data); 
					  this.personal_effects=true; 
					  this.$store.commit("ShowOtherFields", true);
  					break; 
  				}
  				case 7: { 
  					this.resetCategories(data); 
					this.animals=true;
					this.$store.commit("ShowOtherFields", true); 
  					break; 
  				}
  				case 8: { 
  					this.resetCategories(data); 
					this.hobbies_and_leisure=true; 
					this.$store.commit("ShowOtherFields", true);
  					break; 
  				}
  				case 9: { 
  					this.resetCategories(data); 
					this.services=true;
					this.$store.commit("ShowOtherFields", true);
  					break; 
  				}
  				case 10: { 
  					this.resetCategories(data); 
					this.other=true;
					this.$store.commit("ShowOtherFields", true);
  					break; 
  				}
  			}
		},
  		
  		/*
		----------------------------
		  Сохранить объявление
		----------------------------*/
    	onSubmit(evt) {			
		evt.preventDefault();

		var formData = new FormData();

		// записываю значения полей
		forEach(this.$root.advert_data, function(key, value) {
			formData.append(key, value);
		})

		// Записываю изображения
		for( var i=0; i < this.real_images.length; i++ ) {
          	formData.append('images['+i+']', this.real_images[i]);
		}
		
		// ---------------------------------------------------
		// Отправить пост запрос на создание объявления
		// ---------------------------------------------------
		axios.post('/create', formData, {
			headers: { 'Content-Type': 'multipart/form-data' }
        }).then(response => {
              console.log(response);
			if (response.data.result=="db.error")
				this.$root.$notify({group: 'foo', text: "<h6>Неполадки в работе сервиса. Приносим свои извинения.</h6>", type: 'error'});
			else
			if (response.data.result=="usr.error")
			this.$root.$notify({group: 'foo', text: "<h6>"+response.data.msg+"</h6>", type: 'error'});
			else
			alert("ok");
			//	else 
			//	window.location="home"; // переходим в личный кабинет
        }).catch(error => {
			  console.log(error.response)
			  this.$root.$notify({group: 'foo', text: "<h6>Невозможно отправить запрос. Проверьте подключение к интернету.</h6>", type: 'error'});
		})
    },

	// Показать диалог выбора расположения
	showSetCoordsDialog() {

		this.setCoordsDialog=true;

		if (!navigator.geolocation) {
			// navigator.geolocation не поддерживается
			console.log("navigator.geolocation error");
		}
		else {
				navigator.geolocation.getCurrentPosition(function(position) {				
				var lat = position.coords.latitude;
				var lon = position.coords.longitude;
				var geoCoords=[lat,lon];
				myPlacemark.geometry.setCoordinates(getCoords);				
			});
		}
	},

	// ---------------------------------
	// Установить координаты
	// ---------------------------------
	setCoords() {
		this.setCoordsDialog=false;
		this.$root.advert_data.adv_coords=[];
		this.$root.advert_data.adv_coords=mapCoords;
		this.coordinates_set=true;
	}
}
}
</script>