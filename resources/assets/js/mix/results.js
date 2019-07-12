require('./bootstrap');
import Vue from 'vue';
import $ from "jquery";
import bootstrap from "bootstrap";
import items from "../components/items.vue";
import { get } from '../helpers/api' // axios

// --------------------------
// экземляр приложения vue
// --------------------------
export default new Vue ({
  el: '#app',
  data () {   
    return {
      showItems: false,
      data: "123123",
      totalRecords: 0,
      countString: ""
    }
  },
  delimiters: ['${', '}'], // для разрешения конфликта c переменными php
  components: {    
    bootstrap,
    items
  },

  // -------------------------------
  // Компонент создан
  // -------------------------------
  created() {
    // Отобразить отложенные данные
    $(".deferred").show();
  },

  watch: {
    strNum: function(totalRecords) {
      this.countString = num2str(totalRecords, ["объявление", "объявления", "объявлений"]);
    }
  },
  // --------------------------------------
  // Методы
  // --------------------------------------
  methods: {
  // -----------------------------------------------
  // функция склонений слов / Перенести на бэкенд
  // -----------------------------------------------
  num2str(n, text_forms) {
    n = Math.abs(n) % 100;
    var n1 = n % 10;
    if (n > 10 && n < 20) return text_forms[2];   
    if (n1 > 1 && n1 < 5) return text_forms[1];
    if (n1 == 1) return text_forms[0];
    return text_forms[2];
  },

  // закрыть экран
  closeAndReturn() {
    window.history.back()
  },

  changePage(e, totalRecords) {
    e.preventDefault();    
  
    var firstVal = parseInt($( ".pageNum" ).first().text());
    var lastVal = parseInt($( ".pageNum" ).last().text());
    var btnData = e.target.attributes[1].nodeValue;
    
    if (btnData==="prev" && firstVal > 1) {
      $( ".pageNum" ).each(function( index ) {
        var item = $(this).text();
        $(this).text(parseInt(item)-1)
      });   
    }

    if (btnData==="next" && lastVal!=totalRecords) {
      $( ".pageNum" ).each(function( index ) {
        var item = $(this).text();
        $(this).text(parseInt(item)+1)
      });   
    }
    
    if (btnData!="next" && btnData!="prev") {          
      $("#defaultItems").empty();      
      this.showItems=true;      
    }
  }
}
  
});