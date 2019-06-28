require('./bootstrap');

import data from './data';
import Vue from 'vue';
import $ from "jquery";

import popperjs from "popper.js";
import bootstrap from "bootstrap";
import { get } from './helpers/api' // axios

// экземляр приложения vue
export default new Vue({
  el: '#app',
  data: data,
  delimiters: ['${', '}'], // что-бы не было конфликта c переменными php
  components: {
    popperjs,
    bootstrap
  },

  created() {},

  methods: {

	showLocationWindow() {
    $("#locationModal").modal("show");
  },
  
  closeLocationWindow() {
    this.regions=true;
    this.places=false;
    $("#locationModal").modal("hide");    
  },
  
  // Выбор региона
  showPlacesByRegion(e, regionId) {        
    e.preventDefault();

    // Получить города / сёлы
    get("getPlaces?region_id="+regionId).then((res) => {
      
      this.placesList=res.data;
      this.regions=false;
      this.places=true;

    }).catch((err) => { console.log(err) });    
  },

  // Выбор расположения
  selectPlace(e, placeName) {      
    e.preventDefault();
    this.locationName=placeName;
    this.closeLocationWindow();
  }


}
  
});