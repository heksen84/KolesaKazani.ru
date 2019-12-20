"use strict";

require('./bootstrap');

import Vue from 'vue';
import { get } from '../helpers/api'
import filtertransport from './views/components/filterTransport'

// --------------------------
// экземляр приложения vue
// --------------------------
export default new Vue ({

  el: '#app',

  components: { filtertransport },

  data () {   
    return {
    }
  },

  // -------------------------------
  // Компонент создан
  // -------------------------------
  created() {},

  // --------------------------------------
  // Методы
  // --------------------------------------
  methods: {
    filter() {
      alert("!")
    }
  }
  
});