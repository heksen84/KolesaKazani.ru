<template>
	<b-container fluid class="mycontainer_adv">
    <notifications group="foo" position="top center"/>
		<b-row>

		 <!-- карта -->
          <b-modal size="lg" v-model="setCoordsDialog" style="text-align:center;color:rgb(50,50,50)" hide-footer title="Уточнить на карте">
			  <div id="bigmap" style="width: 100%; height: 400px"></div>
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

			<b-form-group label="Вид сделки:" label-for="default_group" style="width:270px" v-if="category!=null && category!=4 && category!=9">
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

				<b-form-group label="Описание:" label-for="addit_info">
			 		<b-form-textarea id="addit_info" placeholder="Введите описание" :rows="4" :max-rows="4" @input="setInfo" v-model="info"></b-form-textarea>
				</b-form-group>			

				<!-- Цена -->
				<b-form-group label-for="price" style="text-align:center" v-if="category!=4">
			 		<b-form-input v-model="price" type="number" id="price" placeholder="Цена" style="width:150px;display:inline;font-weight:bold" :formatter="setPrice" required></b-form-input>
					&nbsp;{{ this.$root.money_full_name }}
				</b-form-group>

				<!-- Фотографии -->
				<b-form-group label="Фотографии:">
				<div style="text-align:center">
					<b-img v-for="(i, index) in preview_images" :src="i.src" :key="i.name" @click="deletePhoto(index)" class="image" :title="i.name"/>
					<b-form-file multiple accept=".png, .jpg, .jpeg" class="mt-2" @change="loadImage"></b-form-file>
				</div>
				</b-form-group>

				<b-form-group label="<ins>Контакты:</ins>" style="text-align:center;font-weight:bold">
			 	
				 	<b-form-input v-model.trim="phone1" type="text" placeholder="Контактный номер 1" style="width:250px;display:inline;text-align:center" :state="setPhoneNumber(1)" required></b-form-input>
							<!--<span style="margin-left:10px;color:grey;cursor:pointer" title="очистить поле" @click="clearField('phone1')">X</span>-->
					<div v-if="phone1.length>const_phone1_length">
						<b-form-input v-model.trim="phone2" type="text" placeholder="Контактный номер 2" style="width:250px;text-align:center;margin: 5px auto" :state="setPhoneNumber(2)"></b-form-input>
							<!--<span style="color:grey;cursor:pointer" title="очистить поле" @click="clearField('phone2')">X</span>-->
						<b-form-input v-model.trim="phone3" type="text" placeholder="Контактный номер 3" style="width:250px;text-align:center;margin: 5px auto" :state="setPhoneNumber(3)"></b-form-input>
							<!--<span style="margin-left:10px;color:grey" title="очистить поле" @click="clearField('phone3')">X</span>-->
					</div>
				
				</b-form-group>

				<div v-show="phone1.length>const_phone1_length">

				<!-- Город, Село и т.д. -->
				<div style="text-align:center;margin-top:50px;margin-bottom:0px;font-weight:bold">Расположение</div>
				
				<!-- выпадающий список регионов -->
				<b-form-group label="Регион:" style="width:280px;margin:auto">
				<b-form-select class="mb-3" @change="changeRegion" v-model="regions_model">
					 <option :value=null>-- Выберите регион --</option>
					 <option v-for="item in regions" :value="item.region_id" :key="item.name">{{item.name}}</option>
				</b-form-select>
				</b-form-group>

				<b-form-group label="Местность:" style="width:280px;margin:auto" v-show="regions_model!=null">
				<b-form-select class="mb-3" @change="changePlace" v-model="places_model">
					 <option :value=null>-- Выберите местность --</option>
					 <option v-for="item in places" :value="item.city_id+'@'+item.coords" :key="item.name">{{item.name}}</option>
				</b-form-select>
				</b-form-group>

				<!-- Расположение на карте -->
				<b-form-group style="text-align:center" v-show="placeChanged && places_model!=null">
					<div id="smallmap" style="border:1px solid rgb(180,180,180);margin-bottom:10px;width: 100%; height: 200px" v-show="coordinates_set"></div>
					<b-button variant="primary" @click="showSetCoordsDialog">уточнить расположение</b-button>
				</b-form-group>

				<hr>

				<!-- Публикация -->
				<b-form-group style="text-align:center;margin:25px" v-show="places_model!=null">
					<b-button type="onSubmit" variant="outline-primary" title="Опубликовать объявление">ОПУБЛИКОВАТЬ</b-button>
				</b-form-group>
			
			</div>
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

