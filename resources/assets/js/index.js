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
    $("#locationModal").modal("hide");
  },


}
  
});