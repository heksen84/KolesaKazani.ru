<template>
<div>

<div id="advert_loading_block">
  <div class="d-flex justify-content-center mt-1">
    <button class="btn btn-primary" type="button" style="font-size:20px">
      <span class="spinner-border spinner-border" role="status" aria-hidden="true"></span>
        Публикация объявления...<br>Это может занять некоторое время.
    </button>
    </div>
</div>

<div class="container-fluid mycontainer">  

    <!-- карта и сообщения об ошибках-->
    <div class="modal" id="MsgModalDialog" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-show="!serviceUnavailable" class="modal-title grey">Расположение</h5>          
            <b v-show="serviceUnavailable" class="modal-title grey">{{ dialogTitleMsg }}</b>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div v-show="!serviceUnavailable" id="bigmap" style="width: 100%; height: 300px"></div>
            <!--<p v-show="serviceUnavailable" class="alert-heading">{{ dialogMsg }}</p>-->
            <p v-show="serviceUnavailable" class="alert-heading">Приносим извинения за неудобства, но в данный момент мы не можем обработать ваш запрос.</p>            
          </div>
          <div class="modal-footer" v-show="!serviceUnavailable">          
            <button type="button" class="btn btn-primary margin-auto" @click="setCoords">Сохранить</button>          
          </div>
        </div>
      </div>
    </div>        

    <!-- Объявление размещено -->
    <div class="modal" id="AdPostedModal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header"><h4>Готово!</h4></div>
            <div class="modal-body">
              <h5>Ваше объявление отправлено на проверку</h5>
            </div>
              <div class="modal-footer">          
                <button type="button" class="btn btn-primary margin-auto" data-dismiss="modal" aria-label="Close">Продолжить</button>          
              </div>                  
            </div>
          </div>
        </div>        

    <div class="row">  
      <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 create_advert_col" style="border: 1px solid rgb(220,220,220)">
        <div style="text-align:right;font-size:14px"><a href="#" title="Правила размещения объявления">правила размещения</a></div>
        <div class="close-link" style="width:80px" title="Закрыть страницу" @click="closePage">закрыть</div>
        <br>
		      <h1 class="title_text">новое объявление</h1>          
            <hr>            
            
          <!------------------------------------------------------------------ 
            ОСНОВНАЯ ФОРМА 
            ------------------------------------------------------------------>
          <form id="advertform" @submit="onSubmit">

            <div class="row form-group">
              <div class="col-auto">
                <label>Заголовок объявления</label>
                <input class="form-control" size="100" maxlength="100" placeholder="Введите заголовок объявления" v-model="title" @input="setTitle" required/>
              </div>
            </div>    
  
          <div class="row form-group">
            <div class="col-auto">
              <label for="categories">Категория товара или услуги:</label>
                <select class="form-control" v-model="category" @change="changeCategory">            
                  <option v-bind:value="null">-- Выберите категорию --</option>
                  <option v-for="(item, index) in categories" :key="index" v-bind:value="item.id">{{ item.name }}</option>
                </select>                
              </div>
            </div>

            <!-- Категории -->
		        <div v-if="root"></div>

              <transport v-if="transport && category"/>    
              <realEstate v-if="real_estate"/>

              <!-- fix: поместить селекты в компонент superSelect -->
              <div class="row">

                <!-- электроника -->
                <div class="col-11 col-xl-5 col-md-5 col-sm-12" v-if="appliances && category">
                  <select class="form-group form-control" v-model="subCategory" @change="changeSubCategory">
                    <option value="null">-- Подкатегория --</option>
                    <option v-for="(item, index) in subCategoryItems" :key="index" :value=item.id>{{ item.name }}</option>
                  </select>
                </div>

                <!-- работа и бизнес -->
                <div class="col-11 col-xl-4 col-md-4 col-sm-12" v-if="work_and_buisness && category">
                  <select class="form-group form-control" v-model="subCategory" @change="changeSubCategory">
                    <option value="null">-- Подкатегория --</option>
                    <option v-for="(item, index) in subCategoryItems" :key="index" :value=item.id>{{ item.name }}</option>
                  </select>
                </div>

                <!-- для дома и дачи -->
                <div class="col-11 col-xl-4 col-md-4 col-sm-12" v-if="for_home && category">
                  <select class="form-group form-control" v-model="subCategory" @change="changeSubCategory">
                    <option value="null">-- Подкатегория --</option>
                    <option v-for="(item, index) in subCategoryItems" :key="index" :value=item.id>{{ item.name }}</option>
                  </select>
                </div>

                <!-- личные вещи -->
                <div class="col-11 col-xl-5 col-md-5 col-sm-12" v-if="personal_effects && category">
                  <select class="form-group form-control" v-model="subCategory" @change="changeSubCategory">
                    <option value="null">-- Подкатегория --</option>
                    <option v-for="(item, index) in subCategoryItems" :key="index" :value=item.id>{{ item.name }}</option>
                  </select>
                </div>

                <!-- животные -->
                <div class="col-11 col-xl-4 col-md-4 col-sm-12" v-if="animals && category">
                  <select class="form-group form-control" v-model="subCategory" @change="changeSubCategory">
                    <option value="null">-- Подкатегория --</option>
                    <option v-for="(item, index) in subCategoryItems" :key="index" :value=item.id>{{ item.name }}</option>
                  </select>
                </div>

                <!-- хобби и бизнес -->
                <div class="col-11 col-xl-4 col-md-4 col-sm-12" v-if="hobbies_and_leisure && category">
                  <select class="form-group form-control" v-model="subCategory" @change="changeSubCategory">
                    <option value="null">-- Подкатегория --</option>
                    <option v-for="(item, index) in subCategoryItems" :key="index" :value=item.id>{{ item.name }}</option>
                  </select>
                </div>

                <!-- услуги -->
                <div class="col-11 col-xl-5 col-md-5 col-sm-12" v-if="services && category">
                  <select class="form-group form-control" v-model="subCategory" @change="changeSubCategory">
                    <option value="null">-- Подкатегория --</option>
                    <option v-for="(item, index) in subCategoryItems" :key="index" :value=item.id>{{ item.name }}</option>
                  </select>
                </div>  

              </div>

            <!-- Дополнительные поля -->			      
            <div v-show="$store.state.show_final_fields">
              <label for="addit_info">{{ $store.state.info_label_description }}</label>
                <textarea id="addit_info" class="form-control form-group" :placeholder="$store.state.placeholder_info_text" :rows="4" :max-rows="4" maxlength="1024" @input="setInfo" v-model="info"></textarea>
                  <div class="row">
                    
                    <div class="col-md-12 text-center" v-if="$store.state.show_price">
                      <span style="margin-right:5px">Цена:</span>                      
                      <superInput type="number" v-model="price" :maxlength="9" @input="setPrice"></superInput>
                    </div>

                    <div class="col-md-12">
                      <label class="form-group">Фотографии:</label>
                    </div>

                    <div class="col-md-12 text-center">
                      <img v-for="(i, index) in preview_images" :src="i.src" :key="i.name" @click="deletePhoto(index)" class="image" :title="i.name"/>
                    </div>

                    <div class="col-md-12 text-center">                      
                      <br>
                      <div class="custom-file" id="customFile" lang="ru">
                        <input @change="loadImage" name="input2[]" type="file" class="custom-file-input" accept=".png, .jpg, .jpeg" multiple data-show-upload="true" data-show-caption="true">
                        <label class="custom-file-label"></label>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <hr>
                      <label class="form-group">Контакты:</label>                            
                    </div>

                  </div>

                  <div class="row">                                        
                    <div class="col-md-12 text-center">                      
                      <superInput type="phone" placeholder="контактный номер" v-model="phone" :maxlength="14" @input="setPhone"></superInput>                      
                      <br>
                    </div>
                  </div>

                  <div class="row" v-show="phone.length===14">                  
                  <br>
                  <div class="col-md-12">
                    <label class="form-group">Расположение:</label>
                  </div>
                  
                  <div class="col-md-12">
                    <div style="width:280px;margin:auto">
                    <label for="selectRegion">Регион:</label>
                      <select id="selectRegion" class="form-control form-group" @change="changeRegion" v-model="regions_model">            
                        <option v-bind:value="null">-- Выберите регион --</option>
                        <option v-for="item in regions" :value="item.region_id" :key="item.name">{{ item.name }}</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12" v-show="regions_model!=null">
                    <div style="width:280px;margin:auto">
                    <label for="selectPlace">Местность:</label>
                      <select id="selectPlace" class="form-control form-group" @change="changePlace" v-model="places_model">            
                        <option v-bind:value="null">-- Выберите местность --</option>
                        <option v-for="item in places" :value="item.city_id+'@'+item.coords" :key="item.name">{{ item.name }}</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-12 text-center" v-show="places_model!=null">
                    <div id="smallmap" style="border:1px solid rgb(180,180,180);margin-bottom:10px;width: 100%; height: 200px" v-show="coordinates_set"></div>
                    <button type="button" class="btn btn-primary form-group" @click="showSetCoordsDialog">уточнить местоположение</button>                    
                  </div>
                  
                  <div class="col-md-12 text-center" v-if="places_model!=null">
                    <hr>
                    <button type="submit" class="btn btn-success form-group">опубликовать</button>                    
                  </div>
                           
                </div>                 
            </div>
          </form>
        </div>
    </div>  
