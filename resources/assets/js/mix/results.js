"use strict";

require('./bootstrap');

import Vue from 'vue';
import { get } from '../helpers/api' // axios

// --------------------------
// экземляр приложения vue
// --------------------------
export default new Vue ({

  el: '#app',

  data () {   
    return {
      //subcategoryId: null,
      priceFrom: null,
      priceTo: null
    }
  },

  delimiters: ['${', '}'], // для разрешения конфликта c переменными php
  components: {},

  // -------------------------------
  // Компонент создан
  // -------------------------------
  created() {
    //alert(this.subcategoryId)
    this.priceFrom=0;
    this.priceTo=1000;
  },

  // --------------------------------------
  // Методы
  // --------------------------------------
  methods: {
    filter() {
      alert("!")
    }
  }
  
});