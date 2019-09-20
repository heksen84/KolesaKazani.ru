<template>
<div class="container-fluid mycontainer_adv">  
    <div class="row">  
        <div class="col-sm-12 col-md-12 col-lg-10 col-xl-10 create_advert_col">
        <div class="close_button" title="Закрыть страницу" style="font-weight:bold" @click="closeAndReturn">X</div>
		    <h1 class="title_text" style="margin-top:12px">подать объявление</h1>
            <hr>
            <div style="margin-bottom:10px">
            <label style="width:270px">Вид сделки:</label>
            <div class="form-check" style="width:260px">
              <div v-for="(item,index) in dealtypes" :key="index">
                <input class="form-check-input" :id="item.id" type="radio" name="inlineRadioOptions" v-bind:value="item.id" v-model="sdelka" @change="setDeal">
                <label class="form-check-label" :for="item.id">{{ item.deal_name_1 }}</label>
              </div>
            </div>
            </div>

            <div class="row form-group" v-if="sdelka!=null">
                <div class="col-md-4">
                  <label for="categories">Категория товара или услуги:</label>
                    <select class="form-control" v-model="category" @change="changeCategory">            
                      <option v-bind:value="null">-- Выберите категорию --</option>
                      <option v-for="(item, index) in categories" :key="index" v-bind:value="item.id">{{ item.name }}</option>
                    </select>                
                </div>
            </div>    
            
            <form id="advertform" @submit="onSubmit" v-if="sdelka!=null">  
              <!-- Категории -->
		          <div v-if="root"></div>
                <transport v-else-if="transport"/>
                <!--<h1 v-else-if="transport">transport</h1>
                <h1 v-else-if="real_estate">nedvizh</h1>-->
            </form>

            <!-- Дополнительные поля -->			      
            <div v-show="$store.state.show_final_fields">
              <label for="addit_info">{{ $store.state.info_label_description }}</label>
                <textarea id="addit_info" v-if="!$store.state.required_info" class="form-control form-group" :placeholder="$store.state.placeholder_info_text" :rows="4" :max-rows="4" @input="setInfo" v-model="info"></textarea>
                  <div class="row">

                    <div class="col-md-12 text-center" v-if="sdelka!=3">
                      <span style="margin-right:5px">Цена:</span>
                      <input type="text" placeholder="0" class="form-group" id="price" :formatter="setPrice" v-model="price" style="margin-right:45px;width:120px;border:1px solid grey;border-radius:3px;padding:5px;text-align:center" required/>
                    </div>
                                                                                                      ;
                    <div class="col-md-12">
                      <hr>
                      <label class="form-group">Контакты:</label>                            
                    </div>

                    <div class="col-md-12 text-center">
                      <button type="button" class="btn btn-success btn-sm form-group" @click="addPhoneNumber">+ Добавить номер</button>
                      <!--<p style="color:red" v-if="$store.state.phonesArr.length>=5">не более 5 номеров</p>
                      <p style="color:red" v-if="lastPhoneNumber==='' && $store.state.phonesArr.length>0">введите номер</p>-->
                    </div>
                  </div>

                  <div class="row">                    
                    <div class="col-md-12 text-center" v-for="(i, index) in $store.state.phonesArr.length" :key="index">
                      <phoneNumberInput :index=index :value=$store.state.phonesArr[index] :name="index"></phoneNumberInput>
                    </div>
                  </div>

                  <div class="row" v-if="$store.state.phonesArr.length>0">                  
                  <br>

                  <div class="col-md-12">
                    <label class="form-group">Фотографии:</label>
                  </div>

                  <div class="col-md-12 text-center">
                    <img v-for="(i, index) in preview_images" :src="i.src" :key="i.name" @click="deletePhoto(index)" class="image" :title="i.name"/>
                  </div>

                  <div class="col-md-12 text-center">
                    <br>                    
                    <input @change="loadImage" name="input2[]" type="file" class="form-group" accept=".png, .jpg, .jpeg" multiple data-show-upload="true" data-show-caption="true">
                  </div>

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
                  
                  <!--
                  <p>фотографии</p>
                  <p>регионы</p>
                  <p>местность</p>
                  <p>расположение на карте</p>
                  <p>кнопка опубликовать</p>-->

                  <div class="col-md-12 text-center" v-if="$store.state.phonesArr.length>0">
                    <hr>
                    <button type="button" class="btn btn-success form-group">опубликовать</button>                    
                  </div>
                </div>                
            </div>
        </div>
    </div>
