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
      tmpLocationName: ""     
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

    // Отобразить отложенные данные
    $(".deferred").show();
    $("#subcats").show();
        
    // Вытаскивыю местоположение из локалстораджа
    var locationUrl = localStorage.getItem("locationUrl");
    var locationName = localStorage.getItem("locationName");
    
    if (locationUrl!=null) {
      this.locationName = locationName;      
      $( ".url" ).each(function( index ) {      
        $(this).attr("href", locationUrl+$(this).data("default-url"));
      });
    }

    // Показываю то, что скрыто
//    $("#locationButton").show();
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
    get("getPlaces?region_id="+regionId).then((res) => {    
      this.placesList=res.data;
      this.regionUrl=e.target.pathname;
      this.regions=false;
      this.places=true;
    }).catch((err) => { console.log(err) });    
  },

  // --------------------------------------
  // Поиск в стране
  // --------------------------------------
  searchInCountry(e) {

    this.locationName=e.target.innerText;
  
    $( ".url" ).each(function( index ) {      
      $(this).attr("href", $(this).data("default-url"))      
    });

    localStorage.setItem("locationUrl", "");
    localStorage.setItem("locationName", this.locationName);
  
    this.closeLocationWindow();
  },

  // --------------------------------------
  // Поиск в регионе
  // --------------------------------------
  searchInRegion(e) {    
    
    let self=this;    
    this.locationName=this.tmpLocationName;
  
    $( ".url" ).each(function( index ) {      
      $(this).attr("href", self.regionUrl+$(this).data("default-url"))      
    });

    localStorage.setItem("locationUrl", self.regionUrl);
    localStorage.setItem("locationName", this.locationName);
  
    this.closeLocationWindow();
  },
  
  // --------------------------------------
  // Выбрать город / село и т.п.
  // --------------------------------------
  selectPlace(e, placeName, placeUrl) {
    e.preventDefault();

    let self=this;
    
    this.locationName=placeName;
    this.closeLocationWindow();

    $( ".url" ).each(function( index ) {      
      $(this).attr("href", self.regionUrl+"/"+placeUrl+$(this).data("default-url"))      
    });

    localStorage.setItem("locationUrl", self.regionUrl+"/"+placeUrl);
    localStorage.setItem("locationName", this.locationName);

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