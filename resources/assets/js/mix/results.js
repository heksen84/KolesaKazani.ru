"use strict";

require('./bootstrap');

import Vue from 'vue';
//import $ from "jquery";
//import bootstrap from "bootstrap";
import { get } from '../helpers/api' // axios

// --------------------------
// экземляр приложения vue
// --------------------------
export default new Vue ({

  el: '#app',

  data () {   
    return {}
  },

  delimiters: ['${', '}'], // для разрешения конфликта c переменными php

  components: { //bootstrap 
  },

  // -------------------------------
  // Компонент создан
  // -------------------------------
  created() {
    alert("i'm ready!")
  },

  // --------------------------------------
  // Методы
  // --------------------------------------
  methods: {}
  
});