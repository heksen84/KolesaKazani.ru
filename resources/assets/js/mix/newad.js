"use strict"; // строгий режим
require('./bootstrap');

import Vue from 'vue';
import $ from "jquery";
import bootstrap from "bootstrap";
import Vuex from 'vuex';
import { get } from '../helpers/api' // axios
//import transport from './subcategories/transport' // компонент транспорт
import transport from './subcategories/transport.vue' // компонент транспорт


// Подрубить компоненты (транспорт, недвижимость)

Vue.use(Vuex);

// массив изображений
let preview_images_array=[];
let mapCoords=[];
let myPlacemark1=null;
let myPlacemark2=null;
let bigmap=null;
let smallmap=null;

// --------------------------------------
// Преобразует строку в массив
// Вынести в отдельный модуль
// --------------------------------------
function str_split(string, length) {  
  
  var chunks, len, pos;
  string = (string == null) ? "" : string;
  length =  (length == null) ? 1 : length;    
  var chunks = [];
  var pos = 0;
  var len = string.length;  
  
  while (pos < len) {
    chunks.push(string.slice(pos, pos += length));
  }      
  
  return chunks;
};
	
// --------------------------------------
// Склоняем словоформу
// Вынести в отдельный модуль
// --------------------------------------
function morph(number, titles) {
 var cases = [2, 0, 1, 1, 1, 2];
   return titles[ (number>4 && number<20)? 2 : cases[Math.min(number, 5)] ];
};
	
// --------------------------------------
// Возвращает сумму прописью
// Вынести в отдельный модуль
// --------------------------------------
function number_to_string (num) {
  var def_translite = {
    null: 'ноль',
    a1: ['один','два','три','четыре','пять','шесть','семь','восемь','девять'],
    a2: ['одна','две','три','четыре','пять','шесть','семь','восемь','девять'],
    a10: ['десять','одиннадцать','двенадцать','тринадцать','четырнадцать','пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать'],
    a20: ['двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят','восемьдесят','девяносто'],
    a100: ['сто','двести','триста','четыреста','пятьсот','шестьсот','семьсот','восемьсот','девятьсот'],
		uc: ['тиын', 'тиын', 'тиын'],
		//uc: ['копейка', 'копейки', 'копеек'],
		//ur: ['рубль', 'рубля', 'рублей'],
		ur: ['тенге', 'тенге', 'тенге'],
    u3: ['тысяча', 'тысячи', 'тысяч'],
    u2: ['миллион', 'миллиона', 'миллионов'],
    u1: ['миллиард', 'миллиарда', 'миллиардов'],
  }
		
	var i1, i2, i3, kop, out, rub, v, zeros, _ref, _ref1, _ref2, ax;
    
    _ref = parseFloat(num).toFixed(2).split('.'), rub = _ref[0], kop = _ref[1];
    var leading_zeros = 12 - rub.length;
    if (leading_zeros < 0) {
        return false;
    }
    
    var zeros = [];
    while (leading_zeros--) {
        zeros.push('0');
    }
    rub = zeros.join('') + rub;
    var out = [];
    if (rub > 0) {
        // Разбиваем число по три символа
        _ref1 = str_split(rub, 3);
        for (var i = -1; i < _ref1.length;i++) {
            v = _ref1[i];
            if (!(v > 0)) continue;
            _ref2 = str_split(v, 1), i1 = parseInt(_ref2[0]), i2 = parseInt(_ref2[1]), i3 = parseInt(_ref2[2]);
            out.push(def_translite.a100[i1-1]); // 1xx-9xx
            ax = (i+1 == 3) ? 'a2' : 'a1';
            if (i2 > 1) {
                out.push(def_translite.a20[i2-2] + (i3 > 0 ?  ' ' + def_translite[ax][i3-1] : '')); // 20-99
            } else {
                out.push(i2 > 0 ? def_translite.a10[i3] : def_translite[ax][i3-1]); // 10-19 | 1-9
            }
            
            if (_ref1.length > i+1){
                var name = def_translite['u'+(i+1)];
                out.push(morph(v,name));
            }
        }
    } else {
        out.push(def_translite.null);
    }
    // Дописываем название "рубли"
    out.push(morph(rub, def_translite.ur));
    
    // Дописываем название "копейка"
    //out.push(kop + ' ' + morph(kop, def_translite.uc));
    
    // Объединяем маcсив в строку, удаляем лишние пробелы и возвращаем результат
    return out.join(' ').replace(RegExp(' {2,}', 'g'), ' ').trimLeft();
};
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
  
    // формирую метки
	  myPlacemark1 = new ymaps.Placemark(mapCoords);
    myPlacemark2 = new ymaps.Placemark(mapCoords);

	  // добавляю метки на карты
	  bigmap.geoObjects.add(myPlacemark1);
	  smallmap.geoObjects.add(myPlacemark2);
    bigmap.events.add("click", function (e) {
    mapCoords = e.get("coordPosition");
	  myPlacemark1.geometry.setCoordinates(mapCoords);
	  myPlacemark2.geometry.setCoordinates(mapCoords);
    smallmap.setCenter(mapCoords, 14, "smallmap");

	});			
}				

// --------------------------------------
// Для заполнения изображений
// --------------------------------------
function forEach(data, callback) { 
	for(var key in data) { 
		if(data.hasOwnProperty(key)) { 
			callback(key, data[key]); 
		} 
	}
}