</div>
</div>
</template>
<script>

// ---------------------------
// импорт модулей
// ---------------------------
import $ from "jquery";
import bootstrap from "bootstrap";
import transport from "./subcategories/transport.vue"
import realEstate from "./subcategories/realEstate.vue"
import superInput from "./components/superInput.vue"
import register from "./components/auth/register.vue"
import restore from "./components/auth/restore.vue"

import { post, get } from '../../helpers/api'

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

	bigmap = new ymaps.Map("bigmap", { center: mapCoords, zoom: 10 });
	smallmap = new ymaps.Map("smallmap", { center: mapCoords, zoom: 9 });

	// запрещаю перемение по мини карте
	smallmap.behaviors.disable("drag");

	// включаю скролл на большой карте
	bigmap.behaviors.enable("scrollZoom");
			
	// формирую метки
	myPlacemark1 = new ymaps.Placemark(mapCoords);
	myPlacemark2 = new ymaps.Placemark(mapCoords);

	// добавляю метки на карты
	bigmap.geoObjects.add(myPlacemark1);
	smallmap.geoObjects.add(myPlacemark2);

  // обработчик клика по карте
  bigmap.events.add("click", function (e) {

    mapCoords = e.get("coordPosition");
	  myPlacemark1.geometry.setCoordinates(mapCoords);
		myPlacemark2.geometry.setCoordinates(mapCoords);
    smallmap.setCenter(mapCoords, 14, "smallmap");    
  });
  		
}				

