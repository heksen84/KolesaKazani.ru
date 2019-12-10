"use strict";

require('./bootstrap');

import Vue from 'vue';
import $ from "jquery";
import bootstrap from "bootstrap";
import { get } from '../helpers/api' // axios

// --------------------------
// экземляр приложения vue
// --------------------------
export default new Vue ({

  el: '#app',

  data () {   
    return {      
      placesList: [], // массив городов / сёл / деревень
      regions: true,    
      places: false,
      categories: true,
      subCategories: false,
      locationName: "",
      tmpLocationName: "",
      searchString: ""
    }
  },

  delimiters: ['${', '}'], // для разрешения конфликта c переменными php

  components: {    
    bootstrap
  },

  // -------------------------------
  // Компонент создан
  // -------------------------------
  created() {    
    $("#subcats").show();
    $("#close_subcats_btn").show();    
  },

  // --------------------------------------
  // Методы
  // --------------------------------------
  methods: {
  
  // Отобразить окно расположения
  showLocationWindow() {
    $("#locationModal").modal("show");
  },
  
  // Закрыть окно расположения
  closeLocationWindow() {
    this.regions=true;
    this.places=false;
    $("#locationModal").modal("hide");    
  },
  
  // --------------------------------------
  // Выбор региона
  // --------------------------------------
  showPlacesByRegion(e, regionId) {
    e.preventDefault();

    this.tmpLocationName=e.target.innerText;

    // Получить города / сёлы
    get("api/getPlaces?region_id="+regionId).then((res) => {    
      this.placesList=res.data;
      this.regionUrl=e.target.pathname;
      this.regions=false;
      this.places=true;
    }).catch((err) => { console.log(err) });    
  },


  // --------------------------------------
  // Поиск в регионе
  // --------------------------------------
  search(e) {              
    
    e.preventDefault();

    if (this.searchString=="about::author") {      
      window.location = "https://moikrug.ru/heksen";
    }

  },

  // --------------------------------------
  // Поиск в стране
  // --------------------------------------
  searchInCountry(e) {

    localStorage.setItem("locationUrl", "");    
    localStorage.setItem("locationName", "Весь Казахстан");

    // редирект
    window.location = "/";
  },

  // --------------------------------------
  // Поиск в регионе
  // --------------------------------------
  searchInRegion(e) {
    window.location = this.regionUrl;
  },
  
  // --------------------------------------
  // Выбрать город / село и т.п.
  // --------------------------------------
  selectPlace(e, placeName, placeUrl) {    
    e.preventDefault();
    window.location = this.regionUrl+"/"+placeUrl;
  },

  // --------------------------------------
  // Показать подкатегории
  // --------------------------------------
  showSubcategories(e, categoryId) {

    if ( categoryId < 10 ) {
      e.preventDefault();        

      // получаю элементы
      let elements = $("*[data-category-id='"+(categoryId)+"']");

      // сбиваю в кучу их если кол-во меньше 4	      
      if (elements.length < 4)
       elements.addClass("col-xl-12")	
    
      // отображаю
      elements.show();

      this.categories=false;
      this.subCategories=true;
    }

  },

  // --------------------------------------
  // Вернуться к категориям
  // --------------------------------------
  returnToCategories() {    
    $("*[data-category-id]").hide();
    this.categories=true;
    this.subCategories=false;    
  }
}
  
});