// --------------------------------------
// Хранилище
// --------------------------------------
const store = new Vuex.Store({

  state: {          
    price: "", 
    required_info: false,
    info_label_description: "",
    placeholder_info_text:  "",      
    show_final_fields: false,
    show_common_transport: false,
    deal_selected: false,    
    str_realestate_area_label_text: ""
  },

  mutations: {
     SetDealSelected( state, value ) {
      state.deal_selected=value;
    },

    // установить заголовок для площади в недвижимости
    SetRealEstateAreaLabelText( state, text ) {
      text=="default"?state.str_realestate_area_label_text = "Площадь (кв.м.):":state.str_realestate_area_label_text = text;
    },

    // установить заголовок доп. информации / текста объявления
    SetInfoLabelDescription( state, text ) {
      text=="default"?state.info_label_description = "Текст объявления":state.info_label_description = text;
    },

    // установить текст подсказки в поле описание
    SetPlaceholderInfoText(state, text) {
      text=="default"?state.placeholder_info_text = "Введите текст объявления":state.placeholder_info_text = text;
    },

    // сбросить содержимое поля
    ResetField(state, field_name) {
      switch(field_name) {
        case "price": state.price=""; break;
      }
    },        

    SetRequiredInfo (state, value) {
      state.required_info=value;
    },

    ShowFinalFields (state, value) {
      state.show_final_fields=value;
    },

    ShowCommonTransport (state, value) {
      state.show_common_transport=value;
    }
  }
})

// экземляр приложения vue
export default new Vue ({  
  el: "#app",
  store,
  data () {   
    return {            
      advert_data: {}, // Объект объявления который пойдёт на сервер      
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

  delimiters: ['${', '}'], // для разрешения конфликта c переменными php
  
  components: { 
    bootstrap,
    transport
  },

  // -------------------------------
  // Компонент создан
  // -------------------------------
  created() { $(".hide").show(); $("#loading").hide(); /*ymaps.ready(initMaps);*/ },  
  // --------------------------------------
  // Методы
  // --------------------------------------
  methods: {
   
  // Вернуться на предыдущую страницу
  closeAndReturn() { window.history.back(); },

  // сброс данных объявления
  advReset(category_data) {

    let form = document.getElementById("advertform");
    if (form) form.reset();

    this.summ_str = "";
    this.$store.commit("SetRequiredInfo", false);
    this.$store.commit("SetPlaceholderInfoText", "default");
    this.$store.commit("SetDealSelected", false);

    // сброс массива объявления и переинициализация его
    this.advert_data = [];

    // ----------------------------------------------------------------------------------------------------------------
    // Не использовать операции сделки во всех категориях, т.к. пользователь может ввести описание объявления сам. 
    // Типа: Продам то-то-то-то или Куплю то-то-то-то
    // ----------------------------------------------------------------------------------------------------------------
    switch(category_data) {
        case 3: this.advert_data.adv_deal = ""; break; 
        case 4: this.advert_data.adv_deal = ""; break; 
        case 5: this.advert_data.adv_deal = ""; break; 
        case 6: this.advert_data.adv_deal = ""; break; 
        case 7: this.advert_data.adv_deal = ""; break; 
        case 8: this.advert_data.adv_deal = ""; break; 
        case 9: this.advert_data.adv_deal = ""; break; 
        case 10: this.advert_data.adv_deal = ""; break; 
      default: this.advert_data.adv_deal = 0; // покупка по умолчанию
    }
      
    //this.$root.advert_data.adv_deal = 0; // покупка по умолчанию

    this.advert_data.adv_info = null; // добавляю формально поле доп. информация
    this.advert_data.adv_price = "";
    this.advert_data.adv_phone1 = "";

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
  this.advert_data.adv_category=category;        
  
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

  // --------------------------------------
  // Выбрать сделку
  // --------------------------------------
  setDeal(deal_id) {    
    this.advert_data.adv_deal=deal_id;
    this.deal_id=deal_id;
    this.$store.commit("SetDealSelected", true);
  },

  // Отправить форму
  onSubmit(evt) {
    evt.preventDefault();
    
		var formData = new FormData();

		// устанавливаю цену если она пустая, т.к. бэкенду нужна цена
		if (this.$root.advert_data.adv_price==null || this.$root.advert_data.adv_price=="")       
    this.$root.advert_data.adv_price=0;
		
		// записываю значения полей
		forEach(this.$root.advert_data, function(key, value) { formData.append(key, value); })

		// Записываю изображения
		for( var i=0; i < this.real_images.length; i++ )
      formData.append('images['+i+']', this.real_images[i]);		
						
		// Размещаю объявление
		axios.post("/create", formData, { headers: { 'Content-Type': 'multipart/form-data' } }).then(response => {			
      
      console.log(response);
    			
      if (response.data.result=="db.error") 
        this.$root.$notify({group: 'foo', text: "<h6>Неполадки в работе сервиса. Приносим свои извинения.</h6>", type: 'error'});
		  else
		    if (response.data.result=="usr.error") this.$root.$notify({group: 'foo', text: "<h6>"+response.data.msg+"</h6>", type: 'error'});
		  else
		    alert("Объявление размещено");
		  //	else 
		  //	window.location="home"; // переходим в личный кабинет
    }).catch(error => {
			console.log(error.response)
			this.$root.$notify({group: 'foo', text: "<h6>Невозможно отправить запрос. Проверьте подключение к интернету.</h6>", type: 'error'});
		})
  }
}  
});