</div>
</template>
<script>

import { post, get } from '../../helpers/api'
import transport from "./subcategories/transport.vue"
import phoneNumberInput from "./components/phoneNumberInput.vue"

// -----------------------
// Логика
// -----------------------
export default {

// Входящие данные
props: ["categories", "dealtypes", "regions"],

components: { 
  transport,
  phoneNumberInput
},

data () {
  return 	{    
    lastPhoneNumber: null,
		summ_str: "",
		const_phone1_max_length: 9,			
		setCoordsDialog: false,
		coordinates_set: false,
		placeChanged: false,			
		category: null,
		sdelka: null,
		deal_id: null,
		info: "",
		price: "",
		number: 0,
		preview_images: [],
		real_images: [],
		root: false,
		regions_model: null,
		places: [],
		places_model: null,
		phone1: "",
		phone2: "",
		phone3: "",
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

// методы компонента
methods: {

// доп. информация
setInfo() {
	this.$root.advert_data.adv_info=this.info;
},

// установить цену
setPrice() {
/*			
	if (price < 0 || price > 10000000000) 
			return this.price;

	this.price = price;
	this.$root.advert_data.adv_price = price;			
	this.summ_str = number_to_string(price);

  return price;*/
},

addPhoneNumber() {

  this.lastPhoneNumber = this.$store.state.phonesArr[this.$store.state.phonesArr.length-1];
  if (this.lastPhoneNumber!="" && this.$store.state.phonesArr.length<5) {
    this.$store.commit("AddPhoneNumber")
  }          
},

// --------------------------------------
// Вернуться на предыдущую страницу
// --------------------------------------
closeAndReturn() {
 	window.history.back();
},

// обработка выбора региона
changeRegion() {

	this.$root.advert_data.region_id = this.regions_model;

	// -------------------------------
	// Получить города / сёлы
	// -------------------------------
  get("getPlaces?region_id="+this.regions_model).then((res) => {
		this.places=res.data;
		this.places_model=null;
      console.log(res.data);
	  }).catch((err) => {});			  
	},

	// -----------------------------------
	// обработка выбора местоположения
	// -----------------------------------
	changePlace() {

  if (this.places_model==null) 
    return; // не обрабатыать если null

	var arr = this.places_model.replace(" ", "").split("@");
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
// Загрузка изображений
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
		//	else
		//	root.$notify({group: 'foo', text: "<h6>Только изображения!</h6>", type: 'error'});				
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

  let form = document.getElementById("advertform");

  if (form) form.reset();

  this.summ_str = "";
  this.$store.commit("SetRequiredInfo", false);
  this.$store.commit("SetPlaceholderInfoText", "default");
  this.$store.commit("SetDealSelected", false);

  // сброс массива объявления и переинициализация его
  //this.$root.advert_data = [];
  this.$root.advert_data = {};

  // ----------------------------------------------------------------------------------------------------------------
  // Не использовать операции сделки во всех категориях, т.к. пользователь может ввести описание объявления сам. 
  // Типа: Продам то-то-то-то или Куплю то-то-то-то
  // ----------------------------------------------------------------------------------------------------------------
  switch(category_data) {
    case 3: this.$root.advert_data.adv_deal = ""; break; 
    case 4: this.$root.advert_data.adv_deal = ""; break; 
    case 5: this.$root.advert_data.adv_deal = ""; break; 
    case 6: this.$root.advert_data.adv_deal = ""; break; 
    case 7: this.$root.advert_data.adv_deal = ""; break; 
    case 8: this.$root.advert_data.adv_deal = ""; break; 
    case 9: this.$root.advert_data.adv_deal = ""; break; 
    case 10: this.$root.advert_data.adv_deal = ""; break; 
    default: this.$root.advert_data.adv_deal = 0; // покупка по умолчанию
  }
      
  //this.$root.advert_data.adv_deal = 0; // покупка по умолчанию    

  this.$root.advert_data.adv_info = null; // добавляю формально поле доп. информация
  this.$root.advert_data.adv_price = "";
  this.$root.advert_data.adv_phone1 = "";

  // сброс моделей
  this.sdelka = 0;
  this.price = "";
  this.info = "";
  this.phone1 = "";
  this.phone2 = "";
  this.phone3 = "";
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
if (photos!=null) photos.value = "";

},

// --------------------------------------
// Выбрать сделку
// --------------------------------------
setDeal() {    
  //console.log("Сделка: "+this.sdelka)
  this.$root.advert_data.adv_deal=this.sdelka;
  this.deal_id=this.sdelka;
  this.$store.commit("SetDealSelected", true);
},

// --------------------------------------
// сброс данных объявления
// --------------------------------------
advReset(category_data) {

    let form = document.getElementById("advertform");
    if (form) form.reset();

    this.summ_str = "";
    this.$store.commit("SetRequiredInfo", false);
    this.$store.commit("SetPlaceholderInfoText", "default");
    this.$store.commit("SetDealSelected", false);

    // сброс массива объявления и переинициализация его
    //this.$root.advert_data = [];
    this.$root.advert_data = {};

    // ----------------------------------------------------------------------------------------------------------------
    // Не использовать операции сделки во всех категориях, т.к. пользователь может ввести описание объявления сам. 
    // Типа: Продам то-то-то-то или Куплю то-то-то-то
    // ----------------------------------------------------------------------------------------------------------------
    switch(category_data) {
      case 3: this.$root.advert_data.adv_deal = ""; break; 
      case 4: this.$root.advert_data.adv_deal = ""; break; 
      case 5: this.$root.advert_data.adv_deal = ""; break; 
      case 6: this.$root.advert_data.adv_deal = ""; break; 
      case 7: this.$root.advert_data.adv_deal = ""; break; 
      case 8: this.$root.advert_data.adv_deal = ""; break; 
      case 9: this.$root.advert_data.adv_deal = ""; break; 
      case 10: this.$root.advert_data.adv_deal = ""; break; 
      default: this.$root.advert_data.adv_deal = 0; // покупка по умолчанию
    }
      
    //this.$root.advert_data.adv_deal = 0; // покупка по умолчанию

    this.$root.advert_data.adv_info = null; // добавляю формально поле доп. информация
    this.$root.advert_data.adv_price = "";
    this.$root.advert_data.adv_phone1 = "";

    // сброс моделей
    //this.sdelka = null;
    this.price = "";
    this.info = "";
    this.phone1 = "";
    this.phone2 = "";
    this.phone3 = "";
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
  if (photos!=null) photos.value = "";

},

// --------------------------------------
// Изменения в категориях
// --------------------------------------
changeCategory() {

  let category = this.category;

  // сброс объявления при выборе категории
  this.advReset(category);
  
  // -----------------------------------------------------------------
  // отрубить вид сделки в категориях: "работа и бизнес" и "услуги"
  // -----------------------------------------------------------------
  if (category == 4 || category == 9) { this.$store.commit("SetDealSelected", true); this.$store.commit("ShowFinalFields", true); }
  
  // добавляю категории
  this.$root.advert_data.adv_category=category;        
  
  // скрываю дополнительные поля
  this.$store.commit("ShowFinalFields", false);
  
  switch(this.category) {
    case null: {
      this.root=true; 
      this.$store.commit("ShowFinalFields", false);
      break;
    }
    case 1: {              
      this.transport=true; 
      this.$store.commit("ShowFinalFields", false);
      break; 
    } 
    case 2: {  
      this.real_estate=true; 
      this.$store.commit("ShowFinalFields", false);
      break;
    } 
    case 3: {
      this.appliances=true; 
      this.$store.commit("ShowFinalFields", true);
      this.$store.commit("SetRequiredInfo", true);
      this.$store.commit("SetPlaceholderInfoText", "Введите текст объявления, например: Продам телевизор Samsung б/у в отличном состоянии");
      break; 
    }
    case 4: {
      this.work_and_buisness=true;
      this.$store.commit("ShowFinalFields", true);
      this.$store.commit("SetRequiredInfo", true);
      this.$store.commit("SetPlaceholderInfoText", "Введите текст объявления, например: Требуются разнорабочие"); 
      break; 
    }
    case 5: {
      this.for_home=true; 
      this.$store.commit("ShowFinalFields", true);
      this.$store.commit("SetRequiredInfo", true);
      this.$store.commit("SetPlaceholderInfoText", "Введите текст объявления, например: Куплю картофель"); 
      break; 
    }
    case 6: {
      this.personal_effects=true; 
      this.$store.commit("ShowFinalFields", true);
      this.$store.commit("SetRequiredInfo", true);
      this.$store.commit("SetPlaceholderInfoText", "Введите текст объявления, например: Продам пуховик"); 
      break; 
    }
    case 7: {
      this.animals=true;
      this.$store.commit("ShowFinalFields", true);
      this.$store.commit("SetRequiredInfo", true);					
      this.$store.commit("SetPlaceholderInfoText", "Введите текст объявления, например: Продам щенков хаски"); 
      break; 
    }
    case 8: {
      this.hobbies_and_leisure=true; 
      this.$store.commit("ShowFinalFields", true);
      this.$store.commit("SetRequiredInfo", true);
      break;
    }
    case 9: { 
      this.services=true;
      this.$store.commit("ShowFinalFields", true);
      this.$store.commit("SetRequiredInfo", true);
      this.$store.commit("SetPlaceholderInfoText", "Введите текст объявления, например: Распечатка текста"); 
      break; 
    }
    case 10: {
      this.other=true;
      this.$store.commit("ShowFinalFields", true);
      this.$store.commit("SetRequiredInfo", true);
      break; 
      }
    }
},

// --------------------
// Отправить форму
// --------------------
onSubmit(evt) {

  evt.preventDefault();
    
  // объект формы
  var formData = new FormData();

	// устанавливаю цену если она пустая, т.к. бэкенду нужна цена
	if (this.$root.advert_data.adv_price==null || this.$root.advert_data.adv_price=="")       
    this.$root.advert_data.adv_price=0;
		
	// записываю значения полей
	forEach(this.$root.advert_data, function(key, value) { formData.append(key, value); })

	// Записываю изображения
	for( var i=0; i < this.real_images.length; i++ )
      formData.append('images['+i+']', this.real_images[i]);		
						
  // ------------------------------
  // Размещение объявление
  // ------------------------------
	axios.post("/create", formData, { headers: { 'Content-Type': 'multipart/form-data' } }).then(response => {			
      
    console.log(response);
    			
    if (response.data.result=="db.error") 
      //this.$root.$notify({group: 'foo', text: "<h6>Неполадки в работе сервиса. Приносим свои извинения.</h6>", type: 'error'});
      alert("Неполадки в работе сервиса. Приносим свои извинения.")
		else
      if (response.data.result=="usr.error") 
       this.$root.$notify({group: 'foo', text: "<h6>"+response.data.msg+"</h6>", type: 'error'});
		else
		  alert("Объявление размещено");
		//	else 
		//	window.location="home"; // переходим в личный кабинет
    }).catch(error => {
		console.log(error.response)
		//this.$root.$notify({group: 'foo', text: "<h6>Невозможно отправить запрос. Проверьте подключение к интернету.</h6>", type: 'error'});
	  })
  }
}

}
</script>