// карты
var mapCoords=[];
var myPlacemark1=null;
var myPlacemark2=null;
var bigmap=null;
var smallmap=null;

/*
---------------------------------------------------------
 Инициализация большой карты (карта назначения координат)
---------------------------------------------------------*/
function initMaps() {

		// координаты по умолчанию для всех карт
		mapCoords = [51.08, 71.26];

		bigmap = new ymaps.Map ("bigmap", { center: mapCoords, zoom: 10 });
		smallmap = new ymaps.Map ("smallmap", { center: mapCoords, zoom: 9 });

		// запрещаю перемение по мини карте
		smallmap.behaviors.disable("drag");

		// включаю скролл на большой карте
		bigmap.behaviors.enable("scrollZoom");
			
		myPlacemark1 = new ymaps.Placemark(mapCoords);
		myPlacemark2 = new ymaps.Placemark(mapCoords);

		bigmap.geoObjects.add(myPlacemark1);
		smallmap.geoObjects.add(myPlacemark2);

    	bigmap.events.add("click", function (e) {
        	mapCoords = e.get('coordPosition');
			myPlacemark1.geometry.setCoordinates(mapCoords);
			myPlacemark2.geometry.setCoordinates(mapCoords);
			smallmap.setCenter(mapCoords, 14, "smallmap");
		});			
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

			// константы
			const_phone1_length: 4,

			// данные карты
			setCoordsDialog: false,
			coordinates_set: false,
			placeChanged: false,

			/*
			-----------------------------
			базовые поля объявления
			-----------------------------*/			
			category: null,
			sdelka: 0,
			deal_id: null,
			info: "",
			price: "",
			number: 0,
			preview_images: [],
			real_images: [],
			root: false,
			regions: [],
			regions_model: null,
			places: [],
			places_model: null,
			phone1: "",
			phone2: "",
			phone3: "",
			
			/*
			-------------------------
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

	// -------------------------------
	// Событие: компонент создан
	// -------------------------------
	created() {

		ymaps.ready(initMaps);
		
		get("/getRegions").then((res) => {
		  this.regions=res.data;
		  this.advReset();
      	}).catch((err) => {
			console.log("Не возможно загрузить регионы!");
		});

	},

	components: { transport, realestate },
  	methods: {

		/*clearField(field) {

			console.log(field);

			switch(field) {
				case "phone1": this.phone1=""; break;
				case "phone2": this.phone2=""; break;
				case "phone3": this.phone3=""; break;
			}
		},*/

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
		changePlace(items) {

			if (items==null) return;

			var arr = items.replace(" ", "").split("@");
			var city_id = arr[0];
			var coords = arr[1];
			var lanlng = coords.split(",")

			mapCoords=[];
			mapCoords.push(lanlng[0])
			mapCoords.push(lanlng[1])

			bigmap.setCenter(mapCoords, 15, "bigmap");
			smallmap.setCenter(mapCoords, 11, "smallmap");

			myPlacemark1.geometry.setCoordinates(mapCoords);
			myPlacemark2.geometry.setCoordinates(mapCoords);

			this.placeChanged = true;
			this.coordinates_set = true;

			// записываю id городи или деревни
			this.$root.advert_data.city_id = city_id;

			// записываю координаты
			this.$root.advert_data.adv_coords=[];
			this.$root.advert_data.adv_coords=mapCoords;
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

		// описание
  		setInfo(info) {
			this.$root.advert_data.adv_info=info;
  		},

		// установить цену
  		setPrice(price) {
			if (price < 0) return;
  			this.$root.advert_data.adv_price=price;
        	this.price = price;
        	return price;
		},

		// телефоны
		setPhoneNumber(number) {

			switch(number) {
				case 1: {
					  this.$root.advert_data.adv_phone1=this.phone1;
					  break;
				}
				case 2: {
					  this.$root.advert_data.adv_phone2=this.phone2;
					  break;
				}
				case 3: {
					  this.$root.advert_data.adv_phone3=this.phone3;
					  break;
				}
			}
		},
		  		  
		// вид сделки
  		setDeal(deal_id) {
			//if (deal_id==null) this.coordinates_set=false;
  			this.$root.advert_data.adv_deal=deal_id;
			this.deal_id=deal_id;
  		},

		// сброс объявления
		advReset(data) {

			// сбрасываю фотки			
			document.querySelector("input[type=file]").value = "";

			// сброс массива объявления и переинициализация его
			this.$root.advert_data=[];
			this.$root.advert_data.adv_deal = 0;	// покупка по умолчанию
			this.$root.advert_data.adv_info = null; // добавляю формально поле доп. информация
			this.$root.advert_data.adv_price = "";
			this.$root.advert_data.adv_phone1 = "";
			this.$root.advert_data.adv_phone2 = "";
			this.$root.advert_data.adv_phone3 = "";

			// сброс моделей
			this.price = "";
			this.info = "";
			this.phone1 = "";
			this.phone2 = "";
			this.phone3 = "";
			this.regions_model = null;
			this.places_model = null;
			this.preview_images = [];
			this.coordinates_set=false;

			// сбрасываю дополнительные поля
			this.$store.commit("ShowOtherFields", false);

			if (data!=null) 
				this.resetCategories(data);
		},
  		/*
  		--------------------------
  		 Изменения в категориях
  		--------------------------*/
  		changeCategory(data) {
			
			this.advReset(data);

			// добавляю категорию
			this.$root.advert_data.adv_category=data;		

  			switch(data) {
  				case null: {
					  this.root=true; 
					  this.$store.commit("ShowOtherFields", false);
  					break;
  				}
  				case 1: {
					  this.transport=true; 
					  this.$store.commit("ShowOtherFields", false);
  					break; 
  				} 
  				case 2: {  
					  this.real_estate=true; 
					  this.$store.commit("ShowOtherFields", true);
  					break; 
  				}
  				case 3: {
					  this.appliances=true; 
					  this.$store.commit("ShowOtherFields", true);
  					break; 
  				}
  				case 4: {
					  this.work_and_buisness=true;
					  this.$store.commit("ShowOtherFields", true); 
  					break; 
  				}
  				case 5: {
					  this.for_home=true; 
					  this.$store.commit("ShowOtherFields", true);
  					break; 
  				}
  				case 6: {
					  this.personal_effects=true; 
					  this.$store.commit("ShowOtherFields", true);
  					break; 
  				}
  				case 7: {
					this.animals=true;
					this.$store.commit("ShowOtherFields", true); 
  					break; 
  				}
  				case 8: {
					this.hobbies_and_leisure=true; 
					this.$store.commit("ShowOtherFields", true);
  					break; 
  				}
  				case 9: { 
					this.services=true;
					this.$store.commit("ShowOtherFields", true);
  					break; 
  				}
  				case 10: {
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
		axios.post("/create", formData, {
			headers: { 'Content-Type': 'multipart/form-data' }
        }).then(response => {
              console.log(response);
			if (response.data.result=="db.error")
				this.$root.$notify({group: 'foo', text: "<h6>Неполадки в работе сервиса. Приносим свои извинения.</h6>", type: 'error'});
			else
			if (response.data.result=="usr.error")
			this.$root.$notify({group: 'foo', text: "<h6>"+response.data.msg+"</h6>", type: 'error'});
			else
			alert("Объявление размещено");
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