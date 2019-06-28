require('./bootstrap');

import data from './data';
import Vue from 'vue';
import $ from "jquery";

import popperjs from "popper.js";
import bootstrap from "bootstrap";

// экземляр приложения vue
export default new Vue({
  el: '#app',
  data: data,
  delimiters: ['${', '}'], // что-бы не было конфликта переменных с php
  components: {
    popperjs,
    bootstrap
  },

  created() {
  },

  methods: {

	showLocationWindow() {
    $("#locationModal").modal("show");
  },
  
  closeLocationWindow() {
    this.regions=true;
    this.places=false;
    $("#locationModal").modal("hide");    
  },
  
  showPlacesByRegion(event, regionId) {
    event.preventDefault();    
    alert(regionId)    
    this.regions=false;
    this.places=true;
  }


}
  
});