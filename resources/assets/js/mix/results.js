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
    return {}
  },

  delimiters: ['${', '}'], // для разрешения конфликта c переменными php
  components: {    
    bootstrap
  },

  // -------------------------------
  // Компонент создан
  // -------------------------------
//  created() { alert("i'm ready!"); },

  // --------------------------------------
  // Методы
  // --------------------------------------
  methods: {
  changePage(e, totalRecords) {
    e.preventDefault();    
  
    var firstVal = parseInt($( ".pageNum" ).first().text());
    var lastVal = parseInt($( ".pageNum" ).last().text());
    var opNav = e.target.attributes[1].nodeValue;
    
    if (opNav==="prev" && firstVal > 1) {
      $( ".pageNum" ).each(function( index ) {
        var item = $(this).text();
        $(this).text(parseInt(item)-1)
      });   
    }
    
    if (opNav==="next" && lastVal!=totalRecords) {
      $( ".pageNum" ).each(function( index ) {
        var item = $(this).text();
        $(this).text(parseInt(item)+1)
      });   
    }

  }

  }
  
});