// --------------------------------
// Функция заполнения изображений
// --------------------------------
function forEach(data, callback) { 
	for(var key in data) { 
		if(data.hasOwnProperty(key)) { 
			callback(key, data[key]); 
		} 
	}
}

// ----------------------------------------------
// Логика
// ----------------------------------------------
export default {

// Входящие данные
props: ["categories", "regions", "lang"],

components: {  
  register,
  restore, 
  transport,
  realEstate,
  superInput,  
},

data () {
  
  return 	{  
  
  dialogMsg: "повторите позже",
  dialogTitleMsg: "Cервис временно не доступен",

  title: "",
  serviceUnavailable: false,
  subCategoryItems: [],    
  lastPhoneNumber: null,
	const_phone_max_length: 9,		
	coordinates_set: false,
	placeChanged: false,			
	category: null,
  subCategory: null,
	info: "",
	price: 0,
	number: 0,
	preview_images: [],
	real_images: [],
	root: false,
	regions_model: null,
	places: [],
	places_model: null,
	phone: "",		
	transport:false,			      // транспорт
	real_estate:false,			    // недвижимость
	appliances:false,			      // бытовая техника
	work_and_buisness:false,	  // работа и бизнес
	for_home:false,				      // для дома и дачи
	personal_effects:false,		  // личные вещи
	animals:false,				      // животные
	hobbies_and_leisure:false,	// хобби и отдых
	services:false,				      // услуги
	other:false					        // другое
  }
},

// компонент создан
created() {  

  document.getElementById("loader").style.display = "none";  

  // FIX?: заюзать require js для загрузки yandex модулей
  ymaps.ready(initMaps);  
  this.$root.advert_data = []; 
  this.advReset();    
},

// методы компонента
methods: {

// сервис не доступен
serviceError() {
  this.serviceUnavailable=true;
  $("#MsgModalDialog").modal("show"); // отобразить окно
},

// Выбор подкатегории
changeSubCategory() {
  this.subCategory=="null"?this.$store.commit("ShowFinalFields", false):this.$store.commit("ShowFinalFields", true);  
  this.$root.advert_data.adv_subcategory=this.subCategory;
},

// Заголовок
setTitle() {
	this.$root.advert_data.adv_title=this.title;
},

// доп. информация
setInfo() {
	this.$root.advert_data.adv_info=this.info;
},

// установить цену
setPrice() {  
  this.$root.advert_data.adv_price=this.price;
},

// указать номер
setPhone() {  
  this.$root.advert_data.adv_phone=this.phone;
},

// Вернуться на предыдущую страницу
closePage() {
   //window.history.back();   
   window.location="/";   
},

// ------------------------------
// обработка выбора региона
// ------------------------------
changeRegion() {

    this.$root.advert_data.region_id = this.regions_model;	  
    
	  // Получить города / сёлы
    get("api/getPlaces?region_id="+this.regions_model).then((res) => {
		  this.places=res.data;
		  this.places_model=null;
	  }).catch((err) => {
      this.serviceError();
    });

	},

	// -----------------------------------
	// обработка выбора местоположения
	// -----------------------------------
	changePlace() {

    if (this.places_model==null) 
      return; // не обрабатыать если null

	  let arr = this.places_model.replace(" ", "").split("@");
	  let city_id = arr[0];
	  let coords = arr[1];
	  let lanlng = coords.split(",")

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
// Загрузка изображений
// ------------------------------------------------
loadImage(evt) {
			  
	let root = this.$root;  
	let files = evt.target.files;			
	let input_images = document.querySelector("input[type=file]");	
	let preview_images = this.preview_images;		
	let real_images = this.real_images;

	  if (input_images.files.length + preview_images.length > this.$root.max_loaded_images) 
		  return;
		
	  for (let i=0; i<files.length; i++) {
      if (i===this.$root.max_loaded_images) 
        break;

		  // если уже существует, не обрабатывать изображение
		  for (let j=0; j<preview_images.length; j++)
			  if (files[i].name==preview_images[j].name)
			  	return false;

      let image = files[i]
		  let reader = new FileReader();

  	  reader.onload = (function(theFile) {

      return function(e) {
    
      if (theFile.type=="image/jpeg" || theFile.type=="image/pjpeg" || theFile.type=="image/png") {					
			  preview_images.push({ "name": theFile.name, "src": e.target.result });
			  real_images.push(theFile);
		  }
		  else
        alert("Только изображения")
      };

		})(image);		  
			reader.readAsDataURL(image);			
  }
    
  input_images.value = "";
  
},

// -------------------------
// Удаление фото по щелчку
// -------------------------
deletePhoto(index) {
	document.querySelector("input[type=file]").value = "";
	this.preview_images.splice(index, 1);
	this.real_images.splice(index, 1);
},


// --------------------------------------
// сброс данных объявления
// --------------------------------------
advReset(category_data) {

    this.$store.commit("SetShowPrice", true);
    this.serviceUnavailable=false;

    let form = document.getElementById("advertform");

    this.subCategory=null; // сбрасываю подкатегории

    if (form) 
      form.reset();        

    this.$root.advert_data.adv_subcategory  = null;
    this.$root.advert_data.adv_info         = null;
    this.$root.advert_data.adv_price        = null;
    this.$root.advert_data.adv_phone        = null;

    // сброс моделей    
    this.price = null;
    this.info = "";
    this.phone = "";
    this.regions_model = null;
    this.places_model = null;
    this.preview_images = [];
    this.coordinates_set = false;

    // сброс категорий
    if (category_data!=null) {
    this.root=false;				        // по умолчанию
    this.transport=false;			      // транспорт
    this.real_estate=false;			    // недвижимость
    this.appliances=false;			    // электроника
    this.work_and_buisness=false; 	// работа и бизнес
    this.for_home=false;			      // для дома и дачи
    this.personal_effects=false;	  // личные вещи
    this.animals=false;				      // животные
    this.hobbies_and_leisure=false;	// хобби и отдых
    this.services=false;			      // услуги
    this.other=false;				        // другое
  }

  // сбрасываю фотки
  let photos = document.querySelector("input[type=file]");

  if (photos!=null) 
    photos.value = "";

},

// --------------------------------------
// Изменения в категориях
// --------------------------------------
changeCategory() {

  let category = this.category;

  // сброс объявления при выборе категории
  this.advReset(category);

  // добавляю категории
  this.$root.advert_data.adv_category=category;             

  this.$store.commit("ShowFinalFields", false);  
  
  switch(this.category) {
    case null: {
      this.root=true;       
      break;
    }
    case 1: {              
      this.transport=true;       
      break; 
    } 
    case 2: {  
      this.real_estate=true;       
      break;
    } 
    case 3: {
      this.appliances=true;   
      break; 
    }
    case 4: {      
      this.$store.commit("SetShowPrice", false);  
      this.work_and_buisness=true;      
      break; 
    }
    case 5: {
      this.for_home=true;       
      break; 
    }
    case 6: {
      this.personal_effects=true;       
      break; 
    }
    case 7: {
      this.animals=true;            
      break; 
    }
    case 8: {
      this.hobbies_and_leisure=true;       
      break;
    }
    case 9: {      
      this.services=true;      
      break; 
    }
    case 10: {
      this.$store.commit("ShowFinalFields", true);  
      this.other=true;      
      break; 
      }
    }

    // Выборка только в конкретных категориях
    let subItems = [3, 4, 5, 6, 7, 8, 9];

    // -------------------------------
    // гружу названия подкатегорий
    // -------------------------------
    if (subItems.indexOf(this.category)!=-1) {
      // запрос
      get("api/getSubCategoryNamesById?id="+this.category).then((res) => {
		    this.subCategoryItems=res.data;
      }).catch((err) => {        
        this.serviceError();
      });
    }
},

// --------------------
// Отправить форму
// --------------------
onSubmit(evt) {  

  evt.preventDefault();

  $("#advert_loading_block").show();
  
  // объект формы
  let formData = new FormData();
  
  // записываю значения полей
  forEach(this.$root.advert_data, function(key, value) { formData.append(key, value); })
  
	// Записываю изображения
	for( let i=0; i < this.real_images.length; i++ )
      formData.append('images['+i+']', this.real_images[i]);		
						
  // ------------------------------------------------------------------------------------------------------------------------
  // Размещение объявления
  // ------------------------------------------------------------------------------------------------------------------------
	axios.post("/api/createAdvert", formData, { headers: { 'Content-Type': 'multipart/form-data' } }).then(response => {			              

    if (response.data.result=="error") {
      $("#advert_loading_block").hide();
       this.dialogTitleMsg = response.data.title;
       //this.dialogMsg = response.data.msg;
       console.error(response.data.msg);
       this.serviceError();
    }
		else {
      $("#advert_loading_block").hide();
      $("#AdPostedModal").modal("show");		  
    }		
    }).catch(error => {
      $("#advert_loading_block").hide();
		  this.serviceError();
	  })
  },

  // -------------------------------------
	// Показать диалог выбора расположения
	// -------------------------------------
	showSetCoordsDialog() {    
        
    this.serviceUnavailable=false;
    
    $("#MsgModalDialog").modal("show"); // отобразить окно

    if (!navigator.geolocation) {    
      console.log("navigator.geolocation error"); // navigator.geolocation не поддерживается
    }		    
    else {
			  navigator.geolocation.getCurrentPosition(function(position) {				
			  let lat = position.coords.latitude;
			  let lon = position.coords.longitude;
			  let geoCoords=[lat,lon];
			  myPlacemark.geometry.setCoordinates(getCoords);				
			});
		}
	},

	// ---------------------------------
	// Установить координаты
	// ---------------------------------
	setCoords() {

    $("#MsgModalDialog").modal("hide"); // скрыть окно

		this.$root.advert_data.adv_coords=[];
		this.$root.advert_data.adv_coords=mapCoords;
		this.coordinates_set=true;
	}
}

}
</script>